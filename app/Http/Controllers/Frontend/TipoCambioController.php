<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TipoCambio;
use Auth;

class TipoCambioController extends Controller
{
    
    public function __construct(){

		$this->middleware(function ($request, $next) {
			if(!Auth::check()) {
                return redirect('login');
            }
			return $next($request);
    	});
	}

    function consulta_tipo_cambio(){

        return view('frontend.tipo_cambio.all');
    }

    public function listar_tipo_cambio_ajax(Request $request){
	
		$tipo_cambio_model = new TipoCambio;
		$p[]=$request->fecha;
		$p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $tipo_cambio_model->listar_tipo_cambio_ajax($p);
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

    public function modal_tipo_cambio_nuevoTipoCambio($id){
		
		$tipo_cambio = new TipoCambio;
		
		if($id>0){
			$tipo_cambio = TipoCambio::find($id);
		}else{
			$tipo_cambio = new TipoCambio;
		}
		
		//$universidad = $tablaMaestra_model->getMaestroByTipo(85);
		//$especialidad = $tablaMaestra_model->getMaestroByTipo(86);
		
		return view('frontend.tipo_cambio.modal_tipo_cambio_nuevoTipoCambio',compact('id','tipo_cambio'));
	
	}

    public function send_tipo_cambio_nuevoTipoCambio(Request $request){

		$id_user = Auth::user()->id;

		if($request->id == 0){
			$tipoCambio = new TipoCambio;
		}else{
			$tipoCambio = TipoCambio::find($request->id);
		}
		
		$tipoCambio->fecha = $request->fecha;
        $tipoCambio->valor_venta = $request->valor_venta;
        $tipoCambio->valor_compra = $request->valor_compra;
		$tipoCambio->id_usuario_inserta = $id_user;
		$tipoCambio->save();
    }

    public function eliminar_tipo_cambio($id,$estado)
    {
		$tipo_cambio = TipoCambio::find($id);
		$tipo_cambio->estado = $estado;
		$tipo_cambio->save();

		echo $tipo_cambio->id;
    }

	public function validar_fecha($fecha){

		$tipo_cambio_model = new TipoCambio;

		$tipo_cambio = $tipo_cambio_model->validarFecha($fecha);
		
		echo json_encode($tipo_cambio);

	}
}
