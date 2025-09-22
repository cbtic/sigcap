<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class User extends Model
{
    use HasFactory;

    function getUserAll(){

        $cad = "select u.id, u.name from users u 
        where u.active ='1'
        order by 1 asc";

		$data = DB::select($cad);
        return $data;
    }

    function getUserByRol($id_rol){

        $cad = "select u.id,u.name
        from model_has_roles mhr  
        inner join users u on mhr.model_id=u.id
        where role_id=".$id_rol;

		$data = DB::select($cad);
        return $data;
    }

    function getRolByUser($id_user){

        $cad = "select 
        u.id as user_id,
        u.name as nombre_usuario,
        r.id as rol_id,
        r.name as nombre_rol
        from model_has_roles mhr
        inner join users u on mhr.model_id = u.id
        inner join roles r on mhr.role_id = r.id
        where u.id = '".$id_user."' ";

		$data = DB::select($cad);
        return $data;
    }

    function getDatosCarritoByIdUsuario($id){
		$cad = "select u.email,p.id id_persona,a.fecha_colegiado,date_part('year',age(now(), a.fecha_colegiado::timestamp))anos,(now()::date - a.fecha_colegiado::date)dias,
        a.celular1,a.direccion,a.id_ubigeo_domicilio,ub.desc_ubigeo departamento,a.numero_cap  
from users u 
inner join personas p on u.id_persona=p.id
inner join agremiados a on p.id=a.id_persona
left join ubigeos ub on left(a.id_ubigeo_domicilio,2)=ub.id_departamento and ub.id_departamento!='00' and ub.id_provincia='00' and ub.id_distrito='00' and ub.id_departamento='15' and ub.estado='1'
where u.id=".$id."
and p.estado='1'
and a.estado='1'";

		$data = DB::select($cad);
        if(isset($data[0]))return $data[0];
	}

}
