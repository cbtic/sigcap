<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AsignacionCuenta;
use App\Models\TablaMaestra;

use App\Models\PlanContable;
use App\Models\CentroCosto;
use App\Models\PartidaPresupuestale;


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
        return view('frontend.asignacion.all');
    }

	public function create()
    {
        return view('frontend.persona.create');
    }

    public function listar_asignacion_ajax(Request $request){
		
		$asignacion_model = new AsignacionCuenta;
		
		$p[]=$request->cuenta;
		$p[]=$request->denominacion;
		$p[]=$request->tipo_cuenta;
		$p[]=$request->centro_costo;
		$p[]=$request->partida_presupuestal;
		$p[]=$request->codigo_financiamiento;
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
		
		

		//print_r($plan_contable_);exit();

        $sw = true;
		$plan_contable = PlanContable::where('estado','1')->orderBy('id', 'desc')->get()->all();
        
		//$array["plan_contable_"] = $plan_contable_;
       // echo json_encode($array);
		//$plan_contable = $array;

		//print_r($array);exit();

		$tipo_cuenta = $tablaMaestra_model->getMaestroByTipo(119);

		//print_r($tipo_cuenta);exit();

		$centro_costo = CentroCosto::where('estado','1')->orderBy('id', 'desc')->get()->all();
		$partida_presupuestal = PartidaPresupuestale::where('estado','1')->orderBy('id', 'desc')->get()->all();
		$medio_pago = $tablaMaestra_model->getMaestroByTipo(108);
		
	
		return view('frontend.asignacion.modal_asignacion',compact('id','asignacion','plan_contable', 'tipo_cuenta', 'centro_costo', 'partida_presupuestal', 'medio_pago'));
	}

}