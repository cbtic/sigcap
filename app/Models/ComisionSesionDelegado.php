<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class ComisionSesionDelegado extends Model
{
    
	function getComisionDelegadosByIdComision($id_comision){

        $cad = " select 
t1.id,t1.id_agremiado,t1.puesto_postula,t5.periodo,t6.denominacion tipo_concurso,
to_char(t1.created_at,'dd-mm-yyyy')fecha_inscripcion,
t3.numero_documento,t3.nombres,t3.apellido_paterno,t3.apellido_materno,t2.numero_cap,
t7.denominacion situacion,t8.denominacion region,t1.puntaje,t1.resultado,t11.denominacion puesto 
from concurso_inscripciones t1 
inner join agremiados t2 on t1.id_agremiado=t2.id
inner join personas t3 on t2.id_persona=t3.id
inner join concurso_puestos t4 on t1.id_concurso_puesto=t4.id 
inner join concursos t5 on t4.id_concurso=t5.id
inner join tabla_maestras t6 on t5.id_tipo_concurso=t6.codigo::int and t6.tipo='93'
inner join tabla_maestras t7 on t2.id_situacion = t7.codigo::int And t7.tipo ='14' 
inner join regiones t8 on t2.id_regional = t8.id
left join tabla_maestras t11 on t1.puesto_postula::int = t11.codigo::int And t11.tipo ='94' ";

		$data = DB::select($cad);
        return $data;
    }
	
	function getComisionSesionDelegadosByIdComisionSesion($id){

        $cad = " select 
t1.id,t1.id_agremiado,t1.puesto_postula,t5.periodo,t6.denominacion tipo_concurso,
to_char(t1.created_at,'dd-mm-yyyy')fecha_inscripcion,
t3.numero_documento,t3.nombres,t3.apellido_paterno,t3.apellido_materno,t2.numero_cap,
t7.denominacion situacion,t8.denominacion region,t1.puntaje,t1.resultado,t11.denominacion puesto 
from concurso_inscripciones t1 
inner join agremiados t2 on t1.id_agremiado=t2.id
inner join personas t3 on t2.id_persona=t3.id
inner join concurso_puestos t4 on t1.id_concurso_puesto=t4.id 
inner join concursos t5 on t4.id_concurso=t5.id
inner join tabla_maestras t6 on t5.id_tipo_concurso=t6.codigo::int and t6.tipo='93'
inner join tabla_maestras t7 on t2.id_situacion = t7.codigo::int And t7.tipo ='14' 
inner join regiones t8 on t2.id_regional = t8.id
left join tabla_maestras t11 on t1.puesto_postula::int = t11.codigo::int And t11.tipo ='94' ";

		$data = DB::select($cad);
        return $data;
    }
	
	
}
