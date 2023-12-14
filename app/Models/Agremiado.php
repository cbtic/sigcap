<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Agremiado extends Model
{
    use HasFactory;
	
	public function listar_agremiado_ajax($p){
		return $this->readFunctionPostgres('sp_listar_agremiado_paginado',$p);
    }

	function getAgremiadoAll(){
		$cad = "select t2.id,t1.id id_p,t1.numero_documento,t1.nombres,t1.apellido_paterno,t1.apellido_materno,t2.numero_cap,t1.foto,t1.numero_ruc,t2.fecha_colegiado,t3.denominacion situacion, desc_cliente nombre_completo,t1.id_tipo_documento 								
		from personas t1 
		inner join agremiados  t2 on t1.id = t2.id_persona And t2.estado='1'
		left join tabla_maestras t3 on t2.id_situacion = t3.codigo::int And t3.tipo ='14'                    
		Where  t1.estado='1' ";
		$data = DB::select($cad);
		
        return $data;
	}

	function getAgremiado($tipo_documento,$numero_documento){

        if($tipo_documento=="79"){  //RUC
            $cad = "select t1.id,razon_social,t1.direccion,t1.representante, t1.ruc 
                    from empresas t1                    
                    Where t1.ruc='".$numero_documento."'";

        }elseif($tipo_documento=="85"){ //NRO_CAP
			
			$cad = "select t2.id,t1.id id_p,t1.numero_documento,t1.nombres,t1.apellido_paterno,t1.apellido_materno,t2.numero_cap,t1.foto,
					t1.numero_ruc,t2.fecha_colegiado,t3.denominacion situacion, desc_cliente nombre_completo,t1.id_tipo_documento,
					t4.denominacion actividad 								
					from personas t1 
					inner join agremiados  t2 on t1.id = t2.id_persona And t2.estado='1'
					left join tabla_maestras t3 on t2.id_situacion = t3.codigo::int And t3.tipo ='14'
					left join tabla_maestras t4 on t2.id_actividad_gremial = t4.codigo::int And t4.tipo ='46'
					Where  t2.numero_cap ='".$numero_documento."' 
					and t1.estado='1' 
					limit 1";
								
        }else{
			$cad = "select t2.id,t1.id id_p,t1.numero_documento,t1.nombres,t1.apellido_paterno,t1.apellido_materno,t2.numero_cap,t1.foto,
					t1.numero_ruc,t1.id_tipo_documento,t3.denominacion situacion, t4.denominacion actividad  			
					from personas t1 
					left join agremiados  t2 on t1.id = t2.id_persona And t2.estado='1'
					left join tabla_maestras t3 on t2.id_situacion = t3.codigo::int And t3.tipo ='14'
					left join tabla_maestras t4 on t2.id_actividad_gremial = t4.codigo::int And t4.tipo ='46'                    
					Where  t1.id_tipo_documento='".$tipo_documento."' and t1.numero_documento = '".$numero_documento."' 
					and t1.estado='1' 
					limit 1";
		}
		//echo $cad;
		$data = DB::select($cad);
		
        return $data[0];
    }
	
	function getAgremiadoByIdPersona($id_persona){

        $cad = "select t2.id,t1.numero_documento,t1.nombres,t1.apellido_paterno,t1.apellido_materno,t2.numero_cap,t1.foto,t1.numero_ruc,t2.fecha_colegiado,t3.denominacion situacion,t4.denominacion region 
from personas t1 
left join agremiados t2 on t1.id = t2.id_persona And t2.estado='1'
left join tabla_maestras t3 on t2.id_situacion = t3.codigo::int And t3.tipo ='14' 
inner join regiones t4 on t2.id_regional = t4.id
Where t2.id_persona=".$id_persona;
		//echo $cad;
		$data = DB::select($cad);
        return $data[0];
    }
	
	function getTipoPlaza($id_agremiado){
		
		$cad = "select 
case 
	when date_part('year', CURRENT_DATE)-date_part('year', fecha_colegiado)>=20 then 1
	when date_part('year', CURRENT_DATE)-date_part('year', fecha_colegiado)>5 and 
		 date_part('year', CURRENT_DATE)-date_part('year', fecha_colegiado)<20 then 2
	else 0 
end id_tipo_plaza
from agremiados a 
where id=".$id_agremiado;
		//echo $cad;
		$data = DB::select($cad);
        if(isset($data[0]))return $data[0]->id_tipo_plaza;
		
	}
	
	public function readFunctionPostgres($function, $parameters = null){

      $_parameters = '';
      if (count($parameters) > 0) {
          $_parameters = implode("','", $parameters);
          $_parameters = "'" . $_parameters . "',";
      }
	  $data = DB::select("BEGIN;");
	  $cad = "select " . $function . "(" . $_parameters . "'ref_cursor');";
	  //echo $cad;
	  $data = DB::select($cad);
	  $cad = "FETCH ALL IN ref_cursor;";
	  $data = DB::select($cad);
      return $data;
   }
   
   public function readFunctionPostgresTransaction($function, $parameters = null){
	
      $_parameters = '';
      if (count($parameters) > 0) {
	  		
			foreach($parameters as $par){
				if(is_string($par))$_parameters .= "'" . $par . "',";
				else $_parameters .= "" . $par . ",";
		  	}
			if(strlen($_parameters)>1)$_parameters= substr($_parameters,0,-1);
			
      }

	  $cad = "select " . $function . "(" . $_parameters . ");";
	  $data = DB::select($cad);
	  return $data[0]->$function;
   }
   	
}
