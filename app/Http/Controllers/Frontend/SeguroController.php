<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Seguro;
use App\Models\SegurosPlane;
use App\Models\Ubigeo;
use App\Models\TablaMaestra;

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
		$p[]=$request->denominacion;
		$p[]=$request->estado;          
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

        $tablaMaestra_model = new TablaMaestra;
		$tipo_municipalidad = $tablaMaestra_model->getMaestroByTipo(43);
       
        $tipo_comision = $tablaMaestra_model->getMaestroByTipo(24);
        
        $PlanSeguro_Model = new SegurosPlane;

        //$plan_seguro=$PlanSeguro_Model->listar_plan($id);
        $plan_seguro=$PlanSeguro_Model::where('id_seguro', $id)->get()->all();
       //$result_ubicacion = UbicacionTrabajo::where('ubicacion_empresa_id', $request->empresa_id)->get()->all();
        //print_r ($plan_seguro);
        //exit();
		
        $ubigeo_model = new Ubigeo;
		$departamento = $ubigeo_model->getDepartamento("PER");

		$provincia = "";
		$distrito = "";

		//print_r ($departamento);
		//exit();

		

		//print_r ($unidad_trabajo);exit();

		return view('frontend.seguro.modal_seguro',compact('id','seguro','plan_seguro'));

    }

    public function send_municipalidad(Request $request){
		$id_user = Auth::user()->id;

        //print_r ($id_user);exit();
        
		if($request->id == 0){
			$municipalidad = new Seguroe;
		}else{
			$municipalidad =Seguroe::find($request->id);
		}
		
		$municipalidad->denominacion = $request->denominacion;
	
		//$municipalidad->estado = $request->estado_;
        $municipalidad->id_tipo_municipalidad = $request->tipo_municipalidad;
		$municipalidad->id_usuario_inserta = $id_user;
        
        

		$municipalidad->save();
			
    }
    
    public function eliminar_municipalidad($id,$estado)
    {
		$municipalidad = Seguroe::find($id);
		$municipalidad->estado = $estado;
		$municipalidad->save();

		echo $municipalidad->id;

    }
}



