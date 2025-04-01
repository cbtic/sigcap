<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class AgremiadoTrabajo extends Model
{
    use HasFactory;
	
	function getAgremiadoTrabajo($id_agremiado){

        $cad = "select at2.id,numero_documento,razon_social,coalesce(tm.denominacion,'SIN DEFINIR') cargo,rubro_negocio,
at2.id_ubigeo,ud.desc_ubigeo departamento,udi.desc_ubigeo distrito,up.desc_ubigeo provincia,at2.direccion,at2.codigo_postal,at2.referencia,at2.telefono,at2.celular,at2.email  
from agremiado_trabajos at2
left join tabla_maestras tm on at2.id_cliente_cargo=tm.codigo::int and tm.tipo='4'
left join ubigeos u on at2.id_ubigeo=u.id_ubigeo
left join ubigeos ud on ud.id_departamento=substring(u.id_ubigeo,1,2) and ud.id_provincia='00' and ud.id_distrito='00' and ud.estado='1'
left join ubigeos up on up.id_departamento=substring(u.id_ubigeo,1,2) and up.id_provincia=substring(u.id_ubigeo,3,2) and up.id_distrito='00' and up.estado='1'
left join ubigeos udi on udi.id_ubigeo=u.id_ubigeo and udi.estado='1'
where at2.id_agremiado=".$id_agremiado."
and at2.estado='1'";
    
		$data = DB::select($cad);
        return $data;
    }
}
