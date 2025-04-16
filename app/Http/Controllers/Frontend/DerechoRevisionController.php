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
use App\Models\ProfesionalesOtro;
use Auth;
use Mail;

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
		$situacion_credipago = $tablaMaestra_model->getMaestroByTipo(125);
		$distrito = $ubigeo_model->getDistritoLima();
		
        return view('frontend.derecho_revision.all',compact('derecho_revision','agremiado','persona','liquidacion','municipalidad','departamento','tipo_proyecto','estado_proyecto', 'tipo_solicitud','distrito','situacion_credipago'));
    }

	public function modal_credipago($id){
		
		$DerechoRevision_model = new DerechoRevision;
		$DerechoRevision_model->actSituacionLiquidacion($id);
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
		$proyecto = new Proyecto;
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
		$situacion_credipago = $tablaMaestra_model->getMaestroByTipo(125);
        
        return view('frontend.derecho_revision.all_solicitud',compact('derecho_revision','agremiado','persona','liquidacion','municipalidad','distrito','estado_solicitud','tipo_proyecto','tipo_solicitud','proyecto','situacion_credipago'));
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
		$p[]=$request->fecha_inicio_bus;
		$p[]=$request->fecha_fin_bus;
		$p[]=$request->situacion_credipago;
		$p[]=$request->estado_proyecto;
		$p[]=$request->estado;
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
		$p[]=$request->situacion_credipago;
		$p[]=$request->estado_proyecto;
		$p[]="1";
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
			$liquidacion->sub_total = number_format($sub_total, 2, '.', '');
			$liquidacion->igv = number_format($igv, 2, '.', '');
			$liquidacion->total = number_format($total, 2, '.', '');
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
			$valorizacion->monto = number_format($liquidacion->total, 2, '.', '');
			$valorizacion->id_moneda = $concepto->id_moneda;
			$valorizacion->fecha = Carbon::now()->format('Y-m-d');
			$valorizacion->fecha_proceso = Carbon::now()->format('Y-m-d');
			$fechaValorizacion = Carbon::now();
			$fecha_valorizacion = $fechaValorizacion->format('my');
			$municipalidad = Municipalidade::where("id",$solicitud->id_municipalidad)->where("estado","1")->first();
			$valorizacion->descripcion = $concepto->denominacion ." - ". $liquidacion->credipago ." - ". $municipalidad->denominacion ." - ". $fecha_valorizacion ;
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

		$total2_ = $request->input('total2');
		$total2_ = preg_replace('/[^\d.]/','',$total2_);
		$total2_ = floatval($total2_);

		$subtotal2_ = $request->input('sub_total2');
		$subtotal2_ = preg_replace('/[^\d.]/','',$subtotal2_);
		$subtotal2_ = floatval($subtotal2_);

		$igv2_ = $request->input('igv2');
		$igv2_ = preg_replace('/[^\d.]/','',$igv2_);
		$igv2_ = floatval($igv2_);

		//if($request->tipo_liquidacion1==136)$valor_obra = $request->total2;
		
		if($request->instancia==250)$valor_obra = $request->valor_reintegro;

		$propietario = Propietario::where("id_solicitud",$request->id)->where("estado","1")->first();
		//var_dump($propietario);exit();
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
				
				$id_tipo_documento = 20;
				if($request->tipo_liquidacion1==136){
					//$valor_obra = $request->total2;
					$sub_total 	= $subtotal2_;
					$igv		= $igv2_;
					$total		= $total2_;

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
				$solicitud->etapa=$request->etapas;
				$solicitud->numero_etapa=$request->n_etapas;
				$solicitud->save();

			}
			
			/*****Habilitaciones urbanas*********/
			
			if($id_tipo_solicitud == 124){
				
				$id_tipo_documento = 22;
				$m2 = $parametro->valor_metro_cuadrado_habilitacion_urbana;
				
				$total 	= ($m2*$area_total);
				$sub_total		= $total/($parametro->igv+1);
				$igv		= $total-$sub_total;
				
				$total_minimo		= $parametro->valor_minimo_hu;
				$sub_total_minimo 	= $total_minimo/(1+$parametro->igv);
				$igv_minimo			= $total_minimo - $sub_total_minimo;
				
				$total_maximo		= $parametro->valor_maximo_hu*$m2;
				$sub_total_maximo 	= $total_maximo/(1+$parametro->igv);
				$igv_maximo			= $total_maximo - $sub_total_maximo;
				
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
				$solicitud->id_resultado='2';
				$solicitud->save();
				
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
			$liquidacion->sub_total = number_format($sub_total, 2, '.', '');
			$liquidacion->igv = number_format($igv, 2, '.', '');
			$liquidacion->total = number_format($total, 2, '.', '');
			$liquidacion->observacion = $request->observacion;
			$liquidacion->id_situacion = 1;
			$liquidacion->id_usuario_inserta = $id_user;
			$liquidacion->save();
			
			$id_liquidacion = $liquidacion->id;
			//echo $id_liquidacion;
			
			$valorizacion = new Valorizacione;
			$valorizacion->id_modulo = 7;
			$valorizacion->pk_registro = $liquidacion->id;
			$valorizacion->id_concepto = $concepto->id;
			
			if(isset($empresa->id)){
				$valorizacion->id_empresa = $empresa->id;
			}
			if(isset($persona->id)){
				$valorizacion->id_persona = $persona->id;
			}
			
			$valorizacion->monto = number_format($liquidacion->total, 2, '.', '');
			$valorizacion->id_moneda = $concepto->id_moneda;
			$valorizacion->fecha = Carbon::now()->format('Y-m-d');
			$valorizacion->fecha_proceso = Carbon::now()->format('Y-m-d');
			//$valorizacion->descripcion = $concepto->denominacion ." - ". $liquidacion->credipago;
			$fechaValorizacion = Carbon::now();
			$fecha_valorizacion = $fechaValorizacion->format('my');
			$municipalidad = Municipalidade::where("id",$solicitud->id_municipalidad)->where("estado","1")->first();
			$valorizacion->descripcion = $concepto->denominacion ." - ". $liquidacion->credipago ." - ". $municipalidad->denominacion ." - ". $fecha_valorizacion ;
			//$valorizacion->estado = 1;
			$valorizacion->id_usuario_inserta = $id_user;
			$valorizacion->save();
			
			$numeracionDocumento = NumeracionDocumento::where("id_tipo_documento",$id_tipo_documento)->where("estado",1)->first();			
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
        
		//$this->correo_credipago($request->id);
		
        return response()->json($datos_formateados);
	
	}
	
	public function correo_credipago($id){
		
		view('emails.mensaje');
		$email_paciente = "";
		$pasaje_actual = "";
		$nombre_boletopaciente = "";
		$nombre_boletopaciente_extra1 = "";
		$nombre_boletopaciente_extra2 = "";
		$nombre_boletopaciente_extra3 = "";
		$nombre_boletoacompanante = "";
		$nombre_boletomedico = "";
		
		//$correo_electronico = "wyamunaque.expertta@gmail.com";
		$correo_electronico = "julioyamunaque04@gmail.com";
		$paterno = "";
		$fecha_viaje = "";
		
		//$agremiado = Agremiado::find(100);
		/*$derecho_revision = DerechoRevision::find($id);

		$proyecto = Proyecto::where("id",$derecho_revision->id_proyecto)->where("estado","1")->first();

		$proyectista = Proyectista::where("id_solicitud",$derecho_revision->id)->where("estado","1")->first();
		//var_dump($proyectista);exit();
		$agremiado = Agremiado::where("id",$proyectista->id_agremiado)->where("estado","1")->first();
		$persona = Persona::where("id",$agremiado->id_persona)->where("estado","1")->first();*/

		$derecho_revision_model = new DerechoRevision;

		$datos_correo = $derecho_revision_model->getSolicitudCorreo($id);
		//var_dump($datos_correo);exit();
        Mail::send('emails.mensaje', ['datos_correo' => $datos_correo], function ($m) use ($pasaje_actual, $email_paciente,$nombre_boletopaciente,$nombre_boletopaciente_extra1,$nombre_boletopaciente_extra2,$nombre_boletopaciente_extra3,$nombre_boletoacompanante,$nombre_boletomedico, $correo_electronico,$paterno,$fecha_viaje,$datos_correo) {
			$asunto = 'SOLICITUD '.$datos_correo[0]->codigo_solicitud.' CODIGO DE PROYECTO '.$datos_correo[0]->codigo;
			$m->from(config('mail.mailers.smtp.username'), 'CAP');
            $m->to($correo_electronico, $paterno)->subject($asunto);
			
        });
		
	}

	public function correo_credipago_aprobado_hu($id){
		
		view('emails.mensaje_correo_aprobado_hu');
		$email_paciente = "";
		$pasaje_actual = "";
		$nombre_boletopaciente = "";
		$nombre_boletopaciente_extra1 = "";
		$nombre_boletopaciente_extra2 = "";
		$nombre_boletopaciente_extra3 = "";
		$nombre_boletoacompanante = "";
		$nombre_boletomedico = "";
		
		//$correo_electronico = "wyamunaque.expertta@gmail.com";
		$correo_electronico = "julioyamunaque04@gmail.com";
		$paterno = "";
		$fecha_viaje = "";

		$derecho_revision_model = new DerechoRevision;

		$datos_correo = $derecho_revision_model->getSolicitudCorreoAprobadoHu($id);
		//var_dump($datos_correo);exit();
        Mail::send('emails.mensaje_correo_aprobado_hu', ['datos_correo' => $datos_correo], function ($m) use ($pasaje_actual, $email_paciente,$nombre_boletopaciente,$nombre_boletopaciente_extra1,$nombre_boletopaciente_extra2,$nombre_boletopaciente_extra3,$nombre_boletoacompanante,$nombre_boletomedico, $correo_electronico,$paterno,$fecha_viaje,$datos_correo) {
			$asunto = 'SOLICITUD DE DERECHO DE REVISIÓN DE HABILITACIÓN URBANA';
			$m->from(config('mail.mailers.smtp.username'), 'CAP');
            $m->to($correo_electronico, $paterno)->subject($asunto);
			
        });
		
	}
	
	
	public function correo_credipago_aprobado_reintegro($id){
		
		view('emails.mensaje_correo_aprobado_reintegro');
		$email_paciente = "";
		$pasaje_actual = "";
		$nombre_boletopaciente = "";
		$nombre_boletopaciente_extra1 = "";
		$nombre_boletopaciente_extra2 = "";
		$nombre_boletopaciente_extra3 = "";
		$nombre_boletoacompanante = "";
		$nombre_boletomedico = "";
		
		//$correo_electronico = "wyamunaque.expertta@gmail.com";
		$correo_electronico = "julioyamunaque04@gmail.com";
		$paterno = "";
		$fecha_viaje = "";

		$derecho_revision_model = new DerechoRevision;

		$datos_correo = $derecho_revision_model->getSolicitudCorreoAprobadoReintegro($id);
		//var_dump($datos_correo);exit();
        Mail::send('emails.mensaje_correo_aprobado_reintegro', ['datos_correo' => $datos_correo], function ($m) use ($pasaje_actual, $email_paciente,$nombre_boletopaciente,$nombre_boletopaciente_extra1,$nombre_boletopaciente_extra2,$nombre_boletopaciente_extra3,$nombre_boletoacompanante,$nombre_boletomedico, $correo_electronico,$paterno,$fecha_viaje,$datos_correo) {
			$asunto = 'SOLICITUD REINTEGRO CODIGO DE PROYECTO '.$datos_correo[0]->codigo;
			$m->from(config('mail.mailers.smtp.username'), 'CAP');
            $m->to($correo_electronico, $paterno)->subject($asunto);
			
        });
		
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
		$proyectista_ = Proyectista::where("id_solicitud",$derechoRevision_->id)->where("estado","1")->orderBy('id')->first();
		$proyectista = Proyectista::find($proyectista_->id);
		$agremiado_ = Agremiado::find($proyectista->id_agremiado);
		$datos_agremiado= $agremiado_model->getAgremiado(85,$agremiado_->numero_cap);
		
		$persona_ = Persona::where("id",$agremiado_->id_persona)->where("estado","1")->first();
		//var_dump($persona_->numero_documento);exit();
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
		$proyectista_solicitud = $proyectista_model->getProyectistaSolicitudHU($id);
		$propietario_solicitud = $propietario_model->getPropietarioSolicitud($id);
		$info_solicitud = $presupuesto_model->getInfoSolicitud($id);
		$info_uso_solicitud = $usoEdificacione_model->getInfoSolicitudUsoTipo($id);
		
		
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
		$derecho_revision->id_ubigeo = $ubigeo;
		$derecho_revision->id_resultado = 1;
		$derecho_revision->id_instancia = 246;
		$derecho_revision->id_tipo_solicitud = 124;
		//$derecho_revision->id_proyectista = $agremiado->id;
		
		$derecho_revision->id_usuario_inserta = $id_user;
		

		$proyecto->id_ubigeo = $ubigeo;
		$proyecto->nombre = $request->nombre_proyecto;
		$proyecto->parcela = $request->parcela;
		$proyecto->super_manzana = $request->superManzana;
		$proyecto->direccion = $request->direccion_proyecto;
		$proyecto->sitio_descripcion = $request->direccion_sitio;
		$proyecto->zona_descripcion = $request->direccion_zona;
		$proyecto->lote = $request->lote;
		$proyecto->fila = $request->fila;
		$proyecto->id_tipo_sitio = $request->sitio;
		$proyecto->id_zona = $request->zona;
		$proyecto->id_tipo_direccion = $request->tipo;
		$proyecto->id_tipo_proyecto = 124;
		$codigoHU = $derecho_revision->getCodigoSolicitudHU();
		$proyecto->codigo = $codigoHU;
		$proyecto->zonificacion = $request->zonificacion;
		$proyecto->sub_lote = $request->sublote;
		$proyecto->id_usuario_inserta = $id_user;
		$proyecto->save();
		

		$agremiado = Agremiado::where("numero_cap",$request->numero_cap)->where("estado","1")->first();

		$proyectista->id_agremiado = $agremiado->id;
		$proyectista->celular = $agremiado->celular1;
		$proyectista->email = $agremiado->email1;
		$proyectista->id_tipo_profesional = 211;
		$proyectista->id_tipo_proyectista = 1;
		
		//$proyectista->firma = $request->nombre;
		//$profesion->estado = 1;
		$proyectista->id_usuario_inserta = $id_user;
		$proyectista->save();
		$derecho_revision->id_proyecto = $proyecto->id;
		$derecho_revision->id_proyectista = $proyectista->id;
		$derecho_revision->save();
		$proyectista->id_solicitud = $derecho_revision->id;
		$proyectista->save();

		return $derecho_revision->id;
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
		$tipo_proyectista = Proyectista::where("id_solicitud",$request->id_solicitud)->where("estado","1")->first();
		if($tipo_proyectista){
			$tipo_proyectista->id_tipo_profesional = 212;
			$proyectista->id_tipo_profesional = 212;
			$proyectista->id_tipo_proyectista = 2;
			$tipo_proyectista->save();
		}
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

		$tipo_documento = $tablaMaestra_model->getMaestroByTipo(127);
		
        return view('frontend.derecho_revision.modal_nuevo_propietario',compact('id','tipo_documento','empresa','proyectista','agremiado','persona'));
		
    }

	public function send_nueno_propietario(Request $request){

		$id_user = Auth::user()->id;
		$persona = Persona::where("numero_documento",$request->dni_propietario)->where("estado","1")->first();
		$empresa = Empresa::where("ruc",$request->ruc_propietario)->where("estado","1")->first();
		$persona_carne_extranjeria = Persona::where("numero_documento",$request->carne_propietario)->where("estado","1")->first();
		
		$buscaPersonaDni = Persona::where("numero_documento", $request->dni_propietario)->where("id_tipo_documento", $request->id_tipo_documento)->where("estado", "1")->get();
		$buscaPersonaCarne = Persona::where("numero_documento", $request->carne_propietario)->where("id_tipo_documento", $request->id_tipo_documento)->where("estado", "1")->get();
		$buscaEmpresaRuc = Empresa::where("ruc", $request->ruc_propietario)->where("estado", "1")->get();

		$sw = true;
		$msg = "";
		//dd($persona);exit();
		
		if($request->id == 0){
			$propietario = new Propietario;
		}else{
			$propietario = Propietario::find($request->id);
		}

		if($persona && $request->dni_propietario!=''){
			//var_dump($persona);exit();
			$buscaPersonaDniPropietario = Propietario::where("id_tipo_propietario", $persona->id_tipo_documento)->where("id_persona", $persona->id)->where("id_solicitud", $request->id_solicitud)->where("estado", "1")->count();
			if($buscaPersonaDniPropietario>0){
				$sw = false;
				$msg = "El propietario ingresado ya existe en esta solicitud!!!";
			}else{
				$propietario->id_tipo_propietario = 78;
				$propietario->id_persona = $persona->id;
				$propietario->celular = $request->celular_dni;
				$propietario->email = $request->email_dni;
				$propietario->id_solicitud = $request->id_solicitud;
				//$proyectista->firma = $request->nombre;
				//$profesion->estado = 1;
				$propietario->id_usuario_inserta = $id_user;
				$propietario->save();
				/*if ($buscaPersonaDni->count()>0){
					//dd($buscaPersonaDni);exit();
					$tablaMaestra_model = new TablaMaestra;		
					$tipo_documento = $tablaMaestra_model->getMaestroC(110,$request->id_tipo_documento);
					$sw = false;
					$msg = "El ".$tipo_documento[0]->denominacion." ingresado ya existe !!!";
				}*/
			}
		}else if($empresa && $request->ruc_propietario!=''){
			$buscaEmpresaRucPropietario = Propietario::where("id_tipo_propietario", $request->id_tipo_documento)->where("id_empresa", $empresa->id)->where("id_solicitud",$request->id_solicitud)->where("estado", "1")->count();
			if($buscaEmpresaRucPropietario>0){
				$sw = false;
				$msg = "El propietario ingresado ya existe en esta solicitud!!!";
			}else{
				$propietario->id_tipo_propietario = 79;
				$propietario->id_empresa = $empresa->id;
				$propietario->celular = $request->telefono_ruc;
				$propietario->email = $request->email_ruc;
				$propietario->id_solicitud = $request->id_solicitud;
				//$proyectista->firma = $request->nombre;
				//$profesion->estado = 1;
				$propietario->id_usuario_inserta = $id_user;
				$propietario->save();
			}
			
		}else if($persona_carne_extranjeria && $request->carne_propietario!=''){
			$buscaPersonaCarnePropietario = Propietario::where("id_tipo_propietario", $request->id_tipo_documento)->where("id_persona", $persona_carne_extranjeria->id)->where("id_solicitud",$request->id_solicitud)->where("estado", "1")->count();
			if($buscaPersonaCarnePropietario>0){
				$sw = false;
				$msg = "El propietario ingresado ya existe !!!";
			}else{
				$propietario->id_tipo_propietario = 84;
				$propietario->id_persona = $persona_carne_extranjeria->id;
				$propietario->celular = $request->celular_dni;
				$propietario->email = $request->email_dni;
				$propietario->id_solicitud = $request->id_solicitud;
				//$proyectista->firma = $request->nombre;
				//$profesion->estado = 1;
				$propietario->id_usuario_inserta = $id_user;
				$propietario->save();
				if ($buscaPersonaCarne->count()>1){
					//dd($buscaPersonaDni);exit();
					$tablaMaestra_model = new TablaMaestra;
					$tipo_documento = $tablaMaestra_model->getMaestroC(110,$request->id_tipo_documento);
					$sw = false;
					$msg = "El ".$tipo_documento[0]->denominacion." ingresado ya existe !!!";
				}
			}
			
		}else if(!$persona && $request->ruc_propietario=='' && $request->carne_propietario==''){
			//var_dump($request->ruc_propietario);exit();

			$persona = new Persona();
			$persona->id_tipo_documento = $request->id_tipo_documento;
			$persona->numero_documento = $request->dni_propietario;
			$persona->apellido_paterno = $request->ap_paterno;
			$persona->apellido_materno = $request->ap_materno;
			$persona->nombres = $request->nombres;
			$persona->direccion = $request->direccion_dni;
			$persona->numero_celular = $request->celular_dni;
			$persona->correo = $request->email_dni;
			$persona->id_usuario_inserta = $id_user;
			$persona->save();

			$propietario->id_tipo_propietario = 78;
			$propietario->id_persona = $persona->id;
			$propietario->celular = $request->celular_dni;
			$propietario->email = $request->email_dni;
			$propietario->id_solicitud = $request->id_solicitud;
			//$proyectista->firma = $request->nombre;
			//$profesion->estado = 1;
			$propietario->id_usuario_inserta = $id_user;
			$propietario->save();
			/*if ($buscaPersonaDni->count()>0){
				//dd($buscaPersonaDni);exit();
				$tablaMaestra_model = new TablaMaestra;		
				$tipo_documento = $tablaMaestra_model->getMaestroC(110,$request->id_tipo_documento);
				$sw = false;
				$msg = "El ".$tipo_documento[0]->denominacion." ingresado ya existe !!!";
			}*/
		}else if(!$empresa && $request->dni_propietario=='' && $request->carne_propietario==''){

			$empresa = new Empresa();
			$empresa->ruc = $request->ruc_propietario;
			$empresa->nombre_comercial = $request->razon_social_propietario;
			$empresa->razon_social = $request->razon_social_propietario;
			$empresa->direccion = $request->direccion_ruc;
			$empresa->telefono = $request->telefono_ruc;
			$empresa->email = $request->email_ruc;
			$empresa->id_usuario_inserta = $id_user;
			$empresa->save();

			$propietario->id_tipo_propietario = 79;
			$propietario->id_empresa = $empresa->id;
			$propietario->celular = $request->telefono_ruc;
			$propietario->email = $request->email_ruc;
			$propietario->id_solicitud = $request->id_solicitud;
			//$proyectista->firma = $request->nombre;
			//$profesion->estado = 1;
			$propietario->id_usuario_inserta = $id_user;
			$propietario->save();
		}else if(!$persona_carne_extranjeria && $request->dni_propietario=='' && $request->ruc_propietario==''){

			$persona = new Persona();
			$persona->id_tipo_documento = $request->id_tipo_documento;
			$persona->numero_documento = $request->carne_propietario;
			$persona->apellido_paterno = $request->apellido_paterno_carne_propietario;
			$persona->apellido_materno = $request->apellido_materno_carne_propietario;
			$persona->nombres = $request->nombre_carne_propietario;
			$persona->direccion = $request->direccion_dni;
			$persona->numero_celular = $request->celular_dni;
			$persona->correo = $request->email_dni;
			$persona->id_usuario_inserta = $id_user;
			$persona->save();

			$propietario->id_tipo_propietario = 84;
			$propietario->id_persona = $persona->id;
			$propietario->celular = $request->celular_dni;
			$propietario->email = $request->email_dni;
			$propietario->id_solicitud = $request->id_solicitud;
			//$proyectista->firma = $request->nombre;
			//$profesion->estado = 1;
			$propietario->id_usuario_inserta = $id_user;
			$propietario->save();

			/*if ($buscaPersonaCarne->count()>0){
				//dd($buscaPersonaDni);exit();
				$tablaMaestra_model = new TablaMaestra;		
				$tipo_documento = $tablaMaestra_model->getMaestroC(110,$request->id_tipo_documento);
				$sw = false;
				$msg = "El ".$tipo_documento[0]->denominacion." ingresado ya existe !!!";
			}*/
		}
		$array["sw"] = $sw;
		$array["msg"] = $msg;
		echo json_encode($array);
    }

	public function modal_nuevo_infoProyecto($id){
		
		if($id>0){
			$derechoRevision = DerechoRevision::find($id);
			$uso_edificion = UsoEdificacione::find($id);
			$solicitud = DerechoRevision::where("id",$uso_edificion->id_solicitud)->where("estado","1")->get();
			$uso_edificion_ = UsoEdificacione::where("id_solicitud",$uso_edificion->id_solicitud)->where("estado","1")->get();
			$selectedIds = $uso_edificion_->pluck('id_tipo_uso')->toArray();
			$selectedIdsTramite = $solicitud->pluck('id_tipo_tramite')->toArray();
			$solicitudDocumento = SolicitudDocumento::where("id_solicitud",$uso_edificion->id_solicitud)->where("estado","1")->get();
			$selectedDocumentos = $solicitudDocumento->pluck('ruta_archivo')->toArray();
			$solicitud_ = DerechoRevision::where("id",$uso_edificion->id_solicitud)->where("estado","1")->first();
		}else{
			$derechoRevision = new DerechoRevision;
			$uso_edificion = new UsoEdificacione;
			$selectedIds = [];
			$selectedIdsTramite = [];
			$selectedDocumentos = [];
			$solicitud=new DerechoRevision;
			$solicitud_=new DerechoRevision;
		}
		//var_dump($solicitud_);exit();
		
        return view('frontend.derecho_revision.modal_nuevo_infoProyecto',compact('id','uso_edificion','selectedIds','selectedIdsTramite','selectedDocumentos','solicitud','solicitud_'));
		
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
			$uso_edificion_ = UsoEdificacione::where("id_solicitud",$request->id_solicitud)->where("estado","1")->get();
			
			foreach ($uso_edificion_ as $uso) {
				$uso->estado = "0";
				$uso->id_usuario_inserta = $id_user;
				$uso->save();
			}
		}
		//var_dump($uso_edificion_);exit();
		$procedimientos_complementarios = $request->input('procedimientos_complementarios');
		$procedimientos_complementarios2 = $request->input('procedimientos_complementarios2');

		$procedimientosArray = explode(',', $procedimientos_complementarios2);
		$procedimientosArray = array_map('trim', $procedimientosArray);
		$procedimientosArray = array_filter($procedimientosArray, 'is_numeric');
    	$procedimientosArray = array_map('intval', $procedimientosArray);

		$solicitud = Solicitude::find($request->id_solicitud);
		$solicitud->id_tipo_tramite = $procedimientos_complementarios;
		$solicitud->area_total = $request->areaBruta;
		$solicitud->id_usuario_inserta = $id_user;
		//var_dump($procedimientos_complementarios2);exit();
		$solicitud->save();
			//var_dump($procedimientosArray);exit();

		foreach($procedimientosArray as $uso){
			$usoEdificacion = new UsoEdificacione;
			//var_dump($solicitud->id);exit();
			//$usoEdificacion_ = UsoEdificacione::where("id_solicitud",$solicitud->id)->where("estado","1")->first();
			//$usoEdificacion = UsoEdificacione::find($usoEdificacion_->id);
			//$usoEdificacion = new UsoEdificacione;
			$usoEdificacion->id_tipo_uso = $uso;
			//$usoEdificacion->id_sub_tipo_uso = $procedimientos_complementarios2;
			$usoEdificacion->id_solicitud = $request->id_solicitud;
			$usoEdificacion->area_techada = $request->areaBruta;
			//$proyectista->firma = $request->nombre;
			//$profesion->estado = 1;
			$usoEdificacion->id_usuario_inserta = $id_user;
			$usoEdificacion->save();
		}
		
		
		
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
	
	function redondear_dos_decimal($valor) {
		//$float_redondeado= Math.ceil($valor * 100) / 100;
		return number_format(round($valor + 0.0000001, 2), 2, '.', '');
	}

	public function credipago_pdf($id){
		
		$derecho_revision_model=new DerechoRevision;
		$ubigeo_model = new Ubigeo;
		$parametro_model = new Parametro;
		$proyectista_model = new Proyectista;
		$usoEdificacion_model = new UsoEdificacione;
		$presupuesto_model = new Presupuesto;

		$liquidacion = Liquidacione::find($id);

		$datos_proyectista = $proyectista_model->getProyectistaSolicitud2($liquidacion->id_solicitud);
		$proyectista_nombres = array();
		$proyectista_cap = array();
		$tipo_colegiatura_cap = array();
		foreach($datos_proyectista as $proyectistas){
			$proyectista_nombres[] = $proyectistas->agremiado;
			$proyectista_cap[] = $proyectistas->numero_cap;
			$tipo_colegiatura_cap[] = $proyectistas->tipo_colegiatura;
		}

		$datos_uso_edificacion = $usoEdificacion_model->getUsoEdificacionSolicitud($liquidacion->id_solicitud);
		$tipo_uso_datos = array();
		$sub_tipo_uso_datos = array();
		foreach($datos_uso_edificacion as $uso_edificacion){
			$tipo_uso_datos[] = $uso_edificacion->tipo_uso;
			$sub_tipo_uso_datos[] = $uso_edificacion->sub_tipo_uso;
		}

		$datos_tipo_obra = $presupuesto_model->getTipoObraSolicitud($liquidacion->id_solicitud);
		$tipo_obra_datos = array();
		$area_techada_datos = array();
		foreach($datos_tipo_obra as $tipo_obra){
			$tipo_obra_datos[] = $tipo_obra->tipo_obra;
			$area_techada_datos[] = $tipo_obra->area_techada;
		}
		
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
		$sub_total_ = $datos[0]->sub_total;
		$igv_ = $datos[0]->igv;
		$total_ = $datos[0]->total;
		$sub_total =  number_format(round($sub_total_ + 0.0000001, 2), 2, '.', '');
		$igv =  number_format(round($igv_ + 0.0000001, 2), 2, '.', '');
		$total =  number_format(round($total_ + 0.0000001, 2), 2, '.', '');
		$tipo_proyectista = $datos[0]->tipo_proyectista;
		$tipo_liquidacion = $datos[0]->tipo_liquidacion;
		$instancia = $datos[0]->instancia;
		$tipo_uso = $datos[0]->tipo_uso;
		$tipo_obra = $datos[0]->tipo_obra;
		$codigo = $datos[0]->codigo;
		$tipo_tramite = $datos[0]->tipo_tramite;
		$valor_reintegro = $datos[0]->valor_reintegro;
		$fecha_liquidacion = $datos[0]->fecha_liquidacion;

		$year = Carbon::now()->year;

		$parametro = $parametro_model->getParametroAnio($year);

		$porcentaje_ = $parametro[0]->porcentaje_calculo_edificacion;

		$porcentaje = floatval($porcentaje_) * 100;
		
		$departamento = $ubigeo_model->obtenerDepartamento($departamento_);
		$provincia = $ubigeo_model->obtenerProvincia($departamento_,$provincia_);
		$distrito = $ubigeo_model->obtenerDistrito($departamento_,$provincia_,$distrito_);

		Carbon::setLocale('es');

		// Crear una instancia de Carbon a partir de la fecha

		 $carbonDate =Carbon::now()->format('d-m-Y');

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
		
		$pdf = Pdf::loadView('frontend.derecho_revision.credipago_pdf',compact('credipago','proyectista','numero_cap','razon_social','nombre','departamento','provincia','distrito','direccion','numero_revision','municipalidad','total_area_techada','valor_obra','sub_total','igv','total','carbonDate','currentHour','tipo_proyectista','porcentaje','tipo_liquidacion','instancia','tipo_uso','tipo_obra','codigo','tipo_tramite','proyectista_nombres','proyectista_cap','tipo_uso_datos','sub_tipo_uso_datos','datos_uso_edificacion','tipo_obra_datos','area_techada_datos','tipo_colegiatura_cap','valor_reintegro','fecha_liquidacion'));
		


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
		$proyectista_model = new Proyectista;
		$propietario_model = new Propietario;

		$liquidacion = Liquidacione::find($id);

		$datos_proyectista = $proyectista_model->getProyectistaSolicitudHULiq($liquidacion->id_solicitud);
		$proyectista_nombres = array();
		$proyectista_cap = array();
		foreach($datos_proyectista as $proyectistas){
			$proyectista_nombres[] = $proyectistas->agremiado;
			$proyectista_cap[] = $proyectistas->numero_cap;
		}

		$datos_propietario = $propietario_model->getPropietarioSolicitudHULiq($liquidacion->id_solicitud);
		$propietario_nombres = array();
		foreach($datos_propietario as $propietario){
			$propietario_nombres[] = $propietario->propietario_nombre;
		}

		$datos=$derecho_revision_model->getSolicitudPdfHU2($id);
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
		//$tipo_uso = $datos[0]->tipo_uso;
		$instancia = $datos[0]->instancia;
		$codigo = $datos[0]->codigo;
		$tipo_tramite = $datos[0]->tipo_tramite;
		$id_sitio = $datos[0]->id_sitio;
		$sitio_descripcion = $datos[0]->sitio_descripcion;
		$id_zona = $datos[0]->id_zona;
		$zona_descripcion = $datos[0]->zona_descripcion;
		$parcela = $datos[0]->parcela;
		$super_manzana = $datos[0]->super_manzana;
		$id_tipo = $datos[0]->id_tipo;
		$direccion = $datos[0]->direccion;
		$lote = $datos[0]->lote;
		$sub_lote = $datos[0]->sub_lote;
		$fila = $datos[0]->fila;
		$zonificacion = $datos[0]->zonificacion;
		
		$year = Carbon::now()->year;

		$parametro = $parametro_model->getParametroAnio($year);

		$valor_metro_cuadrado = $parametro[0]->valor_metro_cuadrado_habilitacion_urbana;
		$valor_minimo = $parametro[0]->valor_minimo_hu;
		$valor_maximo_ = $parametro[0]->valor_maximo_hu;
		$valor_maximo = $valor_maximo_*$valor_metro_cuadrado;

		//$porcentaje = floatval($porcentaje_) * 100;
		
		$departamento = $ubigeo_model->obtenerDepartamento($departamento_);
		$provincia = $ubigeo_model->obtenerProvincia($departamento_,$provincia_);
		$distrito = $ubigeo_model->obtenerDistrito($departamento_,$provincia_,$distrito_);

		Carbon::setLocale('es');

		// Crear una instancia de Carbon a partir de la fecha

		 $carbonDate =Carbon::now()->format('d-m-Y');

		 $currentHour = Carbon::now()->format('H:i:s');

		
		$pdf = Pdf::loadView('frontend.derecho_revision.credipago_pdf_HU',compact('credipago','proyectista','numero_cap','razon_social','nombre','departamento','provincia','distrito','direccion','numero_revision','municipalidad','total_area_techada','valor_obra','sub_total','igv','total','carbonDate','currentHour','tipo_proyectista','valor_metro_cuadrado','valor_minimo','valor_maximo','instancia','proyectista_nombres','codigo','proyectista_cap','tipo_tramite','id_sitio', 'sitio_descripcion', 'id_zona', 'zona_descripcion', 'parcela', 'super_manzana', 'id_tipo', 'direccion', 'lote', 'sub_lote', 'fila','zonificacion','propietario_nombres'));

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
		$proyectista_model = new Proyectista;
		$tablaMaestra_model = new TablaMaestra;
		$parametro_model = new Parametro;
		$ubigeo_model=new Ubigeo;
        $liquidacion = $derechoRevision_model->getReintegroByIdSolicitud($id);
		$ubigeo = $liquidacion[0]->id_ubigeo;
		$ubigeo_id = Ubigeo::where("id_ubigeo",$ubigeo)->where("estado","1")->first();
		$departamento = $ubigeo_model->obtenerDepartamento($ubigeo_id->id_departamento);
		$provincia = $ubigeo_model->obtenerProvincia($ubigeo_id->id_departamento,$ubigeo_id->id_provincia);
		$distrito = $ubigeo_model->obtenerDistrito($ubigeo_id->id_departamento,$ubigeo_id->id_provincia,$ubigeo_id->id_distrito);
		$tipo_liquidacion = $tablaMaestra_model->getMaestroByTipo(27);
		$instancia = $tablaMaestra_model->getMaestroByTipo(47);
		$anio_actual = Carbon::now()->year;
		$parametro = $parametro_model->getParametroAnio($anio_actual);
		$proyectista_ = $proyectista_model->getDatosProyectistaIngeniero_($id);
		$proyectista_solicitud = $proyectista_model->getProyectistaSolicitud_($id);
		$datos_proyectista = $proyectista_model->getDatosProyectistaIngeniero($id);
		$tipo_proyectista = $tablaMaestra_model->getMaestroByTipo(41);
		$principal_asociado = $tablaMaestra_model->getMaestroByTipo(130);
		$tipo_proyecto = $tablaMaestra_model->getMaestroByTipo(25);
		$derechoRevision_ = DerechoRevision::find($id);
		$datos_usoEdificaciones = UsoEdificacione::where("id_solicitud",$derechoRevision_->id)->where("estado","1")->orderBy('id')->get();
		$tipo_uso = $tablaMaestra_model->getMaestroByTipoByTipoNombre(111,'TIPO USO');
		$datos_presupuesto = Presupuesto::where("id_solicitud",$derechoRevision_->id)->where("estado","1")->orderBy('id')->get();
		$tipo_obra = $tablaMaestra_model->getMaestroByTipo(112);

		//var_dump($parametro);exit;

        return view('frontend.derecho_revision.modal_reintegro',compact('id','liquidacion','departamento','provincia','distrito','tipo_liquidacion','instancia','parametro','proyectista_','proyectista_solicitud','datos_proyectista','tipo_proyectista','principal_asociado','tipo_proyecto','derechoRevision_','datos_usoEdificaciones','tipo_uso','datos_presupuesto','tipo_obra'));
		
    }

	public function modal_reintegroRU($id){
		 
		//$derechoRevision = new DerechoRevision;
		$derechoRevision_model = new DerechoRevision;
		$tablaMaestra_model = new TablaMaestra;
		$parametro_model = new Parametro;
		$ubigeo_model=new Ubigeo;
        $liquidacion = $derechoRevision_model->getReintegroByIdSolicitud($id);
		$ubigeo = $liquidacion[0]->id_ubigeo;
		$ubigeo_id = Ubigeo::where("id_ubigeo",$ubigeo)->where("estado","1")->first();
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

	public function eliminar_credipago($id,$id_situacion)
    {
		$liquidacion = Liquidacione::find($id);
		$liquidacion->id_situacion = $id_situacion;
		$liquidacion->save();

		$solicitud = DerechoRevision::find($liquidacion->id_solicitud);
		$solicitud->id_resultado = 3;
		$solicitud->save();

		echo $liquidacion->id;
    }

	function importar_dataLicencia(){
	
		
		$derecho_revision_model = new DerechoRevision;

		$data = [];

		$data['empresas'] = $derecho_revision_model->importar_empresas_dataLicencia();

		$data['personas'] = $derecho_revision_model->importar_personas_dataLicencia();
		
		$data['proyectos'] = $derecho_revision_model->importar_proyectos_dataLicencia();
		
		$data['solicitudes'] = $derecho_revision_model->importar_solicitudes_dataLicencia();

		$data['uso_edificaciones'] = $derecho_revision_model->importar_uso_edificacion_dataLicencia();

		$data['presupuesto'] = $derecho_revision_model->importar_presupuesto_dataLicencia();

		$data['proyectista'] = $derecho_revision_model->importar_proyectista_dataLicencia();
		
		$result["aaData"] = $data;

		//var_dump($data);exit;

		echo json_encode($result);
	
	}

	public function eliminar_solicitud_edificaciones($id,$estado)
    {
		$derecho_revision = DerechoRevision::find($id);
		$derecho_revision->estado = $estado;
		$derecho_revision->save();

		echo $derecho_revision->id;
    }

	public function eliminar_solicitud_hu($id,$estado)
    {
		$derecho_revision = DerechoRevision::find($id);
		$derecho_revision->estado = $estado;
		$derecho_revision->save();

		echo $derecho_revision->id;
    }

	public function obtener_ubigeo($distrito){
			
		$municipalidad_model = new Municipalidade;
		$IdUbigeo = $municipalidad_model->getIdUbigeoByMunicipalidad($distrito);
		//print_r($tipo_solicitud);
		//$array["id"] = $tipo_solicitud->id;
		//echo json_encode($tipo_solicitud);

		$datos_formateados = [];

        foreach ($IdUbigeo as $ubigeo) {
            $datos_formateados[] = [
                'municipalidad' => $ubigeo->id,
				'denominacion' => $ubigeo->denominacion,
                //'id_provincia' => $ubigeo->id_provincia,
				//'id_distrito' => $ubigeo->id_ubigeo,
            ];
        }
        return response()->json($datos_formateados);
		
	}

	public function derecho_revision_reintegro($id){

		$agremiado_model = new Agremiado;
		$persona_model = new Persona;
		//$propietario_model = new Propietario;
		$derechoRevision_ = DerechoRevision::find($id);
		$proyectista_model = new Proyectista();
		$proyecto_ = Proyecto::where("id",$derechoRevision_->id_proyecto)->where("estado","1")->first();
		$proyecto2 = Proyecto::find($proyecto_->id);
		//var_dump($proyecto2->id_tipo_sitio);exit();
		$proyectista_ = $proyectista_model->getProyectistaIngeniero($id);
		//var_dump($proyectista_);exit();
		$proyectista = Proyectista::find($proyectista_[0]->id_profesional);
		$profesionales_otro = ProfesionalesOtro::find($proyectista_[0]->id_profesional);

		$datos_proyectista = $proyectista_model->getDatosProyectistaIngeniero($id);
		/*$agremiado_ = Agremiado::find($proyectista_[0]->id_agremiado);
		$datos_agremiado= $agremiado_model->getAgremiado(85,$agremiado_->numero_cap);
		$persona_ = Persona::where("id",$agremiado_->id_persona)->where("estado","1")->first();
		//var_dump($persona_->numero_documento);exit();
		$datos_persona= $persona_model->getPersonaById(78,$persona_->id);*/

		$datos_usoEdificaciones = UsoEdificacione::where("id_solicitud",$derechoRevision_->id)->where("estado","1")->orderBy('id')->get();
		$datos_presupuesto = Presupuesto::where("id_solicitud",$derechoRevision_->id)->where("estado","1")->orderBy('id')->get();
		//$datos_propietario= $propietario_model->getPropietarioSolicitud($id);
		//var_dump($proyectista_->id_agremiado);exit();
		$tipo_solicitante = 1;
		
		$proyectista_model = new Proyectista;
		$propietario_model = new Propietario;
		$derechoRevision_model = new DerechoRevision;
		$derechoRevision = new DerechoRevision;
		$agremiado = new Agremiado;
		$persona = new Persona;
		$proyecto = new Proyecto;
		$tablaMaestra_model = new TablaMaestra; 
		$ubigeo_model = new Ubigeo;
		$municipalidad_model = new Municipalidade;
		$presupuesto_model = new Presupuesto;
		$usoEdificacione_model = new UsoEdificacione;
		$parametro_model = new Parametro;
		$empresa = new Empresa;

		$departamento = $ubigeo_model->getDepartamento();
        $sitio = $tablaMaestra_model->getMaestroByTipo(33);
        $zona = $tablaMaestra_model->getMaestroByTipo(34);
		$tipo = $tablaMaestra_model->getMaestroByTipo(35);
		$tipo_proyectista = $tablaMaestra_model->getMaestroByTipo(41);
		$principal_asociado = $tablaMaestra_model->getMaestroByTipo(130);
		$tipo_proyecto = $tablaMaestra_model->getMaestroByTipo(25);
		$tipo_uso = $tablaMaestra_model->getMaestroByTipoByTipoNombre(111,'TIPO USO');
		//$sub_tipo_uso = $tablaMaestra_model->getMaestroByTipoByTipoNombre(111,'SUB TIPO USO');
		//$sub_tipo_uso = $tablaMaestra_model->getMaestroByTipoAndSubTipo(111,$sub_codigo);
		
		$tipo_obra = $tablaMaestra_model->getMaestroByTipo(112);
		$tipo_liquidacion = $tablaMaestra_model->getMaestroByTipo(27);
		$instancia = $tablaMaestra_model->getMaestroByTipo(47);
		$tipo_documento = $tablaMaestra_model->getMaestroByTipo(16);
		$municipalidad = $municipalidad_model->getMunicipalidadOrden();
		$proyectista_solicitud = $proyectista_model->getProyectistaSolicitud_($id);
		//$propietario_ = Propietario::where("id_solicitud",$derechoRevision_->id)->where("estado","1")->orderBy('id')->first();
		//var_dump($derechoRevision_->id).exit();
		$propietario_solicitud = $propietario_model->getPropietarioSolicitud($id);
		//var_dump($propietario_solicitud[0]).exit();
		$info_solicitud = $presupuesto_model->getInfoSolicitud($id);
		$info_uso_solicitud = $usoEdificacione_model->getInfoSolicitudUso2($id);
		$anio_actual = Carbon::now()->year;
		$parametro = $parametro_model->getParametroAnio($anio_actual);
		$liquidacion = $derechoRevision_model->getReintegroByIdSolicitud($id);
		//dd($liquidacion);
        return view('frontend.derecho_revision.all_derecho_revision_reintegro',compact('id','derechoRevision','proyectista','agremiado','persona','proyecto','sitio','zona','tipo','departamento','municipalidad','proyectista_solicitud','propietario_solicitud','derechoRevision_','proyecto2','tipo_solicitante',/*'datos_agremiado','datos_persona',*/'info_solicitud','info_uso_solicitud','tipo_proyecto','tipo_uso','datos_usoEdificaciones',/*'sub_tipo_uso',*/'tipo_obra','datos_presupuesto','tipo_liquidacion','instancia','parametro','liquidacion','tipo','tipo_documento','empresa','tipo_proyectista','profesionales_otro','datos_proyectista','principal_asociado'));
    }

	public function send_nuevo_reintegro(Request $request){
		
		//dd($request->id_tipo_documento);exit();

		$tipo_uso = $request->tipo_uso;
		$sub_tipo_uso = $request->sub_tipo_uso;
		$area_techada = $request->area_techada;
		$tipo_obra = $request->tipo_obra;
		$area_techada_presupuesto = $request->area_techada_presupuesto;
		$valor_unitario = $request->valor_unitario;
		$presupuesto_ = $request->presupuesto;
		//$numero_cap_row = $request->numero_cap_row;
		//var_dump($request->numero_cap_row);exit();
		$tipo_proyectista_row = $request->tipo_proyectista_row;
		//var_dump($tipo_proyectista_row);exit();
		$tipo_colegiatura_row = $request->tipo_colegiatura_row;
		
		$id_user = Auth::user()->id;
		$id_solicitud = $request->id_solicitud_reintegro;
		//dd($id_solicitud).exit();
		$agremiado = Agremiado::where("numero_cap",$request->numero_cap)->where("estado","1")->first();
		$ubigeo = $request->distrito;
		$id_ubi = Ubigeo::where("id_ubigeo",$ubigeo)->where("estado","1")->first();
		//$ubigeo = Ubigeo::where("numero_cap",$request->numero_cap)->where("estado","1")->first();
		$solicitud_matriz = Solicitude::find($request->id_solicitud);
		//dd($solicitud_matriz).exit();
		if($id_solicitud == 0){
			$derecho_revision = new DerechoRevision;
			$proyecto = new Proyecto;
			$proyectista = new Proyectista;
			$uso_edificacion = new UsoEdificacione;
			$presupuesto = new Presupuesto;
		}else{
			$derecho_revision = DerechoRevision::find($request->id_solicitud);
			$proyecto = Proyecto::find($derecho_revision->id_proyecto);
			$proyectista = Proyectista::find($derecho_revision->id_proyectista);
		}
		
		//$id_tipo_solicitud = $solicitud->id_tipo_solicitud;

		$derecho_revision->id_regional = 5;
		$derecho_revision->fecha_registro = Carbon::now()->format('Y-m-d');
		$derecho_revision->numero_revision = $request->n_revision;
		$derecho_revision->direccion = $request->direccion_proyecto;
		$derecho_revision->id_municipalidad = $request->municipalidad;
		$derecho_revision->id_ubigeo = $ubigeo;
		$derecho_revision->id_resultado = 2;
		$derecho_revision->id_instancia = $request->instancia;
		$derecho_revision->id_tipo_solicitud = $solicitud_matriz->id_tipo_solicitud;
		$derecho_revision->id_tipo_tramite = $request->tipo_proyecto;
		$derecho_revision->numero_sotano = $request->n_sotanos;
		$derecho_revision->azotea = $request->azotea;
		$derecho_revision->semisotano = $request->semisotano;
		$derecho_revision->numero_piso = $request->n_pisos;
		$derecho_revision->valor_obra = convertir_entero($request->valor_total_obra);
		$derecho_revision->area_total = convertir_entero($request->area_techada_total);
		$derecho_revision->id_tipo_liquidacion1 = $request->tipo_liquidacion1;
		$derecho_revision->valor_reintegro = convertir_entero($request->valor_reintegro);

		$derecho_revision->id_usuario_inserta = $id_user;
		
		$proyecto->id_ubigeo = $ubigeo;
		$proyecto->nombre = $request->nombre_proyecto;
		$proyecto->direccion = $request->direccion_proyecto;
		$proyecto->id_tipo_direccion = $request->tipo_direccion;
		$proyecto->id_tipo_proyecto = $solicitud_matriz->id_tipo_solicitud;
		$proyecto->codigo = $request->codigo_proyecto;
		$proyecto->id_usuario_inserta = $id_user;
		$proyecto->save();

		if($request->tipo_colegiatura=="CAP"){
		
			$agremiado = Agremiado::where("numero_cap",$request->numero_cap)->where("estado","1")->first();
	
			$proyectista->id_tipo_profesional = $request->tipo_proyectista;
			$proyectista->id_agremiado = $agremiado->id;
			$proyectista->celular = $agremiado->celular1;
			$proyectista->email = $agremiado->email1;
			$proyectista->id_tipo_proyectista = $request->principal_asociado;
			
			$proyectista->id_usuario_inserta = $id_user;
			$proyectista->save();
			
			$derecho_revision->id_proyecto = $proyecto->id;
			$derecho_revision->id_proyectista = $proyectista->id;
			$derecho_revision->save();
			
			$proyectistaNew = Proyectista::find($proyectista->id);
			$proyectistaNew->id_solicitud = $derecho_revision->id;
			$proyectistaNew->save();
			
		}
		
		if($request->tipo_colegiatura=="CIP"){
			
			$derecho_revision->id_proyecto = $proyecto->id;
			$derecho_revision->save();
			
			$profesionalesOtroBus = ProfesionalesOtro::where("colegiatura",$request->numero_cap)->where("estado","1")->first();
					
			$profesionalesOtro = new ProfesionalesOtro;
			$profesionalesOtro->id_tipo_profesional = $request->tipo_proyectista;
			$profesionalesOtro->colegiatura = $request->numero_cap;
			$profesionalesOtro->colegiatura_abreviatura = "CIP";
			$profesionalesOtro->id_persona = $profesionalesOtroBus->id_persona;
			$profesionalesOtro->id_profesion = 1;
			$profesionalesOtro->id_solicitud = $derecho_revision->id;
			$profesionalesOtro->id_tipo_proyectista = $request->principal_asociado;
			$profesionalesOtro->id_usuario_inserta = $id_user;
			$profesionalesOtro->save();
			
		}
		
		if(isset($tipo_proyectista_row)){
		
			foreach($tipo_proyectista_row as $key=>$row){
				
			//var_dump($tipo_colegiatura_row[2]);exit();
				//echo "ok";
				//if(isset($tipo_proyectista_row[$key]) && $tipo_proyectista_row[$key]>0){
					
					if($tipo_colegiatura_row[$key]=="CAP"){
					
						$agremiado = Agremiado::where("numero_cap",$request->numero_cap_row[$key])->where("estado","1")->first();
						//var_dump($numero_cap_row[3]);exit();
						$proyectista = new Proyectista;
						$proyectista->id_tipo_profesional = (isset($tipo_proyectista_row[$key]) && $tipo_proyectista_row[$key]>0)?$tipo_proyectista_row[$key]:0;
						$proyectista->id_agremiado = $agremiado->id;
						$proyectista->celular = $agremiado->celular1;
						$proyectista->email = $agremiado->email1;
						$proyectista->id_solicitud = $derecho_revision->id;
						//var_dump($key);exit();
						$proyectista->id_tipo_proyectista = 2;
						$proyectista->id_usuario_inserta = $id_user;
						$proyectista->save();
					}
					
					if($tipo_colegiatura_row[$key]=="CIP"){
					
						//var_dump($request->numero_cap_row[$key]);exit();
						$profesionalesOtroBus = ProfesionalesOtro::where("colegiatura",$request->numero_cap_row[$key])->where("estado","1")->first();
						
						$profesionalesOtro = new ProfesionalesOtro;
						$profesionalesOtro->id_tipo_profesional = (isset($tipo_proyectista_row[$key]) && $tipo_proyectista_row[$key]>0)?$tipo_proyectista_row[$key]:0;
						$profesionalesOtro->colegiatura = $request->numero_cap_row[$key];
						$profesionalesOtro->colegiatura_abreviatura = "CIP";
						$profesionalesOtro->id_persona = $profesionalesOtroBus->id_persona;
						$profesionalesOtro->id_profesion = 1;
						$profesionalesOtro->id_solicitud = $derecho_revision->id;
						$profesionalesOtro->id_tipo_proyectista = 2;
						$profesionalesOtro->id_usuario_inserta = $id_user;
						$profesionalesOtro->save();
					}
					
				//}
			}
			
		}
		
		/***********************************/
		
		if(isset($tipo_uso)){
		
			foreach($tipo_uso as $key=>$row){
				//echo "ok";
				$uso_edificacion = new UsoEdificacione;
				$uso_edificacion->id_tipo_uso = $tipo_uso[$key];
				$uso_edificacion->id_sub_tipo_uso = $sub_tipo_uso[$key];
				$uso_edificacion->area_techada = convertir_entero($area_techada[$key]);
				$uso_edificacion->id_solicitud = $derecho_revision->id;
				$uso_edificacion->id_usuario_inserta = $id_user;
				$uso_edificacion->save();
				
				/*
				$uso_edificacion->id_tipo_uso = $request->tipo_uso;
				$uso_edificacion->id_sub_tipo_uso = $request->sub_tipo_uso;
				$uso_edificacion->area_techada = convertir_entero($request->area_techada);
				$uso_edificacion->id_solicitud = $derecho_revision->id;
				$uso_edificacion->id_usuario_inserta = $id_user;
				$uso_edificacion->save();
				*/
			}
		
		}
		
		if(isset($tipo_obra)){
		
			foreach($tipo_obra as $key=>$row){
				
				$presupuesto1 = new Presupuesto;
				$presupuesto1->id_tipo_obra = $tipo_obra[$key];
				$presupuesto1->area_techada = convertir_entero($area_techada_presupuesto[$key]);
				$presupuesto1->valor_unitario = convertir_entero($valor_unitario[$key]);
				$presupuesto1->total_presupuesto = convertir_entero($presupuesto_[$key]);
				$presupuesto1->id_solicitud = $derecho_revision->id;
				$presupuesto1->id_usuario_inserta = $id_user;
				$presupuesto1->save();
				
				/*
				$presupuesto->id_tipo_obra = $request->tipo_obra;
				$presupuesto->area_techada = convertir_entero($request->area_techada_presupuesto);
				$presupuesto->valor_unitario = convertir_entero($request->valor_unitario);
				$presupuesto->total_presupuesto = convertir_entero($request->presupuesto);
				$presupuesto->id_solicitud = $derecho_revision->id;
				$presupuesto->id_usuario_inserta = $id_user;
				$presupuesto->save();
				*/
	
			}
			
		}
		
		/***********************************/
		
		if($request->id_tipo_documento=='78'){
			$persona = Persona::where("numero_documento",$request->dni_propietario)->where("estado","1")->first();
			$empresa = null;
		}
		if($request->id_tipo_documento=='79'){
			$persona = null;
			$empresa = Empresa::where("ruc",$request->ruc_propietario)->where("estado","1")->first();
		}
		
		if($id_solicitud == 0){
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
			$propietario->id_solicitud = $derecho_revision->id;
			//$proyectista->firma = $request->nombre;
			//$profesion->estado = 1;
			$propietario->id_usuario_inserta = $id_user;
			$propietario->save();

		}else if($empresa){
			$propietario->id_tipo_propietario = 79;
			$propietario->id_empresa = $empresa->id;
			$propietario->celular = $request->telefono_ruc;
			$propietario->email = $request->email_ruc;
			$propietario->id_solicitud = $derecho_revision->id;
			//$proyectista->firma = $request->nombre;
			//$profesion->estado = 1;
			$propietario->id_usuario_inserta = $id_user;
			$propietario->save();
		}

		$propietario = Propietario::where("id_solicitud",$derecho_revision->id)->where("estado","1")->first();
		
		if(isset($propietario->id_empresa) && $propietario->id_empresa>0){
			$empresa = Empresa::where("id",$propietario->id_empresa)->where("estado","1")->first();
			$empresa_cantidad = Empresa::where("ruc",$empresa->ruc)->where("estado","1")->count();
		}
		
		if(isset($propietario->id_persona) && $propietario->id_persona>0){
			$persona = Persona::where("id",$propietario->id_persona)->where("estado","1")->first();
			$empresa_cantidad = Persona::where("numero_documento",$persona->numero_documento)->where("estado","1")->count();
		}
		
		if($empresa_cantidad==1){
			if($request->instancia==250)$valor_obra = convertir_entero($request->valor_reintegro);

			$anio = Carbon::now()->year;
			$parametro = Parametro::where("anio",$anio)->where("estado",1)->orderBy("id","desc")->first();
			
			$uit = $parametro->valor_uit;
		
			/*****Edificaciones*********/
			if($solicitud_matriz->id_tipo_solicitud == 123){
				
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
				/*$solicitud = new Solicitude;
				$solicitud->id_instancia=$request->instancia;
				$solicitud->id_tipo_liquidacion1=$request->tipo_liquidacion1;
				$solicitud->id_usuario_inserta = $id_user;
				$solicitud->save();*/

			}
				
			/*****Habilitaciones urbanas*********/
			
			if($solicitud_matriz->id_tipo_solicitud == 124){
				
				$m2 = $parametro->valor_metro_cuadrado_habilitacion_urbana;
				
				$sub_total 	= ($m2*$area_total);
				$igv		= ($parametro->igv*$sub_total);
				$total		= $sub_total + $igv;
				
				$total_minimo		= $parametro->valor_minimo_hu;
				$sub_total_minimo 	= $total_minimo/(1+$parametro->igv);
				$igv_minimo			= $total_minimo - $sub_total_minimo;
				
				$total_maximo		= $parametro->valor_maximo_hu*$m2;
				$sub_total_maximo 	= $total_maximo/(1+$parametro->igv);
				$igv_maximo			= $total_maximo - $sub_total_maximo;
				
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
				$solicitud = new Solicitude;
				$concepto = Concepto::where("id",26483)->where("estado","1")->first();
				$solicitud->id_resultado='2';
				$solicitud->id_usuario_inserta = $id_user;
				$solicitud->save();
			}
			
			$codigoSolicitud = $derecho_revision->getCodigoSolicitud($solicitud_matriz->id_tipo_solicitud);
			$codigo1 = $codigoSolicitud->codigo;
			$numero_correlativo = $codigoSolicitud->numero;
			$codigo2 = $derecho_revision->getCountProyectoTipoSolicitud($solicitud_matriz->id_proyecto,$solicitud_matriz->id_tipo_solicitud);
			$codigo = $codigo1.$codigo2;
			
			$id_user = Auth::user()->id;
			$liquidacion = new Liquidacione;
			$liquidacion->id_solicitud = $derecho_revision->id;
			$liquidacion->fecha = Carbon::now()->format('Y-m-d');
			$liquidacion->credipago = $codigo;
			$liquidacion->sub_total = number_format($sub_total, 2, '.', '');
			$liquidacion->igv = number_format($igv, 2, '.', '');
			$liquidacion->total = number_format($total, 2, '.', '');
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
			
			$valorizacion->monto = number_format($liquidacion->total, 2, '.', '');
			$valorizacion->id_moneda = $concepto->id_moneda;
			$valorizacion->fecha = Carbon::now()->format('Y-m-d');
			$valorizacion->fecha_proceso = Carbon::now()->format('Y-m-d');
			//$valorizacion->descripcion = $concepto->denominacion ." - ". $liquidacion->credipago;
			$fechaValorizacion = Carbon::now();
			$fecha_valorizacion = $fechaValorizacion->format('my');
			$municipalidad = Municipalidade::where("id",$solicitud_matriz->id_municipalidad)->where("estado","1")->first();
			$valorizacion->descripcion = $concepto->denominacion ." - ". $liquidacion->credipago ." - ". $municipalidad->denominacion ." - ". $fecha_valorizacion ;
			//$valorizacion->estado = 1;
			$valorizacion->id_usuario_inserta = $id_user;
			$valorizacion->save();
			
			$numeracionDocumento = NumeracionDocumento::where("id_tipo_documento",20)->where("estado",1)->first();
			$numeracionDocumento->numero = $numero_correlativo;
			$numeracionDocumento->save();
			
			$sw = true;
		}
		return response()->json($derecho_revision->id);
		
	}

	public function obtener_provincia_distrito_solicitud($id){
		
		$derechoRevision_model = new DerechoRevision;
		$solicitud_ubigeo = $derechoRevision_model->getProvinciaDistritoByIdSolicitud($id);
		
		echo json_encode($solicitud_ubigeo);
	}

	public function eliminar_proyectista_hu($id){

		$proyectista = Proyectista::find($id);
		$proyectista->estado= "0";
		$proyectista->save();
		
		echo "success";

    }

	public function eliminar_propietario_hu($id){

		$propietario = Propietario::find($id);
		$propietario->estado= "0";
		$propietario->save();
		
		echo "success";

    }

	public function eliminar_infoProyecto_hu($id){

		$uso_edificacion = UsoEdificacione::find($id);
		$uso_edificacion->estado= "0";
		$uso_edificacion->save();
		
		echo "success";

    }

	public function derecho_revision_editar_reintegro($id){

		$agremiado_model = new Agremiado;
		$persona_model = new Persona;
		
		$solicitud = Solicitude::find($id);
		$proyectista_model = new Proyectista;
		
		//$propietario_model = new Propietario;
		$derechoRevision_ = DerechoRevision::find($id);
		$proyecto_ = Proyecto::where("id",$derechoRevision_->id_proyecto)->where("estado","1")->first();
		$proyecto2 = Proyecto::find($proyecto_->id);
		//var_dump($request->tipo_colegiatura);exit();

		$proyectista = $proyectista_model->datos_proyectista_editar($id);
		
		if($proyectista[0]->tipo_colegiatura=='CAP'){
			
			$proyectista_ = Proyectista::where("id_solicitud",$id)->where("estado","1")->orderBy('id')->first();
			$proyectista = Proyectista::find($proyectista_->id);
			$agremiado_ = Agremiado::find($proyectista_->id_agremiado);
			$datos_agremiado= $agremiado_model->getAgremiado(85,$agremiado_->numero_cap);
			$persona_ = Persona::where("id",$agremiado_->id_persona)->where("estado","1")->first();
			//var_dump($proyectista[0]->tipo_colegiatura);exit();
		}
		
		else if($proyectista[0]->tipo_colegiatura=='CIP'){
			$proyectista_ = ProfesionalesOtro::where("id_solicitud",$id)->where("estado","1")->orderBy('id')->first();
			$proyectista = ProfesionalesOtro::find($proyectista_->id);
			$persona_ = Persona::where("id",$proyectista->id_persona)->where("estado","1")->first();
			$datos_agremiado = new \stdClass();
			$datos_agremiado->numero_cap=$proyectista->colegiatura;
			$datos_agremiado->situacion='';
			$datos_agremiado->celular1=$persona_->numero_celular;
			$datos_agremiado->email=$persona_->correo;
			$datos_agremiado->actividad='';
			//var_dump($proyectista->colegiatura);exit();
		}
		
		
		$datos_persona= $persona_model->getPersonaById(78,$persona_->id);
		$datos_usoEdificaciones = UsoEdificacione::where("id_solicitud",$derechoRevision_->id)->where("estado","1")->orderBy('id')->get();
		$datos_presupuesto = Presupuesto::where("id_solicitud",$derechoRevision_->id)->where("estado","1")->orderBy('id')->get();
		//$datos_propietario= $propietario_model->getPropietarioSolicitud($id);
		//var_dump($proyectista_->id_agremiado);exit();
		$tipo_solicitante = 1;
		

		$proyectista_model = new Proyectista;
		$propietario_model = new Propietario;
		$derechoRevision_model = new DerechoRevision;
		$derechoRevision = new DerechoRevision;
		$agremiado = new Agremiado;
		$persona = new Persona;
		$proyecto = new Proyecto;
		$tablaMaestra_model = new TablaMaestra; 
		$ubigeo_model = new Ubigeo;
		$municipalidad_model = new Municipalidade;
		$presupuesto_model = new Presupuesto;
		$usoEdificacione_model = new UsoEdificacione;
		$parametro_model = new Parametro;
		$empresa = new Empresa;
		$liquidacion_model = new Liquidacione;

		$departamento = $ubigeo_model->getDepartamento();
        $sitio = $tablaMaestra_model->getMaestroByTipo(33);
        $zona = $tablaMaestra_model->getMaestroByTipo(34);
		$tipo = $tablaMaestra_model->getMaestroByTipo(35);
		$tipo_proyecto = $tablaMaestra_model->getMaestroByTipo(25);
		$tipo_uso = $tablaMaestra_model->getMaestroByTipoByTipoNombre(111,'TIPO USO');
		//$sub_tipo_uso = $tablaMaestra_model->getMaestroByTipoByTipoNombre(111,'SUB TIPO USO');
		//$sub_tipo_uso = $tablaMaestra_model->getMaestroByTipoAndSubTipo(111,$sub_codigo);
		
		$tipo_obra = $tablaMaestra_model->getMaestroByTipo(112);
		$tipo_liquidacion = $tablaMaestra_model->getMaestroByTipo(27);
		$instancia = $tablaMaestra_model->getMaestroByTipo(47);
		$tipo_documento = $tablaMaestra_model->getMaestroByTipo(16);
		$municipalidad = $municipalidad_model->getMunicipalidadOrden();
		$proyectista_solicitud = $proyectista_model->getProyectistaSolicitud_($id);
		//$propietario_ = Propietario::where("id_solicitud",$derechoRevision_->id)->where("estado","1")->orderBy('id')->first();
		//var_dump($derechoRevision_->id).exit();
		$propietario_solicitud = $propietario_model->getPropietarioSolicitud($id);
		//var_dump($propietario_solicitud[0]).exit();
		$info_solicitud = $presupuesto_model->getInfoSolicitud($id);
		$info_uso_solicitud = $usoEdificacione_model->getInfoSolicitudUso2($id);
		$anio_actual = Carbon::now()->year;
		$parametro = $parametro_model->getParametroAnio($anio_actual);
		$liquidacion = $derechoRevision_model->getReintegroByIdSolicitud($id);
		$liquidacion_datos = $liquidacion_model->getLiquidacionByIdSolicitud($id);
		//var_dump($liquidacion_datos);exit();
		//dd($liquidacion);
        return view('frontend.derecho_revision.all_derecho_revision_edit_reintegro',compact('id','derechoRevision','proyectista','agremiado','persona','proyecto','sitio','zona','tipo','departamento','municipalidad','proyectista_solicitud','propietario_solicitud','derechoRevision_','proyecto2','tipo_solicitante','datos_agremiado','datos_persona','info_solicitud','info_uso_solicitud','tipo_proyecto','tipo_uso','datos_usoEdificaciones',/*'sub_tipo_uso',*/'tipo_obra','datos_presupuesto','tipo_liquidacion','instancia','parametro','liquidacion','tipo','tipo_documento','empresa','solicitud','liquidacion_datos'));
    }

	public function send_editar_reintegro(Request $request){  
		
		$id_uso_edificaciones = $request->id_uso_edificaciones;
		$id_presupuesto = $request->id_presupuesto;
		$tipo_uso = $request->tipo_uso;
		$sub_tipo_uso = $request->sub_tipo_uso;
		$area_techada = $request->area_techada;
		$tipo_obra = $request->tipo_obra;
		$area_techada_presupuesto = $request->area_techada_presupuesto;
		$valor_unitario = $request->valor_unitario;
		$presupuesto_ = $request->presupuesto;
		
		$id_user = Auth::user()->id;
		$id_solicitud = $request->id_solicitud_reintegro;
		//dd($id_solicitud).exit();
		$agremiado = Agremiado::where("numero_cap",$request->numero_cap)->where("estado","1")->first();
		$ubigeo = $request->distrito;
		$id_ubi = Ubigeo::where("id_ubigeo",$ubigeo)->where("estado","1")->first();
		//$ubigeo = Ubigeo::where("numero_cap",$request->numero_cap)->where("estado","1")->first();
		$solicitud_matriz = Solicitude::find($request->id_solicitud); 
		
		$solicitud_matriz->valor_reintegro = convertir_entero($request->valor_reintegro);
		$solicitud_matriz->save();
		
		//var_dump($request->id_solicitud);exit();
		
		
		$derecho_revision = DerechoRevision::find($request->id_solicitud);
		//$proyecto = Proyecto::find($derecho_revision->id_proyecto);
		//$proyectista = Proyectista::find($derecho_revision->id_proyectista);
		
		$derecho_revision->id_regional = 5;
		//$derecho_revision->fecha_registro = Carbon::now()->format('Y-m-d');
		//$derecho_revision->numero_revision = $request->n_revision;
		//$derecho_revision->direccion = $request->direccion_proyecto;
		//$derecho_revision->id_municipalidad = $request->municipalidad;
		//$derecho_revision->id_ubigeo = $ubigeo;
		//$derecho_revision->id_resultado = 2;
		$derecho_revision->id_instancia = $request->instancia;
		$derecho_revision->id_tipo_solicitud = $solicitud_matriz->id_tipo_solicitud;
		$derecho_revision->id_tipo_tramite = $request->tipo_proyecto;
		$derecho_revision->numero_sotano = $request->n_sotanos;
		$derecho_revision->azotea = $request->azotea;
		$derecho_revision->semisotano = $request->semisotano;
		$derecho_revision->numero_piso = $request->n_pisos;
		$derecho_revision->valor_obra = convertir_entero($request->valor_total_obra);
		$derecho_revision->area_total = convertir_entero($request->area_techada_total);
		$derecho_revision->id_tipo_liquidacion1 = $request->tipo_liquidacion1;
		
		$derecho_revision->id_usuario_inserta = $id_user;
		
		
		//$derecho_revision->id_proyecto = $proyecto->id;
		//$derecho_revision->id_proyectista = $proyectista->id;
		$derecho_revision->save();
		//$proyectista->id_solicitud = $derecho_revision->id;
		//$proyectista->save();
		
		$array_tipo_uso = array();
		
		foreach($tipo_uso as $key=>$row){
			
			if(isset($id_uso_edificaciones[$key]) && $id_uso_edificaciones[$key]>0){
				$uso_edificacion = UsoEdificacione::find($id_uso_edificaciones[$key]);
			}else{
				$uso_edificacion = new UsoEdificacione;
			}
			
			$uso_edificacion->id_tipo_uso = $tipo_uso[$key];
			$uso_edificacion->id_sub_tipo_uso = $sub_tipo_uso[$key];
			$uso_edificacion->area_techada = convertir_entero($area_techada[$key]);
			$uso_edificacion->id_solicitud = $derecho_revision->id;
			$uso_edificacion->id_usuario_inserta = $id_user;
			$uso_edificacion->save();
			
			$array_tipo_uso[] = $uso_edificacion->id;
		}
		
		
		$usoEdificacionAll = UsoEdificacione::where("id_solicitud",$request->id_solicitud)->where("estado","1")->get();
		foreach($usoEdificacionAll as $key=>$row){
			
			if (!in_array($row->id, $array_tipo_uso)){
				$uso_edificacion = UsoEdificacione::find($row->id);
				$uso_edificacion->estado = 0;
				$uso_edificacion->save();
			}
			
		}
		
		$array_tipo_obra = array();
		
		foreach($tipo_obra as $key=>$row){
			
			if(isset($id_presupuesto[$key]) && $id_presupuesto[$key]>0){
				$presupuesto1 = Presupuesto::find($id_presupuesto[$key]);
			}else{
				$presupuesto1 = new Presupuesto;
			}
			
			$presupuesto1->id_tipo_obra = $tipo_obra[$key];
			$presupuesto1->area_techada = convertir_entero($area_techada_presupuesto[$key]);
			$presupuesto1->valor_unitario = convertir_entero($valor_unitario[$key]);
			$presupuesto1->total_presupuesto = convertir_entero($presupuesto_[$key]);
			$presupuesto1->id_solicitud = $derecho_revision->id;
			$presupuesto1->id_usuario_inserta = $id_user;
			$presupuesto1->save();
			
			$array_tipo_obra[] = $presupuesto1->id;
			
		}
		
		$presupuestoAll = Presupuesto::where("id_solicitud",$request->id_solicitud)->where("estado","1")->get();
		foreach($presupuestoAll as $key=>$row){
			
			if (!in_array($row->id, $array_tipo_obra)){
				$presupuesto = Presupuesto::find($row->id);
				$presupuesto->estado = 0;
				$presupuesto->save();
			}
			
		}

		$propietario = Propietario::where("id_solicitud",$derecho_revision->id)->where("estado","1")->first();
		
		if(isset($propietario->id_empresa) && $propietario->id_empresa>0){
			$empresa = Empresa::where("id",$propietario->id_empresa)->where("estado","1")->first();
			$empresa_cantidad = Empresa::where("ruc",$empresa->ruc)->where("estado","1")->count();
		}
		
		if(isset($propietario->id_persona) && $propietario->id_persona>0){
			$persona = Persona::where("id",$propietario->id_persona)->where("estado","1")->first();
			$empresa_cantidad = Persona::where("numero_documento",$persona->numero_documento)->where("estado","1")->count();
		}
		
		if($empresa_cantidad==1){
			if($request->instancia==250)$valor_obra = convertir_entero($request->valor_reintegro);

			$anio = Carbon::now()->year;
			$parametro = Parametro::where("anio",$anio)->where("estado",1)->orderBy("id","desc")->first();
			
			$uit = $parametro->valor_uit;

			if($solicitud_matriz->id_tipo_solicitud == 123){
					
				if($request->tipo_liquidacion1==136){

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
			}

			$id_user = Auth::user()->id;
				$liquidacion = Liquidacione::where("id_solicitud",$solicitud_matriz->id)->where("estado","1")->first();
				//$liquidacion->id_solicitud = $derecho_revision->id;
				//$liquidacion->fecha = Carbon::now()->format('Y-m-d');
				//$liquidacion->credipago = $codigo;
				$liquidacion->sub_total = number_format($sub_total, 2, '.', '');
				$liquidacion->igv = number_format($igv, 2, '.', '');
				$liquidacion->total = number_format($total, 2, '.', '');
				$liquidacion->observacion = "obs";
				$liquidacion->id_usuario_inserta = $id_user;
				$liquidacion->save();
		}
		
	}

	public function valida_credipago_unico($id_solicitud){

		$derecho_revision_model = new DerechoRevision;
		$credipago_unico = $derecho_revision_model->getCredipagoUnico($id_solicitud);

		$datos_formateados = [];

        foreach ($credipago_unico as $credipago) {
            $datos_formateados[] = [
                'cantidad' => $credipago->cantidad,
            ];
        }
        return response()->json($datos_formateados);
	}

	public function validar_proyectista_hu($id){

		$proyectista_model = new Proyectista;
		$proyectista_principal = $proyectista_model->getProyectistaPrincipal($id);

		$datos_formateados = [];

        foreach ($proyectista_principal as $proyectista) {
            $datos_formateados[] = [
                'id_tipo_proyectista' => $proyectista->id_tipo_proyectista,
            ];
        }
        return response()->json($datos_formateados);
	}

	public function obtener_numero_revision($id_solicitud){

		$derecho_revision_model = new DerechoRevision;
		$numero_revision_data = $derecho_revision_model->getNumeroRevisionBySolicitud($id_solicitud);
		//dd($numero_revision);exit();
        
		$id = $numero_revision_data[0]->id;
		$numero_revision = $numero_revision_data[0]->numero_revision;
		$codigo = $numero_revision_data[0]->codigo;
		$pago_liquidacion = null;
        
		if($numero_revision !=1){

			$pago_liquidacion = $derecho_revision_model->getLiquidacionByRevision($id, $numero_revision, $codigo);

		}
		
		/*foreach($pago_liquidacion as $pago){
			if($pago->pagado==1){
				$pagado=1;
			}else{
				$pagado=0;
			}
		}*/

		//dd($pago_liquidacion);exit();

        return response()->json(['pago_liquidacion'=>$pago_liquidacion,'numero_revision'=>$numero_revision]);
	}

	function create_solicitud(){

		$id_persona = Auth::user()->id_persona;
		//dd($id_persona);exit();

		$agremiado_model = new Agremiado;
		$persona_model = new Persona;
		//$derechoRevision_ = DerechoRevision::find($id);
		$proyectista_model = new Proyectista();
		//$proyecto_ = Proyecto::where("id",$derechoRevision_->id_proyecto)->where("estado","1")->first();
		//$proyecto2 = Proyecto::find($proyecto_->id);
		//$proyectista_ = $proyectista_model->getProyectistaIngeniero($id);
		//$proyectista = Proyectista::find($proyectista_[0]->id_profesional);
		//$profesionales_otro = ProfesionalesOtro::find($proyectista_[0]->id_profesional);

		//$datos_proyectista = $proyectista_model->getDatosProyectistaIngeniero($id);

		//$datos_usoEdificaciones = UsoEdificacione::where("id_solicitud",$derechoRevision_->id)->where("estado","1")->orderBy('id')->get();
		//$datos_presupuesto = Presupuesto::where("id_solicitud",$derechoRevision_->id)->where("estado","1")->orderBy('id')->get();
		$tipo_solicitante = 1;
		
		$proyectista_model = new Proyectista;
		$propietario_model = new Propietario;
		$derechoRevision_model = new DerechoRevision;
		$derechoRevision = new DerechoRevision;
		$agremiado = new Agremiado;
		$persona = new Persona;
		$proyecto = new Proyecto;
		$tablaMaestra_model = new TablaMaestra; 
		$ubigeo_model = new Ubigeo;
		$municipalidad_model = new Municipalidade;
		$presupuesto_model = new Presupuesto;
		$usoEdificacione_model = new UsoEdificacione;
		$parametro_model = new Parametro;
		$empresa = new Empresa;

		$departamento = $ubigeo_model->getDepartamento();
        $sitio = $tablaMaestra_model->getMaestroByTipo(33);
        $zona = $tablaMaestra_model->getMaestroByTipo(34);
		$tipo = $tablaMaestra_model->getMaestroByTipo(35);
		$tipo_proyectista = $tablaMaestra_model->getMaestroByTipo(41);
		$principal_asociado = $tablaMaestra_model->getMaestroByTipo(130);
		$tipo_proyecto = $tablaMaestra_model->getMaestroByTipo(25);
		$tipo_uso = $tablaMaestra_model->getMaestroByTipoByTipoNombre(111,'TIPO USO');
		
		$tipo_obra = $tablaMaestra_model->getMaestroByTipo(112);
		$tipo_liquidacion = $tablaMaestra_model->getMaestroByTipo(27);
		$instancia = $tablaMaestra_model->getMaestroByTipo(47);
		$tipo_documento = $tablaMaestra_model->getMaestroByTipo(16);
		$municipalidad = $municipalidad_model->getMunicipalidadOrden();
		//$proyectista_solicitud = $proyectista_model->getProyectistaSolicitud_($id);
		//$propietario_solicitud = $propietario_model->getPropietarioSolicitud($id);
		//$info_solicitud = $presupuesto_model->getInfoSolicitud($id);
		//$info_uso_solicitud = $usoEdificacione_model->getInfoSolicitudUso2($id);
		$anio_actual = Carbon::now()->year;
		$parametro = $parametro_model->getParametroAnio($anio_actual);
		//$liquidacion = $derechoRevision_model->getReintegroByIdSolicitud($id);
		$persona_princ = Persona::find($id_persona);
		$agremiado_princ = Agremiado::where('id_persona',$id_persona)->where('estado',1)->first();
		$agremiado_principal = $agremiado_model->getAgremiado('85',$agremiado_princ->numero_cap);
		$id="0";
		//dd($agremiado_principal);exit();
        return view('frontend.derecho_revision.create_solicitud',compact('id','derechoRevision',/*'proyectista',*/'agremiado','persona','proyecto','sitio','zona','tipo','departamento','municipalidad',/*'proyectista_solicitud','propietario_solicitud','derechoRevision_','proyecto2',*/'tipo_solicitante',/*'datos_agremiado','datos_persona',*//*'info_solicitud','info_uso_solicitud',*/'tipo_proyecto','tipo_uso',/*'datos_usoEdificaciones',*//*'sub_tipo_uso',*/'tipo_obra',/*'datos_presupuesto',*/'tipo_liquidacion','instancia','parametro',/*'liquidacion',*/'tipo','tipo_documento','empresa','tipo_proyectista',/*'profesionales_otro','datos_proyectista',*/'principal_asociado','agremiado_principal'));
    }

	public function send_nuevo_registro_solicitud_edificacion(Request $request){

		$id_user = Auth::user()->id;
		$id = $request->id;
		$agremiado_principal = Agremiado::where("numero_cap",$request->numero_cap)->where("estado","1")->first();
		$ubigeo = $request->distrito;
		$id_ubi = Ubigeo::where("id_ubigeo",$ubigeo)->where("estado","1")->first();
		$tipo_uso = $request->tipo_uso;
		$tipo_obra = $request->tipo_obra;
		$sub_tipo_uso = $request->sub_tipo_uso;
		$area_techada = $request->area_techada;
		$area_techada_presupuesto = $request->area_techada_presupuesto;
		$valor_unitario = $request->valor_unitario;
		$presupuesto_ = $request->presupuesto;
		$tipo_proyectista_row = $request->tipo_proyectista_row;
		$agremiado_row = $request->agremiado_row;
		$numero_cap_row = $request->numero_cap_row;
		$situacion_row = $request->situacion_row;
		$telefono_row = $request->telefono_row;
		$email_row = $request->email_row;
		$descripcion_archivo = $request->descripcion_archivo;
		$btnArchivoAdicional = $request->btnArchivoAdicional;
		
		//$ubigeo = Ubigeo::where("numero_cap",$request->numero_cap)->where("estado","1")->first();
		
		if($request->id == 0){
			$derecho_revision = new DerechoRevision;
			$proyecto = new Proyecto;
			$proyectista_principal = new Proyectista;
			$propietario = new Propietario;
		}else{
			$derecho_revision = DerechoRevision::find($request->id);
			$proyecto = Proyecto::find($derecho_revision->id_proyecto);
			$proyectista_principal = Proyectista::find($derecho_revision->id_proyectista);
			$propietario = Propietario::where('id_solicitud',$derecho_revision->id_proyectista)->first();
		}
		
		$derecho_revision->id_regional = 5;
		$derecho_revision->fecha_registro = Carbon::now()->format('Y-m-d');
		$derecho_revision->id_tipo_solicitud = 123;
		$derecho_revision->id_tipo_tramite = $request->tipo_proyecto;
		$derecho_revision->numero_revision = $request->n_revision;
		$derecho_revision->direccion = $request->direccion_proyecto;
		$derecho_revision->id_ubigeo = $ubigeo;
		$derecho_revision->numero_sotano = $request->n_sotanos;
		$derecho_revision->azotea = $request->azotea;
		$derecho_revision->semisotano = $request->semisotano;
		$derecho_revision->numero_piso = $request->n_pisos;
		//$derecho_revision->valor_unitario = $request->municipalidad;// calcularlo despues
		$derecho_revision->valor_obra = str_replace(',', '', $request->valor_total_obra);
		$derecho_revision->area_total = str_replace(',', '', $request->area_techada_total);
		//$derecho_revision->id_proyecto = $request->municipalidad;
		//$derecho_revision->id_usuario_revisa = $request->municipalidad;
		//$derecho_revision->fecha_revisado = $request->municipalidad;
		//$derecho_revision->id_usuario_aprueba = $request->municipalidad;
		//$derecho_revision->fecha_aprobado = $request->municipalidad;
		$derecho_revision->id_resultado = 1;
		//$derecho_revision->numero_expediente_municipal = $request->municipalidad;
		//$derecho_revision->id_comision_proyecto = $request->municipalidad;
		$derecho_revision->estado = 1;
		$derecho_revision->id_usuario_inserta = $id_user;
		$derecho_revision->id_municipalidad = $request->municipalidad;
		if($request->id_tipo_documento==78){
			$persona = Persona::where('numero_documento',$request->dni_propietario)->first();
			$derecho_revision->id_persona = $persona->id;
			$derecho_revision->correo = $request->email_dni;
			$derecho_revision->celular = $request->celular_dni;
		}else if($request->id_tipo_documento==79){
			$empresa = Empresa::where('ruc',$request->ruc_propietario)->first();
			$derecho_revision->id_empresa = $empresa->id;
			$derecho_revision->correo = $request->email_ruc;
			$derecho_revision->celular = $request->telefono_ruc;
		}
		
		//$derecho_revision->planta_tipica = $request->municipalidad; revisar caso de planta tipica
		//$derecho_revision->id_proyectista = $request->municipalidad;
		
		/////////consultar de donde salen estos datos
		/*$derecho_revision->sotanos_m2 = $request->municipalidad;
		$derecho_revision->semisotano_m2 = $request->municipalidad;
		$derecho_revision->piso_nivel_m2 = $request->municipalidad;
		$derecho_revision->otro_piso_nivel_m2 = $request->municipalidad;*/
		////////////
		//$derecho_revision->area_total = $request->area_techada_total;
		//$derecho_revision->codigo_solicitud = $request->municipalidad;
		$derecho_revision->id_instancia = 246;
		//$derecho_revision->id_tipo_liquidacion1 = $request->municipalidad;
		//$derecho_revision->etapa = $request->municipalidad;
		//$derecho_revision->numero_etapa = $request->municipalidad;
		//$derecho_revision->valor_reintegro = $request->municipalidad;
		//$derecho_revision->id_proyectista = $agremiado->id;
		$derecho_revision->save();
		$id_derecho_revision = $derecho_revision->id;
		
		$proyecto->id_ubigeo = $ubigeo;
		$proyecto->id_tipo_sitio = $request->sitio;
		$proyecto->id_tipo_direccion = $request->tipo;
		$proyecto->nombre = $request->nombre_proyecto;
		//$proyecto->lugar = $request->nombre_proyecto;
		//$proyecto->manzana = $request->nombre_proyecto;
		$proyecto->parcela = $request->parcela;
		$proyecto->super_manzana = $request->superManzana;
		$proyecto->direccion = $request->direccion_proyecto;
		$proyecto->sitio_descripcion = $request->direccion_sitio;
		$proyecto->zona_descripcion = $request->direccion_zona;
		$proyecto->lote = $request->lote;
		$proyecto->fila = $request->fila;
		//$proyecto->id_tipo_sitio = $request->sitio;
		$proyecto->id_zona = $request->zona;
		//$proyecto->id_tipo_direccion = $request->tipo;
		$proyecto->id_tipo_proyecto = 124;
		//$codigoHU = $derecho_revision->getCodigoSolicitudHU();
		//$proyecto->codigo = $codigoHU;///preguntar sobre codigo en edificaciones
		$proyecto->zonificacion = $request->zonificacion;
		$proyecto->sub_lote = $request->sublote;
		$proyecto->id_usuario_inserta = $id_user;
		$proyecto->save();
		$id_proyecto = $proyecto->id;
		
		//$agremiado = Agremiado::where("numero_cap",$request->numero_cap)->where("estado","1")->first();

		$proyectista_principal->id_agremiado = $agremiado_principal->id;
		$proyectista_principal->celular = $agremiado_principal->celular1;
		$proyectista_principal->email = $agremiado_principal->email1;
		$proyectista_principal->id_tipo_profesional = 211;
		$proyectista_principal->id_tipo_proyectista = 1;
		$proyectista_principal->id_usuario_inserta = $id_user;
		$proyectista_principal->save();
		$id_proyectista_principal = $proyectista_principal->id;

		$derecho_revision_find = DerechoRevision::find($id_derecho_revision);
		$derecho_revision_find->id_proyecto = $id_proyecto;
		$derecho_revision_find->id_proyectista = $id_proyectista_principal;
		$derecho_revision_find->save();

		$proyectista_principal_find = Proyectista::find($id_proyectista_principal);
		$proyectista_principal_find->id_solicitud = $id_derecho_revision;
		$proyectista_principal_find->save();

		if($request->id_tipo_documento==78){
			$persona = Persona::where('numero_documento',$request->dni_propietario)->first();
			$propietario->id_tipo_propietario = $request->id_tipo_documento;
			$propietario->id_persona = $persona->id;
			$propietario->representante = $request->nombre_propietario;
			$propietario->celular = $request->celular_dni;
			$propietario->email = $request->email_dni;
		}else if($request->id_tipo_documento==79){
			$empresa = Empresa::where('ruc',$request->ruc_propietario)->first();
			$propietario->id_tipo_propietario = $request->id_tipo_documento;
			$propietario->id_empresa = $empresa->id;
			$propietario->representante = $request->razon_social_propietario;
			$propietario->celular = $request->telefono_ruc;
			$propietario->email = $request->email_ruc;
		}
		
		$propietario->estado = 1;
		$propietario->id_usuario_inserta = $id_user;
		$propietario->id_solicitud = $id_derecho_revision;
		$propietario->save();

		if(isset($tipo_uso)){
		
			foreach($tipo_uso as $key=>$row){
				//echo "ok";
				$uso_edificacion = new UsoEdificacione;
				$uso_edificacion->id_tipo_uso = $tipo_uso[$key];
				$uso_edificacion->id_sub_tipo_uso = $sub_tipo_uso[$key];
				$uso_edificacion->area_techada = convertir_entero($area_techada[$key]);
				$uso_edificacion->id_solicitud = $id_derecho_revision;
				$uso_edificacion->id_usuario_inserta = $id_user;
				$uso_edificacion->save();
				
			}
		}

		if(isset($tipo_obra)){
		
			foreach($tipo_obra as $key=>$row){
				
				$presupuesto1 = new Presupuesto;
				$presupuesto1->id_tipo_obra = $tipo_obra[$key];
				$presupuesto1->area_techada = convertir_entero($area_techada_presupuesto[$key]);
				$presupuesto1->valor_unitario = convertir_entero($valor_unitario[$key]);
				$presupuesto1->total_presupuesto = convertir_entero($presupuesto_[$key]);
				$presupuesto1->id_solicitud = $id_derecho_revision;
				$presupuesto1->id_usuario_inserta = $id_user;
				$presupuesto1->save();
				
			}
		}

		if(isset($tipo_proyectista_row)){
		
			foreach($tipo_proyectista_row as $key=>$row){
				
				$agremiado_secundario = Agremiado::where("numero_cap",$numero_cap_row[$key])->where("estado","1")->first();
				
				$proyectista_secundario = New Proyectista;
				$proyectista_secundario->id_agremiado = $agremiado_secundario->id;
				$proyectista_secundario->celular = $telefono_row[$key];
				$proyectista_secundario->email = $email_row[$key];
				$proyectista_secundario->id_tipo_profesional = 212;
				$proyectista_secundario->id_tipo_proyectista = 2;
				$proyectista_secundario->id_usuario_inserta = $id_user;
				$proyectista_secundario->id_solicitud = $id_derecho_revision;
				$proyectista_secundario->save();

			}

			$proyectista_principal_ = Proyectista::find($id_proyectista_principal);
			$proyectista_principal_->id_tipo_proyectista = 2;
			$proyectista_principal_->id_usuario_inserta = $id_user;
			$proyectista_principal_->save();
		}

		$solicitud_documento_plano = new SolicitudDocumento;

		$path = "img/solicitud_derecho_revision_edificaciones/plano_ubicacion";
        if (!is_dir($path)) {
            mkdir($path);
        }

        if (isset($_FILES["btnPlanoUbicacion"]) && $_FILES["btnPlanoUbicacion"]["error"] == UPLOAD_ERR_OK) {

            $path = "img/solicitud_derecho_revision_edificaciones/plano_ubicacion/".$id_derecho_revision;
            if (!is_dir($path)) {
                mkdir($path);
            }

            $filepath = public_path($path.'/');

            $filename = "plano_ubicacion_".date("YmdHis") . substr((string)microtime(), 1, 6);
            $type=$this->extension($_FILES["btnPlanoUbicacion"]["name"]);
            $filenamefirma=$filename.".".$type;

            move_uploaded_file($_FILES["btnPlanoUbicacion"]["tmp_name"], $filepath.$filenamefirma);

            $solicitud_documento_plano->id_tipo_documento = 4;
            $solicitud_documento_plano->descripcion = "Plano Ubicacion";
            $solicitud_documento_plano->ruta_archivo = $path."/".$filenamefirma;
            $solicitud_documento_plano->estado = 1;
            $solicitud_documento_plano->id_usuario_inserta = $id_user;
            $solicitud_documento_plano->id_solicitud = $id_derecho_revision;
        	$solicitud_documento_plano->save();
        }

		$solicitud_documento_fue = new SolicitudDocumento;

		$path = "img/solicitud_derecho_revision_edificaciones/fue";
        if (!is_dir($path)) {
            mkdir($path);
        }

        if (isset($_FILES["btnFue"]) && $_FILES["btnFue"]["error"] == UPLOAD_ERR_OK) {

            $path = "img/solicitud_derecho_revision_edificaciones/fue/".$id_derecho_revision;
            if (!is_dir($path)) {
                mkdir($path);
            }

            $filepath = public_path($path.'/');

            $filename = "fue_".date("YmdHis") . substr((string)microtime(), 1, 6);
            $type=$this->extension($_FILES["btnFue"]["name"]);
            $filenamefirma=$filename.".".$type;

            move_uploaded_file($_FILES["btnFue"]["tmp_name"], $filepath.$filenamefirma);

            $solicitud_documento_fue->id_tipo_documento = 5;
            $solicitud_documento_fue->descripcion = "FUE";
            $solicitud_documento_fue->ruta_archivo = $path."/".$filenamefirma;
            $solicitud_documento_fue->estado = 1;
            $solicitud_documento_fue->id_usuario_inserta = $id_user;
            $solicitud_documento_fue->id_solicitud = $id_derecho_revision;
        	$solicitud_documento_fue->save();
        }

		$solicitud_documento_presupuesto = new SolicitudDocumento;

		$path = "img/solicitud_derecho_revision_edificaciones/presupuesto";
        if (!is_dir($path)) {
            mkdir($path);
        }

        if (isset($_FILES["btnPresupuesto"]) && $_FILES["btnPresupuesto"]["error"] == UPLOAD_ERR_OK) {

            $path = "img/solicitud_derecho_revision_edificaciones/presupuesto/".$id_derecho_revision;
            if (!is_dir($path)) {
                mkdir($path);
            }

            $filepath = public_path($path.'/');

            $filename = "presupuesto_".date("YmdHis") . substr((string)microtime(), 1, 6);
            $type=$this->extension($_FILES["btnPresupuesto"]["name"]);
            $filenamefirma=$filename.".".$type;

            move_uploaded_file($_FILES["btnPresupuesto"]["tmp_name"], $filepath.$filenamefirma);

            $solicitud_documento_presupuesto->id_tipo_documento = 6;
            $solicitud_documento_presupuesto->descripcion = "Presupuesto";
            $solicitud_documento_presupuesto->ruta_archivo = $path."/".$filenamefirma;
            $solicitud_documento_presupuesto->estado = 1;
            $solicitud_documento_presupuesto->id_usuario_inserta = $id_user;
            $solicitud_documento_presupuesto->id_solicitud = $id_derecho_revision;
        	$solicitud_documento_presupuesto->save();
        }

		if(isset($descripcion_archivo)){
		
			foreach($descripcion_archivo as $key=>$row){
				
				$solicitud_documento_adicional = new SolicitudDocumento;

				$path = "img/solicitud_derecho_revision_edificaciones/archivos_adicionales";
				if (!is_dir($path)) {
					mkdir($path);
				}

				if (isset($_FILES["btnArchivoAdicional"]) && $_FILES["btnArchivoAdicional"]["error"][$key] == UPLOAD_ERR_OK) {

					$path = "img/solicitud_derecho_revision_edificaciones/archivos_adicionales/".$id_derecho_revision;
					if (!is_dir($path)) {
						mkdir($path);
					}

					$filepath = public_path($path.'/');

					$filename = "archivos_adicionales_".date("YmdHis") . substr((string)microtime(), 1, 6);
					$type=$this->extension($_FILES["btnArchivoAdicional"]["name"][$key]);
					$filenamefirma=$filename.".".$type;

					move_uploaded_file($_FILES["btnArchivoAdicional"]["tmp_name"][$key], $filepath.$filenamefirma);

					$solicitud_documento_adicional->id_tipo_documento = 7;
					$solicitud_documento_adicional->descripcion = $descripcion_archivo[$key];
					$solicitud_documento_adicional->ruta_archivo = $path."/".$filenamefirma;
					$solicitud_documento_adicional->estado = 1;
					$solicitud_documento_adicional->id_usuario_inserta = $id_user;
					$solicitud_documento_adicional->id_solicitud = $id_derecho_revision;
					$solicitud_documento_adicional->save();
				}
			}
		}

		//dd($request->respuesta);exit();

		if($request->respuesta==0){
			$derecho_revision = DerechoRevision::find($id_derecho_revision);
			$derecho_revision->planta_tipica = $request->respuesta;
			$derecho_revision->save();
		}else{
			$derecho_revision = DerechoRevision::find($id_derecho_revision);
			$derecho_revision->planta_tipica = $request->respuesta;
			$derecho_revision->save();

			if ($request->hasFile('btnPlanoDistribucion1') && $request->file('btnPlanoDistribucion1')->isValid()) {
				
				$solicitud_documento_adicional = new SolicitudDocumento;

				$path = "img/solicitud_derecho_revision_edificaciones/planta_tipica/planos_distribucion/";
				if (!is_dir($path)) {
					mkdir($path);
				}

				if (isset($_FILES["btnPlanoDistribucion1"]) && $_FILES["btnPlanoDistribucion1"]["error"] == UPLOAD_ERR_OK) {

					$path = "img/solicitud_derecho_revision_edificaciones/planta_tipica/planos_distribucion/".$id_derecho_revision;
					if (!is_dir($path)) {
						mkdir($path);
					}

					$filepath = public_path($path.'/');

					$filename = "planos_distribucion_".date("YmdHis") . substr((string)microtime(), 1, 6);
					$type=$this->extension($_FILES["btnPlanoDistribucion1"]["name"]);
					$filenamefirma=$filename.".".$type;

					move_uploaded_file($_FILES["btnPlanoDistribucion1"]["tmp_name"], $filepath.$filenamefirma);

					$solicitud_documento_adicional->id_tipo_documento = 8;
					$solicitud_documento_adicional->descripcion = "Planos de Distribucion de Plantas Tipicas";
					$solicitud_documento_adicional->ruta_archivo = $path."/".$filenamefirma;
					$solicitud_documento_adicional->estado = 1;
					$solicitud_documento_adicional->id_usuario_inserta = $id_user;
					$solicitud_documento_adicional->id_solicitud = $id_derecho_revision;
					$solicitud_documento_adicional->save();
				}
			}
			
			if ($request->hasFile('btnPlanoDistribucion2') && $request->file('btnPlanoDistribucion2')->isValid()) {
				
				$solicitud_documento_adicional = new SolicitudDocumento;

				$path = "img/solicitud_derecho_revision_edificaciones/planta_tipica/planos_distribucion/";
				if (!is_dir($path)) {
					mkdir($path);
				}

				if (isset($_FILES["btnPlanoDistribucion2"]) && $_FILES["btnPlanoDistribucion2"]["error"] == UPLOAD_ERR_OK) {

					$path = "img/solicitud_derecho_revision_edificaciones/planta_tipica/planos_distribucion/".$id_derecho_revision;
					if (!is_dir($path)) {
						mkdir($path);
					}

					$filepath = public_path($path.'/');

					$filename = "planos_distribucion_".date("YmdHis") . substr((string)microtime(), 1, 6);
					$type=$this->extension($_FILES["btnPlanoDistribucion2"]["name"]);
					$filenamefirma=$filename.".".$type;

					move_uploaded_file($_FILES["btnPlanoDistribucion2"]["tmp_name"], $filepath.$filenamefirma);

					$solicitud_documento_adicional->id_tipo_documento = 8;
					$solicitud_documento_adicional->descripcion = "Planos de Distribucion de Plantas Tipicas";
					$solicitud_documento_adicional->ruta_archivo = $path."/".$filenamefirma;
					$solicitud_documento_adicional->estado = 1;
					$solicitud_documento_adicional->id_usuario_inserta = $id_user;
					$solicitud_documento_adicional->id_solicitud = $id_derecho_revision;
					$solicitud_documento_adicional->save();
				}
			}

			if ($request->hasFile('btnPlanoDistribucion3') && $request->file('btnPlanoDistribucion3')->isValid()) {
				
				$solicitud_documento_adicional = new SolicitudDocumento;

				$path = "img/solicitud_derecho_revision_edificaciones/planta_tipica/planos_distribucion/";
				if (!is_dir($path)) {
					mkdir($path);
				}

				if (isset($_FILES["btnPlanoDistribucion3"]) && $_FILES["btnPlanoDistribucion3"]["error"] == UPLOAD_ERR_OK) {

					$path = "img/solicitud_derecho_revision_edificaciones/planta_tipica/planos_distribucion/".$id_derecho_revision;
					if (!is_dir($path)) {
						mkdir($path);
					}

					$filepath = public_path($path.'/');

					$filename = "planos_distribucion_".date("YmdHis") . substr((string)microtime(), 1, 6);
					$type=$this->extension($_FILES["btnPlanoDistribucion3"]["name"]);
					$filenamefirma=$filename.".".$type;

					move_uploaded_file($_FILES["btnPlanoDistribucion3"]["tmp_name"], $filepath.$filenamefirma);

					$solicitud_documento_adicional->id_tipo_documento = 8;
					$solicitud_documento_adicional->descripcion = "Planos de Distribucion de Plantas Tipicas";
					$solicitud_documento_adicional->ruta_archivo = $path."/".$filenamefirma;
					$solicitud_documento_adicional->estado = 1;
					$solicitud_documento_adicional->id_usuario_inserta = $id_user;
					$solicitud_documento_adicional->id_solicitud = $id_derecho_revision;
					$solicitud_documento_adicional->save();
				}
			}

			if ($request->hasFile('btnPlanoDistribucion4') && $request->file('btnPlanoDistribucion4')->isValid()) {
				
				$solicitud_documento_adicional = new SolicitudDocumento;

				$path = "img/solicitud_derecho_revision_edificaciones/planta_tipica/planos_distribucion/";
				if (!is_dir($path)) {
					mkdir($path);
				}

				if (isset($_FILES["btnPlanoDistribucion4"]) && $_FILES["btnPlanoDistribucion4"]["error"] == UPLOAD_ERR_OK) {

					$path = "img/solicitud_derecho_revision_edificaciones/planta_tipica/planos_distribucion/".$id_derecho_revision;
					if (!is_dir($path)) {
						mkdir($path);
					}

					$filepath = public_path($path.'/');

					$filename = "planos_distribucion_".date("YmdHis") . substr((string)microtime(), 1, 6);
					$type=$this->extension($_FILES["btnPlanoDistribucion4"]["name"]);
					$filenamefirma=$filename.".".$type;

					move_uploaded_file($_FILES["btnPlanoDistribucion4"]["tmp_name"], $filepath.$filenamefirma);

					$solicitud_documento_adicional->id_tipo_documento = 8;
					$solicitud_documento_adicional->descripcion = "Planos de Distribucion de Plantas Tipicas";
					$solicitud_documento_adicional->ruta_archivo = $path."/".$filenamefirma;
					$solicitud_documento_adicional->estado = 1;
					$solicitud_documento_adicional->id_usuario_inserta = $id_user;
					$solicitud_documento_adicional->id_solicitud = $id_derecho_revision;
					$solicitud_documento_adicional->save();
				}
			}

			$solicitud_documento_adicional = new SolicitudDocumento;

			$path = "img/solicitud_derecho_revision_edificaciones/planta_tipica/declaracion_jurada/";
			if (!is_dir($path)) {
				mkdir($path);
			}

			if (isset($_FILES["btnDeclaracion"]) && $_FILES["btnDeclaracion"]["error"] == UPLOAD_ERR_OK) {

				$path = "img/solicitud_derecho_revision_edificaciones/planta_tipica/declaracion_jurada/".$id_derecho_revision;
				if (!is_dir($path)) {
					mkdir($path);
				}

				$filepath = public_path($path.'/');

				$filename = "declaracion_jurada_".date("YmdHis") . substr((string)microtime(), 1, 6);
				$type=$this->extension($_FILES["btnDeclaracion"]["name"]);
				$filenamefirma=$filename.".".$type;

				move_uploaded_file($_FILES["btnDeclaracion"]["tmp_name"], $filepath.$filenamefirma);

				$solicitud_documento_adicional->id_tipo_documento = 9;
				$solicitud_documento_adicional->descripcion = "Declaracion Jurada Firmada";
				$solicitud_documento_adicional->ruta_archivo = $path."/".$filenamefirma;
				$solicitud_documento_adicional->estado = 1;
				$solicitud_documento_adicional->id_usuario_inserta = $id_user;
				$solicitud_documento_adicional->id_solicitud = $id_derecho_revision;
				$solicitud_documento_adicional->save();
			}

		}

		return $derecho_revision->id;
    }
}
