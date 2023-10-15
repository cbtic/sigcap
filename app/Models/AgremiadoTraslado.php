<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class AgremiadoTraslado extends Model
{
    use HasFactory;
	
	function getAgremiadoTraslado($id_agremiado){

        $cad = "select at2.id,r.denominacion region,at2.numero_regional,at2.fecha_inicio,at2.fecha_fin,at2.observacion  
from agremiado_traslados at2
inner join regiones r on at2.id_region=r.id
where at2.id_agremiado=".$id_agremiado."
and at2.estado='1'";
    
		$data = DB::select($cad);
        return $data;
    }
	
}
