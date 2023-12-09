<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class ConcursoRequisito extends Model
{
    
	function getConcursoRequisitoById($id){

        $cad = "select *
                from concurso_requisitos
                where id=".$id." 
				and estado='1'";
    
		$data = DB::select($cad);
        return $data[0];
    }
	
	
}
