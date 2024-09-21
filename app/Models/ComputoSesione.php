<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class ComputoSesione extends Model
{
    use HasFactory;
	
	public function getComisionSesionByAnioMes($anio,$mes,$id_periodo_comisione){

        $cad = "select distinct id_comision_sesion 
from comision_sesion_delegados csd 
inner join comision_sesiones cs on csd.id_comision_sesion=cs.id
where to_char(cs.fecha_ejecucion,'yyyy')='".$anio."' 
and to_char(cs.fecha_ejecucion,'mm')='".$mes."'
and csd.estado='1' 
and cs.id_periodo_comisione='".$id_periodo_comisione."'";
		//echo $cad;
		$data = DB::select($cad);
        return $data;
    }
	
	public function getMesComputoById($id_computo_sesion,$anio,$mes){

        $cad = "select 
sum(case when to_char(cs.fecha_programado,'yyyy-mm')='".$anio."-".$mes."' then 1 else 0 end)computo_mes_actual,
sum(case when to_char(cs.fecha_programado,'yyyy-mm-dd')::date<'".$anio."-".$mes."-01'::date then 1 else 0 end)computo_meses_anteriores
from comision_sesiones cs 
inner join comision_sesion_delegados csd on cs.id=csd.id_comision_sesion 
where id_computo_sesion=".$id_computo_sesion."
and id_aprobar_pago='2'";
		//echo $cad;
		$data = DB::select($cad);
        if(isset($data[0]))return $data[0];
    }
	
}
