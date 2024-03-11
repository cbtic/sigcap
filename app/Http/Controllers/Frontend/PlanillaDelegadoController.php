<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PlanillaDelegado;
use App\Models\DelegadoReintegro;
use App\Models\PeriodoComisione;
use App\Models\ComisionDelegado;
use App\Models\Regione;
use App\Models\ComisionSesionDelegado;
use Auth;

class PlanillaDelegadoController extends Controller
{
	
	public function consulta_planilla_delegado(){
		
		//$agremiado_model = new Agremiado();
		//$concurso_model = new Concurso();
		//$tablaMaestra_model = new TablaMaestra;
		
		//$concurso = $concurso_model->getConcurso();
		//$situacion_cliente = $tablaMaestra_model->getMaestroByTipo(14);
		
        //return view('frontend.concurso.create_resultado',compact('concurso','situacion_cliente'));
		
		$anio = range(date('Y'), date('Y') - 20); 
		$mes = [
            '01' => 'Enero', '02' => 'Febrero', '03' => 'Marzo',
            '04' => 'Abril', '05' => 'Mayo', '06' => 'Junio',
            '07' => 'Julio', '08' => 'Agosto', '09' => 'Septiembre',
            '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre',
        ];
		
		return view('frontend.planilla.consulta_planilla_delegado',compact('anio','mes'));
		
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
		
		$planillaDelegado = PlanillaDelegado::where("periodo",$request->anio)->where("mes",$request->mes)->first();
		
        $planillaDelegado_model = new PlanillaDelegado;
		
		$planilla = NULL;
		$fondo_comun = NULL;
		
		if(isset($planillaDelegado->id)){
        	$planilla = $planillaDelegado_model->getPlanillaDelegadoDetalleByIdPlanilla($planillaDelegado->id);
			$fondo_comun = $planillaDelegado_model->getSaldoDelegadoFondoComun($request->anio,$request->mes);
		}
        return view('frontend.planilla.lista_planilla_delegado',compact('planilla','fondo_comun'));

    }
	
	public function send_planilla_delegado(Request $request){
		
		$msg = "";
		$planillaDelegadoExiste = PlanillaDelegado::where("periodo",$request->anio)->where("mes",$request->mes)->where("estado",1)->first();
		
		if($planillaDelegadoExiste){
			$msg = false;
		}else{
			$planillaDelegado_model = new PlanillaDelegado;
			$planillaDelegado_model->generar_planilla_delegado($request->anio,$request->mes);
		}
		
		return $msg;
		
	}
	
	    
}
