<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CentroCosto;

class CentroCostoController extends Controller
{
    public function importar_centro_costo(){ 
	
		$ch = curl_init('http://webservice.limacap.org:8080/webservices.php?op=centrocostos');		
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
		
			$centroCostoExiste = CentroCosto::where("codigo",$row->CODIGO)->where("estado",1)->get();
			
			if(count($centroCostoExiste)==0){
				$centroCosto = new CentroCosto;
				$centroCosto->id_regional=5;
				$centroCosto->periodo=date("Y");
				$centroCosto->codigo = $row->CODIGO;
				$centroCosto->denominacion = $row->NOM;
				$centroCosto->total_debe = ($row->TDEBE!="")?$row->TDEBE:0;
				$centroCosto->total_haber = ($row->THABER!="")?$row->THABER:0;
				$centroCosto->estado = 1;
				$centroCosto->id_usuario_inserta = 1;
				$centroCosto->save();
			}
			
		}
		
	}
}
