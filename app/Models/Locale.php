<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Locale extends Model
{
    use HasFactory;

    function getLocal($id_regional){

        $cad = "select id,denominacion 
        from locales 
        where id_regional=".$id_regional." 
        and estado='1'";
    
		$data = DB::select($cad);
        return $data;
    }

}
