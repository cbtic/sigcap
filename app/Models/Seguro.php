<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Seguro extends Model
{
   
    public function listar_seguro($p){

        return $this->readFuntionPostgres('sp_listar_seguro_paginado',$p);

    }

    public function listar_plan($p){

        return $this->readFuntionPostgres('sp_listar_seguro_plan_paginado',$p);

    }

    function getSeguroAll(){

        $cad = "select s.*
        from seguros s
        where s.estado='1'
        and exists 
        (select 1 from seguros_planes sp 
        where sp.id_seguro = s.id
        and current_date between sp.fecha_inicio and sp.fecha_fin)
        order by s.nombre";
    
		$data = DB::select($cad);
        return $data;
    }


    function getPlanId($p){

        $cad = "select *
                from seguro_planes
                where estado='1' and id_seguro=". $p . 
                " order by nombre ";
    
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
