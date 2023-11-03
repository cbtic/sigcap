<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class InscripcionDocumento extends Model
{
    use HasFactory;
	
	function getConcursoInscripcionDocumentoById($id){

        $cad = "select t1.id,t1.observacion,t2.denominacion tipo_documento,to_char(fecha_documento,'dd-mm-yyyy')fecha_documento,ruta_archivo 
from inscripcion_documentos t1
left join tabla_maestras t2 on t1.id_tipo_documento = t2.codigo::int And t2.tipo ='97'
where id_concurso_inscripcion=".$id;
		//echo $cad;
		$data = DB::select($cad);
        return $data;
    }
	
}
