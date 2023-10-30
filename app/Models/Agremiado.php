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

        }elseif($tipo_documento=="NRO_CAP"){
			
			$cad = "select t2.id,t1.id id_p,t1.numero_documento,t1.nombres,t1.apellido_paterno,t1.apellido_materno,t2.numero_cap,t1.foto,t1.numero_ruc,t2.fecha_colegiado,t3.denominacion situacion, desc_cliente nombre_completo
					--,razon_social,t1.foto,t2.codigo,t2.fecha_inicio,t2.ubicacion_id id_ubicacion,				
					from personas t1 
					left join agremiados  t2 on t1.id = t2.id_persona And t2.estado='1'
					left join tabla_maestras t3 on t2.id_situacion = t3.codigo::int And t3.tipo ='14'                    
					Where  t2.numero_cap ='".$numero_documento."' and t1.estado='1' 
					limit 1";
								
        }else{
			$cad = "select t2.id,t1.id id_p,t1.numero_documento,t1.nombres,t1.apellido_paterno,t1.apellido_materno,t2.numero_cap,t1.foto,t1.numero_ruc
					--,razon_social,t1.foto,t2.codigo,t2.fecha_inicio,t2.ubicacion_id id_ubicacion,				
					from personas t1 
					left join agremiados  t2 on t1.id = t2.id_persona And t2.estado='1'
					left join tabla_maestras t3 on t2.id_situacion = t3.codigo::int And t3.tipo ='14'                    
					Where  t1.tipo_documento='".$tipo_documento."' and t1.numero_documento = '".$numero_documento."' and t1.estado='1' 
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
