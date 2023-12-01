<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Profesione;
use Auth;

class ProfesionController extends Controller
{
    public function __construct(){

		$this->middleware(function ($request, $next) {
			if(!Auth::check()) {
                return redirect('login');
            }
			return $next($request);
    	});
	}

    function consulta_profesion(){

        return view('frontend.profesion.all');
    }

    public function listar_profesion_ajax(Request $request){
	
		$empresa_model = new Profesione;
		$p[]=$request->nombre;
		$p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $empresa_model->listar_profesion_ajax($p);
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

    public function editar_profesion($id){
        
		$profesion = Profesione::find($id);
		$id_profesion = $profesion->id_profesion;
        $nombre = $profesion->nombre;
        $profesion = Profesione::find($id_profesion);
		
		return view('frontend.profesion.create',compact('id','nombre','profesion','estado'));
		
    }

    public function modal_profesion_nuevoProfesion($id){
		
		$profesion = new Profesione;
		
		if($id>0){
			$profesion = Profesione::find($id);
		}else{
			$profesion = new Profesione;
		}
		
		//$universidad = $tablaMaestra_model->getMaestroByTipo(85);
		//$especialidad = $tablaMaestra_model->getMaestroByTipo(86);
		
		return view('frontend.profesion.modal_profesion_nuevoProfesion',compact('id','profesion'));
	
	}

    public function send_profesion_nuevoProfesion(Request $request){
		
		$request->validate([
			'nombre'=>'required',
		]
		);

		$id_user = Auth::user()->id;

		if($request->id == 0){
			$profesion = new Profesione;
		}else{
			$profesion = Profesione::find($request->id);
		}
		
		$profesion->nombre = $request->nombre;
		//$profesion->estado = 1;
		$profesion->id_usuario_inserta = $id_user;
		$profesion->save();
    }

	public function eliminar_profesion($id,$estado)
    {
		$profesion = Profesione::find($id);
		$profesion->estado = $estado;
		$profesion->save();

		echo $profesion->id;
    }

}
