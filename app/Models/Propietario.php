<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Propietario extends Model
{
    use HasFactory;

    function getPropietarioSolicitud($id_solicitud){      

        $cad = "select p.id,
        CASE 
             WHEN p.id_tipo_propietario = '78' THEN (select p2.numero_documento from personas p2 where p2.id = p.id_persona)
             WHEN p.id_tipo_propietario = '79' THEN (select e.ruc from empresas e where e.id = p.id_empresa)
       end as numero_documento, 
       CASE 
             WHEN p.id_tipo_propietario = '78' THEN (select p2.apellido_paterno||' '||p2.apellido_materno||' '||p2.nombres agremiado from personas p2 where p2.id = p.id_persona)
             WHEN p.id_tipo_propietario = '79' THEN (select e2.razon_social from empresas e2 where e2.id = p.id_empresa)
       end as propietario,
       CASE 
             WHEN p.id_tipo_propietario = '78' THEN (select p3.numero_celular from personas p3 where p3.id = p.id_persona)
             WHEN p.id_tipo_propietario = '79' THEN (select e3.telefono from empresas e3 where e3.id = p.id_empresa)
       end as numero_celular,
       CASE 
             WHEN p.id_tipo_propietario = '78' THEN (select p4.correo from personas p4 where p4.id = p.id_persona)
             WHEN p.id_tipo_propietario = '79' THEN (select e4.email from empresas e4 where e4.id = p.id_empresa)
       end as correo,tm.denominacion tipo_propietario
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
