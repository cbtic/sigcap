<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Persona extends Model
{
    //protected $fillable = ['nro_brevete', 'codigo', 'tipo_documento', 'numero_documento', 'nombres', 'apellido_paterno', 'apellido_materno', 'fecha_nacimiento', 'sexo', 'telefono', 'email', 'foto', 'ocupacion', 'titular_id', 'tipo_relacion'];

    protected $fillable = ['numero_documento', 'nombres', 'apellido_paterno', 'apellido_materno', 'fecha_nacimiento', 'sexo', 'estado', 'tipo_documento'];

    // contantes SEXO
    const SEXO_FEMENINO = 'F';
    const SEXO_MASCULINO = 'M';
    // contantes TIPO DOCUMENTO
    const TIPO_DOCUMENTO_DNI = 'DNI';
    const TIPO_DOCUMENTO_CARNET_EXTRANJERIA = 'CARNET_EXTRANJERIA';
    const TIPO_DOCUMENTO_PASAPORTE = 'PASAPORTE';
    const TIPO_DOCUMENTO_RUC = 'RUC';
    const TIPO_DOCUMENTO_CEDULA = 'CEDULA';
    const TIPO_DOCUMENTO_PTP = 'PTP/PTEP';
    const TIPO_DOCUMENTO_CAP = 'NRO_CAP';

    function getPersonaAll()
    {

        $cad = "select id, tipo_documento, numero_documento, concat(apellido_paterno,' ',apellido_materno,' ',nombres) persona,fecha_nacimiento, sexo, estado
        from personas
        order by id desc";
        $data = DB::select($cad);
        return $data;
    }
    //use HasFactory;

    function getPersonaBuscar($term)
    {

        $cad = "select id,apellido_paterno||' '||apellido_materno||' '||nombres persona 
		from personas 
		where estado='A' 
		and nombres||' '||apellido_paterno||' '||apellido_materno ilike '%" . $term . "%' ";

        $data = DB::select($cad);
        return $data;
    }

    public function listar_persona_ajax($p)
    {
        return $this->readFunctionPostgres('sp_listar_persona_paginado', $p);
    }

    public function listar_persona2_ajax($p)
    {

        return $this->readFunctionPostgres('sp_listar_persona_paginado', $p);
    }

    public function readFunctionPostgres($function, $parameters = null)
    {

        $_parameters = '';
        if (count($parameters) > 0) {
            $_parameters = implode("','", $parameters);
            $_parameters = "'" . $_parameters . "',";
        }
        $data = DB::select("BEGIN;");
        $cad = "select " . $function . "(" . $_parameters . "'ref_cursor');";
        $data = DB::select($cad);
        $cad = "FETCH ALL IN ref_cursor;";
        $data = DB::select($cad);
        return $data;
    }

    /*
     function getPersonas($empresa_id){
        $ubicacion = UbicacionTrabajo::where("ubicacion_empresa_id", $empresa_id)->first();
        $afiliaciones = Afiliacion::where("ubicacion_id", $ubicacion->id)->get("persona_id");
        $data = Persona::find($afiliaciones);
        // dd($data);
        return $data;
    }
    */

    function getPersona($tipo_documento, $numero_documento)
    {

        $cad = "select p.id, p.id_tipo_documento, p.numero_documento, p.apellido_paterno, p.apellido_materno, p.nombres, p.fecha_nacimiento, p.id_sexo, p.direccion, a.id_situacion, p.numero_celular, p.correo
		from personas p 
		left join agremiados a on p.id=a.id_persona
		Where p.id_tipo_documento='" . $tipo_documento . "' And p.numero_documento='" . $numero_documento . "'";

        $data = DB::select($cad);
        return $data[0];
    }

    function getAgremiadoDatos($numero_cap, $id_secret_code)
    {

        $cad = "select a.id,a.numero_cap, pe.numero_documento, pe.apellido_paterno, pe.apellido_materno, pe.nombres,tm.denominacion tipo_documento,
        a.celular1,a.celular2,a.email1,a.email2,a.direccion,a.clave
        from agremiados a
		inner join personas pe on a.id_persona = pe.id
        left join tabla_maestras tm on pe.id_tipo_documento = tm.codigo::int And tm.tipo ='16'                    
		where a.numero_cap =  '" . $numero_cap . "' and a.clave='" . $id_secret_code . "'";

        $data = DB::select($cad);

        return $data[0];
    }

    function getProyectistaByProfesion($id_profesion, $buscar)
    {

        $cad = "select p.id
 from registro_proyectistas p 
left join agremiados a on p.id_agremiado=a.id and a.estado='1'
left join profesion_otros po on p.id_profesion_otro=po.id and po.estado='1'
where 1=1 ";

        if ($id_profesion == 1) {
            $cad .= " and a.numero_cap = '" . $buscar . "'";
        }

        if ($id_profesion == 2) {
            $cad .= " and po.colegiatura = '" . $buscar . "'";
        }

        $cad .= " and p.estado='1'";

        $data = DB::select($cad);

        return $data;
    }

    function getPersonaExt($tipo_documento, $numero_documento)
    {

        if ($tipo_documento == "RUC") {
            /*$cad = "select t1.id,razon_social,t1.direccion,t1.representante,t2.id id_ubicacion
                    from empresas t1
                    inner join ubicacion_trabajos t2 on t1.id=t2.ubicacion_empresa_id
                    Where t1.ruc='".$numero_documento."'";*/
        } else {
            $cad = "Select codigo,tipo_documento,numero_documento,nombres,apellido_paterno,apellido_materno,fecha_nacimiento::date,sexo,telefono,email,foto,'A' estado From dblink ('dbname=" . config('values.dblink_dbname') . " port=" . config('values.dblink_port') . " host=" . config('values.dblink_host') . " user=" . config('values.dblink_user') . " password=" . config('values.dblink_password') . "','select codigo,tipo_documento,numero_documento,nombres,apellido_paterno,apellido_materno,fecha_nacimiento,sexo,telefono,email,foto,estado from personas where numero_documento=''" . $numero_documento . "'' and tipo_documento=''" . $tipo_documento . "''')ret
(codigo varchar,tipo_documento varchar,numero_documento varchar,nombres varchar,apellido_paterno varchar,apellido_materno varchar,fecha_nacimiento varchar,sexo varchar,telefono varchar,email varchar,foto varchar,estado varchar)";
        }
        //echo $cad;
        $data = DB::select($cad);
        if (isset($data[0])) return $data[0];
    }

    function getPersonaBuscarT($tipo_documento, $numero_documento)
    {

        if ($tipo_documento == "RUC") {
            /*$cad = "select t1.id,razon_social,t1.direccion,t1.representante,t2.id id_ubicacion
                    from empresas t1
                    inner join ubicacion_trabajos t2 on t1.id=t2.ubicacion_empresa_id
                    Where t1.ruc='".$numero_documento."'";*/
        } else {
            $cad = "Select codigo,tipo_documento,numero_documento,nombres,apellido_paterno,apellido_materno,fecha_nacimiento::date,sexo,telefono,email,foto,'A' estado From dblink ('dbname=" . config('values.dblink_dbname') . " port=" . config('values.dblink_port') . " host=" . config('values.dblink_host') . " user=" . config('values.dblink_user') . " password=" . config('values.dblink_password') . "','select codigo,tipo_documento,numero_documento,nombres,apellido_paterno,apellido_materno,fecha_nacimiento,sexo,telefono,email,foto,estado from personas where numero_documento=''" . $numero_documento . "'' ')ret
(codigo varchar,tipo_documento varchar,numero_documento varchar,nombres varchar,apellido_paterno varchar,apellido_materno varchar,fecha_nacimiento varchar,sexo varchar,telefono varchar,email varchar,foto varchar,estado varchar)";
        }
        //echo $cad;
        $data = DB::select($cad);
        if (isset($data[0])) return $data[0];
    }

    function apiperu_dev($dni)
    {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://apiperu.dev/api/dni/' . $dni,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer 20b6666ddda099db4204cf53854f8ca04d950a4eead89029e77999b0726181cb',
                'Cookie: XSRF-TOKEN=eyJpdiI6InNWRHJxUGpDT3pqSVRkUlFFTm5XMHc9PSIsInZhbHVlIjoiREtNUVFoTytVcHhRQmdFSGo2ejV1SVBhMnExYmpMc25ZYTZSdlEwYmRJekhDWUVpMC94bFJqeWs5T1pKN1RuUHdYNHhUalI4SXJOYVJoSzFOcUs1MDNiTitRamkxTm5TTElkUU1JMGdPK2ZteXlDQ1I4YkVBZFdrYis1QndCOUsiLCJtYWMiOiJlMjQ4ZWZmZmY0OTQzMDhlYjYyMTljOWVmMjI4ZWQ2M2Q1NTFkYjE2MmZhYWNlMzRkZWI1MmJhZGM2MmY0NjFkIn0%3D; apiperu_session=eyJpdiI6IjVkbkpDQ1MwVGx3THFiR0g0UjlyMnc9PSIsInZhbHVlIjoiUk5IWTFoYjVhWXJGaEhiQ2NMQ1phRHV5RjR5QWxVKzgrRjhpaVRRckQ3OGIrQUpSdk1tcXNTdmRKYk95Rml0MlVkWVdsSHlEbXcvcmNxUFNiNGp2SzdTWHJhYmtnck5KenFla1dPQ0lId3hWZitXaVkyNEtOR25GdVhibHVCS2QiLCJtYWMiOiI2OGI2MTFjNjhjMDFmY2UzMzhlOTJhNGJkZTUzZjY5MDU2ZWNkNDA4OGRkNjlmYjVjY2RlOGQ3ZDljY2E0ZDMxIn0%3D'
            ),
        ));
        //exit($dni);
        $response = curl_exec($curl);
        //echo($response);exit();

        curl_close($curl);
        return $response;
    }

    function getPersona_ListaAll()
    {

        $cad = "select * from personas
        where estado='1'
        order by id desc";
        $data = DB::select($cad);
        return $data;
    }

    function getPersonaDni($numero_documento)
    {

        $cad = "select p.id, p.numero_documento, p.apellido_paterno, p.apellido_materno, p.nombres
		from personas p
		Where p.numero_documento='" . $numero_documento . "'";
        //echo $cad;
        $data = DB::select($cad);
        return $data[0];
    }

    function getPersonaDniPropietario($numero_documento)
    {

        $cad = "select p.id, p.apellido_paterno|| ' ' ||p.apellido_materno || ', ' || p.nombres nombres, p.direccion, p.numero_celular, p.correo, p.correo, p.fecha_nacimiento,p.apellido_paterno, p.apellido_materno, p.nombres nombre 
        from personas p
        Where p.numero_documento='" . $numero_documento . "'";
        //echo $cad;
        $data = DB::select($cad);
        return $data[0];
    }

    function getPersonaById($tipo_documento, $id_persona)
    {

        $cad = "select p.id, p.id_tipo_documento, p.numero_documento, p.apellido_paterno, p.apellido_materno, p.nombres, p.fecha_nacimiento, p.id_sexo, p.direccion, a.id_situacion, p.numero_celular, p.correo
        from personas p 
        left join agremiados a on p.id=a.id_persona
        Where p.id_tipo_documento='" . $tipo_documento . "' And p.id='" . $id_persona . "'
        union all
        select p.id, p.id_tipo_documento, p.numero_documento, p.apellido_paterno, p.apellido_materno, p.nombres, p.fecha_nacimiento, p.id_sexo, p.direccion, null, p.numero_celular, p.correo 
        from profesion_otros po 
        inner join personas p on po.id_persona = p.id
        where p.id='" . $id_persona . "'";

        $data = DB::select($cad);
        return $data[0];
    }
}
