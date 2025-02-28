<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProntoPago;
use App\Models\Concepto;
use Carbon\Carbon;
use Auth;

class ProntoPagoController extends Controller
{
    public function consulta_prontoPago(){
        
		$concepto_model = new Concepto;
		$concepto = $concepto_model->getConceptoAll();
		$prontoPago = new ProntoPago;
        return view('frontend.prontoPago.all',compact('concepto','prontoPago'));

    }
	
	public function __construct(){

		$this->middleware(function ($request, $next) {
			if(!Auth::check()) {
                return redirect('login');
            }
			return $next($request);
    	});
	}

    public function listar_prontoPago_ajax(Request $request){
	
		$prontoPago_model = new ProntoPago;
		$p[]=$request->periodo;
		$p[]=$request->fecha_inicio;//$request->nombre;
		$p[]=$request->fecha_fin;
		$p[]=$request->codigo_documento;
        $p[]="";
		$p[]="";
        $p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $prontoPago_model->listar_prontoPago_ajax($p);
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

	public function editar_prontoPago($id){
        
		$prontoPago = ProntoPago::find($id);
		$id_prontoPago = $prontoPago->id_prontoPago;
		$prontoPago = ProntoPago::find($id_prontoPago);
		
        $prontoPago_model = new ProntoPago;
		
		return view('frontend.prontoPago.create',compact('periodo','fecha_inicio','fecha_fin','codigo_documento','concepto','numero_cuotas','estado'));
		
    }

    public function modal_prontoPago_nuevoProntoPago($id){
		
		$prontoPago = new ProntoPago;
		$concepto_model = new Concepto;

		if($id>0){
			$prontoPago = ProntoPago::find($id);
		}else{
			$prontoPago = new ProntoPago;
		}
		
		$concepto = $concepto_model->getConceptoAll();
		
		return view('frontend.prontoPago.modal_prontoPago_nuevoProntoPago',compact('id','prontoPago','concepto'));
	
	}

    public function send_prontoPago_nuevoProntoPago(Request $request){
		
		$request->validate([
			//'ruc'=>'required | numeric | unique | digits:11',
			'fecha_inicio'=>'required | date',
			'fecha_fin'=>'required | date',
			'numero_cuotas'=>'required | numeric',
			//'codigo_documento'=>'required',
			'id_concepto'=>'required',
		]
		);

		$id_user = Auth::user()->id;

		if($request->id == 0){
			$prontoPago = new ProntoPago;
		}else{
			$prontoPago = ProntoPago::find($request->id);
		}
		$periodo1 = date("Y", strtotime($request->fecha_inicio));
		$periodo2 = date("Y", strtotime($request->fecha_fin));
		$separacion = " - ";
		if ($periodo1 == $periodo2){
			$prontoPago->periodo = $periodo2;
		}else{
			//$prontoPago->periodo = $periodo1.$separacion.$periodo2;}
			$prontoPago->periodo = $periodo2;}
		
		$prontoPago->fecha_inicio = $request->fecha_inicio;
		$prontoPago->fecha_fin = $request->fecha_fin;
		//$prontoPago->porcentaje = $request->porcentaje;
		$prontoPago->codigo_documento = $request->codigo_documento;
		//$prontoPago->ruta_documento = $request->ruta_documento;
		$prontoPago->numero_cuotas = $request->numero_cuotas;
		$prontoPago->id_concepto = $request->id_concepto;
		/*if (date("Y", strtotime($request->fecha_inicio)) == date("Y")){
			$prontoPago->estado = 1;
		}else{
			$prontoPago->estado = 2;}
*/
		if (strtotime(date("Y-m-d")) < strtotime($request->fecha_fin) && strtotime(date("Y-m-d")) > strtotime($request->fecha_inicio)){
			$prontoPago->estado = 1;
		}else{
			$prontoPago->estado = 2;}
		
		$prontoPago->id_usuario_inserta = $id_user;
		$prontoPago->save();
    }

	public function eliminar_prontoPago($id,$estado)
    {
		$prontoPago = ProntoPago::find($id);
		$prontoPago->estado = $estado;
		$prontoPago->save();

		echo $prontoPago->id;
    }

	public function actualizarEstadoProntoPago()
	{
		$prontoPago_model = new ProntoPago;

		$prontoPago_model->actualizarActivoProntoPago();
		$prontoPago_model->actualizarInactivoProntoPago();
	}
}
