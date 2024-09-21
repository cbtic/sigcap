<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class DelegadoReintegro extends Model
{
    use HasFactory;
	
	public function listar_reintegro_ajax($p){

        return $this->readFuntionPostgres('sp_listar_reintegro_paginado',$p);

    }
	
	function actualizaImporteTotalReintegro($id_delegado_reintegro){

        $cad = "update delegado_reintegros set importe_total=(select coalesce(sum(importe),0) from delegado_reintegro_detalles drd where id_delegado_reintegro=".$id_delegado_reintegro." and estado='1') where id=".$id_delegado_reintegro;
    
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
