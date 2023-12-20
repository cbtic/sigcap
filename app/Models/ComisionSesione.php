<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class ComisionSesione extends Model
{
    public function lista_programacion_sesion_ajax($p){

        return $this->readFunctionPostgres('sp_listar_programacion_sesion_paginado',$p);

    }
	
	public function lista_computo_sesion_ajax($p){

        return $this->readFunctionPostgres('sp_listar_computo_sesion_paginado',$p);

    }
	
	public function lista_computo_cerrado_ajax($p){

        return $this->readFunctionPostgres('sp_listar_computo_cerrado_paginado',$p);

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
   
}
