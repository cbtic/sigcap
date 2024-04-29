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
use App\Models\Valorizacione;
use App\Models\Concepto;
use App\Models\Parametro;
use App\Models\NumeracionDocumento;
use App\Models\UsoEdificacione;
use App\Models\Presupuesto;
use App\Models\SolicitudDocumento;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
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
		$tipo_solicitud = $tablaMaestra_model->getMaestroByTipo(24);
		$estado_proyecto = $tablaMaestra_model->getMaestroByTipo(118);
		$distrito = $ubigeo_model->getDistritoLima();
		
        return view('frontend.derecho_revision.all',compact('derecho_revision','agremiado','persona','liquidacion','municipalidad','departamento','tipo_proyecto','estado_proyecto', 'tipo_solicitud','distrito'));
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
		$tipo_proyecto = $tablaMaestra_model->getMaestroByTipo(25);
		$tipo_solicitud = $tablaMaestra_model->getMaestroByTipo(24);
        
        return view('frontend.derecho_revision.all_solicitud',compact('derecho_revision','agremiado','persona','liquidacion','municipalidad','distrito','estado_solicitud','tipo_proyecto','tipo_solicitud'));
    }

	public function listar_derecho_revision_ajax(Request $request){
	
		$derecho_revision_model = new DerechoRevision;
		$p[]=$request->anio;
		$p[]=$request->nombre_proyecto;
        $p[]=$request->distrito;
        $p[]=$request->numero_cap;
        $p[]=$request->proyectista;
        $p[]=$request->numero_documento;
        $p[]=$request->propietario;
        $p[]=$request->tipo_proyecto;
        $p[]=$request->tipo_solicitud;
        $p[]=$request->credipago;
		$p[]=$request->municipalidad;
        $p[]=$request->direccion;
		$p[]=$request->n_solicitud;
		$p[]=$request->codigo;
		$p[]=$request->estado_proyecto;
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

    public function listar_derecho_revision_HU_ajax(Request $request){
	
		$derecho_revision_model = new DerechoRevision;
		$p[]=$request->anio;
		$p[]=$request->nombre_proyecto;
        $p[]=$request->distrito;
        $p[]=$request->numero_cap;
        $p[]=$request->proyectista;
        $p[]=$request->numero_documento;
        $p[]=$request->propietario;
        $p[]=$request->tipo_proyecto;
        $p[]=$request->tipo_solicitud;
        $p[]=$request->credipago;
		$p[]=$request->municipalidad;
        $p[]=$request->direccion;
		$p[]=$request->estado_proyecto;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $derecho_revision_model->listar_derecho_revision_HU_ajax($p);
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
		$propietario_model = new Propietario;

		$sw = true;
		
		$solicitud = Solicitude::find($request->id);
		$valor_obra = $solicitud->valor_obra;
		$area_total = $solicitud->area_total;
		$id_tipo_solicitud = $solicitud->id_tipo_solicitud;

		$propietario = Propietario::where("id_solicitud",$request->id)->where("estado","1")->first();
		$empresa = Empresa::where("id",$propietario->id_empresa)->where("estado","1")->first();
		$empresa_cantidad = Empresa::where("ruc",$empresa->ruc)->where("estado","1")->count();
		
		//print_r($empresa_cantidad);exit();
		if($empresa_cantidad==1){

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

				$concepto = Concepto::where("id",26474)->where("estado","1")->first();
				
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

				$concepto = Concepto::where("id",26483)->where("estado","1")->first();
				
			}
			
			$codigo1 = $derechoRevision_model->getCodigoSolicitud($id_tipo_solicitud);
			$codigo2 = $derechoRevision_model->getCountProyectoTipoSolicitud($solicitud->id_proyecto,$id_tipo_solicitud);
			$codigo = $codigo1.$codigo2;
			
			$id_user = Auth::user()->id;
			$liquidacion = new Liquidacione;
			$liquidacion->id_solicitud = $request->id;
			$liquidacion->fecha = Carbon::now()->format('Y-m-d');
			$liquidacion->credipago = $codigo;
			$liquidacion->sub_total = $sub_total;
			$liquidacion->igv = $igv;
			$liquidacion->total = $total;
			$liquidacion->observacion = "obs";
			$liquidacion->id_usuario_inserta = $id_user;
			$liquidacion->save();
			
			$id_liquidacion = $liquidacion->id;
			echo $id_liquidacion;
			
			$valorizacion = new Valorizacione;
			$valorizacion->id_modulo = 7;
			$valorizacion->pk_registro = $liquidacion->id;
			$valorizacion->id_concepto = $concepto->id;
			$valorizacion->id_empresa = $empresa->id;
			$valorizacion->monto = $liquidacion->total;
			$valorizacion->id_moneda = $concepto->id_moneda;
			$valorizacion->fecha = Carbon::now()->format('Y-m-d');
			$valorizacion->fecha_proceso = Carbon::now()->format('Y-m-d');
			$valorizacion->descripcion = $concepto->denominacion ." - ". $liquidacion->credipago;
			//$valorizacion->estado = 1;
			//print_r($valorizacion->descripcion).exit();
			$valorizacion->id_usuario_inserta = $id_user;
			$valorizacion->save();
			$sw = true;
		}else{
			$sw = false;
		}
		
		/*$array["sw"] = $sw;
		echo json_encode($array);*/

		$datos_formateados = [];

        
		$datos_formateados[] = [
			'sw' => $sw,
		];
        
        return response()->json($datos_formateados);
		
		
    }
	
	public function send_credipago_liquidacion(Request $request){
		
		//exit();
		
		$derechoRevision_model = new DerechoRevision;
		$propietario_model = new Propietario;

		$sw = true;
		
		$solicitud = Solicitude::find($request->id);
		$valor_obra = $solicitud->valor_obra;
		$area_total = $solicitud->area_total;
		$id_tipo_solicitud = $solicitud->id_tipo_solicitud;

		//if($request->tipo_liquidacion1==136)$valor_obra = $request->total2;
		
		if($request->instancia==250)$valor_obra = $request->valor_reintegro;

		$propietario = Propietario::where("id_solicitud",$request->id)->where("estado","1")->first();
		
		if(isset($propietario->id_empresa) && $propietario->id_empresa>0){
			$empresa = Empresa::where("id",$propietario->id_empresa)->where("estado","1")->first();
			$empresa_cantidad = Empresa::where("ruc",$empresa->ruc)->where("estado","1")->count();
		}
		
		if(isset($propietario->id_persona) && $propietario->id_persona>0){
			$persona = Persona::where("id",$propietario->id_persona)->where("estado","1")->first();
			$empresa_cantidad = Persona::where("numero_documento",$persona->numero_documento)->where("estado","1")->count();
		}
		
		if($empresa_cantidad==1){
			
			$anio = Carbon::now()->year;
			$parametro = Parametro::where("anio",$anio)->where("estado",1)->orderBy("id","desc")->first();
			
			$uit = $parametro->valor_uit;
		
			/*****Edificaciones*********/
			if($id_tipo_solicitud == 123){
				
				if($request->tipo_liquidacion1==136){
					//$valor_obra = $request->total2;
					$sub_total 	= $request->sub_total2;
					$igv		= $request->igv2;
					$total		= $request->total2;

				}else{
					$sub_total 	= ($parametro->porcentaje_calculo_edificacion*$valor_obra);//(0.0005*$valor_obra);
					$igv		= ($parametro->igv*$sub_total);
					$total		= $sub_total + $igv;
					
					$sub_total_minimo 	= ($parametro->valor_minimo_edificaciones*$uit);//123.75
					$igv_minimo			= ($parametro->igv*$sub_total_minimo);//22.275
					$total_minimo		= $sub_total_minimo + $igv_minimo;//146.025
					
					if($total<$total_minimo){
						$sub_total 	= $sub_total_minimo;
						$igv		= $igv_minimo;
						$total		= $total_minimo;
					}
				}
				$concepto = Concepto::where("id",26474)->where("estado","1")->first();

				$solicitud->id_instancia=$request->instancia;
				$solicitud->id_tipo_liquidacion1=$request->tipo_liquidacion1;
				$solicitud->save();

			}
			
			/*****Habilitaciones urbanas*********/
			
			if($id_tipo_solicitud == 124){
				
				$m2 = $parametro->valor_metro_cuadrado_habilitacion_urbana;
				
				$sub_total 	= ($m2*$area_total);
				$igv		= ($parametro->igv*$sub_total);
				$total		= $sub_total + $igv;
				
				$total_minimo		= $parametro->valor_minimo_hu;
				$igv_minimo			= $total_minimo/(1+$parametro->igv);
				$sub_total_minimo 	= $total_minimo - $igv_minimo;
				
				$total_maximo		= $parametro->valor_maximo_hu*$m2;
				$igv_maximo			= $total_maximo/(1+$parametro->igv);
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

				$concepto = Concepto::where("id",26483)->where("estado","1")->first();
				
			}
			
			$codigoSolicitud = $derechoRevision_model->getCodigoSolicitud($id_tipo_solicitud);
			$codigo1 = $codigoSolicitud->codigo;
			$numero_correlativo = $codigoSolicitud->numero;
			$codigo2 = $derechoRevision_model->getCountProyectoTipoSolicitud($solicitud->id_proyecto,$id_tipo_solicitud);
			$codigo = $codigo1.$codigo2;
			
			$id_user = Auth::user()->id;
			$liquidacion = new Liquidacione;
			$liquidacion->id_solicitud = $request->id;
			$liquidacion->fecha = Carbon::now()->format('Y-m-d');
			$liquidacion->credipago = $codigo;
			$liquidacion->sub_total = $sub_total;
			$liquidacion->igv = $igv;
			$liquidacion->total = $total;
			$liquidacion->observacion = "obs";
			$liquidacion->id_usuario_inserta = $id_user;
			$liquidacion->save();
			
			$id_liquidacion = $liquidacion->id;
			//echo $id_liquidacion;
			
			$valorizacion = new Valorizacione;
			$valorizacion->id_modulo = 7;
			$valorizacion->pk_registro = $liquidacion->id;
			$valorizacion->id_concepto = $concepto->id;
			
			if(isset($empresa->id))$valorizacion->id_empresa = $empresa->id;
			if(isset($persona->id))$valorizacion->id_persona = $persona->id;
			
			$valorizacion->monto = $liquidacion->total;
			$valorizacion->id_moneda = $concepto->id_moneda;
			$valorizacion->fecha = Carbon::now()->format('Y-m-d');
			$valorizacion->fecha_proceso = Carbon::now()->format('Y-m-d');
			$valorizacion->descripcion = $concepto->denominacion ." - ". $liquidacion->credipago;
			//$valorizacion->estado = 1;
			$valorizacion->id_usuario_inserta = $id_user;
			$valorizacion->save();
			
			$numeracionDocumento = NumeracionDocumento::where("id_tipo_documento",20)->where("estado",1)->first();			
			$numeracionDocumento->numero = $numero_correlativo;
			$numeracionDocumento->save();
			
			$sw = true;
		}else{
			$sw = false;
		}
		
		/*$array["sw"] = $sw;
		echo json_encode($array);*/

		$datos_formateados = [];

        
		$datos_formateados[] = [
			'sw' => $sw,
		];
        
        return response()->json($datos_formateados);
	
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

	public function consulta_derecho_revision_nuevo(){

		$id = 0;
		$tipo_solicitante = "";
        $proyectista = new Proyectista;
		$proyectista_model = new Proyectista;
		$derechoRevision_ = new DerechoRevision;
		$datos_agremiado = new Agremiado;
		$datos_persona = new Persona;
		$persona = new Persona;
		$proyecto2 = new Proyecto;
		$proyectista_model = new Proyectista;
		$propietario_model = new Propietario;
		$presupuesto_model = new Presupuesto;
		$tablaMaestra_model = new TablaMaestra;
		$ubigeo_model = new Ubigeo;
		$municipalidad_model = new Municipalidade;
		$usoEdificacione_model = new UsoEdificacione;

		$departamento = $ubigeo_model->getDepartamento();
        $sitio = $tablaMaestra_model->getMaestroByTipo(33);
        $zona = $tablaMaestra_model->getMaestroByTipo(34);
		$tipo = $tablaMaestra_model->getMaestroByTipo(35);
		$municipalidad = $municipalidad_model->getMunicipalidadOrden();
		$proyectista_solicitud = $proyectista_model->getProyectistaSolicitud($id);
		$propietario_solicitud = $propietario_model->getPropietarioSolicitud($id);
		$info_solicitud = $presupuesto_model->getInfoSolicitud($id);
		$info_uso_solicitud = $usoEdificacione_model->getInfoSolicitudUso($id);
		
        return view('frontend.derecho_revision.all_nuevoDerecho',compact('id','derechoRevision_','proyectista','datos_agremiado','datos_persona','proyecto2','sitio','zona','tipo','departamento','municipalidad','proyectista_solicitud','tipo_solicitante','propietario_solicitud','persona','info_solicitud','info_uso_solicitud'));
    }

	public function editar_derecho_revision_nuevo($id){

		$agremiado_model = new Agremiado;
		$persona_model = new Persona;
		$derechoRevision_ = DerechoRevision::find($id);
		$proyecto_ = Proyecto::where("id",$derechoRevision_->id_proyecto)->where("estado","1")->first();
		$proyecto2 = Proyecto::find($proyecto_->id);
		//var_dump($proyecto2->id_tipo_sitio);exit();
		$proyectista_ = Proyectista::where("id_solicitud",$id)->where("estado","1")->first();
		$proyectista = Proyectista::find($proyectista_->id);
		$agremiado_ = Agremiado::find($proyectista_->id_agremiado);
		$datos_agremiado= $agremiado_model->getAgremiado(85,$agremiado_->numero_cap);
		$persona_ = Persona::where("id",$agremiado_->id_persona)->where("estado","1")->first();
		$datos_persona= $persona_model->getPersona(78,$persona_->numero_documento);
		//var_dump($proyectista_->id_agremiado);exit();
		$tipo_solicitante = 1;
		
		$proyectista_model = new Proyectista;
		$propietario_model = new Propietario;
		$derechoRevision = new DerechoRevision;
		$agremiado = new Agremiado;
		$persona = new Persona;
		$proyecto = new Proyecto;
		$tablaMaestra_model = new TablaMaestra;
		$ubigeo_model = new Ubigeo;
		$municipalidad_model = new Municipalidade;
		$presupuesto_model = new Presupuesto;
		$usoEdificacione_model = new UsoEdificacione;

		$departamento = $ubigeo_model->getDepartamento();
        $sitio = $tablaMaestra_model->getMaestroByTipo(33);
        $zona = $tablaMaestra_model->getMaestroByTipo(34);
		$tipo = $tablaMaestra_model->getMaestroByTipo(35);
		$municipalidad = $municipalidad_model->getMunicipalidadOrden();
		$proyectista_solicitud = $proyectista_model->getProyectistaSolicitud($id);
		$propietario_solicitud = $propietario_model->getPropietarioSolicitud($id);
		$info_solicitud = $presupuesto_model->getInfoSolicitud($id);
		$info_uso_solicitud = $usoEdificacione_model->getInfoSolicitudUso($id);
		
		
        return view('frontend.derecho_revision.all_nuevoDerecho',compact('id','derechoRevision','proyectista','agremiado','persona','proyecto','sitio','zona','tipo','departamento','municipalidad','proyectista_solicitud','propietario_solicitud','derechoRevision_','proyecto2','tipo_solicitante','datos_agremiado','datos_persona','info_solicitud','info_uso_solicitud'));
    }

	public function send_nuevo_registro_solicitud(Request $request){

		//var_dump($request->id_solicitud);exit();
		$id_user = Auth::user()->id;
		$id_solicitud = $request->id_solicitud;
		$agremiado = Agremiado::where("numero_cap",$request->numero_cap)->where("estado","1")->first();
		$ubigeo = $request->distrito;
		$id_ubi = Ubigeo::where("id_ubigeo",$ubigeo)->where("estado","1")->first();
		//$ubigeo = Ubigeo::where("numero_cap",$request->numero_cap)->where("estado","1")->first();

		if($request->id_solicitud == 0){
			$derecho_revision = new DerechoRevision;
			$proyecto = new Proyecto;
			$proyectista = new Proyectista;
		}else{
			$derecho_revision = DerechoRevision::find($request->id_solicitud);
			$proyecto = Proyecto::find($derecho_revision->id_proyecto);
			$proyectista = Proyectista::find($derecho_revision->id_proyectista);
		}
		
		$derecho_revision->id_regional = 5;
		$derecho_revision->fecha_registro = Carbon::now()->format('Y-m-d');
		$derecho_revision->numero_revision = $request->n_revision;
		$derecho_revision->direccion = $request->direccion_proyecto;
		$derecho_revision->id_municipalidad = $request->municipalidad;
		$derecho_revision->id_ubigeo = $id_ubi->id;
		$derecho_revision->id_resultado = 1;
		$derecho_revision->id_tipo_solicitud = 124;
		//$derecho_revision->id_proyectista = $agremiado->id;
		
		$derecho_revision->id_usuario_inserta = $id_user;
		

		$proyecto->id_ubigeo = $id_ubi->id_ubigeo;
		$proyecto->nombre = $request->nombre_proyecto;
		$proyecto->parcela = $request->parcela;
		$proyecto->super_manzana = $request->superManzana;
		$proyecto->direccion = $request->direccion_proyecto;
		$proyecto->lote = $request->lote;
		$proyecto->fila = $request->fila;
		$proyecto->id_tipo_sitio = $request->sitio;
		$proyecto->id_tipo_direccion = $request->tipo;
		$proyecto->id_tipo_proyecto = 124;
		$proyecto->zonificacion = $request->zonificacion;
		$proyecto->sub_lote = $request->sublote;
		$proyecto->id_usuario_inserta = $id_user;
		$proyecto->save();
		

		$agremiado = Agremiado::where("numero_cap",$request->numero_cap)->where("estado","1")->first();

		$proyectista->id_agremiado = $agremiado->id;
		$proyectista->celular = $agremiado->celular1;
		$proyectista->email = $agremiado->email1;
		
		//$proyectista->firma = $request->nombre;
		//$profesion->estado = 1;
		$proyectista->id_usuario_inserta = $id_user;
		$proyectista->save();
		$derecho_revision->id_proyecto = $proyecto->id;
		$derecho_revision->id_proyectista = $proyectista->id;
		$derecho_revision->save();
		$proyectista->id_solicitud = $derecho_revision->id;
		$proyectista->save();
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
		$proyectista->id_solicitud = $request->id_solicitud;
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
			//var_dump($persona);exit();
			$propietario->id_tipo_propietario = 78;
			$propietario->id_persona = $persona->id;
			$propietario->celular = $request->celular_dni;
			$propietario->email = $request->email_dni;
			$propietario->id_solicitud = $request->id_solicitud;
			//$proyectista->firma = $request->nombre;
			//$profesion->estado = 1;
			$propietario->id_usuario_inserta = $id_user;
			$propietario->save();

		}else if($empresa){
			$propietario->id_tipo_propietario = 79;
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

		$path = "img/derecho_revision";
		if (!is_dir($path)) {
			mkdir($path);
		}

		$id_user = Auth::user()->id;
		$agremiado = Agremiado::where("numero_cap",$request->numero_cap)->where("estado","1")->first();

		if($request->id == 0){
			$usoEdificacion = new UsoEdificacione;
			//$solicitud = new Solicitude;
		}else{
			$usoEdificacion = UsoEdificacione::find($request->id);
			$solicitud = Solicitude::find($request->id);
		}

		$procedimientos_complementarios = $request->input('procedimientos_complementarios');
		$procedimientos_complementarios2 = $request->input('procedimientos_complementarios2');

		$solicitud = Solicitude::find($request->id_solicitud);
		$solicitud->id_tipo_tramite = $procedimientos_complementarios;
		$solicitud->id_usuario_inserta = $id_user;
		//var_dump($procedimientos_complementarios2);exit();
		$solicitud->save();


		//var_dump($solicitud->id);exit();
		//$usoEdificacion_ = UsoEdificacione::where("id_solicitud",$solicitud->id)->where("estado","1")->first();
		//$usoEdificacion = UsoEdificacione::find($usoEdificacion_->id);
		//$usoEdificacion = new UsoEdificacione;
		$usoEdificacion->id_tipo_uso = $procedimientos_complementarios2;
		//$usoEdificacion->id_sub_tipo_uso = $procedimientos_complementarios2;
		$usoEdificacion->id_solicitud = $request->id_solicitud;
		$usoEdificacion->area_techada = $request->areaBruta;
		//$proyectista->firma = $request->nombre;
		//$profesion->estado = 1;
		$usoEdificacion->id_usuario_inserta = $id_user;
		$usoEdificacion->save();
		
		
		$solicitudDocumento1 = new SolicitudDocumento;
		$solicitudDocumento1->id_tipo_documento = 1;
		if($request->img_foto1!=""){
			$filepath_tmp = public_path('img/frontend/tmp_derecho_revision/');
			$filepath_nuevo = public_path('img/derecho_revision/');
			if (file_exists($filepath_tmp.$request->img_foto1)) {
				copy($filepath_tmp.$request->img_foto1, $filepath_nuevo.$request->img_foto1);
			}
			
			$solicitudDocumento1->ruta_archivo = $request->img_foto1;
		}
		$solicitudDocumento1->estado = 1;
		$solicitudDocumento1->id_solicitud = $request->id_solicitud;
		$solicitudDocumento1->id_usuario_inserta = $id_user;
		$solicitudDocumento1->save();
		
		$solicitudDocumento2 = new SolicitudDocumento;
		$solicitudDocumento2->id_tipo_documento = 2;
		if($request->img_foto2!=""){
			$filepath_tmp = public_path('img/frontend/tmp_derecho_revision/');
			$filepath_nuevo = public_path('img/derecho_revision/');
			if (file_exists($filepath_tmp.$request->img_foto2)) {
				copy($filepath_tmp.$request->img_foto2, $filepath_nuevo.$request->img_foto2);
			}
			
			$solicitudDocumento2->ruta_archivo = $request->img_foto2;
		}
		$solicitudDocumento2->estado = 1;
		$solicitudDocumento2->id_solicitud = $request->id_solicitud;
		$solicitudDocumento2->id_usuario_inserta = $id_user;
		$solicitudDocumento2->save();
		
		$solicitudDocumento3 = new SolicitudDocumento;
		$solicitudDocumento3->id_tipo_documento = 3;
		if($request->img_foto3!=""){
			$filepath_tmp = public_path('img/frontend/tmp_derecho_revision/');
			$filepath_nuevo = public_path('img/derecho_revision/');
			if (file_exists($filepath_tmp.$request->img_foto3)) {
				copy($filepath_tmp.$request->img_foto3, $filepath_nuevo.$request->img_foto3);
			}
			
			$solicitudDocumento3->ruta_archivo = $request->img_foto3;
		}
		$solicitudDocumento3->estado = 1;
		$solicitudDocumento3->id_solicitud = $request->id_solicitud;
		$solicitudDocumento3->id_usuario_inserta = $id_user;
		$solicitudDocumento3->save();
		
    }

	public function upload_solicitud(Request $request){
		
		$path = "img/frontend/tmp_derecho_revision";
		if (!is_dir($path)) {
			mkdir($path);
		}
		
		$filename = date("YmdHis") . substr((string)microtime(), 1, 6);
		$type="";
		
		$filepath = public_path('img/frontend/tmp_derecho_revision/');
		
		$type=$this->extension($_FILES["file"]["name"]);
		move_uploaded_file($_FILES["file"]["tmp_name"], $filepath . $filename.".".$type);
		
		//$archivo = $filename.".".$type;
		//$this->importar_solicitud($archivo);
		echo $filename.".".$type;
		
	}

	function extension($filename){$file = explode(".",$filename); return strtolower(end($file));}

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

	public function credipago_pdf($id){
		
		$derecho_revision_model=new DerechoRevision;
		$ubigeo_model = new Ubigeo;
		$parametro_model = new Parametro;

		$datos=$derecho_revision_model->getSolicitudPdf($id);
		$credipago=$datos[0]->credipago;
		$proyectista=$datos[0]->proyectista;
		$numero_cap=$datos[0]->numero_cap;
		$razon_social = $datos[0]->razon_social;
		$nombre = $datos[0]->nombre;
		$departamento_=$datos[0]->departamento;
		$provincia_=$datos[0]->provincia;
		$distrito_=$datos[0]->distrito;
		$direccion = $datos[0]->direccion;
		$numero_revision = $datos[0]->numero_revision;
		$municipalidad = $datos[0]->municipalidad;
		$total_area_techada=$datos[0]->total_area_techada;
		$valor_obra=$datos[0]->valor_obra;
		$sub_total=$datos[0]->sub_total;
		$igv = $datos[0]->igv;
		$total = $datos[0]->total;
		$tipo_proyectista = $datos[0]->tipo_proyectista;
		$tipo_liquidacion = $datos[0]->tipo_liquidacion;
		$instancia = $datos[0]->instancia;

		$year = Carbon::now()->year;

		$parametro = $parametro_model->getParametroAnio($year);

		$porcentaje_ = $parametro[0]->porcentaje_calculo_edificacion;

		$porcentaje = floatval($porcentaje_) * 100;
		
		$departamento = $ubigeo_model->obtenerDepartamento($departamento_);
		$provincia = $ubigeo_model->obtenerProvincia($departamento_,$provincia_);
		$distrito = $ubigeo_model->obtenerDistrito($departamento_,$provincia_,$distrito_);

		Carbon::setLocale('es');

		// Crear una instancia de Carbon a partir de la fecha

		 $carbonDate =Carbon::now()->format('Y-m-d');

		 $currentHour = Carbon::now()->format('H:i:s');

		// Formatear la fecha en un formato largo

		/*
		$numeroEnLetras = $this->numeroALetras($numero); 
		

		if ($trato==3) {
			$tratodesc="EL ARQUITECTO ";
			$faculta="facultado";
			$habilita="HABILITADO";
			$inscripcion="inscrito";
		}
		else{
			$tratodesc="LA ARQUITECTA ";
			$faculta="facultada";
			$habilita="HABILITADA";
			$inscripcion="inscrita";
		}

		Carbon::setLocale('es');

		// Crear una instancia de Carbon a partir de la fecha
		$carbonDate = new Carbon($fecha_emision);

		// Formatear la fecha en un formato largo

	
		$formattedDate = $carbonDate->timezone('America/Lima')->formatLocalized(' %d de %B %Y'); //->format('l, j F Y ');
		*/
		
		$pdf = Pdf::loadView('frontend.derecho_revision.credipago_pdf',compact('credipago','proyectista','numero_cap','razon_social','nombre','departamento','provincia','distrito','direccion','numero_revision','municipalidad','total_area_techada','valor_obra','sub_total','igv','total','carbonDate','currentHour','tipo_proyectista','porcentaje','tipo_liquidacion','instancia'));
		


		$pdf->setPaper('A4'); // Tamaño de papel (puedes cambiarlo según tus necesidades)

		
    	$pdf->setOption('margin-top', 20); // Márgen superior en milímetros
   		$pdf->setOption('margin-right', 50); // Márgen derecho en milímetros
    	$pdf->setOption('margin-bottom', 20); // Márgen inferior en milímetros
    	$pdf->setOption('margin-left', 100); // Márgen izquierdo en milímetros

		return $pdf->stream();
    	//return $pdf->download('invoice.pdf');
		//return view('frontend.certificado.certificado_pdf');

	}

	public function credipago_pdf_HU($id){
		
		$derecho_revision_model=new DerechoRevision;
		$ubigeo_model = new Ubigeo;
		$parametro_model = new Parametro;

		$datos=$derecho_revision_model->getSolicitudPdf($id);
		$credipago=$datos[0]->credipago;
		$proyectista=$datos[0]->proyectista;
		$numero_cap=$datos[0]->numero_cap;
		$razon_social = $datos[0]->razon_social;
		$nombre = $datos[0]->nombre;
		$departamento_=$datos[0]->departamento;
		$provincia_=$datos[0]->provincia;
		$distrito_=$datos[0]->distrito;
		$direccion = $datos[0]->direccion;
		$numero_revision = $datos[0]->numero_revision;
		$municipalidad = $datos[0]->municipalidad;
		$total_area_techada=$datos[0]->total_area_techada;
		$valor_obra=$datos[0]->valor_obra;
		$sub_total=$datos[0]->sub_total;
		$igv = $datos[0]->igv;
		$total = $datos[0]->total;
		$tipo_proyectista = $datos[0]->tipo_proyectista;

		$year = Carbon::now()->year;

		$parametro = $parametro_model->getParametroAnio($year);

		$porcentaje_ = $parametro[0]->porcentaje_calculo_edificacion;

		$porcentaje = floatval($porcentaje_) * 100;
		
		$departamento = $ubigeo_model->obtenerDepartamento($departamento_);
		$provincia = $ubigeo_model->obtenerProvincia($departamento_,$provincia_);
		$distrito = $ubigeo_model->obtenerDistrito($departamento_,$provincia_,$distrito_);

		Carbon::setLocale('es');

		// Crear una instancia de Carbon a partir de la fecha

		 $carbonDate =Carbon::now()->format('Y-m-d');

		 $currentHour = Carbon::now()->format('H:i:s');

		
		$pdf = Pdf::loadView('frontend.derecho_revision.credipago_pdf_HU',compact('credipago','proyectista','numero_cap','razon_social','nombre','departamento','provincia','distrito','direccion','numero_revision','municipalidad','total_area_techada','valor_obra','sub_total','igv','total','carbonDate','currentHour','tipo_proyectista','porcentaje'));
		


		$pdf->setPaper('A4'); // Tamaño de papel (puedes cambiarlo según tus necesidades)

		
    	$pdf->setOption('margin-top', 20); // Márgen superior en milímetros
   		$pdf->setOption('margin-right', 50); // Márgen derecho en milímetros
    	$pdf->setOption('margin-bottom', 20); // Márgen inferior en milímetros
    	$pdf->setOption('margin-left', 100); // Márgen izquierdo en milímetros

		return $pdf->stream();
    	//return $pdf->download('invoice.pdf');
		//return view('frontend.certificado.certificado_pdf');

	}

	public function credipago_pdf_edificaciones($id){
		
		$derecho_revision_model=new DerechoRevision;
		$ubigeo_model = new Ubigeo;
		$parametro_model = new Parametro;

		$datos=$derecho_revision_model->getSolicitudPdf($id);
		$credipago=$datos[0]->credipago;
		$proyectista=$datos[0]->proyectista;
		$numero_cap=$datos[0]->numero_cap;
		$razon_social = $datos[0]->razon_social;
		$nombre = $datos[0]->nombre;
		$departamento_=$datos[0]->departamento;
		$provincia_=$datos[0]->provincia;
		$distrito_=$datos[0]->distrito;
		$direccion = $datos[0]->direccion;
		$numero_revision = $datos[0]->numero_revision;
		$municipalidad = $datos[0]->municipalidad;
		$total_area_techada=$datos[0]->total_area_techada;
		$valor_obra=$datos[0]->valor_obra;
		$sub_total=$datos[0]->sub_total;
		$igv = $datos[0]->igv;
		$total = $datos[0]->total;
		$tipo_proyectista = $datos[0]->tipo_proyectista;

		$year = Carbon::now()->year;

		$parametro = $parametro_model->getParametroAnio($year);

		$porcentaje_ = $parametro[0]->porcentaje_calculo_edificacion;

		$porcentaje = floatval($porcentaje_) * 100;
		
		$departamento = $ubigeo_model->obtenerDepartamento($departamento_);
		$provincia = $ubigeo_model->obtenerProvincia($departamento_,$provincia_);
		$distrito = $ubigeo_model->obtenerDistrito($departamento_,$provincia_,$distrito_);

		Carbon::setLocale('es');

		// Crear una instancia de Carbon a partir de la fecha

		 $carbonDate =Carbon::now()->format('Y-m-d');

		 $currentHour = Carbon::now()->format('H:i:s');

		
		$pdf = Pdf::loadView('frontend.derecho_revision.credipago_pdf_HU',compact('credipago','proyectista','numero_cap','razon_social','nombre','departamento','provincia','distrito','direccion','numero_revision','municipalidad','total_area_techada','valor_obra','sub_total','igv','total','carbonDate','currentHour','tipo_proyectista','porcentaje'));
		


		$pdf->setPaper('A4'); // Tamaño de papel (puedes cambiarlo según tus necesidades)

		
    	$pdf->setOption('margin-top', 20); // Márgen superior en milímetros
   		$pdf->setOption('margin-right', 50); // Márgen derecho en milímetros
    	$pdf->setOption('margin-bottom', 20); // Márgen inferior en milímetros
    	$pdf->setOption('margin-left', 100); // Márgen izquierdo en milímetros

		return $pdf->stream();
    	//return $pdf->download('invoice.pdf');
		//return view('frontend.certificado.certificado_pdf');

	}

	public function obtener_tipo_credipago($id){
			
		$derecho_revision_model = new DerechoRevision;
		$tipo_solicitud = $derecho_revision_model->getTipoSolicitud($id);
		//print_r($tipo_solicitud);
		//$array["id"] = $tipo_solicitud->id;
		//echo json_encode($tipo_solicitud);

		$datos_formateados = [];

        foreach ($tipo_solicitud as $solicitud) {
            $datos_formateados[] = [
                'id' => $solicitud->id,
                'id_tipo_solicitud' => $solicitud->id_tipo_solicitud,
            ];
        }
        return response()->json($datos_formateados);
		
	}

	public function modal_reintegro($id){
		 
		//$derechoRevision = new DerechoRevision;
		$derechoRevision_model = new DerechoRevision;
		$tablaMaestra_model = new TablaMaestra;
		$parametro_model = new Parametro;
		$ubigeo_model=new Ubigeo;
        $liquidacion = $derechoRevision_model->getReintegroByIdSolicitud($id);
		$ubigeo = $liquidacion[0]->id_ubigeo;
		$ubigeo_id = Ubigeo::where("id",$ubigeo)->where("estado","1")->first();
		$departamento = $ubigeo_model->obtenerDepartamento($ubigeo_id->id_departamento);
		$provincia = $ubigeo_model->obtenerProvincia($ubigeo_id->id_departamento,$ubigeo_id->id_provincia);
		$distrito = $ubigeo_model->obtenerDistrito($ubigeo_id->id_departamento,$ubigeo_id->id_provincia,$ubigeo_id->id_distrito);
		$tipo_liquidacion = $tablaMaestra_model->getMaestroByTipo(27);
		$instancia = $tablaMaestra_model->getMaestroByTipo(47);
		$anio_actual = Carbon::now()->year;
		$parametro = $parametro_model->getParametroAnio($anio_actual);

		//var_dump($parametro);exit;

        return view('frontend.derecho_revision.modal_reintegro',compact('id','liquidacion','departamento','provincia','distrito','tipo_liquidacion','instancia','parametro'));
		
    }

	public function modal_reintegroRU($id){
		 
		//$derechoRevision = new DerechoRevision;
		$derechoRevision_model = new DerechoRevision;
		$tablaMaestra_model = new TablaMaestra;
		$parametro_model = new Parametro;
		$ubigeo_model=new Ubigeo;
        $liquidacion = $derechoRevision_model->getReintegroByIdSolicitud($id);
		$ubigeo = $liquidacion[0]->id_ubigeo;
		$ubigeo_id = Ubigeo::where("id",$ubigeo)->where("estado","1")->first();
		$departamento = $ubigeo_model->obtenerDepartamento($ubigeo_id->id_departamento);
		$provincia = $ubigeo_model->obtenerProvincia($ubigeo_id->id_departamento,$ubigeo_id->id_provincia);
		$distrito = $ubigeo_model->obtenerDistrito($ubigeo_id->id_departamento,$ubigeo_id->id_provincia,$ubigeo_id->id_distrito);
		$tipo_liquidacion = $tablaMaestra_model->getMaestroByTipo(27);
		$instancia = $tablaMaestra_model->getMaestroByTipo(47);
		$anio_actual = Carbon::now()->year;
		$parametro = $parametro_model->getParametroAnio($anio_actual);

		//var_dump($parametro);exit;

        return view('frontend.derecho_revision.modal_reintegroRU',compact('id','liquidacion','departamento','provincia','distrito','tipo_liquidacion','instancia','parametro'));
		
    }

	public function listar_solicitud_periodo(Request $request){
        
        $derechoRevision_model = new DerechoRevision;
        $resultado = $derechoRevision_model->getPeridoSolicitud();

        //print_r($resultado);exit();
		return $resultado;

    }

	public function listar_solicitud_periodo_hu(Request $request){
        
        $derechoRevision_model = new DerechoRevision;
        $resultado = $derechoRevision_model->getPeridoSolicitudHu();

        //print_r($resultado);exit();
		return $resultado;
    }

	public function eliminar_credipago($id,$estado)
    {
		$liquidacion = Liquidacione::find($id);
		$liquidacion->estado = $estado;
		$liquidacion->save();

		echo $liquidacion->id;
    }

	function importar_dataLicencia(){
	
		
		$derecho_revision_model = new DerechoRevision;

		$data = [];
		
		$data['proyectos'] = $derecho_revision_model->importar_proyectos_dataLicencia();
		
		$data['solicitudes'] = $derecho_revision_model->importar_solicitudes_dataLicencia();

		$data['empresas'] = $derecho_revision_model->importar_empresas_dataLicencia();

		$data['personas'] = $derecho_revision_model->importar_personas_dataLicencia();
		
		$result["aaData"] = $data;

		//var_dump($data);exit;

		echo json_encode($result);
	
	}
}
