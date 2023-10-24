<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProntoPago;
use Auth;

class ProntoPagoController extends Controller
{
    function consulta_prontoPago(){
        
        return view('frontend.prontoPago.all');

    }
	
	public function __construct(){

		$this->middleware(function ($request, $next) {
			if(!Auth::check()) {
                return redirect('login');
            }
			return $next($request);
    	});
	}

    public function listar_prontoPago_ajax(Request $request){
	
		$prontoPago_model = new ProntoPago;
		$p[]=$request->fecha_inicio;//$request->nombre;
		$p[]=$request->fecha_fin;
		$p[]="";
        $p[]="";
        $p[]="";
        $p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $prontoPago_model->listar_prontoPago_ajax($p);
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
