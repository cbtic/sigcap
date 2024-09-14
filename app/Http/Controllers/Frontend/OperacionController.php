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
		//echo convertir_entero("235,556.54");
		
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
		
		/************1. REQUERIMIENTO ENVIO*************/
		
		$bancoInterconexionRequerimientoEnvio = new BancoInterconexione();
		$bancoInterconexionRequerimientoEnvio->tipo_conexion = $tipo_conexion;
		$bancoInterconexionRequerimientoEnvio->message_type_identification = $request->input('MESSAGE TYPE IDENTIFICATION');
		$bancoInterconexionRequerimientoEnvio->primary_bit_map = $request->input('PRIMARY BIT MAP');
		$bancoInterconexionRequerimientoEnvio->secondary_bit_map = $request->input('SECONDARY BIT MAP');
		$bancoInterconexionRequerimientoEnvio->primary_account_number = $request->input('PRIMARY ACCOUNT NUMBER');
		$bancoInterconexionRequerimientoEnvio->processing_code = $request->input('PROCESSING CODE');
		$bancoInterconexionRequerimientoEnvio->amount_transaction = $request->input('AMOUNT TRANSACTION');
		$bancoInterconexionRequerimientoEnvio->trace = $request->input('TRACE');
		$bancoInterconexionRequerimientoEnvio->time_local_transaction = $request->input('TIME LOCAL TRANSACTION');
		$bancoInterconexionRequerimientoEnvio->date_local_transaction = $request->input('DATE LOCAL TRANSACTION');
		$bancoInterconexionRequerimientoEnvio->pos_entry_mode = $request->input('POS ENTRY MODE');
		$bancoInterconexionRequerimientoEnvio->pos_condition_code = $request->input('POS CONDITION CODE');
		$bancoInterconexionRequerimientoEnvio->acquirer_institution_id_code = $request->input('ACQUIRER INSTITUTION ID CODE');
		$bancoInterconexionRequerimientoEnvio->forward_institution_id_code = $request->input('FORWARD INSTITUTION ID CODE');
		$bancoInterconexionRequerimientoEnvio->retrieval_reference_number = $request->input('RETRIEVAL REFERENCE NUMBER');
		$bancoInterconexionRequerimientoEnvio->card_acceptor_terminal_id = $request->input('CARD ACCEPTOR TERMINAL ID');
		$bancoInterconexionRequerimientoEnvio->card_acceptor_id_code = $request->input('CARD ACCEPTOR ID CODE');
		$bancoInterconexionRequerimientoEnvio->card_acceptor_name_location = $request->input('CARD ACCEPTOR NAME LOCATION');
		$bancoInterconexionRequerimientoEnvio->transaction_currency_code = $request->input('TRANSACTION CURRENCY CODE');
		$bancoInterconexionRequerimientoEnvio->longitud = $request->input('LONGITUD');
		$bancoInterconexionRequerimientoEnvio->codigoempresa = $request->input('CodigoEmpresa');
		
		if($tipo_conexion==1){
			$bancoInterconexionRequerimientoEnvio->codigoproducto = $request->input('CodigoProducto');
			$bancoInterconexionRequerimientoEnvio->numpagina = $request->input('NumPagina');
			$bancoInterconexionRequerimientoEnvio->nummaxdocs = $request->input('NumMaxDocs');
			$bancoInterconexionRequerimientoEnvio->filler = $request->input('Filler');
		}
		
		$bancoInterconexionRequerimientoEnvio->tipoconsulta = $request->input('TipoConsulta');
		$bancoInterconexionRequerimientoEnvio->numconsulta = $request->input('NumConsulta');
		
		if($tipo_conexion==2){
			$bancoInterconexionRequerimientoEnvio->formapago = $request->input('FormaPago');
			$bancoInterconexionRequerimientoEnvio->numreferenciaoriginal = $request->input('NumReferenciaOriginal');
			$bancoInterconexionRequerimientoEnvio->numdocs = $request->input('NumDocs');
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
		$bancoInterconexionRequerimientoEnvio->id_usuario_inserta = $id_user;
		$bancoInterconexionRequerimientoEnvio->save();
		$id_banco_interconexion_requerimiento_envio = $bancoInterconexionRequerimientoEnvio->id;
		
		if($tipo_conexion==2 || $tipo_conexion==3 || $tipo_conexion==4 || $tipo_conexion==5){
		
			/************2. REQUERIMIENTO DETALLE ENVIO*************/
			
			$bloque = $request->input('Bloque de documentos a pagar');
			
			foreach($bloque as $row){
			
				$bancoInterconexionRequerimientoDetalleEnvio = new BancoInterconexionDetalle();
				$bancoInterconexionRequerimientoDetalleEnvio->id_banco_interconexion = $id_banco_interconexion_requerimiento_envio;
				//$bancoInterconexionRequerimientoDetalleEnvio->codigoerrororiginal = $request->input('TRACE');
				//$bancoInterconexionRequerimientoDetalleEnvio->descrespuesta = $request->input('TRACE');
				//$bancoInterconexionRequerimientoDetalleEnvio->nombrecliente = $request->input('TRACE');
				//$bancoInterconexionRequerimientoDetalleEnvio->nombreempresa = $request->input('TRACE');
				//$bancoInterconexionRequerimientoDetalleEnvio->numoperacionerp = $request->input('TRACE');
				$bancoInterconexionRequerimientoDetalleEnvio->codigoproducto = $row["CodigoProducto"];
				//$bancoInterconexionRequerimientoDetalleEnvio->descrproducto = $request->input('TRACE');
				$bancoInterconexionRequerimientoDetalleEnvio->numdocumento = $row["NumDocumento"];
				//$bancoInterconexionRequerimientoDetalleEnvio->descdocumento = $request->input('TRACE');
				$bancoInterconexionRequerimientoDetalleEnvio->fechavencimiento = $row["FechaVencimiento"];
				$bancoInterconexionRequerimientoDetalleEnvio->fechaemision = $row["FechaEmision"];
				$bancoInterconexionRequerimientoDetalleEnvio->deuda = $row["Deuda"];
				$bancoInterconexionRequerimientoDetalleEnvio->mora = $row["Mora"];
				$bancoInterconexionRequerimientoDetalleEnvio->gastosadm = $row["GastosAdm"];
				//$bancoInterconexionRequerimientoDetalleEnvio->pagominimo = $request->input('TRACE');
				$bancoInterconexionRequerimientoDetalleEnvio->importetotal = $row["ImporteTotal"];
				$bancoInterconexionRequerimientoDetalleEnvio->periodo = $row["Periodo"];
				//$bancoInterconexionRequerimientoDetalleEnvio->anio = $row["Año"];
				$bancoInterconexionRequerimientoDetalleEnvio->cuota = $row["Cuota"];
				$bancoInterconexionRequerimientoDetalleEnvio->monedadoc = $row["MonedaDoc"];
				$bancoInterconexionRequerimientoDetalleEnvio->filler = $row["Filler"];
				$bancoInterconexionRequerimientoDetalleEnvio->id_usuario_inserta = $id_user;
				$bancoInterconexionRequerimientoDetalleEnvio->save();
			
			}
		}
		
		/************3. REQUERIMIENTO RESPUESTA*************/
			
		$bancoInterconexione_model = new BancoInterconexione;
		$p[]="";
		$p[]="";
		$p[]="";
		$p[]="";
		$p[]="";
		$p[]="";
		$p[]="";
		$p[]="";
		$p[]="1";
		$p[]="3";
		$respuesta = $bancoInterconexione_model->listar_operacion_ajax($p);
		//$iTotalDisplayRecords = isset($data[0]->totalrows)?$data[0]->totalrows:0;
		
		$bancoInterconexionEnvio = BancoInterconexione::find($id_banco_interconexion_requerimiento_envio);
		
		$bancoInterconexionRequerimientoRespuesta = new BancoInterconexione();
		$bancoInterconexionRequerimientoRespuesta->tipo_conexion = 6;
		$bancoInterconexionRequerimientoRespuesta->message_type_identification = $bancoInterconexionEnvio->message_type_identification;
		$bancoInterconexionRequerimientoRespuesta->primary_bit_map = $bancoInterconexionEnvio->primary_bit_map;
		$bancoInterconexionRequerimientoRespuesta->secondary_bit_map = $bancoInterconexionEnvio->secondary_bit_map;
		$bancoInterconexionRequerimientoRespuesta->primary_account_number = $bancoInterconexionEnvio->primary_account_number;
		$bancoInterconexionRequerimientoRespuesta->processing_code = $bancoInterconexionEnvio->processing_code;
		$bancoInterconexionRequerimientoRespuesta->amount_transaction = $bancoInterconexionEnvio->amount_transaction;
		$bancoInterconexionRequerimientoRespuesta->trace = $bancoInterconexionEnvio->trace;
		$bancoInterconexionRequerimientoRespuesta->time_local_transaction = $bancoInterconexionEnvio->time_local_transaction;
		$bancoInterconexionRequerimientoRespuesta->date_local_transaction = $bancoInterconexionEnvio->date_local_transaction;
		$bancoInterconexionRequerimientoRespuesta->pos_entry_mode = $bancoInterconexionEnvio->pos_entry_mode;
		$bancoInterconexionRequerimientoRespuesta->pos_condition_code = $bancoInterconexionEnvio->pos_condition_code;
		$bancoInterconexionRequerimientoRespuesta->acquirer_institution_id_code = $bancoInterconexionEnvio->acquirer_institution_id_code;
		$bancoInterconexionRequerimientoRespuesta->forward_institution_id_code = $bancoInterconexionEnvio->forward_institution_id_code;
		$bancoInterconexionRequerimientoRespuesta->retrieval_reference_number = $bancoInterconexionEnvio->retrieval_reference_number;
		$bancoInterconexionRequerimientoRespuesta->card_acceptor_terminal_id = $bancoInterconexionEnvio->card_acceptor_terminal_id;
		//$bancoInterconexionRequerimientoRespuesta->card_acceptor_id_code = $bancoInterconexionEnvio->card_acceptor_id_code;
		//$bancoInterconexionRequerimientoRespuesta->card_acceptor_name_location = $bancoInterconexionEnvio->card_acceptor_name_location;
		$bancoInterconexionRequerimientoRespuesta->transaction_currency_code = $bancoInterconexionEnvio->transaction_currency_code;
		$bancoInterconexionRequerimientoRespuesta->longitud = $bancoInterconexionEnvio->longitud;
		$bancoInterconexionRequerimientoRespuesta->codigoempresa = $bancoInterconexionEnvio->codigoempresa;
		/*
		if($tipo_conexion==1){
			$bancoInterconexion->codigoproducto = $request->input('CodigoProducto');
			$bancoInterconexion->numpagina = $request->input('NumPagina');
			$bancoInterconexion->nummaxdocs = $request->input('NumMaxDocs');
			$bancoInterconexion->filler = $request->input('Filler');
		}
		*/
		$bancoInterconexionRequerimientoRespuesta->tipoconsulta = $bancoInterconexionEnvio->tipoconsulta;
		$bancoInterconexionRequerimientoRespuesta->numconsulta = $bancoInterconexionEnvio->numconsulta;
		$bancoInterconexionRequerimientoRespuesta->numdocs = $bancoInterconexionEnvio->numdocs;
		$bancoInterconexionRequerimientoRespuesta->id_usuario_inserta = $id_user;
		$bancoInterconexionRequerimientoRespuesta->save();
		$id_banco_interconexion_requerimiento_respuesta = $bancoInterconexionRequerimientoRespuesta->id;
		/*
		if($tipo_conexion==2){
			$bancoInterconexion->formapago = $request->input('FormaPago');
			$bancoInterconexion->numreferenciaoriginal = $request->input('NumReferenciaOriginal');
			$bancoInterconexion->numdocs = $request->input('NumDocs');
		}
		*/
		
		/************4. REQUERIMIENTO DETALLE RESPUESTA*************/
		
		foreach ($respuesta as $row) {
			$bancoInterconexionRequerimientoDetalleRespuesta = new BancoInterconexionDetalle();
			$bancoInterconexionRequerimientoDetalleRespuesta->id_banco_interconexion = $id_banco_interconexion_requerimiento_respuesta;
			//$bancoInterconexionDetalle->codigoerrororiginal = $request->input('TRACE');
			//$bancoInterconexionDetalle->descrespuesta = $request->input('TRACE');
			//$bancoInterconexionDetalle->nombrecliente = $request->input('TRACE');
			//$bancoInterconexionDetalle->nombreempresa = $request->input('TRACE');
			//$bancoInterconexionDetalle->numoperacionerp = $request->input('TRACE');
			$bancoInterconexionRequerimientoDetalleRespuesta->codigoproducto = "123";//$row["CodigoProducto"];
			//$bancoInterconexionDetalle->descrproducto = $request->input('TRACE');
			$bancoInterconexionRequerimientoDetalleRespuesta->numdocumento = "123";//$row["NumDocumento"];
			//$bancoInterconexionDetalle->descdocumento = $request->input('TRACE');
			$bancoInterconexionRequerimientoDetalleRespuesta->fechavencimiento = "123";//$row["FechaVencimiento"];
			$bancoInterconexionRequerimientoDetalleRespuesta->fechaemision = "123";//$row["FechaEmision"];
			$bancoInterconexionRequerimientoDetalleRespuesta->deuda = "123";//$row["Deuda"];
			$bancoInterconexionRequerimientoDetalleRespuesta->mora = "123";//$row["Mora"];
			$bancoInterconexionRequerimientoDetalleRespuesta->gastosadm = "123";//$row["GastosAdm"];
			//$bancoInterconexionDetalle->pagominimo = $request->input('TRACE');
			$bancoInterconexionRequerimientoDetalleRespuesta->importetotal = "123";//$row["ImporteTotal"];
			$bancoInterconexionRequerimientoDetalleRespuesta->periodo = "123";//$row["Periodo"];
			//$bancoInterconexionDetalle->anio = $row["Año"];
			$bancoInterconexionRequerimientoDetalleRespuesta->cuota = "123";//$row["Cuota"];
			$bancoInterconexionRequerimientoDetalleRespuesta->monedadoc = "123";//$row["MonedaDoc"];
			$bancoInterconexionRequerimientoDetalleRespuesta->filler = "123";//$row["Filler"];
			$bancoInterconexionRequerimientoDetalleRespuesta->id_usuario_inserta = $id_user;
			$bancoInterconexionRequerimientoDetalleRespuesta->save();
			
		}
		
		/************5. SALIDA WS CABECERA*******************/
		
		$bancoInterconexionRequerimientoSalida = BancoInterconexione::find($id_banco_interconexion_requerimiento_respuesta);
		
		$data["MESSAGE TYPE IDENTIFICATION"] = $bancoInterconexionRequerimientoSalida->message_type_identification;
		$data["PRIMARY BIT MAP"] = $bancoInterconexionRequerimientoSalida->primary_bit_map;
		$data["SECONDARY BIT MAP"] = $bancoInterconexionRequerimientoSalida->secondary_bit_map;
		$data["PRIMARY ACCOUNT NUMBER"] = $bancoInterconexionRequerimientoSalida->primary_account_number;
		$data["PROCESSING CODE"] = $bancoInterconexionRequerimientoSalida->processing_code;
		$data["AMOUNT TRANSACTION"] = $bancoInterconexionRequerimientoSalida->amount_transaction;
		$data["TRACE"] = $bancoInterconexionRequerimientoSalida->trace;
		$data["TIME LOCAL TRANSACTION"] = $bancoInterconexionRequerimientoSalida->time_local_transaction;
		$data["DATE LOCAL TRANSACTION"] = $bancoInterconexionRequerimientoSalida->date_local_transaction;
		$data["POS ENTRY MODE"] = $bancoInterconexionRequerimientoSalida->pos_entry_mode;
		$data["POS CONDITION CODE"] = $bancoInterconexionRequerimientoSalida->pos_condition_code;
		$data["ACQUIRER INSTITUTION ID CODE"] = $bancoInterconexionRequerimientoSalida->acquirer_institution_id_code;
		$data["FORWARD INSTITUTION ID CODE"] = $bancoInterconexionRequerimientoSalida->forward_institution_id_code;
		$data["RETRIEVAL REFERENCE NUMBER"] = $bancoInterconexionRequerimientoSalida->retrieval_reference_number;
		$data["APPROVAL CODE"] = "000301";
		$data["RESPONSE CODE"] = "00";
		$data["CARD ACCEPTOR TERMINAL ID"] = $bancoInterconexionRequerimientoSalida->card_acceptor_terminal_id;
		$data["TRANSACTION CURRENCY CODE"] = $bancoInterconexionRequerimientoSalida->transaction_currency_code;
		$data["LONGITUD"] = "0634";
		$data["CodigoEmpresa"] = $bancoInterconexionRequerimientoSalida->codigoempresa;
		$data["TipoConsulta"] = $bancoInterconexionRequerimientoSalida->tipoconsulta;
		$data["NumConsulta"] = $bancoInterconexionRequerimientoSalida->numconsulta;
		$data["CodigoErrorOriginal"] = "000";
		$data["DescRespuesta"] = "TRANSACCION PROCESADA OK";
		$data["NombreCliente"] = "GINOCCHIO MENDOZA PATRICIA MON";
		$data["NombreEmpresa"] = "LA POSITIVA";
		$data["NumDocs"] = "03";
		
		/************6. DEVOLVER DATOS WS DETALLE*******************/
		
		$bancoInterconexionRequerimientoDetalleSalida = BancoInterconexionDetalle::where("id_banco_interconexion",$id_banco_interconexion_requerimiento_respuesta)->get();
		
		$bloque_de_documentos_a_pagar = array();
		foreach($bancoInterconexionRequerimientoDetalleSalida as $row){
			$bloque_de_documentos_a_pagar["CodigoProducto"] = $row->codigoproducto;
			$bloque_de_documentos_a_pagar["NumDocumento"] = $row->numdocumento;
			$bloque_de_documentos_a_pagar["FechaVencimiento"] = $row->fechavencimiento;
			$bloque_de_documentos_a_pagar["FechaEmision"] = $row->fechaemision;
			$bloque_de_documentos_a_pagar["Deuda"] = $row->deuda;
			$bloque_de_documentos_a_pagar["Mora"] = $row->mora;
			$bloque_de_documentos_a_pagar["GastosAdm"] = $row->gastosadm;
			$bloque_de_documentos_a_pagar["ImporteTotal"] = $row->importetotal;
			$bloque_de_documentos_a_pagar["Periodo"] = $row->periodo;
			$bloque_de_documentos_a_pagar["Anio"] = $row->anio;
			$bloque_de_documentos_a_pagar["Cuota"] = $row->cuota;
			$bloque_de_documentos_a_pagar["MonedaDoc"] = $row->monedadoc;
			$bloque_de_documentos_a_pagar["Filler"] = $row->filler;
		}
		
		$data["Bloque de documentos a pagar"] = $bloque_de_documentos_a_pagar;
		
		/************7. DEVOLVER DATOS WS JSON*******************/
		
        $responsecode = 200;
        $header = array (
                'Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'
            );
		return response()->json($data , $responsecode, $header, JSON_UNESCAPED_UNICODE);
		
	}
	
	
	public function req_consulta(Request $request){
		
		/**********REQ CONSULTA************/
		/*
		{
        "input": "0200F038048188E080000000000000000080000000000000000000031000000000000000015502413564318062024010602000100820001000000081451689BPI4    898            SERV CLI X INTERNET                     6040059031510800803563190       0105                              "
}
		*/
		
		$input = $request->input('input');
		
		$arr_var_input = array("MESSAGE TYPE IDENTIFICATION","PRIMARY BIT MAP","SECONDARY BIT MAP","PRIMARY ACCOUNT NUMBER","PROCESSING CODE","AMOUNT TRANSACTION","TRACE","TIME LOCAL TRANSACTION","DATE LOCAL TRANSACTION","POS ENTRY MODE","POS CONDITION CODE","ACQUIRER INSTITUTION ID CODE","FORWARD INSTITUTION ID CODE","RETRIEVAL REFERENCE NUMBER","CARD ACCEPTOR TERMINAL ID","CARD ACCEPTOR ID CODE","CARD ACCEPTOR NAME LOCATION","TRANSACTION CURRENCY CODE","LONGITUD","CodigoEmpresa","CodigoProducto","TipoConsulta","NumConsulta","NumPagina","NumMaxDocs","Filler");
		
		$arr_indice_input = array(1,5,21,37,56,62,74,80,86,94,97,99,107,115,127,135,150,190,193,197,204,207,208,222,224,226);
		$arr_longitud_input = array(4,16,16,19,6,12,6,6,8,3,2,8,8,12,8,15,40,3,4,7,3,1,14,2,2,30);
		
		foreach($arr_var_input as $key=>$row){
			$data_input[$row] = substr($input,($arr_indice_input[$key]-1),$arr_longitud_input[$key]);
		}
		
		/**********RESP CONSULTA************/
		/*
		{
		"output": "0210F03804818E808000000000000000008000000000000000000003100000000002022501550241356431806202401060200010082000100000008145168900183700BPI4    6040982031510803563190       000TRANSACCION PROCESADA OK      SULLON VILELA FRANK GUILLERMO COOPAC SANTA ISABEL PERUN05008CREDITO INDIVIDUAL  25807275        CUOTA 42 CREDITO EFE1507202416062024000000040450000000000000000000000000000000040450000000040450072024421                              008CREDITO INDIVIDUAL  25807276        CUOTA 43 CREDITO EFE1508202416072024000000040450000000000000000000000000000000040450000000040450082024431                              008CREDITO INDIVIDUAL  25807277        CUOTA 44 CREDITO EFE1609202416082024000000040450000000000000000000000000000000040450000000040450092024441                              008CREDITO INDIVIDUAL  25807278        CUOTA 45 CREDITO EFE1510202417092024000000040450000000000000000000000000000000040450000000040450102024451                              008CREDITO INDIVIDUAL  25807279        CUOTA 46 CREDITO EFE1511202416102024000000040450000000000000000000000000000000040450000000040450112024461                              "
}
		*/
		
		$arr_var_igual = array("SECONDARY BIT MAP","PRIMARY ACCOUNT NUMBER","PROCESSING CODE","TRACE","TIME LOCAL TRANSACTION","DATE LOCAL TRANSACTION","POS ENTRY MODE","POS CONDITION CODE","ACQUIRER INSTITUTION ID CODE","FORWARD INSTITUTION ID CODE","RETRIEVAL REFERENCE NUMBER","APPROVAL CODE","RESPONSE CODE","CARD ACCEPTOR TERMINAL ID","TRANSACTION CURRENCY CODE","LONGITUD","CodigoEmpresa","TipoConsulta","NumConsulta","CodigoErrorOriginal","DescRespuesta","NombreCliente","NombreEmpresa","NumDocs");
		
		$arr_var_output = array("MESSAGE TYPE IDENTIFICATION","PRIMARY BIT MAP","SECONDARY BIT MAP","PRIMARY ACCOUNT NUMBER","PROCESSING CODE","AMOUNT TRANSACTION","TRACE","TIME LOCAL TRANSACTION","DATE LOCAL TRANSACTION","POS ENTRY MODE","POS CONDITION CODE","ACQUIRER INSTITUTION ID CODE","FORWARD INSTITUTION ID CODE","RETRIEVAL REFERENCE NUMBER","APPROVAL CODE","RESPONSE CODE","CARD ACCEPTOR TERMINAL ID","TRANSACTION CURRENCY CODE","LONGITUD","CodigoEmpresa","TipoConsulta","NumConsulta","CodigoErrorOriginal","DescRespuesta","NombreCliente","NombreEmpresa","NumDocs");
		
		foreach($arr_var_input as $key=>$row){
			$data_output[$row] = "";
			if(in_array($row, $arr_var_igual)){
				$data_output[$row] = $data_input[$row];
			}
		}
		
		//constantes
		$data_output["MESSAGE TYPE IDENTIFICATION"] = "0210";//4
		$data_output["PRIMARY BIT MAP"] = "F03804818E808000";//16
		$data_output["RESPONSE CODE"] = "00"; //2-De uso interno de Interbank. La Empresa siempre debe devolver ceros
		
		//base de datos
		$data_output["AMOUNT TRANSACTION"] = "000000005000"; //12-suma de los importes de las cuotas pendientes de pago enviadas
		$data_output["APPROVAL CODE"] = "000301"; //6-Código creado por la Empresa,código único por transacción.,codigo generado 
		$data_output["LONGITUD"] = "0634"; //4-Suma la longitud de las líneas desde P01 hasta el final
		$data_output["NombreCliente"] = "GINOCCHIO MENDOZA PATRICIA MON"; //30-Contiene el Nombre del DEUDOR al que pertenece las deudas
		$data_output["NombreEmpresa"] = "LA POSITIVA              "; //25-Empresa cliente de IBK (Recaudador)
		$data_output["NumDocs"] = "03"; //2-Cantidad de documentos por cobrar.
		
		//codigo respuesta
		$data_output["CodigoErrorOriginal"] = "000"; //3-Código de respuesta, utilizar los códigos de la hoja "RESPONSE CODE".
		$data_output["DescRespuesta"] = "TRANSACCION PROCESADA OK      "; //30-descripción del código en la línea anterior (P04)
		
		$data_output_detalle = array();
		$output_detalle = "";
		
		for($key=0;$key<5;$key++){
			$data_output_detalle[$key]["CodigoProducto"] = "sfsvfsv1";
			$data_output_detalle[$key]["DescrProducto"] = "sfsvfsv2";
			$data_output_detalle[$key]["NumDocumento"] = "sfsvfsv3";
			$data_output_detalle[$key]["FILLER"] = "sfsvfsv4";
			$data_output_detalle[$key]["DescDocumento"] = "sfsvfsv5";
			$data_output_detalle[$key]["FechaVencimiento"] = "sfsvfsv6";
			$data_output_detalle[$key]["FechaEmision"] = "sfsvfsv7";
			$data_output_detalle[$key]["Deuda"] = "sfsvfsv8";
			$data_output_detalle[$key]["Mora"] = "sfsvfsv9";
			$data_output_detalle[$key]["GastosAdm"] = "sfsvfsv10";
			$data_output_detalle[$key]["PagoMinimo"] = "sfsvfsv11";
			$data_output_detalle[$key]["ImporteTotal"] = "sfsvfsv12";
			$data_output_detalle[$key]["Periodo"] = "sfsvfsv13";
			$data_output_detalle[$key]["Año"] = "sfsvfsv14";
			$data_output_detalle[$key]["Cuota"] = "sfsvfsv15";
			$data_output_detalle[$key]["MonedaDoc"] = "sfsvfsv16";
			$data_output_detalle[$key]["Filler"] = "sfsvfsv17";
			
			$output_detalle .= implode('',$data_output_detalle[$key]);
			
		}
		
		$output = implode('',$data_output);
		
		$output .= $output_detalle;
		
		$data["output"] = $output;
		
		$responsecode = 200;
        $header = array (
                'Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'
            );
		return response()->json($data , $responsecode, $header, JSON_UNESCAPED_UNICODE);
	
	}	
			
}
