<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Seguro;
use App\Models\SegurosPlane;
use App\Models\Ubigeo;
use App\Models\TablaMaestra;
use App\Models\Regione;

use Auth;

class SeguroController extends Controller
{
    function consulta_seguro(){

        return view('frontend.seguro.all');
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
    public function listar_seguro(Request $request){
	
		$municipalidad_model = new Seguro();
		$p[]=$request->denominacion;
		$p[]=$request->estado;          
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $municipalidad_model->listar_seguro($p);
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

    public function listar_plan(Request $request){
	
		$plan_model = new Seguro();
		$p[]=$request->id_seguro;
		$p[]=1;          
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $plan_model->listar_plan($p);
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
	
	public function obtener_plan($id){
		
		$segurosPlane_model = new SegurosPlane;
		$plan = $segurosPlane_model->getSeguroPlanById($id);
		
		echo json_encode($plan);
	}
	
	public function eliminar_plan($id){

		$segurosPlane = SegurosPlane::find($id);
		$segurosPlane->estado= "0";
		$segurosPlane->save();
		
		echo "success";

    }
	
    public function editar_municipalidad($id){
        
		$municipalidad = Seguro::find($id);
		$id_municipalidad = $$municipalidad->id;
		$municipalidad = Seguro::find($id);
		
		
		return view('frontend.empresa.create',compact('ruc','nombre_comercial','razon_social','direccion','representante','estado'));
		
    }

    public function modal_seguro($id){
		
		$id_user = Auth::user()->id;
		$seguro = new Seguro;
		if($id>0) $seguro = Seguro::find($id);else $seguro = new Seguro;

		$regione_model = new Regione;
        //$tablaMaestra_model = new TablaMaestra;
		//$tipo_municipalidad = $tablaMaestra_model->getMaestroByTipo(43);
        //$tipo_comision = $tablaMaestra_model->getMaestroByTipo(24);
        
        //$PlanSeguro_Model = new SegurosPlane;
        //$plan_seguro=$PlanSeguro_Model::where('id_seguro', $id)->get()->all();
       
        //$ubigeo_model = new Ubigeo;
		//$departamento = $ubigeo_model->getDepartamento("PER");

		//$provincia = "";
		//$distrito = "";
		
		$region = $regione_model->getRegionAll();
		//print_r ($unidad_trabajo);exit();

		return view('frontend.seguro.modal_seguro',compact('id','seguro',/*'plan_seguro',*/'region'));

    }
	
	public function modal_plan($id){
		
		$id_user = Auth::user()->id;
		/*
		$seguro = new Seguro;
		$regione_model = new Regione;
		if($id>0) $seguro = Seguro::find($id);else $seguro = new Seguro;
		*/
		
        //$tablaMaestra_model = new TablaMaestra;
		//$tipo_municipalidad = $tablaMaestra_model->getMaestroByTipo(43);
        //$tipo_comision = $tablaMaestra_model->getMaestroByTipo(24);
        
        //$PlanSeguro_Model = new SegurosPlane;
        $plan_seguro=SegurosPlane::where('id_seguro', $id)->where('estado', '1')->get()->all();
       
        //$ubigeo_model = new Ubigeo;
		//$departamento = $ubigeo_model->getDepartamento("PER");

		//$provincia = "";
		//$distrito = "";

		//$region = $regione_model->getRegionAll();
		//print_r ($unidad_trabajo);exit();

		return view('frontend.seguro.modal_plan',compact('id','plan_seguro'/*'plan_seguro',*/));

    }

    public function send_seguro(Request $request){
		$id_user = Auth::user()->id;
		
		if($request->id == 0){
			$seguro = new Seguro;
		}else{
			$seguro = Seguro::find($request->id);
		}
		
		$seguro->id_regional = $request->id_regional;
		$seguro->nombre = $request->nombre;
		$seguro->descripcion = $request->descripcion;
		$seguro->estado = 1;
		$seguro->id_usuario_inserta = $id_user;
		$seguro->save();
			
    }
	
	public function send_plan(Request $request){
	
		$id_user = Auth::user()->id;
		
		if($request->id == 0){
			$segurosPlan = new SegurosPlane;
			$segurosPlan->id_seguro = $request->id_seguro;
		}else{
			$segurosPlan = SegurosPlane::find($request->id);
		}
		
		$segurosPlan->nombre = $request->nombre;
		$segurosPlan->descripcion = $request->descripcion;
		$segurosPlan->fecha_inicio = $request->fecha_inicio;
		$segurosPlan->fecha_fin = $request->fecha_fin;
		$segurosPlan->monto = $request->monto;
		$segurosPlan->estado = 1;
		$segurosPlan->id_usuario_inserta = $id_user;
		$segurosPlan->save();
		
    }
    
    
    
}



