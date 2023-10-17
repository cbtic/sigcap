<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Concepto;
use App\Models\Regione;
use Auth;

class ConceptoController extends Controller
{
    function consulta_concepto(){
        
        return view('frontend.concepto.all');

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
		$id_concepto = $concepto->id_concepto;
		$concepto = Concepto::find($id_concepto);
		
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
		
		return view('frontend.concepto.create',compact('regional','codigo','denominacion','partida_presupuestal','estado'));
		
    }

    public function modal_concepto_nuevoConcepto($id){
		
		$concepto = new Concepto;
		$regione_model = new Regione;

		if($id>0){
			$concepto = Concepto::find($id);
		}else{
			$concepto = new Concepto;
		}
		
		$region = $regione_model->getRegionAll();
		
		return view('frontend.concepto.modal_concepto_nuevoConcepto',compact('id','concepto','region'));
	
	}

    public function send_concepto_nuevoConcepto(Request $request){
		
		$id_user = Auth::user()->id;

		if($request->id == 0){
			$concepto = new Concepto;
		}else{
			$concepto = Concepto::find($request->id);
		}
		
		$concepto->id_regional = $request->id_regional;
		$concepto->codigo = $request->codigo;
		$concepto->denominacion = $request->denominacion;
		$concepto->id_partida_presupuestal = $request->id_partida_presupuestal;
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
