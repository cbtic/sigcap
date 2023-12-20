<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class ComputoSesione extends Model
{
    use HasFactory;
	
	public function getComisionSesionByAnioMes($anio,$mes){

        $cad = "select distinct id_comision_sesion 
from comision_sesion_delegados csd 
where to_char(fecha_aprobar_pago,'yyyy')='".$anio."' 
and to_char(fecha_aprobar_pago,'mm')='".$mes."'
and csd.estado='1'";
		//echo $cad;
		$data = DB::select($cad);
        return $data;
    }
	
}
