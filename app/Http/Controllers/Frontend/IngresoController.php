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
use Illuminate\Support\Carbon;

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
        $caja = $caja_model->getCaja('91');
        $caja_usuario = $caja_ingreso_model->getCajaIngresoByusuario($id_user,'91');
        $tipo_documento = $caja_model->getMaestroByTipo(16);

        
        //$caja_usuario = $caja_model;
        //print_r($caja_usuario);exit();
        return view('frontend.ingreso.create',compact('persona','caja','caja_usuario','tipo_documento'));

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
         //print_r($concepto);exit();
        $valorizaciones_model = new Valorizacione;
        $sw = true;
        $valorizacion = $valorizaciones_model->getValorizacion($tipo_documento,$id_persona,$periodo,$tipo_couta,$concepto);
       
       
        return view('frontend.ingreso.lista_valorizacion',compact('valorizacion'));

    }
 
    public function listar_valorizacion_concepto(Request $request){
        $id_persona = $request->id_persona;
        $tipo_documento = $request->tipo_documento;
        if($tipo_documento=="79")$id_persona = $request->empresa_id;
        $valorizaciones_model = new Valorizacione;
        $resultado = $valorizaciones_model->getValorizacionConcepto($tipo_documento,$id_persona);
        //print_r($valorizacion);exit();
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

    public function modal_otro_pago($periodo, $id_persona, $id_agremiado ){

        
        $conceptos_model = new Concepto;        
        $conceptos = $conceptos_model->getConceptoPeriodo($periodo);

    
		
		return view('frontend.ingreso.modal_otro_pago',compact('conceptos','periodo','id_persona','id_agremiado' ));
	}

    public function modal_fraccionar($idConcepto, $id_persona, $id_agremiado, $total_fraccionar ){

        $concepto = Concepto::find($idConcepto);

        //$concepto = json_encode($concepto_model);

        //print_r(json_encode($concepto)); exit();
		
		return view('frontend.ingreso.modal_fraccionar',compact('concepto','total_fraccionar','id_persona','id_agremiado' ));
	}

    public function modal_fraccionamiento(Request $request){

        $id_concepto = $request->id_concepto_sel;
        print_r($id_concepto); exit();

        $id_persona = $request->id_persona;
        $id_agremiado = $request->id_agremiado;
        $total_fraccionar = $request->total;
        //print_r($request->comprobante_detalle); exit();
        $comprobante_detalle = $request->comprobante_detalle;
        $ind = 0;
        foreach($request->comprobante_detalles as $key=>$det){
            
            $comprobanted[$ind] = $comprobante_detalle[$key];
            $ind++;
        }

        //print_r($comprobanted); exit();
        $concepto = Concepto::find($id_concepto);
        
        //$comprobanted = json_encode($comprobanted_);
    
		return view('frontend.ingreso.modal_fraccionar',compact('concepto','total_fraccionar','id_persona','id_agremiado','comprobanted' ));
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
        $id_agremiado = $request->id_agremiado;
        
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
            $valorizacion->id_agremido = $id_agremiado;
            $valorizacion->id_persona = $id_persona;
            $valorizacion->monto = $value['importe'];
            $valorizacion->id_moneda = $value['id_moneda'];
            $valorizacion->fecha = Carbon::now()->format('Y-m-d');
            $valorizacion->fecha_proceso = Carbon::now()->format('Y-m-d');            
            $valorizacion->id_usuario_inserta = $id_user;
            $valorizacion->descripcion = $value['denominacion'];

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
            $id_pk = $tmp['id'];
            $id_concepto = $tmp['id_concepto'];
        }


        foreach($request->valorizacion as $key=>$tmp){
            $id_pk = $tmp['id'];
        }

        foreach($request->valorizacion as $key=>$val){

            $id = $val['id'];

            $valorizacion = Valorizacione::find($id);
            $valorizacion-> pk_fraccionamiento = $id_pk;
            $valorizacion-> estado = 0;
			$valorizacion->save();          
        }
        


        foreach($request->fraccionamiento as $key=>$frac){
            $valorizacion = new Valorizacione;
            $valorizacion->id_modulo = 6;
            $valorizacion->pk_registro = 0;
            $valorizacion->id_concepto = $id_concepto;
            $valorizacion->id_agremido = $id_agremiado;
            $valorizacion->id_persona = $id_persona;
            $valorizacion->monto = $frac['total_frac'];
            $valorizacion->id_moneda = 1;
            $valorizacion->fecha = $frac['fecha_cuota'];
            $valorizacion->fecha_proceso = Carbon::now()->format('Y-m-d');            
            $valorizacion->id_usuario_inserta = $id_user;
            $valorizacion->descripcion = $frac['denominacion'];
            $valorizacion->codigo_fraccionamiento =  $id_pk;

            $valorizacion->save();

        }
        

        $id_persona = $request->id_persona;
        $tipo_documento = $request->id_tipo_documento_;
        $periodo = $request->cboPeriodo_b;
        $tipo_couta = $request->cboTipoCuota_b;
        $concepto = $request->cboTipoConcepto_b;
         //print_r($concepto);exit();
        $valorizaciones_model = new Valorizacione;
        $sw = true;
        $valorizacion = $valorizaciones_model->getValorizacion($tipo_documento,$id_persona,$periodo,$tipo_couta,$concepto);
       
       
        return view('frontend.ingreso.lista_valorizacion',compact('valorizacion'));

    }

    public function modal_valorizacion_factura($id){
		
		$valorizaciones_model = new Valorizacione;
		$valorizacion = $valorizaciones_model->getValorizacionFactura($id);
		return view('frontend.ingreso.modal_valorizacion_factura',compact('valorizacion'));
	
	}

}
