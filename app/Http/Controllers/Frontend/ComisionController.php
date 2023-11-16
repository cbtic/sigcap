<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comisione;
use App\Models\TablaMaestra;
use App\Models\Municipalidade;
use App\Models\MunicipalidadIntegrada;
use App\Models\MucipalidadDetalle;
use App\Models\PeriodoComisione;
use Auth;

class ComisionController extends Controller
{
    public function __construct(){

		$this->middleware(function ($request, $next) {
			if(!Auth::check()) {
                return redirect('login');
            }
			return $next($request);
    	});
	}

    function consulta_comision(){

        $tablaMaestra_model = new TablaMaestra;
		$comision = new Comisione;
		$periodoComision_model = new PeriodoComisione;

		$periodoComision = $periodoComision_model->getPeriodoComisionAll();
		
        //$tipo_agrupacion = $tablaMaestra_model->getMaestroByTipo(99);

        return view('frontend.comision.all',compact('comision','periodoComision'));
    }

    public function listar_comision_ajax(Request $request){
	
		$empresa_model = new Comisione;
		$p[]=$request->denominacion;
		$p[]=$request->tipo_municipalidad;
		$p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $empresa_model->listar_comision_ajax($p);
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

	function consulta_municipalidadIntegrada(){

        $tablaMaestra_model = new TablaMaestra;
		$municipalidadIntegrada = new Comisione;
        //$tipo_agrupacion = $tablaMaestra_model->getMaestroByTipo(99);

        return view('frontend.comision.all',compact('municipalidadIntegrada'));
    }

    public function listar_municipalidad_integrada_ajax(Request $request){
	
		$municipalidadIntegrada_model = new MunicipalidadIntegrada;
		$p[]=$request->denominacion;
		$p[]=$request->tipo_agrupacion;
		$p[]="";
		$p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $municipalidadIntegrada_model->listar_municipalidad_integrada_ajax($p);
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

	
	function obtener_municipalidades(){

        $municipalidade_model = new Municipalidade;
		$periodoComision_model = new PeriodoComisione;
		$municipalidad = $municipalidade_model->getMunicipalidadAll();
		$periodoComision = $periodoComision_model->getPeriodoComisionAll();
        return view('frontend.comision.lista_municipalidad',compact('municipalidad','periodoComision'));
    }

	function obtener_municipalidadesIntegradas(){

        $municipalidadIntegrada_model = new MunicipalidadIntegrada;
		$municipalidad_integradas = $municipalidadIntegrada_model->getMunicipalidadIntegradaAll();
        return view('frontend.comision.lista_municipalidadIntegrada',compact('municipalidad_integradas'));
    }

	public function send_comision(Request $request){

		
		$id_user = Auth::user()->id;
		

		$municipalidades = $request->check_;
		$denominacion = "";
		foreach($municipalidades as $row){	
			$municipalidad = Municipalidade::find($row);
			$denominacion .= $municipalidad->denominacion." - ";
		}

		if($denominacion!=""){

			$denominacion = substr($denominacion,0,strlen($denominacion)-3);
		
			$municipalidadIntegrada = new MunicipalidadIntegrada();
			$municipalidadIntegrada->denominacion = $denominacion;
			$municipalidadIntegrada->id_vigencia = 374;
			$municipalidadIntegrada->id_tipo_agrupacion = 1;
			$municipalidadIntegrada->id_regional = 5;
			$municipalidadIntegrada->id_periodo_comisiones = $request->periodo;
			$municipalidadIntegrada->id_coodinador = 1;
			$municipalidadIntegrada->id_usuario_inserta = $id_user;
			$municipalidadIntegrada->estado = "1";
			$municipalidadIntegrada->save();
			$id_municipalidad_integrada = $municipalidadIntegrada->id;

			foreach($municipalidades as $row){	
				$mucipalidadDetalle = new MucipalidadDetalle();
				$mucipalidadDetalle->id_municipalidad = $row;
				$mucipalidadDetalle->id_municipalidad_integrada = $id_municipalidad_integrada;
				$mucipalidadDetalle->id_usuario_inserta = $id_user;
				$mucipalidadDetalle->estado = "1";
				$mucipalidadDetalle->save();
			}
		}

    }

	public function send_municipalidad_integrada(Request $request){
		
		$id_user = Auth::user()->id;
		
		$municipalidadesIntegradas = $request->check_;
		//$municipalidadIntegrada = MunicipalidadIntegrada::find($row);
		//$denominacion = $municipalidadIntegrada->denominacion;
		$denominacion = "";
		foreach($municipalidadIntegrada as $row){	
			$municipalidadIntegrada = MunicipalidadIntegrada::find($row);
			$denominacion = $municipalidadIntegrada->denominacion;
		}
/*
		if($denominacion!=""){

			$denominacion = substr($denominacion,0,strlen($denominacion)-3);
		*/
			$comisiones = new Comisione();
			$comisiones->id_regional = 5;
			$comisiones->id_periodo_comisiones = 8;
			$comisiones->id_tipo_comision = 1;
			$comisiones->id_dia_semana = 1;
			$comisiones->denominacion = $denominacion;
			$comisiones->id_usuario_inserta = $id_user;
			$comisiones->estado = "1";
			$comisiones->save();
			//$id_municipalidad_integrada = $municipalidadIntegrada->id;

			/*foreach($municipalidades as $row){	
				$mucipalidadDetalle = new MucipalidadDetalle();
				$mucipalidadDetalle->id_municipalidad = $row;
				$mucipalidadDetalle->id_municipalidad_integrada = $id_municipalidad_integrada;
				$mucipalidadDetalle->id_usuario_inserta = $id_user;
				$mucipalidadDetalle->estado = "1";
				$mucipalidadDetalle->save();
			}*/
		/*}*/

    }
	
}
