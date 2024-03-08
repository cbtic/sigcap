<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Proyectista;

class ProyectistaController extends Controller
{
    public function obtener_datos_proyectista($numero_cap){

        $proyectista_model = new Proyectista;
        //$valorizaciones_model = new Valorizacione;
        $sw = true;
        $proyectista = $proyectista_model->getProyectistaCap($numero_cap);
        $array["sw"] = $sw;
        $array["proyectista"] = $proyectista;
        echo json_encode($array);

    }
}
