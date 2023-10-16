<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

use App\Models\Persona;
use App\Models\Agremiado;
use App\Models\TablaMaestra;
use App\Models\AgremidoCuota;

use Auth;

class IngresoController extends Controller
{
    public function create(){        
		$id_user = Auth::user()->id;
        $persona = new Persona;
        $caja_model = new TablaMaestra;
        $agremiado_cuota_model = new AgremidoCuota();
        $caja = $caja_model->getCaja('CAJA');
        $caja_usuario = $agremiado_cuota_model->getCajaIngresoByusuario($id_user,'91');
        //$caja_usuario = $caja_model;
        //print_r($caja_usuario);exit();
        return view('frontend.ingreso.create',compact('persona','caja','caja_usuario'));

    }


}
