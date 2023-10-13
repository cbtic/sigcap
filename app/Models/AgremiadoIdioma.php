<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class AgremiadoIdioma extends Model
{
    use HasFactory;
	
	function getAgremiadoIdiomas($id_agremiado){

        $cad = "select ae.id,tm.denominacion idioma,tme.denominacion grado 
from agremiado_idiomas ae
inner join tabla_maestras tm on ae.id_idioma=tm.codigo::int and tm.tipo='87'  
inner join tabla_maestras tme on ae.id_grado_conocimiento=tme.codigo::int and tme.tipo='17'
where ae.id_agremiado=".$id_agremiado."
and ae.estado='1'";

		$data = DB::select($cad);
        return $data;
    }
	
}
