<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Proyecto;

class ProyectoController extends Controller
{
    public function obtener_proyecto($numero_cap){
		
		$proyecto_model = new Proyecto;
		$nombre_proyecto = $proyecto_model->obtenerNombreProyecto($numero_cap);
		echo json_encode($nombre_proyecto);
		
	}
}
