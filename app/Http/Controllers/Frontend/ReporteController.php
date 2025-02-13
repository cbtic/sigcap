<?php

namespace App\Http\Controllers\Frontend;
use App\Models\PeriodoComisione;
use App\Models\Reporte;
use App\Models\CajaIngreso;
use App\Models\Concepto;
use App\Models\TablaMaestra;
use App\Models\Valorizacione;
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

				//$tipo= '';
				$comprobante_conteo=$caja_ingreso_model->getAllComprobanteConteo($id_usuario, $id_caja, $f_inicio, $f_inicio, $por_usuario);
				//$tipo= '';
				$comprobante_lista=$caja_ingreso_model->getAllComprobanteLista($id_usuario, $id_caja, $f_inicio, $f_inicio, $por_usuario);

				$comprobante_ncnd=$caja_ingreso_model->getAllComprobantencnd($id_usuario, $id_caja, $f_inicio, $f_inicio, $por_usuario);

				$ingresos_complementarios=$caja_ingreso_model->getAllIngressComp($id_usuario, $id_caja, $f_inicio, $f_inicio, $por_usuario);

				$nc_no_afecta=$caja_ingreso_model->getAllComprobantencnd_noafecta($id_usuario, $id_caja, $f_inicio, $f_inicio, $por_usuario);
				
		
				$pdf = Pdf::loadView('frontend.reporte.reporte_pdf',compact('titulo','venta','forma_pago','detalle_venta','f_inicio','f_inicio','comprobante_conteo','comprobante_lista','usuario','comprobante_ncnd','ingresos_complementarios','nc_no_afecta'));
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
		
		
		
				$pdf = Pdf::loadView('frontend.reporte.reporte_mov_pdf',compact('titulo','movimiento_comprobante','forma_pago','f_inicio','f_inicio'));
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

	public function exportar_lista_deuda($id, $fecha_fin, $id_concepto) {
		
		if($fecha_fin==0)$fecha_fin = "";
		if($id_concepto==0)$id_concepto = "";

		$reporte = Reporte::find($id);

		$id_tipo= $reporte->id_tipo;
		$funcion = $reporte->funcion;
		$por_usuario= $reporte->por_usuario;

		if($funcion=='rd'){

			$valorizacion_model = new Valorizacione;
			$p[]=$fecha_fin;
			$p[]=$id_concepto;
			$p[]=1;
			$p[]=1;
			$p[]=200000;
			$data = $valorizacion_model->listar_deuda_detallado_caja_ajax($p);
		
			$output='';
			$output.="N,Numero_CAP,Apellidos_Nombres,Monto,Concepto,Periodo,Fecha_Vencimiento\n";
			$n = 1;

			foreach($data as $r){

				$output.= $n++.",".$r->numero_cap.",".$r->apellidos_nombre.",". $r->monto.",".$r->descripcion.",".$r->periodo.",".$r->fecha_vencimiento."\n";

			}
			
			return Response::make($output,200,[
				'Content-Type' => 'text/plain',
				'Content-Disposition' =>'attachment; filename="lista_deuda_detallado.txt"',
			]);
			
		}else if($funcion=='rt'){

			$valorizacion_model = new Valorizacione;
			$p[]=$fecha_fin;
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
			
			$export = new InvoicesExport([$variable], $fecha_fin);
			return Excel::download($export, 'lista_deuda.xlsx');
			
		}
		/*$export = new InvoicesExport([$variable]);
		return Excel::download($export, 'lista_deuda_detallado.xlsx');*/
		
    }
}

class InvoicesExport implements FromArray, WithHeadings, WithStyles
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
