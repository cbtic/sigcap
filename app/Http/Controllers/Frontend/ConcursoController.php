<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Agremiado;
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

        return view('frontend.concurso.all');
    }
	
	public function create(){
		
		$agremiado_model = new Agremiado();
		$concurso_model = new Concurso();
		
		$id_persona = Auth::user()->id_persona;
		//echo $id_user;
		$concurso = $concurso_model->getConcurso();
		$agremiado = $agremiado_model->getAgremiadoByIdPersona($id_persona);
		
        return view('frontend.concurso.create',compact('concurso','agremiado'));
    }
	
	public function create_resultado(){
		
		$agremiado_model = new Agremiado();
		$concurso_model = new Concurso();
		
		$id_persona = Auth::user()->id_persona;
		//echo $id_user;
		$concurso = $concurso_model->getConcurso();
		$agremiado = $agremiado_model->getAgremiadoByIdPersona($id_persona);
		
        return view('frontend.concurso.create_resultado',compact('concurso','agremiado'));
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
		$p[]="";
		$p[]="";
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
		$p[]="";
		$p[]="";
		$p[]="";
		$p[]="";
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

		$tipo_concurso = $tablaMaestra_model->getMaestroByTipo(93);

		return view('frontend.concurso.modal_concurso',compact('id','concurso','tipo_concurso'));

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
		$concurso->periodo = $request->periodo;
		$concurso->fecha = $request->fecha;
		$concurso->fecha_inscripcion = $request->fecha_inscripcion;
		$concurso->fecha_delegatura_inicio = $request->fecha_delegatura_inicio;
		$concurso->fecha_delegatura_fin = $request->fecha_delegatura_fin;
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
		}else{
			$concursoRequisito = ConcursoRequisito::find($request->id);
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
		
		$comprobante = $comprobante_model->getComprobanteByTipoSerieNumero($request->numero_comprobante);
		
		if($comprobante){
			
			$anio = Carbon::now()->format('Y');
			$concursoInscripcione->id_agremiado = $request->id_agremiado;
			//solo para edificaciones
			$id_tipo_plaza = $agremiado_model->getTipoPlaza($request->id_agremiado);
			$concursoPuesto = ConcursoPuesto::where("id_concurso",$request->id_concurso)->where("id_tipo_plaza",$id_tipo_plaza)->where("estado","1")->first();
			$concepto = Concepto::where("codigo","00015")->where("periodo",$anio)->where("estado","1")->first();
			$concurso = Concurso::find($request->id_concurso);
			
			$concursoInscripcione->id_concurso_puesto = $concursoPuesto->id;
			$concursoInscripcione->puesto_postula = $id_tipo_plaza;
			$concursoInscripcione->puntaje = NULL;
			$concursoInscripcione->resultado = NULL;
			$concursoInscripcione->puesto = NULL;
			$concursoInscripcione->id_concepto = $concepto->id;
			$concursoInscripcione->estado = 1;
			$concursoInscripcione->id_usuario_inserta = $id_user;
			$concursoInscripcione->save();
			
			$id_concursoInscripcion = $concursoInscripcione->id;
		
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
			
			echo $id_concursoInscripcion;
			
		}
		
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
	
	
	public function obtener_puesto($id){
		
		$concursoPuesto_model = new ConcursoPuesto;
		$puesto = $concursoPuesto_model->getConcursoPuestoById($id);
		
		echo json_encode($puesto);
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
	
	
}
