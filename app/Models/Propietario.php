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
            WHEN p.id_tipo_propietario in ('84','83','259') THEN (select p7.numero_documento from personas p7 where p7.id = p.id_persona)
      end as numero_documento, 
      CASE 
            WHEN p.id_tipo_propietario = '78' THEN (select p3.apellido_paterno||' '||p3.apellido_materno||' '||p3.nombres agremiado from personas p3 where p3.id = p.id_persona)
            WHEN p.id_tipo_propietario = '79' THEN (select e2.razon_social from empresas e2 where e2.id = p.id_empresa)
            WHEN p.id_tipo_propietario in ('84','83','259') THEN (select p8.apellido_paterno||' '||COALESCE(p8.apellido_materno,'')||' '||p8.nombres agremiado from personas p8 where p8.id = p.id_persona)
      end as propietario,
      CASE 
            WHEN p.id_tipo_propietario = '78' THEN (select p4.numero_celular from personas p4 where p4.id = p.id_persona)
            WHEN p.id_tipo_propietario = '79' THEN (select e3.telefono from empresas e3 where e3.id = p.id_empresa)
            WHEN p.id_tipo_propietario in ('84','83','259') THEN (select p9.numero_celular from personas p9 where p9.id = p.id_persona)
      end as numero_celular,
      CASE 
            WHEN p.id_tipo_propietario = '78' THEN (select p6.direccion from personas p6 where p6.id = p.id_persona)
            WHEN p.id_tipo_propietario = '79' THEN (select e5.direccion from empresas e5 where e5.id = p.id_empresa)
            WHEN p.id_tipo_propietario in ('84','83','259') THEN (select p10.direccion from personas p10 where p10.id = p.id_persona)
      end as direccion,
      CASE 
            WHEN p.id_tipo_propietario = '78' THEN (select p5.correo from personas p5 where p5.id = p.id_persona)
            WHEN p.id_tipo_propietario = '79' THEN (select e4.email from empresas e4 where e4.id = p.id_empresa)
            WHEN p.id_tipo_propietario in ('84','83','259') THEN (select p11.correo from personas p11 where p11.id = p.id_persona)
      end as correo,
      tm.denominacion tipo_propietario, p.id_tipo_propietario 
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

    function getPropietarioSolicitudHULiq($id_solicitud){      
      $cad = "select p.id, p.id_empresa, p.id_persona, 
      CASE 
            WHEN p.id_persona is not null THEN (select p2.nombres ||' '|| p2.apellido_paterno ||' '|| COALESCE(p2.apellido_materno,'') from personas p2 where p2.id = p.id_persona)
            WHEN p.id_empresa is not null THEN (select e.razon_social from empresas e where e.id = p.id_empresa)end as propietario_nombre
      from propietarios p 
      left join personas pe on p.id_persona = pe.id
      left join empresas e on p.id_empresa = e.id
      where p.id_solicitud = '".$id_solicitud."'
      and p.estado='1'
      order by p.id desc";

      //echo $cad;
          $data = DB::select($cad);
      return $data;
  }
}
