<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TipoConcepto;
use App\Models\Regione;
use Auth;

class TipoConceptoController extends Controller
{
    function consulta_tipoConcepto(){
        
        return view('frontend.tipoConcepto.all');

    }

	public function __construct(){

		$this->middleware(function ($request, $next) {
			if(!Auth::check()) {
                return redirect('login');
            }
			return $next($request);
    	});
	}

    public function listar_tipoConcepto_ajax(Request $request){
	
		$tipoConcepto_model = new TipoConcepto;
		$p[]=$request->regional;
		$p[]=$request->denominacion;
        $p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $tipoConcepto_model->listar_tipoConcepto_ajax($p);
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

	public function editar_tipoConcepto($id){
        
		$tipoConcepto = TipoConcepto::find($id);
		$id_tipoConcepto = $tipoConcepto->id_tipoConcepto;
		$tipoConcepto = TipoConcepto::find($id_tipoConcepto);
		
        $tipoConcepto_model = new TipoConcepto;
		
		return view('frontend.tipoConcepto.create',compact('id','regional','denominacion','estado'));
		
    }

	public function modal_tipoConcepto_nuevoTipoConcepto($id){
		
		$tipoConcepto = new TipoConcepto;
		$regione_model = new Regione;

		if($id>0){
			$tipoConcepto = TipoConcepto::find($id);
		}else{
			$tipoConcepto = new TipoConcepto;
		}
		
		$region = $regione_model->getRegionAll();
		
		return view('frontend.tipoConcepto.modal_tipoConcepto_nuevoTipoConcepto',compact('id','tipoConcepto','region'));
	
	}

	public function send_tipoConcepto_nuevoTipoConcepto(Request $request){
		
		$request->validate([
			'regional'=>'required',
			'denominacion'=>'required',
		]
		);

		$id_user = Auth::user()->id;

		//$tipoConcepto_model = new TipoConcepto;

		if($request->id == 0){
			$tipoConcepto = new TipoConcepto;
			//$codigo = $tipoConcepto_model->getTipoConcepto();
		}else{
			$tipoConcepto = TipoConcepto::find($request->id);
			//$codigo = $request->codigo;
		}
	
		//$tipoConcepto->codigo = $codigo;
		$tipoConcepto->id_regional = $request->regional;
		$tipoConcepto->denominacion = $request->denominacion;
		//$tipoConcepto->estado = 1;
		$tipoConcepto->id_usuario_inserta = $id_user;
		$tipoConcepto->save();
    }

	public function eliminar_tipoConcepto($id,$estado)
    {
		$tipoConcepto = TipoConcepto::find($id);
		$tipoConcepto->estado = $estado;
		$tipoConcepto->save();

		echo $tipoConcepto->id;

    }

}
