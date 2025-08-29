<?php

namespace App\Http\Controllers\Frontend;
use App\Models\PeriodoComisione;
use App\Models\Reporte;
use App\Models\CajaIngreso;
use App\Models\Concepto;
use App\Models\TablaMaestra;
use App\Models\Valorizacione;
use App\Models\ReporteDeudaTotal;
use App\Models\ReporteDeudaTotalDetalle;
use App\Models\ReporteDeudaAnuale;
use Carbon\Carbon;
use Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromArray;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use DateTime;

class ReporteController extends Controller
{
    public function __construct(){

		$this->middleware(function ($request, $next) {
			if(!Auth::check()) {
                return redirect('login');
            }
			return $next($request);
    	});
	}

    public function index($tipo_reporte){
			//echo($tipo_reporte); exit();

		$periodoComisione_model = new PeriodoComisione;

		$id_user = Auth::user()->id;

		$anio = range(date('Y'), date('Y') - 20); 
		$mes = [
            '01' => 'Enero', '02' => 'Febrero', '03' => 'Marzo',
            '04' => 'Abril', '05' => 'Mayo', '06' => 'Junio',
            '07' => 'Julio', '08' => 'Agosto', '09' => 'Septiembre',
            '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre',
        ];
		
		$reporte_model = new Reporte;
		$reporte = $reporte_model->getReporteAll($tipo_reporte);

		$periodo = $periodoComisione_model->getPeriodoAll();
		$periodo_ultimo = PeriodoComisione::where("estado",1)->orderBy("id","desc")->first();
		$periodo_activo = PeriodoComisione::where("estado",1)->where("activo",1)->orderBy("id","desc")->first();

		
        $caja_ingreso_model = new CajaIngreso();
        $caja_usuario = $caja_ingreso_model->getCajaUsuario_u();

		$concepto_model = new Concepto();
		$concepto = $concepto_model->getConceptoAllDenominacion2();

		$tabla_model = new TablaMaestra;
        $formapago = $tabla_model->getMaestroByTipo('104');

	
		//$reporte = Reporte::where(['estado' => '1'])->get();

		//print_r($reporte);


		
        return view('frontend.reporte.all',compact('tipo_reporte','periodo','anio','mes','reporte','periodo_ultimo','periodo_activo','caja_usuario', 'concepto','formapago'));
    }
	public function obtener_caja_usuario($idUsuario){
		
		$caja_ingreso_model = new CajaIngreso();
        $caja = $caja_ingreso_model->getCajaUsuario_c($idUsuario);
		echo json_encode($caja);
	}

	public function lista_reporte_ajax(Request $request){
	
		$reporte_model = new Reporte(); 
		$p[]=$request->id_periodo;
		$p[]="";
		$p[]=$request->anio;
		$p[]=$request->mes;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $reporte_model->lista_reporte_ajax($p);
		$iTotalDisplayRecords = isset($data[0]->totalrows)?$data[0]->totalrows:0;

		$result["PageStart"] = $request->NumeroPagina;
		$result["pageSize"] = $request->NumeroRegistros;
		$result["SearchText"] = "";
		$result["ShowChildren"] = true;
		$result["iTotalRecords"] = $iTotalDisplayRecords;
		$result["iTotalDisplayRecords"] = $iTotalDisplayRecords;
		$result["aaData"] = $data;

        //print_r(json_encode($result)); exit();
		echo json_encode($result);

	
	}

	public function listar_reporte($tipo_documento,$id_persona){  
		$id_user = Auth::user()->id;     
        $reporte_model = new Reporte;
        $sw = true;
        $pago = $reporte_model->getReporteAll($id_user);
        return view('frontend.ingreso.lista_pago',compact('pago'));

    }

	public function listar_reporte_usuario(Request $request){
		$id_user = Auth::user()->id;     
        $reporte_model = new Reporte;
        $sw = true;
        $resultado = $reporte_model->getReporteAll($id_user);
      
		return $resultado;

    }

	public function rep_pdf($id,$f_inicio,$f_fin,$opc1,$opc2,$opc3)
	{

		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);
		ini_set('memory_limit', '-1');
		ini_set('max_execution_time', '1200');
		
		$reporte = Reporte::find($id);

		$id_tipo= $reporte->id_tipo;
		$funcion = $reporte->funcion;
		$por_usuario= $reporte->por_usuario;

		if ($id_tipo == '1'){

			$id_usuario = $opc1;
			$id_caja = $opc2;

	
			$titulo = "";

			$caja_ingreso_model = new CajaIngreso();
			$caja_ingresos= $caja_ingreso_model->getCajaById($id_caja);
			$usuario_ingresos= $caja_ingreso_model->getUsuarioById($id_usuario);


			if ($funcion=='ccu' || $funcion=='cct'){
				if ($funcion=='ccu') {
					$titulo = "CONSOLIDADO ".$usuario_ingresos[0] ->usuario." - ".$caja_ingresos[0] ->denominacion ;
					$usuario=$usuario_ingresos[0] ->usuario;
				}
				
				if ($funcion=='cct'){
					$titulo = "CONSOLIDADO DE TODAS LAS CAJAS ";
					$usuario=0;
				}

				$caja_ingreso_model = new CajaIngreso();
				//$tipo= '1';
				$venta = $caja_ingreso_model->getAllCajaComprobante($id_usuario, $id_caja, $f_inicio, $f_inicio ,$por_usuario);
				//print_r($venta);exit();
		
				$caja_ingreso_model = new CajaIngreso();
				//$tipo= '';
				$forma_pago = $caja_ingreso_model->getAllCajaCondicionPago($id_usuario, $id_caja, $f_inicio, $f_inicio, $por_usuario);
		
				$caja_ingreso_model = new CajaIngreso();
				//$tipo= '';
				$detalle_venta = $caja_ingreso_model->getAllCajaComprobanteDet($id_usuario, $id_caja, $f_inicio, $f_inicio, $por_usuario);

				$detalle_venta2 = $caja_ingreso_model->getAllCajaComprobanteDet2($id_usuario, $id_caja, $f_inicio, $f_inicio, $por_usuario);

				//$tipo= '';
				$comprobante_conteo=$caja_ingreso_model->getAllComprobanteConteo($id_usuario, $id_caja, $f_inicio, $f_inicio, $por_usuario);
				//$tipo= '';
				$comprobante_lista=$caja_ingreso_model->getAllComprobanteLista($id_usuario, $id_caja, $f_inicio, $f_inicio, $por_usuario);

				$comprobante_ncnd=$caja_ingreso_model->getAllComprobantencnd($id_usuario, $id_caja, $f_inicio, $f_inicio, $por_usuario);
				
				$comprobante_ncnd2=$caja_ingreso_model->getAllComprobantencnd2($id_usuario, $id_caja, $f_inicio, $f_inicio, $por_usuario);

				$ingresos_complementarios=$caja_ingreso_model->getAllIngressComp($id_usuario, $id_caja, $f_inicio, $f_inicio, $por_usuario);

				$nc_no_afecta=$caja_ingreso_model->getAllComprobantencnd_noafecta($id_usuario, $id_caja, $f_inicio, $f_inicio, $por_usuario);

				$por_cobrar=$caja_ingreso_model->getAllCajaComprobante_por_cobrar($id_usuario, $id_caja, $f_inicio, $f_inicio, $por_usuario);

				$por_serie=$caja_ingreso_model->getAllComprobantePorSerie($id_usuario, $id_caja, $f_inicio, $f_inicio, $por_usuario);
				
		
				$pdf = Pdf::loadView('frontend.reporte.reporte_pdf',compact('titulo','venta','forma_pago','detalle_venta','f_inicio','f_inicio','comprobante_conteo','comprobante_lista','usuario','comprobante_ncnd','ingresos_complementarios','nc_no_afecta','por_cobrar','por_serie','detalle_venta2','comprobante_ncnd2'));
				$pdf->getDomPDF()->set_option("enable_php", true);
				
				//$pdf->setPaper('A4', 'landscape'); // Tamaño de papel (puedes cambiarlo según tus necesidades)
				$pdf->setOption('margin-top', 20); // Márgen superior en milímetros
				$pdf->setOption('margin-right', 50); // Márgen derecho en milímetros
				$pdf->setOption('margin-bottom', 20); // Márgen inferior en milímetros
				$pdf->setOption('margin-left', 100); // Márgen izquierdo en milímetros

			}

			if ($funcion=='mcu' || $funcion=='mct' ){
				if ($funcion=='mcu') {
					$titulo = "REPORTE DE MOVIMIENTOS DE ".$usuario_ingresos[0] ->usuario." - ".$caja_ingresos[0] ->denominacion ;  
					$usuario=$usuario_ingresos[0] ->usuario;
			    }
				if ($funcion=='mct')$titulo = "REPORTE DE MOVIMIENTOS DE TODAS LAS CAJAS ";$usuario=0;

				//print_r($venta);exit();
		
				$caja_ingreso_model = new CajaIngreso();
				//$tipo= '';
				$forma_pago = $caja_ingreso_model->getAllCajaCondicionPago($id_usuario, $id_caja, $f_inicio, $f_inicio, $por_usuario);

				$caja_ingreso_model = new CajaIngreso();
				//$tipo= '';
				$movimiento_comprobante = $caja_ingreso_model->getAllMovimientoComprobantes($id_usuario, $id_caja, $f_inicio, $f_inicio ,$por_usuario);
				//print_r($venta);exit();
				$movimiento_comprobante_noafecta = $caja_ingreso_model->getAllMovimientoComprobantes_noafecta($id_usuario, $id_caja, $f_inicio, $f_inicio ,$por_usuario);
				
				$pdf = Pdf::loadView('frontend.reporte.reporte_mov_pdf',compact('titulo','movimiento_comprobante','forma_pago','f_inicio','f_inicio','movimiento_comprobante_noafecta'));
				$pdf->getDomPDF()->set_option("enable_php", true);
				
				$pdf->setPaper('A4', 'landscape'); // Tamaño de papel (puedes cambiarlo según tus necesidades)
				$pdf->setOption('margin-top', 20); // Márgen superior en milímetros
				$pdf->setOption('margin-right', 50); // Márgen derecho en milímetros
				$pdf->setOption('margin-bottom', 20); // Márgen inferior en milímetros
				$pdf->setOption('margin-left', 100); // Márgen izquierdo en milímetros

			}
		}

		if ($id_tipo == '2'){

			$concepto = $opc1;
			$forma_pago = $opc2;
			$estado_pago = $opc3;


			if ($funcion=='rv' || $funcion=='mct' ){
				//if ($funcion=='mcu')$titulo = "REPORTE DE ventas ".$usuario_ingresos[0] ->usuario." - ".$caja_ingresos[0] ->denominacion ;
				$titulo = "REPORTE REPORTES DE VENTAS POR CONCEPTOS  ";
				
				//$usuario=$usuario_ingresos[0] ->usuario;
				
				$caja_ingreso_model = new CajaIngreso();
				//$tipo= '';			
				$reporte_ventas = $caja_ingreso_model->getAllReporteVentas($f_inicio, $f_fin, $concepto,$forma_pago,$estado_pago);
				//print_r($reporte_ventas);exit();
				//var_dump($reporte_ventas);exit();
				//print_r($venta);exit();
		
				$pdf = Pdf::loadView('frontend.reporte.reporte_venta_pdf',compact('titulo','reporte_ventas','f_inicio','f_inicio'));
				$pdf->getDomPDF()->set_option("enable_php", true);
				
				$pdf->setPaper('A4', 'landscape'); // Tamaño de papel (puedes cambiarlo según tus necesidades)
				$pdf->setOption('margin-top', 20); // Márgen superior en milímetros
				$pdf->setOption('margin-right', 50); // Márgen derecho en milímetros
				$pdf->setOption('margin-bottom', 20); // Márgen inferior en milímetros
				$pdf->setOption('margin-left', 100); // Márgen izquierdo en milímetros

			}

			if ($funcion=='rvm' || $funcion=='mct' ){
				//if ($funcion=='mcu')$titulo = "REPORTE DE ventas ".$usuario_ingresos[0] ->usuario." - ".$caja_ingresos[0] ->denominacion ;
				$titulo = "REPORTE DE REGISTRO VENTAS MENSUAL";
				
				//$usuario=$usuario_ingresos[0] ->usuario;

				//print_r($venta);exit();
				
				$caja_ingreso_model = new CajaIngreso();
				//$tipo= '';			
				$reporte_ventas = $caja_ingreso_model->getAllReporteVentasMensual($f_inicio, $f_fin, $concepto,$forma_pago,$estado_pago);
				
				//var_dump($reporte_ventas);exit();
				//print_r($venta);exit();
		
				$pdf = Pdf::loadView('frontend.reporte.reporte_venta_mensual_pdf',compact('titulo','reporte_ventas','f_inicio','f_fin'));
				$pdf->getDomPDF()->set_option("enable_php", true);
				
				$pdf->setPaper('A4', 'landscape'); // Tamaño de papel (puedes cambiarlo según tus necesidades)
				$pdf->setOption('margin-top', 20); // Márgen superior en milímetros
				$pdf->setOption('margin-right', 50); // Márgen derecho en milímetros
				$pdf->setOption('margin-bottom', 20); // Márgen inferior en milímetros
				$pdf->setOption('margin-left', 100); // Márgen izquierdo en milímetros

			}
		}

		if ($id_tipo == '3'){

			$concepto = $opc1;
			//$estado_pago = $opc2;


			if ($funcion=='rt'){
				//if ($funcion=='mcu')$titulo = "REPORTE DE ventas ".$usuario_ingresos[0] ->usuario." - ".$caja_ingresos[0] ->denominacion ;
				$titulo = "REPORTE DE DEUDA TOTAL";

				
				//$usuario=$usuario_ingresos[0] ->usuario;

				//print_r($venta);exit();
		
				//$caja_ingreso_model = new CajaIngreso();
				//$tipo= '';			
				//$reporte_ventas = $caja_ingreso_model->getAllReporteVentas($f_inicio, $f_fin, $concepto,$estado_pago);
				//print_r($reporte_ventas);exit();
				//var_dump($reporte_ventas);exit();
				//print_r($venta);exit();

				$valorizacion_model = new Valorizacione;
				$valorizacion = $valorizacion_model->getDeudaReporte($f_fin);
		
				$pdf = Pdf::loadView('frontend.reporte.reporte_deuda_pdf',compact('titulo','valorizacion','f_fin'));
				$pdf->getDomPDF()->set_option("enable_php", true);
				
				//$pdf->setPaper('A4', 'landscape'); // Tamaño de papel (puedes cambiarlo según tus necesidades)
				$pdf->setOption('margin-top', 20); // Márgen superior en milímetros
				$pdf->setOption('margin-right', 50); // Márgen derecho en milímetros
				$pdf->setOption('margin-bottom', 20); // Márgen inferior en milímetros
				$pdf->setOption('margin-left', 100); // Márgen izquierdo en milímetros

			}

			if ($funcion=='rd'){
				//if ($funcion=='mcu')$titulo = "REPORTE DE ventas ".$usuario_ingresos[0] ->usuario." - ".$caja_ingresos[0] ->denominacion ;
				$titulo = "REPORTE DE DEUDA DETALLADO";
				
				//$usuario=$usuario_ingresos[0] ->usuario;

				//print_r($venta);exit();
		
				//$caja_ingreso_model = new CajaIngreso();
				//$tipo= '';			
				//$reporte_ventas = $caja_ingreso_model->getAllReporteVentasMensual($f_inicio, $f_fin, $concepto,$estado_pago);
				
				//var_dump($reporte_ventas);exit();
				//print_r($venta);exit();

				$valorizacion_model = new Valorizacione;
				$valorizacion = $valorizacion_model->getDeudaDetalladoReporte($f_fin);
		
				$pdf = Pdf::loadView('frontend.reporte.reporte_deuda_detallado_pdf',compact('titulo','valorizacion','f_fin'));
				$pdf->getDomPDF()->set_option("enable_php", true);
				
				//$pdf->setPaper('A4', 'landscape'); // Tamaño de papel (puedes cambiarlo según tus necesidades)
				$pdf->setOption('margin-top', 20); // Márgen superior en milímetros
				$pdf->setOption('margin-right', 50); // Márgen derecho en milímetros
				$pdf->setOption('margin-bottom', 20); // Márgen inferior en milímetros
				$pdf->setOption('margin-left', 100); // Márgen izquierdo en milímetros

			}
		}
	
		return $pdf->stream('reporte.pdf');
	}

	function mesesALetras($mes) { 
		$meses = array('','enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'setiembre','octubre','noviembre','diciembre'); 
		return $meses[$mes];
	}

	/*public function exportar_lista_deuda($fecha_fin) {
		
		if($fecha_fin==0)$fecha_fin = "";
	
		$valorizacion_model = new Valorizacione;
		$p[]=$fecha_fin;
        $p[]=1;
		$p[]=1;
		$p[]=50000;
		$data = $valorizacion_model->listar_deuda_detallado_caja_ajax($p);
	
		$variable = [];
		$n = 1;
		//array_push($variable, array("SISTEMA CAP"));
		//array_push($variable, array("CONSULTA DE CONCURSO","","","",""));
		array_push($variable, array("N","Numero CAP","Apellidos y Nombres","Monto","Concepto", "Periodo", "Fecha Vencimiento"));
		
		foreach ($data as $r) {
			//$nombres = $r->apellido_paterno." ".$r->apellido_materno." ".$r->nombres;
			array_push($variable, array($n++,$r->numero_cap, $r->apellidos_nombre, $r->monto, $r->descripcion,$r->periodo,$r->fecha_vencimiento));
		}
		
		
		$export = new InvoicesExport([$variable]);
		return Excel::download($export, 'lista_deuda_detallado.xlsx');
		
    }*/

	public function exportar_lista_deuda($id, $fecha_cierre, $fecha_consulta, $id_concepto) {
		
		$id_user = Auth::user()->id;

		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);
		ini_set('memory_limit', '-1');
		ini_set('max_execution_time', '300');

		if($fecha_cierre==0)$fecha_cierre = "";
		if($fecha_consulta==0)$fecha_consulta = "";
		if($id_concepto==0)$id_concepto = "";

		$reporte = Reporte::find($id);

		$id_tipo= $reporte->id_tipo;
		$funcion = $reporte->funcion;
		$por_usuario= $reporte->por_usuario;

		if($funcion=='rd'){

			$reporte_detalle = ReporteDeudaTotalDetalle::where('fecha_consulta', $fecha_consulta)->where('fecha_cierre', $fecha_cierre)->where('estado', 1)->orderBy('id', 'asc')->get();

			if ($reporte_detalle->isEmpty()) {
				$valorizacion_model = new Valorizacione;
				$resultado = $valorizacion_model->generarReporteDeudaDetalle($fecha_cierre, $fecha_consulta, $id_concepto);
				//dd($resultado);exit();
				$rows = [];
				foreach ($resultado as $row) {
					$rows[] = [
						'fecha_cierre'=> $fecha_cierre,
						'fecha_consulta'=> $fecha_consulta,
						'id_agremiado'=> $row->id_agremiado,
						'numero_cap'=> $row->numero_cap,
						'apellidos_nombre'=> $row->apellidos_nombre,
						'monto'=> $row->monto,
						'id_concepto'=> $row->id_concepto,
						'concepto'=> $row->descripcion,
						'periodo'=> $row->periodo,
						'fecha_vencimiento'=> $row->fecha_vencimiento,
						'estado'=> 1,
						'id_usuario_inserta'=> $id_user,
					];
				}

				foreach (array_chunk($rows, 1000) as $chunk) {
					ReporteDeudaTotalDetalle::insert($chunk);
				}

				$reporte_detalle = ReporteDeudaTotalDetalle::where('fecha_cierre', $fecha_cierre)->where('fecha_consulta', $fecha_consulta)->where('estado', 1)->orderBy('id', 'asc')->get();
			}
			
			return response()->stream(function() use ($reporte_detalle) {
				$handle = fopen('php://output', 'w');

				fputcsv($handle, [
					'N',
					'Numero_CAP',
					'Apellidos_Nombres',
					'Monto',
					'Concepto',
					'Periodo',
					'Fecha_Vencimiento'
				], ';');

				$n = 1;
				$total_monto = 0;

				foreach ($reporte_detalle as $r) {
					fputcsv($handle, [
						$n++,
						$r->numero_cap,
						$r->apellidos_nombre,
						(float)$r->monto,
						$r->concepto,
						$r->periodo,
						$r->fecha_vencimiento,
					], ';');

					$total_monto += (float) $r->monto;
				}

				fputcsv($handle, ['', '', 'TOTAL', $total_monto, '', '', ''], ';');

				fclose($handle);
			}, 200, [
				"Content-Type" => "text/csv; charset=UTF-8",
				"Content-Disposition" => 'attachment; filename="Lista_Deuda_Detallado.csv"',
			]);
			
		}else if($funcion=='rt'){
			
			$reportes = ReporteDeudaTotal::where('fecha_consulta', $fecha_consulta)->where('fecha_cierre', $fecha_cierre)->where('estado', 1)->get();

			if ($reportes->isEmpty()) {
				$valorizacion_model = new Valorizacione;
				$resultado = $valorizacion_model->generarReporteDeuda($fecha_cierre, $fecha_consulta, $id_concepto);
				//dd($resultado);exit();
				foreach ($resultado as $row) {
					ReporteDeudaTotal::create([
						'fecha_cierre'=> $fecha_cierre,
						'fecha_consulta'=> $fecha_consulta,
						'id_agremiado'=> $row->id_agremiado,
						'monto_total'=> $row->monto_total,
						'estado'=> 1,
						'id_usuario_inserta'=> $id_user,
					]);
				}

				$reportes = ReporteDeudaTotal::where('fecha_cierre', $fecha_cierre)->where('fecha_consulta', $fecha_consulta)->where('estado', 1)->get();
			}

			$n = 1;
			$total_monto = 0;
			$variable = [];

			array_push($variable, ["N°","Numero CAP","Apellidos y Nombres","Monto"]);

			foreach ($reportes as $r) {
				array_push($variable, [
					$n++,
					$r->agremiado->numero_cap,
					$r->agremiado->persona->apellido_paterno . ' ' .
					$r->agremiado->persona->apellido_materno . ' ' .
					$r->agremiado->persona->nombres,
					(float) $r->monto_total
				]);

				$total_monto += (float) $r->monto_total;
			}

			array_push($variable, ['', '', 'Total', $total_monto]);
			
			$export = new InvoicesExport([$variable], $fecha_cierre, $fecha_consulta);
			return Excel::download($export, 'lista_deuda.xlsx');
			
		}else if($funcion=='ra'){

			$titulo = "DEUDA INSTITUCIONAL";

			$reporte_anual = ReporteDeudaAnuale::where('fecha_consulta', $fecha_consulta)->where('fecha_cierre', $fecha_cierre)->where('estado', 1)->orderBy('id', 'asc')->get();
			
			if ($reporte_anual->isEmpty()) {
				$valorizacion_model = new Valorizacione;
				$resultado = $valorizacion_model->generarReporteDeudaAnual($fecha_cierre, $fecha_consulta, $id_concepto);
				$rows = [];
				$total_monto = 0;

				foreach ($resultado as $row) {
					$rows[] = [
						'fecha_cierre'=> $fecha_cierre,
						'fecha_consulta'=> $fecha_consulta,
						'id_agremiado'=> $row->id_agremiado,
						'numero_cap'=> $row->numero_cap,
						'apellidos_nombre'=> $row->apellidos_nombre,
						'monto'=> $row->monto_total,
						'estado'=> 1,
						'id_usuario_inserta'=> $id_user,
					];
					$total_monto += (float) $row->monto_total;
				}

				foreach (array_chunk($rows, 1000) as $chunk) {
					ReporteDeudaAnuale::insert($chunk);
				}

				$reporte_anual = ReporteDeudaAnuale::where('fecha_cierre', $fecha_cierre)->where('fecha_consulta', $fecha_consulta)->where('estado', 1)->orderBy('id', 'asc')->get();
			}

			$variable = [];
			$n = 1;
			$total_monto = 0;
			$variable[] = ['N°','Numero CAP','Apellidos y Nombres','Monto'];
			foreach ($reporte_anual as $r) {
				
				$variable[] = [
					$n++,
					$r->numero_cap,
					$r->apellidos_nombre,
					(float)$r->monto,
				];
				$total_monto += (float)$r->monto;
			}

			$variable[] = ['', '', 'TOTAL', $total_monto];
			
			$export = new InvoicesExport7([$variable], $titulo, $fecha_cierre);
			return Excel::download($export, 'lista_deuda_anual.xlsx');
			
		}else if($funcion=='rvm'){

			$valorizacion_model = new Valorizacione;
			$p[]=$fecha_cierre;
			$p[]=$fecha_consulta;
			$p[]=$id_concepto;
			$p[]=1;
			$p[]=1;
			$p[]=20000;
			$data = $valorizacion_model->listar_deuda_caja_ajax($p);
		
			$variable = [];
			$total_monto=0;
			$n = 0;
			//array_push($variable, array("SISTEMA CAP"));
			//array_push($variable, array("CONSULTA DE CONCURSO","","","",""));
			//array_push($variable, array("N","Numero CAP","Apellidos y Nombres","Monto Total"));
			
			foreach ($data as $r) {
				//$nombres = $r->apellido_paterno." ".$r->apellido_materno." ".$r->nombres;
				array_push($variable, array($n++,$r->numero_cap, $r->apellidos_nombre, number_format($r->monto_total, 2,'.','')));

				$total_monto+=$r->monto_total;
			}

			array_push($variable,array('','','Total',$total_monto));
			
			$export = new InvoicesExport([$variable], $fecha_cierre, $fecha_consulta);
			return Excel::download($export, 'lista_deuda.xlsx');
			
		}
		
    }

	public function exportar_reporte_caja($id, $f_inicio, $f_fin, $opc1, $opc2, $opc3)
	{

		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);
		ini_set('memory_limit', '-1');
		ini_set('max_execution_time', '300');
		
		$reporte = Reporte::find($id);

		$id_tipo= $reporte->id_tipo;
		$funcion = $reporte->funcion;
		$por_usuario= $reporte->por_usuario;

		if ($id_tipo == '1'){

			$id_usuario = $opc1;
			$id_caja = $opc2;

			$titulo = "";

			$caja_ingreso_model = new CajaIngreso();
			$caja_ingresos= $caja_ingreso_model->getCajaById($id_caja);
			$usuario_ingresos= $caja_ingreso_model->getUsuarioById($id_usuario);


			if ($funcion=='ccu' || $funcion=='cct'){
				if ($funcion=='ccu') {
					$titulo = "CONSOLIDADO ".$usuario_ingresos[0] ->usuario." - ".$caja_ingresos[0] ->denominacion ;
					$usuario=$usuario_ingresos[0] ->usuario;
				}
				
				if ($funcion=='cct'){
					$titulo = "CONSOLIDADO DE TODAS LAS CAJAS ";
					$usuario=0;
				}

				$caja_ingreso_model = new CajaIngreso();
				
				$venta = $caja_ingreso_model->getAllCajaComprobante($id_usuario, $id_caja, $f_inicio, $f_inicio ,$por_usuario);
		
				$caja_ingreso_model = new CajaIngreso();
				
				$forma_pago = $caja_ingreso_model->getAllCajaCondicionPago($id_usuario, $id_caja, $f_inicio, $f_inicio, $por_usuario);
		
				$caja_ingreso_model = new CajaIngreso();
				
				$detalle_venta = $caja_ingreso_model->getAllCajaComprobanteDet($id_usuario, $id_caja, $f_inicio, $f_inicio, $por_usuario);

				$detalle_venta2 = $caja_ingreso_model->getAllCajaComprobanteDet2($id_usuario, $id_caja, $f_inicio, $f_inicio, $por_usuario);

				$comprobante_conteo=$caja_ingreso_model->getAllComprobanteConteo($id_usuario, $id_caja, $f_inicio, $f_inicio, $por_usuario);
				
				$comprobante_lista=$caja_ingreso_model->getAllComprobanteLista($id_usuario, $id_caja, $f_inicio, $f_inicio, $por_usuario);

				$comprobante_ncnd=$caja_ingreso_model->getAllComprobantencnd($id_usuario, $id_caja, $f_inicio, $f_inicio, $por_usuario);

				$comprobante_ncnd2=$caja_ingreso_model->getAllComprobantencnd2($id_usuario, $id_caja, $f_inicio, $f_inicio, $por_usuario);

				$ingresos_complementarios=$caja_ingreso_model->getAllIngressComp($id_usuario, $id_caja, $f_inicio, $f_inicio, $por_usuario);

				$nc_no_afecta=$caja_ingreso_model->getAllComprobantencnd_noafecta($id_usuario, $id_caja, $f_inicio, $f_inicio, $por_usuario);

				$por_cobrar=$caja_ingreso_model->getAllCajaComprobante_por_cobrar($id_usuario, $id_caja, $f_inicio, $f_inicio, $por_usuario);
				
				$variable = [];
				$n = 1;
				
				//array_push($variable, array("Emision","TD","Serie","Numero","Fecha","Tipo","Serie","Numero","Codigo Tributario","Destinatario","Importe afecto","Importe Afecto","IGV","Total"));
				array_push($variable, array("","",""));
				//array_push($variable, array("VENTAS","REF US$","TOTAL S."));

				$total_monto = 0;

				foreach ($venta as $r) {

					array_push($variable, array($r->tipo, "0.00", number_format($r->total, 2,'.','')));

					$total_monto+=$r->total;
				}

				array_push($variable, array("","TOTAL",$total_monto));

				array_push($variable, array("FORMAS DE RECAUDACION","REF US$","TOTAL S."));
				$total_monto_forma_pago = 0;

				foreach ($forma_pago as $r) {

					array_push($variable, array($r->condicion, number_format($r->total_us,2), number_format($r->total_soles, 2,'.','')));

					$total_monto_forma_pago+=$r->total_soles;
					
				}

				array_push($variable, array("","TOTAL",$total_monto_forma_pago));

				array_push($variable, array("DESCRIPCION DE LOS INGRESOS","REF US$","TOTAL S."));
				$total_monto_d = 0;
				$total_igv_d = 0;
				$total_sub_total_d = 0;

				foreach ($detalle_venta2 as $r) {

					array_push($variable, array($r->denominacion, "0.00", number_format($r->pu, 2,'.','')));

					$total_monto_d+=$r->importe;
					$total_igv_d+=$r->igv_total;
					$total_sub_total_d+=$r->pu;
					
				}

				array_push($variable, array("","DESCRIPCION DE LOS INGRESOS",$total_sub_total_d));
				
				array_push($variable, array("","I.G.V 18%",$total_igv_d));
				
				array_push($variable, array("","MONTO TOTAL RECAUDADO",$total_monto_d));

				array_push($variable, array("NOTAS DE CREDITO Y OTROS"));

				array_push($variable, array("Tipo","Comprobante","Destinatario","REF US$","Total"));

				$total_monto_comprobante_ncnd = 0;
				$total_igv_d = 0;
                $total_sub_total_d = 0;

				foreach ($comprobante_ncnd2 as $r) {

					array_push($variable, array($r->tipo_documento, $r->numero, $r->destinatario, number_format($r->us, 2,'.',''), number_format($r->subtotal, 2,'.','')));

					$total_monto_comprobante_ncnd+=$r->total;
					$total_igv_d += $r->impuesto;
					$total_sub_total_d += $r->subtotal;
					
				}
			
				array_push($variable, array("","","","SUB TOTAL",$total_sub_total_d));

				array_push($variable, array("","","","IGV 18%",$total_igv_d));

				array_push($variable, array("","","","TOTAL",$total_monto_comprobante_ncnd));

				array_push($variable, array("POR COBRAR"));

				array_push($variable, array("Tipo","Comprobante","Destinatario","REF US$","Total"));

				$total_monto_por_cobrar = 0;

				foreach ($por_cobrar as $r) {

					array_push($variable, array($r->tipo_documento, $r->numero, $r->destinatario, number_format($r->us, 2,'.',''), number_format($r->total, 2,'.','')));

					$total_monto_por_cobrar+=$r->total;
					
				}
			
				array_push($variable, array("","TOTAL",$total_monto_por_cobrar));

				array_push($variable, array("Documentos Utilizados","Cantidad"));

				$total_monto_comprobante_conteo = 0;

				foreach ($comprobante_conteo as $r) {

					array_push($variable, array($r->tipo_documento, $r->cantidad));

					$total_monto_comprobante_conteo+=$r->cantidad;
					
				}
			
				array_push($variable, array("TOTAL",$total_monto_comprobante_conteo));

				array_push($variable, array("Tipo Documento","Numero"));

				$total_cuenta_comprobante_lista = 0;

				foreach ($comprobante_lista as $r) {
					$total_cuenta_comprobante_lista += 1;
					array_push($variable, array($r->tipo_documento, $r->numero));

				}
			
				array_push($variable, array("TOTAL",$total_cuenta_comprobante_lista));

				array_push($variable, array("INGRESOS COMPLEMENTARIOS DEL DIA"));

				array_push($variable, array("Fecha","Comprobante","REF US$","Total"));

				$total_monto_ingresos_complementarios = 0;

				foreach ($ingresos_complementarios as $r) {

					array_push($variable, array($r->fecha, $r->comprobante, number_format($r->usd, 2,'.',''), number_format($r->importe, 2,'.','')));

					$total_monto_ingresos_complementarios+=$r->importe;
					
				}
			
				array_push($variable, array("","TOTAL",$total_monto_ingresos_complementarios));

				array_push($variable, array("NOTAS DE CREDITO QUE NO AFECTA"));

				array_push($variable, array("Tipo","Comprobante","Destinatario","REF US$","Total"));

				$total_monto_nc_no_afecta = 0;

				foreach ($nc_no_afecta as $r) {

					array_push($variable, array($r->tipo_documento, $r->numero, $r->destinatario, number_format($r->us, 2,'.',''), number_format($r->total, 2,'.','')));

					$total_monto_nc_no_afecta+=$r->total;
					
				}
			
				array_push($variable, array("","TOTAL",$total_monto_nc_no_afecta));

				$export = new InvoicesExport3([$variable], $titulo);
				return Excel::download($export, 'consolidado_caja.xlsx');

			}

			if ($funcion=='mcu' || $funcion=='mct' ){
				if ($funcion=='mcu') {
					$titulo = "REPORTE DE MOVIMIENTOS DE ".$usuario_ingresos[0] ->usuario." - ".$caja_ingresos[0] ->denominacion ;  
					$usuario=$usuario_ingresos[0] ->usuario;
			    }
				if ($funcion=='mct')$titulo = "REPORTE DE MOVIMIENTOS DE TODAS LAS CAJAS ";$usuario=0;
		
				$caja_ingreso_model = new CajaIngreso();
				
				$forma_pago = $caja_ingreso_model->getAllCajaCondicionPago($id_usuario, $id_caja, $f_inicio, $f_inicio, $por_usuario);

				$caja_ingreso_model = new CajaIngreso();
				
				$movimiento_comprobante = $caja_ingreso_model->getAllMovimientoComprobantes($id_usuario, $id_caja, $f_inicio, $f_inicio ,$por_usuario);

				$variable = [];
				$n = 1;
				
				array_push($variable, array("","",""));
				//array_push($variable, array("Emision","TD","Serie","Numero","Fecha","Tipo","Serie","Numero","Codigo Tributario","Destinatario","Importe afecto","Importe Afecto","IGV","Total"));
				
				$total_cuenta = 0;
				 
				$suma_afecto=0;
				$suma_inafecto=0;
				$suma_igv=0;
				$suma_total=0;

				$suma_afecto_parcial=0;
				$suma_inafecto_parcial=0;
				$suma_igv_parcial=0;
				$suma_total_parcial=0;

				foreach ($movimiento_comprobante as $r) {
					$total_cuenta += 1;

					if ($total_cuenta==1) {

						array_push($variable, array($r->concepto));

						$concepto_tmp=$r->concepto;
                 	} else {
						if ($concepto_tmp!=$r->concepto) {

						array_push($variable, array("","","","","","","","","","Total",number_format($suma_afecto_parcial, 2,'.',''), number_format($suma_inafecto_parcial, 2,'.',''), number_format($suma_igv_parcial, 2,'.',''), number_format($suma_total_parcial, 2,'.','')));

						array_push($variable, array($r->concepto));
						
						$suma_afecto_parcial =0;
						$suma_inafecto_parcial = 0;
						$suma_igv_parcial =0;
						$suma_total_parcial =0;

						$concepto_tmp=$r->concepto;
						}
					}

					array_push($variable, array($r->fecha, $r->tipo_documento, $r->serie, $r->numero, $r->fecha_ncd, $r->tipo_documento_ncd, $r->serie_ncd, $r->numero_ncd, $r->cod_tributario, $r->destinatario, number_format($r->imp_afecto, 2, '.', ','), number_format($r->imp_inafecto, 2, '.', ','), number_format($r->igv, 2, '.', ','), number_format($r->total, 2, '.', ',')));

					$suma_afecto += $r->imp_afecto;
					$suma_inafecto += $r->imp_inafecto;
					$suma_igv += $r->igv;
					$suma_total += $r->total;

					$suma_afecto_parcial += $r->imp_afecto;
					$suma_inafecto_parcial += $r->imp_inafecto;
					$suma_igv_parcial += $r->igv;
					$suma_total_parcial += $r->total;

					if ($total_cuenta==count($movimiento_comprobante)) {

						array_push($variable, array("","","","","","","","","","Total",number_format($suma_afecto_parcial, 2,'.',''), number_format($suma_inafecto_parcial, 2,'.',''), number_format($suma_igv_parcial, 2,'.',''), number_format($suma_total_parcial, 2,'.','')));

					}
				}

				array_push($variable, array("","","","","","","","","","Total General",number_format($suma_afecto, 2,'.',''), number_format($suma_inafecto, 2,'.',''), number_format($suma_igv, 2,'.',''), number_format($suma_total, 2,'.','')));

				$export = new InvoicesExport4([$variable], $titulo);
				return Excel::download($export, 'movimiento_caja.xlsx');

			}
		}

		if ($id_tipo == '2'){

			$concepto = $opc1;
			$forma_pago = $opc2;
			$estado_pago = $opc3;


			if ($funcion=='rv' || $funcion=='mct' ){
				$titulo = "REPORTE DE VENTAS POR CONCEPTOS";
				
				$caja_ingreso_model = new CajaIngreso();

				$reporte_ventas = $caja_ingreso_model->getAllReporteVentas($f_inicio, $f_fin, $concepto,$forma_pago,$estado_pago);
				
				/*$pdf = Pdf::loadView('frontend.reporte.reporte_venta_pdf',compact('titulo','reporte_ventas','f_inicio','f_inicio'));
				$pdf->getDomPDF()->set_option("enable_php", true);
				
				$pdf->setPaper('A4', 'landscape'); // Tamaño de papel (puedes cambiarlo según tus necesidades)
				$pdf->setOption('margin-top', 20); // Márgen superior en milímetros
				$pdf->setOption('margin-right', 50); // Márgen derecho en milímetros
				$pdf->setOption('margin-bottom', 20); // Márgen inferior en milímetros
				$pdf->setOption('margin-left', 100); // Márgen izquierdo en milímetros
				*/
				$variable = [];
				$n = 1;
				$total_cuenta = 0;
				$suma_total=0;
				$suma_total_parcial=0;
				
				array_push($variable, array("Emision","TD","Serie","Numero","Codigo Tributario","Destinatario","Cantidad","Descripcion","Total"));

				foreach($reporte_ventas as $r) {
					$total_cuenta += 1;
					
					if ($total_cuenta==1) {
						
						array_push($variable, array($r->concepto,"", "", "", "", "", "", "",""));
						$concepto_tmp=$r->concepto;
					}else{
						if ($concepto_tmp!=$r->concepto) {
							array_push($variable, array("", "", "", "", "", "", "","Total",(float)$suma_total_parcial));
							
							array_push($variable, array($r->concepto,"", "", "", "", "", "", "",""));
							$suma_total_parcial =0;
							$concepto_tmp=$r->concepto;
						}
					}
					
					array_push($variable, array($r->fecha, $r->tipo, $r->serie, $r->numero, $r->cod_tributario, $r->destinatario, $r->cantidad, $r->descripcion, (float)$r->importe));

					$suma_total+=$r->importe;
					$suma_total_parcial += $r->importe;

					if ($total_cuenta==count($reporte_ventas)) {
						
						array_push($variable, array("", "", "", "", "", "", "","Total", (float)$suma_total_parcial));
						
					}
				}

				array_push($variable, array("", "", "", "", "", "", "","Total General", (float)$suma_total));
				
				$export = new InvoicesExport5([$variable], $titulo, $f_inicio);
				return Excel::download($export, 'reporte_ventas_concepto.xlsx');
			}
			
			if ($funcion=='rvm' || $funcion=='mct' ){
				$titulo = "REPORTE DE REGISTRO VENTAS MENSUAL";

				$caja_ingreso_model = new CajaIngreso();
				//$tipo= '';			
				$reporte_ventas = $caja_ingreso_model->getAllReporteVentasMensual($f_inicio, $f_fin, $concepto,$forma_pago,$estado_pago);
				
				/*$pdf = Pdf::loadView('frontend.reporte.reporte_venta_mensual_pdf',compact('titulo','reporte_ventas','f_inicio','f_fin'));
				$pdf->getDomPDF()->set_option("enable_php", true);
				
				$pdf->setPaper('A4', 'landscape'); // Tamaño de papel (puedes cambiarlo según tus necesidades)
				$pdf->setOption('margin-top', 20); // Márgen superior en milímetros
				$pdf->setOption('margin-right', 50); // Márgen derecho en milímetros
				$pdf->setOption('margin-bottom', 20); // Márgen inferior en milímetros
				$pdf->setOption('margin-left', 100); // Márgen izquierdo en milímetros*/

				$variable = [];
				$n = 1;
				$total_cuenta = 0;
				$suma_total_boleta=0;
				$suma_total_factura=0;
				$suma_total_nota_credito=0;
				$suma_imponible_afecto_boleta=0;
				$suma_imponible_afecto_factura=0;
				$suma_imponible_afecto_nota_credito=0;
				$suma_imponible_inafecto_boleta=0;
				$suma_imponible_inafecto_factura=0;
				$suma_imponible_inafecto_nota_credito=0;
				$suma_igv_total_boleta=0;
				$suma_igv_total_factura=0;
				$suma_igv_total_nota_credito=0;
				$suma_imponible_afecto=0;
				$suma_imponible_inafecto=0;
				$suma_igv_total=0;
				$suma_total=0;
				$suma_total_parcial=0;
				
				array_push($variable, array("Emision","TD","Serie","Numero","Codigo Tributario","Destinatario","Imponible Afecto","Imponible Inafecto","IGV","Total","Condicion Pago","Estado Pago"));

				array_push($variable, array("Boletas","","","","","","","","","","",""));
				foreach($reporte_ventas as $r) {
					$total_cuenta += 1;
					if($r->tipo=="BV"){
					
						array_push($variable, array($r->fecha, $r->tipo, $r->serie, $r->numero, $r->cod_tributario, $r->destinatario, (float)$r->imp_afecto, (float)$r->imp_inafecto, (float)$r->impuesto, (float)$r->total, $r->forma_pago, $r->estado_pago));
					
						$suma_imponible_afecto_boleta += $r->imp_afecto;
						$suma_imponible_inafecto_boleta += $r->imp_inafecto;
						$suma_igv_total_boleta += $r->impuesto;
						$suma_total_boleta += $r->total;
						$suma_imponible_afecto += $r->imp_afecto;
						$suma_imponible_inafecto += $r->imp_inafecto;
						$suma_igv_total += $r->impuesto;
						$suma_total+=$r->total;
					}
				}

				array_push($variable, array("","","","","","Total Boletas",$suma_imponible_afecto_boleta,$suma_imponible_inafecto_boleta,$suma_igv_total_boleta,$suma_total_boleta,"",""));
				array_push($variable, array("Facturas","","","","","","","","","","",""));
				foreach($reporte_ventas as $r) {
					$total_cuenta += 1;
					if($r->tipo=="FT"){
					
						array_push($variable, array($r->fecha, $r->tipo, $r->serie, $r->numero, $r->cod_tributario, $r->destinatario, (float)$r->imp_afecto, (float)$r->imp_inafecto, (float)$r->impuesto, (float)$r->total, $r->forma_pago, $r->estado_pago));
					
						$suma_imponible_afecto_factura += $r->imp_afecto;
						$suma_imponible_inafecto_factura += $r->imp_inafecto;
						$suma_igv_total_factura += $r->impuesto;
						$suma_total_factura += $r->total;
						$suma_imponible_afecto += $r->imp_afecto;
						$suma_imponible_inafecto += $r->imp_inafecto;
						$suma_igv_total += $r->impuesto;
						$suma_total+=$r->total;
					}
				}

				array_push($variable, array("","","","","","Total Boletas",$suma_imponible_afecto_factura,$suma_imponible_inafecto_factura,$suma_igv_total_factura,$suma_total_factura,"",""));
				array_push($variable, array("Notas de Credito","","","","","","","","","","",""));
				foreach($reporte_ventas as $r) {
					$total_cuenta += 1;
					if($r->tipo=="NC"){
					
						array_push($variable, array($r->fecha, $r->tipo, $r->serie, $r->numero, $r->cod_tributario, $r->destinatario, (float)$r->imp_afecto, (float)$r->imp_inafecto, -1*(float)$r->impuesto, -1*(float)$r->total, $r->forma_pago, $r->estado_pago));
					
						$suma_imponible_afecto_nota_credito += $r->imp_afecto;
						$suma_imponible_inafecto_nota_credito += $r->imp_inafecto;
						$suma_igv_total_nota_credito += -1*$r->impuesto;
						$suma_total_nota_credito += -1*$r->total;
						$suma_imponible_afecto += $r->imp_afecto;
						$suma_imponible_inafecto += $r->imp_inafecto;
						$suma_igv_total -= $r->impuesto;
						$suma_total -=$r->total;
					}
				}

				array_push($variable, array("","","","","","Total Boletas",$suma_imponible_afecto_nota_credito,$suma_imponible_inafecto_nota_credito,$suma_igv_total_nota_credito,$suma_total_nota_credito,"",""));

				array_push($variable, array("", "", "", "", "", "Total General", $suma_imponible_afecto, $suma_imponible_inafecto, $suma_igv_total,(float)$suma_total, "", ""));
				
				$export = new InvoicesExport6([$variable], $titulo, $f_inicio);
				return Excel::download($export, 'reporte_ventas.xlsx');

			}
		}

		if ($id_tipo == '3'){

			$concepto = $opc1;
			//$estado_pago = $opc2;


			if ($funcion=='rt'){
				$titulo = "REPORTE DE DEUDA TOTAL";

				$valorizacion_model = new Valorizacione;
				$valorizacion = $valorizacion_model->getDeudaReporte($f_fin);
		
				$pdf = Pdf::loadView('frontend.reporte.reporte_deuda_pdf',compact('titulo','valorizacion','f_fin'));
				$pdf->getDomPDF()->set_option("enable_php", true);
				
				//$pdf->setPaper('A4', 'landscape'); // Tamaño de papel (puedes cambiarlo según tus necesidades)
				$pdf->setOption('margin-top', 20); // Márgen superior en milímetros
				$pdf->setOption('margin-right', 50); // Márgen derecho en milímetros
				$pdf->setOption('margin-bottom', 20); // Márgen inferior en milímetros
				$pdf->setOption('margin-left', 100); // Márgen izquierdo en milímetros

			}

			if ($funcion=='rd'){
				$titulo = "REPORTE DE DEUDA DETALLADO";

				$valorizacion_model = new Valorizacione;
				$valorizacion = $valorizacion_model->getDeudaDetalladoReporte($f_fin);
		
				$pdf = Pdf::loadView('frontend.reporte.reporte_deuda_detallado_pdf',compact('titulo','valorizacion','f_fin'));
				$pdf->getDomPDF()->set_option("enable_php", true);
				
				$pdf->setOption('margin-top', 20); // Márgen superior en milímetros
				$pdf->setOption('margin-right', 50); // Márgen derecho en milímetros
				$pdf->setOption('margin-bottom', 20); // Márgen inferior en milímetros
				$pdf->setOption('margin-left', 100); // Márgen izquierdo en milímetros

			}
		}
	
		return $pdf->stream('reporte.pdf');
	}

	public function validar_reporte_deuda($fecha_cierre, $fecha_consulta){
 
        $reporte_deuda_total_model = new ReporteDeudaTotal;
        $reporte_deuda_total = $reporte_deuda_total_model->getReporteDeudaTotalByFechaCierreConsulta($fecha_cierre, $fecha_consulta);
        //dd($liquidacion);exit();

        return response()->json(['reporte_deuda_total' => $reporte_deuda_total]);

    }
}

class InvoicesExport implements FromArray, WithHeadings, WithStyles
{
	protected $invoices;
	protected $fechaFin;
	protected $fechaConsulta;

	public function __construct(array $invoices, $fechaFin, $fechaConsulta)
	{
		$this->invoices = $invoices;
		$this->fechaFin = $fechaFin;
		$this->fechaConsulta = $fechaConsulta;
	}

	public function array(): array
	{
		return $this->invoices;
	}

	public function headings(): array
    {
        return ["N", "Numero CAP", "Apellidos y Nombres", "Monto Total"];
    }

	public function styles(Worksheet $sheet)
    {

		$sheet->mergeCells('A1:D1');
        
		$fecha_actual = date('d-m-Y');

        $sheet->setCellValue('A1', "LISTA DE LA DEUDA ACTUAL DE CUOTA INSTITUCIONAL DE \n ARQUITECTOS AL {$this->fechaConsulta} (Fecha de cierre: {$this->fechaFin})");
        $sheet->getStyle('A1:D1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => '000000'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'A6C9EC'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
        ]);

		$sheet->getStyle('A1')->getAlignment()->setWrapText(true);
		$sheet->getRowDimension(1)->setRowHeight(30);

        $sheet->getStyle('A2:D2')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => '000000'],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'C1F0C8'],
            ],
			'alignment' => [
			'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
    		],
        ]);

		$sheet->fromArray($this->headings(), NULL, 'A2');

		$sheet->getStyle('D3:D'.$sheet->getHighestRow())
		->getNumberFormat()
		->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_00);
        
        foreach (range('A', 'D') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
    }

}

class InvoicesExport2 implements FromArray, WithHeadings, WithStyles
{
	protected $invoices;
	protected $fechaFin;

	public function __construct(array $invoices, $fechaFin)
	{
		$this->invoices = $invoices;
		$this->fechaFin = $fechaFin;
	}

	public function array(): array
	{
		return $this->invoices;
	}

	public function headings(): array
    {
        return ["N", "Numero CAP", "Apellidos y Nombres", "Monto Total"];
    }

	public function styles(Worksheet $sheet)
    {

		$sheet->mergeCells('A1:D1');
        
		$fecha_actual = date('d-m-Y');

        $sheet->setCellValue('A1', "LISTA DE LA DEUDA ACTUAL DE CUOTA INSTITUCIONAL DE \n ARQUITECTOS AL $fecha_actual (Fecha de cierre: {$this->fechaFin})");
        $sheet->getStyle('A1:D1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => '000000'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'A6C9EC'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
        ]);

		$sheet->getStyle('A1')->getAlignment()->setWrapText(true);
		$sheet->getRowDimension(1)->setRowHeight(30);

        $sheet->getStyle('A2:D2')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => '000000'],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'C1F0C8'],
            ],
			'alignment' => [
			'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
    		],
        ]);

		$sheet->fromArray($this->headings(), NULL, 'A2');

		$sheet->getStyle('D3:D'.$sheet->getHighestRow())
		->getNumberFormat()
		->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_00);
        
        foreach (range('A', 'D') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
    }

}

class InvoicesExport3 implements FromArray, WithHeadings, WithStyles
{
	protected $invoices;
	protected $titulo;

	public function __construct(array $invoices, $titulo)
	{
		$this->invoices = $invoices;
		$this->titulo = $titulo;
	}

	public function array(): array
	{
		return $this->invoices;
	}

	public function headings(): array
    {
        return ["VENTAS", "REF US$", "Total S."];
    }

	public function styles(Worksheet $sheet)
    {

		$sheet->mergeCells('A1:E1');
        
		//$fecha_actual = date('d-m-Y');

        $sheet->setCellValue('A1', "CONSOLIDADO {$this->titulo}");
        $sheet->getStyle('A1:E1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => '000000'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'A6C9EC'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
        ]);

		$sheet->getStyle('A1')->getAlignment()->setWrapText(true);
		$sheet->getRowDimension(1)->setRowHeight(30);

        $sheet->getStyle('A2:E2')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => '000000'],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'C1F0C8'],
            ],
			'alignment' => [
			'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
    		],
        ]);

		$sheet->fromArray($this->headings(), NULL, 'A2');

		/*$sheet->getStyle('E3:E'.$sheet->getHighestRow())
		->getNumberFormat()
		->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_00);*/
        
        foreach (range('A', 'E') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
    }

}

class InvoicesExport4 implements FromArray, WithHeadings, WithStyles
{
	protected $invoices;
	protected $titulo;

	public function __construct(array $invoices, $titulo)
	{
		$this->invoices = $invoices;
		$this->titulo = $titulo;
	}

	public function array(): array
	{
		return $this->invoices;
	}

	public function headings(): array
    {
        return ["Emision","TD","Serie","Numero","Fecha","Tipo","Serie","Numero","Codigo Tributario","Destinatario","Importe afecto","Importe Afecto","IGV","Total"];
    }

	public function styles(Worksheet $sheet)
    {

		$sheet->mergeCells('A1:N1');
        
		//$fecha_actual = date('d-m-Y');

        $sheet->setCellValue('A1', "CONSOLIDADO {$this->titulo}");
        $sheet->getStyle('A1:N1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => '000000'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'A6C9EC'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
        ]);

		$sheet->getStyle('A1')->getAlignment()->setWrapText(true);
		$sheet->getRowDimension(1)->setRowHeight(30);

        $sheet->getStyle('A2:N2')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => '000000'],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'C1F0C8'],
            ],
			'alignment' => [
			'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
    		],
        ]);

		$sheet->fromArray($this->headings(), NULL, 'A2');

		$sheet->getStyle('N3:N'.$sheet->getHighestRow())
		->getNumberFormat()
		->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_00);
        
        foreach (range('A', 'N') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
    }

}

class InvoicesExport5 implements FromArray, WithHeadings, WithStyles
{
	protected $invoices;
	protected $titulo;
	protected $f_inicio;

	public function __construct(array $invoices, $titulo, $f_inicio)
	{
		$this->invoices = $invoices;
		$this->titulo = $titulo;
		$this->f_inicio = $f_inicio;
	}

	public function array(): array
	{
		return $this->invoices;
	}

	public function headings(): array
    {
        return ["Emision","TD","Serie","Numero","Codigo Tributario","Destinatario","Cantidad","Descripcion","Total"];
    }

	public function styles(Worksheet $sheet)
    {

		$sheet->mergeCells('A1:I1');
        
		//$fecha_actual = date('d-m-Y');

        $sheet->setCellValue('A1', "{$this->titulo} - DÍA {$this->f_inicio}");
        $sheet->getStyle('A1:I1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => '000000'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'A6C9EC'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
        ]);

		$sheet->getStyle('A1')->getAlignment()->setWrapText(true);
		$sheet->getRowDimension(1)->setRowHeight(30);

        $sheet->getStyle('A2:I2')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => '000000'],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'C1F0C8'],
            ],
			'alignment' => [
			'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
    		],
        ]);

		$sheet->fromArray($this->headings(), NULL, 'A2');

		$sheet->getStyle('I3:I'.$sheet->getHighestRow())
		->getNumberFormat()
		->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_00);
        
        foreach (range('A', 'I') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
    }

}

class InvoicesExport6 implements FromArray, WithHeadings, WithStyles
{
	protected $invoices;
	protected $titulo;
	protected $f_inicio;

	public function __construct(array $invoices, $titulo, $f_inicio)
	{
		$this->invoices = $invoices;
		$this->titulo = $titulo;
		$this->f_inicio = $f_inicio;
	}

	public function array(): array
	{
		return $this->invoices;
	}

	public function headings(): array
    {
        return ["Emision","TD","Serie","Numero","Codigo Tributario","Destinatario","Imponible Afecto","Imponible Inafecto","IGV","Total","Condicion Pago","Estado Pago"];
    }

	public function styles(Worksheet $sheet)
    {

		$sheet->mergeCells('A1:L1');
        
		//$fecha_actual = date('d-m-Y');

        $sheet->setCellValue('A1', "{$this->titulo} - DÍA {$this->f_inicio}");
        $sheet->getStyle('A1:L1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => '000000'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'A6C9EC'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
        ]);

		$sheet->getStyle('A1')->getAlignment()->setWrapText(true);
		$sheet->getRowDimension(1)->setRowHeight(30);

        $sheet->getStyle('A2:L2')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => '000000'],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'C1F0C8'],
            ],
			'alignment' => [
			'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
    		],
        ]);

		$sheet->fromArray($this->headings(), NULL, 'A2');

		$sheet->getStyle('G3:J'.$sheet->getHighestRow())
		->getNumberFormat()
		->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_00);
        
        foreach (range('A', 'L') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
    }

}

class InvoicesExport7 implements FromArray, WithHeadings, WithStyles
{
	protected $invoices;
	protected $titulo;
	protected $fecha_cierre;
	

	public function __construct(array $invoices, $titulo, $fecha_cierre)
	{
		$this->invoices = $invoices;
		$this->titulo = $titulo;
		$this->fecha_cierre = $fecha_cierre;
	}

	public function getAnioCierre()
    {
        $fecha = new DateTime($this->fecha_cierre);
        return $fecha->format('Y');
    }

	public function array(): array
	{
		return array_merge([[]], $this->invoices);
	}

	public function headings(): array
    {
        return ["#","Numero CAP", "Apellidos y Nombres", "Monto"];
    }

	public function styles(Worksheet $sheet)
    {

		$sheet->mergeCells('A1:D1');
        
		//$fecha_actual = date('d-m-Y');

        $sheet->setCellValue('A1', "{$this->titulo} - {$this->getAnioCierre()}");
        $sheet->getStyle('A1:D1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => '000000'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'A6C9EC'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
        ]);

		$sheet->getStyle('A1')->getAlignment()->setWrapText(true);
		$sheet->getRowDimension(1)->setRowHeight(30);

        $sheet->getStyle('A2:D2')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => '000000'],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'C1F0C8'],
            ],
			'alignment' => [
			'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
    		],
        ]);

		//$sheet->fromArray($this->headings(), NULL, 'A2');

		$sheet->getStyle('D3:D'.$sheet->getHighestRow())
		->getNumberFormat()
		->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_00);
        
        foreach (range('A', 'D') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
    }

}
