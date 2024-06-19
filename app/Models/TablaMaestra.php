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
	
	public static function getMaestroByTipoAndSubTipo($tipo,$sub_codigo){

        $cad = "select codigo,denominacion 
                from tabla_maestras 
                where tipo='".$tipo."' 
				and sub_codigo='".$sub_codigo."'
				and estado='1' 
                order by orden ";
    
		$data = DB::select($cad);
        return $data;
    }
	
    function getMaestroByTipoAndDenomina($tipo,$denomina){

        $cad = "select codigo,denominacion 
                from tabla_maestras 
                where tipo='".$tipo."' 
				and denominacion ilike '".$denomina."%'
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

        $cad = "select id,denominacion,codigo  
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

    public function listar_tablaMaestra_ajax($p){

        return $this->readFuntionPostgres('sp_listar_tabla_maestra_paginado',$p);

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

    function getTipoNombre(){

        $cad = "select distinct tm.tipo::int ,tm.tipo_nombre from tabla_maestras tm order by 1 asc";
    
		$data = DB::select($cad);
        return $data;
    }

    function getIdTablaMaestra(){

        $cad = "select tm.id 
        from tabla_maestras tm 
        order by tm.id desc 
        limit 1;";
    
		$data = DB::select($cad);
        return $data;
    }

    function getTipoTablaMaestra($tipo_nombre){

        $cad = "select tm.tipo, tm.denominacion, tm.codigo, tm.tipo_nombre from tabla_maestras tm 
        where tm.tipo ='".$tipo_nombre."'";
    
		$data = DB::select($cad);
        return $data;
    }

    function getMaestroByTipoBySubcogioNull($tipo){

        $cad = "select * from tabla_maestras tm 
                where tm.tipo='".$tipo."' 
                and tm.sub_codigo is null
				and estado='1' 
                order by orden ";
    
		$data = DB::select($cad);
        return $data;
    }

    function getMaestroByTipoByTipoNombre($tipo,$tipoNombre){

        $cad = "select * from tabla_maestras tm 
        where tm.tipo='".$tipo."' 
        and tm.tipo_nombre ilike '".$tipoNombre."'
        and estado='1' 
        order by orden ";
    
		$data = DB::select($cad);
        return $data;
    }
	
}
