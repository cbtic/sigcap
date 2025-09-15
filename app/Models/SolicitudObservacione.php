<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class SolicitudObservacione extends Model
{
    use HasFactory;

    public function listar_observaciones_solicitud($id){

        $cad = "select so.id id_observacion, so.id_solicitud, so.observacion, to_char(so.created_at,'dd-mm-yyyy') fecha , u.name usuario from solicitud_observaciones so 
        inner join users u on so.id_usuario = u.id
        where so.id_solicitud = '".$id."'
        and so.estado = '1' 
        order by so.id desc";
    	//echo $cad;
		$data = DB::select($cad);
        return $data;

    }

}
