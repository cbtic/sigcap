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
use App\Models\ComisionSesionDelegadosHistoriale;
use Carbon\Carbon;
use Auth;
use Barryvdh\DomPDF\Facade\Pdf;

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
		$tipo_comision = $tablaMaestra_model->getMaestroByTipo(102);
		$periodo_ultimo = PeriodoComisione::where("estado",1)->orderBy("id","desc")->first();
		$periodo_activo = PeriodoComisione::where("estado",1)->where("activo",1)->orderBy("id","desc")->first();
		$situacion = $tablaMaestra_model->getMaestroByTipo(14);
		
        return view('frontend.sesion.all_listar_sesion',compact(/*'region',*/'periodo','tipo_programacion','estado_sesion','estado_aprobacion','tipo_comision','periodo_ultimo','situacion','periodo_activo'));
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
		$p[]=$request->tipo_comision;
		$p[]=$request->id_comision;
		$p[]=$request->fecha_inicio_bus;
		$p[]=$request->fecha_fin_bus;
		$p[]=$request->id_tipo_sesion;
		$p[]="";
		$p[]=$request->id_estado_sesion;
		$p[]=$request->id_estado_aprobacion;
		$p[]=$request->cantidad_delegado;
		$p[]=$request->id_situacion;
		$p[]=(isset($request->campo))?$request->campo:"t1.fecha_programado";
		$p[]=(isset($request->orden))?$request->orden:"asc";
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
		$p[]=$request->id_comision;
		$p[]=$request->id_puesto;
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
		
		
		//$comision = $comision_model->getComisionAll("","","","1");
		$region = $regione_model->getRegionAll();
		
		$tipo_programacion = $tablaMaestra_model->getMaestroByTipo(71);
		$estado_sesion = $tablaMaestra_model->getMaestroByTipo(56);
		$estado_sesion_aprobado = $tablaMaestra_model->getMaestroByTipo(109);
		$periodo = $periodoComisione_model->getPeriodoAll();
		$tipo_comision = $tablaMaestra_model->getMaestroByTipo(102);
		
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
		
		$periodo_ultimo = PeriodoComisione::where("estado",1)->orderBy("id","desc")->first();
		
		$dia_semanas = $tablaMaestra_model->getMaestroByTipo(70);
		
		return view('frontend.sesion.modal_sesion',compact('id','comisionSesion','delegados','region','tipo_programacion','estado_sesion','periodo','comision','dia_semana','estado_sesion_aprobado','tipo_comision','periodo_ultimo','dia_semanas'));

    }
	
	public function obtener_delegados($id){
		
		$comisionSesionDelegado_model = new ComisionSesionDelegado(); 
		
		if($id>0){
			$delegados = $comisionSesionDelegado_model->getComisionSesionDelegadosByIdComisionSesion($id);
		}else{
			$delegados = $comisionSesionDelegado_model->getComisionDelegadosByIdComision(0/*$request->id_comision*/);
		}
		
		return view('frontend.sesion.lista_sesion_delegado',compact('id','delegados'));
		
	}
	
	public function modal_historial_delegado_sesion($id){
		 
		$comisionSesionDelegado_model = new ComisionSesionDelegado(); 
        $comisionSesionDelegadoHistorial = $comisionSesionDelegado_model->getHistorialComisionSesionDelegadosByIdComisionSesionDelegado($id);
		
        return view('frontend.sesion.modal_historial_sesion_delegado',compact('comisionSesionDelegadoHistorial','id'));
		
    }
	
	public function obtener_comision($id_periodo,$tipo_comision){
			
		$comision_model = new Comisione;
		$comision = $comision_model->getComisionByPeriodo($id_periodo,$tipo_comision);
		echo json_encode($comision);
		
	}
	
	public function obtener_puesto($id_periodo,$tipo_comision){
			
		$comision_model = new Comisione;
		$puesto = $comision_model->getPuestoByPeriodo($id_periodo,$tipo_comision);
		echo json_encode($puesto);
		
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
	
	public function send_sesion_bloque(Request $request){
		
		$tablaMaestra_model = new TablaMaestra;
		
		$id_user = Auth::user()->id;
		$periodoComision = PeriodoComisione::find($request->id_periodo);
		$fecha_inicio = $periodoComision->fecha_inicio;
		$fecha_fin = $periodoComision->fecha_fin;
		$fechaInicio=strtotime($fecha_inicio);
		$fechaFin=strtotime($fecha_fin);
		
		$dias = array('LUNES','MARTES','MIERCOLES','JUEVES','VIERNES','SABADO','DOMINGO');
		
		
		$tipo_comision = $tablaMaestra_model->getMaestroByTipo(102);
		
		//print_r($tipo_comision);exit();
		
		foreach($tipo_comision as $rowTipoComision){
			
			$id_tipo_comision = $rowTipoComision->codigo;
			
			if($id_tipo_comision!=2){
				
				$comision_model = new Comisione;
				$comisiones = $comision_model->getComisionByPeriodo($request->id_periodo,$id_tipo_comision);
				
				foreach($comisiones as $rowComision){
					
					$id_comision = $rowComision->id;
					//echo $id_comision."<br>";
					/*************************/
					
					$comision = Comisione::find($id_comision);
					$dia_semanas = $tablaMaestra_model->getMaestroC("70", $comision->id_dia_semana);
					//print_r($dia_semanas);
					$dia_semana = $dia_semanas[0]->denominacion;
					
					$comisionSesionDelegado_model = new ComisionSesionDelegado(); 
					$delegados = $comisionSesionDelegado_model->getComisionDelegadosByIdComision($id_comision);
					
					//print_r($delegado);
					
					for($i=$fechaInicio; $i<=$fechaFin; $i+=86400){
						$fechaInicioTemp = date("d-m-Y", $i);
						$dia = $dias[(date('N', strtotime($fechaInicioTemp))) - 1];
						
						//echo $dia_semana."<br>";
						
						if($dia_semana == $dia){
							
							$comisionSesioneExiste = ComisionSesione::where("id_regional",5)->where("id_periodo_comisione",$request->id_periodo)->where("id_tipo_sesion",401)->where("id_comision",$id_comision)->where("fecha_programado",$fechaInicioTemp)->first();
							
							if(!$comisionSesioneExiste){
							
								$comisionSesion = new ComisionSesione;
								$comisionSesion->id_regional = 5;//$request->id_regional;
								$comisionSesion->id_periodo_comisione = $request->id_periodo;
								$comisionSesion->id_tipo_sesion = 401;//$request->id_tipo_sesion;
								$comisionSesion->fecha_programado = $fechaInicioTemp;
								$comisionSesion->observaciones = "";//$request->observaciones;
								$comisionSesion->id_comision = $id_comision;
								$comisionSesion->id_estado_sesion = 288;
								$comisionSesion->estado = 1;
								$comisionSesion->id_usuario_inserta = $id_user;
								$comisionSesion->save();
								$id_comision_sesion = $comisionSesion->id;
								
								foreach($delegados as $row){
									
									//$coordinador = 0;
									//if($request->coordinador == $row)$coordinador = 1;
									$comisionSesionDelegado = new ComisionSesionDelegado();
									$comisionSesionDelegado->id_comision_sesion = $id_comision_sesion;
									$comisionSesionDelegado->id_delegado = $row->id;
									//$comisionSesionDelegado->coordinador = $coordinador;
									$comisionSesionDelegado->coordinador = $row->coordinador;
									$comisionSesionDelegado->id_profesion_otro = NULL;
									$comisionSesionDelegado->id_aprobar_pago = NULL;
									$comisionSesionDelegado->observaciones = NULL;
									$comisionSesionDelegado->estado = 1;
									$comisionSesionDelegado->id_usuario_inserta = $id_user;
									$comisionSesionDelegado->save();
								}
							
							}
							
						}
					}
					
					/*************************/
					
				}
				
			}
			
		
		}
		
		
	}
	
	public function send_sesion(Request $request){
		
		//print_r($request->id_aprobar_pago);
		//exit();
		
		$id_user = Auth::user()->id;
		
		$id_regional = (isset($request->id_regional))?$request->id_regional:$request->id_regional_;
		$id_periodo = (isset($request->id_periodo))?$request->id_periodo:$request->id_periodo_;
		
		$id_delegado = $request->id_delegado;
		$id_tipo = $request->id_tipo;
		
		if($request->id == 0){
			$periodoComision = PeriodoComisione::find($id_periodo);
			$fecha_inicio = $periodoComision->fecha_inicio;
			$fecha_fin = $periodoComision->fecha_fin;
			$fechaInicio=strtotime($fecha_inicio);
			$fechaFin=strtotime($fecha_fin);
			
			$dia_semana = $request->dia_semana;
			
			//$dias = array('LUNES','MARTES','MI�RCOLES','JUEVES','VIERNES','S�BADO','DOMINGO');
			$dias = array('LUNES','MARTES','MIERCOLES','JUEVES','VIERNES','SABADO','DOMINGO');
			
			if($request->id_dia_semana=="398" || $request->id_tipo_sesion=="402"){//variable o extraordinaria
				
			//if($request->id_dia_semana=="398"){//variable
				
				$comisionSesion = new ComisionSesione;
				$comisionSesion->id_regional = $id_regional;
				$comisionSesion->id_periodo_comisione = $id_periodo;
				$comisionSesion->id_tipo_sesion = $request->id_tipo_sesion;
				$comisionSesion->fecha_programado = $request->fecha_programado;
				$comisionSesion->observaciones = $request->observaciones;
				$comisionSesion->id_comision = $request->id_comision;
				$comisionSesion->id_estado_sesion = 288;
				$comisionSesion->estado = 1;
				$comisionSesion->id_usuario_inserta = $id_user;
				$comisionSesion->save();
				$id_comision_sesion = $comisionSesion->id;
				//echo "es".count($id_delegado);exit();
				if(isset($request->id_delegado)){
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
				
			}else{
			
				for($i=$fechaInicio; $i<=$fechaFin; $i+=86400){
					$fechaInicioTemp = date("d-m-Y", $i);
					//echo $fechaInicioTemp;
					$dia = $dias[(date('N', strtotime($fechaInicioTemp))) - 1];
					//echo $dia_semana."|".$dia;
					if($dia_semana == $dia){
						//echo $fechaInicioTemp;
						$comisionSesion = new ComisionSesione;
						$comisionSesion->id_regional = $id_regional;
						$comisionSesion->id_periodo_comisione = $id_periodo;
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
						
						if(isset($request->id_delegado)){
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
				}
			
			}
		
		}else{
			
			$comisionSesion = ComisionSesione::find($request->id);
			$comisionSesion->fecha_ejecucion = $request->fecha_ejecucion;
			$comisionSesion->hora_inicio = $request->hora_inicio;
			$comisionSesion->hora_fin = $request->hora_fin;
			$comisionSesion->id_estado_aprobacion = $request->id_estado_aprobacion;
			$comisionSesion->id_estado_sesion = $request->id_estado_sesion;
			$comisionSesion->observaciones = $request->observaciones;
			$comisionSesion->save();
			
			$id_comision_sesion = $request->id;
			$id_aprobar_pago = $request->id_aprobar_pago;
			
			if(isset($request->id_delegado)){
				foreach($id_delegado as $key=>$row){
					
					if($id_tipo[$key]==1){
						$comisionSesionDelegado = ComisionSesionDelegado::where("id_comision_sesion",$id_comision_sesion)->where("id_delegado",$row)->first();
					}else{
						$comisionSesionDelegado = ComisionSesionDelegado::where("id_comision_sesion",$id_comision_sesion)->where("id_agremiado",$row)->first();	
					}
					
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
			
    }
	
	public function update_sesion_dia_semana(Request $request){
		
		$id_user = Auth::user()->id;
		$tablaMaestra_model = new TablaMaestra;
		
		$comisionSesionUpd = ComisionSesione::find($request->id);
		$id_regional = $comisionSesionUpd->id_regional;
		$id_periodo = $comisionSesionUpd->id_periodo_comisione;
		$id_tipo_sesion = $comisionSesionUpd->id_tipo_sesion;
		$id_comision = $comisionSesionUpd->id_comision;
		$observaciones = $comisionSesionUpd->observaciones;
		$id_delegado = $request->id_delegado;
		
		$periodoComision = PeriodoComisione::find($id_periodo);
		$fecha_inicio = $comisionSesionUpd->fecha_programado;
		$fecha_fin = $periodoComision->fecha_fin;
		$fechaInicio=strtotime($fecha_inicio);
		$fechaFin=strtotime($fecha_fin); 
		
		$id_dia_semana = $request->dia_semana_nuevo;
		$dia_semana_maestro = $tablaMaestra_model->getMaestroC("70", $id_dia_semana);
		$dia_semana = $dia_semana_maestro[0]->denominacion;
		
		$comision = Comisione::find($id_comision);
		$comision->id_dia_semana = $id_dia_semana;
		$comision->save();
		
		$comisionSesion_model = new ComisionSesione;
		$comisionSesion_model->anularComisionSesion($comisionSesionUpd->id,$comisionSesionUpd->id_regional,$comisionSesionUpd->id_periodo_comisione,$comisionSesionUpd->id_tipo_sesion,$comisionSesionUpd->id_comision);
		$comisionSesion_model->anularComisionSesionDelegado($comisionSesionUpd->id,$comisionSesionUpd->id_regional,$comisionSesionUpd->id_periodo_comisione,$comisionSesionUpd->id_tipo_sesion,$comisionSesionUpd->id_comision);
		
		//echo $fecha_inicio."#".$fecha_fin."#".$dia_semana;
		$dias = array('LUNES','MARTES','MIERCOLES','JUEVES','VIERNES','SABADO','DOMINGO');
				
		for($i=$fechaInicio; $i<=$fechaFin; $i+=86400){
			
			$fechaInicioTemp = date("d-m-Y", $i);
			$dia = $dias[(date('N', strtotime($fechaInicioTemp))) - 1];
			
			if($dia_semana == $dia){
				//echo $dia_semana."#".$dia;
				$comisionSesion = new ComisionSesione;
				$comisionSesion->id_regional = $id_regional;
				$comisionSesion->id_periodo_comisione = $id_periodo;
				$comisionSesion->id_tipo_sesion = $id_tipo_sesion;
				$comisionSesion->fecha_programado = $fechaInicioTemp;
				$comisionSesion->observaciones = $observaciones;
				$comisionSesion->id_comision = $id_comision;
				$comisionSesion->id_estado_sesion = 288;
				$comisionSesion->estado = 1;
				$comisionSesion->id_usuario_inserta = $id_user;
				$comisionSesion->save();
				$id_comision_sesion = $comisionSesion->id;
				
				if(isset($request->id_delegado)){
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
		}
		
		
    }
	
	public function send_computo_sesion(Request $request){
		
		$id_user = Auth::user()->id;
		$msg = "";
		
		$computoSesioneExiste = ComputoSesione::where("id_periodo_comision",$request->id_periodo_bus)->where("anio",$request->anio)->where("mes",$request->mes)->where("estado",1)->first();
		
		if($computoSesioneExiste){
			$msg = false;
		}else{
		
			$computoSesion = new ComputoSesione;
			$computoSesion->anio = $request->anio;
			$computoSesion->mes = $request->mes;
			$computoSesion->id_periodo_comision = $request->id_periodo_bus;
			$computoSesion->fecha = Carbon::now()->format('Y-m-d');
			$computoSesion->estado = 1;
			$computoSesion->id_usuario_inserta = $id_user;
			$computoSesion->save();
			$id_computo_sesion = $computoSesion->id;
			
			$computoSesion_model = new ComputoSesione;
			$comisionSesion=$computoSesion_model->getComisionSesionByAnioMes($request->anio,$request->mes,$request->id_periodo_bus);
			
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
			$msg = true;
		}
		
		return $msg;
		
	}
	
	public function send_profesion_otro(Request $request){
		
		$id_user = Auth::user()->id;
		
		$comisionSesionDelegado_model = new ComisionSesionDelegado();
		
		$cantidad = $comisionSesionDelegado_model->getValidaDelegadosBySesionAndAgremiado($request->id_comision_sesion,$request->id_profesion_otro);
		
		if($cantidad == 0){
		
			if($request->id == 0){
				$comisionSesionDelegado = new ComisionSesionDelegado();
			}else{
				$comisionSesionDelegado = ComisionSesionDelegado::find($request->id);
			}
			
			$comisionSesionDelegado->id_comision_sesion = $request->id_comision_sesion;
			$comisionSesionDelegado->id_delegado = NULL;
			//$comisionSesionDelegado->id_profesion_otro = $request->id_profesion_otro;
			$comisionSesionDelegado->id_agremiado = $request->id_profesion_otro;
			$comisionSesionDelegado->id_aprobar_pago = NULL;
			$comisionSesionDelegado->observaciones = NULL;
			$comisionSesionDelegado->estado = 1;
			$comisionSesionDelegado->id_usuario_inserta = $id_user;
			$comisionSesionDelegado->save();
			
		}
		
		$result["cantidad"] = $cantidad;
		//$result["aaData"] = $data;

		echo json_encode($result);
		
				
    }
	
	public function send_delegado_sesion(Request $request){
		
		$id_user = Auth::user()->id; 
		
		$comisionSesionDelegado_model = new ComisionSesionDelegado();
		
		$cantidad = $comisionSesionDelegado_model->getValidaDelegadosBySesionAndAgremiado($request->id_comision_sesion,$request->id_delegado);

		if($cantidad == 0){
				
		if($request->id == 0){
			$comisionSesionDelegado = new ComisionSesionDelegado();
		}else{
			$comisionSesionDelegado = ComisionSesionDelegado::find($request->id);
		}
		
		if($request->flag_titular_suplente == 1){ //TITULAR
		
			$comisionDelegadoOld = ComisionDelegado::find($comisionSesionDelegado->id_delegado);
			//echo $comisionDelegadoOld->id;exit();
			$comisionDelegadoOld->estado = 0;
			$comisionDelegadoOld->save();
			
			$id_puesto = $comisionDelegadoOld->id_puesto;
			
			if($id_puesto==12){
				$comisionSesionDelegado_model = new ComisionSesionDelegado();
				$comisionSesionDelegadoObj = $comisionSesionDelegado_model->getPuestoComisionSesionDelegadoByIdComisionSesion($comisionSesionDelegado->id_comision_sesion);
				$id_puesto = $comisionSesionDelegadoObj->id_puesto;
				//ComisionDelegado::where("id_agremiado",$request->id_delegado)
			}
			
			$comisionDelegado = new ComisionDelegado;
			$comisionDelegado->id_regional = $comisionDelegadoOld->id_regional;
			$comisionDelegado->id_comision = $comisionDelegadoOld->id_comision;
			$comisionDelegado->coordinador = $comisionDelegadoOld->coordinador;
			$comisionDelegado->id_agremiado = $request->id_delegado;
			//$comisionDelegado->id_puesto = $comisionDelegadoOld->id_puesto;
			$comisionDelegado->id_puesto = $id_puesto;
			$comisionDelegado->id_usuario_inserta = $id_user;
			$comisionDelegado->save();
			$id_delegado = $comisionDelegado->id;
			
		}
		
		if($request->flag_titular_suplente == 2){ //SUPLENTE
		
			$comisionDelegadoOld = ComisionDelegado::find($comisionSesionDelegado->id_delegado);
			
			$comisionDelegado = new ComisionDelegado;
			$comisionDelegado->id_regional = $comisionDelegadoOld->id_regional;
			$comisionDelegado->id_comision = $comisionDelegadoOld->id_comision;
			$comisionDelegado->coordinador = $comisionDelegadoOld->coordinador;
			$comisionDelegado->id_agremiado = $request->id_delegado;
			//$comisionDelegado->id_puesto = $comisionDelegadoOld->id_puesto;
			$comisionDelegado->id_puesto = 12;
			$comisionDelegado->estado = 2;
			$comisionDelegado->id_usuario_inserta = $id_user;
			$comisionDelegado->save();
			$id_delegado = $comisionDelegado->id;
			
		}
		
		/***********************/
		
		$id_delegado_anterior = $comisionSesionDelegado->id_delegado;
		$id_agremiado_anterior = $comisionSesionDelegado->id_agremiado;
		
		$comisionSesionDelegado->id_comision_sesion = $request->id_comision_sesion;
		$comisionSesionDelegado->id_delegado_anterior = $id_delegado_anterior;
		$comisionSesionDelegado->id_agremiado_anterior = $id_agremiado_anterior;
		$comisionSesionDelegado->id_delegado = $id_delegado;
		$comisionSesionDelegado->id_profesion_otro = NULL;
		$comisionSesionDelegado->id_aprobar_pago = NULL;
		$comisionSesionDelegado->observaciones = NULL;
		$comisionSesionDelegado->estado = 1;
		$comisionSesionDelegado->id_usuario_inserta = $id_user;
		$comisionSesionDelegado->save();
		
		/*********************************/
		
		$comisionSesionDelegadosHistorial = new ComisionSesionDelegadosHistoriale;
		$comisionSesionDelegadosHistorial->id_comision_sesion_delegado = $comisionSesionDelegado->id;
		$comisionSesionDelegadosHistorial->id_delegado = $id_delegado_anterior;
		$comisionSesionDelegadosHistorial->id_agremiado = $id_agremiado_anterior;
		$comisionSesionDelegadosHistorial->estado = 1;
		$comisionSesionDelegadosHistorial->id_usuario_inserta = $id_user;
		$comisionSesionDelegadosHistorial->save();
		
		/*********************************/
		
		$comisionSesion = ComisionSesione::find($comisionSesionDelegado->id_comision_sesion);
		$comisionSesionDelegado_model = new ComisionSesionDelegado();
		$comisionSesionDelegados = $comisionSesionDelegado_model->getComisionDelegadosByIdDelegadoAndFecha($comisionDelegadoOld->id_agremiado,$comisionSesion->fecha_programado,$request->fecha_inicio_sesion,$request->fecha_fin_sesion);
		
		foreach($comisionSesionDelegados as $row){
			$comisionSesionDelegadoObj = ComisionSesionDelegado::find($row->id);
			
			$id_delegado_anterior_obj = $comisionSesionDelegadoObj->id_delegado;
			$id_agremiado_anterior_obj = $comisionSesionDelegadoObj->id_agremiado;
			
			$comisionSesionDelegadoObj->id_delegado_anterior = $id_delegado_anterior_obj;
			$comisionSesionDelegadoObj->id_agremiado_anterior = $id_agremiado_anterior_obj;
			
			$comisionSesionDelegadoObj->id_delegado = $id_delegado;
			$comisionSesionDelegadoObj->save();
			
			/*********************************/
			
			$comisionSesionDelegadosHistorialObj = new ComisionSesionDelegadosHistoriale;
			$comisionSesionDelegadosHistorialObj->id_comision_sesion_delegado = $comisionSesionDelegadoObj->id;
			$comisionSesionDelegadosHistorialObj->id_delegado = $id_delegado_anterior_obj;
			$comisionSesionDelegadosHistorialObj->id_agremiado = $id_agremiado_anterior_obj;
			$comisionSesionDelegadosHistorialObj->estado = 1;
			$comisionSesionDelegadosHistorialObj->id_usuario_inserta = $id_user;
			$comisionSesionDelegadosHistorialObj->save();
			
			/*********************************/
			
		}
		
		}
		
		$result["cantidad"] = $cantidad;

		echo json_encode($result);
			
    }
	
	public function send_coordinador_delegado_sesion(Request $request){
		
		$comisionSesionDelegado_model = new ComisionSesionDelegado();
		
		$comisionSesionDelegado = ComisionSesionDelegado::find($request->id);
		$comisionSesionDelegado->coordinador = 1;
		$comisionSesionDelegado->save();
		
		$comisionSesion = ComisionSesione::find($comisionSesionDelegado->id_comision_sesion);
		$comisionDelegadoActual = ComisionDelegado::find($comisionSesionDelegado->id_delegado);
		
		$comisionSesionDelegados = $comisionSesionDelegado_model->getComisionDelegadosByIdDelegadoAndFecha($comisionDelegadoActual->id_agremiado,$comisionSesion->fecha_programado,"","");
		
		foreach($comisionSesionDelegados as $row){
		
			$comisionSesionDelegadoObj = ComisionSesionDelegado::find($row->id);
			$comisionSesionDelegadoObj->coordinador = 1;
			$comisionSesionDelegadoObj->save();
			
			$comisionSesionDelegados2 = ComisionSesionDelegado::where("id_comision_sesion",$comisionSesionDelegadoObj->id_comision_sesion)->where("id_delegado","!=",$comisionSesionDelegadoObj->id_delegado)->get();
			
			foreach($comisionSesionDelegados2 as $row2){
			
				$comisionSesionDelegadoObj2 = ComisionSesionDelegado::find($row2->id);
				$comisionSesionDelegadoObj2->coordinador = 0;
				$comisionSesionDelegadoObj2->save();
			}
			
		}
		
    }
	
	public function modal_asignar_delegado_sesion($id){
		
		$id_user = Auth::user()->id;
		
		$comisionDelegado_model = new ComisionDelegado;
		
		//if($id>0) $comisionDelegado = ComisionDelegado::find($id);else $comisionDelegado = new ComisionDelegado;
		
		$comisionSesionDelegado = ComisionSesionDelegado::find($id);
		//echo $comisionSesionDelegado->id_comision_sesion;exit();
		//$concurso_inscripcion = $comisionDelegado_model->getComisionDelegado();
		$comisionSesion = ComisionSesione::find($comisionSesionDelegado->id_comision_sesion);
		$id_comision = $comisionSesion->id_comision;
		$comision_=Comisione::find($id_comision);
		$concurso_inscripcion = $comisionDelegado_model->getConcursoInscripcionAllNuevo($comision_->id_periodo_comisiones,$comision_->id_tipo_comision);
		
		//print_r($concurso_inscripcion);
		
		return view('frontend.sesion.modal_asignar_delegado_sesion',compact('id','concurso_inscripcion'));

    }
	
	public function modal_asignar_profesion_sesion($id){
		
		$id_user = Auth::user()->id;
		
		//$profesionalesOtro_model = new ProfesionalesOtro;
		$agremiado_model = new Agremiado;
		
		//if($id>0) $comisionDelegado = ComisionDelegado::find($id);else $comisionDelegado = new ComisionDelegado;
		
		//$profesion_sesion = $profesionalesOtro_model->getProfesionSesion();
		$profesion_sesion = $agremiado_model->getAgremiadoHabilitadoAll();
		
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
		
		$comision = $comision_model->getComisionAll("","","","1");
		
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
		//$concurso_inscripcion = $comisionDelegado_model->getComisionDelegado();

		$comision_model = new Comisione;
		$comision = $comision_model->getComisionAll("","","","1");
		$periodo = $periodoComisione_model->getPeriodoAll();
		$periodo_ultimo = PeriodoComisione::where("estado",1)->orderBy("id","desc")->first();
		$periodo_activo = PeriodoComisione::where("estado",1)->where("activo",1)->orderBy("id","desc")->first();
		
        return view('frontend.sesion.all_computo_sesion',compact('periodo','anio','mes','comision'/*,'concurso_inscripcion'*/,'periodo_ultimo','periodo_activo'));
    }

	public function obtener_anio_periodo($id_periodo){
			
		$periodoComisione_model = new PeriodoComisione;
		$periodoComision = PeriodoComisione::find($id_periodo);
		$anio = $periodoComisione_model->getAnioByFecha($periodoComision->fecha_inicio,$periodoComision->fecha_fin);
		echo json_encode($anio);
		
	}

	public function lista_computoSesion(){
		
        return view('frontend.sesion.all_listar_computo_sesion');
    }
	
	public function computo_sesion_pdf($id){
		
		$computoSesion = ComputoSesione::find($id);
		
		$comisionSesion_model = new ComisionSesione(); 
		$p[]=$computoSesion->id_periodo_comision;
		$p[]="";
		$p[]=$computoSesion->anio;//$request->anio;
		$p[]=$computoSesion->mes;//$request->mes;
		$p[]=1;
		$p[]=10000;
		$comisionSesion = $comisionSesion_model->lista_computo_sesion_ajax($p);
		
		$pdf = Pdf::loadView('pdf.computo_sesion',compact('comisionSesion','computoSesion'));
		$pdf->getDomPDF()->set_option("enable_php", true);
		
		$pdf->setPaper('A4', 'landscape'); // Tamaño de papel (puedes cambiarlo según tus necesidades)
    	$pdf->setOption('margin-top', 20); // Márgen superior en milímetros
   		$pdf->setOption('margin-right', 50); // Márgen derecho en milímetros
    	$pdf->setOption('margin-bottom', 20); // Márgen inferior en milímetros
    	$pdf->setOption('margin-left', 100); // Márgen izquierdo en milímetros

		return $pdf->stream('computo_sesion.pdf');
	
	}
	
	public function ver_computo_sesion_pdf($id_periodo,$id_comision,$id_puesto,$anio,$mes){
		
		$comisionSesion_model = new ComisionSesione(); 
		$p[]=$id_periodo;
		$p[]=$id_comision;
		$p[]=$id_puesto;
		$p[]=$anio;//$request->anio;
		$p[]=$mes;//$request->mes;
		$p[]=1;
		$p[]=10000;
		$comisionSesion = $comisionSesion_model->lista_computo_sesion_ajax($p);

		$mes_ = ltrim($mes, '0');
		$mesEnLetras = $this->mesesALetras($mes_);
		
		$calendarioSesion = $comisionSesion_model->getCalendarioSesion($id_periodo,$anio,$mes);
		$calendarioCoordinadorZonalSesion = $comisionSesion_model->getCalendarioCoordinadorZonalSesion($id_periodo,$anio,$mes);
		
		$pdf = Pdf::loadView('pdf.ver_computo_sesion',compact('comisionSesion','anio','mes','mesEnLetras','calendarioSesion','calendarioCoordinadorZonalSesion'));
		$pdf->getDomPDF()->set_option("enable_php", true);
		
		$pdf->setPaper('A4', 'landscape'); // Tamaño de papel (puedes cambiarlo según tus necesidades)
    	$pdf->setOption('margin-top', 20); // Márgen superior en milímetros
   		$pdf->setOption('margin-right', 50); // Márgen derecho en milímetros
    	$pdf->setOption('margin-bottom', 20); // Márgen inferior en milímetros
    	$pdf->setOption('margin-left', 100); // Márgen izquierdo en milímetros

		return $pdf->stream('ver_computo_sesion.pdf');
	
	}
	
	public function ver_delegado_coordinador_pdf($id_periodo,$anio,$mes){
		
		$comisionSesionDelegado_model = new ComisionSesionDelegado(); 
		$coordinador = $comisionSesionDelegado_model->getComisionSesionDelegadoCoordinadorByIdPeriodo($id_periodo,$anio,$mes);
		
		$dias = array('L','M','M','J','V','S','D');

		$mes_ = ltrim($mes, '0');
		$mesEnLetras = $this->mesesALetras($mes_);
		
		$pdf = Pdf::loadView('pdf.ver_delegado_coordinador',compact('coordinador','anio','mesEnLetras','mes'));
		$pdf->getDomPDF()->set_option("enable_php", true);
		
		//$pdf->setPaper('A4', 'landscape'); // Tamaño de papel (puedes cambiarlo según tus necesidades)
    	$pdf->setOption('margin-top', 20); // Márgen superior en milímetros
   		$pdf->setOption('margin-right', 50); // Márgen derecho en milímetros
    	$pdf->setOption('margin-bottom', 20); // Márgen inferior en milímetros
    	$pdf->setOption('margin-left', 100); // Márgen izquierdo en milímetros

		return $pdf->stream('ver_delegado_coordinador.pdf');
	
	}
	
	function mesesALetras($mes) { 
		$meses = array('','ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SETIEMBRE','OCTUBRE','NOVIEMBRE','DICIEMBRE'); 
		return $meses[$mes];
	}
	
	public function calendario_sesion_pdf($id){
		
		$computoSesion = ComputoSesione::find($id);
		
		$comisionSesion_model = new ComisionSesione(); 
		$municipalidadSesion = $comisionSesion_model->getMunicipalidadSesion($computoSesion->id_periodo_comision,$computoSesion->anio,$computoSesion->mes);
		
		$dias = array('L','M','M','J','V','S','D');
		
		$pdf = Pdf::loadView('pdf.calendario_sesion',compact('municipalidadSesion','computoSesion','dias'));
		$pdf->getDomPDF()->set_option("enable_php", true);
		
		$pdf->setPaper('A4', 'landscape'); // Tamaño de papel (puedes cambiarlo según tus necesidades)
    	$pdf->setOption('margin-top', 20); // Márgen superior en milímetros
   		$pdf->setOption('margin-right', 50); // Márgen derecho en milímetros
    	$pdf->setOption('margin-bottom', 20); // Márgen inferior en milímetros
    	$pdf->setOption('margin-left', 100); // Márgen izquierdo en milímetros

		return $pdf->stream('calendario_sesion.pdf');
	
	}
	
	public function ver_calendario_sesion_pdf($id_periodo,$anio,$mes){
		
		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);
		ini_set('memory_limit', '-1');
		ini_set('max_execution_time', '1200');
		
		$comisionSesion_model = new ComisionSesione(); 
		
		$municipalidadSesion = $comisionSesion_model->getMunicipalidadSesion($id_periodo,$anio,$mes);
		
		$dias = array('L','M','M','J','V','S','D');
		
		$mes_ = ltrim($mes, '0');
		$mesEnLetras = $this->mesesALetras($mes_);
		
		$pdf = Pdf::loadView('pdf.ver_calendario_sesion',compact('municipalidadSesion','dias','anio','mes','mesEnLetras'));
		$pdf->getDomPDF()->set_option("enable_php", true);
		
		$pdf->setPaper('A4', 'landscape'); // Tamaño de papel (puedes cambiarlo según tus necesidades)
    	$pdf->setOption('margin-top', 20); // Márgen superior en milímetros
   		$pdf->setOption('margin-right', 50); // Márgen derecho en milímetros
    	$pdf->setOption('margin-bottom', 20); // Márgen inferior en milímetros
    	$pdf->setOption('margin-left', 100); // Márgen izquierdo en milímetros

		return $pdf->stream('ver_calendario_sesion.pdf');
	
	}
	
	public function ver_calendario_sesion_coordinador_zonal_pdf($id_periodo,$anio,$mes){
		
		$comisionSesion_model = new ComisionSesione(); 
		
		$municipalidadSesion = $comisionSesion_model->getMunicipalidadSesionCoordinadorZonal($id_periodo,$anio,$mes);
		$dias = array('L','M','M','J','V','S','D');
		
		$mes_ = ltrim($mes, '0');
		$mesEnLetras = $this->mesesALetras($mes_);
		
		$pdf = Pdf::loadView('pdf.ver_calendario_sesion_coordinador_zonal',compact('municipalidadSesion','id_periodo','dias','anio','mes','mesEnLetras'));
		$pdf->getDomPDF()->set_option("enable_php", true);
		
		$pdf->setPaper('A4', 'landscape'); // Tamaño de papel (puedes cambiarlo según tus necesidades)
    	$pdf->setOption('margin-top', 20); // Márgen superior en milímetros
   		$pdf->setOption('margin-right', 50); // Márgen derecho en milímetros
    	$pdf->setOption('margin-bottom', 20); // Márgen inferior en milímetros
    	$pdf->setOption('margin-left', 100); // Márgen izquierdo en milímetros

		return $pdf->stream('ver_calendario_sesion_coordinador_zonal.pdf');
	
	}
	
	public function eliminar_computo_sesion($id)
    {
		$computoSesion = ComputoSesione::find($id);
		$computoSesion->estado = 0;
		$computoSesion->save();

		echo $computoSesion->id;

    }
		
	public function eliminar_comision_sesion_delegados($id)
    {
		$comisionSesionDelegado = ComisionSesionDelegado::find($id);
		$comisionSesionDelegado->estado = 0;
		$comisionSesionDelegado->save();

		echo $comisionSesionDelegado->id;

    }
	
	public function eliminar_historial_comision_sesion_delegados($id)
    {
		$comisionSesionDelegadosHistorial = ComisionSesionDelegadosHistoriale::find($id);
		$comisionSesionDelegadosHistorial->estado = 0;
		$comisionSesionDelegadosHistorial->save();

		$id_comision_sesion_delegado = $comisionSesionDelegadosHistorial->id_comision_sesion_delegado;
		$comisionSesionDelegado = ComisionSesionDelegado::find($id_comision_sesion_delegado);
		$comisionSesionDelegado->id_delegado_anterior = 0;
		$comisionSesionDelegado->id_agremiado_anterior = 0;
		$comisionSesionDelegado->save();
		
		echo $comisionSesionDelegadosHistorial->id;
		

    }

	function importar_dataLicencia_dictamenes($fecha_ejecucion,$id_comision,$id_sesion){
	
		//var_dump($fecha_ejecucion);exit();

		$sesion_model = new ComisionSesione;

		$data = [];

		//$fecha_actual = Carbon::now()->format('Y-m-d');

		$equivaComision = $sesion_model->getComisionData($id_comision);

		$id_sesion = intval($id_sesion);

		$fecha_ejecucion_formateada = Carbon::createFromFormat('d-m-Y', $fecha_ejecucion)->format('Y-m-d');
		//var_dump($equivaComision[0]->id_comision_dl);exit();
		
		$dictamenes = NULL;
		if(isset($equivaComision[0]->id_comision_dl) && $equivaComision[0]->id_comision_dl>0){
			$dictamenes = $sesion_model->importar_dictamenes_dataLicencia($fecha_ejecucion_formateada,$equivaComision[0]->id_comision_dl,$id_sesion);
		}
		
		$result["dictamenes"] = $dictamenes;
		$result["aaData"] = $data;

		//var_dump($data);exit;

		echo json_encode($result);
	
	}
	
	public function eliminar_sesion($id,$estado)
    {
		$comisionSesion = ComisionSesione::find($id);
		$comisionSesion->estado = $estado;
		$comisionSesion->save();

		echo $comisionSesion->id;
    }
	
			
}
