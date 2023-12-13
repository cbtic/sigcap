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
use App\Models\ComisionDelegado;
use App\Models\Regione;
use App\Models\ConcursoInscripcione;
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
		$tablaMaestra_model2 = new TablaMaestra;
		$comision = new Comisione;
		$periodoComision_model = new PeriodoComisione;
		$municipalidadIntegrada = new Comisione;
		$municipalidadIntegrada2 = new MunicipalidadIntegrada;
		//$tablaMaestra_model = new TablaMaestra;
        $tipo_comision = $tablaMaestra_model->getMaestroByTipo(102);
		$periodoComision = $periodoComision_model->getPeriodoComisionAll();
		$tipoAgrupacion = $tablaMaestra_model2->getMaestroByTipo(99);
		
        //$tipo_agrupacion = $tablaMaestra_model->getMaestroByTipo(99);

        return view('frontend.comision.all',compact('comision','periodoComision','tipo_comision','municipalidadIntegrada','tipoAgrupacion'));
    }
	
	function lista_comision(){
		
		$periodoComisione_model = new PeriodoComisione;
		$tablaMaestra_model = new TablaMaestra;
		
		$periodo = $periodoComisione_model->getPeriodoAll();
		$tipoAgrupacion = $tablaMaestra_model->getMaestroByTipo(99);
		
        return view('frontend.comision.all_listar_comision',compact('periodo','tipoAgrupacion'));
    }
	
	public function lista_comision_ajax(Request $request){
	
		$comision_model = new Comisione(); 
		$p[]=$request->id_periodo;
		$p[]=$request->tipo_agrupacion;
		$p[]=$request->id_comision;
		$p[]=$request->estado;      
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $comision_model->lista_comision_ajax($p);
		$iTotalDisplayRecords = isset($data[0]->totalrows)?$data[0]->totalrows:0;

		$result["PageStart"] = $request->NumeroPagina;
		$result["pageSize"] = $request->NumeroRegistros;
		$result["SearchText"] = "";
		$result["ShowChildren"] = true;
		$result["iTotalRecords"] = $iTotalDisplayRecords;
		$result["iTotalDisplayRecords"] = $iTotalDisplayRecords;
		$result["aaData"] = $data;

        //print_r(json_encode($result)); exit();
		echo json_encode($result);

	
	}
	
	public function modal_asignar_delegado($id){
		
		$id_user = Auth::user()->id;
		
		$regione_model = new Regione;
		$comision_model = new Comisione;
		$comisionDelegado_model = new ComisionDelegado;
		
		$comision = $comision_model->getComisionAll("","","1");
		if($id>0) $comisionDelegado = ComisionDelegado::find($id);else $comisionDelegado = new ComisionDelegado;

		$concurso_inscripcion = $comisionDelegado_model->getConcursoInscripcionAll();
		$region = $regione_model->getRegionAll();
		
		return view('frontend.comision.modal_asignar_delegado',compact('id','comisionDelegado','comision','concurso_inscripcion','region'));

    }
	
	public function send_delegado(Request $request){
		$id_user = Auth::user()->id;
		
		if($request->id == 0){
			$comisionDelegado = new ComisionDelegado;
			$comisionDelegado2 = new ComisionDelegado;
		}else{
			$comisionDelegado = ComisionDelegado::find($request->id);
		}
		
		$coordinador = 0;
		if($request->coordinador == 1)$coordinador = 1;
		$concursoInscripcion = ConcursoInscripcione::find($request->id_concurso_inscripcion);
		$comisionDelegado->id_regional = $request->id_regional;
		$comisionDelegado->id_comision = $request->id_comision;
		$comisionDelegado->coordinador = $coordinador;
		$comisionDelegado->id_agremiado = $concursoInscripcion->id_agremiado;
		$comisionDelegado->id_puesto = $concursoInscripcion->puesto_postula;
		//$comisionDelegado->estado = 1;
		$comisionDelegado->id_usuario_inserta = $id_user;
		$comisionDelegado->save();
		
		$coordinador = 0;
		if($request->coordinador == 2)$coordinador = 1;
		$concursoInscripcion2 = ConcursoInscripcione::find($request->id_concurso_inscripcion2);
		$comisionDelegado2->id_regional = $request->id_regional;
		$comisionDelegado2->id_comision = $request->id_comision;
		$comisionDelegado2->coordinador = $coordinador;
		$comisionDelegado2->id_agremiado = $concursoInscripcion2->id_agremiado;
		$comisionDelegado2->id_puesto = $concursoInscripcion2->puesto_postula;
		$comisionDelegado2->estado = 1;
		$comisionDelegado2->id_usuario_inserta = $id_user;
		$comisionDelegado2->save();
			
    }
	
	public function obtener_comision_delegado($id){
	
		$comisionDelegado_model = new ComisionDelegado;
		$delegado = $comisionDelegado_model->getComisionDelegadoByComision($id);
		echo json_encode($delegado);
	
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

		$municipalidadIntegrada = new Comisione;
        $tablaMaestra_model = new TablaMaestra;
        $tipo_comision = $tablaMaestra_model->getMaestroByTipo(102);
		

        return view('frontend.comision.all',compact('municipalidadIntegrada','tipo_comision'));
    }

    public function listar_municipalidad_integrada_ajax(Request $request){
	
		$municipalidadIntegrada_model = new MunicipalidadIntegrada;
		$p[]=$request->denominacion;
		$p[]=$request->tipo_agrupacion;
		$p[]="";
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

	function consulta_comision_integrada(){

		$tablaMaestra_model = new TablaMaestra;
		$municipalidadIntegrada = new Comisione;
		$municipalidadIntegrada2 = new MunicipalidadIntegrada;
		$tipoAgrupacion = $tablaMaestra_model2->getMaestroByTipo(99);
        //$tablaMaestra_model = new TablaMaestra;
		$comision = new Comisione;
		//$periodoComision_model = new PeriodoComisione;

		//$periodoComision = $periodoComision_model->getPeriodoComisionAll();
		
        //$tipo_agrupacion = $tablaMaestra_model->getMaestroByTipo(99);

        return view('frontend.comision.all',compact('comision','tipoAgrupacion','municipalidadIntegrada2','municipalidadIntegrada'));
    }

    public function listar_comision_integrada_ajax(Request $request){
	
		$comisionIntegrada_model = new Comisione;
		$p[]=$request->denominacion;
		$p[]=$request->tipo_agupacion;
		$p[]=$request->movilidad;
		$p[]=$request->comision;
		$p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $empresa_model->listar_comision_integrada_ajax($p);
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

	function obtener_municipalidadesIntegradas($periodo,$tipo_agrupacion){

		if ($tipo_agrupacion == "0")$tipo_agrupacion ="";

        $municipalidadIntegrada_model = new MunicipalidadIntegrada;
		$municipalidad_integradas = $municipalidadIntegrada_model->getMunicipalidadIntegradaAll($periodo,$tipo_agrupacion);
        return view('frontend.comision.lista_municipalidadIntegrada',compact('municipalidad_integradas'));
    }

	function obtener_comision($tipo_comision,$cad_id,$estado){

		if ($estado == "-9")$estado ="";
		if ($cad_id == "0")$cad_id ="";

        $comision_model = new Comisione;
		$comision = $comision_model->getComisionAll($tipo_comision,$cad_id,$estado);
        return view('frontend.comision.lista_comision',compact('comision'));
    }
	
	public function send_comision(Request $request){

		//print_r($request->periodo).exit();
		$id_user = Auth::user()->id;
		$sw = true;
		//$msg = "";

		$municipalidades = $request->check_;
		$denominacion = "";
		foreach($municipalidades as $row){	
			$municipalidad = Municipalidade::find($row);
			$denominacion .= $municipalidad->denominacion." - ";
		}

		if($denominacion!=""){

			if($request->periodo!="")
			{
				$denominacion = substr($denominacion,0,strlen($denominacion)-3);
		
				$municipalidadIntegrada = new MunicipalidadIntegrada();
				$municipalidadIntegrada->denominacion = $denominacion;
				$municipalidadIntegrada->id_vigencia = 374;
				if(count($municipalidades)>1){
					$municipalidadIntegrada->id_tipo_agrupacion = 1;
				}else{
					$municipalidadIntegrada->id_tipo_agrupacion = 2;}
				/*}*/
				
				$municipalidadIntegrada->id_regional = 5;
				$municipalidadIntegrada->id_periodo_comision = $request->periodo;
				//$municipalidadIntegrada->id_coodinador = 1;
				$municipalidadIntegrada->id_usuario_inserta = $id_user;

				$municipalidadIntegrada->save();
				$id_municipalidad_integrada = $municipalidadIntegrada->id;
	
				foreach($municipalidades as $row){	
					$mucipalidadDetalle = new MucipalidadDetalle();
					$mucipalidadDetalle->id_municipalidad = $row;
					$mucipalidadDetalle->id_municipalidad_integrada = $id_municipalidad_integrada;
					$mucipalidadDetalle->id_usuario_inserta = $id_user;
					//$mucipalidadDetalle->estado = "1";
					$mucipalidadDetalle->save();
				}
			}
			else {
				$sw = false;
				//$msg = "Debe ingresar el periodo !!!";
			}
		}
		$array["sw"] = $sw;
			//$array["msg"] = $msg;
			echo json_encode($array);

    }

	public function send_municipalidad_integrada(Request $request){
		
		$id_user = Auth::user()->id;
		$comisione_model = new Comisione();
		/*$municipalidadesIntegradas = $request->check_;
		$municipalidadIntegrada = MunicipalidadIntegrada::find($row);
		$denominacion = $municipalidadIntegrada->denominacion;
		$denominacion = "";
		foreach($municipalidadIntegrada as $row){
			$municipalidadesIntegradas = MunicipalidadIntegrada::find($row);
			$denominacion = $municipalidadesIntegradas->denominacion;
		}*/
/*
		if($denominacion!=""){

			$denominacion = substr($denominacion,0,strlen($denominacion)-3);
		*/
				//$municipalidad = new Municipalidade();
				//$denominacion=$municipalidad->denominacion;
			//$municipalidadesIntegradas = $request->denominacion;
			$municipalidadesIntegradas = $request->check_;
			$tipoComision = $request->tipo_comision;
			//print_r($tipoComision).exit();
		$denominacion = "";
		foreach($municipalidadesIntegradas as $row){
			$municipalidadesIntegrada = MunicipalidadIntegrada::find($row);
			$denominacion .= $municipalidadesIntegrada->denominacion." - ";
		}
			//$id = $municipalidadesIntegradas->id;
			//$id_tipo_agrupacion = $municipalidadesIntegradas->id_tipo_agrupacion;
			//$id_periodo_comisiones = $municipalidadesIntegradas->id_periodo_comisiones;
			//$id_regionale = $municipalidadesIntegradas->id_regional;
		
			//print_r($id_regional).exit();
			if($denominacion!="" && $tipoComision = 1){
			
				$comision_desc = "";
				
				
				$comision_desc = "COMISION ".$comisione_model->getCodigoComision($municipalidadesIntegrada->id);
				//echo $comision;
				$denominacion = substr($denominacion,0,strlen($denominacion)-3);
				$comision = new Comisione();
				$comision->id_regional = $municipalidadesIntegrada->id_regional;
				$comision->id_periodo_comisiones = $municipalidadesIntegrada->id_periodo_comision;
				$comision->id_tipo_comision = $request->tipo_comision;
				//$comision->id_dia_semana = 1;
				$comision->denominacion = $denominacion;
				$comision->comision = $comision_desc;
				$comision->id_municipalidad_integrada = $municipalidadesIntegrada->id;
				$comision->id_usuario_inserta = $id_user;
				$comision->estado = "1";
				$comision->save();
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
			}else if($denominacion!="" && $tipoComision = 2){
				$comision_desc = "";
				
				
				$comision_desc = "COMISION ".$comisione_model->getCodigoComision($municipalidadesIntegrada->id);
				//echo $comision;
				$denominacion = substr($denominacion,0,strlen($denominacion)-3);
				$comision = new Comisione();
				$comision->id_regional = $municipalidadesIntegrada->id_regional;
				$comision->id_periodo_comision = $municipalidadesIntegrada->id_periodo_comisiones;
				$comision->id_tipo_comision = $request->tipo_comision;
				//$comision->id_dia_semana = 1;
				$comision->denominacion = $denominacion;
				$comision->comision = $comision_desc;
				$comision->id_municipalidad_integrada = $municipalidadesIntegrada->id;
				$comision->id_usuario_inserta = $id_user;
				//$comision->estado = "1";
				$comision->save();
			}

    }

	public function send_comisiones_integradas(Request $request){
		
		$id_user = Auth::user()->id;

		$comision = $request->check_;
		/*$denominacion = "";
		foreach($municipalidades as $row){	
			$municipalidad = Municipalidade::find($row);
			$denominacion .= $municipalidad->denominacion." - ";
		}*/

		/*if($denominacion!=""){

			$denominacion = substr($denominacion,0,strlen($denominacion)-3);
		*/
			$comision = new MunicipalidadIntegrada();
			$comision->id_regional = 5;
			$comision->id_periodo_comision = 7;
			$comision->id_tipo_comision = 1;
			//$comision->id_dia_semana = 1;
			$comision->denominacion = $request->denominacion;
			//$comision->observacion = ;
			$comision->id_usuario_inserta = $id_user;
			//$comision->estado = "1";
			$comision->save();
			//$id_municipalidad_integrada = $municipalidadIntegrada->id;
/*
			foreach($municipalidades as $row){	
				$mucipalidadDetalle = new MucipalidadDetalle();
				$mucipalidadDetalle->id_municipalidad = $row;
				$mucipalidadDetalle->id_municipalidad_integrada = $id_municipalidad_integrada;
				$mucipalidadDetalle->id_usuario_inserta = $id_user;
				$mucipalidadDetalle->estado = "1";
				$mucipalidadDetalle->save();
			}
		}*/

    }

	public function modal_dia_semana($id){
		
		$comision_model = new Comisione;
		$tablaMaestra_model = new TablaMaestra;
		$tipoAgrupacion = $tablaMaestra_model2->getMaestroByTipo(99);

		
		return view('frontend.comision.modal_asignar_delegado',compact('id','comisionDelegado','comision','concurso_inscripcion','region'));

    }
	
}
