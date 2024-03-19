<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Beneficiario;
use App\Models\Empresa;
use App\Models\Persona;
use App\Models\Concepto;
use App\Models\TablaMaestra;
use App\Models\Valorizacione;
use Carbon\Carbon;
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
		$p[]=$request->ruc;
        $p[]=$request->dni;
		$p[]=$request->agremiado;
		$p[]=$request->razon_social;
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

    public function modal_beneficiario_($id){
		
        $persona = new Persona();
        $empresa = new Empresa();
        $beneficiario = new Beneficiario();
        $concepto_model = new Concepto();
        $tablaMaestra_model = new TablaMaestra;

        if($id>0){
			$beneficiario = Beneficiario::find($id);
            $id_persona = $beneficiario->id_persona;
            $persona = Persona::find($id_persona);
            $id_empresa = $beneficiario->id_empresa;
            $empresa = Empresa::find($id_empresa);
            
		}else{
			$persona = new Persona();
            $empresa = new Empresa();
            $beneficiario = new Beneficiario();
		}

        $concepto = $concepto_model->getConceptoAllDenominacion();
        $estado_concepto = $tablaMaestra_model->getMaestroByTipo(120);
        
        
        //$empresa = $empresa_model->getEmpresaId();
        //$empresa_beneficiario = $beneficiario_model->getBeneficiarioId();
       
		//$beneficiario = new Beneficiario;
		//$valorizacion = $valorizaciones_model->getValorizacionFactura($id);
		return view('frontend.beneficiario.modal_beneficiario_',compact('persona','empresa'/*,'id_persona','id_agremiado','tipo_documento'*/,'beneficiario','concepto','estado_concepto'));
	
	}

    public function send_beneficiario(Request $request){
		
		$id_user = Auth::user()->id;

		if($request->id == 0){
			$beneficiario = new Beneficiario;
            //$persona = new Persona;
		}else{
			$beneficiario = Beneficiario::find($request->id);
		}
		$persona = Persona::where("numero_documento",$request->dni)->where("estado","1")->first();
        $empresa = Empresa::where("ruc",$request->ruc)->where("estado","1")->first();
        $concepto = Concepto::find($request->concepto);

		$beneficiario->id_persona = $persona->id;
		$beneficiario->id_empresa = $empresa->id;
        $beneficiario->id_concepto = $request->concepto;
        $beneficiario->estado_beneficiario = $request->estado_beneficiario;
        $beneficiario->observacion = $request->observacion;
		$beneficiario->id_usuario_inserta = $id_user;
		$beneficiario->save();

        $id_beneficiario = $beneficiario->id;
		
		if($request->estado_beneficiario==1){
		
			//$beneficiario = Beneficiario::find($request->id_beneficiario);
			
			$valorizacion = new Valorizacione;
			$valorizacion->id_modulo = 9;
			$valorizacion->pk_registro = $id_beneficiario;
            $valorizacion->id_empresa = $empresa->id;
			$valorizacion->id_concepto = $concepto->id;
			$valorizacion->id_persona = $persona->id;
			$valorizacion->monto = $concepto->importe;
			$valorizacion->id_moneda = $concepto->id_moneda;
			$valorizacion->fecha = Carbon::now()->format('Y-m-d');
			$valorizacion->fecha_proceso = Carbon::now()->format('Y-m-d');
			$valorizacion->descripcion = $concepto->denominacion ." - ". $persona->nombres." ". $persona->apellido_paterno." ". $persona->apellido_materno;
			//$valorizacion->estado = 1;
			//print_r($valorizacion->descripcion).exit();
			$valorizacion->id_usuario_inserta = $id_user;
			$valorizacion->save();
			
		}else{
		
			$valorizaciones = Valorizacione::where("pk_registro",$request->id)->where("id_modulo", "9")->where("estado","1")->first();
			if(isset($valorizaciones->id)){
				$id_valorizaciones = $valorizaciones->id;
				$valorizacion = Valorizacione::find($id_valorizaciones);
				$valorizacion->estado = 0;
				$valorizacion->save();
			}
		}
        
    }

    public function eliminar_beneficiario($id,$estado)
    {
		$beneficiario = Beneficiario::find($id);
		$valorizaciones = Valorizacione::where("pk_registro",$id)->where("id_modulo", "9")->where("estado","1")->first();

		//$multa = Multa::find($id);
		//print_r($agremiadoMulta->id).exit();

		$id_valorizaciones = $valorizaciones->id;
		$valorizacion = Valorizacione::find($id_valorizaciones);
		$valorizacion->estado = $estado;
		//print_r($id_valorizaciones).exit();
		$beneficiario->estado = $estado;
		$beneficiario->save();
		$valorizacion->save();

		echo $beneficiario->id;
    }

}
