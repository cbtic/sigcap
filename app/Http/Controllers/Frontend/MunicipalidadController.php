<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Municipalidade;

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
		$modal_municipalidad = new Persona;
		if($id>0) $persona = Persona::find($id);else $persona = new Persona;

		//$tipo_documento = DocumentoIdentidade::all();
		$tablaMaestra_model = new TablaMaestra;		
		$tipo_documento = $tablaMaestra_model->getMaestroByTipo("TIP_DOC");
		
		if($id>0) $persona_detalle = PersonaDetalle::where('id_persona', '=', $id)->where('estado', '=', 'A')->first();else $persona_detalle = new PersonaDetalle;
		//$persona_detalle = PersonaDetalle::where('id_persona', '=', $id)->where('estado', '=', 'A')->first();

		$tabla_model = new TablaUbicacione;		
		$profesiones = $tabla_model->getTablaUbicacionAll("tprofesiones","1");
		$condLaboral = $tabla_model->getTablaUbicacionAll("condicion_laborales","1");
		$tipPlanilla = $tabla_model->getTablaUbicacionAll("tplanillas","1");
		$banco = $tabla_model->getTablaUbicacionAll("tbancos","1");
		$regPension = $tabla_model->getTablaUbicacionAll("regimen_pensionarios","1");
		$afp = $tabla_model->getTablaUbicacionAll("tafps","1");
		$comisionAfp = $tabla_model->getTablaUbicacionAll("tipo_comisiones","1");
		$cargo = $tabla_model->getTablaUbicacionAll("tcargos","1");
		$nivel = $tabla_model->getTablaUbicacionAll("tniveles","1");
		$moneda = $tabla_model->getTablaUbicacionAll("tipo_monedas","1");
		$area_trabajo = $tabla_model->getTablaUbicacionAll("area_trabajos","1");

		$empresa_model = new Empresa();		
		$empresas = $empresa_model->getEmpresaAll("1");

		$ubigeo_model = new Ubigeo;
		$departamento = $ubigeo_model->getDepartamento("PER");

		$provincia = "";
		$distrito = "";

		//print_r ($departamento);
		//exit();

		if($persona_detalle->ubigeo!=""){
			$idDepartamento = substr($persona_detalle->ubigeo, 0, 2);
			$idProvincia = substr($persona_detalle->ubigeo, 0, 4);

			$provincia = $ubigeo_model->getProvincia($idDepartamento);
			$distrito = $ubigeo_model->getDistrito($idProvincia);
		}

		$unidad_trabajo = "";

		$unidad_model = new UnidadTrabajo;

		if($persona_detalle->id_area_trabajo!=""){

			$unidad_trabajo = $unidad_model->getUnidad($persona_detalle->id_area_trabajo);
			//UnidadTrabajo::where('id_area_trabajo', '=', $persona_detalle->id_area_trabajo)->where('estado', '=', '1')->first();
		}

		//print_r ($unidad_trabajo);exit();

		return view('frontend.persona.modal_persona',compact('id','persona','persona_detalle','tipo_documento','profesiones','empresas','condLaboral','tipPlanilla','banco','regPension','afp','comisionAfp','cargo','nivel','moneda','departamento','provincia','distrito','area_trabajo','unidad_trabajo'));
	}
}
