<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class AgremiadoSituacione extends Model
{
    use HasFactory;
	
	function getAgremiadoSituacion($id_agremiado){

        $cad = "select ruta_documento,fecha_inicio,fecha_fin,tm.denominacion pais  
from agremiado_situaciones as2 
inner join tabla_maestras tm on as2.id_pais_destino=tm.codigo::int and tm.tipo='88'
where as2.id_agremiado=".$id_agremiado;
    
		$data = DB::select($cad);
        return $data;
    }
	
}