<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Presupuesto extends Model
{
    use HasFactory;

    function getInfoSolicitud($id_solicitud){      
        $cad = "select tm.denominacion tipo_tramite, tm2.denominacion tipo_obra from presupuestos p 
        inner join solicitudes s on p.id_solicitud = s.id 
        inner join tabla_maestras tm on s.id_tipo_tramite = tm.codigo::int and  tm.tipo ='123'
        inner join tabla_maestras tm2 on p.id_tipo_obra = tm2.codigo::int and  tm2.tipo ='124'
        where s.id='".$id_solicitud."'";

        //echo $cad;
		$data = DB::select($cad);
        return $data;
    }

    function getTipoObraSolicitud($id_solicitud){      
        $cad = "select tm4.denominacion tipo_obra, p.area_techada from presupuestos p 
        left join tabla_maestras tm4 on p.id_tipo_obra = tm4.codigo::int and  tm4.tipo ='112'
        where id_solicitud ='".$id_solicitud."'
        and p.estado ='1'";

        //echo $cad;
		$data = DB::select($cad);
        return $data;
    }
}
