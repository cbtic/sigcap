<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class ReporteDeudaTotal extends Model
{
    use HasFactory;

    protected $fillable = [
        'fecha_cierre',
        'fecha_consulta',
        'id_agremiado',
        'monto_total',
        'id_usuario_inserta',
    ];

    protected $table = 'reporte_deuda_total';

    function getReporteDeudaTotalByFechaCierreConsulta($fecha_cierre, $fecha_consulta){

        $cad = "select rdt.id, rdt.fecha_cierre, rdt.fecha_consulta, p.apellido_paterno ||' '|| p.apellido_materno ||' '|| p.nombres agremiado, rdt.monto_total, rdt.estado 
        from reporte_deuda_total rdt 
        inner join agremiados a on rdt.id_agremiado = a.id and a.estado ='1'
        inner join personas p on a.id_persona = p.id 
        where rdt.estado = '1'
        and rdt.fecha_cierre = '".$fecha_cierre."'
        and rdt.fecha_consulta = '".$fecha_consulta."'";

		$data = DB::select($cad);
        if (!empty($data)) {
            return $data[0];
        }

        return "";
    }

    public function agremiado()
    {
        return $this->belongsTo(Agremiado::class, 'id_agremiado');
    }
}

