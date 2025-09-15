<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CoordinadorZonalDetalle;
use App\Models\TablaMaestra;
use App\Models\PeriodoComisione;
use App\Models\Municipalidade;
use Auth;

class CoordinadorZonalDetalleController extends Controller
{
    public function consulta_coordinador_detalle(){

        $tablaMaestra_model = new TablaMaestra;
        $periodoComisione_model = new PeriodoComisione;
        $tipo_coordinador = $tablaMaestra_model->getMaestroByTipo(117);
        $periodo = $periodoComisione_model->getPeriodoAll();
		$periodo_ultimo = PeriodoComisione::where("estado",1)->orderBy("id","desc")->first();
		$periodo_activo = PeriodoComisione::where("estado",1)->where("activo",1)->orderBy("id","desc")->first();
		

        return view('frontend.coordinador_zonal.all_coordinador_detalle',compact('tipo_coordinador','periodo','periodo_ultimo','periodo_activo'));

    }

	public function listar_coordinadorZonal_detalle_ajax(Request $request){
	
		$coordinadorZonal_detalle_model = new CoordinadorZonalDetalle;
		$p[]=$request->periodo;
		$p[]=$request->zonal;
        $p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $coordinadorZonal_detalle_model->listar_coordinadorZonal_detalle_ajax($p);
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

    public function modal_zonal_nuevoZonalDetalle($id){
		
		$coordinadorZonalDetalle = new CoordinadorZonalDetalle;
        $tablaMaestra_model = new TablaMaestra;
        $periodo_model = new PeriodoComisione;
        $municipalidad_model = new Municipalidade;

		if($id>0){
			$coordinadorZonalDetalle = CoordinadorZonalDetalle::find($id);
		}else{
			$coordinadorZonalDetalle = new CoordinadorZonalDetalle;
		}

        $periodo = $periodo_model->getPeriodoAll();
        $tipo_coordinador = $tablaMaestra_model->getMaestroByTipo(117);
        $municipalidad = $municipalidad_model->getMunicipalidadOrden();
        $periodo_ultimo = PeriodoComisione::where("activo",1)->orderBy("id","desc")->first();
		
		//$concepto = $concepto_model->getConceptoAll();
		
		return view('frontend.coordinador_zonal.modal_zonal_nuevoZonalDetalle',compact('id','coordinadorZonalDetalle','periodo','municipalidad','tipo_coordinador','periodo_ultimo'));
	
	}

    public function send_zonal_nuevoZonal(Request $request){
		
		$id_user = Auth::user()->id;

		if($request->id == 0){
			$coordinadorZonalDetalle = new CoordinadorZonalDetalle;
		}else{
			$coordinadorZonalDetalle = CoordinadorZonalDetalle::find($request->id);
		}
		
		$coordinadorZonalDetalle->id_tipo_coordinador = $request->zonal;
		$coordinadorZonalDetalle->id_municipalidad = $request->municipalidad;
		$coordinadorZonalDetalle->periodo = $request->id_periodo;
		$coordinadorZonalDetalle->id_usuario_inserta = $id_user;
		$coordinadorZonalDetalle->save();
		
    }

    public function obtener_datos_zonal_detalle($zonal,$id_periodo){

        $coordinadorZonalDetalle = new CoordinadorZonalDetalle;
        $sw = true;
        $zonal_detalle = $coordinadorZonalDetalle->getZonalDetalle($zonal,$id_periodo);
        //print_r($parentesco_lista);exit();
        return view('frontend.coordinador_zonal.lista_datos_zonal_detalle',compact('zonal_detalle'));

    }

    public function eliminar_zonal_detalle($id,$estado)
    {
		$coordinadorZonalDetalle = CoordinadorZonalDetalle::find($id);
		$coordinadorZonalDetalle->estado = $estado;
		$coordinadorZonalDetalle->save();

		echo $coordinadorZonalDetalle->id;
    }

}
