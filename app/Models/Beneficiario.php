<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Beneficiario extends Model
{
    protected $table = 'curso_empresa_beneficiarios';

    function getBeneficiarioId($id){ 

        $cad = "select p.numero_documento, p.apellido_paterno||' '||p.apellido_materno||' '||p.nombres nombres, p.direccion,p.numero_celular, p.correo from curso_empresa_beneficiarios ceb 
        inner join personas p on ceb.id_persona = p.id 
        inner join empresas e on ceb.id_empresa = e.id 
        where e.id='".$id."'";

        $data = DB::select($cad);
        return $data;

    }
}
