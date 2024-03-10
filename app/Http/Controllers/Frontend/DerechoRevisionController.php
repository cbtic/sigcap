<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DerechoRevision;
use App\Models\Solicitude;
use App\Models\Agremiado;
use App\Models\Persona;
use App\Models\Liquidacione;
use App\Models\Municipalidade;
use App\Models\Ubigeo;
use App\Models\TablaMaestra;
use App\Models\Proyectista;
use App\Models\Propietario;
use App\Models\Proyecto;
use App\Models\Empresa;
use Carbon\Carbon;
use Auth;

class DerechoRevisionController extends Controller
{

    public function __construct(){

		$this->middleware(function ($request, $next) {
			if(!Auth::check()) {
                return redirect('login');
            }
			return $next($request);
    	});
	}

    function consulta_derecho_revision(){

        $tablaMaestra_model = new TablaMaestra;
		$derecho_revision = new DerechoRevision;
        $agremiado = new Agremiado;
        $persona = new Persona;
        $liquidacion = new Liquidacione;
        $municipalidad_modal = new Municipalidade;
        $ubigeo_model = new Ubigeo;
        $departamento = $ubigeo_model->getDepartamento();
        $municipalidad = $municipalidad_modal->getMunicipalidadOrden();
        
        $tipo_proyecto = $tablaMaestra_model->getMaestroByTipo(25);
		$tipo_solicitud = $tablaMaestra_model->getMaestroByTipo(25);
		$estado_proyecto = $tablaMaestra_model->getMaestroByTipo(118);
		
        return view('frontend.derecho_revision.all',compact('derecho_revision','agremiado','persona','liquidacion','municipalidad','departamento','tipo_proyecto','estado_proyecto', 'tipo_solicitud'));
    }

	public function modal_credipago($id){
		 
		$DerechoRevision_model = new DerechoRevision;
        $liquidacion = $DerechoRevision_model->getLiquidacionByIdSolicitud($id);
		
        return view('frontend.derecho_revision.modal_liquidacion',compact('liquidacion'));
		
    }
	
	public function modal_proyectista($id){
		 
		$DerechoRevision_model = new DerechoRevision;
        $proyectista = $DerechoRevision_model->getProyectistaByIdSolicitud($id);
		
        return view('frontend.derecho_revision.modal_proyectista',compact('proyectista'));
		
    }
	
	public function modal_propietario($id){
		 
		$DerechoRevision_model = new DerechoRevision;
        $propietario = $DerechoRevision_model->getPropietarioByIdSolicitud($id);
		
        return view('frontend.derecho_revision.modal_propietario',compact('propietario'));
		
    }
	
	function consulta_solicitud_derecho_revision(){

        //$tablaMaestra_model = new TablaMaestra;
		$derecho_revision = new DerechoRevision;
        $agremiado = new Agremiado;
        $persona = new Persona;
        $liquidacion = new Liquidacione;
        $municipalidad_modal = new Municipalidade;
        $ubigeo_model = new Ubigeo;
		$tablaMaestra_model = new TablaMaestra;
		
        $estado_solicitud = $tablaMaestra_model->getMaestroByTipo(118);
        $distrito = $ubigeo_model->getDistritoLima();
        $municipalidad = $municipalidad_modal->getMunicipalidadOrden();
		
        
        
        return view('frontend.derecho_revision.all_solicitud',compact('derecho_revision','agremiado','persona','liquidacion','municipalidad','distrito','estado_solicitud'));
    }

    public function listar_derecho_revision_ajax(Request $request){
	
		$derecho_revision_model = new DerechoRevision;
		$p[]=$request->nombre_proyecto;
        $p[]=$request->id_tipo_proyecto;
        $p[]="";
        $p[]="";
        $p[]=$request->id_municipalidad;
        $p[]="";
        $p[]="";
        $p[]="";
        $p[]="";
        $p[]=$request->fecha_registro;
		$p[]=$request->id_estado_proyecto;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $derecho_revision_model->listar_derecho_revision_ajax($p);
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
    
    public function send_derecho_revision_nuevoDerechoRevision(Request $request){

		$id_user = Auth::user()->id;

		if($request->id == 0){
			$derecho_revision = new DerechoRevision;
		}else{
			$derecho_revision = DerechoRevision::find($request->id);
		}
		
		$derecho_revision->nombre = $request->nombre;
		//$profesion->estado = 1;
		$derecho_revision->id_usuario_inserta = $id_user;
		$derecho_revision->save();
    }
	
	public function obtener_solicitud($id){
		
		$derechoRevision_model = new DerechoRevision;
		$solicitud = $derechoRevision_model->getSolicitudById($id);
		
		echo json_encode($solicitud);
	}
	
	public function send_credipago(Request $request){
		
		$derechoRevision_model = new DerechoRevision;
		
		$solicitud = Solicitude::find($request->id);
		$valor_obra = $solicitud->valor_obra;
		$area_total = $solicitud->area_total;
		$id_tipo_solicitud = $solicitud->id_tipo_solicitud;
		
		$uit = 4950;
		
		/*****Edificaciones*********/
		if($id_tipo_solicitud == 123){
			
			$sub_total 	= (0.0005*$valor_obra);
			$igv		= (0.18*$sub_total);
			$total		= $sub_total + $igv;
			
			$sub_total_minimo 	= (0.025*$uit);//123.75
			$igv_minimo			= (0.18*$sub_total_minimo);//22.275
			$total_minimo		= $sub_total_minimo + $igv_minimo;//146.025
			
			if($total<$total_minimo){
				$sub_total 	= $sub_total_minimo;
				$igv		= $igv_minimo;
				$total		= $total_minimo;
			}
			
		}
		
		/*****Habilitaciones urbanas*********/
		if($id_tipo_solicitud == 124){
			
			$m2 = 0.23405;
			
			$sub_total 	= ($m2*$area_total);
			$igv		= (0.18*$sub_total);
			$total		= $sub_total + $igv;
			
			$total_minimo		= 1170;
			$igv_minimo			= $total_minimo/1.18;
			$sub_total_minimo 	= $total_minimo - $igv_minimo;
			
			$total_maximo		= 60000*$m2;
			$igv_maximo			= $total_maximo/1.18;
			$sub_total_maximo 	= $total_maximo - $igv_maximo;
			
			if($total<$total_minimo){
				$sub_total 	= $sub_total_minimo;
				$igv		= $igv_minimo;
				$total		= $total_minimo;
			}
			
			if($total>$total_maximo){
				$sub_total 	= $sub_total_maximo;
				$igv		= $igv_maximo;
				$total		= $total_maximo;
			}
			
		}
		
		$codigo1 = $derechoRevision_model->getCodigoSolicitud($id_tipo_solicitud);
		$codigo2 = $derechoRevision_model->getCountProyectoTipoSolicitud($solicitud->id_proyecto,$id_tipo_solicitud);
		$codigo = $codigo1.$codigo2;
		
		$id_user = Auth::user()->id;		
		$liquidacion = new Liquidacione;
		$liquidacion->id_solicitud = $request->id;
		$liquidacion->fecha = Carbon::now()->format('Y-m-d');;
		$liquidacion->credipago = $codigo;
		$liquidacion->sub_total = $sub_total;
		$liquidacion->igv = $igv;
		$liquidacion->total = $total;
		$liquidacion->observacion = "obs";
		$liquidacion->id_usuario_inserta = $id_user;
		$liquidacion->save();
		
		$id_liquidacion = $liquidacion->id;
		echo $id_liquidacion;
		
    }

	public function modal_solicitud_nuevoSolicitud($id){
		
		$proyectista = new Proyectista;
		$derechoRevision = new DerechoRevision;
		$agremiado = new Agremiado;
		$persona = new Persona;
		$proyecto = new Proyecto;
		$tablaMaestra_model = new TablaMaestra;
		
        $sitio = $tablaMaestra_model->getMaestroByTipo(33);
        $zona = $tablaMaestra_model->getMaestroByTipo(34);
		$tipo = $tablaMaestra_model->getMaestroByTipo(35);
		//$proyectista = $derechoRevision_model->getProyectistaByIdSolicitud($id);
		//$proyectista = $proyectista_model->getProyectistaCap();
		
        return view('frontend.derecho_revision.modal_solicitud_nuevoSolicitud',compact('id','derechoRevision','proyectista','agremiado','persona','proyecto','sitio','zona','tipo'));
		
    }

	function consulta_derecho_revision_nuevo(){

        $proyectista = new Proyectista;
		$derechoRevision = new DerechoRevision;
		$agremiado = new Agremiado;
		$persona = new Persona;
		$proyecto = new Proyecto;
		$tablaMaestra_model = new TablaMaestra;
		$ubigeo_model = new Ubigeo;

		$departamento = $ubigeo_model->getDepartamento();
        $sitio = $tablaMaestra_model->getMaestroByTipo(33);
        $zona = $tablaMaestra_model->getMaestroByTipo(34);
		$tipo = $tablaMaestra_model->getMaestroByTipo(35);
		
        return view('frontend.derecho_revision.all_nuevoDerecho',compact('derechoRevision','proyectista','agremiado','persona','proyecto','sitio','zona','tipo','departamento'));
    }

	public function send_nuevo_registro_solicitud(Request $request){

		$id_user = Auth::user()->id;
		$agremiado = Agremiado::where("numero_cap",$request->numero_cap)->where("estado","1")->first();
		$ubigeo = $request->distrito;
		$id_ubi = Ubigeo::where("id_ubigeo",$ubigeo)->where("estado","1")->first();
		//$ubigeo = Ubigeo::where("numero_cap",$request->numero_cap)->where("estado","1")->first();

		if($request->id == 0){
			$derecho_revision = new DerechoRevision;
			$proyecto = new Proyecto;
		}else{
			$derecho_revision = DerechoRevision::find($request->id);
			$proyecto = Proyecto::find($request->id);
		}
		
		$derecho_revision->id_regional = 5;
		$derecho_revision->fecha_registro = Carbon::now()->format('Y-m-d');;
		$derecho_revision->numero_revision = $request->n_revision;
		$derecho_revision->direccion = $request->direccion_proyecto;
		$derecho_revision->id_ubigeo = $id_ubi->id;
		$derecho_revision->id_proyectista = $agremiado->id;
		$derecho_revision->id_proyecto = $proyecto->id;
		$derecho_revision->id_usuario_inserta = $id_user;
		$derecho_revision->save();

		$proyecto->id_ubigeo = $request->departamento.$request->provincia.$request->distrito;
		$proyecto->nombre = $request->nombre_proyecto;
		$proyecto->parcela = $request->parcela;
		$proyecto->super_manzana = $request->superManzana;
		$proyecto->direccion = $request->direccion_proyecto;
		$proyecto->lote = $request->lote;
		$proyecto->fila = $request->fila;
		$proyecto->id_usuario_inserta = $id_user;
		$proyecto->save();
    }

	public function modal_nuevo_proyectista($id){
		 
		$proyectista = new Proyectista();
		$derechoRevision = new DerechoRevision;
		$agremiado = new Agremiado;
		$persona = new Persona;
		
        return view('frontend.derecho_revision.modal_nuevo_proyectista',compact('id','proyectista','agremiado','persona'));
		
    }

	public function send_nueno_proyectista(Request $request){

		$id_user = Auth::user()->id;
		$agremiado = Agremiado::where("numero_cap",$request->numero_cap)->where("estado","1")->first();

		if($request->id == 0){
			$proyectista = new Proyectista;
		}else{
			$proyectista = Proyectista::find($request->id);
		}
		
		$proyectista->id_agremiado = $agremiado->id;
		$proyectista->celular = $request->celular;
		$proyectista->email = $request->email;
		//$proyectista->firma = $request->nombre;
		//$profesion->estado = 1;
		$proyectista->id_usuario_inserta = $id_user;
		$proyectista->save();
    }

	public function modal_nuevo_propietario($id){
		 
		$proyectista = new Proyectista();
		$derechoRevision = new DerechoRevision;
		$agremiado = new Agremiado;
		$tablaMaestra_model = new TablaMaestra;
		$persona = new Persona;
		$empresa = new Empresa;

		$tipo_documento = $tablaMaestra_model->getMaestroByTipo(16);
		
        return view('frontend.derecho_revision.modal_nuevo_propietario',compact('id','tipo_documento','empresa','proyectista','agremiado','persona'));
		
    }

	public function send_nueno_propietario(Request $request){

		$id_user = Auth::user()->id;
		$persona = Persona::where("numero_documento",$request->dni_propietario)->where("estado","1")->first();
		$empresa = Empresa::where("ruc",$request->ruc_propietario)->where("estado","1")->first();

		if($request->id == 0){
			$propietario = new Propietario;
		}else{
			$propietario = Propietario::find($request->id);
		}

		if($persona){

			$propietario->id_persona = $persona->id;
			$propietario->celular = $request->celular_dni;
			$propietario->email = $request->email_dni;
			//$proyectista->firma = $request->nombre;
			//$profesion->estado = 1;
			$propietario->id_usuario_inserta = $id_user;
			$propietario->save();
		}else if($empresa){

			$propietario->id_empresa = $empresa->id;
			$propietario->celular = $request->telefono_ruc;
			$propietario->email = $request->email_ruc;
			//$proyectista->firma = $request->nombre;
			//$profesion->estado = 1;
			$propietario->id_usuario_inserta = $id_user;
			$propietario->save();
		}
    }

	public function modal_nuevo_infoProyecto($id){
		 
		$proyectista = new Proyectista();
		$derechoRevision = new DerechoRevision;
		$agremiado = new Agremiado;
		$persona = new Persona;
		
        return view('frontend.derecho_revision.modal_nuevo_infoProyecto',compact('id','proyectista','agremiado','persona'));
		
    }

	public function send_nueno_infoProyecto(Request $request){

		$id_user = Auth::user()->id;
		$agremiado = Agremiado::where("numero_cap",$request->numero_cap)->where("estado","1")->first();

		if($request->id == 0){
			$proyectista = new Proyectista;
		}else{
			$proyectista = Proyectista::find($request->id);
		}
		
		$proyectista->id_agremiado = $agremiado->id;
		$proyectista->celular = $request->celular;
		$proyectista->email = $request->email;
		//$proyectista->firma = $request->nombre;
		//$profesion->estado = 1;
		$proyectista->id_usuario_inserta = $id_user;
		$proyectista->save();
    }

	public function upload_solicitud(Request $request){
		
		$filename = date("YmdHis") . substr((string)microtime(), 1, 6);
		$type="";
		$filepath = public_path('img/derecho_revision/');
		
		$type=$this->extension($_FILES["file"]["name"]);
		move_uploaded_file($_FILES["file"]["tmp_name"], $filepath . $filename.".".$type);
		
		$archivo = $filename.".".$type;
		
		$this->importar_solicitud($archivo);
		
	}

	public function importar_solicitud($archivo){

	}

	public function modal_nuevo_comprobante($id){
		 
		$proyectista = new Proyectista();
		$derechoRevision = new DerechoRevision;
		$agremiado = new Agremiado;
		$persona = new Persona;
		$tablaMaestra_model = new TablaMaestra;
		$empresa = new Empresa;

		$tipo_documento = $tablaMaestra_model->getMaestroByTipo(16);
		
        return view('frontend.derecho_revision.modal_nuevo_comprobante',compact('id','proyectista','agremiado','persona','derechoRevision','empresa','tipo_documento'));
		
    }

	public function send_nueno_comprobante(Request $request){

		$id_user = Auth::user()->id;
		$agremiado = Agremiado::where("numero_cap",$request->numero_cap)->where("estado","1")->first();

		if($request->id == 0){
			$proyectista = new Proyectista;
		}else{
			$proyectista = Proyectista::find($request->id);
		}
		
		$proyectista->id_agremiado = $agremiado->id;
		$proyectista->celular = $request->celular;
		$proyectista->email = $request->email;
		//$proyectista->firma = $request->nombre;
		//$profesion->estado = 1;
		$proyectista->id_usuario_inserta = $id_user;
		$proyectista->save();
    }
}
