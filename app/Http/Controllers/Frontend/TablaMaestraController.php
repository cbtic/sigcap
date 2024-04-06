<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TablaMaestra;
use Auth;

class TablaMaestraController extends Controller
{
    public function __construct(){

		$this->middleware(function ($request, $next) {
			if(!Auth::check()) {
                return redirect('login');
            }
			return $next($request);
    	});
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
		$tablaMaestra = new TablaMaestra;
		$concepto_model = new Concepto;
		$tablaMaestra_model = new TablaMaestra;

        $moneda = $tablaMaestra_model->getMaestroByTipo(1);
		$concepto = $concepto_model->getConceptoAllDenominacion();
		
		if($id>0){
			$tablaMaestra = TablaMaestra::find($id);
		}else{
			$tablaMaestra = new TablaMaestra;
		}
		
		return view('frontend.tabla_maestra.modal_tablaMaestra_nuevoTablaMaestra',compact('id','moneda','multa','concepto'));
	
	}

    public function send_tablaMaestra_nuevoTablaMaestra(Request $request){
		
		$id_user = Auth::user()->id;

		if($request->id == 0){
			$tablaMaestra = new TablaMaestra;
		}else{
			$tablaMaestra = TablaMaestra::find($request->id);
		}
		
		$tablaMaestra->denominacion = $request->denominacion;
		$tablaMaestra->monto = $request->monto;
		$tablaMaestra->id_moneda = $request->moneda;
		$tablaMaestra->id_concepto = $request->concepto;
		$tablaMaestra->id_usuario_inserta = $id_user;
		$tablaMaestra->save();
		
    }

    public function eliminar_tablaMaestra($id,$estado)
    {
		$tablaMaestra = TablaMaestra::find($id);
		$tablaMaestra->estado = $estado;
		$tablaMaestra->save();

		echo $tablaMaestra->id;
    }

}
