<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OperacionController extends Controller
{
    
	public function consulta(Request $request)
    {
		$data["MESSAGE TYPE IDENTIFICATION"] = "0210";
		$data["PRIMARY BIT MAP"] = "F03804818E808000";
		$data["SECONDARY BIT MAP"] = "0000000000000080";
		$data["PRIMARY ACCOUNT NUMBER"] = "0000000000000000000";
		$data["PROCESSING CODE"] = "310000";
		$data["AMOUNT TRANSACTION"] = "000000053067";
		$data["TRACE"] = "136956";
		$data["TIME LOCAL TRANSACTION"] = "090600";
		$data["DATE LOCAL TRANSACTION"] = "05022020";
		$data["POS ENTRY MODE"] = "020";
		$data["POS CONDITION CODE"] = "60";
		$data["ACQUIRER INSTITUTION ID CODE"] = "20014028";
		$data["FORWARD INSTITUTION ID CODE"] = "20001000";
		$data["RETRIEVAL REFERENCE NUMBER"] = "000000136956";
		$data["APPROVAL CODE"] = "000301";
		$data["RESPONSE CODE"] = "00";
		$data["CARD ACCEPTOR TERMINAL ID"] = "PIB0";
		$data["TRANSACTION CURRENCY CODE"] = "840";
		$data["LONGITUD"] = "0634";
		$data["CodigoEmpresa"] = "0200512";
		$data["TipoConsulta"] = "0";
		$data["NumConsulta"] = "07738650";
		$data["CodigoErrorOriginal"] = "000";
		$data["DescRespuesta"] = "TRANSACCION PROCESADA OK";
		$data["NombreCliente"] = "GINOCCHIO MENDOZA PATRICIA MON";
		$data["NombreEmpresa"] = "LA POSITIVA";
		$data["NumDocs"] = "03";
		//return json_encode($data,true);
		
		//$address = ['token' => $token];
        $responsecode = 200;
        $header = array (
                'Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'
            );
		return response()->json($data , $responsecode, $header, JSON_UNESCAPED_UNICODE);
		
	}
	
}
