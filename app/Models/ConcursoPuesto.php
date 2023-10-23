<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class ConcursoPuesto extends Model
{
    use HasFactory;
	
	function getConcursoPuestoByIdConcurso($id){

        $cad = "select tm.denominacion tipo_plaza,c.numero_plazas 
				from concurso_puestos c
				inner join tabla_maestras tm on c.id_tipo_plaza::int=tm.codigo::int and tm.tipo='93'
				where c.id_concurso=".$id."
				and c.estado='1'";
    
		$data = DB::select($cad);
        return $data;
    }
	
	function getConcursoPuestoById($id){

        $cad = "select *
                from concurso_puestos
                where id=".$id." 
				and estado='1'";
    
		$data = DB::select($cad);
        return $data[0];
    }
	
}
