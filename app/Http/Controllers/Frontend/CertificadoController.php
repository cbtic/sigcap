<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Certificado;

class CertificadoController extends Controller
{
    public function consulta_certificado(Request $request){
	
		$certificado_model = new Certificado();
        
        $p[]=$request->cap;
		$p[]=$request->nombre;
		$p[]=$request->estado;          
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $certificado_model->listar_certificado($p);
     
     
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
}