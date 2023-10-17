<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

use App\Models\Persona;
use App\Models\Agremiado;
use App\Models\TablaMaestra;
use App\Models\AgremidoCuota;
use App\Models\CajaIngreso;

use Auth;

class IngresoController extends Controller
{
    public function create(){      
         
		$id_user = Auth::user()->id;
        $persona = new Persona;
        $caja_model = new TablaMaestra;
        $caja_ingreso_model = new CajaIngreso();
        $caja = $caja_model->getCaja('CAJA');
        $caja_usuario = $caja_ingreso_model->getCajaIngresoByusuario($id_user,'91');
        
        //$caja_usuario = $caja_model;
        //print_r($caja_usuario);exit();
        return view('frontend.ingreso.create',compact('persona','caja','caja_usuario'));

    }


}
