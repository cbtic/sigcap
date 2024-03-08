<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Persona;
use App\Models\Agremiado;
use App\Models\AgremiadoExperienciaLaborale;
use App\Models\AgremiadoIdioma;
use App\Models\AgremiadoEstudio;
use App\Models\AgremiadoSeguro;
use App\Models\AgremiadoTrabajo;
use App\Models\AgremiadoParenteco;
use App\Models\AgremiadoTraslado;
use App\Models\AgremiadoSituacione;
use App\Models\TablaMaestra;
use App\Models\Regione;
use App\Models\Ubigeo;
use App\Models\AgremiadoRole;
use App\Models\ConcursoInscripcione;
use App\Models\Locale;
use App\Models\Suspensione;
use Carbon\Carbon;
use Auth;

class AgremiadoController extends Controller
{
	public function __construct(){

		$this->middleware(function ($request, $next) {
			if(!Auth::check()) {
                return redirect('login');
            }
			return $next($request);
    	});
	}
	
	public function index(){
        /*
		$agremiado = Agremiado::find($id);
		$id_persona = $agremiado->id_persona;
		$persona = Persona::find($id_persona);
		*/
		$id = 0;
		$id_persona = 0;
		$agremiado = new Agremiado();
		$persona = new Persona();
		
		$tablaMaestra_model = new TablaMaestra;
		$regione_model = new Regione;
		$ubigeo_model = new Ubigeo;
		$agremiadoEstudio_model = new AgremiadoEstudio;
		$agremiadoIdioma_model = new AgremiadoIdioma;
		$agremiadoParenteco_model = new AgremiadoParenteco;
		$agremiadoTrabajo_model = new AgremiadoTrabajo;
		$agremiadoTraslado_model = new AgremiadoTraslado;
		$agremiadoSituacione_model = new AgremiadoSituacione;
		$agremiadoRol_model = new AgremiadoRole;
		
		$tipo_documento = $tablaMaestra_model->getMaestroByTipo(16);
		$tipo_zona = $tablaMaestra_model->getMaestroByTipo(34);
		$estado_civil = $tablaMaestra_model->getMaestroByTipo(3);
		$sexo = $tablaMaestra_model->getMaestroByTipo(2);
		$nacionalidad = $tablaMaestra_model->getMaestroByTipo(5);
		$seguro_social = $tablaMaestra_model->getMaestroByTipo(13);
		$actividad_gremial = $tablaMaestra_model->getMaestroByTipo(46);
		$ubicacion_cliente = $tablaMaestra_model->getMaestroByTipo(63);
		$autoriza_tramite = $tablaMaestra_model->getMaestroByTipo(45);
		$situacion_cliente = $tablaMaestra_model->getMaestroByTipo(14);
		$grupo_sanguineo = $tablaMaestra_model->getMaestroByTipo(90);
		$categoria_cliente = $tablaMaestra_model->getMaestroByTipo(18);
		$region = $regione_model->getRegionAll();
		$departamento = $ubigeo_model->getDepartamento();
		
		$agremiado_estudio = $agremiadoEstudio_model->getAgremiadoEstudios($id);
		$agremiado_idioma = $agremiadoIdioma_model->getAgremiadoIdiomas($id);
		$agremiado_parentesco = $agremiadoParenteco_model->getAgremiadoParentesco($id);
		$agremiado_trabajo = $agremiadoTrabajo_model->getAgremiadoTrabajo($id);
		$agremiado_traslado = $agremiadoTraslado_model->getAgremiadoTraslado($id);
		$agremiado_situacion = $agremiadoSituacione_model->getAgremiadoSituacion($id);
		//$agremiado_rol = $agremiadoRol_model->getAgremiadoRol($id);
		
		$concursoInscripcione_model = new ConcursoInscripcione();
		$p[]="";
		$p[]="";
		$p[]=$id;
		$p[]="";
		$p[]="";
		$p[]="";
		$p[]="";
		$p[]="";
		$p[]="1";
		$p[]="100";
		$agremiado_rol = $concursoInscripcione_model->listar_concurso_agremiado($p);
		
		return view('frontend.agremiado.create',compact('id','id_persona','agremiado','persona','tipo_documento','tipo_zona','estado_civil','sexo','nacionalidad','seguro_social','actividad_gremial','ubicacion_cliente','autoriza_tramite','situacion_cliente','region','departamento','grupo_sanguineo','categoria_cliente','agremiado_estudio','agremiado_idioma','agremiado_parentesco','agremiado_trabajo','agremiado_traslado','agremiado_situacion','agremiado_rol'));
    }
	
	public function editar_agremiado($id){
		//echo date('Y-m-d');exit();
        /*
		$firstDate = "2019-01-01";
		$secondDate = "2020-03-04";
		$dateDifference = abs(strtotime($secondDate) - strtotime($firstDate));
		$years  = floor($dateDifference / (365 * 60 * 60 * 24));
		echo $years;
		exit();
		*/
		$agremiado = Agremiado::find($id);
		$id_persona = $agremiado->id_persona;
		$persona = Persona::find($id_persona);
		
		$tablaMaestra_model = new TablaMaestra;
		$regione_model = new Regione;
		$ubigeo_model = new Ubigeo;
		$agremiadoEstudio_model = new AgremiadoEstudio;
		$agremiadoIdioma_model = new AgremiadoIdioma;
		$agremiadoParenteco_model = new AgremiadoParenteco;
		$agremiadoTrabajo_model = new AgremiadoTrabajo;
		$agremiadoTraslado_model = new AgremiadoTraslado;
		$agremiadoSituacione_model = new AgremiadoSituacione;
		$agremiadoRol_model = new AgremiadoRole;
		$suspension_model = new Suspensione;
		
		$tipo_documento = $tablaMaestra_model->getMaestroByTipo(16);
		$tipo_zona = $tablaMaestra_model->getMaestroByTipo(34);
		$estado_civil = $tablaMaestra_model->getMaestroByTipo(3);
		$sexo = $tablaMaestra_model->getMaestroByTipo(2);
		$nacionalidad = $tablaMaestra_model->getMaestroByTipo(5);
		$seguro_social = $tablaMaestra_model->getMaestroByTipo(13);
		$actividad_gremial = $tablaMaestra_model->getMaestroByTipo(46);
		$ubicacion_cliente = $tablaMaestra_model->getMaestroByTipo(63);
		$autoriza_tramite = $tablaMaestra_model->getMaestroByTipo(45);
		$situacion_cliente = $tablaMaestra_model->getMaestroByTipo(14);
		$grupo_sanguineo = $tablaMaestra_model->getMaestroByTipo(90);
		$categoria_cliente = $tablaMaestra_model->getMaestroByTipo(18);
		$region = $regione_model->getRegionAll();
		$departamento = $ubigeo_model->getDepartamento();
		
		$agremiado_estudio = $agremiadoEstudio_model->getAgremiadoEstudios($id);
		$agremiado_idioma = $agremiadoIdioma_model->getAgremiadoIdiomas($id);
		$agremiado_parentesco = $agremiadoParenteco_model->getAgremiadoParentesco($id);
		$agremiado_trabajo = $agremiadoTrabajo_model->getAgremiadoTrabajo($id);
		$agremiado_traslado = $agremiadoTraslado_model->getAgremiadoTraslado($id);
		$agremiado_situacion = $agremiadoSituacione_model->getAgremiadoSituacion($id);
		
		//$agremiado_rol = $agremiadoRol_model->getAgremiadoRol($id);
		
		$concursoInscripcione_model = new ConcursoInscripcione();
		$p[]="";
		$p[]="";
		$p[]=$id;
		$p[]="";
		$p[]="";
		$p[]="";
		$p[]="";
		$p[]="";
		$p[]="1";
		$p[]="100";
		$agremiado_rol = $concursoInscripcione_model->listar_concurso_agremiado($p);
		//print_r($agremiado_rol);
		return view('frontend.agremiado.create',compact('id','id_persona','agremiado','persona','tipo_documento','tipo_zona','estado_civil','sexo','nacionalidad','seguro_social','actividad_gremial','ubicacion_cliente','autoriza_tramite','situacion_cliente','region','departamento','grupo_sanguineo','categoria_cliente','agremiado_estudio','agremiado_idioma','agremiado_parentesco','agremiado_trabajo','agremiado_traslado','agremiado_situacion','agremiado_rol'));
		
    }
	
	public function send(Request $request){

        $sw = true;
		$msg = "";
		$id_user = Auth::user()->id;
		
		$id_agremiado = $request->id_agremiado;
		$id_persona = $request->id_persona;
		
		if($id_persona> 0){
			$persona = Persona::find($id_persona);
			
			if($request->img_foto!=""){
				$filepath_tmp = public_path('img/frontend/tmp_agremiado/');
				$filepath_nuevo = public_path('img/agremiado/');
				if (file_exists($filepath_tmp.$request->img_foto)) {
					copy($filepath_tmp.$request->img_foto, $filepath_nuevo.$request->img_foto);
				}
				
				$persona->foto = $request->img_foto;
			}
			
		}else{
			$persona = new Persona;
			$persona->estado = 1;
			$persona->id_usuario_inserta = 1;
			
			if($request->img_foto!="" && $persona->foto!=$request->img_foto){
				$filepath_tmp = public_path('img/frontend/persona/');
				$filepath_nuevo = public_path('img/agremiado/');
				if (file_exists($filepath_tmp.$request->img_foto)) {
					copy($filepath_tmp.$request->img_foto, $filepath_nuevo.$request->img_foto);
				}
				
				$persona->foto = $request->img_foto;
			}
		}
		
		$persona->id_tipo_documento = $request->id_tipo_documento;
		$persona->numero_documento = $request->numero_documento;
		$persona->apellido_paterno = $request->apellido_paterno;
		$persona->apellido_materno = $request->apellido_materno;
		$persona->nombres = $request->nombres;
		$persona->numero_ruc = $request->numero_ruc;

		//print_r($request->numero_ruc); exit();

		if( $request->numero_ruc!=""){
			$persona->desc_cliente_sunat = $request->apellido_paterno." ".$request->apellido_materno." ".$request->nombres;
			$persona->direccion_sunat = $request->direccion;
		}

		$persona->correo = $request->email1;
		$persona->numero_celular = $request->celular1;
		$persona->direccion = $request->direccion;

		$persona->fecha_nacimiento = $request->fecha_nacimiento;
		$persona->id_sexo = $request->id_sexo;
		$persona->lugar_nacimiento = $request->lugar_nacimiento;
		$persona->grupo_sanguineo = $request->grupo_sanguineo;
		$persona->id_nacionalidad = $request->id_nacionalidad;
		$persona->id_ubigeo_nacimiento = $request->id_distrito;
		$persona->estado = 1;
		$persona->save();
		
		if($id_agremiado> 0){
			$agremiado = Agremiado::find($id_agremiado);
		}else{
			$agremiado = new Agremiado;
			$agremiado->id_persona = $persona->id;
			$agremiado->id_usuario_inserta = 1;
			$agremiado->fecha_colegiado = $request->fecha_colegiado;
			//$agremiado->id_situacion = "73";
		}
		//exit($request->id_distrito_domiciliario);
		$agremiado->numero_cap = $request->numero_cap;
		$agremiado->libro_nacional = $request->libro_nacional;
		$agremiado->numero_regional = $request->numero_regional;
		$agremiado->libro = $request->libro;
		$agremiado->id_regional = $request->id_regional;
		$agremiado->id_local = $request->id_local;
		$agremiado->id_ubigeo_domicilio = $request->id_distrito_domiciliario;
		$agremiado->folio_nacional = $request->folio_nacional;
		//$agremiado->fecha_colegiado = $request->fecha_colegiado;
		$agremiado->folio = $request->folio;
		//$agremiado->fecha_actualiza = $request->fecha_actualiza;
		$agremiado->fecha_actualiza = Carbon::now()->format('Y-m-d');
		$agremiado->id_estado_civil = $request->id_estado_civil;
		$agremiado->direccion = $request->direccion;
		$agremiado->codigo_postal = $request->codigo_postal;
		$agremiado->referencia = $request->referencia;
		$agremiado->telefono1 = $request->telefono1;
		$agremiado->telefono2 = $request->telefono2;
		$agremiado->celular1 = $request->celular1;
		$agremiado->celular2 = $request->celular2;
		$agremiado->email1 = $request->email1;
		$agremiado->email2 = $request->email2;
		$agremiado->informacion_adicional = $request->informacion_adicional;
		$agremiado->flag_confidencial = $request->flag_confidencial;
		$agremiado->id_seguro_social = $request->id_seguro_social;
		$agremiado->flag_correspondencia = $request->flag_correspondencia;
		$agremiado->clave = $request->clave;
		$agremiado->id_actividad_gremial = $request->id_actividad_gremial;
		$agremiado->id_ubicacion = $request->id_ubicacion;
		$agremiado->id_autoriza_tramite = $request->id_autoriza_tramite;
		$agremiado->id_categoria = $request->id_categoria;
		$agremiado->id_situacion = ($request->id_situacion!="")?$request->id_situacion:73;
		$agremiado->desc_situacion_otro = $request->desc_situacion_otro;
		$agremiado->fecha_fallecido = $request->fecha_fallecido;
		
		if($request->id_categoria==91){
			$agremiado->fecha_inicio_temp = $request->fecha_inicio_temp;
			$agremiado->fecha_fin_temp = $request->fecha_fin_temp;
			$agremiado->observacion_temp = $request->observacion_temp;
		}else{
			$agremiado->fecha_inicio_temp = NULL;
			$agremiado->fecha_fin_temp = NULL;
			$agremiado->observacion_temp = NULL;
		}
		
		//$agremiado->estado = 1;
		$agremiado->save();
		
		
	}
	
	public function upload_agremiado(Request $request){
		
		/*
    	$filepath = public_path('img/frontend/tmp_agremiado/');
		move_uploaded_file($_FILES["file"]["tmp_name"], $filepath.$_FILES["file"]["name"]);
		echo $_FILES['file']['name'];
		*/
		
		$filename = date("YmdHis") . substr((string)microtime(), 1, 6);
		$type="";
		$filepath = public_path('img/frontend/tmp_agremiado/');
		
		$type=$this->extension($_FILES["file"]["name"]);
		move_uploaded_file($_FILES["file"]["tmp_name"], $filepath . $filename.".".$type);
		
		echo $filename.".".$type;
		
	}
	
	function extension($filename){$file = explode(".",$filename); return strtolower(end($file));}
	
	public function consulta_agremiado(){
		
		$regione_model = new Regione;
		$tablaMaestra_model = new TablaMaestra;
		$region = $regione_model->getRegionAll();
		$situacion_cliente = $tablaMaestra_model->getMaestroByTipo(14);
		return view('frontend.agremiado.all',compact('region','situacion_cliente'));
		
	}
	
	public function listar_agremiado_ajax(Request $request){
	
		$agremiado_model = new Agremiado;
		$p[]=$request->id_regional;
		$p[]=$request->numero_cap;
		$p[]=$request->numero_documento;
		$p[]=$request->agremiado;
		$p[]=$request->fecha_inicio;
		$p[]=$request->fecha_fin;
		$p[]=$request->id_situacion;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $agremiado_model->listar_agremiado_ajax($p);
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
	
	public function obtener_provincia($idDepartamento){
		
		$ubigeo_model = new Ubigeo;
		$provincia = $ubigeo_model->getProvincia($idDepartamento);
		echo json_encode($provincia);
	}
	
	public function obtener_distrito($id_departamento,$idProvincia){
		
		$ubigeo_model = new Ubigeo;
		$distrito = $ubigeo_model->getDistrito($id_departamento,$idProvincia);
		echo json_encode($distrito);
	}
	
	public function modal_agremiado_estudio($id){
		
		$tablaMaestra_model = new TablaMaestra;
		
		if($id>0){
			$agremiadoEstudio = AgremiadoEstudio::find($id);
		}else{
			$agremiadoEstudio = new AgremiadoEstudio;
		}
		
		$universidad = $tablaMaestra_model->getMaestroByTipo(85);
		$especialidad = $tablaMaestra_model->getMaestroByTipo(86);
		
		return view('frontend.agremiado.modal_estudio',compact('id','agremiadoEstudio','universidad','especialidad'));
	
	}
	
	public function send_agremiado_estudio(Request $request){
		
		if($request->id == 0){
			$agremiadoEstudio = new AgremiadoEstudio;
		}else{
			$agremiadoEstudio = AgremiadoEstudio::find($request->id);
		}
		
		$agremiadoEstudio->id_agremiado = $request->id_agremiado;
		$agremiadoEstudio->id_universidad = $request->id_universidad;
		$agremiadoEstudio->id_especialidad = $request->id_especialidad;
		$agremiadoEstudio->tesis = $request->tesis;
		$agremiadoEstudio->fecha_egresado = $request->fecha_egresado;
		$agremiadoEstudio->fecha_graduado = $request->fecha_graduado;
		$agremiadoEstudio->libro = $request->libro;
		$agremiadoEstudio->folio = $request->folio;
		$agremiadoEstudio->estado = 1;
		$agremiadoEstudio->id_usuario_inserta = 1;
		$agremiadoEstudio->save();
			
    }
	
	public function modal_agremiado_idioma($id){
		
		$tablaMaestra_model = new TablaMaestra;
		
		if($id>0){
			$agremiadoIdioma = AgremiadoIdioma::find($id);
		}else{
			$agremiadoIdioma = new AgremiadoIdioma;
		}
		
		$idioma = $tablaMaestra_model->getMaestroByTipo(87);
		$grado = $tablaMaestra_model->getMaestroByTipo(17);
		
		return view('frontend.agremiado.modal_idioma',compact('id','agremiadoIdioma','idioma','grado'));
	
	}
	
	public function send_agremiado_idioma(Request $request){
		
		if($request->id == 0){
			$agremiadoIdioma = new AgremiadoIdioma;
		}else{
			$agremiadoIdioma = AgremiadoIdioma::find($request->id);
		}
		
		$agremiadoIdioma->id_agremiado = $request->id_agremiado;
		$agremiadoIdioma->id_idioma = $request->id_idioma;
		$agremiadoIdioma->id_grado_conocimiento = $request->id_grado_conocimiento;
		$agremiadoIdioma->estado = 1;
		$agremiadoIdioma->id_usuario_inserta = 1;
		$agremiadoIdioma->save();
			
    }
	
	public function modal_agremiado_parentesco($id){
		
		$tablaMaestra_model = new TablaMaestra;
		
		if($id>0){
			$agremiadoParenteco = AgremiadoParenteco::find($id);
		}else{
			$agremiadoParenteco = new AgremiadoParenteco;
		}
		
		$parentesco = $tablaMaestra_model->getMaestroByTipo(12);
		$sexo = $tablaMaestra_model->getMaestroByTipo(2);
		
		return view('frontend.agremiado.modal_parentesco',compact('id','agremiadoParenteco','parentesco','sexo'));
	
	}
	
	public function send_agremiado_parentesco(Request $request){
		
		if($request->id == 0){
			$agremiadoParenteco = new AgremiadoParenteco;
		}else{
			$agremiadoParenteco = AgremiadoParenteco::find($request->id);
		}
		
		$agremiadoParenteco->id_agremiado = $request->id_agremiado;
		$agremiadoParenteco->id_parentesco = $request->id_parentesco;
		$agremiadoParenteco->id_sexo = $request->id_sexo;
		$agremiadoParenteco->apellido_nombre = $request->apellido_nombre;
		$agremiadoParenteco->fecha_nacimiento = $request->fecha_nacimiento;
		$agremiadoParenteco->estado = 1;
		$agremiadoParenteco->id_usuario_inserta = 1;
		$agremiadoParenteco->save();
			
    }
	
	public function modal_agremiado_trabajo($id){
		
		$tablaMaestra_model = new TablaMaestra;
		$ubigeo_model = new Ubigeo;
		
		if($id>0){
			$agremiadoTrabajo = AgremiadoTrabajo::find($id);
		}else{
			$agremiadoTrabajo = new AgremiadoTrabajo;
		}
		
		$cargo = $tablaMaestra_model->getMaestroByTipo(4);
		$departamento = $ubigeo_model->getDepartamento();
		
		return view('frontend.agremiado.modal_trabajo',compact('id','agremiadoTrabajo','cargo','departamento'));
	
	}
	
	public function modal_agremiado_traslado($id){
		
		$regione_model = new Regione;
		
		if($id>0){
			$agremiadoTraslado = AgremiadoTraslado::find($id);
		}else{
			$agremiadoTraslado = new AgremiadoTraslado;
		}
		
		$region = $regione_model->getRegionAll();
		
		return view('frontend.agremiado.modal_traslado',compact('id','agremiadoTraslado','region'));
	
	}
	
	public function modal_agremiado_situacion($id){
		
		$tablaMaestra_model = new TablaMaestra;
		
		if($id>0){
			$agremiadoSituacion = AgremiadoSituacione::find($id);
		}else{
			$agremiadoSituacion = new AgremiadoSituacione;
		}
		
		$pais = $tablaMaestra_model->getMaestroByTipo(88);
		
		return view('frontend.agremiado.modal_situacion',compact('id','agremiadoSituacion','pais'));
	
	}
	
	public function send_agremiado_trabajo(Request $request){
		
		if($request->id == 0){
			$agremiadoTrabajo = new AgremiadoTrabajo;
		}else{
			$agremiadoTrabajo = AgremiadoTrabajo::find($request->id);
		}
		/*
		$id_departamento = str_pad($request->id_departamento_trabajo, 2, "0", STR_PAD_LEFT);
		$id_provincia = str_pad($request->id_provincia_trabajo, 2, "0", STR_PAD_LEFT);
		$id_distrito = str_pad($request->id_distrito_trabajo, 2, "0", STR_PAD_LEFT);
		$id_ubigeo = $id_departamento.$id_provincia.$id_distrito;
		*/
		
		$id_ubigeo = $request->id_distrito_trabajo;
		$agremiadoTrabajo->id_agremiado = $request->id_agremiado;
		$agremiadoTrabajo->id_cliente_cargo = $request->id_cliente_cargo;
		$agremiadoTrabajo->rubro_negocio = $request->rubro_negocio;
		$agremiadoTrabajo->id_ubigeo = $id_ubigeo;
		$agremiadoTrabajo->numero_documento = $request->numero_documento;
		$agremiadoTrabajo->razon_social = $request->razon_social;
		$agremiadoTrabajo->direccion = $request->direccion;
		$agremiadoTrabajo->codigo_postal = $request->codigo_postal;
		$agremiadoTrabajo->referencia = $request->referencia;
		$agremiadoTrabajo->telefono = $request->telefono;
		$agremiadoTrabajo->celular = $request->celular;
		$agremiadoTrabajo->email = $request->email;
		$agremiadoTrabajo->estado = 1;
		$agremiadoTrabajo->id_usuario_inserta = 1;
		$agremiadoTrabajo->save();
		
    }
	
	public function send_agremiado_situacion(Request $request){
		
		if($request->id == 0){
			$agremiadoSituacion = new AgremiadoSituacione;
		}else{
			$agremiadoSituacion = AgremiadoSituacione::find($request->id);
		}
		
		$agremiadoSituacion->id_agremiado = $request->id_agremiado;
		$agremiadoSituacion->id_motivo = 0;
		$agremiadoSituacion->id_pais_destino = $request->id_pais_destino;
		$agremiadoSituacion->fecha_inicio = $request->fecha_inicio;
		$agremiadoSituacion->fecha_fin = $request->fecha_fin;
		$agremiadoSituacion->ruta_documento = $request->ruta_documento;
		$agremiadoSituacion->estado = 1;
		$agremiadoSituacion->id_usuario_inserta = 1;
		$agremiadoSituacion->save();
		
    }
	
	public function send_agremiado_traslado(Request $request){
		
		if($request->id == 0){
			$agremiadoTraslado = new AgremiadoTraslado;
		}else{
			$agremiadoTraslado = AgremiadoTraslado::find($request->id);
		}
		
		$agremiadoTraslado->id_agremiado = $request->id_agremiado;
		$agremiadoTraslado->id_region = $request->id_region;
		$agremiadoTraslado->fecha_inicio = $request->fecha_inicio;
		$agremiadoTraslado->fecha_fin = $request->fecha_fin;
		$agremiadoTraslado->numero_regional = $request->numero_regional;
		$agremiadoTraslado->observacion = $request->observacion;
		$agremiadoTraslado->estado = 1;
		$agremiadoTraslado->id_usuario_inserta = 1;
		$agremiadoTraslado->save();
		
    }
	
	public function eliminar_estudio($id){

		$agremiadoEstudio = AgremiadoEstudio::find($id);
		$agremiadoEstudio->estado= "0";
		$agremiadoEstudio->save();
		
		echo "success";

    }
	
	public function eliminar_idioma($id){

		$agremiadoIdioma = AgremiadoIdioma::find($id);
		$agremiadoIdioma->estado= "0";
		$agremiadoIdioma->save();
		
		echo "success";

    }
	
	public function eliminar_parentesco($id){

		$agremiadoParenteco = AgremiadoParenteco::find($id);
		$agremiadoParenteco->estado= "0";
		$agremiadoParenteco->save();
		
		echo "success";

    }
	
	public function eliminar_trabajo($id){

		$agremiadoTrabajo = AgremiadoTrabajo::find($id);
		$agremiadoTrabajo->estado= "0";
		$agremiadoTrabajo->save();
		
		echo "success";

    }
	
	public function eliminar_traslado($id){

		$agremiadoTraslado = AgremiadoTraslado::find($id);
		$agremiadoTraslado->estado= "0";
		$agremiadoTraslado->save();
		
		echo "success";

    }
	
	public function eliminar_situacion($id){

		$agremiadoSituacione = AgremiadoSituacione::find($id);
		$agremiadoSituacione->estado= "0";
		$agremiadoSituacione->save();
		
		echo "success";

    }
	
	public function importar_agremiado_cuota(){
		
		$agremiado_model = new Agremiado;
		$p[]=date("Y");
		$data = $agremiado_model->crud_automatico_agremiado_cuota($p);
		
	}
	
	public function importar_agremiado_cuota_fecha(){
		
		$agremiado_model = new Agremiado;
		$p[]=date("Y");
		$data = $agremiado_model->crud_automatico_agremiado_cuota_fecha($p);
		
	}
	
	public function importar_agremiado_cuota_vitalicio(){
		
		$agremiado_model = new Agremiado;
		$data = $agremiado_model->crud_automatico_agremiado_cuota_vitalicio();
		
	} 
	
	public function importar_agremiado($fecha){ 
		
		$fecha = "12-02-2024";
		/*************WEB SERVICE - LEER TOKEN*****************/
		
		$data_string = '{"email":"pbravogutarra@gmail.com","password":"ua5DhY3oFDZ7aKg"}';
		$ch = curl_init('https://integracion.portalcap2.org.pe/api/v1/auth');		
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json'
		));
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		
		$resultWebApi = curl_exec($ch);
		
		if($errno = curl_errno($ch)) {
			$error_message = curl_strerror($errno);
			echo "cURL error ({$errno}):\n {$error_message}";
		}

		$dataWebApi = json_decode($resultWebApi);
		$token = $dataWebApi->token;
		
		//exit($token);
		
		/*************WEB SERVICE - LEER AGREMIADO*****************/
		
		//$ch2 = curl_init('https://integracion.portalcap2.org.pe/api/v1/collegiate/?idRegional=13&fecha=17-08-2023');
		$ch2 = curl_init('https://integracion.portalcap2.org.pe/api/v1/collegiate/?idRegional=11&fecha='.$fecha);
		curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch2, CURLOPT_HTTPHEADER, array('x-token: '.$token));
		curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
		
		$resultWebApi2 = curl_exec($ch2);
		
		if($errno = curl_errno($ch2)) {
			$error_message = curl_strerror($errno);
			echo "cURL error ({$errno}):\n {$error_message}";
		}
		//print_r($resultWebApi2);exit();
		$dataWebApi2 = json_decode($resultWebApi2);
		$ok = $dataWebApi2->ok;
		$data = $dataWebApi2->data;
		
		//echo $ok;
		//dd($data);
		//exit();
		
		/*************INSTAR AGREMIADO*****************/
		
		foreach($data as $solicitud){
			
			$id_departamento_sol = str_pad($solicitud->iddepartamento, 2, "0", STR_PAD_LEFT);
			$id_provincia_sol = str_pad($solicitud->idprovincia, 2, "0", STR_PAD_LEFT);
			$id_distrito_sol = str_pad($solicitud->iddistrito, 2, "0", STR_PAD_LEFT);
			$IdUbigeoDomicilio = $id_departamento_sol.$id_provincia_sol.$id_distrito_sol;
			
			$persona = new Persona;
			$persona->id_tipo_documento = $this->equivalenciaTipoDocumento($solicitud->idtipodocumento);
			$persona->numero_documento = $solicitud->numerodocumento;
			$persona->apellido_paterno = $solicitud->apellidopaterno;
			$persona->apellido_materno = $solicitud->apellidomaterno;
			$persona->nombres = $solicitud->nombre;
			$persona->fecha_nacimiento = $solicitud->fechanacimiento;
			//$persona->sexo = $sexo;
			$persona->id_sexo = $this->equivalenciaTipoSexo($solicitud->idsexo);
			$persona->grupo_sanguineo = $this->equivalenciaGrupoSanguineo($solicitud->gruposanguineo);
			$persona->id_ubigeo_nacimiento = "150101";
			$persona->lugar_nacimiento = $solicitud->lugarnacimiento;
			$persona->id_nacionalidad = 16;
			
			$persona->id_tipo_persona = 1;
			$persona->estado = 1;
			$persona->id_usuario_inserta = 1;
			$persona->save();
			$id_persona = $persona->id;
			
			$agremiado = new Agremiado;
			$agremiado->id_persona = $id_persona;
			$agremiado->numero_cap = $solicitud->numerocap;
			$agremiado->id_regional = 5;
			$agremiado->fecha = $solicitud->fechasolicitud;
			$agremiado->desc_cliente = $solicitud->apellidopaterno." ".$solicitud->apellidomaterno." ".$solicitud->nombre;
			$agremiado->id_estado_civil = $this->equivalenciaEstadoCivil($solicitud->estadocivil);
			$agremiado->direccion = $solicitud->domicilio;
			$agremiado->id_local = 1;
			$agremiado->referencia = NULL;
			$agremiado->id_seguro_social = 94;
			$agremiado->id_ubigeo_domicilio = $IdUbigeoDomicilio;
			$agremiado->codigo_postal = NULL;
			$agremiado->referencia = NULL;
			
			$agremiado->telefono1 = $solicitud->numerotelefonofijo;
			$agremiado->celular1 = $solicitud->numerocelular;
			$agremiado->email1 = $solicitud->correoelectronico;
			
			$agremiado->fecha_colegiado = $solicitud->fechacolegiatura;
			$agremiado->numero_regional = 0;
			$agremiado->libro = NULL;
			$agremiado->folio = NULL;
			$agremiado->libro_nacional = $solicitud->numerolibro;
			$agremiado->folio_nacional = $solicitud->numerofolio;
			$agremiado->flag_correspondencia = true;
			$agremiado->id_categoria = 89;
			//$agremiado->fecha_actualiza = 
			$agremiado->flag_confidencial = true;
			$agremiado->id_autoriza_tramite = 222;
			$agremiado->id_actividad_gremial = 224;
			$agremiado->clave = 0;
			$agremiado->id_ubicacion = 334;
			
			$agremiado->id_situacion = "74";
			//$agremiado->id_situacion = "73";
			$agremiado->id_usuario_inserta = 1;
			$agremiado->save();
			$id_agremiado = $agremiado->id;	
			
			
			foreach($solicitud->datoslaborales as $datoLaboral){
				
				$modalidad = false;
				if($datoLaboral->nombre_modalidad_trabajo=="DEPENDIENTE")$modalidad = true;
				
				$id_departamento = str_pad($datoLaboral->id_departamento, 2, "0", STR_PAD_LEFT);
				$id_provincia = str_pad($datoLaboral->id_provincia, 2, "0", STR_PAD_LEFT);
				$id_distrito = str_pad($datoLaboral->id_distrito, 2, "0", STR_PAD_LEFT);
				$id_ubigeo = $id_departamento.$id_provincia.$id_distrito;
				
				$agremiadoTrabajo = new AgremiadoTrabajo;
				$agremiadoTrabajo->id_agremiado = $id_agremiado;
				//$agremiadoTrabajo->id_persona = "1";
				$agremiadoTrabajo->modalidad = $modalidad;
				$agremiadoTrabajo->numero_documento = $datoLaboral->numero_ruc;
				$agremiadoTrabajo->razon_social = $datoLaboral->nombre_razon_social;
				$agremiadoTrabajo->id_cliente_cargo = "0";
				$agremiadoTrabajo->rubro_negocio = $datoLaboral->nombre_rubro;
				$agremiadoTrabajo->id_ubigeo = $id_ubigeo;
				$agremiadoTrabajo->direccion = $datoLaboral->nombre_direccion_trabajo;
				$agremiadoTrabajo->referencia = $datoLaboral->referencia_direccion;
				$agremiadoTrabajo->codigo_postal = null;
				$agremiadoTrabajo->telefono = $datoLaboral->telefono_fijo_trabajo;
				$agremiadoTrabajo->celular = $datoLaboral->telefono_celular_trabajo;
				$agremiadoTrabajo->email = $datoLaboral->correo_electronico_trabajo;
				$agremiadoTrabajo->estado = 1;
				$agremiadoTrabajo->id_usuario_inserta = 1;
				$agremiadoTrabajo->save();
			
			}
			
			foreach($solicitud->idioma as $idioma){
				
				$agremiadoIdioma = new AgremiadoIdioma;
				$agremiadoIdioma->id_agremiado = $id_agremiado;
				$agremiadoIdioma->id_idioma = $this->equivalenciaIdioma($idioma->id_idiomas);
				$agremiadoIdioma->id_grado_conocimiento = $this->equivalenciaTipoNivel($idioma->id_nivel);
				$agremiadoIdioma->estado = 1;
				$agremiadoIdioma->id_usuario_inserta = 1;
				$agremiadoIdioma->save();
				
			}
			
			foreach($solicitud->estudio as $estudio){
				
				$agremiadoEstudio = new AgremiadoEstudio;
				$agremiadoEstudio->id_agremiado = $id_agremiado;
				$agremiadoEstudio->id_universidad = $this->equivalenciaUniversidad($estudio->id_universidad);
				$agremiadoEstudio->id_especialidad = "1";
				$agremiadoEstudio->tesis = $estudio->nombre_tesis;
				$agremiadoEstudio->fecha_egresado = $estudio->fecha_egresado;
				$agremiadoEstudio->fecha_graduado = $estudio->fecha_graduado;
				$agremiadoEstudio->libro = $estudio->libro;
				$agremiadoEstudio->folio = $estudio->folio;
				$agremiadoEstudio->estado = 1;
				$agremiadoEstudio->id_usuario_inserta = 1;
				$agremiadoEstudio->save();
				
			}
			/*
			foreach($solicitud->otroestudio as $otroestudio){
			
			}
			*/
			foreach($solicitud->parentesco as $parentesco){
				/*
				$agremiadoSeguro = new AgremiadoSeguro;
				$agremiadoSeguro->id_agremiado = $id_agremiado;
				$agremiadoSeguro->id_parentesco = $this->equivalenciaTipoParentesco($parentesco->id_parentezco);
				$agremiadoSeguro->id_region = "5";
				$agremiadoSeguro->fecha_inicio = null;
				$agremiadoSeguro->fecha_fin = null;
				$agremiadoSeguro->estado = 1;
				$agremiadoSeguro->id_usuario_inserta = 1;
				$agremiadoSeguro->save();
				*/
				$agremiadoParenteco = new AgremiadoParenteco;
				$agremiadoParenteco->id_agremiado = $id_agremiado;
				$agremiadoParenteco->id_parentesco = $this->equivalenciaTipoParentesco($parentesco->id_parentezco);
				$agremiadoParenteco->id_sexo = $this->equivalenciaTipoSexo($parentesco->id_genero);
				$agremiadoParenteco->apellido_nombre = $parentesco->apellido_paterno." ".$parentesco->apellido_materno." ".$parentesco->nombre;
				$agremiadoParenteco->fecha_nacimiento = $parentesco->fecha_nacimiento;
				$agremiadoParenteco->numero_documento = NULL;
				$agremiadoParenteco->estado = 1;
				$agremiadoParenteco->id_usuario_inserta = 1;
				$agremiadoParenteco->save();
				
			}
			
			$data_string3 = '{"idSolicitud":'.$solicitud->idsolicitud.'}';
			$ch3 = curl_init('https://integracion.portalcap2.org.pe/api/v1/collegiate/');		
			curl_setopt($ch3, CURLOPT_CUSTOMREQUEST, "PUT");
			curl_setopt($ch3, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch3, CURLOPT_POSTFIELDS, $data_string3);
			curl_setopt($ch3, CURLOPT_HTTPHEADER, array('x-token: '.$token, 'Content-Type: application/json'));
			curl_setopt($ch3, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($ch3, CURLOPT_SSL_VERIFYPEER, false);
			
			$resultWebApi3 = curl_exec($ch3);
			
			if($errno = curl_errno($ch3)) {
				$error_message = curl_strerror($errno);
				echo "cURL error ({$errno}):\n {$error_message}";
			}
			
			$dataWebApi3 = json_decode($resultWebApi3);
			
		}
		
		/*
		$persona = new Persona;
		$persona->id_tipo_documento = 1;//(ok)
		$persona->numero_documento = 21532344;//(ok)
		$persona->apellido_paterno = 'Rojas1';//(ok)
		$persona->apellido_materno = 'Medina1';//(ok)
		$persona->nombres = 'Julio1';//(ok)
		$persona->fecha_nacimiento = '1985-12-09';//(ok)
		$persona->sexo = 'M';//(ok)
		$persona->id_tipo_persona = 1;
		$persona->estado = 1;
		$persona->id_usuario_inserta = 1;
		$persona->save();
		$id_persona = $persona->id;
		
		$agremiado = new Agremiado;
		$agremiado->id_persona = $id_persona;
		$agremiado->numero_cap = "222333";//(ok)
		$agremiado->id_situacion = "2";//(ok)
		$agremiado->id_usuario_inserta = 1;
		$agremiado->save();
		$id_agremiado = $agremiado->id;
		
		$agremiadoExperienciaLaborale = new AgremiadoExperienciaLaborale;
		$agremiadoExperienciaLaborale->id_agremiado = $id_agremiado;
		$agremiadoExperienciaLaborale->id_experiencia_laboral = "1";
		$agremiadoExperienciaLaborale->estado = 1;
		$agremiadoExperienciaLaborale->id_usuario_inserta = 1;
		$agremiadoExperienciaLaborale->save();
		
		$agremiadoIdioma = new AgremiadoIdioma;
		$agremiadoIdioma->id_agremiado = $id_agremiado;
		$agremiadoIdioma->id_idioma = "1";
		$agremiadoIdioma->id_grado_conocimiento = "1";
		$agremiadoIdioma->estado = 1;
		$agremiadoIdioma->id_usuario_inserta = 1;
		$agremiadoIdioma->save();
		
		$agremiadoEstudio = new AgremiadoEstudio;
		$agremiadoEstudio->id_agremiado = $id_agremiado;
		$agremiadoEstudio->id_universidad = "1";
		$agremiadoEstudio->id_especialidad = "1";
		$agremiadoEstudio->estado = 1;
		$agremiadoEstudio->id_usuario_inserta = 1;
		$agremiadoEstudio->save();
		
		$agremiadoSeguro = new AgremiadoSeguro;
		$agremiadoSeguro->id_agremiado = $id_agremiado;
		$agremiadoSeguro->id_persona = $id_persona;
		$agremiadoSeguro->id_parentesco = "1";
		$agremiadoSeguro->id_region = "1";
		$agremiadoSeguro->fecha_inicio = "24-09-2023";
		$agremiadoSeguro->fecha_fin = "24-09-2025";
		$agremiadoSeguro->estado = 1;
		$agremiadoSeguro->id_usuario_inserta = 1;
		$agremiadoSeguro->save();
		*/
		
		//exit();
		/*************WEB SERVICE - ACTUALIZAR*****************/
		/*
		$data_string3 = '{"idSolicitud":1}';
		$ch3 = curl_init('https://integracion.portalcap2.org.pe/api/v1/collegiate/');		
		curl_setopt($ch3, CURLOPT_CUSTOMREQUEST, "PUT");
		curl_setopt($ch3, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch3, CURLOPT_POSTFIELDS, $data_string3);
		curl_setopt($ch3, CURLOPT_HTTPHEADER, array('x-token: '.$token, 'Content-Type: application/json'));
		curl_setopt($ch3, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch3, CURLOPT_SSL_VERIFYPEER, false);
		
		$resultWebApi3 = curl_exec($ch3);
		
		if($errno = curl_errno($ch3)) {
			$error_message = curl_strerror($errno);
			echo "cURL error ({$errno}):\n {$error_message}";
		}
		//print_r($resultWebApi3);exit();
		$dataWebApi3 = json_decode($resultWebApi3);
		//print_r($dataWebApi3);
		
		$ok = $dataWebApi2->ok;
		$data = $dataWebApi2->data;
		*/
				
		
	
	}
	
	public function equivalenciaIdioma($idioma){
		
		$idioma_nuevo = 0;
		
		switch ($idioma) {
		  case "19":
			$idioma_nuevo=1;//INGLES
			break;
		  case "20":
			$idioma_nuevo=2;//FRANCES
			break;
		  case "21":
			$idioma_nuevo=3;//ITALIANO
			break;
		  case "22":
			$idioma_nuevo=4;//PORTUGUES
			break;
		  case "23":
			$idioma_nuevo=5;//ALEM�N
			break;
		  case "24":
			$idioma_nuevo=999;//OTROS
			break;
		  case "86":
			$idioma_nuevo=999;//ESPA�OL
			break;
		  default:
			$idioma_nuevo=999;//NO EXISTE EN SQL
		}
		
		return $idioma_nuevo;
	
	}
	
	public function equivalenciaTipoNivel($id_nivel){
		
		$id_nivel_nuevo = 0;
		
		switch ($id_nivel) {
		  case "87":
			$id_nivel_nuevo=80;//BASICO
			break;
		  case "88":
			$id_nivel_nuevo=81;//INTERMEDIO
			break;
		  case "89":
			$id_nivel_nuevo=82;//AVANZADO
			break;
		}
		
		return $id_nivel_nuevo;
	
	}
	
	public function equivalenciaTipoDocumento($idtipodocumento){
		
		$idtipodocumento_nuevo = 0;
		
		switch ($idtipodocumento) {
		  case "1":
			$idtipodocumento_nuevo=78;//DNI
			break;
		  case "2":
			$idtipodocumento_nuevo=84;//CARN� DE EXTRANJER�A
			break;
		  case "3":
			$idtipodocumento_nuevo=79;//RUC
			break;
		  case "4":
			$idtipodocumento_nuevo=85;//PASAPORTE
			break;
		  case "5":
			$idtipodocumento_nuevo=259;//OTROS DOCUMENTOS DE IDENTIDAD
			break;
		  case "6":
			$idtipodocumento_nuevo=259;//OTROS DOCUMENTOS DE IDENTIDAD
			break;
		}
		
		return $idtipodocumento_nuevo;
	
	}
	
	public function equivalenciaUniversidad($id_universidad){
		
		$id_universidad_nuevo = 0;
		
		switch ($id_universidad) {
		  case "999":
			$id_universidad_nuevo=1;//ESCUELA TECNICA SUPERIOR DE ARQUITECTURA CORU�A
			break;
		  case "999":
			$id_universidad_nuevo=2;//EXTRANJERO
			break;
		  case "19":
			$id_universidad_nuevo=3;//PILOTO DE COLOMBIA
			break;
		  case "79":
			$id_universidad_nuevo=4;//POLITECNICO DE MILANO
			break;
		  case "64":
			$id_universidad_nuevo=5;//PONTIFICIA UNIV. CATOLICA DE VALPARAISO
			break;
		  case "44":
			$id_universidad_nuevo=6;//PONTIFICIA UNIVERSIDAD CATOLICA DEL PERU
			break;
		  case "42":
			$id_universidad_nuevo=7;//UNIV. ALAS PERUANAS
			break;
		  case "60":
			$id_universidad_nuevo=8;//UNIV. CATOLICA DE SANTA MARIA
			break;
		  case "63":
			$id_universidad_nuevo=9;//UNIV. CIENTIFICA DEL PERU
			break;
		  case "999":
			$id_universidad_nuevo=10;//UNIV. ESTATAL DE GUAYAQUIL
			break;
		  case "65":
			$id_universidad_nuevo=11;//UNIV. JOSE ANTONIO ECHEVARRIA
			break;
		  case "41":
			$id_universidad_nuevo=12;//UNIV. NACIONAL JORGE BASADRE GROHMANN
			break;
		  case "87":
			$id_universidad_nuevo=13;//UNIV. NAVARRA
			break;
		  case "90":
			$id_universidad_nuevo=14;//UNIV. POLITECNICA CATALU�A ESPA�A
			break;
		  case "67":
			$id_universidad_nuevo=15;//UNIV. POLITECNICA DE MADRID
			break;
		  case "96":
			$id_universidad_nuevo=16;//UNIV. SAN IGNACIO DE LOYOLA
			break;
		  case "62":
			$id_universidad_nuevo=17;//UNIV. SAN PEDRO- CHIMBOTE
			break;
		  case "68":
			$id_universidad_nuevo=17;//UNIV. SAN PEDRO- CHIMBOTE
			break;
		  case "17":
			$id_universidad_nuevo=18;//UNIV.AUTONOMA DE GUADALAJARA
			break;
		  case "35":
			$id_universidad_nuevo=19;//UNIV.AUTONOMA DE PUEBLA
			break;
		  case "39":
			$id_universidad_nuevo=20;//UNIV.CATOLICA DE CHILE
			break;
		  case "999":
			$id_universidad_nuevo=21;//UNIV.CATOLICA DEL ECUADOR
			break;
		  case "32":
			$id_universidad_nuevo=22;//UNIV.CATOLICA NUESTRA SRA. DE LA ASUNCION
			break;
		  case "55":
			$id_universidad_nuevo=23;//UNIV.CENTRAL DE VENEZUELA
			break;
		  case "15":
			$id_universidad_nuevo=24;//UNIV.CESAR VALLEJO
			break;
		  case "43":
			$id_universidad_nuevo=25;//UNIV.DE ARQUITECTURA DE MOSCU
			break;
		  case "70":
			$id_universidad_nuevo=26;//UNIV.DE BRASILIA
			break;
		  case "28":
			$id_universidad_nuevo=27;//UNIV.DE BUENOS AIRES
			break;
		  case "47":
			$id_universidad_nuevo=29;//UNIV.DE CAMAGUEY
			break;
		  case "23":
			$id_universidad_nuevo=30;//UNIV.DE GAMA FILHO
			break;
		  case "26":
			$id_universidad_nuevo=31;//UNIV.DE MIAMI
			break;
		  case "34":
			$id_universidad_nuevo=32;//UNIV.DE MINAS GERAIS
			break;
		  case "25":
			$id_universidad_nuevo=33;//UNIV.DE TEXAS (AUSTIN)
			break;
		  case "14":
			$id_universidad_nuevo=34;//UNIV.DEL ALTIPLANO
			break;
		  case "33":
			$id_universidad_nuevo=35;//UNIV.DEL VALLE
			break;
		  case "37":
			$id_universidad_nuevo=36;//UNIV.FEDERAL DE PELOTAS
			break;
		  case "27":
			$id_universidad_nuevo=37;//UNIV.FEDERAL DO RIO GRANDE DO NORTE
			break;
		  case "4":
			$id_universidad_nuevo=38;//UNIV.FEMENINA DEL SAGRADO CORAZON
			break;
		  case "20":
			$id_universidad_nuevo=39;//UNIV.MAYOR DE SAN ANDRES DE BOLIVIA
			break;
		  case "36":
			$id_universidad_nuevo=40;//UNIV.MAYOR DE SAN SIMON
			break;
		  case "29":
			$id_universidad_nuevo=41;//UNIV.NACIONAL DE ARQUITECTURA E ING. CIVIL DE JARKOV
			break;
		  case "21":
			$id_universidad_nuevo=42;//UNIV.NACIONAL DE COLOMBIA
			break;
		  case "22":
			$id_universidad_nuevo=43;//UNIV.NACIONAL DE CORDOVA - ARGENTINA
			break;
		  case "1":
			$id_universidad_nuevo=44;//UNIV.NACIONAL DE INGENIERIA
			break;
		  case "18":
			$id_universidad_nuevo=45;//UNIV.NACIONAL DE LA PLATA
			break;
		  case "38":
			$id_universidad_nuevo=46;//UNIV.NACIONAL DE PIURA
			break;
		  case "24":
			$id_universidad_nuevo=47;//UNIV.NACIONAL DE SAN JUAN DE ARGENTINA
			break;
		  case "7":
			$id_universidad_nuevo=48;//UNIV.NACIONAL DEL CENTRO DEL PERU
			break;
		  case "51":
			$id_universidad_nuevo=50;//UNIV.NACIONAL EXPERIMENTAL DEL TACHIRA
			break;
		  case "3":
			$id_universidad_nuevo=51;//UNIV.NACIONAL FEDERICO VILLAREAL
			break;
		  case "31":
			$id_universidad_nuevo=52;//UNIV.NACIONAL LOS ANDES
			break;
		  case "5":
			$id_universidad_nuevo=53;//UNIV.NACIONAL SAN AGUSTIN DE AREQUIPA
			break;
		  case "6":
			$id_universidad_nuevo=54;//UNIV.NACIONAL SAN ANTONIO DE ABAD DEL CUSCO
			break;
		  case "9":
			$id_universidad_nuevo=55;//UNIV.PARTICULAR DE CHICLAYO
			break;
		  case "16":
			$id_universidad_nuevo=56;//UNIV.PEDRO RUIZ GALLO
			break;
		  case "11":
			$id_universidad_nuevo=57;//UNIV.PERUANA DE CIENCIAS APLICADAS
			break;
		  case "10":
			$id_universidad_nuevo=58;//UNIV.PRIVADA ANTENOR ORREGO DE TRUJILLO
			break;
		  case "12":
			$id_universidad_nuevo=59;//UNIV.PRIVADA DE TACNA
			break;
		  case "13":
			$id_universidad_nuevo=60;//UNIV.PRIVADA DEL NORTE
			break;
		  case "2":
			$id_universidad_nuevo=61;//UNIV.RICARDO PALMA
			break;
		  case "46":
			$id_universidad_nuevo=62;//UNIVERSIDAD DE CHILE
			break;
		  case "66":
			$id_universidad_nuevo=63;//UNIVERSIDAD DE HUANUCO
			break;
		  case "69":
			$id_universidad_nuevo=64;//UNIVERSIDAD DE PALERMO
			break;
		  case "999":
			$id_universidad_nuevo=65;//UNIVERSIDAD METROPOLITANA DE MANCHESTER - INGLATER
			break;
		  case "57":
			$id_universidad_nuevo=66;//UNIVERSIDAD SAN MARTIN DE PORRES
			break;
		  case "95":
			$id_universidad_nuevo=67;//UNIVERSITA DELLA SVIZZERA ITALIANA
			break;
		  case "999":
			$id_universidad_nuevo=68;//Universidad Metropolitana de Manchester - Inglaterra
			break;
		  case "16":
			$id_universidad_nuevo=69;//UNIV.NACIONAL PEDRO RUIZ GALLO
			break;
		  case "999":
			$id_universidad_nuevo=70;//PRINCETON UNIVERSITY
			break;
		  case "999":
			$id_universidad_nuevo=71;//UNIV.SAN PABLO CEU
			break;
		  case "78":
			$id_universidad_nuevo=72;//UNIVERSIDAD POLIT�CNICA DE VAL�NCIA
			break;
		  case "999":
			$id_universidad_nuevo=73;//UNIVERSIDAD T�CNICA DE LISBOA
			break;
		  case "999":
			$id_universidad_nuevo=74;//THE COOPERUNION FORTHE ADVANCEMENT
			break;
		  case "104":
			$id_universidad_nuevo=75;//UNIV.PRIVADA TELESUP
			break;
		  case "119":
			$id_universidad_nuevo=75;//UNIV.PRIVADA TELESUP
			break;
		  case "10":
			$id_universidad_nuevo=76;//UNIV. PRIVADA ANTENOR ORREGO
			break;
		  case "106":
			$id_universidad_nuevo=77;//UNIVERSIDAD PERUANA UNION
			break;
		  case "98":
			$id_universidad_nuevo=78;//ESCUELA DE AUQUITECTURA DE VERSALLES
			break;
		  case "999":
			$id_universidad_nuevo=79;//UNIVERSIDAD FRANCISCO DE PAULA SANTANDER
			break;
		  case "55":
			$id_universidad_nuevo=80;//UNIVERSIDAD CENTRAL DE VENEZUELA
			break;
		  case "5":
			$id_universidad_nuevo=81;//UNIVERSIDAD NACIONAL DE SAN AGUSTIN DE AREQUIPA
			break;
		  case "101":
			$id_universidad_nuevo=82;//CATOLICA SANTO TORIBIO DE MOGROVEJO
			break;
		  case "107":
			$id_universidad_nuevo=83;//UNIVERSIDAD DE LIMA
			break;
		  case "71":
			$id_universidad_nuevo=84;//UNIVERSIDAD NACIONAL HERMILIO VALDIZAN
			break;
		  case "92":
			$id_universidad_nuevo=85;//UNIVERSIDAD PERUANA LOS ANDES
			break;
		  case "102":
			$id_universidad_nuevo=86;//UNIVERSIDAD SE�OR DE SIPAN
			break;
		  case "999":
			$id_universidad_nuevo=87;//UNIV. NACIONAL DEL CALLAO
			break;
		  case "15":
			$id_universidad_nuevo=88;//UNIVERSIDAD PRIVADA CESAR VALLEJO - TRUJILLO
			break;
		  case "97":
			$id_universidad_nuevo=89;//UNIVERSIDAD CONTINENTAL
			break;
		  case "999":
			$id_universidad_nuevo=90;//UNIVERSIDAD CATOLICA SEDES SAPIENTIAE
			break;
		  case "999":
			$id_universidad_nuevo=91;//Universidad Tecnol�gica del Per�
			break;
		  case "109":
			$id_universidad_nuevo=92;//UNIVERSIDAD NACIONAL DE SAN MARTIN
			break;
		  case "999":
			$id_universidad_nuevo=93;//UNIVERSIDAD DE GRANADA
			break;
		  case "999":
			$id_universidad_nuevo=94;//CELESTE
			break;
		  case "111":
			$id_universidad_nuevo=95;//UNIV. ARISTOTELES DE TESALONICA - GRECIA
			break;
		  case "13":
			$id_universidad_nuevo=96;//UNIV. PRIVADA DEL NORTE - SEDE CAJAMARCA
			break;
		  case "999":
			$id_universidad_nuevo=97;//PONTIFICIA UNIV. CATOLICA DE MINAS GERAIS
			break;
		  case "999":
			$id_universidad_nuevo=98;//UNIV. CATOLICA DE HONDURAS
			break;
		  case "999":
			$id_universidad_nuevo=99;//UNIV. DE LAS PALMAS DE GRAN CANARIA
			break;
		  case "999":
			$id_universidad_nuevo=100;//ECOLE NATIONALE SUPERIEURE D�ARCHITECTURE PAIS MAL
			break;
		  case "999":
			$id_universidad_nuevo=101;//UNIVERSIDAD CATOLICA BOLIVIANA SAN PABLO
			break;
		  case "999":
			$id_universidad_nuevo=102;//UNIVERSIDAD ANHEMBI MORUMBI - BRASIL
			break;
		  case "114":
			$id_universidad_nuevo=103;//TULANE UNIVERSITY
			break;
		  case "999":
			$id_universidad_nuevo=104;//ECOLES NATIONAL SUPERIEUR D�ARCHITECTUE DE MONTPEL
			break;
		  case "78":
			$id_universidad_nuevo=105;//ESCUELA TECNIA SUPERIOR DE ARQUITECTURA DE VALENCI
			break;
		  case "103":
			$id_universidad_nuevo=106;//UNIV. ANDINA NESTOR CACERES VELASQUEZ
			break;
		  case "120":
			$id_universidad_nuevo=106;//UNIV. ANDINA NESTOR CACERES VELASQUEZ
			break;
		  case "74":
			$id_universidad_nuevo=107;//UNIVERSIDAD DE SEVILLA
			break;
		  case "999":
			$id_universidad_nuevo=108;//TECNOLOGICA DE COSTA RICA
			break;
		  case "118":
			$id_universidad_nuevo=109;//UNIVERSIDAD NACIONAL SAN LUIS GONZAGA - ICA
			break;
			
			
		}
		
		return $id_universidad_nuevo;
	
	}
		
	public function equivalenciaTipoParentesco($id_parentesco){
		
		$id_parentesco_nuevo = 0;
		
		switch ($id_parentesco) {
		  case "82":
			$id_parentesco_nuevo=66;//PADRE
			break;
		  case "83":
			$id_parentesco_nuevo=67;//MADRE
			break;
		  case "84":
			$id_parentesco_nuevo=63;//ESPOSO
			break;
		  case "85":
			$id_parentesco_nuevo=63;//ESPOSA
			break;
		  case "92":
			$id_parentesco_nuevo=108;//HERMANO
			break;
		  case "93":
			$id_parentesco_nuevo=108;//HERMANA
			break;
		  case "94":
			$id_parentesco_nuevo=65;//HIJO
			break;
		  case "95":
			$id_parentesco_nuevo=65;//HIJA
			break;
		  case "96":
			$id_parentesco_nuevo=102;//ABUELO
			break;
		  case "97":
			$id_parentesco_nuevo=102;//ABUELA
			break;
		  case "98":
			$id_parentesco_nuevo=109;//NIETO
			break;
		  case "99":
			$id_parentesco_nuevo=109;//NIETA
			break;
		  case "100":
			$id_parentesco_nuevo=112;//SOBRINO
			break;
		  case "101":
			$id_parentesco_nuevo=372;//HERMANA
			break;
		}
		
		return $id_parentesco_nuevo;
	
	}
	
	public function equivalenciaGrupoSanguineo($gruposanguineo){
		
		$gruposanguineo_nuevo = 0;
		
		switch ($gruposanguineo) {
		  case "O Positivo":
			$gruposanguineo_nuevo=1;//7
			break;
		  case "O Negativo":
			$gruposanguineo_nuevo=2;//8
			break;
		  case "A Negativo":
			$gruposanguineo_nuevo=3;//9
			break;
		  case "A Positivo":
			$gruposanguineo_nuevo=4;//10
			break;
		  case "B Negativo":
			$gruposanguineo_nuevo=5;//75
			break;
		  case "B Positivo":
			$gruposanguineo_nuevo=6;//76
			break;
		  case "AB Positivo":
			$gruposanguineo_nuevo=7;//77
			break;
		  case "AB Negativo":
			$gruposanguineo_nuevo=8;//78
			break;
		}
		
		return $gruposanguineo_nuevo;
	
	}
	
	public function equivalenciaEstadoCivil($estadocivil){
		
		$estadocivil_nuevo = 0;
		
		switch ($estadocivil) {
		  case "SOLTERO (A)":
			$estadocivil_nuevo=5;//13
			break;
		  case "CASADO (A)":
			$estadocivil_nuevo=6;//14
			break;
		  case "VIUDO (A)":
			$estadocivil_nuevo=87;//15
			break;
		  case "DIVORCIADO (A)":
			$estadocivil_nuevo=7;//16
			break;
		}
		
		return $estadocivil_nuevo;
	
	}
	
	public function equivalenciaTipoSexo($id_genero){
		
		$id_genero_nuevo = 0;
		
		switch ($id_genero) {
		  case "11":
			$id_genero_nuevo=3;//MASCULINO
			break;
		  case "12":
			$id_genero_nuevo=4;//FEMENINO
			break;
		}
		
		return $id_genero_nuevo;
	
	}
	
	public function obtener_agremiado($tipo_documento,$numero_documento){

        $agremiado_model = new Agremiado;
        //$valorizaciones_model = new Valorizacione;
        $sw = true;
        $agremiado = $agremiado_model->getAgremiado($tipo_documento,$numero_documento);
        $array["sw"] = $sw;
        $array["agremiado"] = $agremiado;
        echo json_encode($array);

    }

	public function obtener_datos_agremiado($numero_cap){

        $agremiado_model = new Agremiado;
        //$valorizaciones_model = new Valorizacione;
        $sw = true;
        $agremiado = $agremiado_model->getAgremiadoDatos($numero_cap);
        $array["sw"] = $sw;
        $array["agremiado"] = $agremiado;
        echo json_encode($array);

    }

	public function obtener_datos_agremiado_revisor_urbano($numero_cap){

        $agremiado_model = new Agremiado;
        //$valorizaciones_model = new Valorizacione;
        $sw = true;
        $agremiado = $agremiado_model->getAgremiadoDatosRevisorUrbano($numero_cap);
        $array["sw"] = $sw;
        $array["agremiado"] = $agremiado;
        echo json_encode($array);

    }

	public function obtener_local($id_regional){
		
		$local_model = new Locale;
		$local = $local_model->getLocal($id_regional);
		echo json_encode($local);
	}

	public function modal_suspension($id){
		
		$tablaMaestra_model = new TablaMaestra;
		$agremiado_model = new Agremiado;
		
		if($id>0){
			$suspension = Suspensione::find($id);
		}else{
			$agremiado = $agremiado_model->getAgremiadoAll();
			$suspension = new Suspensione;

		}
		
		$universidad = $tablaMaestra_model->getMaestroByTipo(85);
		$especialidad = $tablaMaestra_model->getMaestroByTipo(86);
		
		return view('frontend.agremiado.modal_suspension',compact('id','suspension','agremiado'));
	
	}

	public function send_agremiado_suspension(Request $request){
		
		$id_user = Auth::user()->id;

		if($request->id == 0){
			$suspension = new Suspensione;
		}else{
			$suspension = Suspensione::find($request->id);
		}
		
		$suspension->id_agremiado = $request->id_agremiado;
		$suspension->fecha_inicio = $request->fecha_inicio;
		$suspension->fecha_fin = $request->fecha_inicio;
		$suspension->documento = $request->ruta_documento;
		//$suspension->estado = 1;
		$suspension->id_usuario_inserta = $id_user;
		$suspension->save();
			
    }
	
	public function obtener_suspension($id_agremiado){

        $suspension_model = new Suspensione;
        $sw = true;
        $suspension_lista = $suspension_model->listar_suspension_agremiado($id_agremiado);
        //print_r($parentesco_lista);exit();
        return view('frontend.agremiado.lista_suspension',compact('suspension_lista'));

    }
			
}

