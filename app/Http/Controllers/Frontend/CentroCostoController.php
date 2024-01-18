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
			
			$total_debe=0;
			$total_haber=0;
			$centroCosto = new CentroCosto;
			if($row->TDEBE!="")$total_debe=$row->TDEBE;
			if($row->THABER!="")$total_haber=$row->THABER;
			$centroCosto->id_regional=5;
			$centroCosto->periodo=date("Y");
			$centroCosto->codigo = $row->CODIGO;
			$centroCosto->denominacion = $row->NOM;
			$centroCosto->total_debe = $total_debe;
			$centroCosto->total_haber = $total_haber;
			$centroCosto->estado = 1;
			$centroCosto->id_usuario_inserta = 1;
			$centroCosto->save();
			
		}
		
	}
}
