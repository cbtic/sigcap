<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class UsoEdificacione extends Model
{
    use HasFactory;

    function getInfoSolicitudUso($id_solicitud){      
        $cad = "select s.id, tm.denominacion tipo_tramite, tm2.denominacion tipo_uso, ue.area_techada,
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
}
