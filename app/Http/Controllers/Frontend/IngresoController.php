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

use Auth;

class IngresoController extends Controller
{
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
        $valorizacion = $valorizaciones_model->getValorizacion($tipo_documento,$id_persona);
        //print_r($valorizacion);exit();
        return view('frontend.ingreso.lista_valorizacion',compact('valorizacion'));

    }
    public function obtener_conceptos($perido){

        $conceptos_model = new Concepto;        
        $conceptos = $conceptos_model->getValorizacion($perido);
        //print_r($valorizacion);exit();
        return view('frontend.ingreso.lista_valorizacion',compact('conceptos'));

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

    public function otro_pago($periodo){
        $moneda_tabla = new TablaMaestra;		
        $concepto = Concepto::where('periodo', '=', $periodo)->where('estado', '=', '1')->first();
		$moneda = $moneda_tabla->getMaestroByTipo("1");

        print_r($moneda);exit();
		
		return view('frontend.ingreso.modal_otro_pago',compact('concepto','moneda'));
	}

}
