<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Concepto;
use App\Models\Regione;
use App\Models\TablaMaestra;
use Auth;

class ConceptoController extends Controller
{
    function consulta_concepto(){

		$tablaMaestra_model = new TablaMaestra;
		$concepto = new Concepto;
        $tipo_afectacion = $tablaMaestra_model->getMaestroByTipo(53);
        return view('frontend.concepto.all',compact('tipo_afectacion','concepto'));

    }
	
	public function __construct(){

		$this->middleware(function ($request, $next) {
			if(!Auth::check()) {
                return redirect('login');
            }
			return $next($request);
    	});
	}

    public function listar_concepto_ajax(Request $request){
	
		$concepto_model = new Concepto;
		$p[]="";//$request->nombre;
		$p[]="";
		$p[]=$request->denominacion;
        $p[]=$request->partida_presupuestal;
		$p[]="";
		$p[]="";
		$p[]=$request->tipo_afectacion;
		$p[]="";
		$p[]="";
        $p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $concepto_model->listar_concepto_ajax($p);
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

	public function editar_concepto($id){
        
		$concepto = Concepto::find($id);
		$tablaMaestra_model = new TablaMaestra;
		$id_concepto = $concepto->id_concepto;
		$concepto = Concepto::find($id_concepto);
		$tipo_afectacion = $tablaMaestra_model->getMaestroByTipo(53);
        $concepto_model = new concepto;
 
		//$tablaMaestra_model = new TablaMaestra;
		//$regione_model = new Regione;
		//$ubigeo_model = new Ubigeo;
		//$agremiadoEstudio_model = new AgremiadoEstudio;
		//$agremiadoIdioma_model = new AgremiadoIdioma;
		//$agremiadoParenteco_model = new AgremiadoParenteco;
		//$agremiadoTrabajo_model = new AgremiadoTrabajo;
		//$agremiadoTraslado_model = new AgremiadoTraslado;
		//$agremiadoSituacione_model = new AgremiadoSituacione;
		
		/*$ruc = $tablaMaestra_model->getMaestroByTipo(16);
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
		$agremiado_situacion = $agremiadoSituacione_model->getAgremiadoSituacion($id);*/
		
		return view('frontend.concepto.create',compact('id','regional','codigo','denominacion','partida_presupuestal','tipo_afectacion','estado'));
		
    }

    public function modal_concepto_nuevoConcepto($id){
		
		$concepto = new Concepto;
		$regione_model = new Regione;
		$tablaMaestra_model = new TablaMaestra;
		$tipo_afectacion = $tablaMaestra_model->getMaestroByTipo(53);
		$moneda = $tablaMaestra_model->getMaestroByTipo(1);

		if($id>0){
			$concepto = Concepto::find($id);
		}else{
			$concepto = new Concepto;
		}
		
		$region = $regione_model->getRegionAll();
		
		return view('frontend.concepto.modal_concepto_nuevoConcepto',compact('id','concepto','region','tipo_afectacion','moneda'));
	
	}

    public function send_concepto_nuevoConcepto(Request $request){
		
		$id_user = Auth::user()->id;
		$Concepto_model = new Concepto;

		if($request->id == 0){
			$concepto = new Concepto;
			$codigo = $Concepto_model->getCodigoConcepto();
		}else{
			$concepto = Concepto::find($request->id);
			$codigo = $request->codigo;
		}
		
		$concepto->id_regional = $request->id_regional;
		$concepto->codigo = $codigo;
		$concepto->denominacion = $request->denominacion;
		$concepto->id_partida_presupuestal = $request->id_partida_presupuestal;
		$concepto->id_tipo_concepto = $request->id;
		$concepto->importe = $request->importe;
		$concepto->id_tipo_afectacion = $request->tipo_afectacion;
		$concepto->moneda = $request->moneda;
		$concepto->centro_costo = $request->centro_costo;
		$concepto->estado = 1;
		$concepto->id_usuario_inserta = $id_user;
		$concepto->save();
    }

	public function eliminar_concepto($id,$estado)
    {
		$concepto = Concepto::find($id);
		$concepto->estado = $estado;
		$concepto->save();

		echo $concepto->id;

    }
}
