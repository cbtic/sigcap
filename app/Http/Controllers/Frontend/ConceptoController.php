<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Concepto;
use App\Models\TipoConcepto;
use App\Models\Regione;
use App\Models\TablaMaestra;
use Auth;

class ConceptoController extends Controller
{
    function consulta_concepto(){

		$tablaMaestra_model = new TablaMaestra;
		$concepto = new Concepto;
        $tipo_afectacion = $tablaMaestra_model->getMaestroByTipo(53);
        return view('frontend.concepto.all',compact('tipo_afectacion','concepto'));

    }
	
	public function __construct(){

		$this->middleware(function ($request, $next) {
			if(!Auth::check()) {
                return redirect('login');
            }
			return $next($request);
    	});
	}

    public function listar_concepto_ajax(Request $request){
	
		$concepto_model = new Concepto;
		$p[]="";//$request->nombre;
		$p[]="";
		$p[]=$request->denominacion;
		$p[]="";
		$p[]="";
		$p[]="";
		$p[]="";
		$p[]=$request->cuenta_contable_debe;
		$p[]=$request->cuenta_contable_al_haber1;
		$p[]=$request->cuenta_contable_al_haber2;
        $p[]=$request->partida_presupuestal;
		$p[]=$request->tipo_afectacion;
		$p[]="";
        $p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $concepto_model->listar_concepto_ajax($p);
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

	public function editar_concepto($id){
        
		$concepto = Concepto::find($id);
		$tablaMaestra_model = new TablaMaestra;
		$id_concepto = $concepto->id_concepto;
		$concepto = Concepto::find($id_concepto);
		$tipo_afectacion = $tablaMaestra_model->getMaestroByTipo(53);
		$moneda = $tablaMaestra_model->getMaestroByTipo(1);
        $concepto_model = new concepto;
		
		return view('frontend.concepto.create',compact('id','regional','codigo','tipo_concepto','denominacion','importe','moneda','periodo','cuenta_contable_debe','cuenta_contable_al_haber1','cuenta_contable_al_haber2','partida_presupuestal','tipo_afectacion','estado'));
		
    }

    public function modal_concepto_nuevoConcepto($id){
		
		$concepto = new Concepto;
		$regione_model = new Regione;
		$tipoConcepto_model = new TipoConcepto;
		$tablaMaestra_model = new TablaMaestra;
		$tipo_afectacion = $tablaMaestra_model->getMaestroByTipo(53);
		$moneda = $tablaMaestra_model->getMaestroByTipo(1);

		if($id>0){
			$concepto = Concepto::find($id);
		}else{
			$concepto = new Concepto;
		}
		
		
		$tipoConcepto = $tipoConcepto_model->getTipoConceptoAll();
		$region = $regione_model->getRegionAll();
		
		return view('frontend.concepto.modal_concepto_nuevoConcepto',compact('id','tipoConcepto','concepto','region','tipo_afectacion','moneda'));
	
	}

    public function send_concepto_nuevoConcepto(Request $request){
		
		$id_user = Auth::user()->id;
		$Concepto_model = new Concepto;

		if($request->id == 0){
			$concepto = new Concepto;
			$codigo = $Concepto_model->getCodigoConcepto();
		}else{
			$concepto = Concepto::find($request->id);
			$codigo = $request->codigo;
		}
		
		$concepto->codigo = $codigo;
		$concepto->id_regional = $request->id_regional;
		$concepto->id_tipo_concepto = $request->id_tipo_concepto;
		$concepto->denominacion = $request->denominacion;
		$concepto->importe = $request->importe;
		$concepto->id_moneda = $request->id_moneda;
		$concepto->periodo = $request->periodo;
		$concepto->cuenta_contable_debe = $request->cuenta_contable_debe;
		$concepto->cuenta_contable_al_haber1 = $request->cuenta_contable_al_haber1;
		$concepto->cuenta_contable_al_haber2 = $request->cuenta_contable_al_haber2;
		$concepto->partida_presupuestal = $request->partida_presupuestal;
		$concepto->id_tipo_afectacion = $request->tipo_afectacion;
		$concepto->centro_costo = $request->centro_costo;
		$concepto->estado = 1;
		$concepto->id_usuario_inserta = $id_user;
		$concepto->save();
    }

	public function eliminar_concepto($id,$estado)
    {
		$concepto = Concepto::find($id);
		$concepto->estado = $estado;
		$concepto->save();

		echo $concepto->id;

    }
}
