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
        
        $tipo_proyecto = $tablaMaestra_model->getMaestroByTipo(113);
		$estado_proyecto = $tablaMaestra_model->getMaestroByTipo(118);
		
        return view('frontend.derecho_revision.all',compact('derecho_revision','agremiado','persona','liquidacion','municipalidad','departamento','tipo_proyecto','estado_proyecto'));
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
        $departamento = $ubigeo_model->getDepartamento();
        $municipalidad = $municipalidad_modal->getMunicipalidadOrden();
        
        
        return view('frontend.derecho_revision.all_solicitud',compact('derecho_revision','agremiado','persona','liquidacion','municipalidad','departamento'));
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
	
}
