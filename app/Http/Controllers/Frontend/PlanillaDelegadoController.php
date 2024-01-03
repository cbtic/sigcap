<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PlanillaDelegado;

class PlanillaDelegadoController extends Controller
{
	
	public function consulta_planilla_delegado(){
		
		//$agremiado_model = new Agremiado();
		//$concurso_model = new Concurso();
		//$tablaMaestra_model = new TablaMaestra;
		
		//$concurso = $concurso_model->getConcurso();
		//$situacion_cliente = $tablaMaestra_model->getMaestroByTipo(14);
		
        //return view('frontend.concurso.create_resultado',compact('concurso','situacion_cliente'));
		
		$anio = range(date('Y'), date('Y') - 20); 
		$mes = [
            '01' => 'Enero', '02' => 'Febrero', '03' => 'Marzo',
            '04' => 'Abril', '05' => 'Mayo', '06' => 'Junio',
            '07' => 'Julio', '08' => 'Agosto', '09' => 'Septiembre',
            '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre',
        ];
		
		return view('frontend.planilla.consulta_planilla_delegado',compact('anio','mes'));
		
    }
	
	public function obtener_planilla_delegado(Request $request){
		
		$planillaDelegado = PlanillaDelegado::where("periodo",$request->anio)->where("mes",$request->mes)->first();
		
        $planillaDelegado_model = new PlanillaDelegado;
		
		$planilla = NULL;
		
		if(isset($planillaDelegado->id)){
        	$planilla = $planillaDelegado_model->getPlanillaDelegadoDetalleByIdPlanilla($planillaDelegado->id);
		}
        return view('frontend.planilla.lista_planilla_delegado',compact('planilla'));

    }
	
	public function send_planilla_delegado(Request $request){
		
		$msg = "";
		$planillaDelegadoExiste = PlanillaDelegado::where("periodo",$request->anio)->where("mes",$request->mes)->where("estado",1)->first();
		
		if($planillaDelegadoExiste){
			$msg = false;
		}else{
			$planillaDelegado_model = new PlanillaDelegado;
			$planillaDelegado_model->generar_planilla_delegado($request->anio,$request->mes);
		}
		
		return $msg;
		
	}
	
	    
}
