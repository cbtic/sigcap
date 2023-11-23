<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class ComisionSesione extends Model
{
    public function lista_programacion_sesion_ajax($p){

        return $this->readFuntionPostgres('sp_listar_programacion_sesion_paginado',$p);

    }
}
