<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Parametro;
use Auth;

class ParametrosController extends Controller
{
    public function __construct(){
		/*
		$this->middleware(function ($request, $next) {
			if(!Auth::check()) {
                return redirect('login');
            }
			return $next($request);
    	});
		*/

		$this->middleware('auth');
		$this->middleware('can:Parametros')->only(['consulta_parametro']);
	}

    function consulta_parametro(){

        return view('frontend.parametro.all');
    }

    public function listar_parametro_ajax(Request $request){
	
		$parametro_model = new Parametro;
		$p[]=$request->anio;
        $p[]="";
        $p[]="";
        $p[]="";
        $p[]="";
		$p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $parametro_model->listar_parametro_ajax($p);
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

    public function editar_parametro($id){
        
		$parametro = Parametro::find($id);
		$id_parametro = $parametro->id_parametro;
        //$anio = $parametro->anio;
        $parametro = Parametro::find($id_profesion);
		
		return view('frontend.parametro.create',compact('anio','porcentaje_calculo_edificacion','valor_metro_cuadrado_habilitacion_urbana','valor_uit','igv','parametro','estado'));
		
    }

    public function modal_parametro_nuevoParametro($id){
		
		$parametro = new Parametro;
		
		if($id>0){
			$parametro = Parametro::find($id);
		}else{
			$parametro = new Parametro;
		}
		
		//$universidad = $tablaMaestra_model->getMaestroByTipo(85);
		//$especialidad = $tablaMaestra_model->getMaestroByTipo(86);
		
		return view('frontend.parametro.modal_parametro_nuevoParametro',compact('id','parametro'));
	
	}

    public function send_parametro_nuevoParametro(Request $request){
		
		/*$request->validate([
			'nombre'=>'required',
		]
		);*/

		$id_user = Auth::user()->id;

		if($request->id == 0){
			$parametro = new Parametro;
			$parametro->id_usuario_inserta = $id_user;
		}else{
			$parametro = Parametro::find($request->id);
			$parametro->id_usuario_actualiza = $id_user;
		}
		
		$parametro->anio = $request->anio;
        $parametro->porcentaje_calculo_edificacion = $request->porcentaje_calculo_edificacion;
        $parametro->valor_metro_cuadrado_habilitacion_urbana = $request->valor_metro_cuadrado_habilitacion_urbana;
		$parametro->valor_minimo_edificaciones = $request->valor_minimo_edificaciones;
        $parametro->valor_uit = $request->valor_uit;
		$parametro->valor_minimo_hu = $request->valor_minimo_hu;
		$parametro->valor_maximo_hu = $request->valor_maximo_hu;
        $parametro->igv = $request->igv;
		$parametro->monto_minimo_rh = $request->valor_rh;
		$parametro->save();
    }

	public function eliminar_parametro($id,$estado)
    {
		$id_user = Auth::user()->id;

		$parametro = Parametro::find($id);
		$parametro->estado = $estado;
		$parametro->id_usuario_actualiza = $id_user;
		$parametro->save();

		echo $parametro->id;
    }

}
