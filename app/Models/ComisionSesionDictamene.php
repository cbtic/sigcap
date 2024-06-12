<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class ComisionSesionDictamene extends Model
{
    use HasFactory;
	
	function getComisionSesionDictameneByIdComisionSesion($id){

        //$cad = "select * from comision_sesion_dictamenes csd where id_comision_sesion=".$id." and estado='1'";
		/*
		$cad = "select p.codigo,tm.denominacion tipo_proyecto,s2.numero_revision,l.credipago,p.nombre,p.direccion,csd.id_dictamen
from comision_sesion_dictamenes csd 
inner join comision_sesiones cs on csd.id_comision_sesion=cs.id 
inner join comisiones c2 on cs.id_comision =c2.id  
inner join solicitudes s2 on s2.id_comision_proyecto  =c2.id  
inner join proyectos p on p.id=s2.id_proyecto  
left join tabla_maestras tm on s2.id_tipo_solicitud=tm.codigo::int and tm.tipo='24'
inner join liquidaciones l on l.id_solicitud =s2.id  
where id_comision_sesion=".$id." and csd.estado='1'";
		*/
		$cad = "select  cs.id,p.codigo ,tm.denominacion as tipo_sol ,csd.id_numero_revision,to_char(l.fecha,'dd-mm-yyyy')fecha_liquidacion ,l.credipago ,p.nombre ,p.direccion ,tm2.denominacion as dictamen,u.desc_ubigeo distrito,l.total,csd.numero_expediente,csd.id_solicitud     
		from comision_sesion_dictamenes csd 
		inner join comision_sesiones cs on csd.id_comision_sesion =cs.id 									
		inner join solicitudes s2 on s2.id =csd.id_solicitud  
		inner join proyectos p on p.id=s2.id_proyecto  
		inner join liquidaciones l on l.id_solicitud =s2.id 
		inner join tabla_maestras tm on s2.id_tipo_tramite  =tm.codigo::int and tm.tipo='25'
		inner join tabla_maestras tm2 on csd.id_dictamen  =tm2.codigo::int and tm2.tipo='114'
		inner join ubigeos u on s2.id_ubigeo=u.id_ubigeo 
		where cs.id = ".$id." 
		order by u.desc_ubigeo asc";
		
		//echo $cad;
		$data = DB::select($cad);
        return $data;
    }
	
}
