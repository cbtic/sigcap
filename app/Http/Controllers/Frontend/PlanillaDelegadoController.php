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
use App\Models\DelegadoReintegroDetalle;
use Auth;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromArray;

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
		
		$comisionDelegado = NULL;
		
		if($id>0){
			$delegadoReintegro = DelegadoReintegro::find($id);
			$comisionDelegado = ComisionDelegado::find($delegadoReintegro->id_delegado);
		}else{
			$delegadoReintegro = new DelegadoReintegro;
		}

		$tipo_reintegro = $tablaMaestra_model->getMaestroByTipo(74);

		return view('frontend.planilla.modal_reintegro',compact('id','delegadoReintegro','region','id_regional','periodo','mes','comisionDelegado','periodo_ultimo','tipo_reintegro'/*,'delegados'*/));

    }
	
	public function obtener_delegado_periodo($id_periodo){
			
		$comisionSesionDelegado_model = new ComisionSesionDelegado;
		$comision = $comisionSesionDelegado_model->getComisionDelegadosByIdPeriodo($id_periodo);
		echo json_encode($comision);
		
	}
	
	public function obtener_comision_delegado_periodo($id_periodo,$id_agremiado){
			
		$comisionSesionDelegado_model = new ComisionSesionDelegado;
		$comision = $comisionSesionDelegado_model->getComisionDelegadosByIdPeriodoAgremiado($id_periodo,$id_agremiado);
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
		$delegadoReintegro->id_comision = $request->id_comision;
		$delegadoReintegro->id_delegado = $request->id_delegado;
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
	
	public function obtener_monto($id_tipo_reintegro,$id_comision,$id_periodo,$mes){
		
		$planillaDelegado_model = new PlanillaDelegado;
		$monto = $planillaDelegado_model->getMonto($id_tipo_reintegro,$id_comision,$id_periodo,$mes);
		
		echo json_encode($monto);
	}
	
	public function obtener_planilla_delegado(Request $request){
		
		$planillaDelegado = PlanillaDelegado::where("id_periodo_comision",$request->id_periodo_bus)->where("periodo",$request->anio)->where("mes",$request->mes)->where("estado",1)->first();
		
        $planillaDelegado_model = new PlanillaDelegado;
		
		$planilla = NULL;
		$fondo_comun = NULL;
		
		if(isset($planillaDelegado->id)){
        	$planilla = $planillaDelegado_model->getPlanillaDelegadoDetalleByIdPlanilla($planillaDelegado->id);
			$fondo_comun = $planillaDelegado_model->getSaldoDelegadoFondoComun($request->id_periodo_bus,$request->anio,$request->mes);
		}
        return view('frontend.planilla.lista_planilla_delegado',compact('planilla','fondo_comun'));

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
			array_push($variable, array($n++,$r->delegado,$r->municipalidad, $r->sesiones, number_format($r->sub_total,2),number_format($r->adelanto,2),number_format($r->reintegro,2), number_format($r->coordinador,2), number_format($r->total_bruto_sesiones,2), number_format($r->movilidad_sesion,2),number_format($r->total_movilidad,2),number_format($r->reintegro_asesor,2),number_format($r->total_bruto,2), number_format($r->ir_cuarta,2),number_format($r->total_honorario,2),number_format($r->descuento,2),number_format($r->saldo,2),$r->observaciones));
			
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
		
		array_push($variable, array("","Totales Generales","", $sesiones, number_format($sub_total,2),number_format($adelanto,2),number_format($reintegro,2), number_format($coordinador,2), number_format($total_bruto_sesiones,2), number_format($movilidad_sesion,2),number_format($total_movilidad,2),number_format($reintegro_asesor,2),number_format($total_bruto,2), number_format($ir_cuarta,2),number_format($total_honorario,2),number_format($descuento,2),number_format($saldo,2),""));
		
		$export = new InvoicesExport([$variable]);
		return Excel::download($export, 'resultado_concurso.xlsx');
		
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
