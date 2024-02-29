<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class AgremiadoSituacione extends Model
{
    use HasFactory;
	
	function getAgremiadoSituacion($id_agremiado){

        $cad = "select as2.id,ruta_documento,to_char(fecha_inicio,'dd-mm-yyyy')fecha_inicio,to_char(fecha_fin,'dd-mm-yyyy')fecha_fin,tm.denominacion pais  
from agremiado_situaciones as2 
inner join tabla_maestras tm on as2.id_pais_destino=tm.codigo::int and tm.tipo='88'
where as2.id_agremiado=".$id_agremiado."
and as2.estado='1'";
    
		$data = DB::select($cad);
        return $data;
    }
	
}
