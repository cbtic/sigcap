<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Agremiado;
use App\Models\Concurso;
use App\Models\ConcursoPuesto;
use App\Models\ConcursoInscripcione;
use App\Models\Comprobante;
use App\Models\TablaMaestra;
use App\Models\Concepto;
use Carbon\Carbon;
use Auth;

class ConcursoController extends Controller
{
    function index(){

        return view('frontend.concurso.all');
    }
	
	public function create(){
		
		$agremiado_model = new Agremiado();
		$concurso_model = new Concurso();
		
		$id_persona = Auth::user()->id_persona;
		//echo $id_user;
		$concurso = $concurso_model->getConcurso();
		$agremiado = $agremiado_model->getAgremiadoByIdPersona($id_persona);
		
        return view('frontend.concurso.create',compact('concurso','agremiado'));
    }
	
	public function editar_inscripcion($id){
		
		//$agremiado_model = new Agremiado();
		$concursoInscripcione_model = new ConcursoInscripcione();
		$concursoInscripcion = $concursoInscripcione_model->getConcursoInscripcionById($id);
		
		//$id_persona = Auth::user()->id_persona;
		//echo $id_user;
		//$concurso = $concurso_model->getConcurso();
		//$agremiado = $agremiado_model->getAgremiadoByIdPersona($id_persona);
		
        return view('frontend.concurso.edit',compact('concursoInscripcion'));
    }
	
	public function listar_concurso(Request $request){
	
		$concurso_model = new Concurso();
		$p[]="";
		$p[]="";
		$p[]=$request->estado;          
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $concurso_model->listar_concurso($p);
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
	
	public function modal_concurso($id){
		
		$id_user = Auth::user()->id;
		$concurso = new Concurso;
		$tablaMaestra_model = new TablaMaestra;
		
		if($id>0) $concurso = Concurso::find($id);else $concurso = new Concurso;

		$tipo_concurso = $tablaMaestra_model->getMaestroByTipo(93);

		return view('frontend.concurso.modal_concurso',compact('id','concurso','tipo_concurso'));

    }
	
	public function modal_puesto($id){
		
		$id_user = Auth::user()->id;
		
		$tablaMaestra_model = new TablaMaestra;
		$concursoPuesto_model = new ConcursoPuesto;
		$concurso_puesto = $concursoPuesto_model->getConcursoPuestoByIdConcurso($id);
		$tipo_plaza = $tablaMaestra_model->getMaestroByTipo(94);
		
		return view('frontend.concurso.modal_puesto',compact('id','concurso_puesto','tipo_plaza'));

    }
	
	public function listar_puesto(Request $request){
	
		$puesto_model = new Concurso();
		$p[]=$request->id_concurso;
		$p[]=1;          
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $puesto_model->listar_puesto($p);
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
	
	public function send_concurso(Request $request){
		$id_user = Auth::user()->id;
		
		if($request->id == 0){
			$concurso = new Concurso;
		}else{
			$concurso = Concurso::find($request->id);
		}
		
		$concurso->id_tipo_concurso = $request->id_tipo_concurso;
		$concurso->periodo = $request->periodo;
		$concurso->fecha = $request->fecha;
		$concurso->fecha_inscripcion = $request->fecha_inscripcion;
		$concurso->estado = 1;
		$concurso->id_usuario_inserta = $id_user;
		$concurso->save();
			
    }
	
	public function send_puesto(Request $request){
	
		$id_user = Auth::user()->id;
		
		if($request->id == 0){
			$concursoPuesto = new ConcursoPuesto;
			$concursoPuesto->id_concurso = $request->id_concurso;
		}else{
			$concursoPuesto = ConcursoPuesto::find($request->id);
		}
		
		$concursoPuesto->id_tipo_plaza = $request->id_tipo_plaza;
		$concursoPuesto->numero_plazas = $request->numero_plazas;
		$concursoPuesto->estado = 1;
		$concursoPuesto->id_usuario_inserta = $id_user;
		$concursoPuesto->save();
		
    }
	
	public function send_inscripcion(Request $request){
		
		$id_user = Auth::user()->id;
		$comprobante_model = new Comprobante();
		$agremiado_model = new Agremiado();
		
		if($request->id == 0){
			$concursoInscripcione = new ConcursoInscripcione;
		}else{
			$concursoInscripcione = ConcursoInscripcione::find($request->id);
		}
		
		$comprobante = $comprobante_model->getComprobanteByTipoSerieNumero($request->numero_comprobante);
		
		if($comprobante){
			
			$anio = Carbon::now()->format('Y');
			$concursoInscripcione->id_agremiado = $request->id_agremiado;
			$id_tipo_plaza = $agremiado_model->getTipoPlaza($request->id_agremiado);
			$concursoPuesto = ConcursoPuesto::where("id_concurso",$request->id_concurso)->where("id_tipo_plaza",$id_tipo_plaza)->where("estado","1")->first();
			$concepto = Concepto::where("codigo","00015")->where("periodo",$anio)->where("estado","1")->first();
			$concurso = Concurso::find($request->id_concurso);
			
			$concursoInscripcione->id_concurso_puesto = $concursoPuesto->id;
			$concursoInscripcione->puesto_postula = $id_tipo_plaza;
			$concursoInscripcione->puntaje = NULL;
			$concursoInscripcione->resultado = NULL;
			$concursoInscripcione->puesto = NULL;
			$concursoInscripcione->id_concepto = $concepto->id;
			$concursoInscripcione->estado = 1;
			$concursoInscripcione->id_usuario_inserta = $id_user;
			$concursoInscripcione->save();
		}
		
		/*
		$concurso->id_tipo_concurso = $request->id_tipo_concurso;
		$concurso->periodo = $request->periodo;
		$concurso->fecha = $request->fecha;
		$concurso->fecha_inscripcion = $request->fecha_inscripcion;
		$concurso->estado = 1;
		$concurso->id_usuario_inserta = $id_user;
		$concurso->save();
		*/
    }
	
	public function obtener_puesto($id){
		
		$concursoPuesto_model = new ConcursoPuesto;
		$puesto = $concursoPuesto_model->getConcursoPuestoById($id);
		
		echo json_encode($puesto);
	}
	
	public function eliminar_puesto($id){

		$concursoPuesto = ConcursoPuesto::find($id);
		$concursoPuesto->estado= "0";
		$concursoPuesto->save();
		
		echo "success";

    }
	
}
