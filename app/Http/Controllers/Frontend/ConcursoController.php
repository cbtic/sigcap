<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Agremiado;
use App\Models\Regione;
use App\Models\Concurso;
use App\Models\ConcursoPuesto;
use App\Models\ConcursoInscripcione;
use App\Models\ConcursoRequisito;
use App\Models\InscripcionDocumento;
use App\Models\Comprobante;
use App\Models\TablaMaestra;
use App\Models\Concepto;
use App\Models\Valorizacione;
use App\Models\PeriodoComisione;
use App\Models\AgremiadoRole;
use Carbon\Carbon;
use Auth;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromArray;
use stdClass;
use ZipArchive;

class ConcursoController extends Controller
{
	public function __construct(){

		$this->middleware(function ($request, $next) {
			if(!Auth::check()) {
                return redirect('login');
            }
			return $next($request);
    	});
	}

    function index(){
		
		$tablaMaestra_model = new TablaMaestra;
		$periodoComisione_model = new PeriodoComisione;
		
		$tipo_concurso = $tablaMaestra_model->getMaestroByTipo(101);
		$periodo = $periodoComisione_model->getPeriodoAll();
		$periodo_ultimo = PeriodoComisione::where("estado",1)->orderBy("id","desc")->first();
		$periodo_activo = PeriodoComisione::where("estado",1)->where("activo",1)->orderBy("id","desc")->first();
		
        return view('frontend.concurso.all',compact('tipo_concurso','periodo','periodo_ultimo','periodo_activo'));
    }
	
	public function consulta_resultado(){
		
		//$regione_model = new Regione;
		$tablaMaestra_model = new TablaMaestra;
		$concurso_model = new Concurso();
		
		//$region = $regione_model->getRegionAll();
		$situacion_cliente = $tablaMaestra_model->getMaestroByTipo(14);
		$concurso = $concurso_model->getConcurso();
		
		return view('frontend.concurso.all_resultado',compact(/*'region',*/'situacion_cliente','concurso'));
		
	}
	
	public function listar_resultado_ajax(Request $request){
	
		$concursoInscripcione_model = new ConcursoInscripcione();
		$p[]=$request->id_concurso;
		$p[]=$request->numero_documento;
		$p[]="";
		$p[]=$request->agremiado;
		$p[]=$request->numero_cap;
		$p[]=$request->id_regional;
		$p[]=$request->id_situacion;
		$p[]=$request->id_estado;
		$p[]="t1.id";
		$p[]="desc";
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $concursoInscripcione_model->listar_concurso_agremiado($p);
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
	
	public function create(){
		
		$agremiado_model = new Agremiado();
		$concurso_model = new Concurso();
		$regione_model = new Regione;
		$tablaMaestra_model = new TablaMaestra;
		
		$id_persona = Auth::user()->id_persona;
		//echo $id_user;
		//$concurso = $concurso_model->getConcursoVigente();
		$agremiado = $agremiado_model->getAgremiadoByIdPersona($id_persona);
		$concurso = $concurso_model->getConcursoVigentePendienteByAgremiado($agremiado->id);
		$concursoTotal = $concurso_model->getConcurso();
		$documento_pendiente = $concurso_model->getInscripcionDocumentoPendienteByAgremiado($agremiado->id);
		$region = $regione_model->getRegionAll();
		$situacion_cliente = $tablaMaestra_model->getMaestroByTipo(14);
		$tipo_concurso = $tablaMaestra_model->getMaestroByTipo(101);
		
        return view('frontend.concurso.create',compact('concurso','agremiado','region','situacion_cliente','documento_pendiente','concursoTotal','tipo_concurso'));
    }
	
	
	
	 

	public function create_resultado(){
		
		$agremiado_model = new Agremiado();
		$concurso_model = new Concurso();
		//$regione_model = new Regione;
		$tablaMaestra_model = new TablaMaestra;
		$periodoComisione_model = new PeriodoComisione;
		
		//$id_persona = Auth::user()->id_persona;
		$concurso = $concurso_model->getConcurso();
		$concurso_ultimo = Concurso::where("estado",1)->orderBy("id","desc")->first();
		//$agremiado = $agremiado_model->getAgremiadoByIdPersona($id_persona);
		//$region = $regione_model->getRegionAll();
		$situacion_cliente = $tablaMaestra_model->getMaestroByTipo(14);
		
		$tipo_concurso = $tablaMaestra_model->getMaestroByTipo(101);
		$periodo = $periodoComisione_model->getPeriodoAll();
		$periodo_ultimo = PeriodoComisione::where("estado",1)->orderBy("id","desc")->first();
		$periodo_activo = PeriodoComisione::where("estado",1)->where("activo",1)->orderBy("id","desc")->first();
		
		$puesto = $concurso_model->getPuestoResultado();
		
        return view('frontend.concurso.create_resultado',compact('concurso',/*'agremiado',*//*'region',*/'situacion_cliente','concurso_ultimo','periodo','periodo_ultimo','periodo_activo','tipo_concurso','puesto'));
    }
	
	public function descargar_comprimido($numero_cap,$id_concurso){
		
		//getAgremiadoConcursoInscripcionZip
		//getConcursoInscripcionZip
		//getConcursoInscripcionDocumentoZip
		if($numero_cap==0)$numero_cap="";
		if($id_concurso==0)$id_concurso="";
		
		$concursoInscripcione_model = new ConcursoInscripcione();
		$concursoAgremiado = $concursoInscripcione_model->getAgremiadoConcursoInscripcionZip($numero_cap);
		
		$zip_path = 'agremiados.zip';
		$zip = new ZipArchive();
		
		if ($zip->open($zip_path, ZIPARCHIVE::CREATE | ZIPARCHIVE::OVERWRITE) !== TRUE) {
			die ("An error occurred creating your ZIP file.");
		}
		
		foreach($concursoAgremiado as $row1){
			$concursoInscripcion = $concursoInscripcione_model->getConcursoInscripcionZip($row1->id_agremiado,$id_concurso);
			
			/**************ZIP2****************************/
			$zip_path2 = ($row1->numero_cap).'.zip';
  			$zip2 = new ZipArchive();
			//echo $zip_path2;
			if ($zip2->open($zip_path2, ZIPARCHIVE::CREATE | ZIPARCHIVE::OVERWRITE) !== TRUE) {
				die ("An error occurred creating your ZIP file.");
			}
			
			foreach($concursoInscripcion as $row2){	
				$concursoInscripcionDocumento = $concursoInscripcione_model->getConcursoInscripcionDocumentoZip($row2->id);
				
				/**************ZIP3****************************/
				$zip_path3 = ($row2->periodo."-".$row2->tipo_concurso."-".$row2->sub_tipo_concurso).'.zip';
				$zip3 = new ZipArchive();
				
				if ($zip3->open($zip_path3, ZIPARCHIVE::CREATE | ZIPARCHIVE::OVERWRITE) !== TRUE) {
					die ("An error occurred creating your ZIP file.");
				}
				
				foreach($concursoInscripcionDocumento as $row3){
					$file=$row3->ruta_archivo;
					if (file_exists(public_path($file))){
						$zip3->addFile($file, basename($file));
					}
				}
				
				$zip3->close();
				
				/**************ZIP3****************************/
				
				if (file_exists(public_path($zip_path3))){
					$zip2->addFile($zip_path3, basename($zip_path3));
				}
				
			}
			
			$zip2->close();
			
			/**************ZIP2****************************/
			//echo $zip_path2;
			if (file_exists(public_path($zip_path2))){
				$zip->addFile($zip_path2, basename($zip_path2));
				//echo $zip_path2;
			}
			
		}
		
		
		
		$zip->close();
		//exit();
		return response()->download(public_path($zip_path))->deleteFileAfterSend(true);
		
	}
	public function editar_inscripcion($id){
		
		//$agremiado_model = new Agremiado();
		$concursoInscripcione_model = new ConcursoInscripcione();
		$concursoInscripcion = $concursoInscripcione_model->getConcursoInscripcionById($id);
		
		//$id_persona = Auth::user()->id_persona;
		//echo $id_user;
		//$concurso = $concurso_model->getConcurso();
		//$agremiado = $agremiado_model->getAgremiadoByIdPersona($id_persona);
		
        return view('frontend.concurso.edit',compact('concursoInscripcion'));
    }
	
	public function listar_concurso(Request $request){
	
		$concurso_model = new Concurso();
		$p[]=$request->id_tipo_concurso;
		$p[]=$request->id_sub_tipo_concurso;
		$p[]=$request->periodo;
		$p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $concurso_model->listar_concurso($p);
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
	
	public function listar_concurso_agremiado(Request $request){
	
		$concursoInscripcione_model = new ConcursoInscripcione();
		$p[]=$request->id_concurso;
		$p[]=$request->numero_documento;
		$p[]=$request->id_agremiado;
		$p[]=$request->agremiado;
		$p[]=$request->numero_cap;
		$p[]=$request->id_regional;
		$p[]=$request->id_situacion;
		$p[]=$request->id_estado;
		$p[]=(isset($request->campo))?$request->campo:"t1.id";
		$p[]=(isset($request->orden))?$request->orden:"desc";
		$p[]=$request->flag_concurso;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $concursoInscripcione_model->listar_concurso_agremiado($p);
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
	
	public function listar_concurso_resultado_agremiado(Request $request){
	
		$concursoInscripcione_model = new ConcursoInscripcione();
		$p[]=$request->id_periodo;
		$p[]=$request->id_tipo_concurso;
		$p[]=$request->id_sub_tipo_concurso;
		$p[]=$request->id_puesto;
		$p[]=$request->id_concurso;
		$p[]=$request->numero_documento;
		$p[]=$request->id_agremiado;
		$p[]=$request->agremiado;
		$p[]=$request->numero_cap;
		$p[]=$request->id_regional;
		$p[]=$request->id_situacion;
		$p[]=$request->id_estado;
		$p[]=(isset($request->campo))?$request->campo:"t1.id";
		$p[]=(isset($request->orden))?$request->orden:"desc";
		$p[]=$request->flag_concurso;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $concursoInscripcione_model->listar_concurso_resultado_agremiado($p);
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
	
	public function modal_concurso($id){
		
		$id_user = Auth::user()->id;
		$concurso = new Concurso;
		$tablaMaestra_model = new TablaMaestra;
		$periodo_model = new PeriodoComisione;

		$periodo = $periodo_model->getPeriodoAll();
		
		if($id>0) $concurso = Concurso::find($id);else $concurso = new Concurso;

		$tipo_concurso = $tablaMaestra_model->getMaestroByTipo(101);
		$periodo_ultimo = PeriodoComisione::where("estado",1)->orderBy("id","desc")->first();
		$periodo_activo = PeriodoComisione::where("estado",1)->where("activo",1)->orderBy("id","desc")->first();
		

		return view('frontend.concurso.modal_concurso',compact('id','concurso','tipo_concurso','periodo','periodo_ultimo','periodo_activo'));

    }
	
	public function modal_inscripcion_documento($id){
		 
		$inscripcionDocumento_model = new InscripcionDocumento;
        $inscripcionDocumento = $inscripcionDocumento_model->getConcursoInscripcionDocumentoById($id);
		
        return view('frontend.concurso.modal_inscripcion_documento',compact('inscripcionDocumento'));
		
    }
	
	
	public function listar_maestro_by_tipo_subtipo($tipo,$sub_codigo){
	
		$tablaMaestra_model = new TablaMaestra;
		$sub_tipo_concurso = $tablaMaestra_model->getMaestroByTipoAndSubTipo($tipo,$sub_codigo);
		
		echo json_encode($sub_tipo_concurso);

	}
	
	public function listar_puesto_concurso($id_concurso){
	
		$concurso_model = new Concurso;
		$puesto = $concurso_model->getPuestoByIdConcurso($id_concurso);
		 
		echo json_encode($puesto);
	
	}
	
	public function obtener_concurso_vigente_pendiente($id_agremiado){
	
		$concurso_model = new Concurso;
		$concurso = $concurso_model->getConcursoVigentePendienteByAgremiado($id_agremiado);
		 
		echo json_encode($concurso);
	
	}
	
	public function modal_puesto($id){
		
		$id_user = Auth::user()->id;
		
		$tablaMaestra_model = new TablaMaestra;
		$concursoPuesto_model = new ConcursoPuesto;
		$concurso = Concurso::find($id);
		$concurso_puesto = $concursoPuesto_model->getConcursoPuestoByIdConcurso($id);
		$tipo_plaza = $tablaMaestra_model->getMaestroByTipo(94);
		$sub_tipo_concurso = $concurso->id_sub_tipo_concurso;
		//var_dump($sub_tipo_concurso);exit;
		
		return view('frontend.concurso.modal_puesto',compact('id','concurso_puesto','tipo_plaza','sub_tipo_concurso'));

    }
	
	public function modal_requisito($id){
		
		$id_user = Auth::user()->id;
		
		$tablaMaestra_model = new TablaMaestra;
		
		$tipo_documento = $tablaMaestra_model->getMaestroByTipo(97);
		
		return view('frontend.concurso.modal_requisito',compact('id','tipo_documento'));

    }
	
	public function listar_puesto(Request $request){
	
		$puesto_model = new Concurso();
		$p[]=$request->id_concurso;
		$p[]=1;          
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $puesto_model->listar_puesto($p);
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
	
	public function listar_requisito(Request $request){
	
		$puesto_model = new Concurso();
		$p[]=$request->id_concurso;
		$p[]=1;          
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $puesto_model->listar_requisito($p);
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
	
	public function send_concurso(Request $request){
		$id_user = Auth::user()->id;
		
		if($request->id == 0){
			$concurso = new Concurso;
		}else{
			$concurso = Concurso::find($request->id);
		}
		
		$concurso->id_tipo_concurso = $request->id_tipo_concurso;
		$concurso->id_sub_tipo_concurso = $request->id_sub_tipo_concurso;
		$concurso->id_periodo = $request->periodo;
		$concurso->fecha = $request->fecha;
		$concurso->fecha_inscripcion_inicio = $request->fecha_inscripcion_inicio;
		$concurso->fecha_inscripcion_fin = $request->fecha_inscripcion_fin;
		$concurso->fecha_acreditacion_inicio = $request->fecha_acreditacion_inicio;
		$concurso->fecha_acreditacion_fin = $request->fecha_acreditacion_fin;
		$concurso->estado = 1;
		$concurso->id_usuario_inserta = $id_user;
		$concurso->save();
			
    }
	
	public function send_puesto(Request $request){
	
		$id_user = Auth::user()->id;
		
		if($request->id == 0){
			$concursoPuesto = new ConcursoPuesto;
			$concursoPuesto->id_concurso = $request->id_concurso;
		}else{
			$concursoPuesto = ConcursoPuesto::find($request->id);
		}
		
		$concursoPuesto->id_tipo_plaza = $request->id_tipo_plaza;
		$concursoPuesto->numero_plazas = $request->numero_plazas;
		$concursoPuesto->estado = 1;
		$concursoPuesto->id_usuario_inserta = $id_user;
		$concursoPuesto->save();
		
    }
	
	public function send_requisito(Request $request){
	
		$id_user = Auth::user()->id;
		
		if($request->id == 0){
			$concursoRequisito = new ConcursoRequisito;
			$concursoRequisito->id_concurso = $request->id_concurso;
			
			if($request->img_foto!=""){
				$filepath_tmp = public_path('img/frontend/tmp_documento_requisito/');
				$filepath_nuevo = public_path('img/documento_requisito/');
				if (file_exists($filepath_tmp.$request->img_foto)) {
					copy($filepath_tmp.$request->img_foto, $filepath_nuevo.$request->img_foto);
				}
				
				$concursoRequisito->requisito_archivo = $request->img_foto;
			}
			
		}else{
			$concursoRequisito = ConcursoRequisito::find($request->id);
			
			if($request->img_foto!="" && $concursoRequisito->requisito_archivo!=$request->img_foto){
				$filepath_tmp = public_path('img/frontend/tmp_documento_requisito/');
				$filepath_nuevo = public_path('img/documento_requisito/');
				if (file_exists($filepath_tmp.$request->img_foto)) {
					copy($filepath_tmp.$request->img_foto, $filepath_nuevo.$request->img_foto);
				}
				
				$concursoRequisito->requisito_archivo = $request->img_foto;
			}
			
		}
		
		$concursoRequisito->id_tipo_documento = $request->id_tipo_documento;
		$concursoRequisito->denominacion = $request->denominacion;
		$concursoRequisito->estado = 1;
		$concursoRequisito->id_usuario_inserta = $id_user;
		$concursoRequisito->save();
		
    }
	
	public function send_inscripcion(Request $request){ 
		
		$msg = "";
		$id_user = Auth::user()->id;
		$comprobante_model = new Comprobante();
		$agremiado_model = new Agremiado();
		$concursoInscripcione_model = new ConcursoInscripcione();
		
		$concursoPuesto = ConcursoPuesto::find($request->id_concurso_puesto);
		$concurso = Concurso::find($concursoPuesto->id_concurso);
		
		$concursoInscripcioneExiste=NULL;
		if($concurso->id_tipo_concurso==3)$concursoInscripcioneExiste = $concursoInscripcione_model->getConcursoDelegadoValidaByIdAgremiado($concurso->id_periodo,$request->id_agremiado,$concurso->id_tipo_concurso);
		
		if(isset($concursoInscripcioneExiste->id)){
			$msg = false;
		}else{
		
			$agremiado = Agremiado::find($request->id_agremiado);
			
			if($request->id == 0){
				$concursoInscripcione = new ConcursoInscripcione;
			}else{
				$concursoInscripcione = ConcursoInscripcione::find($request->id);
			}
			
			//$comprobante = $comprobante_model->getComprobanteByTipoSerieNumero($request->numero_comprobante);
			
			//if($comprobante){
				
				$anio = Carbon::now()->format('Y');
				$concursoInscripcione->id_agremiado = $request->id_agremiado;
				
				//solo para edificaciones
				/*
				$id_tipo_plaza = $agremiado_model->getTipoPlaza($request->id_agremiado);
				$concursoPuesto = ConcursoPuesto::where("id_concurso",$request->id_concurso)->where("id_tipo_plaza",$id_tipo_plaza)->where("estado","1")->first();
				$id_concurso_puesto = $concursoPuesto->id;
				*/
				
				$id_concurso_puesto = $request->id_concurso_puesto;
				$concursoPuesto = ConcursoPuesto::find($id_concurso_puesto);
				$id_tipo_plaza = $concursoPuesto->id_tipo_plaza;
				
				$concepto = Concepto::where("codigo","00015")->where("periodo",$anio)->where("estado","1")->first();
				$concurso = Concurso::find($request->id_concurso);
				
				$concursoInscripcione->id_concurso_puesto = $id_concurso_puesto;
				$concursoInscripcione->puesto_postula = $id_tipo_plaza;
				$concursoInscripcione->puntaje = NULL;
				$concursoInscripcione->resultado = NULL;
				$concursoInscripcione->puesto = NULL;
				$concursoInscripcione->id_concepto = $concepto->id;
				$concursoInscripcione->estado = 1;
				$concursoInscripcione->id_usuario_inserta = $id_user;
				$concursoInscripcione->save();
				
				$id_concursoInscripcion = $concursoInscripcione->id;
				/*
				$valorizacion = new Valorizacione;
				$valorizacion->id_modulo = 1;
				$valorizacion->pk_registro = $id_concursoInscripcion;
				$valorizacion->id_concepto = $concepto->id;
				$valorizacion->id_agremido = $request->id_agremiado;
				$valorizacion->id_persona = $agremiado->id_persona;
				$valorizacion->id_comprobante = $comprobante->id;
				$valorizacion->monto = $concepto->importe;
				$valorizacion->id_moneda = $concepto->id_moneda;
				$valorizacion->fecha = Carbon::now()->format('Y-m-d');
				$valorizacion->fecha_proceso = Carbon::now()->format('Y-m-d');
				$valorizacion->estado = 1;
				$valorizacion->id_usuario_inserta = $id_user;
				$valorizacion->save();
				*/
				//echo $id_concursoInscripcion;
				
			//}
			
			$msg = true;
			
		}
		//echo $msg;
		return $msg;
		
    }
	
	public function send_inscripcion_resultado(Request $request){
		
		$id_user = Auth::user()->id;
		
		$concursoInscripcion = ConcursoInscripcione::find($request->id_concurso_inscripcion);
		$concursoInscripcion->puntaje = $request->puntaje;
		$concursoInscripcion->resultado = $request->id_estado;
		
		if(isset($request->asignar_puesto) && $request->asignar_puesto>0){
			$concursoPuesto = ConcursoPuesto::find($request->asignar_puesto);
			$concursoInscripcion->puesto = $concursoPuesto->id_tipo_plaza;
		}
		
		//$concursoInscripcione->puesto = $concursoInscripcione->id_concurso_puesto;
		//$concursoInscripcion->puesto = $concursoPuesto->id_tipo_plaza;
		$concursoInscripcion->save();
		echo $concursoInscripcion->id;
		
		$concursoPuesto_ = ConcursoPuesto::find($concursoInscripcion->id_concurso_puesto);
		$concurso = Concurso::find($concursoPuesto_->id_concurso);
		$fecha_acreditacion_inicio = $concurso->fecha_acreditacion_inicio;
		$fecha_acreditacion_fin = $concurso->fecha_acreditacion_fin;
		$id_tipo_concurso = $concurso->id_tipo_concurso;
		
		
		if(isset($request->asignar_puesto) && $request->asignar_puesto>0){
			$agremiadoRoleExiste = AgremiadoRole::where("id_agremiado",$concursoInscripcion->id_agremiado)->where("rol",$id_tipo_concurso)->first();
			
			if($agremiadoRoleExiste){
				$agremiadoRoleExiste->rol_especifico = $concursoPuesto->id_tipo_plaza;
				$agremiadoRoleExiste->save();
			}else{
				$agremiadoRol = new AgremiadoRole;
				$agremiadoRol->id_agremiado = $concursoInscripcion->id_agremiado;
				$agremiadoRol->rol = $id_tipo_concurso;
				$agremiadoRol->rol_especifico = $concursoPuesto->id_tipo_plaza;
				$agremiadoRol->fecha_inicio = $fecha_acreditacion_inicio;
				$agremiadoRol->fecha_fin = $fecha_acreditacion_fin;
				$agremiadoRol->estado = 1;
				$agremiadoRol->id_usuario_inserta = $id_user;
				$agremiadoRol->save();
			}
		}
    }
	
	public function send_duplicar_concurso(Request $request){
		
		$id_user = Auth::user()->id;
		$concursoInscripcione_model = new ConcursoInscripcione();
		
		$concursoInscripcion = ConcursoInscripcione::find($request->id_concurso_inscripcion);
		$concursoPuesto = ConcursoPuesto::find($concursoInscripcion->id_concurso_puesto);
		$concurso = Concurso::find($concursoPuesto->id_concurso);
		//echo "id_tipo_concurso:".$concurso->id_tipo_concurso;
		//echo "id_sub_tipo_concurso:".$concurso->id_sub_tipo_concurso;
		//exit();
		$concursoInscripcione = $concursoInscripcione_model->getConcursoUltimoNuevoByIdAgremiado($request->id_concurso_inscripcion,$request->id_agremiado,$concurso->id_tipo_concurso,$concurso->id_sub_tipo_concurso);
		$id_concurso_inscripcion = $concursoInscripcione->id;
		
		$inscripcionDocumento = InscripcionDocumento::where("id_concurso_inscripcion",$id_concurso_inscripcion)->where("estado",1)->get();
		foreach($inscripcionDocumento as $row){
			
			$inscripcionDocumento = new InscripcionDocumento;
			$inscripcionDocumento->id_concurso_inscripcion = $request->id_concurso_inscripcion;
			$inscripcionDocumento->ruta_archivo = $row->ruta_archivo;
			$inscripcionDocumento->observacion = $row->observacion;
			$inscripcionDocumento->id_tipo_documento = $row->id_tipo_documento;
			$inscripcionDocumento->fecha_documento = $row->fecha_documento;
			$inscripcionDocumento->estado = 1;
			$inscripcionDocumento->id_usuario_inserta = $id_user;
			$inscripcionDocumento->save();
		}
		
		/*
		$id_user = Auth::user()->id;
		$concursoInscripcione = ConcursoInscripcione::find($request->id_concurso_inscripcion);
		$concursoInscripcione->puntaje = $request->puntaje;
		$concursoInscripcione->resultado = $request->id_estado;
		$concursoInscripcione->puesto = $concursoInscripcione->id_concurso_puesto;
		$concursoInscripcione->save();
		echo $concursoInscripcione->id;
		*/
    }
	
	public function obtener_puesto($id){
		
		$concursoPuesto_model = new ConcursoPuesto;
		$puesto = $concursoPuesto_model->getConcursoPuestoById($id);
		
		echo json_encode($puesto);
	}
	
	public function obtener_requisito($id){
		
		$concursoRequisito_model = new ConcursoRequisito;
		$requisito = $concursoRequisito_model->getConcursoRequisitoById($id);
		
		echo json_encode($requisito);
	}
	
	public function obtener_concurso_inscripcion($id){
		
		$concursoInscripcione_model = new ConcursoInscripcione;
		$concursoInscripcion = $concursoInscripcione_model->getConcursoInscripcionById($id);
		
		echo json_encode($concursoInscripcion);
	}
	
	public function obtener_concurso_documento($id_concurso_inscripcion){

        $inscripcionDocumento_model = new InscripcionDocumento;
        $inscripcionDocumento = $inscripcionDocumento_model->getConcursoInscripcionDocumentoById($id_concurso_inscripcion);
        return view('frontend.concurso.lista_requisito',compact('inscripcionDocumento'));

    }
	
	public function obtener_concurso_requisito($id){

        $concurso_model = new Concurso;
        $concursoRequisito = $concurso_model->getConcursoRequisitoByIdConcurso($id);
		
        return view('frontend.concurso.lista_concurso_requisito',compact('concursoRequisito'));

    }
	
	public function eliminar_puesto($id){

		$concursoPuesto = ConcursoPuesto::find($id);
		$concursoPuesto->estado= "0";
		$concursoPuesto->save();
		
		echo "success";

    }
	
	public function eliminar_requisito($id){

		$concursoRequisito = ConcursoRequisito::find($id);
		$concursoRequisito->estado= "0";
		$concursoRequisito->save();
		
		echo "success";

    }
	
	public function eliminar_inscripcion_concurso($id){

		$concursoInscripcione = ConcursoInscripcione::find($id);
		$concursoInscripcione->estado= "0";
		$concursoInscripcione->save();
		
		echo "success";

    }
	
	public function eliminar_inscripcion_documento($id){

		$inscripcionDocumento = InscripcionDocumento::find($id);
		$inscripcionDocumento->estado= "0";
		$inscripcionDocumento->save();
		
		echo "success";

    }
	
	public function modal_concurso_requisito($id){
		
		$id_user = Auth::user()->id;
		$tablaMaestra_model = new TablaMaestra; 
		
		if($id>0) $inscripcionDocumento = InscripcionDocumento::find($id);else $inscripcionDocumento = new InscripcionDocumento;

		$tipo_documento = $tablaMaestra_model->getMaestroByTipo(97);

		return view('frontend.concurso.modal_concurso_requisito',compact('id','inscripcionDocumento','tipo_documento'));

    }
	
	public function send_concurso_documento(Request $request){
	
		$id_user = Auth::user()->id;
		
		$cantidadInscripcionDocumento = 0;
		$cantidadConcursoRequisito = 0;
		
		$InscripcionDocumentoExiste = InscripcionDocumento::where("id_concurso_inscripcion",$request->id_concurso_inscripcion)->where("orden_requisito",$request->orden_requisito)->where("id","!=",$request->id)->where("estado",1)->get();
		$msg = "";
		
		$cantidad = count($InscripcionDocumentoExiste);
		
		if($cantidad == 0){
		
		$concursoInscripcion = ConcursoInscripcione::find($request->id_concurso_inscripcion);
			
		$agremiado = Agremiado::find($concursoInscripcion->id_agremiado);
		$numero_cap = $agremiado->numero_cap;
		
		$concursoPuesto = ConcursoPuesto::find($concursoInscripcion->id_concurso_puesto);
		$concurso = Concurso::find($concursoPuesto->id_concurso);
		
		$periodoComision = PeriodoComisione::find($concurso->id_periodo);
		$nombre_periodo = str_replace("/","-",$periodoComision->descripcion);
		
		$tipoConcurso = TablaMaestra::where("codigo",$concurso->id_tipo_concurso)->where("tipo",101)->first();
		$nombre_tipo_concurso = $tipoConcurso->denominacion;
		
		$subTipoConcurso = TablaMaestra::where("codigo",$concurso->id_sub_tipo_concurso)->where("tipo",93)->first();
		$nombre_sub_tipo_concurso = $subTipoConcurso->denominacion;
		
		if($request->id == 0){
			
			$inscripcionDocumento = new InscripcionDocumento;
			
			if($request->img_foto!=""){
				//echo $nombre_periodo;
				$path = "img/documento/".$nombre_periodo;
				if (!is_dir($path)) {
					mkdir($path);
				}
				
				$path = "img/documento/".$nombre_periodo."/".$nombre_tipo_concurso;
				if (!is_dir($path)) {
					mkdir($path);
				}
				
				$path = "img/documento/".$nombre_periodo."/".$nombre_tipo_concurso."/".$nombre_sub_tipo_concurso;
				if (!is_dir($path)) {
					mkdir($path);
				}
				
				$path = "img/documento/".$nombre_periodo."/".$nombre_tipo_concurso."/".$nombre_sub_tipo_concurso."/".$numero_cap;
				if (!is_dir($path)) {
					mkdir($path);
				}
				
			
				$filepath_tmp = public_path('img/frontend/tmp_documento/');
				$filepath_nuevo = public_path('img/documento/'.$nombre_periodo.'/'.$nombre_tipo_concurso.'/'.$nombre_sub_tipo_concurso.'/'.$numero_cap.'/');
				
				if (file_exists($filepath_tmp.$request->img_foto)) {
					copy($filepath_tmp.$request->img_foto, $filepath_nuevo.$request->img_foto);
				}
				
				//$inscripcionDocumento->ruta_archivo = $request->img_foto;
				$inscripcionDocumento->ruta_archivo = 'img/documento/'.$nombre_periodo.'/'.$nombre_tipo_concurso.'/'.$nombre_sub_tipo_concurso.'/'.$numero_cap.'/'.$request->img_foto;
			}
			
		}else{
		
			$inscripcionDocumento = InscripcionDocumento::find($request->id);
				
			if($request->img_foto!="" && $inscripcionDocumento->ruta_archivo!=$request->img_foto){
				$filepath_tmp = public_path('img/frontend/tmp_documento/');
				//$filepath_nuevo = public_path('img/documento/');
				$filepath_nuevo = public_path('img/documento/'.$nombre_periodo.'/'.$nombre_tipo_concurso.'/'.$nombre_sub_tipo_concurso.'/'.$numero_cap.'/');
				
				if (file_exists($filepath_tmp.$request->img_foto)) {
					copy($filepath_tmp.$request->img_foto, $filepath_nuevo.$request->img_foto);
				}
				
				//$inscripcionDocumento->ruta_archivo = $request->img_foto;
				$inscripcionDocumento->ruta_archivo = 'img/documento/'.$nombre_periodo.'/'.$nombre_tipo_concurso.'/'.$nombre_sub_tipo_concurso.'/'.$numero_cap.'/'.$request->img_foto;
				
			}
			
		}
		
		
		
		$inscripcionDocumento->id_concurso_inscripcion = $request->id_concurso_inscripcion;
		$inscripcionDocumento->id_tipo_documento = $request->id_tipo_documento;
		//$inscripcionDocumento->ruta_archivo = $request->img_foto;
		$inscripcionDocumento->fecha_documento = $request->fecha_documento;
		$inscripcionDocumento->observacion = $request->observacion;
		$inscripcionDocumento->orden_requisito = $request->orden_requisito;
		$inscripcionDocumento->estado = 1;
		$inscripcionDocumento->id_usuario_inserta = $id_user;
		$inscripcionDocumento->save();
		
		$inscripcionDocumento_model = new InscripcionDocumento;
		$concurso_model = new Concurso;
        $inscripcionDocumento = $inscripcionDocumento_model->getConcursoInscripcionDocumentoById($request->id_concurso_inscripcion);
        $concursoRequisito = $concurso_model->getConcursoRequisitoByIdConcurso($concursoPuesto->id_concurso);
		
		$cantidadInscripcionDocumento = count($inscripcionDocumento);
		$cantidadConcursoRequisito = count($concursoRequisito);
		
		}
		
		$data["inscripcionDocumento"] = $cantidadInscripcionDocumento;
		$data["concursoRequisito"] = $cantidadConcursoRequisito;
		$data["cantidad"] = $cantidad;
		echo json_encode($data);
		
    }
	
	public function upload_documento(Request $request){
		
		$filename = date("YmdHis") . substr((string)microtime(), 1, 6);
		$type="";
		$filepath = public_path('img/frontend/tmp_documento/');
		
		$type=$this->extension($_FILES["file"]["name"]);
		move_uploaded_file($_FILES["file"]["tmp_name"], $filepath . $filename.".".$type);
		
    	
		//move_uploaded_file($_FILES["file"]["tmp_name"], $filepath.$_FILES["file"]["name"]);
		//echo $_FILES['file']['name'];
		
		echo $filename.".".$type;
	}
	
	function extension($filename){$file = explode(".",$filename); return strtolower(end($file));}
	
	public function eliminar_concurso($id,$estado)
    {
		$concurso = Concurso::find($id);
		$concurso->estado = $estado;
		$concurso->save();

		echo $concurso->id;

    }
		
	public function upload_documento_requisito(Request $request){

    	$filepath = public_path('img/frontend/tmp_documento_requisito/');
		move_uploaded_file($_FILES["file"]["tmp_name"], $filepath.$_FILES["file"]["name"]);
		echo $_FILES['file']['name'];
	}
	
	public function exportar_listar_concurso_agremiado($id_concurso,$numero_documento,$id_agremiado,$agremiado,$numero_cap,$id_regional,$id_situacion,$id_estado,$campo,$orden) {
		
		if($id_concurso==0)$id_concurso = "";
		if($numero_documento==0)$numero_documento = "";
		if($id_agremiado==0)$id_agremiado = "";
		if($agremiado==0)$agremiado = "";
		if($numero_cap==0)$numero_cap = "";
		if($id_regional==0)$id_regional = "";
		if($id_situacion==0)$id_situacion = "";
		if($id_estado==0)$id_estado = "";
		if($campo=="0")$campo = "";
		if($orden=="0")$orden = "";
		
		$concursoInscripcione_model = new ConcursoInscripcione();
		$p[]=$id_concurso;
		$p[]=$numero_documento;
		$p[]=$id_agremiado;
		$p[]=$agremiado;
		$p[]=$numero_cap;
		$p[]=$id_regional;
		$p[]=$id_situacion;
		$p[]=$id_estado;
		$p[]=$campo;
		$p[]=$orden;
		$p[]=1;
		$p[]=10000;
		$data = $concursoInscripcione_model->listar_concurso_agremiado($p);
		
		$variable = [];
		$n = 1;
		//array_push($variable, array("SISTEMA CAP"));
		//array_push($variable, array("CONSULTA DE CONCURSO","","","",""));
		array_push($variable, array("N","Id","Periodo","Tipo Concurso", "SubTipo Concurso", "Puesto", "Fecha Inscripcion", "Codigo Pago", "N CAP	", "N DNI", "Nombre","Situacion","Puntaje","Estado"));
		
		foreach ($data as $r) {
			$pago = "";
			if($r->numero!="")$pago = $r->tipo." ".$r->serie." ".$r->numero;
			$nombres = $r->apellido_paterno." ".$r->apellido_materno." ".$r->nombres;
			array_push($variable, array($n++,$r->id,$r->periodo, $r->tipo_concurso, $r->sub_tipo_concurso,$r->puesto,$r->fecha_inscripcion, $pago, $r->numero_cap, $r->numero_documento,$nombres,$r->situacion,$r->puntaje, $r->resultado));
		}
		
		
		$export = new InvoicesExport([$variable]);
		return Excel::download($export, 'resultado_concurso.xlsx');
		
    }
	
	public function upload_concurso(Request $request){
		
		$filename = date("YmdHis") . substr((string)microtime(), 1, 6);
		$type="";
		
		$path = "img/concurso";
		if (!is_dir($path)) {
			mkdir($path);
		}
		
		$filepath = public_path('img/concurso/');
		
		$type=$this->extension($_FILES["file"]["name"]);
		move_uploaded_file($_FILES["file"]["tmp_name"], $filepath . $filename.".".$type);
		
		$archivo = $filename.".".$type;
		
		$this->importar_concurso($archivo);
		
	}
	
	public function importar_concurso($archivo){
		
		$id_user = Auth::user()->id;
		
		$concurso = Excel::toArray(new stdClass(), "img/concurso/".$archivo);
		
		foreach($concurso as $key=>$row){
			
			foreach($row as $key2=>$row2){
				if($key2>0){
					$id = $row2[1];
					$puntaje = $row2[12];
					$resultado = $row2[13];
					$concursoInscripcion = ConcursoInscripcione::find($id);
					$concursoInscripcion->puntaje = $puntaje;
					$concursoInscripcion->resultado = $resultado;
					$concursoInscripcion->save();
					
				}
		
			}
		
		}
	}
	
	
	
}

class InvoicesExport implements FromArray
	{
    	protected $invoices;

    	public function __construct(array $invoices)
    	{
        	$this->invoices = $invoices;
    	}

    	public function array(): array
    	{
        	return $this->invoices;
    	}
}
