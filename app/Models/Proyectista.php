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
		t3.denominacion situacion,t4.denominacion actividad 
		from proyectistas p 
        inner join agremiados a on p.id_agremiado = a.id 
        inner join personas pe on a.id_persona = pe.id
		left join tabla_maestras t3 on a.id_situacion = t3.codigo::int And t3.tipo ='14'
		left join tabla_maestras t4 on a.id_actividad_gremial = t4.codigo::int And t4.tipo ='46'
        where p.id_solicitud = '".$id_solicitud."'
        and p.estado='1'
        order by p.id asc";

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

}
