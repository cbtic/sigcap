<?php

namespace App\Http\Controllers\Frontend;
use App\Models\PeriodoComisione;
use App\Models\Reporte;
use Carbon\Carbon;
use Auth;
use Barryvdh\DomPDF\Facade\Pdf;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReporteController extends Controller
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
		$periodoComisione_model = new PeriodoComisione;

		$id_user = Auth::user()->id;

		$anio = range(date('Y'), date('Y') - 20); 
		$mes = [
            '01' => 'Enero', '02' => 'Febrero', '03' => 'Marzo',
            '04' => 'Abril', '05' => 'Mayo', '06' => 'Junio',
            '07' => 'Julio', '08' => 'Agosto', '09' => 'Septiembre',
            '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre',
        ];
		
		//$reporte_model = new Reporte;
		//$reporte = $reporte_model->getReporteAll($id_user);

		$periodo = $periodoComisione_model->getPeriodoAll();
		$periodo_ultimo = PeriodoComisione::where("estado",1)->orderBy("id","desc")->first();
		$periodo_activo = PeriodoComisione::where("estado",1)->where("activo",1)->orderBy("id","desc")->first();

		

		$reporte = Reporte::where([
			'estado' => '1'
		])->get();

		//print_r($reporte);


		
        return view('frontend.reporte.all',compact('periodo','anio','mes','reporte','periodo_ultimo','periodo_activo'));
    }
/*
    function lista_reporte_ajax(){

		$periodoComisione_model = new PeriodoComisione;

		$anio = range(date('Y'), date('Y') - 20); 
		$mes = [
            '01' => 'Enero', '02' => 'Febrero', '03' => 'Marzo',
            '04' => 'Abril', '05' => 'Mayo', '06' => 'Junio',
            '07' => 'Julio', '08' => 'Agosto', '09' => 'Septiembre',
            '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre',
        ];
		
		$reporte_model = new Reporte;
		$reportes = $reporte_model->getReporteAll();

		$periodo = $periodoComisione_model->getPeriodoAll();
		$periodo_ultimo = PeriodoComisione::where("estado",1)->orderBy("id","desc")->first();
		$periodo_activo = PeriodoComisione::where("estado",1)->where("activo",1)->orderBy("id","desc")->first();
		
        return view('frontend.reporte.all_reporte',compact('periodo','anio','mes','reportes','periodo_ultimo','periodo_activo'));
    }
*/
	public function lista_reporte_ajax(Request $request){
	
		$reporte_model = new Reporte(); 
		$p[]=$request->id_periodo;
		$p[]="";
		$p[]=$request->anio;
		$p[]=$request->mes;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $reporte_model->lista_reporte_ajax($p);
		$iTotalDisplayRecords = isset($data[0]->totalrows)?$data[0]->totalrows:0;

		$result["PageStart"] = $request->NumeroPagina;
		$result["pageSize"] = $request->NumeroRegistros;
		$result["SearchText"] = "";
		$result["ShowChildren"] = true;
		$result["iTotalRecords"] = $iTotalDisplayRecords;
		$result["iTotalDisplayRecords"] = $iTotalDisplayRecords;
		$result["aaData"] = $data;

        //print_r(json_encode($result)); exit();
		echo json_encode($result);

	
	}

	public function listar_reporte($tipo_documento,$id_persona){  
		$id_user = Auth::user()->id;     
        $reporte_model = new Reporte;
        $sw = true;
        $pago = $reporte_model->getReporteAll($id_user);
        return view('frontend.ingreso.lista_pago',compact('pago'));

    }

	public function listar_reporte_usuario(Request $request){
		$id_user = Auth::user()->id;     
        $reporte_model = new Reporte;
        $sw = true;
        $resultado = $reporte_model->getReporteAll($id_user);
      
		return $resultado;

    }
}
