<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Ubigeo extends Model
{
    use HasFactory;
	
	function getDepartamento(){

        $cad = "select id_departamento,desc_ubigeo 
from ubigeos u 
where id_departamento!='00' 
and id_provincia='00' 
and id_distrito='00' 
and estado='1'
order by desc_ubigeo ";
    
		$data = DB::select($cad);
        return $data;
    }
	
	function getProvincia($id_departamento){

        $cad = "select id_provincia,desc_ubigeo 
from ubigeos u 
where id_departamento!='00' 
and id_provincia!='00' 
and id_distrito='00' 
and id_departamento='".$id_departamento."'
and estado='1'
order by desc_ubigeo";
    
		$data = DB::select($cad);
        return $data;
    }
	
	function getDistrito($id_departamento,$id_provincia){

        $cad = "select id_ubigeo,id_distrito,desc_ubigeo 
from ubigeos u 
where id_departamento!='00' 
and id_provincia!='00' 
and id_distrito!='00' 
and id_departamento='".$id_departamento."'
and id_provincia='".$id_provincia."'
and estado='1'
order by desc_ubigeo ";
    
		$data = DB::select($cad);
        return $data;
    }
	
	
}
