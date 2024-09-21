<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProfesionalesOtro;
use App\Models\Persona;
use App\Models\Profesione;
use App\Models\TablaMaestra;
use Auth;

class ProfesionalesOtroController extends Controller
{
    public function __construct(){

		$this->middleware(function ($request, $next) {
			if(!Auth::check()) {
                return redirect('login');
            }
			return $next($request);
    	});
	}

    function consulta_profesionalesOtro(){

        $profesion_model = new Profesione;
        $persona_model = new Persona;
        $profesion = $profesion_model->getProfesionAll();
        $persona = $persona_model->getPersona_ListaAll();
        $profesion_Otro = new ProfesionalesOtro;
        
        return view('frontend.profesionalesOtro.all',compact('profesion_Otro','profesion','persona'));
    }
	
    public function listar_profesionalesOtro_ajax(Request $request){
	
		$profesionOtro_model = new ProfesionalesOtro;
		$p[]=$request->colegiatura;
		$p[]="";
        $p[]="";
        $p[]=$request->numero_documento;
		$p[]=$request->agremiado;
        $p[]="";
		$p[]=$request->profesion;
		$p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $profesionOtro_model->listar_profesionalesOtro_ajax($p);
		$iTotalDisplayRecords = isset($data[0]->totalrows)?$data[0]->totalrows:0;

		$result["PageStart"] = $request->NumeroPagina;
		$result["pageSize"] = $request->NumeroRegistros;
		$result["SearchText"] = "";
		$result["ShowChildren"] = true;
		$result["iTotalRecords"] = $iTotalDisplayRecords;
		$result["iTotalDisplayRecords"] = $iTotalDisplayRecords;
		$result["aaData"] = $data;

		echo json_encode($result);
	
	}

    public function editar_profesionalesOtro($id){
        
		$profesionalesOtro = ProfesionalesOtro::find($id);
		$id_profesion_otro = $profesionalesOtro->id_profesion_otro;
		$profesionalesOtro = ProfesionalesOtro::find($id_profesion_otro);

        $persona = Persona::find($id);
		$id_persona = $persona->id_persona;
		$persona = Persona::find($id_persona);

        $profesion = Profesione::find($id);
		$id_profesion = $profesion->id_profesion;
		$profesion = Profesione::find($id_profesion);

		//$profesion_model = new Profesione;
		//$profesion = $profesion_model->getProfesionAll();
        //$empresas_model = new empresas;

		
		return view('frontend.profesionalesOtro.create',compact('colegiatura','colegiatura_abreviatura','persona','profesion','ruta_firma','estado'));
		
    }

    public function modal_profesionalesOtro_nuevoProfesionalesOtro($id){
		
		$profesionalOtro = new ProfesionalesOtro;
        $persona = new Persona;
		$tablaMaestra_model = new TablaMaestra;
        $profesion_model = new Profesione;
		
		if($id>0){
			$profesionalOtro = ProfesionalesOtro::find($id);
            $persona = Persona::find($id);
		}else{
			$profesionalOtro = new ProfesionalesOtro;
            $persona = new Persona;
		}
		
        //$persona = $persona_model->getPersona_ListaAll();
        $tipo_documento = $tablaMaestra_model->getMaestroByTipo(16);
        $profesion = $profesion_model->getProfesionAll();
		//$universidad = $tablaMaestra_model->getMaestroByTipo(85);
		//$especialidad = $tablaMaestra_model->getMaestroByTipo(86);
		
		return view('frontend.profesionalesOtro.modal_profesionalesOtro_nuevoProfesionalesOtro',compact('id','profesionalOtro','persona','tipo_documento','profesion'));
	
	}

    public function send_profesionalesOtro_nuevoProfesionalesOtro(Request $request){
		
		/*$request->validate([
			'tipo_documento'=>'required',
			'numero_documento'=>'required | numeric | digits:8',
			'profesion'=>'required',
			'colegiatura'=>'required',
		]
		);*/

		$id_user = Auth::user()->id;

		if($request->id == 0){
			$profesionOtro = new ProfesionalesOtro;
		}else{
			$profesionOtro = ProfesionalesOtro::find($request->id);
		}


		$profesionOtro->colegiatura = $request->colegiatura;
		$profesionOtro->colegiatura_abreviatura = $request->colegiatura_abreviatura;
		$profesionOtro->id_persona = $request->id_persona;
		$profesionOtro->id_profesion = $request->profesion;
		//$profesionalesOtro->ruta_firma = $request->ruta_firma;
		//$profesionOtro->estado = 1;
		$profesionOtro->id_usuario_inserta = $id_user;
		
		if($profesionOtro->id_persona)$profesionOtro->save();
		
    }

	public function eliminar_profesionalesOtro($id,$estado)
    {
		$profesionOtro = ProfesionalesOtro::find($id);
		$profesionOtro->estado = $estado;
		$profesionOtro->save();

		echo $profesionOtro->id;
    }
}
