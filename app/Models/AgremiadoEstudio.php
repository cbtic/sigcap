<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class AgremiadoEstudio extends Model
{
    use HasFactory;
	
	function getAgremiadoEstudios($id_agremiado){

        $cad = "select ae.id,tm.denominacion universidad,tme.denominacion especialidad,ae.tesis,to_char(ae.fecha_egresado,'dd-mm-yyyy')fecha_egresado,to_char(ae.fecha_graduado,'dd-mm-yyyy')fecha_graduado,ae.libro,ae.folio,ae.estado  
from agremiado_estudios ae
inner join tabla_maestras tm on ae.id_universidad=tm.codigo::int and tm.tipo='85'  
inner join tabla_maestras tme on ae.id_especialidad=tme.codigo::int and tme.tipo='86'
where ae.id_agremiado=".$id_agremiado."
and ae.estado='1'";
    
		$data = DB::select($cad);
        return $data;
    }
		
	
}
