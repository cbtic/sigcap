<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Multa;
use Auth;

class MultaController extends Controller
{
    function consulta_multa(){
        
        return view('frontend.multa.all');

    }

    public function __construct(){

		$this->middleware(function ($request, $next) {
			if(!Auth::check()) {
                return redirect('login');
            }
			return $next($request);
    	});
	}

    public function listar_datosAgremiado_ajax(Request $request){
	
		$multa_model = new Multa;
		$p[]="";
		$p[]="";
		$p[]="";
		$p[]="";
        $p[]="";
		$p[]="";
		$p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $multa_model->listar_datosAgremiado_ajax($p);
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

    public function editar_multa($id){
        
		$multa = Multa::find($id);
		$id_multa = $multa->id_multa;
		$multa = Multa::find($id_multa);
		
        $multa_model = new empresas;
		
		return view('frontend.multa.create',compact('periodo','concepto','moneda','importe','fecha_inicio','fecha_fin','estado'));
		
    }

    public function modal_multa_nuevoMulta($id){
		
		$multa = new Multa;
		
		if($id>0){
			$multa = Multa::find($id);
		}else{
			$multa = new Multa;
		}
		
		//$universidad = $tablaMaestra_model->getMaestroByTipo(85);
		//$especialidad = $tablaMaestra_model->getMaestroByTipo(86);
		
		return view('frontend.multa.modal_multa_nuevoMulta',compact('id','multa'));
	
	}

    public function send_multa_nuevoMulta(Request $request){
		
		$id_user = Auth::user()->id;

		if($request->id == 0){
			$multa = new Multa;
		}else{
			$multa = Multa::find($request->id);
		}

		$multa->cap = $request->cap;
		$multa->periodo = $request->periodo;
		$multa->concepto = $request->concepto;
		$multa->moneda = $request->moneda;
		$multa->importe = $request->importe;
		$multa->fecha_inicio = $request->fecha_inicio;
		$multa->fecha_fin = $request->fecha_fin;
		$multa->estado = 1;
		$multa->id_usuario_inserta = $id_user;
		$multa->save();
    }

	public function eliminar_multa($id,$estado)
    {
		$multa = Multa::find($id);
		$multa->estado = $estado;
		$multa->save();

		echo $multa->id;

    }

}
