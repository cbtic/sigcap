<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PlanillaDelegado;
use App\Models\PlanillaDelegadoDetalle;
use App\Models\DelegadoReintegro;
use App\Models\PeriodoComisione;
use App\Models\ComisionDelegado;
use App\Models\Regione;
use App\Models\ComisionSesionDelegado;
use App\Models\TablaMaestra;
use App\Models\Agremiado;
use Auth;

class PlanillaDelegadoController extends Controller
{
	
	public function consulta_planilla_delegado(){
		
		$periodoComisione_model = new PeriodoComisione;
		
		$anio = range(date('Y'), date('Y') - 20); 
		$mes = [
            '01' => 'Enero', '02' => 'Febrero', '03' => 'Marzo',
            '04' => 'Abril', '05' => 'Mayo', '06' => 'Junio',
            '07' => 'Julio', '08' => 'Agosto', '09' => 'Septiembre',
            '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre',
        ];
		
		$periodo = $periodoComisione_model->getPeriodoAll();
		$periodo_ultimo = PeriodoComisione::where("estado",1)->orderBy("id","desc")->first();
		$periodo_activo = PeriodoComisione::where("estado",1)->where("activo",1)->orderBy("id","desc")->first();
		
		return view('frontend.planilla.consulta_planilla_delegado',compact('periodo','anio','mes','periodo_ultimo','periodo_activo'));
		
    }
	
	public function obtener_anio_periodo($id_periodo){
			
		$periodoComisione_model = new PeriodoComisione;
		$periodoComision = PeriodoComisione::find($id_periodo);
		$anio = $periodoComisione_model->getAnioByFecha($periodoComision->fecha_inicio,$periodoComision->fecha_fin);
		echo json_encode($anio);
		
	}
	
	public function consulta_reintegro(){
		
		return view('frontend.planilla.all_reintegro');
		
    }
	
	public function listar_reintegro_ajax(Request $request){
	
		$delegadoReintegro_model = new DelegadoReintegro();
		$p[]=$request->denominacion;
		$p[]="";
		$p[]="";
		$p[]=$request->estado;          
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $delegadoReintegro_model->listar_reintegro_ajax($p);
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
	
	public function modal_reintegro($id){
		
		$id_user = Auth::user()->id;
		
		$periodoComision_model = new PeriodoComisione;
		$regione_model = new Regione;
		$comisionSesionDelegado_model = new ComisionSesionDelegado;
		
		$periodo = $periodoComision_model->getPeriodoComisionAll();
		$region = $regione_model->getRegionAll();
		$id_regional="5";
		
		$mes = [
            '01' => 'Enero', '02' => 'Febrero', '03' => 'Marzo',
            '04' => 'Abril', '05' => 'Mayo', '06' => 'Junio',
            '07' => 'Julio', '08' => 'Agosto', '09' => 'Septiembre',
            '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre',
        ];
		
		//$delegados = $comisionSesionDelegado_model->getComisionDelegadosByIdComision(0);
		
		$comisionDelegado = NULL;
		
		if($id>0){
			$delegadoReintegro = DelegadoReintegro::find($id);
			$comisionDelegado = ComisionDelegado::find($delegadoReintegro->id_delegado);
		}else{
			$delegadoReintegro = new DelegadoReintegro;
		}
		
		return view('frontend.planilla.modal_reintegro',compact('id','delegadoReintegro','region','id_regional','periodo','mes','comisionDelegado'/*,'delegados'*/));

    }
	
	public function obtener_delegado_periodo($id_periodo){
			
		$comisionSesionDelegado_model = new ComisionSesionDelegado;
		$comision = $comisionSesionDelegado_model->getComisionDelegadosByIdPeriodo($id_periodo);
		echo json_encode($comision);
		
	}
	
	public function obtener_comision_delegado_periodo($id_periodo,$id_agremiado){
			
		$comisionSesionDelegado_model = new ComisionSesionDelegado;
		$comision = $comisionSesionDelegado_model->getComisionDelegadosByIdPeriodoAgremiado($id_periodo,$id_agremiado);
		echo json_encode($comision);
		
	}
	
	public function send_reintegro(Request $request){
		$id_user = Auth::user()->id;
		
		if($request->id == 0){
			$delegadoReintegro = new DelegadoReintegro;
		}else{
			$delegadoReintegro = DelegadoReintegro::find($request->id);
		}
		
		$delegadoReintegro->id_regional = $request->id_regional;
		$delegadoReintegro->id_periodo = $request->id_periodo;
		$delegadoReintegro->id_mes = $request->id_mes;
		$delegadoReintegro->id_comision = $request->id_comision;
		$delegadoReintegro->id_delegado = $request->id_delegado;
		$delegadoReintegro->importe = $request->importe;
		$delegadoReintegro->observacion = $request->observacion;
		$delegadoReintegro->estado = 1;
		$delegadoReintegro->id_usuario_inserta = $id_user;
		$delegadoReintegro->save();
			
    }
	
	public function obtener_planilla_delegado(Request $request){
		
		$planillaDelegado = PlanillaDelegado::where("id_periodo_comision",$request->id_periodo_bus)->where("periodo",$request->anio)->where("mes",$request->mes)->first();
		
        $planillaDelegado_model = new PlanillaDelegado;
		
		$planilla = NULL;
		$fondo_comun = NULL;
		
		if(isset($planillaDelegado->id)){
        	$planilla = $planillaDelegado_model->getPlanillaDelegadoDetalleByIdPlanilla($planillaDelegado->id);
			$fondo_comun = $planillaDelegado_model->getSaldoDelegadoFondoComun($request->id_periodo_bus,$request->anio,$request->mes);
		}
        return view('frontend.planilla.lista_planilla_delegado',compact('planilla','fondo_comun'));

    }
	
	public function send_planilla_delegado(Request $request){
		//exit();
		$msg = "";
		$planillaDelegadoExiste = PlanillaDelegado::where("periodo",$request->anio)->where("mes",$request->mes)->where("estado",1)->first();
		
		if($planillaDelegadoExiste){
			$msg = false;
		}else{
			$planillaDelegado_model = new PlanillaDelegado;
			$planillaDelegado_model->generar_planilla_delegado($request->id_periodo_bus,$request->anio,$request->mes);
		}
		
		return $msg;
		
	}
	
	public function consulta_planilla_recibos_honorario(){
		
		$periodoComisione_model = new PeriodoComisione;
		$planillaDelegadoDetalle = new PlanillaDelegadoDetalle;
		$agremiado = new Agremiado;
		$tablaMaestra_model = new TablaMaestra;
		
		
		$anio = range(date('Y'), date('Y') - 20); 
		$mes = [
            '01' => 'Enero', '02' => 'Febrero', '03' => 'Marzo',
            '04' => 'Abril', '05' => 'Mayo', '06' => 'Junio',
            '07' => 'Julio', '08' => 'Agosto', '09' => 'Septiembre',
            '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre',
        ];
		
		$periodo = $periodoComisione_model->getPeriodoAll();
		$periodo_ultimo = PeriodoComisione::where("estado",1)->orderBy("id","desc")->first();
		$periodo_activo = PeriodoComisione::where("estado",1)->where("activo",1)->orderBy("id","desc")->first();
		$tipo_comprobante = $tablaMaestra_model->getMaestroByTipo(103);
		$situacion = $tablaMaestra_model->getMaestroByTipo(14);

		return view('frontend.planilla.consulta_planilla_recibos_honorario',compact('periodo','anio','mes','periodo_ultimo','periodo_activo','planillaDelegadoDetalle','tipo_comprobante','agremiado','situacion'));
		
    }

	public function listar_recibo_honorario_ajax(Request $request){
	
		$planillaDelegadoDetalle_model = new PlanillaDelegadoDetalle();
		$p[]=$request->periodo;
		$p[]=$request->anio;
		$p[]=$request->mes;
		$p[]=$request->numero_cap;
		$p[]=$request->agremiado;
		$p[]=$request->municipalidad;
		$p[]=$request->situacion;
		$p[]=$request->numero_comprobante;
		$p[]=$request->fecha_inicio;
		$p[]=$request->fecha_fin;
		$p[]=$request->provision;
		$p[]=$request->cancelacion;
		$p[]=$request->grupo;
		$p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $planillaDelegadoDetalle_model->listar_recibo_honorario_ajax($p);
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

	public function obtener_datos_recibo($id){

		$planillaDelegadoDetalle_model = new PlanillaDelegadoDetalle;
		$datosRecibo = $planillaDelegadoDetalle_model->getDatosRecibo($id);
		echo json_encode($datosRecibo);

	}

	public function send_recibo_honorario(Request $request){

/*
		$planilla_detalle = PlanillaDelegadoDetalle::where('id_grupo',1)->where('estado','1')->get();

		foreach($planilla_detalle as $row){
			print_r($row->id);

		}
*/
	//	print_r($request->numero_comprobante); exit();

		
		
		$id_user = Auth::user()->id;

		$id = $request->id_recibo;

		if ($request->selTipo=='S' or $request->selTipo==''){
			$planillaDelegadoDetalle = PlanillaDelegadoDetalle::find($id);
			
			$planillaDelegadoDetalle->tipo_comprobante = $request->tipo_comprobante;
			$planillaDelegadoDetalle->numero_comprobante = $request->numero_comprobante;
			$planillaDelegadoDetalle->fecha_comprobante = $request->fecha_comprobante;
			$planillaDelegadoDetalle->fecha_vencimiento = $request->fecha_vencimiento;
			$planillaDelegadoDetalle->numero_operacion = $request->numero_operacion;
			$planillaDelegadoDetalle->cancelado = $request->cancelado;
			$planillaDelegadoDetalle->id_usuario_inserta = $id_user;
			$planillaDelegadoDetalle->save();



			/*
			$planillaDelegadoDetalle->tipo_comprobante = $request->tipo_comprobante;
			$planillaDelegadoDetalle->numero_comprobante = $request->numero_comprobante;
			$planillaDelegadoDetalle->fecha_comprobante = $request->fecha_comprobante;
			$planillaDelegadoDetalle->fecha_vencimiento = $request->fecha_vencimiento;
			$planillaDelegadoDetalle->numero_operacion = $request->numero_operacion;
			$planillaDelegadoDetalle->cancelado = $request->cancelado;
			$planillaDelegadoDetalle->id_usuario_inserta = $id_user;
			$planillaDelegadoDetalle->save();
			*/

		}else if ($request->selTipo=='T'){
			$planillaDelegadoDetalle_model = new PlanillaDelegadoDetalle();
			$data = $planillaDelegadoDetalle_model->actualizarReciboHonorario($request->id_periodo_bus, $request->anio, $request->mes,
			$request->id_grupo, $request->tipo_comprobante, $request->numero_comprobante, $request->fecha_comprobante, $request->fecha_vencimiento,
			$request->numero_operacion, $request->cancelado, $id_user);	
		}



		//echo json_encode($data);
		
    }

	public function generar_asiento_planilla(Request $request){

		$asiento = $request->asiento;
		
		
        $planillaDelegado_model = new PlanillaDelegado;
		
		$fondo_comun = $planillaDelegado_model->getGenerarAsientoPlanilla($asiento, $request->id_periodo_bus,$request->anio,$request->mes);

    }
	    
}
