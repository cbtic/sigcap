<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AsientoPlanilla;
use App\Models\TablaMaestra;

use App\Models\PlanContable;
use App\Models\CentroCosto;
use App\Models\PartidaPresupuestale;

use App\Models\PeriodoComisione;
use App\Models\PeriodoComisionDetalle;


//use App\Models\CondicionLaborale;

use Auth;

class AsientoPlanillaController extends Controller
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

		$anio = range(date('Y'), date('Y') - 20); 		
		$mes = [
            '01' => 'Enero', '02' => 'Febrero', '03' => 'Marzo',
            '04' => 'Abril', '05' => 'Mayo', '06' => 'Junio',
            '07' => 'Julio', '08' => 'Agosto', '09' => 'Septiembre',
            '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre',
        ];

		$mes_actual = date("m");

		$periodoComisione_model = new PeriodoComisione;
		$periodo = $periodoComisione_model->getPeriodoAll();
		$periodo_ultimo = PeriodoComisione::where("estado",1)->orderBy("id","desc")->first();
		$periodo_activo = PeriodoComisione::where("estado",1)->where("activo",1)->orderBy("id","desc")->first();

		$periodoDet = $periodoComisione_model->getPeriodoDetAll();
		$periodoDet_ultimo = PeriodoComisionDetalle::where("estado",1)->orderBy("id","desc")->first();
		$periodoDet_activo = PeriodoComisionDetalle::where("estado",1)->where("activo",1)->orderBy("id","desc")->first();


        return view('frontend.asiento.all',compact('periodo','periodo_activo', 'periodo_ultimo','periodoDet','periodoDet_activo', 'periodoDet_ultimo', 'anio', 'mes','mes_actual'));
    }

	public function create()
    {
        return view('frontend.persona.create');
    }

    public function listar_asiento_ajax(Request $request){
		
		$asiento_model = new AsientoPlanilla;
		
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
		$data = $asiento_model->listar_asiento_ajax($p);

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

    function consulta_asiento(){

		//$tablaMaestra_model = new TablaMaestra;
		//$persona = new Persona;
        //$sexo = $tablaMaestra_model->getMaestroByTipo(2);
		//$tipo_documento = $tablaMaestra_model->getMaestroByTipo(16);
		//$grupo_sanguineo = $tablaMaestra_model->getMaestroByTipo(90);
		//$nacionalidad = $tablaMaestra_model->getMaestroByTipo(5);
        return view('frontend.persona.all_lista_asiento',compact(''));

    }

	public function modal_asiento($id){
		$id_user = Auth::user()->id;
		
		
		if($id>0){
			$asiento = AsientoPlanilla::find($id);
		}else{
			$asiento = new AsientoPlanilla;
		}
		
		$tablaMaestra_model = new TablaMaestra;
        $sw = true;
		$plan_contable = PlanContable::where('estado','1')->orderBy('id', 'desc')->get()->all();        
		$tipo_cuenta = $tablaMaestra_model->getMaestroByTipo(122);
		$centro_costo = CentroCosto::where('estado','1')->orderBy('id', 'desc')->get()->all();
		$partida_presupuestal = PartidaPresupuestale::where('estado','1')->orderBy('id', 'desc')->get()->all();
		$medio_pago = $tablaMaestra_model->getMaestroByTipo(108);

		//print_r($array);exit();
		return view('frontend.asiento.modal_asiento',compact('id','asiento','plan_contable', 'tipo_cuenta', 'centro_costo', 'partida_presupuestal', 'medio_pago'));
	}

	public function send_asiento(Request $request){

		$id_user = Auth::user()->id;

		$cuenta = $request->cuenta;
		$denominacion = $request->denominacion ;
		$tipo_cuenta = $request->tipo_cuenta ;
		$centro_costo = $request->centro_costo;
		$partida_presupuestal = $request->partida_presupuestal ;
		$codigo_financiero =  $request->codigo_financiero;
		$medio_pago = $request->medio_pago ;
		$origen = $request->origen;
		
		if($request->id == 0){									
			$asignar = new AsientoPlanilla;
	
			$asignar->id_plan_contable = $cuenta;
			$asignar->denominacion = $denominacion;
			$asignar->id_tipo_cuenta = $tipo_cuenta;
			$asignar->id_centro_costo = $centro_costo;
			$asignar->id_partida_presupuestal = $partida_presupuestal;
			$asignar->id_codigo_financiero = $codigo_financiero;
			$asignar->id_medio_pago = $medio_pago;
			$asignar->id_origen = $origen;

			$asignar->id_usuario_inserta = $id_user;

			$asignar->save();
		}else{
			$asignar = AsientoPlanilla::find($request->id);

			$asignar->id_plan_contable = $cuenta;
			$asignar->denominacion = $denominacion;
			$asignar->id_tipo_cuenta = $tipo_cuenta;
			$asignar->id_centro_costo = $centro_costo;
			$asignar->id_partida_presupuestal = $partida_presupuestal;
			$asignar->id_codigo_financiero = $codigo_financiero;
			$asignar->id_medio_pago = $medio_pago;
			$asignar->id_origen = $origen;

			$asignar->save();
		}
    }

	public function eliminar_asiento($id,$estado)
    {
		$asignar = AsientoPlanilla::find($id);
		$asignar->estado = $estado;
		$asignar->save();

		echo $asignar->id;

    }

    public function obtener_asiento_planilla(Request $request){
		
		$anio = $request->anio;
		$mes = $request->mes;
		$periodo = $request->id_periodo;
		$tipo = $request->Tipo_b;

		//echo($tipo); exit();

		$asiento_planilla_model = new AsientoPlanilla;
		$asientoPlanilla = $asiento_planilla_model->ListarAsientoPlanilla($anio, $mes, $periodo,$tipo);

        return view('frontend.asiento.lista_asiento_planilla',compact('asientoPlanilla'));

    }

	public function generar_asiento_planilla(Request $request){
		//exit("hola");
		$anio =$request->anio;
		$mes =$request->mes;
		$periodo =$request->periodo;
		$id_periodo =$request->id_periodo;
		$tipo =$request->tipo;

		//print_r($id_periodo_bus); exit();

		$asiento_planilla_model = new AsientoPlanilla;
		$data = $asiento_planilla_model->generar_asiento_planilla($tipo,$id_periodo ,$anio, $mes);

		$result["aaData"] = $data;

		echo json_encode($result);
	
	}




}