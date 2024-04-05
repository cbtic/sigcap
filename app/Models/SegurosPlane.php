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

        $cad = "select id,nombre,monto
        from seguros_planes sp 
        where id_seguro = '".$id."' and estado='1' 
        order by nombre";
    
		$data = DB::select($cad);
        return $data;
    }

    function getPlanIdBySeguro($id){

        $cad = "select sp.id
        from seguros_planes sp 
        where id_seguro = '".$id."' and estado='1' 
        order by nombre";
    
		$data = DB::select($cad);
        return $data;
    }
	
    function getSeguroById($id){

        $cad = "select sa.id, s.nombre , sp.monto from seguro_afiliados sa 
        inner join seguros_planes sp on sa.id_plan = sp.id 
        inner join seguros s on sp.id_seguro = s.id
        where sa.id='".$id."'";
    
		$data = DB::select($cad);
        return $data;
    }

}
