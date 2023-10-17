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

	function getAgremiado($tipo_documento,$numero_documento){

        if($tipo_documento=="RUC"){
            $cad = "select t1.id,razon_social,t1.direccion,t1.representante 
                    from empresas t1                    
                    Where t1.ruc='".$numero_documento."'";

        }else{
			
			$cad = "select t1.id,nombres,apellido_paterno,apellido_materno,razon_social,t1.foto,t2.codigo,t2.fecha_inicio,t2.ubicacion_id id_ubicacion,
					(select string_agg(numero_tarjeta, ',') from tarjetas tar where tar.persona_id=t2.persona_id and estado='1') tarjeta,
					(select string_agg(t3_.plan_denominacion, ',')
					from personas t1_
					inner join afiliaciones t2_ on t1_.id = t2_.persona_id
					inner join plan_atenciones t3_ on t2_.plan_id=t3_.id
					where t1_.id=t1.id and t1_.estado='1' and t2_.estado='1')afiliacion, t1.ruc ruc_p, 
                    (select ut.id from empresas e inner join ubicacion_trabajos ut on ut.ubicacion_empresa_id = e.id 
					where e.ruc =t1.ruc and e.estado = '1' limit 1) id_ubicacion_p 
					from personas t1
					left join afiliaciones t2 on t1.id = t2.persona_id And t2.estado='1'
					left join ubicacion_trabajos t3 on t2.ubicacion_id = t3.id
					left join empresas t4 on t3.ubicacion_empresa_id = t4.id
                    Where t1.tipo_documento='".$tipo_documento."'
                    And t1.numero_documento='".$numero_documento."'
					and t1.estado='1' 
                    limit 1";
					
        }
		//echo $cad;
		$data = DB::select($cad);
        return $data[0];
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
