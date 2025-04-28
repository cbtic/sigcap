<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Proyectista extends Model
{
    function getProyectistaCap($numero_cap){      
        $cad = "select a.numero_cap, pe.apellido_paterno || pe.apellido_materno || pe.nombres agremiado, tm.denominacion situacion, pe.direccion, a.numero_regional, tm2.denominacion actividad_gremial from proyectistas p 
        inner join agremiados a on p.id_agremiado = a.id
        inner join personas pe on a.id_persona = pe.id
        inner join tabla_maestras tm on a.id_situacion ::int=tm.codigo::int and tm.tipo='14'
        inner join tabla_maestras tm2 on a.id_actividad_gremial ::int=tm2.codigo::int and tm2.tipo='46'
        where a.numero_cap = '".$numero_cap."'";

        //echo $cad;
		$data = DB::select($cad);
        return $data;
    }

    function getProyectistaSolicitud($id_solicitud){      
        $cad = "select p.id, a.numero_cap, pe.apellido_paterno||' '||pe.apellido_materno||' '||pe.nombres agremiado, a.celular1, a.email1, 
        t3.denominacion situacion,t4.denominacion actividad, p.id_tipo_profesional, 'CAP' tipo_colegiatura
        from proyectistas p 
        inner join agremiados a on p.id_agremiado = a.id 
        inner join personas pe on a.id_persona = pe.id
        left join tabla_maestras t3 on a.id_situacion = t3.codigo::int And t3.tipo ='14'
        left join tabla_maestras t4 on a.id_actividad_gremial = t4.codigo::int And t4.tipo ='46'
        where p.id_solicitud = '".$id_solicitud."' and p.id_tipo_proyectista=2
        and p.estado='1'
        union all
        select p.id, po.colegiatura numero_cap, p.apellido_paterno ||' '|| p.apellido_materno ||' '|| p.nombres agremiado, p.numero_celular, p.correo, '' situacion, '' actividad, po.id_tipo_profesional , 'CIP' tipo_colegiatura
        from profesion_otros po 
        inner join personas p on po.id_persona = p.id
        inner join solicitudes s on po.id_solicitud = s.id
        where s.id='".$id_solicitud."' and po.id_tipo_proyectista=2 and p.estado='1'";

        //echo $cad;
		$data = DB::select($cad);
        return $data;
    }

    function getProyectistaSolicitud_($id_solicitud){
        $cad = "select p.id, a.numero_cap, pe.apellido_paterno||' '||pe.apellido_materno||' '||pe.nombres agremiado, a.celular1, a.email1, 
        t3.denominacion situacion,t4.denominacion actividad, p.id_tipo_profesional, 'CAP' tipo_colegiatura, p.id_tipo_proyectista
        from proyectistas p
        inner join agremiados a on p.id_agremiado = a.id 
        inner join personas pe on a.id_persona = pe.id
        left join tabla_maestras t3 on a.id_situacion = t3.codigo::int And t3.tipo ='14'
        left join tabla_maestras t4 on a.id_actividad_gremial = t4.codigo::int And t4.tipo ='46'
        where p.id_solicitud = '".$id_solicitud."'
        and p.estado='1'
        union all
        select p.id, po.colegiatura numero_cap, p.apellido_paterno ||' '|| p.apellido_materno ||' '|| p.nombres agremiado, p.numero_celular,
        p.correo, '' situacion, '' actividad, po.id_tipo_profesional , 'CIP' tipo_colegiatura, po.id_tipo_proyectista
        from profesion_otros po
        inner join personas p on po.id_persona = p.id
        inner join solicitudes s on po.id_solicitud = s.id
        where s.id='".$id_solicitud."' and p.estado='1'";

        //echo $cad;
		$data = DB::select($cad);
        return $data;
    }

    function getProyectistaSolicitud2($id_solicitud){      
        $cad = "select 'CAP' tipo_colegiatura, p4.id, a2.numero_cap AS numero_cap, pe.apellido_paterno||' '||pe.apellido_materno||' '||pe.nombres agremiado, a2.celular1, a2.email1, 
        t3.denominacion situacion,t4.denominacion actividad, p4.id_tipo_profesional, id_tipo_proyectista 
        FROM proyectistas p4
        INNER JOIN agremiados a2 ON p4.id_agremiado = a2.id 
        inner join personas pe on a2.id_persona = pe.id
        left join tabla_maestras t3 on a2.id_situacion = t3.codigo::int And t3.tipo ='14'
        left join tabla_maestras t4 on a2.id_actividad_gremial = t4.codigo::int And t4.tipo ='46'
        WHERE p4.id_solicitud = '".$id_solicitud."'
        UNION
        SELECT 'CIP' tipo_colegiatura, po.id, po.colegiatura AS numero_cap, pe2.apellido_paterno||' '||pe2.apellido_materno||' '||pe2.nombres agremiado, pe2.numero_celular, pe2.correo, 
        '' situacion,'' actividad, null id_tipo_profesional, id_tipo_proyectista 
        FROM profesion_otros po 
        INNER JOIN solicitudes s2 ON po.id_solicitud = s2.id
        inner join personas pe2 on po.id_persona = pe2.id
        WHERE po.id_solicitud = '".$id_solicitud."'
        order by id_tipo_proyectista";

        //echo $cad;
		$data = DB::select($cad);
        return $data;
    }

    function getProyectistaSolicitudHU($id_solicitud){      
        $cad = "select p.id, a.numero_cap, pe.apellido_paterno||' '||pe.apellido_materno||' '||pe.nombres agremiado, a.celular1, a.email1, 
        t3.denominacion situacion,t4.denominacion actividad, p.id_tipo_profesional, 'CAP' tipo_colegiatura, p.id_tipo_proyectista
        from proyectistas p 
        inner join agremiados a on p.id_agremiado = a.id 
        inner join personas pe on a.id_persona = pe.id
        left join tabla_maestras t3 on a.id_situacion = t3.codigo::int And t3.tipo ='14'
        left join tabla_maestras t4 on a.id_actividad_gremial = t4.codigo::int And t4.tipo ='46'
        where p.id_solicitud = '".$id_solicitud."'
        and p.estado='1'
        order by p.id_tipo_proyectista";

        //echo $cad;
		$data = DB::select($cad);
        return $data;
    }

    function getProyectistaSolicitudHULiq($id_solicitud){      
        $cad = "select p.id, a.numero_cap, pe.apellido_paterno||' '||pe.apellido_materno||' '||pe.nombres agremiado, a.celular1, a.email1, 
        t3.denominacion situacion,t4.denominacion actividad, p.id_tipo_profesional, 'CAP' tipo_colegiatura
        from proyectistas p 
        inner join agremiados a on p.id_agremiado = a.id 
        inner join personas pe on a.id_persona = pe.id
        left join tabla_maestras t3 on a.id_situacion = t3.codigo::int And t3.tipo ='14'
        left join tabla_maestras t4 on a.id_actividad_gremial = t4.codigo::int And t4.tipo ='46'
        where p.id_solicitud = '".$id_solicitud."'
        and p.estado='1'
        order by p.id_tipo_proyectista";

        //echo $cad;
		$data = DB::select($cad);
        return $data;
    }

    function getProyectista($id_solicitud){

        $cad = "select a.numero_cap, p2.apellido_paterno ||' '|| p2.apellido_materno ||' '|| p2.nombres agremiado, a.celular1, a.email1
        from proyectistas p
        inner join agremiados a on p.id_agremiado = a.id
        inner join personas p2 on a.id_persona = p2.id
        inner join solicitudes s on p.id_solicitud = s.id
        where s.id='".$id_solicitud."'
        and p.estado='1'";
        
		$data = DB::select($cad);
        return $data;
    }

    function getProyectistaIngeniero($id_solicitud){

        $cad = "select p.id, p.id_tipo_documento, p.numero_documento, p.apellido_paterno, p.apellido_materno, p.nombres, p.fecha_nacimiento, p.id_sexo, p.direccion, a.id_situacion, p.numero_celular, p.correo, p2.id id_profesional
        from proyectistas p2 
        inner join agremiados a on p2.id_agremiado = a.id
        left join personas p on a.id_persona =p.id
        inner join solicitudes s on p2.id_solicitud = s.id
        Where s.id='".$id_solicitud."' and p2.id_tipo_proyectista=1
        union all
        select p.id, p.id_tipo_documento, p.numero_documento, p.apellido_paterno, p.apellido_materno, p.nombres, p.fecha_nacimiento, p.id_sexo, p.direccion, null, p.numero_celular, p.correo, po.id id_profesional
        from profesion_otros po 
        inner join personas p on po.id_persona = p.id
        inner join solicitudes s on po.id_solicitud = s.id
        where s.id='".$id_solicitud."' and po.id_tipo_proyectista=1";
        
		$data = DB::select($cad);
        return $data;
    }

    function getDatosProyectistaIngeniero($id_solicitud){

        $cad = "select p.id, p.apellido_paterno ||' '|| p.apellido_materno ||' '|| p.nombres nombres, a.numero_cap numero_cap, tm.denominacion situacion, p.numero_celular, p.correo,tm2.denominacion actividad, 'CAP' tipo_colegiatura
        from proyectistas p2 
        inner join agremiados a on p2.id_agremiado = a.id
        left join personas p on a.id_persona =p.id
        inner join solicitudes s on p2.id_solicitud = s.id
        left join tabla_maestras tm on a.id_situacion = tm.codigo::int And tm.tipo ='14'
        left join tabla_maestras tm2 on a.id_actividad_gremial = tm2.codigo::int And tm2.tipo ='46'
        Where s.id='".$id_solicitud."' and p2.id_tipo_proyectista=1
        union all
        select p.id, p.apellido_paterno ||' '|| p.apellido_materno ||' '|| p.nombres nombres, po.colegiatura numero_cap, '' situacion, p.numero_celular, p.correo, '' actividad, 'CIP' tipo_colegiatura
        from profesion_otros po 
        inner join personas p on po.id_persona = p.id
        inner join solicitudes s on po.id_solicitud = s.id
        where s.id='".$id_solicitud."' and po.id_tipo_proyectista=1";
        
		$data = DB::select($cad);
        return $data;
    }

    function getDatosProyectistaIngeniero_($id_solicitud){

        $cad = "select p.id, p.apellido_paterno ||' '|| p.apellido_materno ||' '|| p.nombres nombres, a.numero_cap numero_cap, tm3.denominacion ubicacion, a.numero_regional, p.direccion , lo.denominacion as local, r.denominacion regional, tm4.denominacion autoriza, tm.denominacion situacion, p.numero_celular, tm2.denominacion actividad, 'CAP' tipo_colegiatura
        from proyectistas p2 
        inner join agremiados a on p2.id_agremiado = a.id
        left join personas p on a.id_persona =p.id
        inner join solicitudes s on p2.id_solicitud = s.id
        left join tabla_maestras tm on a.id_situacion = tm.codigo::int And tm.tipo ='14'
        left join tabla_maestras tm2 on a.id_actividad_gremial = tm2.codigo::int And tm2.tipo ='46'
        left join tabla_maestras tm3 on a.id_ubicacion = tm3.codigo::int And tm3.tipo ='63'
        left join locales lo on a.id_local = lo.id 
        left join regiones r on a.id_regional = r.id
        left join tabla_maestras tm4 on a.id_autoriza_tramite = tm4.codigo::int And tm4.tipo ='45'
        Where s.id='".$id_solicitud."' and p2.id_tipo_proyectista=1
        union all
        select p.id, p.apellido_paterno ||' '|| p.apellido_materno ||' '|| p.nombres nombres, po.colegiatura numero_cap, '' ubicacion, null numero_regional, p.direccion , '' as local, '' regional, '' autoriza, '' situacion, p.numero_celular, '' actividad, 'CIP' tipo_colegiatura
        from profesion_otros po 
        inner join personas p on po.id_persona = p.id
        inner join solicitudes s on po.id_solicitud = s.id
        where s.id='".$id_solicitud."' and po.id_tipo_proyectista=1";
            
		$data = DB::select($cad);
        return $data;
    }

    function datos_proyectista_editar($id_solicitud){      

        $cad = "select p.id, a.numero_cap, pe.apellido_paterno||' '||pe.apellido_materno||' '||pe.nombres agremiado, a.celular1, a.email1, 
        t3.denominacion situacion,t4.denominacion actividad, p.id_tipo_profesional, 'CAP' tipo_colegiatura
        from proyectistas p 
        inner join agremiados a on p.id_agremiado = a.id 
        inner join personas pe on a.id_persona = pe.id
        left join tabla_maestras t3 on a.id_situacion = t3.codigo::int And t3.tipo ='14'
        left join tabla_maestras t4 on a.id_actividad_gremial = t4.codigo::int And t4.tipo ='46'
        where p.id_solicitud = '".$id_solicitud."' and p.id_tipo_proyectista=1
        and p.estado='1'
        union all
        select p.id, po.colegiatura numero_cap, p.apellido_paterno ||' '|| p.apellido_materno ||' '|| p.nombres agremiado, p.numero_celular, p.correo, '' situacion, '' actividad, po.id_tipo_profesional , 'CIP' tipo_colegiatura
        from profesion_otros po 
        inner join personas p on po.id_persona = p.id
        inner join solicitudes s on po.id_solicitud = s.id
        where s.id='".$id_solicitud."' and po.id_tipo_proyectista=1 and p.estado='1'";

        //echo $cad;
		$data = DB::select($cad);
        return $data;
    }

    function getProyectistaPrincipal($id){      

        $cad = "select * from proyectistas p where id='".$id."'";

        //echo $cad;
		$data = DB::select($cad);
        return $data;
    }

    function getProyectistaPrincipalEdificaciones($id){

        $cad = "select p.id, p2.nombres ||' '|| p2.apellido_paterno ||' '|| p2.apellido_materno nombres, a.numero_cap, a.celular1, a.email1, a.firma from proyectistas p
        inner join solicitudes s on p.id_solicitud = s.id 
        inner join agremiados a on p.id_agremiado = a.id 
        inner join personas p2 on a.id_persona = p2.id 
        where p.id='".$id."'";

		$data = DB::select($cad);
        return $data;
    }

}
