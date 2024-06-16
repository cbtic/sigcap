<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OperacionController extends Controller
{
    
	public function consulta(Request $request)
    {
	
		$validator = Validator::make($request->all(), [
			'MESSAGE TYPE IDENTIFICATION' => 'required|numeric|digits_between:1,4',
			'PRIMARY BIT MAP' => 'required|max:16',
			'SECONDARY BIT MAP' => 'required|max:16',
			'PRIMARY ACCOUNT NUMBER' => 'required|numeric|digits_between:1,19',
			'PROCESSING CODE' => 'required|numeric|digits_between:1,6',
			'AMOUNT TRANSACTION' => 'required|numeric|digits_between:1,12',
			'TRACE' => 'required|numeric|digits_between:1,6',
			'TIME LOCAL TRANSACTION' => 'required|numeric|digits_between:1,6',
			'DATE LOCAL TRANSACTION' => 'required|numeric|digits_between:1,8',
			'POS ENTRY MODE' => 'required|numeric|digits_between:1,3',
			'POS CONDITION CODE' => 'required|numeric|digits_between:1,2',
			'ACQUIRER INSTITUTION ID CODE' => 'required|numeric|digits_between:1,8',
			'FORWARD INSTITUTION ID CODE' => 'required|numeric|digits_between:1,8',
			'RETRIEVAL REFERENCE NUMBER' => 'required|max:12',
			'CARD ACCEPTOR TERMINAL ID' => 'required|max:8',
			'CARD ACCEPTOR ID CODE' => 'required|max:15',
			'CARD ACCEPTOR NAME LOCATION' => 'required|max:40',
			'TRANSACTION CURRENCY CODE' => 'required|numeric|digits_between:1,3',
			'LONGITUD' => 'required|numeric|digits_between:1,4',
			'CodigoEmpresa' => 'required|max:7',
			'CodigoProducto' => 'required|numeric|digits_between:1,3',
			'TipoConsulta' => 'required|max:1',
			'NumConsulta' => 'required|max:14',
			'NumPagina' => 'required|numeric|digits_between:1,2',
			'NumMaxDocs' => 'required|numeric|digits_between:1,2',
			'Filler' => 'max:30',
		]);
		//print_r($validator->messages());exit();
		if ($validator->fails()) {
			return response()->json(['message' => $validator->errors()], 200);
		}
		
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
