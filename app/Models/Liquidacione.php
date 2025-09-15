<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Liquidacione extends Model
{
    use HasFactory;

    function getLiquidacionByIdSolicitud($id){

        $cad = "select l.sub_total, l.igv, l.total, l.credipago, l.fecha, l.id 
        from liquidaciones l 
        where id_solicitud ='".$id."'";

        //echo $cad;
		$data = DB::select($cad);
        return $data;
    }

    function anular_liquidacion_7_dias(){
        $p=array();
		return $this->readFunctionPostgresTransaction('sp_crud_anular_liquidacion_7_dias',$p);
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

    function getLiquidacionByCredipago($numero_documento){

      $cad = "select l.id, l.credipago, l.id_situacion from liquidaciones l 
      where l.credipago ='".$numero_documento."'
      and l.estado ='1'
      order by id_situacion asc";
    
		  $data = DB::select($cad);
      return $data;
    }

}
