<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FondoComun;
use App\Models\PeriodoComisione;
use App\Models\ComisionDelegado;
use App\Models\Comisione;
use App\Models\TablaMaestra;
use App\Models\Municipalidade;
use Auth;

class FondoComunController extends Controller
{
    public function __construct(){

		$this->middleware(function ($request, $next) {
			if(!Auth::check()) {
                return redirect('login');
            }
			return $next($request);
    	});
	}

    function consulta_fondo_comun(){

        $periodoComisione_model = new PeriodoComisione;

        $municipalidad_model = new Municipalidade;

        $municipalidad = $municipalidad_model -> getMunicipalidadAll();

	
		$anio = range(date('Y'), date('Y') - 20); 
		$mes = [
            '01' => 'Enero', '02' => 'Febrero', '03' => 'Marzo',
            '04' => 'Abril', '05' => 'Mayo', '06' => 'Junio',
            '07' => 'Julio', '08' => 'Agosto', '09' => 'Septiembre',
            '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre',
        ];


		$tablaMaestra_model = new TablaMaestra;

		$mes = $tablaMaestra_model->getMaestroByTipo(116);

		$mes_actual = date("m");


		$comisionDelegado_model = new ComisionDelegado;
		
		$concurso_inscripcion = $comisionDelegado_model->getComisionDelegado();

		$comision_model = new Comisione;
		
		$comision = $comision_model->getComisionAll("","","","1");
				
		$periodo = $periodoComisione_model->getPeriodoAll();

		$periodo_ultimo = PeriodoComisione::where("estado",1)->orderBy("id","desc")->first();

		//print_r($mes); exit();

        //return view('frontend.fondoComun.all_fondo_comun',compact('periodo','anio','mes','mes_actual','comision','concurso_inscripcion','municipalidad','periodo_ultimo'));
		return view('frontend.fondoComun.all_fondo_comun',compact('periodo','anio','mes'));
    }

    public function listar_fondo_comun_ajax(Request $request){
	
		$fondo_comun_model = new FondoComun;
		$p[]=$request->id_periodo;
		$p[]=$request->anio;
		$p[]=$request->mes;
		$p[]=$request->idMunicipalidad;
		$p[]=$request->idComision;
		$p[]=$request->credipago;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;

		//print_r($p); exit();

		$data = $fondo_comun_model->listar_fondo_comun_ajax($p);
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
	
	public function calcula_fondo_comun(Request $request){
		//exit("hola");
		$anio =$request->anio;
		$mes =$request->mes;

		$fondo_comun_model = new FondoComun;
		$data = $fondo_comun_model->calcula_fondo_comun($anio, $mes);

		$result["aaData"] = $data;

		echo json_encode($result);
	
	}
	public function obtener_fondo_comun(Request $request){
		
		$anio = $request->anio;
		$mes = $request->mes;
		$municipalidad = $request->idMunicipalidad;

		$fondo_comun_model = new FondoComun;
		$fondoComun = $fondo_comun_model->ListarFondoComun($anio, $mes, $municipalidad);

        return view('frontend.fondoComun.lista_fondo_comun',compact('fondoComun'));

    }
	
}
