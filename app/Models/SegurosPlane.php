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

        $cad = "select sa.id, s.nombre , (select sp3.monto from seguros_planes sp3 where sp3.id_seguro = s.id limit 1) monto from seguro_afiliados sa     
        inner join seguros s on sa.id_seguro = s.id
        where sa.id='".$id."'";
    
		$data = DB::select($cad);
        return $data;
    }
	
	function getSeguroByIdAgramieadoAndIdSeguro($id_agremiado,$id_seguro){

        $cad = "select sp.id id_plan,extract(year from Age(p.fecha_nacimiento))edad,p.id_sexo 
from  agremiados a
inner join personas p on a.id_persona=p.id 
inner join seguros_planes sp on sp.id=(select id from seguros_planes where id_seguro=".$id_seguro." and id_parentesco in('119','121') and extract(year from Age(p.fecha_nacimiento)) between edad_minima and edad_maxima limit 1) 
where a.id=".$id_agremiado;
    	//echo $cad;
		$data = DB::select($cad);
        if(isset($data[0]))return $data[0];
    }
	
	

}
