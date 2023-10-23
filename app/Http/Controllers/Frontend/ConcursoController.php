<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Concurso;
use App\Models\ConcursoPuesto;
use App\Models\TablaMaestra;
use Auth;

class ConcursoController extends Controller
{
    function index(){

        return view('frontend.concurso.all');
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

		$tipo_concurso = $tablaMaestra_model->getMaestroByTipo(92);

		return view('frontend.concurso.modal_concurso',compact('id','concurso','tipo_concurso'));

    }
	
	public function modal_puesto($id){
		
		$id_user = Auth::user()->id;
		
		$tablaMaestra_model = new TablaMaestra;
		$concursoPuesto_model = new ConcursoPuesto;
		$concurso_puesto = $concursoPuesto_model->getConcursoPuestoByIdConcurso($id);
		$tipo_plaza = $tablaMaestra_model->getMaestroByTipo(93);
		
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
