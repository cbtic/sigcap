<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Suspensione extends Model
{
    use HasFactory;

    public function listar_suspension_ajax($p){

        return $this->readFuntionPostgres('sp_listar_suspension_paginado',$p);

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

    public function listar_suspension_agremiado($id_agremiado){

        $cad = "select s.id_agremiado, s.fecha_inicio, s.fecha_fin, s.documento from suspensiones s 
        where s.id_agremiado =" .$id_agremiado. " ";
    	//echo $cad;
		$data = DB::select($cad);
        return $data;

    }

}
