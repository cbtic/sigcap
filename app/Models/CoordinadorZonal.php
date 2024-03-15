<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class CoordinadorZonal extends Model
{
    use HasFactory;

    protected $table = 'coordinador_zonales';

    public function listar_coordinadorZonal_ajax($p){
 
        return $this->readFuntionPostgres('sp_listar_coordinador_zonal_paginado',$p);
        
    }

    public function listar_coordinadorZonalSesion_ajax($p){
 
        return $this->readFuntionPostgres('sp_listar_coordinador_zonal_sesion_paginado',$p);

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
