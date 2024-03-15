<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Persona;
use App\Models\Agremiado;
use App\Models\TablaMaestra;
use App\Models\AgremidoCuota;
use App\Models\CajaIngreso;
use App\Models\Valorizacione;
use App\Models\Concepto;
use App\Models\ProntoPago;
use App\Models\Fraccionamiento;
use Illuminate\Support\Carbon;
use App\Models\Empresa;
use App\Models\Beneficiario;
use App\Models\Comprobante;

use Auth;

class IngresoController extends Controller
{

    public function __construct(){

		$this->middleware(function ($request, $next) {
			if(!Auth::check()) {
                return redirect('login');
            }
			return $next($request);
    	});
	}
       
    public function create(){      
         
		$id_user = Auth::user()->id;
        $persona = new Persona;
        $caja_model = new TablaMaestra;
        $caja_ingreso_model = new CajaIngreso();
        //$pronto_pago_model = new ProntoPago;

        $caja = $caja_model->getCaja('91');
        $caja_usuario = $caja_ingreso_model->getCajaIngresoByusuario($id_user,'91');
        $tipo_documento = $caja_model->getMaestroByTipo(16);
        $pronto_pago = ProntoPago::where("estado","1")->first();
                
        $concepto = Concepto::find(26411); //CUOTA GREMIAL

        //$caja_usuario = $caja_model;
        //print_r($concepto);exit();

        return view('frontend.ingreso.create',compact('persona','caja','caja_usuario','tipo_documento','pronto_pago', 'concepto'));

    }

    public function obtener_valorizacion($tipo_documento,$id_persona){
 
        $valorizaciones_model = new Valorizacione;
        $sw = true;
        //$valorizacion = $valorizaciones_model->getValorizacion($tipo_documento,$id_persona);
        //print_r($valorizacion);exit();
        return view('frontend.ingreso.lista_valorizacion',compact('valorizacion'));

    }

    public function listar_valorizacion(Request $request){

        $id_persona = $request->id_persona;
        
        $tipo_documento = $request->tipo_documento;

       //echo($tipo_documento);exit();

        if($tipo_documento=="79")$id_persona = $request->empresa_id;

        $periodo = $request->cboPeriodo_b;
        $tipo_couta = $request->cboTipoCuota_b;
        $concepto = $request->cboTipoConcepto_b;
        $filas = $request->cboFilas;
        // print_r($filas);exit();
        $valorizaciones_model = new Valorizacione;
        $sw = true;
        $valorizacion = $valorizaciones_model->getValorizacion($tipo_documento,$id_persona,$periodo,$tipo_couta,$concepto,$filas);
       
       
        return view('frontend.ingreso.lista_valorizacion',compact('valorizacion'));

    }
 
    public function listar_valorizacion_concepto(Request $request){
        $id_persona = $request->id_persona;
        $tipo_documento = $request->tipo_documento;
        if($tipo_documento=="79")$id_persona = $request->empresa_id;
        $valorizaciones_model = new Valorizacione;
        $resultado = $valorizaciones_model->getValorizacionConcepto($tipo_documento,$id_persona);
    /*
        $valorizaciones_model = new Valorizacione;
        $periodo = $valorizaciones_model->getPeridoValorizacion($tipo_documento,$id_persona);
*/
        //print_r($valorizacion);exit();
		return $resultado;

    }
    
    public function listar_valorizacion_periodo(Request $request){
        $id_persona = $request->id_persona;
        $tipo_documento = $request->tipo_documento;
        if($tipo_documento=="79")$id_persona = $request->empresa_id;
        
        $valorizaciones_model = new Valorizacione;
        $resultado = $valorizaciones_model->getPeridoValorizacion($tipo_documento,$id_persona);

        //print_r($resultado);exit();
		return $resultado;

    }


    public function obtener_pago($tipo_documento,$id_persona){       
        $valorizaciones_model = new Valorizacione;
        $sw = true;
        $pago = $valorizaciones_model->getPago($tipo_documento,$id_persona);
        return view('frontend.ingreso.lista_pago',compact('pago'));

    }

    public function sendCaja(Request $request)
    {
        $valorizaciones_model = new Valorizacione;
		$id_user = Auth::user()->id;
        $datos[] = $request->accion;
        $datos[] = $id_user;
		
		$datos[] = $request->id_caja_ingreso;
        $datos[] = $request->id_caja;
        $datos[] = ($request->saldo_inicial=='')?0:$request->saldo_inicial;
        $datos[] = ($request->total_recaudado=='')?0:$request->total_recaudado;
        $datos[] = ($request->saldo_total=='')?0:$request->saldo_total;
		
        $datos[] = $request->estado;
        //print_r($datos);
        $id_caja_ingreso = $valorizaciones_model->registrar_caja_ingreso($datos);
        echo $id_caja_ingreso;
		
		//Session::put('id_caja', $request->id_caja);
        
    }

    public function sendCajaMoneda(Request $request)
    {
        $valorizaciones_model = new Valorizacione;
		$id_user = Auth::user()->id;
        $datos[] = $request->accion;
        $datos[] = $id_user;
		
		$datos[] = $request->id_caja_ingreso_soles;
        $datos[] = $request->id_caja_soles;
        $datos[] = ($request->saldo_inicial_soles=='')?0:$request->saldo_inicial_soles;
        $datos[] = ($request->total_recaudado_soles=='')?0:$request->total_recaudado_soles;
        $datos[] = ($request->saldo_total_soles=='')?0:$request->saldo_total_soles;
		
		$datos[] = $request->id_caja_ingreso_dolares;
        $datos[] = $request->id_caja_dolares;
        $datos[] = ($request->saldo_inicial_dolares=='')?0:$request->saldo_inicial_dolares;
        $datos[] = ($request->total_recaudado_dolares=='')?0:$request->total_recaudado_dolares;
        $datos[] = ($request->saldo_total_dolares=='')?0:$request->saldo_total_dolares;
		
        $datos[] = $request->estado;
        //print_r($datos);
        $id_caja_ingreso = $valorizaciones_model->registrar_caja_ingreso_moneda($datos);
        echo $id_caja_ingreso;
		
		//Session::put('id_caja', $request->id_caja);
        
    }

    public function modal_otro_pago($periodo, $id_persona, $id_agremiado, $tipo_documento){

        
        $conceptos_model = new Concepto;        
        $conceptos = $conceptos_model->getConceptoPeriodo($periodo);

    
		
		return view('frontend.ingreso.modal_otro_pago',compact('conceptos','periodo','id_persona','id_agremiado','tipo_documento' ));
	}

    public function modal_fraccionar($idConcepto, $id_persona, $id_agremiado, $total_fraccionar ){

        $concepto = Concepto::find($idConcepto);

        //$concepto = json_encode($concepto_model);

        //print_r(json_encode($concepto)); exit();
		
		return view('frontend.ingreso.modal_fraccionar',compact('concepto','total_fraccionar','id_persona','id_agremiado' ));
	}

    public function modal_fraccionamiento(Request $request){

        $id_concepto = $request->idConcepto;
       // print_r($id_concepto); exit();

        $id_persona = $request->id_persona;
        $id_agremiado = $request->id_agremiado;
        $total_fraccionar = $request->total;
        

        $comprobante_detalle = $request->comprobante_detalle;
        $ind = 0;

       
        $tipo_documento = $request->tipo_documento;
        if($tipo_documento=="79")$id_persona = $request->empresa_id;

        $periodo = "";
        $tipo_couta = "1";
        $concepto = $request->cboTipoConcepto_b;
        $filas = "10000";

        $valorizaciones_model = new Valorizacione;
        $sw = true;
        $valorizacion = $valorizaciones_model->getValorizacion_total($tipo_documento,$id_persona,$id_concepto);
  

        foreach($request->comprobante_detalles as $key=>$det){
            
            $comprobanted[$ind] = $comprobante_detalle[$key];
            $ind++;
        }

        //print_r($comprobanted); exit();
        $concepto = Concepto::find($id_concepto);
        
        //$comprobanted = json_encode($comprobanted_);

        //print_r($total_fraccionar); exit();
    
		return view('frontend.ingreso.modal_fraccionar',compact('concepto','total_fraccionar','id_persona','id_agremiado','comprobanted', 'valorizacion' ));
	}
    

    public function obtener_conceptos($perido){

        $conceptos_model = new Concepto;        
        $conceptos = $conceptos_model->getConceptoPeriodo($perido);
        //print_r($conceptos);exit();
        return view('frontend.ingreso.lista_conceptos',compact('conceptos'));

    }

    public function send_concepto(Request $request){
        $msg = "";
        $id_user = Auth::user()->id;
        $id_persona = $request->id_persona;
        $tipo_documento = $request->tipo_documento;
        $id_agremiado = $request->id_agremiado;

       // print_r($id_persona); exit();

        //if($tipo_documento=="79")$id_persona = $request->empresa_id;
            
        $concepto_detalle = $request->concepto_detalle;
        $ind = 0;
        foreach($request->concepto_detalles as $key=>$det){
            $conceptod[$ind] = $concepto_detalle[$key];
            $ind++;
        }

        foreach ($conceptod as $key => $value) {

            //$id_val = $value['id'];
            //echo( $id_val);

            $valorizacion = new Valorizacione;
            $valorizacion->id_modulo = 5;
            $valorizacion->pk_registro = 0;
            $valorizacion->id_concepto = $value['id'];
            if($tipo_documento=="79"){
                $valorizacion->id_empresa = $id_persona;    
            }else{
                $valorizacion->id_agremido = $id_agremiado;
                $valorizacion->id_persona = $id_persona;
                    
            }
            $valorizacion->monto = $value['importe'];
            $valorizacion->id_moneda = $value['id_moneda'];
            $valorizacion->fecha = Carbon::now()->format('Y-m-d');
            $valorizacion->fecha_proceso = Carbon::now()->format('Y-m-d');            
            $valorizacion->id_usuario_inserta = $id_user;
            $valorizacion->descripcion = $value['denominacion'];

            $valorizacion->valor_unitario = $value['importe'];
            $valorizacion->cantidad = "1";
            $valorizacion->otro_concepto = "1";


            $valorizacion->save();

            $msg = "ok";

        }

        
       // print_r($conceptod);
       // exit();

       echo $msg;

/*

        $valorizaciones_model = new Valorizacione;
        $sw = true;
        $valorizacion = $valorizaciones_model->getValorizacion("89",$id_persona);
        //print_r($valorizacion);exit();
        return view('frontend.ingreso.lista_valorizacion',compact('valorizacion'));
*/
    }

    public function send_fracciona_deuda(Request $request){

        $msg = "";
        $id_user = Auth::user()->id;
        $id_persona = $request->id_persona;
        $id_agremiado = $request->id_agremiado;

        $id_pk = 0;
        $id_concepto = 0;

        //print_r($request->fraccionamiento);

        

        foreach($request->valorizacion as $key=>$tmp){
            //$id_pk = $tmp['id'];
            $id_concepto = $tmp['id_concepto'];
        }

/*
        foreach($request->valorizacion as $key=>$tmp){
            $id_pk = $tmp['id'];
        }
*/


        $fraccionamiento = new Fraccionamiento; 
        $fraccionamiento->cuotas = $request->cboCuotas;
        $fraccionamiento->monto = $request->txtTotalFrac;
        $fraccionamiento->porcentaje = $request->txtPorcentaje;
        $fraccionamiento->fecha_inicio = $request->txtFechaIni;
        $fraccionamiento->id_usuario_inserta = $id_user;

        $fraccionamiento->save();
        $id_fraccionamiento = $fraccionamiento->id;

        $id_persona = $request->id_persona;
        $tipo_documento = $request->id_tipo_documento_;
        $valorizaciones_model = new Valorizacione;        
        $valorizacion = $valorizaciones_model->ActualizaValorizacion_pp($tipo_documento, $id_fraccionamiento, $id_persona);
/*
        foreach($request->valorizacion as $key=>$val){

            $id = $val['id'];

            $valorizacion = Valorizacione::find($id);
            $valorizacion-> pk_fraccionamiento = $id_pk;
            $valorizacion-> estado = 0;
			$valorizacion->save();          
        }        
*/

        foreach($request->fraccionamiento as $key=>$frac){
            $valorizacion = new Valorizacione;
            $valorizacion->id_modulo = 6;
            $valorizacion->pk_registro = 0;
            $valorizacion->id_concepto = 26412;
            $valorizacion->id_agremido = $id_agremiado;
            $valorizacion->id_persona = $id_persona;
            $valorizacion->monto = $frac['total_frac'];
            $valorizacion->id_moneda = 1;
            $valorizacion->fecha = $frac['fecha_cuota'];
            $valorizacion->fecha_proceso = Carbon::now()->format('Y-m-d');            
            $valorizacion->id_usuario_inserta = $id_user;
            $valorizacion->descripcion = $frac['denominacion'];
            $valorizacion->codigo_fraccionamiento =  $id_fraccionamiento;

            $valorizacion->save();

        }
        

        $id_persona = $request->id_persona;
        $tipo_documento = $request->id_tipo_documento_;
        $periodo = $request->cboPeriodo_b;
        $tipo_couta = $request->cboTipoCuota_b;
        $concepto = 26412;
        //$filas = $request->cboFilas;
        $filas = "100";
        // print_r($concepto);exit();
        $valorizaciones_model = new Valorizacione;
        $sw = true;
        $valorizacion = $valorizaciones_model->getValorizacion($tipo_documento,$id_persona,$periodo,$tipo_couta,$concepto,$filas);
       
       
        return view('frontend.ingreso.lista_valorizacion',compact('valorizacion'));

    }

    public function modal_valorizacion_factura($id){
		
		$valorizaciones_model = new Valorizacione;
		$valorizacion = $valorizaciones_model->getValorizacionFactura($id);
		return view('frontend.ingreso.modal_valorizacion_factura',compact('valorizacion'));
	
	}

    public function modal_beneficiario_($periodo, $id_persona, $id_agremiado, $tipo_documento){
		
        $persona = new Persona();
        $empresa_model = new Empresa();
        $beneficiario_model = new Beneficiario();
        $empresa = $empresa_model->getEmpresaId($id_persona);
        $empresa_beneficiario = $beneficiario_model->getBeneficiarioId($empresa->id);
       
		//$beneficiario = new Beneficiario;
		//$valorizacion = $valorizaciones_model->getValorizacionFactura($id);
		return view('frontend.ingreso.modal_beneficiario_',compact('persona','empresa','id_persona','id_agremiado','tipo_documento','empresa_beneficiario'));
	
	}
	
	public function listar_empresa_beneficiario_ajax(Request $request){
	
		$beneficiario_model = new Beneficiario();
		$p[]=$request->id_concurso;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $beneficiario_model->listar_empresa_beneficiario($p);
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

    public function send_beneficiario(Request $request){
		
		$id_user = Auth::user()->id;

		if($request->id == 0){
			$beneficiario = new Beneficiario;
		}else{
			$beneficiario = Beneficiario::find($request->id);
		}
		$persona = Persona::where("numero_documento",$request->dni)->where("estado","1")->first();
        $empresa = Empresa::where("ruc",$request->ruc)->where("estado","1")->first();

		$beneficiario->id_persona = $persona->id;
		$beneficiario->id_empresa = $empresa->id;
		$beneficiario->id_usuario_inserta = $id_user;
		$beneficiario->save();
		
    }


    public function liquidacion_caja(){	
		$caja_model = new TablaMaestra;
        $caja = $caja_model->getMaestroByTipo("91");

        return view('frontend.ingreso.all_liquidacion_caja',compact('caja'));
    }
	
	public function modal_liquidacion($id){        
		$valorizaciones_model = new Valorizacione;

		return view('frontend.ingreso.modal_liquidacion',compact('id'));
	}


    public function modal_detalle_factura($id){
		
		$cajaIngreso = CajaIngreso::find($id);
		$factura_model = new Comprobante;
		$fecha_fin=$cajaIngreso->fecha_fin;
		if($cajaIngreso->fecha_fin=="")$fecha_fin=$factura_model->fecha_hora_actual();
		$factura = $factura_model->getFacturaByCaja($cajaIngreso->id_caja,$cajaIngreso->fecha_inicio,$fecha_fin);
		return view('frontend.ingreso.modal_detalle_factura',compact('factura'));
	
	}
	

	public function updateCajaLiquidacion(Request $request)
    {
        $valorizaciones_model = new Valorizacione;
		$id_user = Auth::user()->id;
        $datos[] = "ul";
        $datos[] = $id_user;
        $datos[] = $request->id_caja_ingreso;
		$datos[] = $request->id_caja;
        $datos[] = "";
        $datos[] = "";
        $datos[] = ($request->saldo_liquidado=='')?0:$request->saldo_liquidado;
        $datos[] = $request->estado;
        //print_r($datos);
        $id_caja_ingreso = $valorizaciones_model->registrar_caja_ingreso($datos);
        
		//echo $id_caja_ingreso;
        return redirect('/ingreso/liquidacion_caja');
		
    }	
	
	public function listar_liquidacion_caja_ajax(Request $request){
		
		$valorizaciones_model = new Valorizacione;
		$p[]=$request->fecha_inicio_desde;
		$p[]=$request->fecha_inicio_hasta;
		$p[]=$request->fecha_ini;
		$p[]=$request->fecha_fin;
		$p[]=$request->id_caja;
		$p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $valorizaciones_model->listar_liquidacion_caja_ajax($p);
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
	
	public function exportar_liquidacion_caja($fecha_inicio_desde,$fecha_inicio_hasta,$fecha_ini, $fecha_fin,$id_caja,$estado) {
		
		$valorizaciones_model = new Valorizacione;
		if($fecha_inicio_desde!=0)$fecha_inicio_desde = str_replace("-","/",$fecha_inicio_desde); else $fecha_inicio_desde = "";
		if($fecha_inicio_hasta!=0)$fecha_inicio_hasta = str_replace("-","/",$fecha_inicio_hasta); else $fecha_inicio_hasta = "";
		if($fecha_ini!=0)$fecha_ini = str_replace("-","/",$fecha_ini); else $fecha_ini = "";
		if($fecha_fin!=0)$fecha_fin = str_replace("-","/",$fecha_fin); else $fecha_fin = "";
		$p[]=$fecha_inicio_desde;
		$p[]=$fecha_inicio_hasta;
		$p[]=$fecha_ini;
		$p[]=$fecha_fin;
		$p[]=$id_caja;
		$p[]=$estado;
		$p[]=1;
		$p[]=10000;
		$data = $valorizaciones_model->listar_liquidacion_caja_ajax($p);
		
		$variable = [];
		$n = 1;
		array_push($variable, array("N","Usuario Caja", "Nombre Caja", "Tipo", "Estado", "Saldo Inicial", "Total Recaudado","Saldo Total","Fecha Inicio","Fecha Cierre","Usuario Contabilidad","Saldo Liquidado","Observacion"));
		foreach ($data as $r) {
			$estado = "";
			$disabled = "";
			if($r->estado == 0){
				$estado = "CERRADO";
				$disabled = "";
			}
			if($r->estado == 1){
				$estado = "ABIERTO";
				$disabled = "disabled='disabled'";
			}
			if($r->saldo_liquidado > 0){
				$estado = "LIQUIDADO";
				$disabled = "disabled='disabled'";
			}
			array_push($variable, array($n++,$r->usuario, $r->caja, $r->tipo,$estado, number_format($r->saldo_inicial,2), number_format($r->total_recaudado,2),number_format($r->saldo_total,2),$r->fecha_inicio, $r->fecha_fin, $r->usuario_contabilidad,($r->saldo_liquidado!="")?number_format($r->saldo_liquidado,2):0,$r->observacion));
		}
		
		$export = new InvoicesExport([$variable]);
		return Excel::download($export, 'liquidacion_caja.xlsx');
    }

}
