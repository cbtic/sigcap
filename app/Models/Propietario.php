<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Propietario extends Model
{
    use HasFactory;

    function getPropietarioSolicitud($id_solicitud){      

        $cad = "select
        CASE 
             WHEN p.id_tipo_propietario = '78' THEN (select p2.numero_documento from personas p2 where p2.id = p.id_persona)
             WHEN p.id_tipo_propietario = '79' THEN (select e.ruc from empresas e where e.id = p.id_empresa)
       end as numero_documento, CASE 
             WHEN p.id_tipo_propietario = '78' THEN (select p2.apellido_paterno||' '||p2.apellido_materno||' '||p2.nombres agremiado from personas p2 where p2.id = p.id_persona)
             WHEN p.id_tipo_propietario = '79' THEN (select e.razon_social from empresas e where e.id = p.id_empresa)
       end as propietario, tm.denominacion tipo_propietario
       from propietarios p
       --inner join personas p2 on p.id_persona = p2.id
       inner join solicitudes s on p.id_solicitud = s.id
       inner join tabla_maestras tm on p.id_tipo_propietario ::int=tm.codigo::int and tm.tipo='16'
       where s.id='".$id_solicitud."'
       and p.estado='1'";

        //echo $cad;
		$data = DB::select($cad);
        return $data;
    }
}
