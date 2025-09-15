<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Suspensione extends Model
{
    use HasFactory;

    public function listar_suspension_ajax($p){

        return $this->readFuntionPostgres('sp_listar_suspension_paginado',$p);

    }
	
	function actualizarSuspensionAgremiado(){
  
        //$cad = "update periodo_comisiones set estado = '0' where now() not between fecha_inicio and fecha_fin and estado = '1'";
		$p=array();
		return $this->readFunctionPostgresTransaction('sp_crud_agremiado_cuota_eliminar_suspension',$p);
        //echo $cad;
        //$data = DB::select($cad);
        //return $data;
    }
	
    public function readFuntionPostgres($function, $parameters = null){

        $_parameters = '';
        if (count($parameters) > 0) {
            $_parameters = implode("','", $parameters);
            $_parameters = "'" . $_parameters . "',";
        }
        $data = DB::select("BEGIN;");
        $cad = "select " . $function . "(" . $_parameters . "'ref_cursor');";
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

    public function listar_suspension_agremiado($id_agremiado){

        $cad = "select s.id_agremiado, s.fecha_inicio, s.fecha_fin, s.documento from suspensiones s 
        where s.id_agremiado =" .$id_agremiado. " ";
    	//echo $cad;
		$data = DB::select($cad);
        return $data;

    }

}
