<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class DelegadoReintegroDetalle extends Model
{
    use HasFactory;

    function getReintegroDetalle($id_agremiado){

        $cad = "select drd.id, p.apellido_paterno ||' '|| p.apellido_materno ||' '|| p.nombres agremiado, tm.denominacion tipo_reintegro, tm2.denominacion mes_reintegrar, tm3.denominacion mes_ejecuta_reintegro, drd.cantidad, drd.importe, drd.estado 
        from delegado_reintegro_detalles drd 
        inner join delegado_reintegros dr on drd.id_delegado_reintegro = dr.id
        inner join comision_delegados cd on dr.id_delegado=cd.id
        inner join agremiados a on cd.id_agremiado = a.id
        inner join personas p on a.id_persona = p.id
        inner join tabla_maestras tm on drd.id_tipo_reintegro = tm.codigo::int and  tm.tipo ='74'
        inner join tabla_maestras tm2 on drd.id_mes = tm2.codigo::int and  tm2.tipo ='116'
        inner join tabla_maestras tm3 on dr.id_mes_ejecuta_reintegro = tm3.codigo::int and  tm3.tipo ='116'
        where dr.id ='".$id_agremiado."' 
        and drd.estado='1'";
    
		$data = DB::select($cad);
        return $data;
    }
}
