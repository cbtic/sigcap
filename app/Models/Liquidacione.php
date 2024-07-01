<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Liquidacione extends Model
{
    use HasFactory;

    function getLiquidacionByIdSolicitud($id){

        $cad = "select l.sub_total, l.igv, l.total, l.credipago, l.fecha, l.id 
        from liquidaciones l 
        where id_solicitud ='".$id."'";

        //echo $cad;
		$data = DB::select($cad);
        return $data;
    }
}
