<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class TablaMaestra extends Model
{
    use HasFactory;
	
	function getMaestroByTipo($tipo){

        $cad = "select codigo,denominacion 
                from tabla_maestras 
                where tipo='".$tipo."' 
				and estado='1' 
                order by orden ";
    
		$data = DB::select($cad);
        return $data;
    }
    function getMaestro($tipo){

        $cad = "select id,denominacion 
                from tabla_maestras 
                where tipo='".$tipo."' 
                order by orden ";
    
		$data = DB::select($cad);
        return $data;
    }
    function getMaestroC($tipo, $codigo){

        $cad = "select id,denominacion 
                from tabla_maestras 
                where tipo='".$tipo."' 
                and codigo ='".$codigo."'
                order by orden ";
    
		$data = DB::select($cad);
        return $data;
    }
	
    function getCaja($tipo){

        $cad = "Select t1.codigo,t1.denominacion 
		from tabla_maestras t1
		where t1.tipo='".$tipo."' and t1.estado='1' 
		And t1.codigo::int not in (select distinct id_caja from caja_ingresos where estado='1')
		order by t1.orden"; 
    
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
