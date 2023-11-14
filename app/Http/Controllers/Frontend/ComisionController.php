<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comisione;
use App\Models\TablaMaestra;
use App\Models\Municipalidade;
use App\Models\MunicipalidadIntegrada;
use App\Models\MucipalidadDetalle;
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
        //$tipo_agrupacion = $tablaMaestra_model->getMaestroByTipo(99);

        return view('frontend.comision.all',compact('comision'));
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
		$comision = new Comisione;
        //$tipo_agrupacion = $tablaMaestra_model->getMaestroByTipo(99);

        return view('frontend.comision.all',compact('comision'));
    }

    public function listar_municipalidadIntegrada_ajax(Request $request){
	
		$municipalidadIntegrada_model = new MunicipalidadIntegrada;
		$p[]=$request->denominacion;
		$p[]=$request->tipo_agrupacion;
		$p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $municipalidadIntegrada_model->listar_municipalidadIntegrada_ajax($p);
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
		$municipalidad = $municipalidade_model->getMunicipalidadAll();
        return view('frontend.comision.lista_municipalidad',compact('municipalidad'));
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
			$municipalidadIntegrada->id_periodo_comisiones = 4;
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
	
}
