<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class RevisorUrbano extends Model
{
    use HasFactory;

    public function listar_revisorUrbano_ajax($p){

        return $this->readFuntionPostgres('sp_listar_revisorurbano_paginado',$p);

    }

	function getCodigoRU(){

        $cad = "select 'RU-'||to_char(now(),'yyyy')||'-'||lpad((coalesce(max(split_part(codigo_ru::varchar, '-', 3)::int),0)+1)::varchar,7,'0') codigo  
                from revisor_urbanos 
                where coalesce(split_part(codigo_ru::varchar, '-', 3),'')!=''
                and split_part(codigo_ru::varchar, '-', 2) = to_char(now(),'yyyy')";
        
		$data = DB::select($cad);
        return $data[0]->codigo;
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
