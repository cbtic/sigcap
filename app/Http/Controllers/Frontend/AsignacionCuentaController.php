<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AsignacionCuenta;
use App\Models\TablaMaestra;

use App\Models\PlanContable;
use App\Models\CentroCosto;
use App\Models\PartidaPresupuestale;
use App\Models\CodigoFinanciero;


//use App\Models\CondicionLaborale;

use Auth;

class AsignacionCuentaController extends Controller
{
    public function __construct(){

		$this->middleware(function ($request, $next) {
			if(!Auth::check()) {
                return redirect('login');
            }
			return $next($request);
    	});
	}
	
    public function index(){

		$tablaMaestra_model = new TablaMaestra;
		$plan_contable = PlanContable::where('estado','1')->orderBy('cuenta', 'asc')->get()->all();        
		$tipo_cuenta = $tablaMaestra_model->getMaestroByTipo(122);
		$centro_costo = CentroCosto::where('estado','1')->orderBy('codigo', 'asc')->get()->all();
		$partida_presupuestal = PartidaPresupuestale::where('estado','1')->orderBy('id', 'desc')->get()->all();
		$medio_pago = $tablaMaestra_model->getMaestroByTipo(108);
		$origen = $tablaMaestra_model->getMaestroByTipo(128);
		$codigo_financiero = CodigoFinanciero::where('estado','1')->orderBy('id', 'asc')->get()->all();
		$tipo_planilla = $tablaMaestra_model->getMaestroByTipo(129);

        return view('frontend.asignacion.all',compact('plan_contable','tipo_cuenta','centro_costo','partida_presupuestal','medio_pago','origen','codigo_financiero','tipo_planilla'));
    }

	public function create()
    {
        return view('frontend.persona.create');
    }

    public function listar_asignacion_ajax(Request $request){
		
		$asignacion_model = new AsignacionCuenta;
		
		$p[]=$request->tipo_planilla;
		$p[]=$request->cuenta;
		$p[]=$request->denominacion;
		$p[]=$request->tipo_cuenta;
		$p[]=$request->centro_costo;
		$p[]=$request->partida_presupuestal;
		$p[]=$request->codigo_financiero;
		$p[]=$request->medio_pago;
		$p[]=$request->origen;

		$p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $asignacion_model->listar_asignacion_ajax($p);

		$iTotalDisplayRecords = isset($data[0]->totalrows)?$data[0]->totalrows:0;
		
		$result["PageStart"] = $request->NumeroPagina;
		$result["pageSize"] = $request->NumeroRegistros;
		$result["SearchText"] = "";
		$result["ShowChildren"] = true;
		$result["iTotalRecords"] = $iTotalDisplayRecords;
		$result["iTotalDisplayRecords"] = $iTotalDisplayRecords;
		$result["aaData"] = $data;

		echo json_encode($result);
		//print_r ($result);
	}

    function consulta_asignacion(){

		//$tablaMaestra_model = new TablaMaestra;
		//$persona = new Persona;
        //$sexo = $tablaMaestra_model->getMaestroByTipo(2);
		//$tipo_documento = $tablaMaestra_model->getMaestroByTipo(16);
		//$grupo_sanguineo = $tablaMaestra_model->getMaestroByTipo(90);
		//$nacionalidad = $tablaMaestra_model->getMaestroByTipo(5);
        return view('frontend.persona.all_lista_asignacion',compact(''));

    }

	public function modal_asignacion($id){
		$id_user = Auth::user()->id;
		
		if($id>0){
			$asignacion = AsignacionCuenta::find($id);
		}else{
			$asignacion = new AsignacionCuenta;
		}
		
		$tablaMaestra_model = new TablaMaestra;
        $sw = true;
		$plan_contable = PlanContable::where('estado','1')->orderBy('cuenta', 'asc')->get()->all();        
		$tipo_cuenta = $tablaMaestra_model->getMaestroByTipo(122);
		$centro_costo = CentroCosto::where('estado','1')->orderBy('codigo', 'asc')->get()->all();
		$partida_presupuestal = PartidaPresupuestale::where('estado','1')->orderBy('id', 'desc')->get()->all();
		$medio_pago = $tablaMaestra_model->getMaestroByTipo(108);
		$origen = $tablaMaestra_model->getMaestroByTipo(128);
		$codigo_financiero = CodigoFinanciero::where('estado','1')->orderBy('id', 'asc')->get()->all();
		$tipo_planilla = $tablaMaestra_model->getMaestroByTipo(129);

		//print_r($array);exit();
		return view('frontend.asignacion.modal_asignacion',compact('id','asignacion','plan_contable', 'tipo_cuenta', 'centro_costo', 'partida_presupuestal', 'medio_pago','origen','codigo_financiero','tipo_planilla'));
	}

	public function send_asignacion(Request $request){

		$id_user = Auth::user()->id;

		$cuenta = $request->cuenta;
		$denominacion = $request->denominacion ;
		$tipo_cuenta = $request->tipo_cuenta ;
		$centro_costo = $request->centro_costo;
		$partida_presupuestal = $request->partida_presupuestal ;
		$codigo_financiero =  $request->codigo_financiero;
		$medio_pago = $request->medio_pago ;
		$origen = $request->origen;
		$tipo_planilla = $request->tipo_planilla;
		
		if($request->id == 0){									
			$asignar = new AsignacionCuenta;
	
			$asignar->id_plan_contable = $cuenta;
			$asignar->denominacion = $denominacion;
			$asignar->id_tipo_cuenta = $tipo_cuenta;
			$asignar->id_centro_costo = $centro_costo;
			$asignar->id_partida_presupuestal = $partida_presupuestal;
			$asignar->id_codigo_financiero = $codigo_financiero;
			$asignar->id_medio_pago = $medio_pago;
			$asignar->id_origen = $origen;
			$asignar->id_tipo_planilla = $tipo_planilla;

			$asignar->id_usuario_inserta = $id_user;

			$asignar->save();
		}else{
			$asignar = AsignacionCuenta::find($request->id);

			$asignar->id_plan_contable = $cuenta;
			$asignar->denominacion = $denominacion;
			$asignar->id_tipo_cuenta = $tipo_cuenta;
			$asignar->id_centro_costo = $centro_costo;
			$asignar->id_partida_presupuestal = $partida_presupuestal;
			$asignar->id_codigo_financiero = $codigo_financiero;
			$asignar->id_medio_pago = $medio_pago;
			$asignar->id_origen = $origen;
			$asignar->id_tipo_planilla = $tipo_planilla;

			$asignar->save();
		}
    }

	public function eliminar_asignacion($id,$estado)
    {
		$asignar = AsignacionCuenta::find($id);
		$asignar->estado = $estado;
		$asignar->save();

		echo $asignar->id;

    }

}