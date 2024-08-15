<?php

namespace App\Http\Controllers\Frontend;
use App\Models\PeriodoComisione;
use App\Models\Reporte;
use App\Models\CajaIngreso;
use App\Models\Concepto;
use App\Models\TablaMaestra;
use Carbon\Carbon;
use Auth;
use Barryvdh\DomPDF\Facade\Pdf;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


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

	public function rep_pdf($id,$f_inicio,$f_fin,$opc1,$opc2)
	{

		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);
		ini_set('memory_limit', '1280M');
		ini_set('max_execution_time', '500');
		
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
				if ($funcion=='ccu')$titulo = "CONSOLIDADO ".$usuario_ingresos[0] ->usuario." - ".$caja_ingresos[0] ->denominacion ;
				if ($funcion=='cct')$titulo = "CONSOLIDADO DE TODAS LAS CAJAS ";

				$usuario=$usuario_ingresos[0] ->usuario;

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
		
		
				$pdf = Pdf::loadView('frontend.reporte.reporte_pdf',compact('titulo','venta','forma_pago','detalle_venta','f_inicio','f_inicio','comprobante_conteo','comprobante_lista','usuario'));
				$pdf->getDomPDF()->set_option("enable_php", true);
				
				//$pdf->setPaper('A4', 'landscape'); // Tamaño de papel (puedes cambiarlo según tus necesidades)
				$pdf->setOption('margin-top', 20); // Márgen superior en milímetros
				$pdf->setOption('margin-right', 50); // Márgen derecho en milímetros
				$pdf->setOption('margin-bottom', 20); // Márgen inferior en milímetros
				$pdf->setOption('margin-left', 100); // Márgen izquierdo en milímetros

			}

			if ($funcion=='mcu' || $funcion=='mct' ){
				if ($funcion=='mcu')$titulo = "REPORTE DE MOVIMIENTOS DE ".$usuario_ingresos[0] ->usuario." - ".$caja_ingresos[0] ->denominacion ;
				if ($funcion=='mct')$titulo = "REPORTE DE MOVIMIENTOS DE TODAS LAS CAJAS ";

				
				$usuario=$usuario_ingresos[0] ->usuario;

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

			$concepto = $opc2;
			$estado_pago = $opc1;


			if ($funcion=='rv' || $funcion=='mct' ){
				//if ($funcion=='mcu')$titulo = "REPORTE DE ventas ".$usuario_ingresos[0] ->usuario." - ".$caja_ingresos[0] ->denominacion ;
				$titulo = "REPORTE DE MOVIMIENTOS DE TODAS LAS CAJAS ";

				
				//$usuario=$usuario_ingresos[0] ->usuario;

				//print_r($venta);exit();
		
				$caja_ingreso_model = new CajaIngreso();
				//$tipo= '';			
				$reporte_ventas = $caja_ingreso_model->getAllReporteVentas($f_inicio, $f_fin, $concepto,$estado_pago);
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
		}
	
		return $pdf->stream('reporte.pdf');
	}

	function mesesALetras($mes) { 
		$meses = array('','enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'setiembre','octubre','noviembre','diciembre'); 
		return $meses[$mes];
	}
}
