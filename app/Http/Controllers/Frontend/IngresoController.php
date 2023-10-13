<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

use App\Models\Persona;
use App\Models\Agremiado;
use App\Models\TablaMaestra;

use Auth;

class IngresoController extends Controller
{
    public function create(){        
		$id_user = Auth::user()->id;
        $persona = new Persona;
        $caja_model = new TablaMaestra;
        $valorizaciones_model = new Valorizacione;
        $caja = $caja_model->getCaja('CAJA');
        $caja_usuario = $valorizaciones_model->getCajaIngresoByusuario($id_user,'CAJA');
        //$caja_usuario = $caja_model;
        //print_r($caja_usuario);exit();
        return view('frontend.ingreso.create',compact('persona','caja','caja_usuario'));

    }
}
