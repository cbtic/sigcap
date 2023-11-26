<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ComisionSesione;
use App\Models\ComisionSesionDelegado;
use App\Models\Regione;
use App\Models\Comisione;
use App\Models\TablaMaestra;
use App\Models\PeriodoComisione;
use App\Models\ComisionDelegado;
use App\Models\ProfesionalesOtro;
use Auth;

class SesionController extends Controller
{

	public function __construct(){

		$this->middleware(function ($request, $next) {
			if(!Auth::check()) {
                return redirect('login');
            }
			return $next($request);
    	});
	}

    public function lista_programacion_sesion(){

        return view('frontend.sesion.all_listar_sesion');
    }
	
	public function lista_programacion_sesion_ajax(Request $request){
	
		$comisionSesion_model = new ComisionSesione(); 
		$p[]="";
		$p[]="";
		$p[]="";
		$p[]=$request->estado;          
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $comisionSesion_model->lista_programacion_sesion_ajax($p);
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
	
	public function modal_sesion($id){
		
		$id_user = Auth::user()->id;
		
		$regione_model = new Regione;
		//$comision_model = new Comisione;
		$comisionSesionDelegado_model = new ComisionSesionDelegado;
		$tablaMaestra_model = new TablaMaestra;
		$periodoComisione_model = new PeriodoComisione;
		
		
		//$comision = $comision_model->getComisionAll("","1");
		$region = $regione_model->getRegionAll();
		
		$tipo_programacion = $tablaMaestra_model->getMaestroByTipo(71);
		$estado_sesion = $tablaMaestra_model->getMaestroByTipo(56);
		$periodo = $periodoComisione_model->getPeriodoAll();
		
		if($id>0){
			$comisionSesion = ComisionSesione::find($id);
			$id_comision = $comisionSesion->id_comision;
			$comision = Comisione::find($id_comision);
			$delegados = $comisionSesionDelegado_model->getComisionSesionDelegadosByIdComisionSesion($id);
		}else{
			$comisionSesion = new ComisionSesione;
			$comision = new Comisione;
			$delegados = $comisionSesionDelegado_model->getComisionDelegadosByIdComision(0/*$request->id_comision*/);
		}
		
		return view('frontend.sesion.modal_sesion',compact('id','comisionSesion','delegados','region','tipo_programacion','estado_sesion','periodo','comision'));

    }
	
	public function obtener_comision($id_periodo){
			
		$comision_model = new Comisione;
		$comision = $comision_model->getComisionByPeriodo($id_periodo);
		echo json_encode($comision);
		
	}
	
	public function obtener_comision_delegado($id_comision){
			
		$comisionSesionDelegado_model = new ComisionSesionDelegado(); 
		$delegado = $comisionSesionDelegado_model->getComisionDelegadosByIdComision($id_comision);
		echo json_encode($delegado);
		
	}
	
	public function send_sesion(Request $request){
		$id_user = Auth::user()->id;
		
		$id_delegado = $request->id_delegado;
		
		if($request->id == 0){
			$comisionSesion = new ComisionSesione;
		}else{
			$comisionSesion = ComisionSesione::find($request->id);
		}
		
		//$concursoInscripcion = ConcursoInscripcione::find($request->id_concurso_inscripcion);
		
		$comisionSesion->id_regional = $request->id_regional;
		$comisionSesion->id_periodo_comisione = $request->id_periodo_comisione;
		$comisionSesion->id_tipo_sesion = $request->id_tipo_sesion;
		$comisionSesion->fecha_programado = $request->fecha_programado;
		$comisionSesion->fecha_ejecucion = $request->fecha_ejecucion;
		$comisionSesion->hora_inicio = $request->hora_inicio;
		$comisionSesion->hora_fin = $request->hora_fin;
		$comisionSesion->id_aprobado = $request->id_aprobado;
		$comisionSesion->observaciones = $request->observaciones;
		$comisionSesion->id_comision = $request->id_comision;
		$comisionSesion->id_estado_sesion = $request->id_estado_sesion;
		//$comisionDelegado->id_agremiado = $concursoInscripcion->id_agremiado;
		//$comisionDelegado->id_puesto = $concursoInscripcion->puesto_postula;
		$comisionSesion->estado = 1;
		$comisionSesion->id_usuario_inserta = $id_user;
		$comisionSesion->save();
		$id_comision_sesion = $comisionSesion->id;
		
		foreach($id_delegado as $row){
			$comisionSesionDelegado = new ComisionSesionDelegado();
			$comisionSesionDelegado->id_comision_sesion = $id_comision_sesion;
			$comisionSesionDelegado->id_delegado = $row;
			$comisionSesionDelegado->id_profesion_otro = NULL;
			$comisionSesionDelegado->id_aprobar_pago = NULL;
			$comisionSesionDelegado->observaciones = NULL;
			$comisionSesionDelegado->estado = 1;
			$comisionSesionDelegado->id_usuario_inserta = $id_user;
			$comisionSesionDelegado->save();
		}
		
			
    }
	
	public function send_profesion_otro(Request $request){
		
		$id_user = Auth::user()->id;
		
		if($request->id == 0){
			$comisionSesionDelegado = new ComisionSesionDelegado();
		}else{
			$comisionSesionDelegado = ComisionSesionDelegado::find($request->id);
		}
		
		$comisionSesionDelegado->id_comision_sesion = $request->id_comision_sesion;
		$comisionSesionDelegado->id_delegado = NULL;
		$comisionSesionDelegado->id_profesion_otro = $request->id_profesion_otro;
		$comisionSesionDelegado->id_aprobar_pago = NULL;
		$comisionSesionDelegado->observaciones = NULL;
		$comisionSesionDelegado->estado = 1;
		$comisionSesionDelegado->id_usuario_inserta = $id_user;
		$comisionSesionDelegado->save();
				
    }
	
	public function send_delegado_sesion(Request $request){
		
		$id_user = Auth::user()->id;
		
		if($request->id == 0){
			$comisionSesionDelegado = new ComisionSesionDelegado();
		}else{
			$comisionSesionDelegado = ComisionSesionDelegado::find($request->id);
		}
		
		$comisionSesionDelegado->id_comision_sesion = $request->id_comision_sesion;
		$comisionSesionDelegado->id_delegado = $request->id_delegado;
		$comisionSesionDelegado->id_profesion_otro = NULL;
		$comisionSesionDelegado->id_aprobar_pago = NULL;
		$comisionSesionDelegado->observaciones = NULL;
		$comisionSesionDelegado->estado = 1;
		$comisionSesionDelegado->id_usuario_inserta = $id_user;
		$comisionSesionDelegado->save();
			
    }
	
	public function modal_asignar_delegado_sesion($id){
		
		$id_user = Auth::user()->id;
		
		$comisionDelegado_model = new ComisionDelegado;
		
		//if($id>0) $comisionDelegado = ComisionDelegado::find($id);else $comisionDelegado = new ComisionDelegado;
		
		$concurso_inscripcion = $comisionDelegado_model->getComisionDelegado();
		
		return view('frontend.sesion.modal_asignar_delegado_sesion',compact('id','concurso_inscripcion'));

    }
	
	public function modal_asignar_profesion_sesion($id){
		
		$id_user = Auth::user()->id;
		
		$profesionalesOtro_model = new ProfesionalesOtro;
		
		//if($id>0) $comisionDelegado = ComisionDelegado::find($id);else $comisionDelegado = new ComisionDelegado;
		
		$profesion_sesion = $profesionalesOtro_model->getProfesionSesion();
		
		return view('frontend.sesion.modal_asignar_profesion_sesion',compact('id','profesion_sesion'));

    }
	
		
	
}
