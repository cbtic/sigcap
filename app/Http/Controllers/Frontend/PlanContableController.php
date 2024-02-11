<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PlanContable;

class PlanContableController extends Controller
{
    public function importar_plan_contable(){ 
	
		$ch = curl_init('http://webservice.limacap.org:8080/webservices.php?op=plancontable');		
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
		
		foreach($dataWebApi as $row){
			//print_r($row);
			$planContableExiste = PlanContable::where("cuenta",$row->CUENTA)->where("estado",1)->get();
			
			if(count($planContableExiste)==0){
				$planContable = new PlanContable;
				$planContable->cuenta = $row->CUENTA;
				$planContable->denominacion = $row->NOMBRE;
				$planContable->estado = 1;
				$planContable->id_usuario_inserta = 1;
				$planContable->save();
				
			}
			
		}
	
	}
}
