<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CoordinadorZonal;

class CoordinadorZonalController extends Controller
{
    public function __construct(){

		$this->middleware(function ($request, $next) {
			if(!Auth::check()) {
                return redirect('login');
            }
			return $next($request);
    	});
	}

    public function consulta_coordinadorZonal(){
        
		$coordinadorZonal_model = new CoordinadorZonal;
		//$concepto = $coordinadorZonal_model->getConceptoAll();
		//$prontoPago = new ProntoPago;
        return view('frontend.coordinador_zonal.all');

    }

    public function listar_coordinadorZonal_ajax(Request $request){
	
		$coordinadorZonal_model = new CoordinadorZonal;
		$p[]="";
		$p[]="";//$request->nombre;
		$p[]="";
		$p[]="";
        $p[]="";
		$p[]="";
        $p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $coordinadorZonal_model->listar_coordinadorZonal_ajax($p);
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

    public function modal_coordinadorZonal_nuevoCoordinadorZonal($id){
		
		$coordinadorZonal = new CoordinadorZonal;
		//$concepto_model = new Concepto;

		if($id>0){
			$coordinadorZonal = CoordinadorZonal::find($id);
		}else{
			$coordinadorZonal = new CoordinadorZonal;
		}
		
		//$concepto = $concepto_model->getConceptoAll();
		
		return view('frontend.coordinador_zonal.modal_coordinadorZonal_nuevoCoordinadorZonal',compact('id','coordinadorZonal'));
	
	}
    
}
