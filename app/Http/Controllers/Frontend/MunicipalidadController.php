<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Municipalidade;
use App\Models\Ubigeo;

use Auth;

class MunicipalidadController extends Controller
{
    function consulta_municipalidad(){

        return view('frontend.municipalidad.all');
    }


    //
    public function listar_municipalidad(Request $request){
	
		$municipalidad_model = new Municipalidade();
		$p[]=$request->denominacion;
		$p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $municipalidad_model->listar_municipalidad($p);
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

    public function editar_municipalidad($id){
        
		$empresa = Municipalidade::find($id);
		$id_empresa = $empresa->id;
		$empresa = Municipalidade::find($id_empresa);
		
		
		return view('frontend.empresa.create',compact('ruc','nombre_comercial','razon_social','direccion','representante','estado'));
		
    }

    public function modal_municipalidad($id){
		$id_user = Auth::user()->id;
		$municipalidad = new Municipalidade;
		if($id>0) $municipalidad = Municipalidade::find($id);else $municipalidad = new Municipalidade;

		//$tipo_documento = DocumentoIdentidade::all();
		//$tablaMaestra_model = new TablaMaestra;		
		//$tipo_documento = $tablaMaestra_model->getMaestroByTipo("TIP_DOC");
		
		//if($id>0) $persona_detalle = PersonaDetalle::where('id_persona', '=', $id)->where('estado', '=', 'A')->first();else $persona_detalle = new PersonaDetalle;
		//$persona_detalle = PersonaDetalle::where('id_persona', '=', $id)->where('estado', '=', 'A')->first();

		

		$ubigeo_model = new Ubigeo;
		$departamento = $ubigeo_model->getDepartamento("PER");

		$provincia = "";
		$distrito = "";

		//print_r ($departamento);
		//exit();

		if($municipalidad->id_ubigeo!=""){
			$idDepartamento = substr($municipalidad->ubigeo, 0, 2);
			$idProvincia = substr($municipalidad->ubigeo, 0, 4);

			$provincia = $ubigeo_model->getProvincia($idDepartamento);
			$distrito = $ubigeo_model->getDistrito($idDepartamento,$idProvincia);
		}

		

		//print_r ($unidad_trabajo);exit();

		return view('frontend.municipalidad.modal_municipalidad',compact('id','municipalidad','departamento','provincia','distrito'));
	}
}
