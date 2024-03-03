<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CoordinadorZonal;
use App\Models\Regione;
use App\Models\PeriodoComisione;
use App\Models\Agremiado;
use App\Models\Persona;
use App\Models\TablaMaestra;
use App\Models\Municipalidade;
use Auth;

class CoordinadorZonalController extends Controller
{
    public function __construct(){

		$this->middleware(function ($request, $next) {
			if(!Auth::check()) {
                return redirect('login');
            }
			return $next($request);
    	});
	}

    public function consulta_coordinadorZonal(){
        
		$coordinadorZonal_model = new CoordinadorZonal;
        $agremiado = new Agremiado;
        $coordinador_zonal = new CoordinadorZonal;
        $persona = new Persona;
        $periodo_model = new PeriodoComisione;
        $region_model = new Regione;
		$region = $region_model->getRegionAll();
        $periodo = $periodo_model->getPeriodoVigenteAll();

		//$prontoPago = new ProntoPago;
        return view('frontend.coordinador_zonal.all',compact('coordinador_zonal','region','periodo','agremiado','persona'));

    }

    public function listar_coordinadorZonal_ajax(Request $request){
	
		$coordinadorZonal_model = new CoordinadorZonal;
		$p[]="";//$request->nombre;
		$p[]="";
        $p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $coordinadorZonal_model->listar_coordinadorZonal_ajax($p);
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

    public function modal_coordinadorZonal_nuevoCoordinadorZonal($id){
		
		$coordinadorZonal = new CoordinadorZonal;
        $tablaMaestra_model = new TablaMaestra;
        $periodo_model = new PeriodoComisione;
        $agremiado_model = new Agremiado;
        $municipalidad_model = new Municipalidade;
		//$concepto_model = new Concepto;

		if($id>0){
			$coordinadorZonal = CoordinadorZonal::find($id);
            $agremiado = Agremiado::where("id",$coordinadorZonal->id_agremiado)->where("estado","1")->first();
            //$agremiado_model = Agremiado::find($id);
		}else{
			$coordinadorZonal = new CoordinadorZonal;
		}

        $periodo = $periodo_model->getPeriodoVigenteAll();
        $mes = $tablaMaestra_model->getMaestroByTipo(116);
        $estado_sesion = $tablaMaestra_model->getMaestroByTipo(109);
        $municipalidad = $municipalidad_model->getMunicipalidadOrden();
		
		//$concepto = $concepto_model->getConceptoAll();
		
		return view('frontend.coordinador_zonal.modal_coordinadorZonal_nuevoCoordinadorZonal',compact('id','agremiado','coordinadorZonal','periodo','mes','municipalidad','estado_sesion'));
	
	}

    public function send_coordinador_zonal_nuevoCoordinadorZonal(Request $request){
		
		$id_user = Auth::user()->id;
		$agremiado = Agremiado::where("numero_cap",$request->numero_cap)->where("estado","1")->first();
		$mensaje = "";
		
		if($agremiado){
				
            $coordinadorZonal_model = new CoordinadorZonal;
            
            $coordinadorZonal = new CoordinadorZonal;
            $coordinadorZonal->id_regional = $request->regional;
            $coordinadorZonal->id_periodo = $request->periodo;
            $coordinadorZonal->id_agremiado = $agremiado->id;
            $coordinadorZonal->id_comision = "1";
            $coordinadorZonal->id_muni_inte = "1";
            $coordinadorZonal->id_mes = "1";
            //$coordinadorZonal->estado = 1;
            $coordinadorZonal->id_usuario_inserta = $id_user;
            $coordinadorZonal->save();

		}else{
			$mensaje = "El Numero de CAP no existe";
		}
		
		$result["mensaje"] = $mensaje;
		echo json_encode($result);
		
	}
    
}
