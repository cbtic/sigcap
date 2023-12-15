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
use Carbon\Carbon;
use Auth;

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
		
		$tipo_concurso = $tablaMaestra_model->getMaestroByTipo(101);
		
        return view('frontend.concurso.all',compact('tipo_concurso'));
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
		$concurso = $concurso_model->getConcursoVigente();
		$agremiado = $agremiado_model->getAgremiadoByIdPersona($id_persona);
		$region = $regione_model->getRegionAll();
		$situacion_cliente = $tablaMaestra_model->getMaestroByTipo(14);
		
        return view('frontend.concurso.create',compact('concurso','agremiado','region','situacion_cliente'));
    }
	
	
	
	 

	public function create_resultado(){
		
		$agremiado_model = new Agremiado();
		$concurso_model = new Concurso();
		//$regione_model = new Regione;
		$tablaMaestra_model = new TablaMaestra;
		
		//$id_persona = Auth::user()->id_persona;
		$concurso = $concurso_model->getConcurso();
		//$agremiado = $agremiado_model->getAgremiadoByIdPersona($id_persona);
		//$region = $regione_model->getRegionAll();
		$situacion_cliente = $tablaMaestra_model->getMaestroByTipo(14);
		
        return view('frontend.concurso.create_resultado',compact('concurso',/*'agremiado',*//*'region',*/'situacion_cliente'));
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
	
	public function modal_concurso($id){
		
		$id_user = Auth::user()->id;
		$concurso = new Concurso;
		$tablaMaestra_model = new TablaMaestra;
		
		if($id>0) $concurso = Concurso::find($id);else $concurso = new Concurso;

		$tipo_concurso = $tablaMaestra_model->getMaestroByTipo(101);

		return view('frontend.concurso.modal_concurso',compact('id','concurso','tipo_concurso'));

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
	
	public function modal_puesto($id){
		
		$id_user = Auth::user()->id;
		
		$tablaMaestra_model = new TablaMaestra;
		$concursoPuesto_model = new ConcursoPuesto;
		$concurso_puesto = $concursoPuesto_model->getConcursoPuestoByIdConcurso($id);
		$tipo_plaza = $tablaMaestra_model->getMaestroByTipo(94);
		
		return view('frontend.concurso.modal_puesto',compact('id','concurso_puesto','tipo_plaza'));

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
		$concurso->periodo = $request->periodo;
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
		
		$id_user = Auth::user()->id;
		$comprobante_model = new Comprobante();
		$agremiado_model = new Agremiado();
		
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
			echo $id_concursoInscripcion;
			
		//}
		
    }
	
	public function send_inscripcion_resultado(Request $request){
		
		$id_user = Auth::user()->id;
		$concursoInscripcione = ConcursoInscripcione::find($request->id_concurso_inscripcion);
		$concursoInscripcione->puntaje = $request->puntaje;
		$concursoInscripcione->resultado = $request->id_estado;
		$concursoInscripcione->puesto = $concursoInscripcione->id_concurso_puesto;
		$concursoInscripcione->save();
		echo $concursoInscripcione->id;
		
    }
	
	public function send_duplicar_concurso(Request $request){
		
		$id_user = Auth::user()->id;
		$concursoInscripcione_model = new ConcursoInscripcione();
		$concursoInscripcione = $concursoInscripcione_model->getConcursoUltimoByIdAgremiado($request->id_concurso_inscripcion,$request->id_agremiado);
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
		
		if($request->id == 0){
		
			$inscripcionDocumento = new InscripcionDocumento;
			
			if($request->img_foto!=""){
				$filepath_tmp = public_path('img/frontend/tmp_documento/');
				$filepath_nuevo = public_path('img/documento/');
				if (file_exists($filepath_tmp.$request->img_foto)) {
					copy($filepath_tmp.$request->img_foto, $filepath_nuevo.$request->img_foto);
				}
				
				$inscripcionDocumento->ruta_archivo = $request->img_foto;
			}
			
		}else{
		
			$inscripcionDocumento = InscripcionDocumento::find($request->id);
				
			if($request->img_foto!="" && $inscripcionDocumento->ruta_archivo!=$request->img_foto){
				$filepath_tmp = public_path('img/frontend/tmp_documento/');
				$filepath_nuevo = public_path('img/documento/');
				if (file_exists($filepath_tmp.$request->img_foto)) {
					copy($filepath_tmp.$request->img_foto, $filepath_nuevo.$request->img_foto);
				}
				
				$inscripcionDocumento->ruta_archivo = $request->img_foto;
			}
			
		}
		
		
		
		$inscripcionDocumento->id_concurso_inscripcion = $request->id_concurso_inscripcion;
		$inscripcionDocumento->id_tipo_documento = $request->id_tipo_documento;
		//$inscripcionDocumento->ruta_archivo = $request->img_foto;
		$inscripcionDocumento->fecha_documento = $request->fecha_documento;
		$inscripcionDocumento->observacion = $request->observacion;
		$inscripcionDocumento->estado = 1;
		$inscripcionDocumento->id_usuario_inserta = $id_user;
		$inscripcionDocumento->save();
			
    }
	
	public function upload_documento(Request $request){

    	$filepath = public_path('img/frontend/tmp_documento/');
		move_uploaded_file($_FILES["file"]["tmp_name"], $filepath.$_FILES["file"]["name"]);
		echo $_FILES['file']['name'];
	}
	
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
	
	
}
