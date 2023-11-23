<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ComisionSesione;
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
		$comision_model = new Comisione;
		$comisionDelegado_model = new ComisionDelegado;
		
		$comision = $comision_model->getComisionAll("","1");
		if($id>0) $comisionSesion = ComisionSesione::find($id);else $comisionSesion = new ComisionSesione;

		//$concurso_inscripcion = $comisionDelegado_model->getConcursoInscripcionAll();
		$region = $regione_model->getRegionAll();
		
		return view('frontend.sesion.modal_sesion',compact('id','comisionSesion','comision','concurso_inscripcion','region'));

    }
	
	public function send_sesion(Request $request){
		$id_user = Auth::user()->id;
		
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
			
    }
	
	
	
}
