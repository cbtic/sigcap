<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Propietario extends Model
{
    use HasFactory;

    function getPropietarioSolicitud($id_solicitud){      

        $cad = "select tm.denominacion tipo_propietario, p2.numero_documento, p2.apellido_paterno ||' '|| p2.apellido_materno ||' '|| p2.nombres nombres, p2.numero_celular, p2.correo 
        from propietarios p
        inner join personas p2 on p.id_persona = p2.id
        inner join solicitudes s on p.id_solicitud = s.id
        inner join tabla_maestras tm on p.id_tipo_propietario ::int=tm.codigo::int and tm.tipo='110'
        where s.id='".$id_solicitud."'
        and p.estado='1'";

        //echo $cad;
		$data = DB::select($cad);
        return $data;
    }
}
