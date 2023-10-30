<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class SegurosPlane extends Model
{
    use HasFactory;
	
	function getSeguroPlanById($id){

        $cad = "select *
                from seguros_planes
                where id=".$id." 
				and estado='1'";
    
		$data = DB::select($cad);
        return $data[0];
    }

    function getPlanBySeguro($id){

        $cad = "select *
        from seguros_planes sp 
        where id_seguro =".$id." and estado='1' 
        order by nombre";
    
		$data = DB::select($cad);
        return $data;
    }
	
}
