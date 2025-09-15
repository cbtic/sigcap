<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class AgremiadoParenteco extends Model
{
    use HasFactory;
	
	function getAgremiadoParentesco($id_agremiado){

        $cad = "select ap.id,tm.denominacion parentesco,tms.denominacion sexo,ap.apellido_nombre,to_char(ap.fecha_nacimiento,'dd-mm-yyyy')fecha_nacimiento  
from agremiado_parentecos ap 
inner join tabla_maestras tm on ap.id_parentesco=tm.codigo::int and tm.tipo='12'
inner join tabla_maestras tms on ap.id_sexo=tms.codigo::int and tms.tipo='2'
where ap.id_agremiado=".$id_agremiado."
and ap.estado='1'";
    
		$data = DB::select($cad);
        return $data;
    }
	
}
