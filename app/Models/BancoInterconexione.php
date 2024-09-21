<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class BancoInterconexione extends Model
{
    use HasFactory;
	
	public function listar_operacion_ajax($p){
		return readFunctionPostgres('sp_listar_agremiado_paginado',$p);
    }
	
}
