<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PlanContable;
use App\Models\TablaMaestra;
use Auth;

class PlanContableController extends Controller
{
    public function importar_plan_contable(){ 
	
		$ch = curl_init('http://webservice.limacap.org:8080/webservices.php?op=plancontable');		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json'
		));
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		
		$resultWebApi = curl_exec($ch);
		
		if($errno = curl_errno($ch)) {
			$error_message = curl_strerror($errno);
			echo "cURL error ({$errno}):\n {$error_message}";
		}
		
		$dataWebApi = json_decode($resultWebApi);
		
		foreach($dataWebApi as $row){
			//print_r($row);
			$CUENTA = trim($row->CUENTA);
			$planContableExiste = PlanContable::where("cuenta",$CUENTA)->where("estado",1)->get();
			
			if(count($planContableExiste)==0){
				$planContable = new PlanContable;
				$planContable->cuenta = $CUENTA;
				$planContable->denominacion = $row->NOMBRE;
				$planContable->estado = 1;
				$planContable->id_usuario_inserta = 1;
				$planContable->save();
				
			}
			
		}
	
	}

	public function __construct(){

		$this->middleware(function ($request, $next) {
			if(!Auth::check()) {
                return redirect('login');
            }
			return $next($request);
    	});
	}

	function consulta_plan_contable(){

        return view('frontend.plan_contable.all');
    }

    public function listar_plan_contable_ajax(Request $request){
	
		$plan_contable_model = new PlanContable;
		$p[]=$request->denominacion;
		$p[]=$request->cuenta;
		$p[]="";
		$p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $plan_contable_model->listar_plan_contable_ajax($p);
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

    public function modal_plan_contable_nuevoPlanContable($id){
		
		$plan_contable = new PlanContable;
		$tablaMaestra_model = new TablaMaestra;

		$tipo_plan_contable = $tablaMaestra_model->getMaestroByTipo(21);
		
		if($id>0){
			$plan_contable = PlanContable::find($id);
		}else{
			$plan_contable = new PlanContable;
		}
		
		//$universidad = $tablaMaestra_model->getMaestroByTipo(85);
		//$especialidad = $tablaMaestra_model->getMaestroByTipo(86);
		
		return view('frontend.plan_contable.modal_planContable_nuevoPlanContable',compact('id','plan_contable','tipo_plan_contable'));
	
	}

    public function send_plan_contable_nuevoPlanContable(Request $request){
		
		/*$request->validate([
			'nombre'=>'required',
		]
		);*/

		$id_user = Auth::user()->id;

		if($request->id == 0){
			$plan_contable = new PlanContable;
			$plan_contable->id_usuario_inserta = $id_user;
		}else{
			$plan_contable = PlanContable::find($request->id);
			$plan_contable->id_usuario_actualiza = $id_user;
		}
		
		$plan_contable->denominacion = $request->denominacion;
		$plan_contable->cuenta = $request->cuenta;
		$plan_contable->id_tipo = $request->tipo_plan_contable;
		//$profesion->estado = 1;
		$plan_contable->save();
    }

	public function eliminar_plan_contable($id,$estado)
    {

		$id_user = Auth::user()->id;

		$plan_contable = PlanContable::find($id);
		$plan_contable->estado = $estado;
		$plan_contable->id_usuario_actualiza = $id_user;
		$plan_contable->save();

		echo $plan_contable->id;
    }
}
