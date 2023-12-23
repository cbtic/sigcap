<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class ComisionSesionDictamene extends Model
{
    use HasFactory;
	
	function getComisionSesionDictameneByIdComisionSesion($id){

        $cad = "select * from comision_sesion_dictamenes csd where id_comision_sesion=".$id." and estado='1'";
		//echo $cad;
		$data = DB::select($cad);
        return $data;
    }
	
}
