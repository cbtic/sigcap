<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Proyecto extends Model
{
    public function obtenerNombreProyecto($numero_cap){

        $cad = "select s.id, p.nombre from solicitudes s 
        inner join proyectos p on s.id_proyecto = p.id 
        inner join proyectistas pr on s.id_proyectista = pr.id 
        inner join agremiados a on pr.id_agremiado = a.id 
        where a.numero_cap = '".$numero_cap."'";
		//echo $cad;
		$data = DB::select($cad);
        return $data;
    }
}
