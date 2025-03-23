<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PlanillaDelegado;
use App\Models\PlanillaDelegadoDetalle;
use App\Models\DelegadoReintegro;
use App\Models\PeriodoComisione;
use App\Models\ComisionDelegado;
use App\Models\Regione;
use App\Models\ComisionSesionDelegado;
use App\Models\TablaMaestra;
use App\Models\Agremiado;
use App\Models\Comisione;
use App\Models\DelegadoReintegroDetalle;
use Auth;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromArray;
use App\Models\ComputoSesione;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class PlanillaDelegadoController extends Controller
{
	
	public function consulta_planilla_delegado(){
		
		$periodoComisione_model = new PeriodoComisione;
		
		$anio = range(date('Y'), date('Y') - 20); 
		$mes = [
            '01' => 'Enero', '02' => 'Febrero', '03' => 'Marzo',
            '04' => 'Abril', '05' => 'Mayo', '06' => 'Junio',
            '07' => 'Julio', '08' => 'Agosto', '09' => 'Septiembre',
            '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre',
        ];
		
		$periodo = $periodoComisione_model->getPeriodoAll();
		$periodo_ultimo = PeriodoComisione::where("estado",1)->orderBy("id","desc")->first();
		$periodo_activo = PeriodoComisione::where("estado",1)->where("activo",1)->orderBy("id","desc")->first();
		
		return view('frontend.planilla.consulta_planilla_delegado',compact('periodo','anio','mes','periodo_ultimo','periodo_activo'));
		
    }
	
	public function obtener_anio_periodo($id_periodo){
			
		$periodoComisione_model = new PeriodoComisione;
		$periodoComision = PeriodoComisione::find($id_periodo);
		$anio = $periodoComisione_model->getAnioByFecha($periodoComision->fecha_inicio,$periodoComision->fecha_fin);
		echo json_encode($anio);
		
	}
	
	public function consulta_reintegro(){

		$tablaMaestra_model = new TablaMaestra;

		$tipo_reintegro = $tablaMaestra_model->getMaestroByTipo(74);
		$mes = $tablaMaestra_model->getMaestroByTipo(116);
		
		return view('frontend.planilla.all_reintegro',compact('tipo_reintegro','mes'));
		
    }
	
	public function listar_reintegro_ajax(Request $request){
	
		$delegadoReintegro_model = new DelegadoReintegro();
		$p[]=$request->numero_cap;
		$p[]=$request->agremiado;
		$p[]="";
		$p[]=$request->mes_reintegro;
		$p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $delegadoReintegro_model->listar_reintegro_ajax($p);
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
	
	public function modal_reintegro($id){
		
		$id_user = Auth::user()->id;
		
		$periodoComision_model = new PeriodoComisione;
		$regione_model = new Regione;
		$comisionSesionDelegado_model = new ComisionSesionDelegado;
		$tablaMaestra_model = new TablaMaestra;
		$agremiado_model = new Agremiado;
		//$comision_model = new Comisione;
		
		$periodo = $periodoComision_model->getPeriodoAll();
		$periodo_ultimo = PeriodoComisione::where("activo",1)->orderBy("id","desc")->first();
		$region = $regione_model->getRegionAll();
		$id_regional="5";
		
		$mes = [
            '01' => 'Enero', '02' => 'Febrero', '03' => 'Marzo',
            '04' => 'Abril', '05' => 'Mayo', '06' => 'Junio',
            '07' => 'Julio', '08' => 'Agosto', '09' => 'Septiembre',
            '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre',
        ];
		
		//$delegados = $comisionSesionDelegado_model->getComisionDelegadosByIdComision(0);
		$agremiados = $agremiado_model->getAgremiadoRLAll();
		//$comisiones = $comision_model->getComisionByPeriodo();
		
		$comisionDelegado = NULL;
		
		if($id>0){
			$delegadoReintegro = DelegadoReintegro::find($id);
			$comisionDelegado = ComisionDelegado::find($delegadoReintegro->id_delegado);
		}else{
			$delegadoReintegro = new DelegadoReintegro;
		}

		$tipo_reintegro = $tablaMaestra_model->getMaestroByTipo(74);

		return view('frontend.planilla.modal_reintegro',compact('id','delegadoReintegro','region','id_regional','periodo','mes','comisionDelegado','periodo_ultimo','tipo_reintegro'/*,'delegados'*/,'agremiados'));

    }
	
	public function obtener_delegado_periodo($id_periodo){
		
		$comisionSesionDelegado_model = new ComisionSesionDelegado;
		$comision = $comisionSesionDelegado_model->getComisionDelegadosByIdPeriodoReintegro($id_periodo);
		echo json_encode($comision);
		
	}
	
	public function obtener_comision_delegado_periodo($id_periodo,$id_agremiado){
			
		$comisionSesionDelegado_model = new ComisionSesionDelegado;
		$comision = $comisionSesionDelegado_model->getComisionDelegadosByIdPeriodoAgremiado2($id_periodo,$id_agremiado);
		echo json_encode($comision);
		
	}
	
	public function send_reintegro(Request $request){
		$id_user = Auth::user()->id;
		
		if($request->id == 0){
			$delegadoReintegro = new DelegadoReintegro;
			$reintegroDetalle = new DelegadoReintegroDetalle;
		}else{
			$delegadoReintegro = DelegadoReintegro::find($request->id);
			$reintegroDetalle = new DelegadoReintegroDetalle;
			//$reintegroDetalle = DelegadoReintegroDetalle::where("id_delegado_reintegro",$delegadoReintegro->id)->where("estado","1")->first();
		}
		
		$delegadoReintegro->id_regional = $request->id_regional;
		$delegadoReintegro->id_periodo = $request->id_periodo;
		//$delegadoReintegro->id_mes = $request->id_mes;
		$delegadoReintegro->id_mes_ejecuta_reintegro = $request->id_mes_ejecuta_reintegro;
		//$delegadoReintegro->anio_reintegro = $request->anio;
		//$delegadoReintegro->porcentaje = $request->porcentaje;
		$delegadoReintegro->id_comision = $request->id_comision;
		$delegadoReintegro->id_delegado = $request->id_delegado; //Se envia el id_agremiado a la columna id_delegado de reintegro
		$delegadoReintegro->porcentaje = $request->porcentaje;
		$delegadoReintegro->anio_reintegro = $request->anio;
		//$delegadoReintegro->importe_total = $request->id_delegado;
		//$delegadoReintegro->id_tipo_reintegro = $request->id_tipo_reintegro;
		//$delegadoReintegro->cantidad = $request->cantidad;
		//$delegadoReintegro->importe = $request->importe;
		$delegadoReintegro->observacion = $request->observacion;
		$delegadoReintegro->id_usuario_inserta = $id_user;
		$delegadoReintegro->save();

		$reintegroDetalle->id_delegado_reintegro=$delegadoReintegro->id;
		$reintegroDetalle->id_mes = $request->id_mes;
		$reintegroDetalle->id_tipo_reintegro = $request->id_tipo_reintegro;
		$reintegroDetalle->cantidad = $request->cantidad;
		$reintegroDetalle->importe = $request->importe;
		$reintegroDetalle->id_usuario_inserta = $id_user;
		$reintegroDetalle->save();

		$delegadoReintegro->importe_total += $request->importe;
    	$delegadoReintegro->save();
		
		$delegadoReintegro_model = new DelegadoReintegro;
		
		$delegadoReintegro_model->actualizaImporteTotalReintegro($delegadoReintegro->id);
		
		echo $delegadoReintegro->id;

    }

	public function eliminar_reintegro($id,$estado)
    {
		$delegadoReintegro = DelegadoReintegro::find($id);
		$delegadoReintegro->estado = $estado;
		$delegadoReintegro->save();
		if($estado==0){
			$reintegroDetalle = DelegadoReintegroDetalle::where("id_delegado_reintegro",$delegadoReintegro->id)->update(['estado'=>0]);
		}else{
			$reintegroDetalle = DelegadoReintegroDetalle::where("id_delegado_reintegro",$delegadoReintegro->id)->update(['estado'=>1]);
		}
		
		echo $delegadoReintegro->id;
    }

	public function obtener_datos_reintegro_detalle($id_agremiado){

        $reintegroDetalle_model = new DelegadoReintegroDetalle;
        $sw = true;
        $reintegro_detalle_lista = $reintegroDetalle_model->getReintegroDetalle($id_agremiado);
        //print_r($parentesco_lista);exit();
        return view('frontend.planilla.lista_datos_reintegro_detalle',compact('reintegro_detalle_lista'));

    }
	
	public function obtener_monto($id_tipo_reintegro,$id_comision,$id_periodo,$anio,$mes,$porcentaje){
		
		$planillaDelegado_model = new PlanillaDelegado;
		$monto = $planillaDelegado_model->getMonto($id_tipo_reintegro,$id_comision,$id_periodo,$anio,$mes,$porcentaje);
		
		echo json_encode($monto);
	}
	
	public function obtener_planilla_delegado(Request $request){
		
		$planillaDelegado = PlanillaDelegado::where("id_periodo_comision",$request->id_periodo_bus)->where("periodo",$request->anio)->where("mes",$request->mes)->where("estado",1)->first();
		
        $planillaDelegado_model = new PlanillaDelegado;
		
		$planilla = NULL;
		$fondo_comun = NULL;
		$computoSesion = NULL;
		if(isset($planillaDelegado->id)){
        	$planilla = $planillaDelegado_model->getPlanillaDelegadoDetalleByIdPlanilla($planillaDelegado->id);
			$fondo_comun = $planillaDelegado_model->getSaldoDelegadoFondoComun($request->id_periodo_bus,$request->anio,$request->mes);
			$computoSesion = ComputoSesione::find($planillaDelegado->id_computo_sesion);
		}
        return view('frontend.planilla.lista_planilla_delegado',compact('planilla','fondo_comun','computoSesion'));

    }
	
	public function send_planilla_delegado(Request $request){
		//exit();
		$msg = true;
		$planillaDelegadoExiste = PlanillaDelegado::where("id_periodo_comision",$request->id_periodo_bus)->where("periodo",$request->anio)->where("mes",$request->mes)->where("estado",1)->first();
		
		if($planillaDelegadoExiste){
			$msg = false;
		}else{
			$planillaDelegado_model = new PlanillaDelegado;
			$planillaDelegado_model->generar_planilla_delegado($request->id_periodo_bus,$request->anio,$request->mes);
		}
		
		return $msg;
		
	}
	
	public function eliminar_planilla_delegado(Request $request){
		/*
		$msg = "";
		$planillaDelegadoExiste = PlanillaDelegado::where("id_periodo_comision",$request->id_periodo_bus)->where("periodo",$request->anio)->where("mes",$request->mes)->where("estado",1)->first();
		*/
		//if($planillaDelegadoExiste){
			//$msg = false;
		//}else{
			$planillaDelegado_model = new PlanillaDelegado;
			$planillaDelegado_model->eliminar_planilla_delegado($request->id_periodo_bus,$request->anio,$request->mes);
		
			//return $planillaDelegado_model;
			//}
		
		//return $msg;
		
	}
	
	public function consulta_planilla_recibos_honorario(){
		
		$periodoComisione_model = new PeriodoComisione;
		$planillaDelegadoDetalle = new PlanillaDelegadoDetalle;
		$agremiado = new Agremiado;
		$tablaMaestra_model = new TablaMaestra;
		
		
		$anio = range(date('Y'), date('Y') - 20); 
		$mes = [
            '01' => 'Enero', '02' => 'Febrero', '03' => 'Marzo',
            '04' => 'Abril', '05' => 'Mayo', '06' => 'Junio',
            '07' => 'Julio', '08' => 'Agosto', '09' => 'Septiembre',
            '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre',
        ];
		
		$periodo = $periodoComisione_model->getPeriodoAll();
		$periodo_ultimo = PeriodoComisione::where("estado",1)->orderBy("id","desc")->first();
		$periodo_activo = PeriodoComisione::where("estado",1)->where("activo",1)->orderBy("id","desc")->first();
		$tipo_comprobante = $tablaMaestra_model->getMaestroByTipo(103);
		$situacion = $tablaMaestra_model->getMaestroByTipo(14);

		return view('frontend.planilla.consulta_planilla_recibos_honorario',compact('periodo','anio','mes','periodo_ultimo','periodo_activo','planillaDelegadoDetalle','tipo_comprobante','agremiado','situacion'));
		
    }

	public function listar_recibo_honorario_ajax(Request $request){
	
		$planillaDelegadoDetalle_model = new PlanillaDelegadoDetalle();
		$p[]=$request->periodo;
		$p[]=$request->anio;
		$p[]=$request->mes;
		$p[]=$request->numero_cap;
		$p[]=$request->agremiado;
		$p[]=$request->municipalidad;
		$p[]=$request->situacion;
		$p[]=$request->numero_comprobante;
		$p[]=$request->fecha_inicio;
		$p[]=$request->fecha_fin;
		$p[]=$request->provision;
		$p[]=$request->cancelacion;
		$p[]=$request->grupo;
		$p[]=$request->tiene_ruc;
		$p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $planillaDelegadoDetalle_model->listar_recibo_honorario_ajax($p);
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

	public function obtener_datos_recibo($id){

		$planillaDelegadoDetalle_model = new PlanillaDelegadoDetalle;
		$datosRecibo = $planillaDelegadoDetalle_model->getDatosRecibo($id);
		echo json_encode($datosRecibo);

	}

	public function modal_recibo($id){
		
		$id_user = Auth::user()->id;
		
		$planillaDelegadoDetalle_model = new PlanillaDelegadoDetalle;
		$datosRecibo = $planillaDelegadoDetalle_model->getDatosRecibo($id);

		//if($id>0) $datosRecibo = PlanillaDelegadoDetalle::find($id);else $datosRecibo = new PlanillaDelegadoDetalle;

		//print_r($datosRecibo); exit();

		//print_r($datosRecibo[0]->id_agremiado); exit();

		//$id_agremiado = $datosRecibo[0]->id_agremiado;

		//$agremiado = new Agremiado;
		//$agremiado = Agremiado::find($id_agremiado);


		return view('frontend.planilla.modal_recibo',compact('id','datosRecibo', 'id_user'));
	}		

	public function send_recibo_honorario(Request $request){

/*
		$planilla_detalle = PlanillaDelegadoDetalle::where('id_grupo',1)->where('estado','1')->get();

		foreach($planilla_detalle as $row){
			print_r($row->id);

		}
*/
	//	print_r($request->numero_comprobante); exit();

		
		
		$id_user = Auth::user()->id;

		//$id = $request->id_recibo;
		$id = $request->id;

		$planillaDelegadoDetalle = PlanillaDelegadoDetalle::find($id);
			
		$planillaDelegadoDetalle->tipo_comprobante = $request->tipo_comprobante;
		$planillaDelegadoDetalle->numero_comprobante = $request->numero_comprobante;
		$planillaDelegadoDetalle->fecha_comprobante = $request->fecha_comprobante;
		$planillaDelegadoDetalle->fecha_vencimiento = $request->fecha_vencimiento;			
		$planillaDelegadoDetalle->cancelado = $request->cancelado;

		//echo($planillaDelegadoDetalle->secuencua_vou);


		if ($planillaDelegadoDetalle->secuencua_vou==Null){			
			$planillaDelegadoDetalle_model = new PlanillaDelegadoDetalle();
			$data = $planillaDelegadoDetalle_model->secuencua_vou($request->id_periodo_comision, $request->periodo, $request->mes);
			
			//echo($data[0]->secuencia);
			$planillaDelegadoDetalle->secuencua_vou = $data[0]->secuencia;
			
		}
		//exit();


		$planillaDelegadoDetalle->save();

		if ($request->selTipo=='S'){

			$planillaDelegadoDetalle = PlanillaDelegadoDetalle::find($id);
			$planillaDelegadoDetalle->numero_operacion = $request->numero_operacion;
			$planillaDelegadoDetalle->fecha_operacion= $request->fecha_operacion;
			$planillaDelegadoDetalle->id_usuario_inserta = $id_user;


			$planillaDelegadoDetalle->save();

		}else if ($request->selTipo=='T'){
			$planillaDelegadoDetalle_model = new PlanillaDelegadoDetalle();
			$data = $planillaDelegadoDetalle_model->actualizarReciboHonorario($request->id_periodo_comision, $request->periodo, $request->mes,
			$request->id_grupo, $request->cancelado,$request->numero_operacion,$request->fecha_operacion, $id_user);	
		}



		//echo json_encode($data);
		
    }

	public function generar_asiento_planilla(Request $request){

		$asiento = $request->asiento;
		
		
        $planillaDelegado_model = new PlanillaDelegado;
		
		$fondo_comun = $planillaDelegado_model->getGenerarAsientoPlanilla($asiento, $request->id_periodo_bus,$request->anio,$request->mes);

    }
	
	public function exportar_planilla_delegado($periodo,$anio,$mes) {
		
		if($periodo==0)$periodo = "";
		if($anio==0)$anio = "";
		if($mes==0)$mes = "";
		
		$planillaDelegado = PlanillaDelegado::where("id_periodo_comision",$periodo)->where("periodo",$anio)->where("mes",$mes)->where("estado",1)->first();
		
		$planillaDelegado_model = new PlanillaDelegado;
		$planilla = $planillaDelegado_model->getPlanillaDelegadoDetalleByIdPlanilla($planillaDelegado->id);
		$fondo_comun = $planillaDelegado_model->getSaldoDelegadoFondoComun($periodo,$anio,$mes);
		
		$variable = [];
		$n = 1;
		
		array_push($variable, array("N","Delegado","Municipio","Sesiones", "Sub Total", "Adelanto \nCon Rec. \nHon.", "(+) \nReintegro", "(+) Adicional \npor \nCoordinador", "Total \nHonorario \nBruto por \nSesiones", "Movilidad \nPor Sesion \nRegular", "Total \nHonorario por \nMovilidad","Reintegro \npor Pago a Asesores \nAsumido por el CAP RL","Total Honorario \nBruto","I.R. 4TA \n8.00 %","Total Honorario \nNeto","Dscto","Saldo",utf8_encode("OBSERVACI�N")));
		
		$sesiones=0;
		$sesiones_asesor=0;
		$sub_total=0;
		$adelanto=0;
		$reintegro=0;
		$coordinador=0;
		$total_bruto_sesiones=0;
		$movilidad_sesion=0;
		$total_movilidad=0;
		$reintegro_asesor=0;
		$total_bruto=0;
		$ir_cuarta=0;
		$total_honorario=0;
		$descuento=0;
		$saldo=0;
		
		foreach($planilla as $r) {
			array_push($variable, array($n++,$r->delegado,$r->municipalidad, $r->sesiones, number_format($r->sub_total,2,".",""),number_format($r->adelanto,2,".",""),number_format($r->reintegro,2,".",""), number_format($r->coordinador,2,".",""), number_format($r->total_bruto_sesiones,2,".",""), number_format($r->movilidad_sesion,2,".",""),number_format($r->total_movilidad,2,".",""),number_format($r->reintegro_asesor,2),number_format($r->total_bruto,2,".",""), number_format($r->ir_cuarta,2,".",""),number_format($r->total_honorario,2,".",""),number_format($r->descuento,2,".",""),number_format($r->saldo,2,".",""),$r->observaciones));
			
			$sesiones+=$r->sesiones;
			$sub_total+=$r->sub_total;
			$adelanto+=$r->adelanto;
			$reintegro+=$r->reintegro;
			$coordinador+=$r->coordinador;
			$total_bruto_sesiones+=$r->total_bruto_sesiones;
			$movilidad_sesion+=$r->movilidad_sesion;
			
			$total_movilidad+=$r->total_movilidad;
			$reintegro_asesor+=$r->reintegro_asesor;
			$total_bruto+=$r->total_bruto;
			$ir_cuarta+=$r->ir_cuarta;
			$total_honorario+=$r->total_honorario;
			$descuento+=$r->descuento;
			$saldo+=$r->saldo;
			
			if($r->reintegro_asesor>0){
				$sesiones_asesor++;
			}
			
		}
		
		array_push($variable, array("","Totales Generales","", $sesiones, number_format($sub_total,2,".",""),number_format($adelanto,2,".",""),number_format($reintegro,2,".",""), number_format($coordinador,2,".",""), number_format($total_bruto_sesiones,2,".",""), number_format($movilidad_sesion,2,".",""),number_format($total_movilidad,2,".",""),number_format($reintegro_asesor,2,".",""),number_format($total_bruto,2,".",""), number_format($ir_cuarta,2,".",""),number_format($total_honorario,2,".",""),number_format($descuento,2,".",""),number_format($saldo,2,".",""),""));
		
		$sesiones_asesor = 0.5 * $sesiones_asesor;
		$fondo_comun_saldo = (isset($fondo_comun->saldo))?$fondo_comun->saldo:0;
		$fondo_comun_neto = ($fondo_comun_saldo) - $reintegro - $total_movilidad - $coordinador;
		$total_sesiones = $sesiones - $sesiones_asesor;
		
		$importe_por_sesion=0;
		if($total_sesiones>0)$importe_por_sesion = $fondo_comun_neto / $total_sesiones;
		
		array_push($variable, array("","","", "", "","","", "", "", "","","","", "","","","",""));
		array_push($variable, array("","Saldo a favor de los Delegados Pro Fondo Comun","", number_format($fondo_comun_saldo,2,".",""), "","","", "", "", "","","","", "","Fondo Comun","",number_format($fondo_comun_neto,2,".",""),""));
		array_push($variable, array("","Menos Pagos a Destiempo de Meses pasados","", number_format($reintegro,2,".",""), "","","", "", "", "","","","", "","Total acumulado de Sesiones del Mes","",$sesiones,""));
		array_push($variable, array("","Menos movilidad a Delegados","", number_format($total_movilidad,2,".",""), "","","", "", "", "","","","", "","Sesion de asesores a cargo del CAP RL","",$sesiones_asesor,""));
		array_push($variable, array("","Menos Pago Fijo a Coordinadores","", number_format($coordinador,2,".",""), "","","", "", "", "","","","", "","SALDO FINAL DE SESIONES","",$total_sesiones,""));
		array_push($variable, array("","Monto Neto = Fondo Comun","", number_format($fondo_comun_neto,2,".",""), "","","", "", "", "","","","", "","Importe por Sesion","",number_format($importe_por_sesion,2,".",""),""));
		
		$export = new InvoicesExport([$variable]);
		return Excel::download($export, 'planilla_delegado.xlsx');
		
    }
	
	
	public function ver_planilla_delegado_pdf($id_periodo,$anio,$mes){
		/*
		$movilidad_model = new ComisionMovilidade;
		
		$movilidad = $movilidad_model->getMovilidadByPeriodo($id_periodo,$anio,$mes);
		
		$dias = array('L','M','M','J','V','S','D');
		$mes_ = ltrim($mes, '0');
		$mesEnLetras = $this->mesesALetras($mes_);
		*/

		$planillaDelegado = PlanillaDelegado::where("id_periodo_comision",$id_periodo)->where("periodo",$anio)->where("mes",$mes)->where("estado",1)->first();

        $planillaDelegado_model = new PlanillaDelegado;

		$planilla = NULL;
		$fondo_comun = NULL;
		$computoSesion = NULL;
		if(isset($planillaDelegado->id)){
        	$planilla = $planillaDelegado_model->getPlanillaDelegadoDetalleByIdPlanilla($planillaDelegado->id);
			$fondo_comun = $planillaDelegado_model->getSaldoDelegadoFondoComun($id_periodo,$anio,$mes);
			$computoSesion = ComputoSesione::find($planillaDelegado->id_computo_sesion);
		}
        //return view('frontend.planilla.lista_planilla_delegado',compact('planilla','fondo_comun','computoSesion'));

		$pdf = Pdf::loadView('pdf.ver_planilla_delegado',compact('planilla','fondo_comun','computoSesion','anio','mes'));
		$pdf->getDomPDF()->set_option("enable_php", true);

		$pdf->setPaper('A4', 'landscape'); // Tama�o de papel (puedes cambiarlo seg�n tus necesidades)
    	$pdf->setOption('margin-top', 20); // M�rgen superior en mil�metros
   		$pdf->setOption('margin-right', 50); // M�rgen derecho en mil�metros
    	$pdf->setOption('margin-bottom', 20); // M�rgen inferior en mil�metros
    	$pdf->setOption('margin-left', 100); // M�rgen izquierdo en mil�metros

		return $pdf->stream('ver_planilla_delegado.pdf');

	}

	public function eliminar_recibo_honorario($id,$estado)
    {
		$id_user = Auth::user()->id;
		$planillaDelegadoDetalle = PlanillaDelegadoDetalle::find($id);
		$planillaDelegadoDetalle->numero_comprobante = null;
		$planillaDelegadoDetalle->fecha_comprobante = null;
		$planillaDelegadoDetalle->cancelado = 0;
		$planillaDelegadoDetalle->numero_operacion = null;
		$planillaDelegadoDetalle->fecha_operacion = null;
		$planillaDelegadoDetalle->id_usuario_inserta = $id_user;

		$planillaDelegadoDetalle->save();

		echo $planillaDelegadoDetalle->id;
    }
	
	public function obtener_anio_reintegro($periodo){

		$periodo_actual = PeriodoComisione::find($periodo);

		$incio_periodo = Carbon::parse($periodo_actual->fecha_inicio);
		$fin_periodo = Carbon::parse($periodo_actual->fecha_fin);

		$period = CarbonPeriod::create($incio_periodo,'1 year', $fin_periodo);

		$anios = [];

		foreach($period as $anio){
			$anios[] = $anio->year;
		}

		//dd($anios);exit();
		echo json_encode($anios);

	}
	
	public function obtener_comisiones($periodo){

		$comision_model = new Comisione;

		$comisiones = $comision_model->getComisionByPeriodo($periodo, '1');

		//dd($anios);exit();
		echo json_encode($comisiones);

	}

	public function exportar_listar_recibo_honorario($periodo, $anio, $mes, $numero_cap, $agremiado, $municipalidad, $fecha_inicio, $fecha_fin, $provision, $cancelacion, $ruc) {
		if($periodo==0)$periodo = "";
		if($anio==0)$anio = "";
		if($mes==0)$mes = "";
		if($numero_cap==0)$numero_cap = "";
		if($agremiado=="0")$agremiado = "";
		if($municipalidad=="0")$municipalidad = "";
		if($fecha_inicio=="0")$fecha_inicio = "";
		if($fecha_fin=="0")$fecha_fin = "";
		if($provision=="0")$provision = "";
		if($cancelacion=="0")$cancelacion = "";
		if($ruc=="0")$ruc = "";
		//if($estado==0)$estado = "";
		//var_dump($agremiado);exit();
		$planillaDelegadoDetalle_model = new PlanillaDelegadoDetalle();
		$p[]=$periodo;
		$p[]=$anio;
		$p[]=$mes;
		$p[]=$numero_cap;
		$p[]=$agremiado;
		$p[]=$municipalidad;
		$p[]="";
		$p[]="";
		$p[]=$fecha_inicio;
		$p[]=$fecha_fin;
		$p[]=$provision;
		$p[]=$cancelacion;
		$p[]="";
		$p[]=$ruc;
		$p[]=1;
		$p[]=1;
		$p[]=10000;
		$data = $planillaDelegadoDetalle_model->listar_recibo_honorario_ajax($p);
	
		$variable = [];
		$n = 1;
		//array_push($variable, array("SISTEMA CAP"));
		//array_push($variable, array("CONSULTA DE CONCURSO","","","",""));
		array_push($variable, array("N","Numero CAP","Nombre","RUC","Municipalidad","Situacion", "Numero Comprobante", "Fecha Comprobante", "Fecha Vencimiento", "Abonado", "N° Operacion", "Fecha Operacion", "Grupo", "Asiento Provision", "Asiento Cancelacion"));
		
		foreach ($data as $r) {
			//$nombres = $r->apellido_paterno." ".$r->apellido_materno." ".$r->nombres;
			if($r->cancelado==0)$cancelado='No';
			if($r->cancelado==1)$cancelado='Si';
			array_push($variable, array($n++,$r->numero_cap, $r->agremiado, $r->ruc, $r->municipalidad,$r->situacion,$r->numero_comprobante, $r->fecha_comprobante, $r->fecha_vencimiento, $cancelado, $r->numero_operacion, $r->fecha_operacion, $r->id_grupo, $r->provision, $r->cancelacion));
		}
		
		
		$export = new InvoicesExport([$variable]);
		return Excel::download($export, 'reporte_recibo_honorarios_delegados.xlsx');
		
    }
}

class InvoicesExport implements FromArray
	{
    	protected $invoices;

    	public function __construct(array $invoices)
    	{
        	$this->invoices = $invoices;
    	}

    	public function array(): array
    	{
        	return $this->invoices;
    	}
}
