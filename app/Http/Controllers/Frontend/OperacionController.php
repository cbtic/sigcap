<?php 

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\BancoInterconexione;
use App\Models\BancoInterconexionDetalle;
use Auth;

class OperacionController extends Controller
{
    
	public function consulta(Request $request){
	
		return $this->interconexiones(1,$request);
		
	}
	
	public function pago(Request $request){
	
		return $this->interconexiones(2,$request);
		
	}
	
	public function extorno_pago(Request $request){
	
		return $this->interconexiones(3,$request);
		
	}
	
	public function anulacion(Request $request){
	
		return $this->interconexiones(4,$request);
		
	}
	
	public function extorno_anulacion(Request $request){
	
		return $this->interconexiones(5,$request);
		
	}
	
	public function interconexiones($tipo_conexion,Request $request)
    {
		
		//$id_user = Auth::user()->id;
		$id_user = 1;
		
		/*
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
		
		if ($validator->fails()) {
			return response()->json(['message' => $validator->errors()], 200);
		}
		*/
		
		//CONSULTA
		$bancoInterconexion = new BancoInterconexione();
		$bancoInterconexion->tipo_conexion = $tipo_conexion;
		$bancoInterconexion->message_type_identification = $request->input('MESSAGE TYPE IDENTIFICATION');
		$bancoInterconexion->primary_bit_map = $request->input('PRIMARY BIT MAP');
		$bancoInterconexion->secondary_bit_map = $request->input('SECONDARY BIT MAP');
		$bancoInterconexion->primary_account_number = $request->input('PRIMARY ACCOUNT NUMBER');
		$bancoInterconexion->processing_code = $request->input('PROCESSING CODE');
		$bancoInterconexion->amount_transaction = $request->input('AMOUNT TRANSACTION');
		$bancoInterconexion->trace = $request->input('TRACE');
		$bancoInterconexion->time_local_transaction = $request->input('TIME LOCAL TRANSACTION');
		$bancoInterconexion->date_local_transaction = $request->input('DATE LOCAL TRANSACTION');
		$bancoInterconexion->pos_entry_mode = $request->input('POS ENTRY MODE');
		$bancoInterconexion->pos_condition_code = $request->input('POS CONDITION CODE');
		$bancoInterconexion->acquirer_institution_id_code = $request->input('ACQUIRER INSTITUTION ID CODE');
		$bancoInterconexion->forward_institution_id_code = $request->input('FORWARD INSTITUTION ID CODE');
		$bancoInterconexion->retrieval_reference_number = $request->input('RETRIEVAL REFERENCE NUMBER');
		$bancoInterconexion->card_acceptor_terminal_id = $request->input('CARD ACCEPTOR TERMINAL ID');
		$bancoInterconexion->card_acceptor_id_code = $request->input('CARD ACCEPTOR ID CODE');
		$bancoInterconexion->card_acceptor_name_location = $request->input('CARD ACCEPTOR NAME LOCATION');
		$bancoInterconexion->transaction_currency_code = $request->input('TRANSACTION CURRENCY CODE');
		$bancoInterconexion->longitud = $request->input('LONGITUD');
		$bancoInterconexion->codigoempresa = $request->input('CodigoEmpresa');
		
		if($tipo_conexion==1){
			$bancoInterconexion->codigoproducto = $request->input('CodigoProducto');
			$bancoInterconexion->numpagina = $request->input('NumPagina');
			$bancoInterconexion->nummaxdocs = $request->input('NumMaxDocs');
			$bancoInterconexion->filler = $request->input('Filler');
		}
		
		$bancoInterconexion->tipoconsulta = $request->input('TipoConsulta');
		$bancoInterconexion->numconsulta = $request->input('NumConsulta');
		
		if($tipo_conexion==2){
			$bancoInterconexion->formapago = $request->input('FormaPago');
			$bancoInterconexion->numreferenciaoriginal = $request->input('NumReferenciaOriginal');
			$bancoInterconexion->numdocs = $request->input('NumDocs');
		}
		
		//$bancoInterconexion->numdocumento = $request->input('TIME LOCAL TRANSACTION');
		//$bancoInterconexion->fechavencimiento = $request->input('TIME LOCAL TRANSACTION');
		//$bancoInterconexion->fechaemision = $request->input('TIME LOCAL TRANSACTION');
		//$bancoInterconexion->deuda = $request->input('TIME LOCAL TRANSACTION');
		//$bancoInterconexion->mora = $request->input('TIME LOCAL TRANSACTION');
		//$bancoInterconexion->gastosadm = $request->input('TIME LOCAL TRANSACTION');
		//$bancoInterconexion->importetotal = $request->input('TIME LOCAL TRANSACTION');
		//$bancoInterconexion->periodo = $request->input('TIME LOCAL TRANSACTION');
		//$bancoInterconexion->anio = $request->input('TIME LOCAL TRANSACTION');
		//$bancoInterconexion->cuota = $request->input('TIME LOCAL TRANSACTION');
		//$bancoInterconexion->monedadoc = $request->input('TIME LOCAL TRANSACTION');
		
		$bancoInterconexion->estado = 1;
		$bancoInterconexion->id_usuario_inserta = $id_user;
		$bancoInterconexion->save();
		$id_banco_interconexion = $bancoInterconexion->id;
		
		if($tipo_conexion==2 || $tipo_conexion==3 || $tipo_conexion==4 || $tipo_conexion==5){
		
			$bloque = $request->input('Bloque de documentos a pagar');
			//print_r($bloque);
			//$bloque = json_decode($request->input('Bloque de documentos a pagar'));
			
			foreach($bloque as $row){
			
				$bancoInterconexionDetalle = new BancoInterconexionDetalle();
				$bancoInterconexionDetalle->id_banco_interconexion = $id_banco_interconexion;
				//$bancoInterconexionDetalle->codigoerrororiginal = $request->input('TRACE');
				//$bancoInterconexionDetalle->descrespuesta = $request->input('TRACE');
				//$bancoInterconexionDetalle->nombrecliente = $request->input('TRACE');
				//$bancoInterconexionDetalle->nombreempresa = $request->input('TRACE');
				//$bancoInterconexionDetalle->numoperacionerp = $request->input('TRACE');
				$bancoInterconexionDetalle->codigoproducto = $row["CodigoProducto"];
				//$bancoInterconexionDetalle->descrproducto = $request->input('TRACE');
				$bancoInterconexionDetalle->numdocumento = $row["NumDocumento"];
				//$bancoInterconexionDetalle->descdocumento = $request->input('TRACE');
				$bancoInterconexionDetalle->fechavencimiento = $row["FechaVencimiento"];
				$bancoInterconexionDetalle->fechaemision = $row["FechaEmision"];
				$bancoInterconexionDetalle->deuda = $row["Deuda"];
				$bancoInterconexionDetalle->mora = $row["Mora"];
				$bancoInterconexionDetalle->gastosadm = $row["GastosAdm"];
				//$bancoInterconexionDetalle->pagominimo = $request->input('TRACE');
				$bancoInterconexionDetalle->importetotal = $row["ImporteTotal"];
				$bancoInterconexionDetalle->periodo = $row["Periodo"];
				//$bancoInterconexionDetalle->anio = $row["Año"];
				$bancoInterconexionDetalle->cuota = $row["Cuota"];
				$bancoInterconexionDetalle->monedadoc = $row["MonedaDoc"];
				$bancoInterconexionDetalle->filler = $row["Filler"];
				//$bancoInterconexionDetalle->estado = $request->input('TRACE');
				$bancoInterconexionDetalle->id_usuario_inserta = 1;
				$bancoInterconexionDetalle->save();
			
			}
		}
		
		
		/************RESPUESTA******************/
		
		if($tipo_conexion==1){
		
			$bancoInterconexionEnvio = BancoInterconexione::find($id_banco_interconexion);
			
			$bancoInterconexionRespuesta = new BancoInterconexione();
			$bancoInterconexionRespuesta->tipo_conexion = 6;
			$bancoInterconexionRespuesta->message_type_identification = $bancoInterconexionEnvio->message_type_identification;
			$bancoInterconexionRespuesta->primary_bit_map = $bancoInterconexionEnvio->primary_bit_map;
			$bancoInterconexionRespuesta->secondary_bit_map = $bancoInterconexionEnvio->secondary_bit_map;
			$bancoInterconexionRespuesta->primary_account_number = $bancoInterconexionEnvio->primary_account_number;
			$bancoInterconexionRespuesta->processing_code = $bancoInterconexionEnvio->processing_code;
			$bancoInterconexionRespuesta->amount_transaction = $bancoInterconexionEnvio->amount_transaction;
			$bancoInterconexionRespuesta->trace = $bancoInterconexionEnvio->trace;
			$bancoInterconexionRespuesta->time_local_transaction = $bancoInterconexionEnvio->time_local_transaction;
			$bancoInterconexionRespuesta->date_local_transaction = $bancoInterconexionEnvio->date_local_transaction;
			$bancoInterconexionRespuesta->pos_entry_mode = $bancoInterconexionEnvio->pos_entry_mode;
			$bancoInterconexionRespuesta->pos_condition_code = $bancoInterconexionEnvio->pos_condition_code;
			$bancoInterconexionRespuesta->acquirer_institution_id_code = $bancoInterconexionEnvio->acquirer_institution_id_code;
			$bancoInterconexionRespuesta->forward_institution_id_code = $bancoInterconexionEnvio->forward_institution_id_code;
			$bancoInterconexionRespuesta->retrieval_reference_number = $bancoInterconexionEnvio->retrieval_reference_number;
			
			$bancoInterconexionRespuesta->card_acceptor_terminal_id = $bancoInterconexionEnvio->card_acceptor_terminal_id;
			//$bancoInterconexionRespuesta->card_acceptor_id_code = $bancoInterconexionEnvio->card_acceptor_id_code;
			//$bancoInterconexionRespuesta->card_acceptor_name_location = $bancoInterconexionEnvio->card_acceptor_name_location;
			$bancoInterconexionRespuesta->transaction_currency_code = $bancoInterconexionEnvio->transaction_currency_code;
			$bancoInterconexionRespuesta->longitud = $bancoInterconexionEnvio->longitud;
			$bancoInterconexionRespuesta->codigoempresa = $bancoInterconexionEnvio->codigoempresa;
			/*
			if($tipo_conexion==1){
				$bancoInterconexion->codigoproducto = $request->input('CodigoProducto');
				$bancoInterconexion->numpagina = $request->input('NumPagina');
				$bancoInterconexion->nummaxdocs = $request->input('NumMaxDocs');
				$bancoInterconexion->filler = $request->input('Filler');
			}
			*/
			$bancoInterconexionRespuesta->tipoconsulta = $bancoInterconexionEnvio->tipoconsulta;
			$bancoInterconexionRespuesta->numconsulta = $bancoInterconexionEnvio->numconsulta;
			$bancoInterconexionRespuesta->numdocs = $bancoInterconexionEnvio->numdocs;
			
			$bancoInterconexionRespuesta->estado = 1;
			$bancoInterconexionRespuesta->id_usuario_inserta = $id_user;
			$bancoInterconexionRespuesta->save();
			$id_banco_interconexion = $bancoInterconexionRespuesta->id;
			/*
			if($tipo_conexion==2){
				$bancoInterconexion->formapago = $request->input('FormaPago');
				$bancoInterconexion->numreferenciaoriginal = $request->input('NumReferenciaOriginal');
				$bancoInterconexion->numdocs = $request->input('NumDocs');
			}
			*/
			
			$data["MESSAGE TYPE IDENTIFICATION"] = $bancoInterconexionRespuesta->message_type_identification;
			$data["PRIMARY BIT MAP"] = $bancoInterconexionRespuesta->primary_bit_map;
			$data["SECONDARY BIT MAP"] = $bancoInterconexionRespuesta->secondary_bit_map;
			$data["PRIMARY ACCOUNT NUMBER"] = $bancoInterconexionRespuesta->primary_account_number;
			$data["PROCESSING CODE"] = $bancoInterconexionRespuesta->processing_code;
			$data["AMOUNT TRANSACTION"] = $bancoInterconexionRespuesta->amount_transaction;
			$data["TRACE"] = $bancoInterconexionRespuesta->trace;
			$data["TIME LOCAL TRANSACTION"] = $bancoInterconexionRespuesta->time_local_transaction;
			$data["DATE LOCAL TRANSACTION"] = $bancoInterconexionRespuesta->date_local_transaction;
			$data["POS ENTRY MODE"] = $bancoInterconexionRespuesta->pos_entry_mode;
			$data["POS CONDITION CODE"] = $bancoInterconexionRespuesta->pos_condition_code;
			$data["ACQUIRER INSTITUTION ID CODE"] = $bancoInterconexionRespuesta->acquirer_institution_id_code;
			$data["FORWARD INSTITUTION ID CODE"] = $bancoInterconexionRespuesta->forward_institution_id_code;
			$data["RETRIEVAL REFERENCE NUMBER"] = $bancoInterconexionRespuesta->retrieval_reference_number;
			$data["APPROVAL CODE"] = "000301";
			$data["RESPONSE CODE"] = "00";
			$data["CARD ACCEPTOR TERMINAL ID"] = $bancoInterconexionRespuesta->card_acceptor_terminal_id;
			$data["TRANSACTION CURRENCY CODE"] = $bancoInterconexionRespuesta->transaction_currency_code;
			$data["LONGITUD"] = "0634";
			$data["CodigoEmpresa"] = $bancoInterconexionRespuesta->codigoempresa;
			$data["TipoConsulta"] = $bancoInterconexionRespuesta->tipoconsulta;
			$data["NumConsulta"] = $bancoInterconexionRespuesta->numconsulta;
			$data["CodigoErrorOriginal"] = "000";
			$data["DescRespuesta"] = "TRANSACCION PROCESADA OK";
			$data["NombreCliente"] = "GINOCCHIO MENDOZA PATRICIA MON";
			$data["NombreEmpresa"] = "LA POSITIVA";
			$data["NumDocs"] = "03";
			
		}
		
		/*
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
		*/
        $responsecode = 200;
        $header = array (
                'Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'
            );
		return response()->json($data , $responsecode, $header, JSON_UNESCAPED_UNICODE);
		
	}
	
}
