<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Seguro_afiliado extends Model
{
   
    public function listar_afiliacion_seguro($p){

        return $this->readFuntionPostgres('sp_listar_afiliado_seguro_paginado',$p);

    }

    public function listar_parentesco($p){

        return $this->readFuntionPostgres('sp_listar_parentesco_seguro_paginado',$p);

    }

    public function datos_afiliacion_seguro($id){

        $cad = "select * ,s.id id_seguro 
        from seguro_afiliados sa inner join agremiados a on sa.id_agremiado =a.id inner join seguros s on sa.id_plan =s.id inner join tabla_maestras tm on a.id_situacion  =cast( tm.codigo as integer)  
                where sa.id=".$id. " and tm.tipo='14';  ";
    
		$data = DB::select($cad);
        return $data;

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
}
