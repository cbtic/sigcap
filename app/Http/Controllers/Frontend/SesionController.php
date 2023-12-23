<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ComisionSesione;
use App\Models\ComisionSesionDelegado;
use App\Models\Regione;
use App\Models\Comisione;
use App\Models\Agremiado;
use App\Models\TablaMaestra;
use App\Models\PeriodoComisione;
use App\Models\ComisionDelegado;
use App\Models\ProfesionalesOtro;
use App\Models\ComputoSesione;
use App\Models\ComisionSesionDictamene;
use Carbon\Carbon;
use Auth;

class SesionController extends Controller
{

	public function __construct(){

		$this->middleware(function ($request, $next) {
			if(!Auth::check()) {
                return redirect('login');
            }
			return $next($request);
    	});
	}

    public function lista_programacion_sesion(){
		
		//$regione_model = new Regione;
		$comisionSesionDelegado_model = new ComisionSesionDelegado;
		$tablaMaestra_model = new TablaMaestra;
		$periodoComisione_model = new PeriodoComisione;
		
		//$region = $regione_model->getRegionAll();
		$tipo_programacion = $tablaMaestra_model->getMaestroByTipo(71);
		$estado_sesion = $tablaMaestra_model->getMaestroByTipo(56);
		$estado_aprobacion = $tablaMaestra_model->getMaestroByTipo(109);
		$periodo = $periodoComisione_model->getPeriodoAll();
		
		
        return view('frontend.sesion.all_listar_sesion',compact(/*'region',*/'periodo','tipo_programacion','estado_sesion','estado_aprobacion'));
    }
	
	public function obtener_dictamen($id_comision_sesion){

        $comisionSesionDictamene_model = new ComisionSesionDictamene;
        $dictamen = $comisionSesionDictamene_model->getComisionSesionDictameneByIdComisionSesion($id_comision_sesion);
        return view('frontend.sesion.lista_dictamen',compact('dictamen'));

    }
	
	public function lista_programacion_sesion_ajax(Request $request){
	
		$comisionSesion_model = new ComisionSesione(); 
		$p[]=$request->id_regional;
		$p[]=$request->id_periodo;
		$p[]=$request->id_comision;
		$p[]=$request->fecha_inicio_bus;
		$p[]=$request->fecha_fin_bus;
		$p[]=$request->id_tipo_sesion;
		$p[]="";
		$p[]=$request->id_estado_sesion;
		$p[]=$request->id_estado_aprobacion;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $comisionSesion_model->lista_programacion_sesion_ajax($p);
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
	
	public function lista_computo_sesion_ajax(Request $request){
	
		$comisionSesion_model = new ComisionSesione(); 
		$p[]=$request->id_periodo;
		$p[]="";
		$p[]=$request->anio;
		$p[]=$request->mes;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $comisionSesion_model->lista_computo_sesion_ajax($p);
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
	
	public function lista_computo_cerrado_ajax(Request $request){
	
		$comisionSesion_model = new ComisionSesione(); 
		$p[]=$request->id_periodo;
		$p[]="";
		$p[]=$request->anio;
		$p[]=$request->mes;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $comisionSesion_model->lista_computo_cerrado_ajax($p);
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
	
	public function modal_sesion($id){
		
		$id_user = Auth::user()->id;
		
		$regione_model = new Regione;
		//$comision_model = new Comisione;
		$comisionSesionDelegado_model = new ComisionSesionDelegado;
		$tablaMaestra_model = new TablaMaestra;
		$periodoComisione_model = new PeriodoComisione;
		
		
		//$comision = $comision_model->getComisionAll("","1");
		$region = $regione_model->getRegionAll();
		
		$tipo_programacion = $tablaMaestra_model->getMaestroByTipo(71);
		$estado_sesion = $tablaMaestra_model->getMaestroByTipo(56);
		$estado_sesion_aprobado = $tablaMaestra_model->getMaestroByTipo(109);
		$periodo = $periodoComisione_model->getPeriodoAll();
		
		if($id>0){
			$comisionSesion = ComisionSesione::find($id);
			$id_comision = $comisionSesion->id_comision;
			$comision = Comisione::find($id_comision);
			$dia_semana = $tablaMaestra_model->getMaestroC("70", $comision->id_dia_semana);
			$delegados = $comisionSesionDelegado_model->getComisionSesionDelegadosByIdComisionSesion($id);
		}else{
			$comisionSesion = new ComisionSesione;
			$comision = new Comisione;
			$dia_semana = null;
			$delegados = $comisionSesionDelegado_model->getComisionDelegadosByIdComision(0/*$request->id_comision*/);
		}
		
		return view('frontend.sesion.modal_sesion',compact('id','comisionSesion','delegados','region','tipo_programacion','estado_sesion','periodo','comision','dia_semana','estado_sesion_aprobado'));

    }
	
	public function obtener_comision($id_periodo){
			
		$comision_model = new Comisione;
		$comision = $comision_model->getComisionByPeriodo($id_periodo);
		echo json_encode($comision);
		
	}
	
	public function obtener_comision_delegado($id_comision){
		
		$tablaMaestra_model = new TablaMaestra;	
		$comisionSesionDelegado_model = new ComisionSesionDelegado(); 
		$delegado = $comisionSesionDelegado_model->getComisionDelegadosByIdComision($id_comision);
		$comision = Comisione::find($id_comision);
		$dia_semana = $tablaMaestra_model->getMaestroC("70", $comision->id_dia_semana);
		//print_r($dia_semana);
		$data["dia_semana"] = $dia_semana;
		$data["delegado"] = $delegado;
		//echo json_encode($delegado);
		echo json_encode($data);
	}
	
	public function send_sesion(Request $request){
		
		//print_r($request->id_aprobar_pago);
		//exit();
		
		$id_user = Auth::user()->id;
		
		$id_delegado = $request->id_delegado;
		
		if($request->id == 0){
			$periodoComision = PeriodoComisione::find($request->id_periodo);
			$fecha_inicio = $periodoComision->fecha_inicio;
			$fecha_fin = $periodoComision->fecha_fin;
			$fechaInicio=strtotime($fecha_inicio);
			$fechaFin=strtotime($fecha_fin);
			
			$dia_semana = $request->dia_semana;
			
			$dias = array('LUNES','MARTES','MI�RCOLES','JUEVES','VIERNES','S�BADO','DOMINGO');
			
			for($i=$fechaInicio; $i<=$fechaFin; $i+=86400){
				$fechaInicioTemp = date("d-m-Y", $i);
				//echo $fechaInicioTemp;
				$dia = $dias[(date('N', strtotime($fechaInicioTemp))) - 1];
				//echo $dia_semana."|".$dia;
				if($dia_semana == $dia){
					//echo $fechaInicioTemp;
					$comisionSesion = new ComisionSesione;
					$comisionSesion->id_regional = $request->id_regional;
					$comisionSesion->id_periodo_comisione = $request->id_periodo;
					$comisionSesion->id_tipo_sesion = $request->id_tipo_sesion;
					$comisionSesion->fecha_programado = $fechaInicioTemp;
					//$comisionSesion->fecha_ejecucion = $request->fecha_ejecucion;
					//$comisionSesion->hora_inicio = $request->hora_inicio;
					//$comisionSesion->hora_fin = $request->hora_fin;
					//$comisionSesion->id_aprobado = $request->id_aprobado;
					$comisionSesion->observaciones = $request->observaciones;
					$comisionSesion->id_comision = $request->id_comision;
					$comisionSesion->id_estado_sesion = 288;
					$comisionSesion->estado = 1;
					$comisionSesion->id_usuario_inserta = $id_user;
					$comisionSesion->save();
					$id_comision_sesion = $comisionSesion->id;
					
					foreach($id_delegado as $row){
						
						$coordinador = 0;
						if($request->coordinador == $row)$coordinador = 1;
						$comisionSesionDelegado = new ComisionSesionDelegado();
						$comisionSesionDelegado->id_comision_sesion = $id_comision_sesion;
						$comisionSesionDelegado->id_delegado = $row;
						$comisionSesionDelegado->coordinador = $coordinador;
						$comisionSesionDelegado->id_profesion_otro = NULL;
						$comisionSesionDelegado->id_aprobar_pago = NULL;
						$comisionSesionDelegado->observaciones = NULL;
						$comisionSesionDelegado->estado = 1;
						$comisionSesionDelegado->id_usuario_inserta = $id_user;
						$comisionSesionDelegado->save();
					}
					
				}
			}
		
		}else{
			
			$comisionSesion = ComisionSesione::find($request->id);
			$comisionSesion->fecha_ejecucion = $request->fecha_ejecucion;
			$comisionSesion->hora_inicio = $request->hora_inicio;
			$comisionSesion->hora_fin = $request->hora_fin;
			$comisionSesion->id_estado_aprobacion = $request->id_estado_aprobacion;
			$comisionSesion->id_estado_sesion = $request->id_estado_sesion;
			$comisionSesion->save();
			
			$id_comision_sesion = $request->id;
			$id_aprobar_pago = $request->id_aprobar_pago;
			
			foreach($id_delegado as $key=>$row){
				$comisionSesionDelegado = ComisionSesionDelegado::where("id_comision_sesion",$id_comision_sesion)->where("id_delegado",$row)->first();
				
				$coordinador = 0;
				if($request->coordinador == $row)$coordinador = 1;
				
				$id_aprobar_pago_ = 1;
				if(isset($id_aprobar_pago[$row]) && $id_aprobar_pago[$row]==$row)$id_aprobar_pago_ = 2;
				
				$comisionSesionDelegado->coordinador = $coordinador;
				$comisionSesionDelegado->id_aprobar_pago = $id_aprobar_pago_;
				if($id_aprobar_pago_==2)$comisionSesionDelegado->fecha_aprobar_pago = Carbon::now()->format('Y-m-d');
				$comisionSesionDelegado->save();
				
			}
			
		}
			
    }
	
	public function send_computo_sesion(Request $request){
		
		$id_user = Auth::user()->id;
		
		$computoSesion = new ComputoSesione;
		$computoSesion->anio = $request->anio;
		$computoSesion->mes = $request->mes;
		$computoSesion->fecha = Carbon::now()->format('Y-m-d');
		$computoSesion->estado = 1;
		$computoSesion->id_usuario_inserta = $id_user;
		$computoSesion->save();
		$id_computo_sesion = $computoSesion->id;
		
		$computoSesion_model = new ComputoSesione;
		$comisionSesion=$computoSesion_model->getComisionSesionByAnioMes($request->anio,$request->mes);
		
		foreach($comisionSesion as $row){
			$ComisionSesion = ComisionSesione::find($row->id_comision_sesion);
			$ComisionSesion->id_computo_sesion = $id_computo_sesion;
			$ComisionSesion->save();
		}
		
		$computo_mes = $computoSesion_model->getMesComputoById($id_computo_sesion,$request->anio,$request->mes);
		
		$computoSesionUpd = ComputoSesione::find($id_computo_sesion);
		$computoSesionUpd->computo_mes_actual = $computo_mes->computo_mes_actual;
		$computoSesionUpd->computo_meses_anteriores = $computo_mes->computo_meses_anteriores;
		$computoSesionUpd->save();
		
	}
	
	public function send_profesion_otro(Request $request){
		
		$id_user = Auth::user()->id;
		
		if($request->id == 0){
			$comisionSesionDelegado = new ComisionSesionDelegado();
		}else{
			$comisionSesionDelegado = ComisionSesionDelegado::find($request->id);
		}
		
		$comisionSesionDelegado->id_comision_sesion = $request->id_comision_sesion;
		$comisionSesionDelegado->id_delegado = NULL;
		$comisionSesionDelegado->id_profesion_otro = $request->id_profesion_otro;
		$comisionSesionDelegado->id_aprobar_pago = NULL;
		$comisionSesionDelegado->observaciones = NULL;
		$comisionSesionDelegado->estado = 1;
		$comisionSesionDelegado->id_usuario_inserta = $id_user;
		$comisionSesionDelegado->save();
				
    }
	
	public function send_delegado_sesion(Request $request){
		
		$id_user = Auth::user()->id;
		
		if($request->id == 0){
			$comisionSesionDelegado = new ComisionSesionDelegado();
		}else{
			$comisionSesionDelegado = ComisionSesionDelegado::find($request->id);
		}
		
		$comisionSesionDelegado->id_comision_sesion = $request->id_comision_sesion;
		$comisionSesionDelegado->id_delegado = $request->id_delegado;
		$comisionSesionDelegado->id_profesion_otro = NULL;
		$comisionSesionDelegado->id_aprobar_pago = NULL;
		$comisionSesionDelegado->observaciones = NULL;
		$comisionSesionDelegado->estado = 1;
		$comisionSesionDelegado->id_usuario_inserta = $id_user;
		$comisionSesionDelegado->save();
			
    }
	
	public function modal_asignar_delegado_sesion($id){
		
		$id_user = Auth::user()->id;
		
		$comisionDelegado_model = new ComisionDelegado;
		
		//if($id>0) $comisionDelegado = ComisionDelegado::find($id);else $comisionDelegado = new ComisionDelegado;
		
		$concurso_inscripcion = $comisionDelegado_model->getComisionDelegado();
		
		return view('frontend.sesion.modal_asignar_delegado_sesion',compact('id','concurso_inscripcion'));

    }
	
	public function modal_asignar_profesion_sesion($id){
		
		$id_user = Auth::user()->id;
		
		//$profesionalesOtro_model = new ProfesionalesOtro;
		$agremiado_model = new Agremiado;
		
		//if($id>0) $comisionDelegado = ComisionDelegado::find($id);else $comisionDelegado = new ComisionDelegado;
		
		//$profesion_sesion = $profesionalesOtro_model->getProfesionSesion();
		$profesion_sesion = $agremiado_model->getAgremiadoAll();
		
		return view('frontend.sesion.modal_asignar_profesion_sesion',compact('id','profesion_sesion'));

    }
	
	function consulta_calendarioComputo(){

		$periodoComisione_model = new PeriodoComisione;
		$anio = range(date('Y'), date('Y') - 20); 
		$mes = [
            '01' => 'Enero', '02' => 'Febrero', '03' => 'Marzo',
            '04' => 'Abril', '05' => 'Mayo', '06' => 'Junio',
            '07' => 'Julio', '08' => 'Agosto', '09' => 'Septiembre',
            '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre',
        ];
		$comisionDelegado_model = new ComisionDelegado;
		
		$concurso_inscripcion = $comisionDelegado_model->getComisionDelegado();

		$comision_model = new Comisione;
		
		$comision = $comision_model->getComisionAll("","","1");
		
		$periodo = $periodoComisione_model->getPeriodoAll();

        return view('frontend.sesion.all_calendario_computo',compact('periodo','anio','mes','comision','concurso_inscripcion'));
    }

	public function lista_calendario_computo(){
		
		//$regione_model = new Regione;
		/*$comisionSesionDelegado_model = new ComisionSesionDelegado;
		$tablaMaestra_model = new TablaMaestra;
		$periodoComisione_model = new PeriodoComisione;
		
		//$region = $regione_model->getRegionAll();
		$tipo_programacion = $tablaMaestra_model->getMaestroByTipo(71);
		$estado_sesion = $tablaMaestra_model->getMaestroByTipo(56);
		$estado_aprobacion = $tablaMaestra_model->getMaestroByTipo(109);
		$periodo = $periodoComisione_model->getPeriodoAll();
		*/
		
        return view('frontend.sesion.all_listar_sesion');
    }
	
	function consulta_computoSesion(){

		$periodoComisione_model = new PeriodoComisione;

		$anio = range(date('Y'), date('Y') - 20); 
		$mes = [
            '01' => 'Enero', '02' => 'Febrero', '03' => 'Marzo',
            '04' => 'Abril', '05' => 'Mayo', '06' => 'Junio',
            '07' => 'Julio', '08' => 'Agosto', '09' => 'Septiembre',
            '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre',
        ];
		
		$comisionDelegado_model = new ComisionDelegado;
		
		$concurso_inscripcion = $comisionDelegado_model->getComisionDelegado();

		$comision_model = new Comisione;
		
		$comision = $comision_model->getComisionAll("","","1");
		
		$periodo = $periodoComisione_model->getPeriodoAll();

        return view('frontend.sesion.all_computo_sesion',compact('periodo','anio','mes','comision','concurso_inscripcion'));
    }

	public function lista_computoSesion(){
		
		
		
        return view('frontend.sesion.all_listar_computo_sesion');
    }

}
