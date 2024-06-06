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
use App\Models\Agremiado;
use App\Models\AgremiadoRole;
use App\Models\ConcursoPuesto;
use App\Models\Concurso;
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
		$periodoComisione_model = new PeriodoComisione;
		$municipalidadIntegrada = new Comisione;
		$municipalidadIntegrada2 = new MunicipalidadIntegrada;
		//$tablaMaestra_model = new TablaMaestra;
        $tipo_comision = $tablaMaestra_model->getMaestroByTipo(102);
		$periodo = $periodoComisione_model->getPeriodoAll();
		$periodo_ultimo = PeriodoComisione::where("estado",1)->orderBy("id","desc")->first();
		$periodo_activo = PeriodoComisione::where("estado",1)->where("activo",1)->orderBy("id","desc")->first();
		$periodoComision = $periodoComision_model->getPeriodoComisionAll();
		$tipoAgrupacion = $tablaMaestra_model2->getMaestroByTipo(99);
		$periodo_ultimo = PeriodoComisione::where("estado",1)->orderBy("id","desc")->first();
        //$tipo_agrupacion = $tablaMaestra_model->getMaestroByTipo(99);

        return view('frontend.comision.all',compact('comision','periodoComision','periodo_ultimo','periodo_activo','tipo_comision','municipalidadIntegrada','tipoAgrupacion','periodo_ultimo'));
    }
	
	function lista_comision(){
		
		$periodoComisione_model = new PeriodoComisione;
		$tablaMaestra_model = new TablaMaestra;
		
		$periodo = $periodoComisione_model->getPeriodoAll();
		$tipoAgrupacion = $tablaMaestra_model->getMaestroByTipo(99);
		$tipoComision = $tablaMaestra_model->getMaestroByTipo(102);
		$periodo_ultimo = PeriodoComisione::where("estado",1)->orderBy("id","desc")->first();
		$periodo_activo = PeriodoComisione::where("estado",1)->where("activo",1)->orderBy("id","desc")->first();
		
        return view('frontend.comision.all_listar_comision_nuevo',compact('periodo','tipoAgrupacion','tipoComision','periodo_ultimo','periodo_activo'));
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
	
	public function lista_comision_nuevo_ajax(Request $request){
	
		$comision_model = new Comisione();
		$p[]=$request->id_periodo;
		$p[]=$request->tipo_agrupacion;
		$p[]=$request->tipo_comision;
		$p[]=$request->id_comision;
		$p[]=$request->estado;      
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $comision_model->lista_comision_nuevo_ajax($p);
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
		$periodoComisione_model = new PeriodoComisione;
		$tablaMaestra_model = new TablaMaestra;
		
		$comision = $comision_model->getComisionAll("","","","1");
		
		if($id>0){
			$comision_=Comisione::find($id);
			$periodo_ = PeriodoComisione::find($comision_->id_periodo_comisiones);
			$tipo_comision_ = TablaMaestra::where("codigo",$comision_->id_tipo_comision)->where("tipo",102)->first();
			$comisionDelegado = ComisionDelegado::where("id_comision",$id)->where("estado","1")->get();
			$concurso_inscripcion = $comisionDelegado_model->getConcursoInscripcionAll($comision_->id_periodo_comisiones,$comision_->id_tipo_comision);
		}else{ 
			$comisionDelegado = new ComisionDelegado;
			$periodo_ = NULL;
			$tipo_comision_ = NULL;
			$concurso_inscripcion = $comisionDelegado_model->getConcursoInscripcionAll(0,0);
		}
		
		
		$region = $regione_model->getRegionAll();
		
		$periodo = $periodoComisione_model->getPeriodoVigenteAll();
		$periodo_ultimo = PeriodoComisione::where("estado",1)->orderBy("id","desc")->first();
		$periodo_activo = PeriodoComisione::where("estado",1)->where("activo",1)->orderBy("id","desc")->first();
		
		
		$tipo_comision = $tablaMaestra_model->getMaestroByTipo(102);
		//$tipo_comision = TablaMaestra::where("codigo",$comision_->id_tipo_comision)->where("tipo",102)->first();
		
		return view('frontend.comision.modal_asignar_delegado',compact('id','comisionDelegado','comision','concurso_inscripcion','region','periodo','periodo_','tipo_comision','tipo_comision_','periodo_ultimo','periodo_activo'));

    }
	
	public function obtener_comision_periodo_tipo_comision($id_periodo,$id_tipo_comision){
			
		$comision_model = new Comisione;
		$comision = $comision_model->getComisionByPeriodoAndTipComision($id_periodo,$id_tipo_comision);
		echo json_encode($comision);
		
	}
	
	public function obtener_concurso_inscripcion_periodo_tipo_comision($id_periodo,$id_tipo_comision){
			
		$comisionDelegado_model = new ComisionDelegado;
		$concurso_inscripcion = $comisionDelegado_model->getConcursoInscripcionAll($id_periodo,$id_tipo_comision);
		echo json_encode($concurso_inscripcion);
		
	}
	
	public function modal_asignar_delegado_comision($id){
		
		$id_user = Auth::user()->id;
		
		$regione_model = new Regione;
		$comision_model = new Comisione;
		$comisionDelegado_model = new ComisionDelegado;
		
		$comision = $comision_model->getComisionAll("","","","1");
		
		if($id>0){
			$comision_=Comisione::find($id);
			//$comisionDelegado = ComisionDelegado::find($id);
			$periodo = PeriodoComisione::find($comision_->id_periodo_comisiones);
			//$tipo_comision = TablaMaestra::find($comision_->id_tipo_comision);
			$tipo_comision = TablaMaestra::where("codigo",$comision_->id_tipo_comision)->where("tipo",102)->first();
			$comisionDelegado = ComisionDelegado::where("id_comision",$id)->where("estado","1")->get();
			
			$municipalidadIntegrada = MunicipalidadIntegrada::find($comision_->id_municipalidad_integrada);
			$id_tipo_agrupacion = $municipalidadIntegrada->id_tipo_agrupacion;
			//$comisionDelegado = null;
		}else{ 
			$comisionDelegado = new ComisionDelegado;
			$periodo = NULL;
			$tipo_comision = NULL;
			$id_tipo_agrupacion = NULL;
			//$comisionDelegado = NULL;
		}

		$concurso_inscripcion = $comisionDelegado_model->getConcursoInscripcionAll($comision_->id_periodo_comisiones,$comision_->id_tipo_comision);
		$region = $regione_model->getRegionAll();
		
		return view('frontend.comision.modal_asignar_delegado_comision',compact('id','comisionDelegado','comision','concurso_inscripcion','region','periodo','tipo_comision','id_tipo_agrupacion'/*,'comisionDelegado'*/));

    }
	
	public function send_delegado(Request $request){
		$id_user = Auth::user()->id;
		
		if($request->id == 0){
			
			if($request->id_comision_delegado_1==0){
			
				$comisionDelegado = new ComisionDelegado;
				$coordinador = 0;
				if($request->coordinador == 1)$coordinador = 1;
				$concursoInscripcion = ConcursoInscripcione::find($request->id_concurso_inscripcion);
				$comisionDelegado->id_regional = $request->id_regional;
				$comisionDelegado->id_comision = $request->id_comision;
				$comisionDelegado->coordinador = $coordinador;
				$comisionDelegado->id_agremiado = $concursoInscripcion->id_agremiado;
				//$comisionDelegado->id_puesto = $concursoInscripcion->puesto;
				$comisionDelegado->id_puesto = 1;
				$comisionDelegado->id_usuario_inserta = $id_user;
				$comisionDelegado->save();
				
			}else{
				$coordinador = 0;
				if($request->coordinador == 1)$coordinador = 1;
				$concursoInscripcion1 = ConcursoInscripcione::find($request->id_concurso_inscripcion);
				$comisionDelegado1 = ComisionDelegado::find($request->id_comision_delegado_1);
				$comisionDelegado1->id_agremiado = $concursoInscripcion1->id_agremiado;
				$comisionDelegado1->coordinador = $coordinador;
				$comisionDelegado1->id_puesto = 1;
				$comisionDelegado1->save();
			}
			
			if($request->id_comision_delegado_2==0){
			
				if(isset($request->id_concurso_inscripcion2) && $request->id_concurso_inscripcion2>0){
					
					$comisionDelegado2 = new ComisionDelegado;
					$coordinador = 0;
					if($request->coordinador == 2)$coordinador = 1;
					$concursoInscripcion2 = ConcursoInscripcione::find($request->id_concurso_inscripcion2);
					$comisionDelegado2->id_regional = $request->id_regional;
					$comisionDelegado2->id_comision = $request->id_comision;
					$comisionDelegado2->coordinador = $coordinador;
					$comisionDelegado2->id_agremiado = $concursoInscripcion2->id_agremiado;
					//$comisionDelegado2->id_puesto = $concursoInscripcion2->puesto;
					$comisionDelegado2->id_puesto = 2;
					$comisionDelegado2->estado = 1;
					$comisionDelegado2->id_usuario_inserta = $id_user;
					$comisionDelegado2->save();
					
				}
				
			}else{
				$coordinador = 0;
				if($request->coordinador == 2)$coordinador = 1;
				$concursoInscripcion2 = ConcursoInscripcione::find($request->id_concurso_inscripcion2);
				$comisionDelegado2 = ComisionDelegado::find($request->id_comision_delegado_2);
				$comisionDelegado2->id_agremiado = $concursoInscripcion2->id_agremiado;
				$comisionDelegado2->coordinador = $coordinador;
				$comisionDelegado2->id_puesto = 2;
				$comisionDelegado2->save();
			}
			
			
		}else{
			//$comisionDelegado = ComisionDelegado::find($request->id_comision_delegado_1);
			
			if($request->id_comision_delegado_1==0){
				$comisionDelegado = new ComisionDelegado;
				$coordinador = 0;
				if($request->coordinador == 1)$coordinador = 1;
				$concursoInscripcion1 = ConcursoInscripcione::find($request->id_concurso_inscripcion);
				$comisionDelegado->id_regional = $request->id_regional;
				$comisionDelegado->id_comision = $request->id_comision;
				$comisionDelegado->coordinador = $coordinador;
				$comisionDelegado->id_agremiado = $concursoInscripcion1->id_agremiado;
				//$comisionDelegado->id_puesto = $concursoInscripcion1->puesto;
				$comisionDelegado->id_puesto = 1;
				$comisionDelegado->estado = 1;
				$comisionDelegado->id_usuario_inserta = $id_user;
				$comisionDelegado->save();
			}else{
				$coordinador = 0;
				if($request->coordinador == 1)$coordinador = 1;
				$concursoInscripcion1 = ConcursoInscripcione::find($request->id_concurso_inscripcion);
				$comisionDelegado1 = ComisionDelegado::find($request->id_comision_delegado_1);
				$comisionDelegado1->id_agremiado = $concursoInscripcion1->id_agremiado;
				$comisionDelegado1->coordinador = $coordinador;
				$comisionDelegado1->id_puesto = 1;
				$comisionDelegado1->save();
			}
			
			if($request->id_comision_delegado_2==0){
				
				if(isset($request->id_concurso_inscripcion2)){
				
					$comisionDelegado2 = new ComisionDelegado;
					$coordinador = 0;
					if($request->coordinador == 2)$coordinador = 1;
					$concursoInscripcion2 = ConcursoInscripcione::find($request->id_concurso_inscripcion2);
					$comisionDelegado2->id_regional = $request->id_regional;
					$comisionDelegado2->id_comision = $request->id_comision;
					$comisionDelegado2->coordinador = $coordinador;
					$comisionDelegado2->id_agremiado = $concursoInscripcion2->id_agremiado;
					//$comisionDelegado2->id_puesto = $concursoInscripcion2->puesto;
					$comisionDelegado2->id_puesto = 2;
					$comisionDelegado2->estado = 1;
					$comisionDelegado2->id_usuario_inserta = $id_user;
					$comisionDelegado2->save();
					
				}
				
			}else{
				$coordinador = 0;
				if($request->coordinador == 2)$coordinador = 1;
				$concursoInscripcion2 = ConcursoInscripcione::find($request->id_concurso_inscripcion2);
				$comisionDelegado2 = ComisionDelegado::find($request->id_comision_delegado_2);
				$comisionDelegado2->id_agremiado = $concursoInscripcion2->id_agremiado;
				$comisionDelegado2->coordinador = $coordinador;
				$comisionDelegado2->id_puesto = 2;
				$comisionDelegado2->save();
			}
			
		}
		
		
			
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

	function obtener_municipalidadesIntegradas($periodo,$tipo_agrupacion,$tipo_comision){ 

		if ($tipo_agrupacion == "0")$tipo_agrupacion ="";

        $municipalidadIntegrada_model = new MunicipalidadIntegrada;
		$municipalidad_integradas = $municipalidadIntegrada_model->getMunicipalidadIntegradaAll($periodo,$tipo_agrupacion,$tipo_comision);
        return view('frontend.comision.lista_municipalidadIntegrada',compact('municipalidad_integradas'));
    }
	
	public function modal_municipalidadesIntegrada($id){
		
		$id_user = Auth::user()->id;
		
		$municipalidade_model = new Municipalidade;
		$municipalidad = $municipalidade_model->getMunicipalidadAll();
		
		return view('frontend.comision.modal_municipalidadIntegrada',compact('id','municipalidad'));

    }
	
	function obtener_municipalidadesIntegradaDetalle($id){

        $municipalidadIntegrada_model = new MunicipalidadIntegrada;
		$mucipalidad_detalles = $municipalidadIntegrada_model->getMunicipalidadDetalleById($id);
        return view('frontend.comision.lista_municipalidad_detalle',compact('mucipalidad_detalles'));
    }
	
	function obtener_comision($periodo,$tipo_comision,$cad_id,$estado){

		if ($estado == "-9")$estado ="";
		if ($cad_id == "0")$cad_id ="";

        $comision_model = new Comisione;
		$comision = $comision_model->getComisionAll($periodo,$tipo_comision,$cad_id,$estado);
        return view('frontend.comision.lista_comision',compact('comision'));
    }
	
	public function send_municipalidad_detalle(Request $request){
	
		$id_user = Auth::user()->id;
		$denominacion = "";
		
		$mucipalidadDetalle = new MucipalidadDetalle();
		$mucipalidadDetalle->id_municipalidad = $request->id_municipalidad;
		$mucipalidadDetalle->id_municipalidad_integrada = $request->id_municipalidad_integrada;
		$mucipalidadDetalle->id_usuario_inserta = $id_user;
		$mucipalidadDetalle->save();
		
		$municipalidadIntegrada = MunicipalidadIntegrada::find($request->id_municipalidad_integrada);
		
		$mucipalidadDetalle = MucipalidadDetalle::where("id_municipalidad_integrada",$request->id_municipalidad_integrada)->where("estado","1")->orderBy("id","asc")->get();
		
		foreach($mucipalidadDetalle as $row){		
			$municipalidad = Municipalidade::find($row->id_municipalidad);
			$denominacion .= $municipalidad->denominacion." - ";
		}
		
		$denominacion = substr($denominacion,0,strlen($denominacion)-3);
		$municipalidadIntegrada->denominacion=$denominacion; 
		$municipalidadIntegrada->save();
		
		$comision = Comisione::where("id_municipalidad_integrada",$request->id_municipalidad_integrada)->where("estado","1")->first();
		$comision->denominacion=$denominacion; 
		$comision->save();
		
	}
	
	public function eliminar_municipalidad_detalle($id)
    {
		$mucipalidadDetalle = MucipalidadDetalle::find($id);
		$mucipalidadDetalle->estado = 0;
		$mucipalidadDetalle->save();
		
		$mucipalidadDetalles = MucipalidadDetalle::where("id_municipalidad_integrada",$mucipalidadDetalle->id_municipalidad_integrada)->where("estado","1")->orderBy("id","asc")->get();
		
		$denominacion = "";
		
		foreach($mucipalidadDetalles as $row){		
			$municipalidad = Municipalidade::find($row->id_municipalidad);
			$denominacion .= $municipalidad->denominacion." - ";
		}
		
		$denominacion = substr($denominacion,0,strlen($denominacion)-3);
		
		$municipalidadIntegrada = MunicipalidadIntegrada::find($mucipalidadDetalle->id_municipalidad_integrada);
		$municipalidadIntegrada->denominacion=$denominacion; 
		$municipalidadIntegrada->save();
		
		$comision = Comisione::where("id_municipalidad_integrada",$mucipalidadDetalle->id_municipalidad_integrada)->where("estado","1")->first();
		$comision->denominacion=$denominacion; 
		$comision->save();
		
		echo $mucipalidadDetalle->id;
    }
	
	public function send_comision(Request $request){
		
		//print_r($request->periodo).exit();
		$id_user = Auth::user()->id;
		$sw = true;
		//$msg = "";

		$municipalidades = $request->check_;
		$denominacion = "";
		
		/*******************/
		$obs = "";
		$arrayMunicipalidad = array();
		$municipalidadIntegrada_model = new MunicipalidadIntegrada();
		foreach($municipalidades as $row){	
			$municipalidad = Municipalidade::find($row);
			//$denominacion .= $municipalidad->denominacion." - ";
			$municipalidadIntegrada = MunicipalidadIntegrada::where("id_periodo_comision",$request->periodo)->where("id_tipo_comision",$request->tipo_comision)->where("denominacion",$municipalidad->denominacion)->where("estado","1")->first();
			if($municipalidadIntegrada){
				$obs .= $municipalidad->denominacion.",";
				$arrayMunicipalidad[] = $municipalidad->denominacion;
			}
			
			$municipalidadIntegrada2 = $municipalidadIntegrada_model->getMunicipalidadDetalle($request->periodo,$request->tipo_comision,$municipalidad->denominacion);
			if($municipalidadIntegrada2){
				if(!in_array($municipalidad->denominacion, $arrayMunicipalidad)){
					$obs .= $municipalidad->denominacion.",";
				}
			}
			
		}
		
		if(strlen($obs)>1)$obs=substr($obs,0,-1);	
		
		/*******************/
		
		if($obs==""){
		
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
					$municipalidadIntegrada->id_tipo_comision = $request->tipo_comision;
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
		
		}
		
		$array["obs"] = $obs;
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
				$comision->id_dia_semana = ($request->dia_semana>0)?$request->dia_semana:398;
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
				$comision->id_dia_semana = ($request->dia_semana>0)?$request->dia_semana:398;
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

	public function modalDiaSemana($id){
		
		//$comision = Comisione::find($id);
		$comision_model = new Comisione;
		$comision = new Comisione;
		//$comision = $comision_model->id_comision;
		//$comision = $comision_model->getDiaComisionAll();
		$tablaMaestra_model = new TablaMaestra;
		//$comision = $comision_model
		$dia_semana = $tablaMaestra_model->getMaestroByTipo(70);
		
		return view('frontend.comision.modalDiaSemana',compact('id','dia_semana','comision'));

    }

	public function send_dia_semana(Request $request){

		$id_user = Auth::user()->id;
		//print_r($request->dia_semana).exit();
		if($request->id == 0){
			$comision = new Comisione;
		}else{
			$comision = Comisione::find($request->id);
		}
		
		$comision->id_dia_semana = $request->dia_semana;
		
		$comision->save();
    }

	public function eliminar_muniIntegrada($id,$estado)
    {
		$municipalidadesIntegrada = MunicipalidadIntegrada::find($id);
		$municipalidadesIntegrada->estado = $estado;
		$municipalidadesIntegrada->save();

		echo $municipalidadesIntegrada->id;
    }

	public function eliminarComision($id,$estado)
    {
		$comision = Comisione::find($id);
		$comision->estado = $estado;
		$comision->save();

		echo $comision->id;
    }
	
	public function send_asignar_agremiado_rol2(){
	
		$id_user = Auth::user()->id;
		
		$comision = Comisione::where("id_periodo_comisiones",9)->where("id_tipo_comision",1)->where("estado","1")->get();
		//$comision = Comisione::where("id_periodo_comisiones",9)->where("id_tipo_comision",1)->where("estado","1")->where("id",3761)->get();
		
		foreach($comision as $row){
		
			$comisionDelegado = ComisionDelegado::where("id_comision",$row->id)->where("estado","1")->orderBy("id","desc")->get();
			
			foreach($comisionDelegado as $key2=>$row2){
				
				if($key2==0)$rol_especifico = 1;
				else $rol_especifico = 2;
				
				$concursoInscripcion_model = new ConcursoInscripcione;
				$concursoInscripciones = $concursoInscripcion_model->getConcursoInscripcionByIdAgremiadoIdPeriodoIdSubTipoConcurso($row2->id_agremiado,9,1);
				$concursoInscripcion = ConcursoInscripcione::find($concursoInscripciones->id);
				$concursoInscripcion->puesto = $rol_especifico;
				$concursoInscripcion->save();
				
			}
		}
		
		$comisionDelegado_model = new ComisionDelegado;
		$concurso_inscripcion = $comisionDelegado_model->getConcursoInscripcionSinPuesto(9,1);
		
		foreach($concurso_inscripcion as $key3=>$row3){
			$concursoInscripcion = ConcursoInscripcione::find($row3->id);
			$concursoInscripcion->puesto = 12;
			$concursoInscripcion->save();
		}
		
		/*
		foreach($comision as $row){
		
			$concurso_inscripcion = $comisionDelegado_model->getConcursoInscripcionNotDelegado(9,1,$row->id);
			
			foreach($concurso_inscripcion as $key3=>$row3){
				echo $row->id."|".$row3->id;
				echo "<br>";				
				$concursoInscripcion = ConcursoInscripcione::find($row3->id);
				$concursoInscripcion->puesto = 12;
				$concursoInscripcion->save();
			}
			
		}
		*/
		
	}
	
	public function send_asignar_agremiado_rol(Request $request){
		
		$id_user = Auth::user()->id;
		
		$comision = Comisione::where("id_periodo_comisiones",$request->periodo)->where("id_tipo_comision",$request->tipo_comision)->where("estado","1")->get();
		
		$subtipoConcurso = TablaMaestra::where("codigo",$request->tipo_comision)->where("tipo",93)->first();
		$id_tipo_concurso = $subtipoConcurso->sub_codigo;
		$concurso = Concurso::where("id_periodo",$request->periodo)->where("id_sub_tipo_concurso",$request->tipo_comision)->where("estado","1")->first();
		
		foreach($comision as $row){
		
			$comisionDelegado_model = new ComisionDelegado;
			//$comisionDelegado = ComisionDelegado::where("id_comision",$row->id)->where("estado","1")->orderBy("id","desc")->get();
			$comisionDelegado = $comisionDelegado_model->getComisionDelegadoByComisionAndPeriodo($row->id,$request->periodo);
			
			foreach($comisionDelegado as $key2=>$row2){
				
				//if($key2==0)$rol_especifico = 1;
				//else $rol_especifico = 2;
				 
				$rol_especifico = $row2->id_puesto; 
				
				$concursoInscripcion_model = new ConcursoInscripcione;
				$concursoInscripciones = $concursoInscripcion_model->getConcursoInscripcionByIdAgremiadoIdPeriodoIdSubTipoConcurso($row2->id_agremiado,$request->periodo,$request->tipo_comision); 
				
				if($concursoInscripciones){
					
					/*
					if($concursoInscripciones->id==56){
						echo $rol_especifico."|";
						echo $row->id."|";
					}
					*/
					
					$concursoInscripcion = ConcursoInscripcione::find($concursoInscripciones->id);
					$concursoInscripcion->puesto = $rol_especifico;
					$concursoInscripcion->save();
					
					$agremiadoRoleExiste = AgremiadoRole::where("id_agremiado",$concursoInscripcion->id_agremiado)->where("rol",$id_tipo_concurso)->where("rol_especifico",$rol_especifico)->where("id_periodo",$request->periodo)->first();
					
					if($agremiadoRoleExiste){
						
					}else{
					
						$agremiadoRol = new AgremiadoRole; 
						$agremiadoRol->id_agremiado = $concursoInscripcion->id_agremiado;
						$agremiadoRol->rol = $id_tipo_concurso;
						$agremiadoRol->rol_especifico = $rol_especifico;///
						$agremiadoRol->fecha_inicio = $concurso->fecha_acreditacion_inicio;
						$agremiadoRol->fecha_fin = $concurso->fecha_acreditacion_fin;
						$agremiadoRol->id_periodo = $request->periodo;
						$agremiadoRol->estado = 1;
						$agremiadoRol->id_usuario_inserta = $id_user;
						$agremiadoRol->save();
						
					}
					
				}
				
			}
		}
		
		
		$comisionDelegado_model = new ComisionDelegado;
		$concurso_inscripcion = $comisionDelegado_model->getConcursoInscripcionSinPuesto($request->periodo,$request->tipo_comision);
		
		foreach($concurso_inscripcion as $key3=>$row3){
			$concursoInscripcion = ConcursoInscripcione::find($row3->id);
			$concursoInscripcion->puesto = 12;
			$concursoInscripcion->save();
			
			$agremiadoRoleExiste = AgremiadoRole::where("id_agremiado",$concursoInscripcion->id_agremiado)->where("rol",$id_tipo_concurso)->where("rol_especifico",12)->where("id_periodo",$request->periodo)->first();
				
			if($agremiadoRoleExiste){
				
			}else{
			
				$agremiadoRol = new AgremiadoRole; 
				$agremiadoRol->id_agremiado = $concursoInscripcion->id_agremiado;
				$agremiadoRol->rol = $id_tipo_concurso;
				$agremiadoRol->rol_especifico = 12;///
				$agremiadoRol->fecha_inicio = $concurso->fecha_acreditacion_inicio;
				$agremiadoRol->fecha_fin = $concurso->fecha_acreditacion_fin;
				$agremiadoRol->id_periodo = $request->periodo;
				$agremiadoRol->estado = 1;
				$agremiadoRol->id_usuario_inserta = $id_user;
				$agremiadoRol->save();
				
			}
			
		}
	
	}
	
	public function send_asignar_agremiado_rol___(Request $request){
		
		$id_user = Auth::user()->id;
		$comisionDelegado_model = new ComisionDelegado;
		
		$subtipoConcurso = TablaMaestra::where("codigo",$request->tipo_comision)->where("tipo",93)->first();
		$id_tipo_concurso = $subtipoConcurso->sub_codigo;
		
		$comision = Comisione::where("id_periodo_comisiones",$request->periodo)->where("id_tipo_comision",$request->tipo_comision)->where("estado","1")->get();
		
		$concurso = Concurso::where("id_periodo",$request->periodo)->where("id_sub_tipo_concurso",$request->tipo_comision)->where("estado","1")->first();
		
		foreach($comision as $row){
			
			$comisionDelegado = ComisionDelegado::where("id_comision",$row->id)->where("estado","1")->orderBy("id","desc")->get();
			
			foreach($comisionDelegado as $key2=>$row2){
				
				if($key2==0)$rol_especifico = 1;
				else $rol_especifico = 2;
					
				$agremiadoRoleExiste = AgremiadoRole::where("id_agremiado",$row2->id_agremiado)->where("rol",$id_tipo_concurso)->where("rol_especifico",$rol_especifico)->first();
				
				if($agremiadoRoleExiste){
					
					$agremiadoRol_model = new AgremiadoRole;
					$agremiadoRol_model->updatePuestoConcursoInscripcion($row2->id_agremiado,$concurso->id,$rol_especifico);
					
				}else{
				
					$agremiadoRol = new AgremiadoRole; 
					$agremiadoRol->id_agremiado = $row2->id_agremiado;
					$agremiadoRol->rol = $id_tipo_concurso;
					$agremiadoRol->rol_especifico = $rol_especifico;///
					$agremiadoRol->fecha_inicio = $concurso->fecha_acreditacion_inicio;
					$agremiadoRol->fecha_fin = $concurso->fecha_acreditacion_fin;
					$agremiadoRol->id_periodo = $request->periodo;
					$agremiadoRol->estado = 1;
					$agremiadoRol->id_usuario_inserta = $id_user;
					$agremiadoRol->save();
					
					$agremiadoRol_model = new AgremiadoRole;
					$agremiadoRol_model->updatePuestoConcursoInscripcion($row2->id_agremiado,$concurso->id,$rol_especifico);
					
				}
				
			}
			
			
		}
		
		foreach($comision as $row){
			
			$concurso_inscripcion = $comisionDelegado_model->getConcursoInscripcionAll($request->periodo,$request->tipo_comision);	
			
			foreach($concurso_inscripcion as $key2=>$row2){
				/*
				if($row2->puesto==""){
					echo $row2->puesto."|";
				}
				*/
				$rol_especifico = 12;
				
				$agremiadoRoleExiste2 = AgremiadoRole::where("id_agremiado",$row2->id_agremiado)->where("rol",$id_tipo_concurso)->first();
				
				if($agremiadoRoleExiste2){
					//echo "1";
					//$agremiadoRol_model = new AgremiadoRole;
					//$agremiadoRol_model->updatePuestoConcursoInscripcion($row2->id_agremiado,$concurso->id,$rol_especifico);
						
				}else{
					$agremiadoRol = new AgremiadoRole;
					$agremiadoRol->id_agremiado = $row2->id_agremiado;
					$agremiadoRol->rol = $id_tipo_concurso;
					$agremiadoRol->rol_especifico = $rol_especifico;
					$agremiadoRol->fecha_inicio = $row2->fecha_acreditacion_inicio;
					$agremiadoRol->fecha_fin = $row2->fecha_acreditacion_fin;
					$agremiadoRol->id_periodo = $request->periodo;
					$agremiadoRol->estado = 1;
					$agremiadoRol->id_usuario_inserta = $id_user;
					$agremiadoRol->save();
					
					//$agremiadoRol_model = new AgremiadoRole;
					//$agremiadoRol_model->updatePuestoConcursoInscripcion($row2->id_agremiado,$concurso->id,$rol_especifico);
					
				}
			
			}
			
			
		}
		
	
	}
	
	
}
