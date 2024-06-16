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
		$data["SECONDARY BIT MAP"] = $request->input('SECONDARY BIT MAP');
		$data["PRIMARY ACCOUNT NUMBER"] = $request->input('PRIMARY ACCOUNT NUMBER');
		$data["PROCESSING CODE"] = $request->input('PROCESSING CODE');
		$data["AMOUNT TRANSACTION"] = "000000053067";
		$data["TRACE"] = $request->input('TRACE');
		$data["TIME LOCAL TRANSACTION"] = $request->input('TIME LOCAL TRANSACTION');
		$data["DATE LOCAL TRANSACTION"] = $request->input('DATE LOCAL TRANSACTION');
		$data["POS ENTRY MODE"] = $request->input('POS ENTRY MODE');
		$data["POS CONDITION CODE"] = $request->input('POS CONDITION CODE');
		$data["ACQUIRER INSTITUTION ID CODE"] = $request->input('ACQUIRER INSTITUTION ID CODE');
		$data["FORWARD INSTITUTION ID CODE"] = $request->input('FORWARD INSTITUTION ID CODE');
		$data["RETRIEVAL REFERENCE NUMBER"] = $request->input('RETRIEVAL REFERENCE NUMBER');
		$data["APPROVAL CODE"] = "000301";
		$data["RESPONSE CODE"] = "00";
		$data["CARD ACCEPTOR TERMINAL ID"] = $request->input('CARD ACCEPTOR TERMINAL ID');
		$data["TRANSACTION CURRENCY CODE"] = $request->input('TRANSACTION CURRENCY CODE');
		$data["LONGITUD"] = "0634";
		$data["CodigoEmpresa"] = $request->input('CodigoEmpresa');
		$data["TipoConsulta"] = $request->input('TipoConsulta');
		$data["NumConsulta"] = $request->input('NumConsulta');
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
