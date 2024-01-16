<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Municipalidade;
use App\Models\Ubigeo;
use App\Models\TablaMaestra;

use Auth;

class MunicipalidadController extends Controller
{
    function consulta_municipalidad(){

        return view('frontend.municipalidad.all');
    }

    public function __construct(){

		$this->middleware(function ($request, $next) {
			if(!Auth::check()) {
                return redirect('login');
            }
			return $next($request);
    	});
	}

    //
    public function listar_municipalidad(Request $request){
	
		$municipalidad_model = new Municipalidade();
		$p[]=$request->denominacion;
		$p[]=$request->tipo_municipalidad;
		$p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $municipalidad_model->listar_municipalidad($p);
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

    public function editar_municipalidad($id){
        
		$municipalidad = Municipalidade::find($id);
		$id_municipalidad = $$municipalidad->id;
		$municipalidad = Municipalidade::find($id);
		
		
		return view('frontend.empresa.create',compact('ruc','nombre_comercial','razon_social','direccion','representante','estado'));
		
    }

    public function modal_municipalidad($id){
		$id_user = Auth::user()->id;
		//$municipalidad = new Municipalidade;
		$ubigeo_model = new Ubigeo;
		if($id>0) 
		{
			$municipalidad = Municipalidade::find($id);
		}else 
		{
			$municipalidad = new Municipalidade;
		}

        $tablaMaestra_model = new TablaMaestra;
		$tipo_municipalidad = $tablaMaestra_model->getMaestroByTipo(43);


		$ubigeo_model = new Ubigeo;
		$departamento = $ubigeo_model->getDepartamento();

		/*$provincia = "";
		$distrito = "";*/

		//print_r ($departamento);
		//exit();
/*
		if($municipalidad->id_ubigeo!=""){
			$idDepartamento = substr($municipalidad->ubigeo, 0, 2);
			$idProvincia = substr($municipalidad->ubigeo, 0, 4);

			$provincia = $ubigeo_model->getProvincia($idDepartamento);
			$distrito = $ubigeo_model->getDistrito($idDepartamento,$idProvincia);
		}*/

		//print_r ($unidad_trabajo);exit();

		return view('frontend.municipalidad.modal_municipalidad',compact('id','municipalidad','departamento','tipo_municipalidad'));

    }

	public function obtener_provincia($idDepartamento){
		
		$ubigeo_model = new Ubigeo;
		$provincia = $ubigeo_model->getProvincia($idDepartamento);
		
		echo json_encode($provincia);
	}
	
	public function obtener_distrito($id_departamento,$idProvincia){
		
		$ubigeo_model = new Ubigeo;
		$distrito = $ubigeo_model->getDistrito($id_departamento,$idProvincia);
		//print_r($distrito);exit();
		echo json_encode($distrito);
	}

    public function send_municipalidad(Request $request){
		$id_user = Auth::user()->id;

        //print_r ($id_user);exit();
        
		if($request->id == 0){
			$municipalidad = new municipalidade;
		}else{
			$municipalidad =municipalidade::find($request->id);
		}
		
		$municipalidad->denominacion = $request->denominacion;

		//$municipalidad->estado = $request->estado_;
        $municipalidad->id_tipo_municipalidad = $request->tipo_municipalidad;
		$municipalidad->id_regional = 5;
		$municipalidad->id_ubigeo = $request->id_distrito_domiciliario;
		$municipalidad->id_usuario_inserta = $id_user;
        
        

		$municipalidad->save();
			
    }
    
    public function eliminar_municipalidad($id,$estado)
    {
		$municipalidad = municipalidade::find($id);
		$municipalidad->estado = $estado;
		$municipalidad->save();

		echo $municipalidad->id;

    }
}



