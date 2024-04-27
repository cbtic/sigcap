<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DelegadoTributo;
use App\Models\TablaMaestra;
use App\Models\Agremiado;
use Auth;

class DelegadoTributoController extends Controller
{
    public function __construct(){

		$this->middleware(function ($request, $next) {
			if(!Auth::check()) {
                return redirect('login');
            }
			return $next($request);
    	});
	}

    function consulta_delegadoTributo(){

        return view('frontend.delegadoTributo.all');
    }

    public function listar_delegadoTributo_ajax(Request $request){
	
		$delegadoTributo_model = new DelegadoTributo;
		$p[]=$request->ruc;
		$p[]="";
		$p[]=$request->razon_social;
		$p[]="";
        $p[]="";
		$p[]="";
		$p[]="";
		$p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $delegadoTributo_model->listar_delegadoTributo_ajax($p);
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

    public function modal_nuevoDelegadoTributo($id){
		
		
		$delegadoTributo = new DelegadoTributo;
        $tablaMaestra_model = new TablaMaestra;
        $agremiado_model = new Agremiado;
		
		if($id>0){
			$delegadoTributo = DelegadoTributo::find($id);
		}else{
			$delegadoTributo = new DelegadoTributo;
		}
		
        $agremiado = $agremiado_model->getAgremiadoRLAll();
        $tipo_tributo = $tablaMaestra_model->getMaestroByTipo(77);
        $bancos = $tablaMaestra_model->getMaestroByTipo(49);
        
		//$universidad = $tablaMaestra_model->getMaestroByTipo(85);
		//$especialidad = $tablaMaestra_model->getMaestroByTipo(86);
		
		return view('frontend.delegadoTributo.modal_nuevoDelegadoTributo',compact('id','delegadoTributo','tipo_tributo','bancos','agremiado'));
	
	}

    public function send_delegadoTributo(Request $request){
		
		$id_user = Auth::user()->id;

		if($request->id == 0){
			$delegadoTributo = new DelegadoTributo;
		}else{
			$delegadoTributo = DelegadoTributo::find($request->id);
		}
		
		$delegadoTributo->denominacion = $request->denominacion;
		$delegadoTributo->monto = $request->monto;
		$delegadoTributo->id_moneda = $request->moneda;
		$delegadoTributo->id_concepto = $request->concepto;
		$delegadoTributo->id_usuario_inserta = $id_user;
		$delegadoTributo->save();
		
    }

    public function eliminar_delegadoTributo($id,$estado)
    {
		$delegadoTributo = DelegadoTributo::find($id);
		$delegadoTributo->estado = $estado;
		$delegadoTributo->save();

		echo $delegadoTributo->id;
    }
}
