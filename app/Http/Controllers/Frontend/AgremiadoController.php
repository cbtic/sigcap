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

class AgremiadoController extends Controller
{
	
	public function index(){
        
		return view('frontend.agremiado.create');
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
		
		$ch2 = curl_init('https://integracion.portalcap2.org.pe/api/v1/collegiate/?idRegional=11&fecha=');		
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
		//print_r($data);
		//exit();
		
		/*************INSTAR AGREMIADO*****************/
		/*
		foreach($data as $solicitud){
			
			$persona = new Persona;
			$persona->id_tipo_documento = $solicitud->idtipodocumento;
			$persona->numero_documento = $solicitud->numerodocumento;
			$persona->apellido_paterno = $solicitud->apellidopaterno;
			$persona->apellido_materno = $solicitud->apellidomaterno;
			$persona->nombres = $solicitud->nombre;
			$persona->fecha_nacimiento = $solicitud->fechanacimiento;
			$persona->sexo = $solicitud->idsexo;
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
				
				$agremiadoTrabajo = new AgremiadoTrabajo;
				$agremiadoTrabajo->id_agremiado = $id_agremiado;
				$agremiadoTrabajo->id_persona = "1";
				$agremiadoTrabajo->modalidad = "1";
				$agremiadoTrabajo->numero_documento = "1";
				$agremiadoTrabajo->razon_social = "1";
				$agremiadoTrabajo->id_cliente_cargo = "1";
				$agremiadoTrabajo->rubro_negocio = "1";
				$agremiadoTrabajo->id_ubigeo = "1";
				$agremiadoTrabajo->direccion = "1";
				$agremiadoTrabajo->referencia = "1";
				$agremiadoTrabajo->codigo_postal = "1";
				$agremiadoTrabajo->telefono = "1";
				$agremiadoTrabajo->celular = "1";
				$agremiadoTrabajo->email = "1";
				$agremiadoTrabajo->estado = 1;
				$agremiadoTrabajo->id_usuario_inserta = 1;
				$agremiadoTrabajo->save();
			
			}
			
			foreach($solicitud->idioma as $idioma){
				
				$agremiadoIdioma = new AgremiadoIdioma;
				$agremiadoIdioma->id_agremiado = $id_agremiado;
				$agremiadoIdioma->id_idioma = "1";
				$agremiadoIdioma->id_grado_conocimiento = "1";
				$agremiadoIdioma->estado = 1;
				$agremiadoIdioma->id_usuario_inserta = 1;
				$agremiadoIdioma->save();
				
			}
			
			foreach($solicitud->estudio as $estudio){
				
				$agremiadoEstudio = new AgremiadoEstudio;
				$agremiadoEstudio->id_agremiado = $id_agremiado;
				$agremiadoEstudio->id_universidad = "1";
				$agremiadoEstudio->id_especialidad = "1";
				$agremiadoEstudio->estado = 1;
				$agremiadoEstudio->id_usuario_inserta = 1;
				$agremiadoEstudio->save();
				
			}
			
			foreach($solicitud->otroestudio as $otroestudio){
			
			}
			
			foreach($solicitud->parentesco as $parentesco){
				
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
				
			}
			
			
		}
		*/
		
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
		
		//exit();
		/*************WEB SERVICE - ACTUALIZAR*****************/
		
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
		
		//$ok = $dataWebApi2->ok;
		//$data = $dataWebApi2->data;
		
				
		
	
	}	
	
}

