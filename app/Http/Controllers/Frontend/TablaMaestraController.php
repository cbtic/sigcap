<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TablaMaestra;
use Auth;

class TablaMaestraController extends Controller
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
		$this->middleware('can:Tabla Maestra')->only(['consulta_tabla_maestra']);
	}

    function consulta_tabla_maestra(){
        $tablaMaestra_model = new TablaMaestra;
        $tipo_nombre = $tablaMaestra_model->getTipoNombre();
        
        return view('frontend.tabla_maestra.all',compact('tipo_nombre'));

    }

    public function listar_tablaMaestra_ajax(Request $request){
	
		$tablaMaestra_model = new TablaMaestra;
		$p[]=$request->denominacion;
		$p[]=$request->tipo_nombre;
		$p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $tablaMaestra_model->listar_tablaMaestra_ajax($p);
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

    public function modal_tablaMaestra_nuevoTablaMaestra($id){
		
		//$id->moneda;
		$tablaMaestra_model = new TablaMaestra;
        $tipo_nombre = $tablaMaestra_model->getTipoNombre();
		
		if($id>0){
			$tablaMaestra = TablaMaestra::find($id);
		}else{
			$tablaMaestra = new TablaMaestra;
		}
		
		return view('frontend.tabla_maestra.modal_tablaMaestra_nuevoTablaMaestra',compact('id','tipo_nombre','tablaMaestra'));
	
	}

    public function send_tablaMaestra_nuevoTablaMaestra(Request $request){
		
		$id_user = Auth::user()->id;
        $tablaMaestra_model = new TablaMaestra;
		$datos_tablaMaestra = TablaMaestra::where("tipo",$request->tipo_nombre)->where("estado","1")->orderBy('id','desc')->first();
		$tipo_nombre = $datos_tablaMaestra->tipo_nombre;
        $codigo = $datos_tablaMaestra->codigo;
        $orden = $datos_tablaMaestra->orden;
        $id_ = $tablaMaestra_model->getIdTablaMaestra();
        $ultimo_id =  $id_[0]->id;

		if($request->id == 0){
			$tablaMaestra = new TablaMaestra;
			$tablaMaestra->id = intval($ultimo_id) + 1;
			$tablaMaestra->codigo = $codigo + 1;
			$tablaMaestra->orden = $orden + 1;
		}else{
			$tablaMaestra = TablaMaestra::find($request->id);
			//$tablaMaestra->id = $tablaMaestra-//intval($ultimo_id);
		}
        
		//dd($datos_tablaMaestra);

        $tablaMaestra->tipo = $request->tipo_nombre;
		$tablaMaestra->denominacion = $request->denominacion;
		$tablaMaestra->tipo_nombre = $tipo_nombre;
		$tablaMaestra->predeterminado = $request->predeterminado;
       
        $tablaMaestra->estado = 1;
		//$tablaMaestra->id_usuario_inserta = $id_user;
		$tablaMaestra->save();
		
    }

    public function eliminar_tablaMaestra($id,$estado)
    {
		$tablaMaestra = TablaMaestra::find($id);
		$tablaMaestra->estado = $estado;
		$tablaMaestra->save();

		echo $tablaMaestra->id;
    }

    public function obtener_datos_tabla_maestra($tipo_nombre){

        $tablaMaestra_model = new TablaMaestra;
        $sw = true;
        $tipo_nombre_lista = $tablaMaestra_model->getTipoTablaMaestra($tipo_nombre);
        //print_r($parentesco_lista);exit();
        return view('frontend.tabla_maestra.lista_datos_tabla_maestra',compact('tipo_nombre_lista'));

    }

}
