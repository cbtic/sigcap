<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class UsoEdificacione extends Model
{
    use HasFactory;

    function getInfoSolicitudUso($id_solicitud){      
        $cad = "select s.id, ue.id id_uso_edificacion, tm.denominacion tipo_tramite, tm2.denominacion tipo_uso, ue.area_techada,
		(select ruta_archivo from solicitud_documentos sd where id_solicitud=ue.id_solicitud and id_tipo_documento=1 and estado='1' order by 1 desc limit 1)ruta_archivo1,
		(select ruta_archivo from solicitud_documentos sd where id_solicitud=ue.id_solicitud and id_tipo_documento=2 and estado='1' order by 1 desc limit 1)ruta_archivo2,
		(select ruta_archivo from solicitud_documentos sd where id_solicitud=ue.id_solicitud and id_tipo_documento=3 and estado='1' order by 1 desc limit 1)ruta_archivo3 
		from uso_edificaciones ue 
        inner join solicitudes s on ue.id_solicitud = s.id 
        inner join tabla_maestras tm on s.id_tipo_tramite = tm.codigo::int and  tm.tipo ='123'
        inner join tabla_maestras tm2 on ue.id_tipo_uso = tm2.codigo::int and  tm2.tipo ='124'
        where s.id='".$id_solicitud."'
        and ue.estado ='1'";

        //echo $cad;
		$data = DB::select($cad);
        return $data;
    }

    function getInfoSolicitudUso2($id_solicitud){      
        $cad = "select s.id, ue.id id_uso_edificacion, tm.denominacion tipo_tramite, tm2.denominacion tipo_uso, ue.area_techada,
		(select ruta_archivo from solicitud_documentos sd where id_solicitud=ue.id_solicitud and id_tipo_documento=1 and estado='1' order by 1 desc limit 1)ruta_archivo1,
		(select ruta_archivo from solicitud_documentos sd where id_solicitud=ue.id_solicitud and id_tipo_documento=2 and estado='1' order by 1 desc limit 1)ruta_archivo2,
		(select ruta_archivo from solicitud_documentos sd where id_solicitud=ue.id_solicitud and id_tipo_documento=3 and estado='1' order by 1 desc limit 1)ruta_archivo3 
		from uso_edificaciones ue 
        inner join solicitudes s on ue.id_solicitud = s.id 
        inner join tabla_maestras tm on s.id_tipo_tramite = tm.codigo::int and  tm.tipo ='25'
        inner join tabla_maestras tm2 on ue.id_tipo_uso = tm2.codigo::int and  tm2.tipo ='124'
        where s.id='".$id_solicitud."'
        and ue.estado ='1'";

        //echo $cad;
		$data = DB::select($cad);
        return $data;
    }

    function getInfoSolicitudUsoTipo($id_solicitud){      
        $cad = "select s.id, ue.id id_uso_edificacion, tm.denominacion tipo_tramite, (SELECT STRING_AGG(tm2.denominacion, ' - ') AS tipo_uso
        FROM uso_edificaciones ue
        INNER JOIN tabla_maestras tm2 ON ue.id_tipo_uso = tm2.codigo::int AND tm2.tipo = '124'
        WHERE ue.id_solicitud = s.id and ue.estado='1'), ue.area_techada,
        (select ruta_archivo from solicitud_documentos sd where id_solicitud=ue.id_solicitud and id_tipo_documento=1 and estado='1' order by sd.id desc limit 1)ruta_archivo1,
        (select ruta_archivo from solicitud_documentos sd where id_solicitud=ue.id_solicitud and id_tipo_documento=2 and estado='1' order by sd.id desc limit 1)ruta_archivo2,
        (select ruta_archivo from solicitud_documentos sd where id_solicitud=ue.id_solicitud and id_tipo_documento=3 and estado='1' order by sd.id desc limit 1)ruta_archivo3 
        from uso_edificaciones ue 
        inner join solicitudes s on ue.id_solicitud = s.id 
        inner join tabla_maestras tm on s.id_tipo_tramite = tm.codigo::int and  tm.tipo ='123'
        inner join tabla_maestras tm2 on ue.id_tipo_uso = tm2.codigo::int and  tm2.tipo ='124'
        where s.id='".$id_solicitud."'
        and ue.estado ='1'
        order by ue.id desc
        limit 1 ";

        //echo $cad;
		$data = DB::select($cad);
        return $data;
    }

    function getUsoEdificacionSolicitud($id_solicitud){      
        $cad = "select tm4.denominacion tipo_uso, tm5.denominacion sub_tipo_uso from uso_edificaciones ue 
        left join tabla_maestras tm4 on ue.id_tipo_uso = tm4.codigo::int and  tm4.tipo ='111' and tm4.sub_codigo is null
        left join tabla_maestras tm5 on ue.id_sub_tipo_uso = tm5.codigo::int and  tm5.tipo ='111' and tm5.sub_codigo ::int = ue.id_tipo_uso
        where ue.id_solicitud ='".$id_solicitud."'
        and ue.estado ='1'";

        //echo $cad;
		$data = DB::select($cad);
        return $data;
    }

    function getUsoEdificacion($id){      
        $cad = "select ue.id, ROW_NUMBER() OVER (PARTITION BY ue.id_solicitud) AS row_num, tm.denominacion uso_edificacion, tm2.denominacion sub_tipo_edificacion, ue.area_techada, ue.estado from uso_edificaciones ue 
        inner join tabla_maestras tm on ue.id_tipo_uso = tm.codigo::int and tm.tipo ='111' and tm.sub_codigo::int is null
        left join tabla_maestras tm2 on ue.id_tipo_uso = tm2.codigo::int and coalesce(ue.id_sub_tipo_uso::int,0) = tm2.sub_codigo::int and tm2.tipo ='111'
        where ue.estado ='1'
        and ue.id = '".$id."'";

        //echo $cad;
		$data = DB::select($cad);
        return $data;
    }
}
