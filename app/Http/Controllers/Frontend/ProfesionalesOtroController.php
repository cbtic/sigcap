<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProfesionalesOtro;
use App\Models\Persona;
use App\Models\Profesione;

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

        return view('frontend.profesionalesOtro.all');
    }
	
    public function listar_profesionarlesOtro_ajax(Request $request){
	
		$profesionOtro_model = new ProfesionalesOtro;
		$p[]=$request->colegiatura;
		$p[]="";
		$p[]=$request->nombres;
		$p[]=$request->profesion;
        $p[]="";
		$p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $profesionOtro_model->listar_profesionarlesOtro_ajax($p);
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
		
		$profesionalesOtro = new ProfesionalesOtro;
		
		if($id>0){
			$profesionalesOtro = ProfesionalesOtro::find($id);
		}else{
			$profesionalesOtro = new ProfesionalesOtro;
		}
		
		//$universidad = $tablaMaestra_model->getMaestroByTipo(85);
		//$especialidad = $tablaMaestra_model->getMaestroByTipo(86);
		
		return view('frontend.profesionalesOtro.modal_profesionalesOtro_nuevoProfesionalesOtro',compact('id','profesionalesOtro'));
	
	}

    public function send_profesionalesOtro_nuevoProfesionalesOtro(Request $request){
		
		$id_user = Auth::user()->id;

		if($request->id == 0){
			$profesionalesOtro = new ProfesionalesOtro;
		}else{
			$profesionalesOtro = ProfesionalesOtro::find($request->id);
		}
		
		$profesionalesOtro->colegiatura = $request->colegiatura;
		$profesionalesOtro->colegiatura_abreviatura = $request->colegiatura_abreviatura;
		$profesionalesOtro->id_persona = $request->nombres;
		$profesionalesOtro->id_profesion = $request->profesion;
		$profesionalesOtro->ruta_firma = $request->ruta_firma;
		$profesionalesOtro->estado = 1;
		$profesionalesOtro->id_usuario_inserta = $id_user;
		$profesionalesOtro->save();
    }

	public function eliminar_profesionalesOtro($id,$estado)
    {
		$profesionalesOtro = ProfesionalesOtro::find($id);
		$profesionalesOtro->estado = $estado;
		$profesionalesOtro->save();

		echo $profesionalesOtro->id;
    }
}
