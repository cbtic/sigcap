<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mail;
use App\Models\Agremiado;

class CorreoController extends Controller
{
    
	public function generar_credipago(){
	
		view('emails.mensaje');
		$email_usuario_logistica = "apps@limacap.org";
		$email_paciente = "";
		$pasaje_actual = "";
		$nombre_boletopaciente = "";
		$nombre_boletopaciente_extra1 = "";
		$nombre_boletopaciente_extra2 = "";
		$nombre_boletopaciente_extra3 = "";
		$nombre_boletoacompanante = "";
		$nombre_boletomedico = "";
		
		$correo_electronico = "wyamunaque.expertta@gmail.com";
		$paterno = "";
		$fecha_viaje = "";
		
		$agremiado = Agremiado::find(100);
		
        Mail::send('emails.mensaje', ['pasaje' => $agremiado], function ($m) use ($pasaje_actual, $email_paciente,$email_usuario_logistica,$nombre_boletopaciente,$nombre_boletopaciente_extra1,$nombre_boletopaciente_extra2,$nombre_boletopaciente_extra3,$nombre_boletoacompanante,$nombre_boletomedico, $correo_electronico,$paterno,$fecha_viaje) {
		
			$m->from($email_usuario_logistica, 'CAP');
            $m->to($correo_electronico, $paterno)->subject('SOLICITUD XXX CODIGO DE PROYECTO YYH');
			
        });
		
		
	}	
	
}
