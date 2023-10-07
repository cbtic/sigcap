<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class AgremiadoEstudio extends Model
{
    use HasFactory;
	
	function getAgremiadoEstudios($id_agremiado){

        $cad = "select tm.denominacion universidad,tme.denominacion especialidad,ae.tesis,ae.fecha_egresado,ae.fecha_graduado,ae.libro,ae.folio 
from agremiado_estudios ae
inner join tabla_maestras tm on ae.id_universidad=tm.codigo::int and tm.tipo='85'  
inner join tabla_maestras tme on ae.id_universidad=tme.codigo::int and tme.tipo='86'
where ae.id_agremiado=".$id_agremiado;
    
		$data = DB::select($cad);
        return $data;
    }
		
	
}
