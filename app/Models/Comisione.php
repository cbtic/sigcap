<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Comisione extends Model
{
    use HasFactory;

    public function listar_comision_ajax($p){

        return $this->readFuntionPostgres('sp_listar_municipalidad_comision_paginado',$p);

    }

    public function listar_municipalidad_integrada_ajax($p){

        return $this->readFuntionPostgres('sp_listar_municipalidad_integrada_paginado',$p);

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

    function getComisionAll(){

        $cad = "select c.*,tm.denominacion tipo_comision
        from comisiones c
        inner join tabla_maestras tm on c.id_tipo_comision::int =tm.codigo::int and tm.tipo='102'
        where c.estado='1'  ";
		$data = DB::select($cad);
        return $data;
    }
}
