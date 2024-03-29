<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class seguro_afiliado_parentesco extends Model
{
    use HasFactory;
	
	function getParentescoById($id){
       
        $cad = "select *
                from seguro_afiliado_parentescos
                where id=".$id." 
				and estado='1'";
    
		$data = DB::select($cad);

        
        
        return $data[0];
    }

    function getDatosSeguro($id){
       
        $cad = "select sa.id  id,  apellido_paterno||''|| apellido_materno || ', ' || nombres Agremiado, numero_cap cap,s.nombre seguro,sp.nombre plan,sp.monto monto,sp.fecha_inicio fecha_inicio,sp.fecha_fin fecha_fin ,a.id id_agremiado
                from seguro_afiliados sa inner join seguros_planes sp on sa.id_plan =sp.id  inner join seguros s on sp.id_seguro =s.id  inner join agremiados a on sa.id_agremiado =a.id inner join personas p on p.id=a.id_persona  
                where sa.id=" .$id. "";
    
		$data = DB::select($cad);
        

        return $data[0];

    }
    
	public function seguro_agremiado_cuota($id_afiliacion) {
		
        $cad = "Select sp_crud_seguro_agremiado_cuota(?)";
        $data = DB::select($cad, array($id_afiliacion));
        return $data[0]->sp_crud_seguro_agremiado_cuota;
    }
	
	
	
}
