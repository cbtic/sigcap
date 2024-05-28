<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class InscripcionDocumento extends Model
{
    use HasFactory;
	
	function getConcursoInscripcionDocumentoById($id){

        $cad = "select t1.id,t1.observacion,t2.denominacion tipo_documento,orden_requisito,to_char(fecha_documento,'dd-mm-yyyy')fecha_documento,ruta_archivo 
from inscripcion_documentos t1
left join tabla_maestras t2 on t1.id_tipo_documento = t2.codigo::int And t2.tipo ='97'
where t1.estado='1'
and id_concurso_inscripcion=".$id." 
order by /*t1.observacion*/ coalesce(orden_requisito::int,100000) asc";
		//echo $cad;
		$data = DB::select($cad);
        return $data;
    }
	
}
