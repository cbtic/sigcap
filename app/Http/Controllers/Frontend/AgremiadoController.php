<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Persona;
use App\Models\Agremiado;
use App\Models\AgremiadoExperienciaLaborale;
use App\Models\AgremiadoIdioma;
use App\Models\AgremiadoEstudio;
use App\Models\AgremiadoSeguro;
use App\Models\AgremiadoTrabajo;
use App\Models\TablaMaestra;

class AgremiadoController extends Controller
{
	
	public function index(){
        
		$tablaMaestra_model = new TablaMaestra;
		$tipo_documento = $tablaMaestra_model->getMaestroByTipo(16);
		$tipo_zona = $tablaMaestra_model->getMaestroByTipo(34);
		$estado_civil = $tablaMaestra_model->getMaestroByTipo(3);
		$sexo = $tablaMaestra_model->getMaestroByTipo(2);
		$nacionalidad = $tablaMaestra_model->getMaestroByTipo(5);
		$seguro_social = $tablaMaestra_model->getMaestroByTipo(13);
		$actividad_gremial = $tablaMaestra_model->getMaestroByTipo(46);
		$ubicacion_cliente = $tablaMaestra_model->getMaestroByTipo(63);
		$autoriza_tramite = $tablaMaestra_model->getMaestroByTipo(45);
		$situacion_cliente = $tablaMaestra_model->getMaestroByTipo(14);
		
		return view('frontend.agremiado.create',compact('tipo_documento','tipo_zona','estado_civil','sexo','nacionalidad','seguro_social','actividad_gremial','ubicacion_cliente','autoriza_tramite','situacion_cliente'));
    }
	    
	public function importar_agremiado(){ 
		
		/*************WEB SERVICE - LEER TOKEN*****************/
		
		$data_string = '{"email":"pbravogutarra@gmail.com","password":"ua5DhY3oFDZ7aKg"}';
		$ch = curl_init('https://integracion.portalcap2.org.pe/api/v1/auth');		
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json'
		));
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		
		$resultWebApi = curl_exec($ch);
		
		if($errno = curl_errno($ch)) {
			$error_message = curl_strerror($errno);
			echo "cURL error ({$errno}):\n {$error_message}";
		}

		$dataWebApi = json_decode($resultWebApi);
		$token = $dataWebApi->token;
		
		//exit($token);
		
		/*************WEB SERVICE - LEER AGREMIADO*****************/
		
		$ch2 = curl_init('https://integracion.portalcap2.org.pe/api/v1/collegiate/?idRegional=13&fecha=17-08-2023');		
		curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch2, CURLOPT_HTTPHEADER, array('x-token: '.$token));
		curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
		
		$resultWebApi2 = curl_exec($ch2);
		
		if($errno = curl_errno($ch2)) {
			$error_message = curl_strerror($errno);
			echo "cURL error ({$errno}):\n {$error_message}";
		}
		//print_r($resultWebApi2);exit();
		$dataWebApi2 = json_decode($resultWebApi2);
		$ok = $dataWebApi2->ok;
		$data = $dataWebApi2->data;
		
		//echo $ok;
		//dd($data);
		//exit();
		
		/*************INSTAR AGREMIADO*****************/
		
		foreach($data as $solicitud){
			
			$sexo="";
			if($solicitud->idsexo==11)$sexo="M";
			else $sexo="F";
			
			$persona = new Persona;
			$persona->id_tipo_documento = $this->equivalenciaTipoDocumento($solicitud->idtipodocumento);
			$persona->numero_documento = $solicitud->numerodocumento;
			$persona->apellido_paterno = $solicitud->apellidopaterno;
			$persona->apellido_materno = $solicitud->apellidomaterno;
			$persona->nombres = $solicitud->nombre;
			$persona->fecha_nacimiento = $solicitud->fechanacimiento;
			$persona->sexo = $sexo;
			$persona->id_tipo_persona = 1;
			$persona->estado = 1;
			$persona->id_usuario_inserta = 1;
			$persona->save();
			$id_persona = $persona->id;
			
			$agremiado = new Agremiado;
			$agremiado->id_persona = $id_persona;
			$agremiado->numero_cap = $solicitud->numerocap;
			$agremiado->id_situacion = "74";
			$agremiado->id_usuario_inserta = 1;
			$agremiado->save();
			$id_agremiado = $agremiado->id;	
			
			
			foreach($solicitud->datoslaborales as $datoLaboral){
				
				$modalidad = false;
				if($datoLaboral->nombre_modalidad_trabajo=="DEPENDIENTE")$modalidad = true;
				
				$id_departamento = str_pad($datoLaboral->id_departamento, 2, "0", STR_PAD_LEFT);
				$id_provincia = str_pad($datoLaboral->id_provincia, 2, "0", STR_PAD_LEFT);
				$id_distrito = str_pad($datoLaboral->id_distrito, 2, "0", STR_PAD_LEFT);
				$id_ubigeo = $id_departamento.$id_provincia.$id_distrito;
				
				$agremiadoTrabajo = new AgremiadoTrabajo;
				$agremiadoTrabajo->id_agremiado = $id_agremiado;
				//$agremiadoTrabajo->id_persona = "1";
				$agremiadoTrabajo->modalidad = $modalidad;
				$agremiadoTrabajo->numero_documento = $datoLaboral->numero_ruc;
				$agremiadoTrabajo->razon_social = $datoLaboral->nombre_razon_social;
				$agremiadoTrabajo->id_cliente_cargo = "0";
				$agremiadoTrabajo->rubro_negocio = $datoLaboral->nombre_rubro;
				$agremiadoTrabajo->id_ubigeo = $id_ubigeo;
				$agremiadoTrabajo->direccion = $datoLaboral->nombre_direccion_trabajo;
				$agremiadoTrabajo->referencia = $datoLaboral->referencia_direccion;
				$agremiadoTrabajo->codigo_postal = null;
				$agremiadoTrabajo->telefono = $datoLaboral->telefono_fijo_trabajo;
				$agremiadoTrabajo->celular = $datoLaboral->telefono_celular_trabajo;
				$agremiadoTrabajo->email = $datoLaboral->correo_electronico_trabajo;
				$agremiadoTrabajo->estado = 1;
				$agremiadoTrabajo->id_usuario_inserta = 1;
				$agremiadoTrabajo->save();
			
			}
			
			foreach($solicitud->idioma as $idioma){
				
				$agremiadoIdioma = new AgremiadoIdioma;
				$agremiadoIdioma->id_agremiado = $id_agremiado;
				$agremiadoIdioma->id_idioma = $this->equivalenciaIdioma($idioma->id_idiomas);
				$agremiadoIdioma->id_grado_conocimiento = $this->equivalenciaTipoNivel($idioma->id_nivel);
				$agremiadoIdioma->estado = 1;
				$agremiadoIdioma->id_usuario_inserta = 1;
				$agremiadoIdioma->save();
				
			}
			
			foreach($solicitud->estudio as $estudio){
				
				$agremiadoEstudio = new AgremiadoEstudio;
				$agremiadoEstudio->id_agremiado = $id_agremiado;
				$agremiadoEstudio->id_universidad = $this->equivalenciaUniversidad($estudio->id_universidad);
				$agremiadoEstudio->id_especialidad = "1";
				$agremiadoEstudio->tesis = $estudio->nombre_tesis;
				$agremiadoEstudio->fecha_egresado = $estudio->fecha_egresado;
				$agremiadoEstudio->fecha_graduado = $estudio->fecha_graduado;
				$agremiadoEstudio->libro = $estudio->libro;
				$agremiadoEstudio->folio = $estudio->folio;
				$agremiadoEstudio->estado = 1;
				$agremiadoEstudio->id_usuario_inserta = 1;
				$agremiadoEstudio->save();
				
			}
			/*
			foreach($solicitud->otroestudio as $otroestudio){
			
			}
			*/
			foreach($solicitud->parentesco as $parentesco){
				
				$agremiadoSeguro = new AgremiadoSeguro;
				$agremiadoSeguro->id_agremiado = $id_agremiado;
				//$agremiadoSeguro->id_persona = $id_persona;
				$agremiadoSeguro->id_parentesco = $this->equivalenciaTipoParentesco($parentesco->id_parentezco);
				$agremiadoSeguro->id_region = "5";
				$agremiadoSeguro->fecha_inicio = null;
				$agremiadoSeguro->fecha_fin = null;
				$agremiadoSeguro->estado = 1;
				$agremiadoSeguro->id_usuario_inserta = 1;
				$agremiadoSeguro->save();
				
			}
			
			
		}
		
		/*
		$persona = new Persona;
		$persona->id_tipo_documento = 1;//(ok)
		$persona->numero_documento = 21532344;//(ok)
		$persona->apellido_paterno = 'Rojas1';//(ok)
		$persona->apellido_materno = 'Medina1';//(ok)
		$persona->nombres = 'Julio1';//(ok)
		$persona->fecha_nacimiento = '1985-12-09';//(ok)
		$persona->sexo = 'M';//(ok)
		$persona->id_tipo_persona = 1;
		$persona->estado = 1;
		$persona->id_usuario_inserta = 1;
		$persona->save();
		$id_persona = $persona->id;
		
		$agremiado = new Agremiado;
		$agremiado->id_persona = $id_persona;
		$agremiado->numero_cap = "222333";//(ok)
		$agremiado->id_situacion = "2";//(ok)
		$agremiado->id_usuario_inserta = 1;
		$agremiado->save();
		$id_agremiado = $agremiado->id;
		
		$agremiadoExperienciaLaborale = new AgremiadoExperienciaLaborale;
		$agremiadoExperienciaLaborale->id_agremiado = $id_agremiado;
		$agremiadoExperienciaLaborale->id_experiencia_laboral = "1";
		$agremiadoExperienciaLaborale->estado = 1;
		$agremiadoExperienciaLaborale->id_usuario_inserta = 1;
		$agremiadoExperienciaLaborale->save();
		
		$agremiadoIdioma = new AgremiadoIdioma;
		$agremiadoIdioma->id_agremiado = $id_agremiado;
		$agremiadoIdioma->id_idioma = "1";
		$agremiadoIdioma->id_grado_conocimiento = "1";
		$agremiadoIdioma->estado = 1;
		$agremiadoIdioma->id_usuario_inserta = 1;
		$agremiadoIdioma->save();
		
		$agremiadoEstudio = new AgremiadoEstudio;
		$agremiadoEstudio->id_agremiado = $id_agremiado;
		$agremiadoEstudio->id_universidad = "1";
		$agremiadoEstudio->id_especialidad = "1";
		$agremiadoEstudio->estado = 1;
		$agremiadoEstudio->id_usuario_inserta = 1;
		$agremiadoEstudio->save();
		
		$agremiadoSeguro = new AgremiadoSeguro;
		$agremiadoSeguro->id_agremiado = $id_agremiado;
		$agremiadoSeguro->id_persona = $id_persona;
		$agremiadoSeguro->id_parentesco = "1";
		$agremiadoSeguro->id_region = "1";
		$agremiadoSeguro->fecha_inicio = "24-09-2023";
		$agremiadoSeguro->fecha_fin = "24-09-2025";
		$agremiadoSeguro->estado = 1;
		$agremiadoSeguro->id_usuario_inserta = 1;
		$agremiadoSeguro->save();
		*/
		
		//exit();
		/*************WEB SERVICE - ACTUALIZAR*****************/
		/*
		$data_string3 = '{"idSolicitud":1}';
		$ch3 = curl_init('https://integracion.portalcap2.org.pe/api/v1/collegiate/');		
		curl_setopt($ch3, CURLOPT_CUSTOMREQUEST, "PUT");
		curl_setopt($ch3, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch3, CURLOPT_POSTFIELDS, $data_string3);
		curl_setopt($ch3, CURLOPT_HTTPHEADER, array('x-token: '.$token, 'Content-Type: application/json'));
		curl_setopt($ch3, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch3, CURLOPT_SSL_VERIFYPEER, false);
		
		$resultWebApi3 = curl_exec($ch3);
		
		if($errno = curl_errno($ch3)) {
			$error_message = curl_strerror($errno);
			echo "cURL error ({$errno}):\n {$error_message}";
		}
		//print_r($resultWebApi3);exit();
		$dataWebApi3 = json_decode($resultWebApi3);
		//print_r($dataWebApi3);
		
		$ok = $dataWebApi2->ok;
		$data = $dataWebApi2->data;
		*/
				
		
	
	}
	
	public function equivalenciaIdioma($idioma){
		
		$idioma_nuevo = 0;
		
		switch ($idioma) {
		  case "19":
			$idioma_nuevo=1;//INGLES
			break;
		  case "20":
			$idioma_nuevo=2;//FRANCES
			break;
		  case "21":
			$idioma_nuevo=3;//ITALIANO
			break;
		  case "22":
			$idioma_nuevo=4;//PORTUGUES
			break;
		  case "23":
			$idioma_nuevo=5;//ALEMÁN
			break;
		  case "24":
			$idioma_nuevo=999;//OTROS
			break;
		  case "86":
			$idioma_nuevo=999;//ESPAÑOL
			break;
		  default:
			$idioma_nuevo=999;//NO EXISTE EN SQL
		}
		
		return $idioma_nuevo;
	
	}
	
	public function equivalenciaTipoNivel($id_nivel){
		
		$id_nivel_nuevo = 0;
		
		switch ($id_nivel) {
		  case "87":
			$id_nivel_nuevo=80;//BASICO
			break;
		  case "88":
			$id_nivel_nuevo=81;//INTERMEDIO
			break;
		  case "89":
			$id_nivel_nuevo=82;//AVANZADO
			break;
		}
		
		return $id_nivel_nuevo;
	
	}
	
	public function equivalenciaTipoDocumento($idtipodocumento){
		
		$idtipodocumento_nuevo = 0;
		
		switch ($idtipodocumento) {
		  case "1":
			$idtipodocumento_nuevo=78;//DNI
			break;
		  case "2":
			$idtipodocumento_nuevo=84;//CARNÉ DE EXTRANJERÍA
			break;
		  case "3":
			$idtipodocumento_nuevo=79;//RUC
			break;
		  case "4":
			$idtipodocumento_nuevo=85;//PASAPORTE
			break;
		  case "5":
			$idtipodocumento_nuevo=259;//OTROS DOCUMENTOS DE IDENTIDAD
			break;
		  case "6":
			$idtipodocumento_nuevo=259;//OTROS DOCUMENTOS DE IDENTIDAD
			break;
		}
		
		return $idtipodocumento_nuevo;
	
	}
	
	public function equivalenciaUniversidad($id_universidad){
		
		$id_universidad_nuevo = 0;
		
		switch ($id_universidad) {
		  case "999":
			$id_universidad_nuevo=1;//ESCUELA TECNICA SUPERIOR DE ARQUITECTURA CORUÑA
			break;
		  case "999":
			$id_universidad_nuevo=2;//EXTRANJERO
			break;
		  case "19":
			$id_universidad_nuevo=3;//PILOTO DE COLOMBIA
			break;
		  case "79":
			$id_universidad_nuevo=4;//POLITECNICO DE MILANO
			break;
		  case "64":
			$id_universidad_nuevo=5;//PONTIFICIA UNIV. CATOLICA DE VALPARAISO
			break;
		  case "44":
			$id_universidad_nuevo=6;//PONTIFICIA UNIVERSIDAD CATOLICA DEL PERU
			break;
		  case "42":
			$id_universidad_nuevo=7;//UNIV. ALAS PERUANAS
			break;
		  case "60":
			$id_universidad_nuevo=8;//UNIV. CATOLICA DE SANTA MARIA
			break;
		  case "63":
			$id_universidad_nuevo=9;//UNIV. CIENTIFICA DEL PERU
			break;
		  case "999":
			$id_universidad_nuevo=10;//UNIV. ESTATAL DE GUAYAQUIL
			break;
		  case "65":
			$id_universidad_nuevo=11;//UNIV. JOSE ANTONIO ECHEVARRIA
			break;
		  case "41":
			$id_universidad_nuevo=12;//UNIV. NACIONAL JORGE BASADRE GROHMANN
			break;
		  case "87":
			$id_universidad_nuevo=13;//UNIV. NAVARRA
			break;
		  case "90":
			$id_universidad_nuevo=14;//UNIV. POLITECNICA CATALUÑA ESPAÑA
			break;
		  case "67":
			$id_universidad_nuevo=15;//UNIV. POLITECNICA DE MADRID
			break;
		  case "96":
			$id_universidad_nuevo=16;//UNIV. SAN IGNACIO DE LOYOLA
			break;
		  case "62":
			$id_universidad_nuevo=17;//UNIV. SAN PEDRO- CHIMBOTE
			break;
		  case "68":
			$id_universidad_nuevo=17;//UNIV. SAN PEDRO- CHIMBOTE
			break;
		  case "17":
			$id_universidad_nuevo=18;//UNIV.AUTONOMA DE GUADALAJARA
			break;
		  case "35":
			$id_universidad_nuevo=19;//UNIV.AUTONOMA DE PUEBLA
			break;
		  case "39":
			$id_universidad_nuevo=20;//UNIV.CATOLICA DE CHILE
			break;
		  case "999":
			$id_universidad_nuevo=21;//UNIV.CATOLICA DEL ECUADOR
			break;
		  case "32":
			$id_universidad_nuevo=22;//UNIV.CATOLICA NUESTRA SRA. DE LA ASUNCION
			break;
		  case "55":
			$id_universidad_nuevo=23;//UNIV.CENTRAL DE VENEZUELA
			break;
		  case "15":
			$id_universidad_nuevo=24;//UNIV.CESAR VALLEJO
			break;
		  case "43":
			$id_universidad_nuevo=25;//UNIV.DE ARQUITECTURA DE MOSCU
			break;
		  case "70":
			$id_universidad_nuevo=26;//UNIV.DE BRASILIA
			break;
		  case "28":
			$id_universidad_nuevo=27;//UNIV.DE BUENOS AIRES
			break;
		  case "47":
			$id_universidad_nuevo=29;//UNIV.DE CAMAGUEY
			break;
		  case "23":
			$id_universidad_nuevo=30;//UNIV.DE GAMA FILHO
			break;
		  case "26":
			$id_universidad_nuevo=31;//UNIV.DE MIAMI
			break;
		  case "34":
			$id_universidad_nuevo=32;//UNIV.DE MINAS GERAIS
			break;
		  case "25":
			$id_universidad_nuevo=33;//UNIV.DE TEXAS (AUSTIN)
			break;
		  case "14":
			$id_universidad_nuevo=34;//UNIV.DEL ALTIPLANO
			break;
		  case "33":
			$id_universidad_nuevo=35;//UNIV.DEL VALLE
			break;
		  case "37":
			$id_universidad_nuevo=36;//UNIV.FEDERAL DE PELOTAS
			break;
		  case "27":
			$id_universidad_nuevo=37;//UNIV.FEDERAL DO RIO GRANDE DO NORTE
			break;
		  case "4":
			$id_universidad_nuevo=38;//UNIV.FEMENINA DEL SAGRADO CORAZON
			break;
		  case "20":
			$id_universidad_nuevo=39;//UNIV.MAYOR DE SAN ANDRES DE BOLIVIA
			break;
		  case "36":
			$id_universidad_nuevo=40;//UNIV.MAYOR DE SAN SIMON
			break;
		  case "29":
			$id_universidad_nuevo=41;//UNIV.NACIONAL DE ARQUITECTURA E ING. CIVIL DE JARKOV
			break;
		  case "21":
			$id_universidad_nuevo=42;//UNIV.NACIONAL DE COLOMBIA
			break;
		  case "22":
			$id_universidad_nuevo=43;//UNIV.NACIONAL DE CORDOVA - ARGENTINA
			break;
		  case "1":
			$id_universidad_nuevo=44;//UNIV.NACIONAL DE INGENIERIA
			break;
		  case "18":
			$id_universidad_nuevo=45;//UNIV.NACIONAL DE LA PLATA
			break;
		  case "38":
			$id_universidad_nuevo=46;//UNIV.NACIONAL DE PIURA
			break;
		  case "24":
			$id_universidad_nuevo=47;//UNIV.NACIONAL DE SAN JUAN DE ARGENTINA
			break;
		  case "7":
			$id_universidad_nuevo=48;//UNIV.NACIONAL DEL CENTRO DEL PERU
			break;
		  case "51":
			$id_universidad_nuevo=50;//UNIV.NACIONAL EXPERIMENTAL DEL TACHIRA
			break;
		  case "3":
			$id_universidad_nuevo=51;//UNIV.NACIONAL FEDERICO VILLAREAL
			break;
		  case "31":
			$id_universidad_nuevo=52;//UNIV.NACIONAL LOS ANDES
			break;
		  case "5":
			$id_universidad_nuevo=53;//UNIV.NACIONAL SAN AGUSTIN DE AREQUIPA
			break;
		  case "6":
			$id_universidad_nuevo=54;//UNIV.NACIONAL SAN ANTONIO DE ABAD DEL CUSCO
			break;
		  case "9":
			$id_universidad_nuevo=55;//UNIV.PARTICULAR DE CHICLAYO
			break;
		  case "16":
			$id_universidad_nuevo=56;//UNIV.PEDRO RUIZ GALLO
			break;
		  case "11":
			$id_universidad_nuevo=57;//UNIV.PERUANA DE CIENCIAS APLICADAS
			break;
		  case "10":
			$id_universidad_nuevo=58;//UNIV.PRIVADA ANTENOR ORREGO DE TRUJILLO
			break;
		  case "12":
			$id_universidad_nuevo=59;//UNIV.PRIVADA DE TACNA
			break;
		  case "13":
			$id_universidad_nuevo=60;//UNIV.PRIVADA DEL NORTE
			break;
		  case "2":
			$id_universidad_nuevo=61;//UNIV.RICARDO PALMA
			break;
		  case "46":
			$id_universidad_nuevo=62;//UNIVERSIDAD DE CHILE
			break;
		  case "66":
			$id_universidad_nuevo=63;//UNIVERSIDAD DE HUANUCO
			break;
		  case "69":
			$id_universidad_nuevo=64;//UNIVERSIDAD DE PALERMO
			break;
		  case "999":
			$id_universidad_nuevo=65;//UNIVERSIDAD METROPOLITANA DE MANCHESTER - INGLATER
			break;
		  case "57":
			$id_universidad_nuevo=66;//UNIVERSIDAD SAN MARTIN DE PORRES
			break;
		  case "95":
			$id_universidad_nuevo=67;//UNIVERSITA DELLA SVIZZERA ITALIANA
			break;
		  case "999":
			$id_universidad_nuevo=68;//Universidad Metropolitana de Manchester - Inglaterra
			break;
		  case "16":
			$id_universidad_nuevo=69;//UNIV.NACIONAL PEDRO RUIZ GALLO
			break;
		  case "999":
			$id_universidad_nuevo=70;//PRINCETON UNIVERSITY
			break;
		  case "999":
			$id_universidad_nuevo=71;//UNIV.SAN PABLO CEU
			break;
		  case "78":
			$id_universidad_nuevo=72;//UNIVERSIDAD POLITÉCNICA DE VALÉNCIA
			break;
		  case "999":
			$id_universidad_nuevo=73;//UNIVERSIDAD TÉCNICA DE LISBOA
			break;
		  case "999":
			$id_universidad_nuevo=74;//THE COOPERUNION FORTHE ADVANCEMENT
			break;
		  case "104":
			$id_universidad_nuevo=75;//UNIV.PRIVADA TELESUP
			break;
		  case "119":
			$id_universidad_nuevo=75;//UNIV.PRIVADA TELESUP
			break;
		  case "10":
			$id_universidad_nuevo=76;//UNIV. PRIVADA ANTENOR ORREGO
			break;
		  case "106":
			$id_universidad_nuevo=77;//UNIVERSIDAD PERUANA UNION
			break;
		  case "98":
			$id_universidad_nuevo=78;//ESCUELA DE AUQUITECTURA DE VERSALLES
			break;
		  case "999":
			$id_universidad_nuevo=79;//UNIVERSIDAD FRANCISCO DE PAULA SANTANDER
			break;
		  case "55":
			$id_universidad_nuevo=80;//UNIVERSIDAD CENTRAL DE VENEZUELA
			break;
		  case "5":
			$id_universidad_nuevo=81;//UNIVERSIDAD NACIONAL DE SAN AGUSTIN DE AREQUIPA
			break;
		  case "101":
			$id_universidad_nuevo=82;//CATOLICA SANTO TORIBIO DE MOGROVEJO
			break;
		  case "107":
			$id_universidad_nuevo=83;//UNIVERSIDAD DE LIMA
			break;
		  case "71":
			$id_universidad_nuevo=84;//UNIVERSIDAD NACIONAL HERMILIO VALDIZAN
			break;
		  case "92":
			$id_universidad_nuevo=85;//UNIVERSIDAD PERUANA LOS ANDES
			break;
		  case "102":
			$id_universidad_nuevo=86;//UNIVERSIDAD SEÑOR DE SIPAN
			break;
		  case "999":
			$id_universidad_nuevo=87;//UNIV. NACIONAL DEL CALLAO
			break;
		  case "15":
			$id_universidad_nuevo=88;//UNIVERSIDAD PRIVADA CESAR VALLEJO - TRUJILLO
			break;
		  case "97":
			$id_universidad_nuevo=89;//UNIVERSIDAD CONTINENTAL
			break;
		  case "999":
			$id_universidad_nuevo=90;//UNIVERSIDAD CATOLICA SEDES SAPIENTIAE
			break;
		  case "999":
			$id_universidad_nuevo=91;//Universidad Tecnológica del Perú
			break;
		  case "109":
			$id_universidad_nuevo=92;//UNIVERSIDAD NACIONAL DE SAN MARTIN
			break;
		  case "999":
			$id_universidad_nuevo=93;//UNIVERSIDAD DE GRANADA
			break;
		  case "999":
			$id_universidad_nuevo=94;//CELESTE
			break;
		  case "111":
			$id_universidad_nuevo=95;//UNIV. ARISTOTELES DE TESALONICA - GRECIA
			break;
		  case "13":
			$id_universidad_nuevo=96;//UNIV. PRIVADA DEL NORTE - SEDE CAJAMARCA
			break;
		  case "999":
			$id_universidad_nuevo=97;//PONTIFICIA UNIV. CATOLICA DE MINAS GERAIS
			break;
		  case "999":
			$id_universidad_nuevo=98;//UNIV. CATOLICA DE HONDURAS
			break;
		  case "999":
			$id_universidad_nuevo=99;//UNIV. DE LAS PALMAS DE GRAN CANARIA
			break;
		  case "999":
			$id_universidad_nuevo=100;//ECOLE NATIONALE SUPERIEURE D´ARCHITECTURE PAIS MAL
			break;
		  case "999":
			$id_universidad_nuevo=101;//UNIVERSIDAD CATOLICA BOLIVIANA SAN PABLO
			break;
		  case "999":
			$id_universidad_nuevo=102;//UNIVERSIDAD ANHEMBI MORUMBI - BRASIL
			break;
		  case "114":
			$id_universidad_nuevo=103;//TULANE UNIVERSITY
			break;
		  case "999":
			$id_universidad_nuevo=104;//ECOLES NATIONAL SUPERIEUR D´ARCHITECTUE DE MONTPEL
			break;
		  case "78":
			$id_universidad_nuevo=105;//ESCUELA TECNIA SUPERIOR DE ARQUITECTURA DE VALENCI
			break;
		  case "103":
			$id_universidad_nuevo=106;//UNIV. ANDINA NESTOR CACERES VELASQUEZ
			break;
		  case "120":
			$id_universidad_nuevo=106;//UNIV. ANDINA NESTOR CACERES VELASQUEZ
			break;
		  case "74":
			$id_universidad_nuevo=107;//UNIVERSIDAD DE SEVILLA
			break;
		  case "999":
			$id_universidad_nuevo=108;//TECNOLOGICA DE COSTA RICA
			break;
		  case "118":
			$id_universidad_nuevo=109;//UNIVERSIDAD NACIONAL SAN LUIS GONZAGA - ICA
			break;
			
			
		}
		
		return $id_universidad_nuevo;
	
	}
		
	public function equivalenciaTipoParentesco($id_parentesco){
		
		$id_parentesco_nuevo = 0;
		
		switch ($id_parentesco) {
		  case "82":
			$id_parentesco_nuevo=66;//PADRE
			break;
		  case "83":
			$id_parentesco_nuevo=67;//MADRE
			break;
		  case "84":
			$id_parentesco_nuevo=63;//ESPOSO
			break;
		  case "85":
			$id_parentesco_nuevo=63;//ESPOSA
			break;
		  case "92":
			$id_parentesco_nuevo=108;//HERMANO
			break;
		  case "93":
			$id_parentesco_nuevo=108;//HERMANA
			break;
		  case "94":
			$id_parentesco_nuevo=65;//HIJO
			break;
		  case "95":
			$id_parentesco_nuevo=65;//HIJA
			break;
		  case "96":
			$id_parentesco_nuevo=102;//ABUELO
			break;
		  case "97":
			$id_parentesco_nuevo=102;//ABUELA
			break;
		  case "98":
			$id_parentesco_nuevo=109;//NIETO
			break;
		  case "99":
			$id_parentesco_nuevo=109;//NIETA
			break;
		  case "100":
			$id_parentesco_nuevo=112;//SOBRINO
			break;
		  case "101":
			$id_parentesco_nuevo=372;//HERMANA
			break;
		}
		
		return $id_parentesco_nuevo;
	
	}
	
		
}

