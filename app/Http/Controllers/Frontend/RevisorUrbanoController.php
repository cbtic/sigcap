<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RevisorUrbano;
use App\Models\TablaMaestra;
use App\Models\Agremiado;
use App\Models\Persona;
use App\Models\Regione;
use Auth;

class RevisorUrbanoController extends Controller
{
    public function __construct(){

		$this->middleware(function ($request, $next) {
			if(!Auth::check()) {
                return redirect('login');
            }
			return $next($request);
    	});
	}

    function consulta_revisorUrbano(){

        $tablaMaestra_model = new TablaMaestra;
		$agremiado = new Agremiado;
        $persona = new Persona;
        $regione_model = new Regione;
        $region = $regione_model->getRegionAll();
        $tipo_documento = $tablaMaestra_model->getMaestroByTipo(110);
        $ubicacion_cliente = $tablaMaestra_model->getMaestroByTipo(63);
        $situacion_cliente = $tablaMaestra_model->getMaestroByTipo(14);

        return view('frontend.revisorUrbano.all',compact('agremiado','persona','tipo_documento','region','ubicacion_cliente','situacion_cliente'));
    }

    public function listar_revisorUrbano_ajax(Request $request){
	
		$revisorUrbano_model = new RevisorUrbano;
		$p[]="";//$request->ruc;
		$p[]="";
		$p[]="";
		$p[]="";
        $p[]="";
		$p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $revisorUrbano_model->listar_revisorUrbano_ajax($p);
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

    public function modal_revisorUrbano_nuevoRevisorUrbano($id){
		
		$revisorUrbano = new RevisorUrbano;
		
		if($id>0){
			$revisorUrbano = RevisorUrbano::find($id);
		}else{
			$revisorUrbano = new RevisorUrbano;
		}
		
		//$universidad = $tablaMaestra_model->getMaestroByTipo(85);
		//$especialidad = $tablaMaestra_model->getMaestroByTipo(86);
		
		return view('frontend.revisorUrbano.modal_revisorUrbano_nuevoRevisorUrbano',compact('id','revisorUrbano'));
	
	}

}
