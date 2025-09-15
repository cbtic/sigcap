<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AgremiadoRole;
use App\Models\TablaMaestra;
use App\Models\PeriodoComisione;
use Auth;

class AgremiadoRolesController extends Controller
{
    public function __construct(){

		$this->middleware(function ($request, $next) {
			if(!Auth::check()) {
                return redirect('login');
            }
			return $next($request);
    	});
	}

    function consulta_agremiado_rol(){

		$agremiado_rol = new AgremiadoRole;
		$tablaMaestra_model = new TablaMaestra;
		$periodoComision_model = new PeriodoComisione;

		$rol_especifico = $tablaMaestra_model->getMaestroByTipo(94);
		$rol = $tablaMaestra_model->getMaestroByTipo(101);
		$periodo = $periodoComision_model->getPeriodoAll();
		$periodo_ultimo = PeriodoComisione::where("estado",1)->orderBy("id","desc")->first();
		$periodo_activo = PeriodoComisione::where("estado",1)->where("activo",1)->orderBy("id","desc")->first();
		

        return view('frontend.agremiado_rol.all',compact('agremiado_rol','rol','rol_especifico','periodo','periodo_ultimo','periodo_activo'));
    }

    public function listar_agremiado_rol_ajax(Request $request){
	
		$agremiado_rol_model = new AgremiadoRole;
		$p[]=$request->periodo;
		$p[]=$request->numero_cap;
        $p[]=$request->agremiado;
        $p[]=$request->rol;
		$p[]=$request->sub_rol;
		$p[]=$request->rol_especifico;
        $p[]="";
        $p[]="";
        $p[]="";
		$p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $agremiado_rol_model->listar_agremiado_rol_ajax($p);
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
