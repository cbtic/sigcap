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
	
	public function getMesComputoById($id_computo_sesion,$anio,$mes){

        $cad = "select 
sum(case when to_char(cs.fecha_programado,'yyyy')='".$anio."' and to_char(cs.fecha_programado,'mm')='".$mes."' then 1 else 0 end)computo_mes_actual,
sum(case when to_char(cs.fecha_programado,'yyyy')='".$anio."' and to_char(cs.fecha_programado,'mm')<'".$mes."' then 1 else 0 end)computo_meses_anteriores
from comision_sesiones cs 
inner join comision_sesion_delegados csd on cs.id=csd.id_comision_sesion 
where id_computo_sesion=".$id_computo_sesion."
and id_aprobar_pago='2'";
		//echo $cad;
		$data = DB::select($cad);
        if(isset($data[0]))return $data[0];
    }
	
}
