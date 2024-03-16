<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Beneficiario;
use Auth;

class BeneficiarioController extends Controller
{

    public function __construct(){

		$this->middleware(function ($request, $next) {
			if(!Auth::check()) {
                return redirect('login');
            }
			return $next($request);
    	});
	}

    function consulta_beneficiario(){
        
        return view('frontend.beneficiario.all');

    }

    public function listar_beneficiario_ajax(Request $request){
	
		$beneficiario_model = new Beneficiario;
		$p[]="";
		$p[]=$request->numero_cap;
		$p[]=$request->numero_documento;
		$p[]=$request->agremiado;
        $p[]="";
		$p[]="";
		$p[]="";
		$p[]="";
		$p[]="";
		$p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $beneficiario_model->listar_beneficiario_ajax($p);
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

    public function modal_beneficiario_($periodo, $id_persona, $id_agremiado, $tipo_documento){
		
        $persona = new Persona();
        $empresa_model = new Empresa();
        $beneficiario_model = new Beneficiario();
        $empresa = $empresa_model->getEmpresaId($id_persona);
        $empresa_beneficiario = $beneficiario_model->getBeneficiarioId($empresa->id);
       
		//$beneficiario = new Beneficiario;
		//$valorizacion = $valorizaciones_model->getValorizacionFactura($id);
		return view('frontend.beneficiario.modal_beneficiario_',compact('persona','empresa','id_persona','id_agremiado','tipo_documento','empresa_beneficiario'));
	
	}

    public function send_beneficiario(Request $request){
		
		$id_user = Auth::user()->id;

		if($request->id == 0){
			$beneficiario = new Beneficiario;
		}else{
			$beneficiario = Beneficiario::find($request->id);
		}
		$persona = Persona::where("numero_documento",$request->dni)->where("estado","1")->first();
        $empresa = Empresa::where("ruc",$request->ruc)->where("estado","1")->first();

		$beneficiario->id_persona = $persona->id;
		$beneficiario->id_empresa = $empresa->id;
		$beneficiario->id_usuario_inserta = $id_user;
		$beneficiario->save();
		
    }

}
