<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class EfectivoDetalle extends Model
{
    use HasFactory;

    function getEfectivoDetalleByIdMonedaAndIdEfectivo($id,$id_moneda){ 

        $cad = "select ed.id,id_efectivo,id_tipo_efectivo,cantidad,total,id_moneda,tm.denominacion,abreviatura,codigo 
        from efectivo_detalles ed
        inner join tabla_maestras tm on ed.id_tipo_efectivo=tm.codigo::int and tm.tipo='133'
        where id_efectivo= '".$id."' 
        and ed.id_moneda= '".$id_moneda."'
        order by 1 asc";

        $data = DB::select($cad);
        return $data;

    }


}
