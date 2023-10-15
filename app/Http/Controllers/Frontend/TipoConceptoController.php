<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TipoConcepto;

class TipoConceptoController extends Controller
{
    function consulta_tipoConcepto(){
        
        return view('frontend.tipoConcepto.all');

    }

    public function listar_tipoConcepto_ajax(Request $request){
	
		$tipoConcepto_model = new TipoConcepto;
		$p[]="";
		$p[]="";
		$p[]="";
		$p[]="";
        $p[]="";
        $p[]="";
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $empresa_model->listar_empresa_ajax($p);
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
}
