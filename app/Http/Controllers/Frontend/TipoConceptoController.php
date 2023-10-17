<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TipoConcepto;
use App\Models\Regione;
use Auth;

class TipoConceptoController extends Controller
{
    function consulta_tipoConcepto(){
        
        return view('frontend.tipoConcepto.all');

    }

    public function listar_tipoConcepto_ajax(Request $request){
	
		$tipoConcepto_model = new TipoConcepto;
		$p[]=$request->codigo;
		$p[]=$request->id_regional;
		$p[]=$request->denominacion;
        $p[]="";
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $tipoConcepto_model->listar_tipoConcepto_ajax($p);
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

	public function editar_tipoConcepto($id){
        
		$tipoConcepto = TipoConcepto::find($id);
		$id_tipoConcepto = $tipoConcepto->id_tipoConcepto;
		$tipoConcepto = TipoConcepto::find($id_tipoConcepto);
		
        $tipoConcepto_model = new TipoConcepto;
 
		//$tablaMaestra_model = new TablaMaestra;
		//$regione_model = new Regione;
		//$region = $regione_model->getRegionAll();
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
		
		return view('frontend.tipoConcepto.create',compact('codigo','regional','denominacion','estado'));
		
    }

	public function modal_tipoConcepto_nuevoTipoConcepto($id){
		
		$tipoConcepto = new TipoConcepto;
		$regione_model = new Regione;

		if($id>0){
			$tipoConcepto = TipoConcepto::find($id);
		}else{
			$tipoConcepto = new TipoConcepto;
		}
		
		$region = $regione_model->getRegionAll();
		
		return view('frontend.tipoConcepto.modal_tipoConcepto_nuevoTipoConcepto',compact('id','tipoConcepto','region'));
	
	}

	public function send_tipoConcepto_nuevoTipoConcepto(Request $request){
		
		$id_user = Auth::user()->id;

		if($request->id == 0){
			$tipoConcepto = new TipoConcepto;
		}else{
			$tipoConcepto = TipoConcepto::find($request->id);
		}
		
		$tipoConcepto->codigo = $request->codigo;
		$tipoConcepto->id_regional = $request->id_regional;
		$tipoConcepto->denominacion = $request->denominacion;
		$tipoConcepto->estado = 1;
		$tipoConcepto->id_usuario_inserta = $id_user;
		$tipoConcepto->save();
    }

	public function eliminar_tipoConcepto($id,$estado)
    {
		$tipoConcepto = TipoConcepto::find($id);
		$tipoConcepto->estado = $estado;
		$tipoConcepto->save();

		echo $tipoConcepto->id;

    }

}
