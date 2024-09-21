<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class PlanContable extends Model
{
    use HasFactory;

    public function listar_plan_contable_ajax($p){

        return $this->readFuntionPostgres('sp_listar_plan_contable_paginado',$p);

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

    function getPlanContableCuentaContableDebe(){

        $cad = "select distinct id, cuenta from plan_contables pc where cuenta ilike '12%'";
    
		$data = DB::select($cad);
        return $data;
    }

    function getPlanContableCuentaContableHaber1(){

        $cad = "select distinct id, cuenta from plan_contables pc where cuenta ilike '40%'";
    
		$data = DB::select($cad);
        return $data;
    }

    function getPlanContableCuentaContableHaber2(){

        $cad = "select distinct id, cuenta from plan_contables pc where cuenta ilike '70%' or cuenta ilike '75%' ";
    
		$data = DB::select($cad);
        return $data;
    }
}
