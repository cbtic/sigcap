<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Empresa;
use Auth;

class EmpresaController extends Controller
{
    function consulta_empresa(){

        return view('frontend.empresa.all');
    }
	
	public function __construct(){

		$this->middleware(function ($request, $next) {
			if(!Auth::check()) {
                return redirect('login');
            }
			return $next($request);
    	});
	}

    public function listar_empresa_ajax(Request $request){
	
		$empresa_model = new Empresa;
		$p[]=$request->ruc;
		$p[]="";
		$p[]=$request->razon_social;
		$p[]="";
        $p[]="";
		$p[]="";
		$p[]="";
		$p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $empresa_model->listar_empresa_ajax($p);
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

    public function editar_empresa($id){
        
		$empresas = Empresas::find($id);
		$id_empresa = $empresas->id_empresa;
		$empresas = Empresas::find($id_empresa);
		
        $empresas_model = new empresas;
 
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
		
		return view('frontend.empresa.create',compact('ruc','nombre_comercial','razon_social','direccion','email','telefono','representante','estado'));
		
    }

    public function modal_empresa_nuevoEmpresa($id){
		
		
		$empresa = new Empresa;
		
		if($id>0){
			$empresa = Empresa::find($id);
		}else{
			$empresa = new Empresa;
		}
		
		//$universidad = $tablaMaestra_model->getMaestroByTipo(85);
		//$especialidad = $tablaMaestra_model->getMaestroByTipo(86);
		
		return view('frontend.empresa.modal_empresa_nuevoEmpresa',compact('id','empresa'));
	
	}

    public function send_empresa_nuevoEmpresa(Request $request){

		$id_user = Auth::user()->id;
		$sw = true;
		
		if($request->id == 0){
			//$empresa = new Empresa;
			$buscaempresa = Empresa::where("ruc", $request->ruc)->where("estado", "1")->get();

			if ($buscaempresa->count()==0){
				$empresa = new Empresa;
				$empresa->ruc = $request->ruc;
				$empresa->nombre_comercial = $request->nombre_comercial;
				$empresa->razon_social = $request->razon_social;
				$empresa->direccion = $request->direccion;
				$empresa->email = $request->email;
				$empresa->telefono = $request->telefono;
				$empresa->representante = $request->representante;
				$empresa->id_usuario_inserta = $id_user;
				$empresa->save();
			}else{
				$sw = false;
			}
		}else {
			$empresa = Empresa::find($request->id);
			$empresa->ruc = $request->ruc;
			$empresa->nombre_comercial = $request->nombre_comercial;
			$empresa->razon_social = $request->razon_social;
			$empresa->direccion = $request->direccion;
			$empresa->email = $request->email;
			$empresa->telefono = $request->telefono;
			$empresa->representante = $request->representante;
			$empresa->id_usuario_actualiza = $id_user;
			$empresa->save();
		}	
		$array["sw"] = $sw;
		//$array["msg"] = $msg;
		echo json_encode($array);
			
    }

	public function eliminar_empresa($id,$estado)
    {

		$id_user = Auth::user()->id;

		$empresa = Empresa::find($id);
		$empresa->estado = $estado;
		$empresa->id_usuario_actualiza = $id_user;
		$empresa->save();

		echo $empresa->id;
    }

	public function obtener_datos_empresa($ruc_propietario){

		$empresa_model = new Empresa;
		$sw = true;

		$empresa2 = Empresa::where('ruc',$ruc_propietario)->where('estado','1')->first();

		if($empresa2)
		{
			$empresa = $empresa_model->getEmpresaPropietario($ruc_propietario);
			$array["sw"] = $sw;
			$array["empresa"] = $empresa;
			echo json_encode($array);
		}else {
			$array["empresa"] = "0";
			echo json_encode($array);}
	}
}
