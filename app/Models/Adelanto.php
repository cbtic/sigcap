<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Adelanto extends Model
{
    use HasFactory;

    public function listar_adelanto_ajax($p){

        return $this->readFuntionPostgres('sp_listar_adelanto_paginado',$p);
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

    function getAdelantoId($id){ 

        $cad = "select a.id_agremiado, a.total_adelanto, a.fecha from adelantos a 
        where a.id=".$id;

        $data = DB::select($cad);
        return $data;

    }

    public function getDatosAdelanto($id_agremiado){
		
		$cad = "select (select tm.denominacion from comision_delegados cd 
        left join tabla_maestras tm on cd.id_puesto = tm.codigo::int And tm.tipo ='94' 
        where cd.id_agremiado = ".$id_agremiado." order by cd.id desc limit 1) puesto,
        (select c.denominacion from comision_delegados cd 
        left join comisiones c on cd.id_comision = c.id 
        where cd.id_agremiado = '".$id_agremiado."' order by cd.id desc limit 1) comision
        from comision_delegados cd2
        where cd2.estado='1'
        limit 1 ";

		$data = DB::select($cad);
        return $data;
		
	}
}
