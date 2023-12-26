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
		
		$cad = "select p.codigo,tm.denominacion tipo_proyecto,s2.numero_revision,l.credipago,p.nombre,p.direccion,csd.id_dictamen
from comision_sesion_dictamenes csd 
inner join comision_sesiones cs on csd.id_comision_sesion=cs.id 
inner join comisiones c2 on cs.id_comision =c2.id  
inner join solicitudes s2 on s2.id_comision_proyecto  =c2.id  
inner join proyectos p on p.id=s2.id_proyecto  
left join tabla_maestras tm on s2.id_tipo_solicitud=tm.codigo::int and tm.tipo='24'
inner join liquidaciones l on l.id_solicitud =s2.id  
where id_comision_sesion=".$id." and csd.estado='1'";
		
		//echo $cad;
		$data = DB::select($cad);
        return $data;
    }
	
}
