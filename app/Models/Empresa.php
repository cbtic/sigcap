<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Empresa extends Model
{
    use HasFactory;

    public function listar_empresa_ajax($p){

        return $this->readFuntionPostgres('sp_listar_empresa_paginado',$p);

    }

    function getEmpresaId($id){


        $cad = "select id, ruc, nombre_comercial, razon_social, direccion, representante, estado, email, telefono
        from empresas         
        Where id='".$id."' ";
    
        $data = DB::select($cad);
        if($data)return $data[0];
    }
	
    function getPersonaId($id){

        $cad = "select numero_ruc ruc, apellido_paterno||' '||apellido_materno||' '||nombres nombre_comercial, apellido_paterno||' '||apellido_materno||' '||nombres razon_social,  direccion, correo email
        from personas
        Where id='".$id."' ";
    
        $data = DB::select($cad);
        if($data)return $data[0];
    }

    function getPersonaId_BV($id){

        $cad = "select numero_documento ruc, apellido_paterno||' '||apellido_materno||' '||nombres nombre_comercial, apellido_paterno||' '||apellido_materno||' '||nombres razon_social,  direccion, correo email
        from personas
        Where id='".$id."' ";
    
        $data = DB::select($cad);
        if($data)return $data[0];
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

    function getEmpresaPropietario($ruc_propietario){

        $cad = "select e.id, e.razon_social, e.direccion, e.telefono, e.email 
        from empresas e
        Where e.ruc='".$ruc_propietario."'";
		//echo $cad;
		$data = DB::select($cad);
        return $data[0];
    }

}
