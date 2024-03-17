<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Beneficiario extends Model
{
    protected $table = 'concepto_empresa_beneficiarios';
	
	public function listar_empresa_beneficiario($p){

        return $this->readFuntionPostgres('sp_listar_empresa_beneficiario_paginado',$p);

    }

    public function listar_beneficiario_ajax($p){

        return $this->readFuntionPostgres('sp_listar_beneficiario_paginado',$p);

    }
	
    function getBeneficiarioId($id){ 

        $cad = "select p.numero_documento, p.apellido_paterno||' '||p.apellido_materno||' '||p.nombres nombres, p.direccion,p.numero_celular, p.correo from curso_empresa_beneficiarios ceb 
        inner join personas p on ceb.id_persona = p.id 
        inner join empresas e on ceb.id_empresa = e.id 
        where e.id='".$id."'";

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
