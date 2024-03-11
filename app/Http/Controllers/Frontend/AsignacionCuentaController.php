<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AsignacionCuenta;
use App\Models\TablaMaestra;

//use App\Models\CondicionLaborale;

use Auth;

class AsignacionCuentaController extends Controller
{
    public function __construct(){

		$this->middleware(function ($request, $next) {
			if(!Auth::check()) {
                return redirect('login');
            }
			return $next($request);
    	});
	}
	
    public function index(){
        return view('frontend.asignacion.all');
    }

	public function create()
    {
        return view('frontend.persona.create');
    }

    public function listar_persona_ajax(Request $request){
		
		$persona_model = new Persona;
		$p[]=$request->numero_documento;
		$p[]=$request->persona;
		$p[]=$request->unidad;
		$p[]=$request->empresa;
		$p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $persona_model->listar_persona_ajax($p);
		$iTotalDisplayRecords = isset($data[0]->totalrows)?$data[0]->totalrows:0;
		
		$result["PageStart"] = $request->NumeroPagina;
		$result["pageSize"] = $request->NumeroRegistros;
		$result["SearchText"] = "";
		$result["ShowChildren"] = true;
		$result["iTotalRecords"] = $iTotalDisplayRecords;
		$result["iTotalDisplayRecords"] = $iTotalDisplayRecords;
		$result["aaData"] = $data;

		echo json_encode($result);
		//print_r ($result);
	}

    function consulta_asignacion(){

		//$tablaMaestra_model = new TablaMaestra;
		//$persona = new Persona;
        //$sexo = $tablaMaestra_model->getMaestroByTipo(2);
		//$tipo_documento = $tablaMaestra_model->getMaestroByTipo(16);
		//$grupo_sanguineo = $tablaMaestra_model->getMaestroByTipo(90);
		//$nacionalidad = $tablaMaestra_model->getMaestroByTipo(5);
        return view('frontend.persona.all_lista_asignacion',compact(''));

    }
}