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
       
        $cad = "select sa.id  id,  apellido_paterno||''|| apellido_materno || ', ' || nombres Agremiado, numero_cap cap, s.nombre seguro,
        (select sp2.nombre from seguros_planes sp2 where sp2.id_seguro = s.id limit 1) plan,
        (select sp3.monto from seguros_planes sp3 where sp3.id_seguro = s.id limit 1) monto,
        (select sp4.fecha_inicio from seguros_planes sp4 where sp4.id_seguro = s.id limit 1) fecha_inicio,
        (select sp5.fecha_fin from seguros_planes sp5 where sp5.id_seguro = s.id limit 1) fecha_fin ,
        a.id id_agremiado, s.id id_seguro      
        from seguro_afiliados sa 
        inner join seguros s on sa.id_seguro =s.id  
        inner join agremiados a on sa.id_agremiado =a.id 
        inner join personas p on p.id=a.id_persona           
        where sa.id=" .$id. "";
    
		$data = DB::select($cad);
        

        return $data[0];

    }

    function getDatosSeguro_act($id){
       
        $cad = "select sa.id  id,  apellido_paterno||''|| apellido_materno || ', ' || nombres Agremiado, numero_cap cap, s.nombre seguro,
        --(select sp2.nombre from seguros_planes sp2 where sp2.id_seguro = s.id limit 1) plan,
        (select sp3.monto from seguros_planes sp3 where sp3.id_seguro = s.id limit 1) monto,
        (select sp4.fecha_inicio from seguros_planes sp4 where sp4.id_seguro = s.id limit 1) fecha_inicio,
        (select sp5.fecha_fin from seguros_planes sp5 where sp5.id_seguro = s.id limit 1) fecha_fin ,
        a.id id_agremiado, s.id id_seguro, sp.nombre plan 
        from seguro_afiliados sa 
        inner join seguros s on sa.id_seguro =s.id  
        inner join agremiados a on sa.id_agremiado =a.id 
        inner join personas p on p.id=a.id_persona   
        inner join seguro_afiliado_parentescos sap on sap.id_afiliacion=sa.id and sap.id_agremiado=sa.id_agremiado and sap.id_familia=0 and sap.estado='1'
        inner join seguros_planes sp on sp.id=sap.id_plan
        where sa.id=" .$id. "";
    
		$data = DB::select($cad);
        

        return $data[0];

    }
    
	public function seguro_agremiado_cuota($id_afiliacion) {
		
        $cad = "Select sp_crud_seguro_agremiado_cuota(?)";
        $data = DB::select($cad, array($id_afiliacion));
        return $data[0]->sp_crud_seguro_agremiado_cuota;
    }
	
	public function eliminar_afiliado_seguro_cuota($id_afiliacion) {
		
        $cad = "Select sp_eliminar_afiliado_seguro_cuota(?)";
        $data = DB::select($cad, array($id_afiliacion));
        return $data[0]->sp_eliminar_afiliado_seguro_cuota;
    }
	
	
}
