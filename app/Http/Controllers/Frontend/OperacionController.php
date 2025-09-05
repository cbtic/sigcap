<?php 

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\BancoInterconexione;
use App\Models\BancoInterconexionDetalle;
use App\Models\Comprobante;
use App\Models\Agremiado;
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
				//$bancoInterconexionRequerimientoDetalleEnvio->anio = $row["A�o"];
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
			//$bancoInterconexionDetalle->anio = $row["A�o"];
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
		
	function generarCodigoUnico6() {
		list($micro, $seg) = explode(" ", microtime());
		$horaMicro = date('His', $seg) . substr($micro, 2, 2); // HHMMSS + 2 dígitos de microsegundos
		return substr($horaMicro, -6); // Solo 6 dígitos
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
		
		$comprobante_model = new Comprobante;
		$p[]=strval($data_input["TipoConsulta"]);
		$p[]=(int)$data_input["NumConsulta"];
		$p[]="";
		$p[]="5";
		//print_r($data_input);exit();
		$deuda_pendiente = $comprobante_model->lista_deuda_pendiente($p);
		//print_r($deuda_pendiente);
		
		/**********RESP CONSULTA************/
		/*
		{
		"output": "0210F03804818E808000000000000000008000000000000000000003100000000002022501550241356431806202401060200010082000100000008145168900183700BPI4    6040982031510803563190       000TRANSACCION PROCESADA OK      SULLON VILELA FRANK GUILLERMO COOPAC SANTA ISABEL PERUN05008CREDITO INDIVIDUAL  25807275        CUOTA 42 CREDITO EFE1507202416062024000000040450000000000000000000000000000000040450000000040450072024421                              008CREDITO INDIVIDUAL  25807276        CUOTA 43 CREDITO EFE1508202416072024000000040450000000000000000000000000000000040450000000040450082024431                              008CREDITO INDIVIDUAL  25807277        CUOTA 44 CREDITO EFE1609202416082024000000040450000000000000000000000000000000040450000000040450092024441                              008CREDITO INDIVIDUAL  25807278        CUOTA 45 CREDITO EFE1510202417092024000000040450000000000000000000000000000000040450000000040450102024451                              008CREDITO INDIVIDUAL  25807279        CUOTA 46 CREDITO EFE1511202416102024000000040450000000000000000000000000000000040450000000040450112024461                              "
}
		*/
		
		$arr_var_igual = array("SECONDARY BIT MAP","PRIMARY ACCOUNT NUMBER","PROCESSING CODE","TRACE","TIME LOCAL TRANSACTION","DATE LOCAL TRANSACTION","POS ENTRY MODE","POS CONDITION CODE","ACQUIRER INSTITUTION ID CODE","FORWARD INSTITUTION ID CODE","RETRIEVAL REFERENCE NUMBER","CARD ACCEPTOR TERMINAL ID","TRANSACTION CURRENCY CODE","CodigoEmpresa","TipoConsulta","NumConsulta");
		
		$arr_var_output = array("MESSAGE TYPE IDENTIFICATION","PRIMARY BIT MAP","SECONDARY BIT MAP","PRIMARY ACCOUNT NUMBER","PROCESSING CODE","AMOUNT TRANSACTION","TRACE","TIME LOCAL TRANSACTION","DATE LOCAL TRANSACTION","POS ENTRY MODE","POS CONDITION CODE","ACQUIRER INSTITUTION ID CODE","FORWARD INSTITUTION ID CODE","RETRIEVAL REFERENCE NUMBER","APPROVAL CODE","RESPONSE CODE","CARD ACCEPTOR TERMINAL ID","TRANSACTION CURRENCY CODE","LONGITUD","CodigoEmpresa","TipoConsulta","NumConsulta","CodigoErrorOriginal","DescRespuesta","NombreCliente","NombreEmpresa","NumDocs");
		
		foreach($arr_var_output as $key=>$row){
			$data_output[$row] = "";
			if(in_array($row, $arr_var_igual)){
				$data_output[$row] = $data_input[$row];
			}
		}
		
		//CONSTANTES
		$data_output["MESSAGE TYPE IDENTIFICATION"] = "0210";//4
		$data_output["PRIMARY BIT MAP"] = "F03804818E808000";//16
		$data_output["RESPONSE CODE"] = "00"; //2-De uso interno de Interbank. La Empresa siempre debe devolver ceros
		
		$destinatario = "";

		if($data_input["TipoConsulta"]==0){
			$agremiado_model = new Agremiado;
			$agremiado_data = $agremiado_model->getAgremiado('85',(int)$data_input["NumConsulta"]);
			$destinatario = $agremiado_data->apellido_paterno." ".$agremiado_data->apellido_materno." ".$agremiado_data->nombres;
		}
		//echo $destinatario;exit();
		//BASE DE DATOS
		$nombreEmpresa = "COLEGIO ARQ PERU";
		//$nombreCliente = (count($deuda_pendiente)>0)?$deuda_pendiente[0]->destinatario:"";//"GINOCCHIO MENDOZA PATRICIA MON";
		$nombreCliente = $destinatario;
		$numDocs = count($deuda_pendiente);
		$suma_importes = 0;
		$correlativo = $this->generarCodigoUnico6();
		$suma_longitud = (174*count($deuda_pendiente))+112;//982//634;
		
		$data_output["AMOUNT TRANSACTION"] = str_pad($suma_importes, 12, "0", STR_PAD_LEFT); //12-suma de los importes de las cuotas pendientes de pago enviadas
		$data_output["APPROVAL CODE"] = str_pad($correlativo, 6, "0", STR_PAD_LEFT); //6-C�digo creado por la Empresa,c�digo �nico por transacci�n, codigo generado 
		$data_output["LONGITUD"] = str_pad($suma_longitud, 4, "0", STR_PAD_LEFT); //4-Suma la longitud de las l�neas desde P01 hasta el final
		$data_output["NombreCliente"] = str_pad($nombreCliente, 30, " ", STR_PAD_RIGHT); //30-Contiene el Nombre del DEUDOR al que pertenece las deudas
		$data_output["NombreEmpresa"] = str_pad($nombreEmpresa, 25, " ", STR_PAD_RIGHT); //25-Empresa cliente de IBK (Recaudador)
		$data_output["NumDocs"] = str_pad($numDocs, 2, "0", STR_PAD_LEFT); //2-Cantidad de documentos por cobrar.
		
		//RESPUESTA
		$descRespuesta = "TRANSACCION PROCESADA OK";
		//$descRespuesta = "TRANSACCIÓN PROCESADA OK";
		$data_output["CodigoErrorOriginal"] = "000"; //3-C�digo de respuesta, utilizar los c�digos de la hoja "RESPONSE CODE".
		
		if(count($deuda_pendiente)==0){
			$descRespuesta = "CLIENTE SIN DEUDA PENDIENTE";
			$data_output["CodigoErrorOriginal"] = "022";
		}

		//$data_output["DescRespuesta"] = str_pad($descRespuesta, 30, " ", STR_PAD_RIGHT); //30-descripci�n del c�digo en la l�nea anterior (P04)
		$data_output["DescRespuesta"] = $this->mb_sprintf_pad($descRespuesta, 30);

		$data_output_detalle = array();
		$output_detalle = "";
		
		foreach($deuda_pendiente as $row){
			
			$codigoProducto = $row->codigo_producto;//12;
			//echo $codigoProducto;echo "\n";
			$descrProducto = substr($row->descr_producto,0,20);//"DEUDA CUOTA";
			$numDocumento = $row->num_documento;//"FD221919437";
			$descDocumento = substr($row->desc_documento,0,20);//"FACTURA DICIEMBRE";
			
			$fechaVencimiento = date("dmY", strtotime($row->fecha_vencimiento));//"25122019";
			$fechaEmision = date("dmY", strtotime($row->fecha_emision));//"25122019";
			
			$deuda = $row->deuda;//16089;
			$mora = $row->mora;//1000;
			$gastosAdm = $row->gastos_adm;//600;
			$pagoMinimo = $row->pago_minimo;//17689;
			$importeTotal = $row->importe_total;//17689;
			
			$deuda = str_replace('.', '', $deuda);
			$sinPmoraunto = str_replace('.', '', $mora);
			$gastosAdm = str_replace('.', '', $gastosAdm);
			$pagoMinimo = str_replace('.', '', $pagoMinimo);
			$importeTotal = str_replace('.', '', $importeTotal);

			$periodo = $row->periodo;//9;
			$anio = $row->anio;//2024;
			$cuota = $row->cuota;//1;
			$monedaDoc = $row->moneda_doc;//1;
			
			$data_output_detalle[$key]["CodigoProducto"] = str_pad($codigoProducto, 3, "0", STR_PAD_LEFT);//3 - 17 o 19 servicios
			$data_output_detalle[$key]["DescrProducto"] = str_pad($descrProducto, 20, " ", STR_PAD_RIGHT);//20 - Contiene el nombre del Servicio, DEUDA CUOTA
			$data_output_detalle[$key]["NumDocumento"] = str_pad($numDocumento, 15, " ", STR_PAD_RIGHT);//15 - N�mero del documento de la deuda, se debe completar con espacios a la derecha, FD221919437
			$data_output_detalle[$key]["FILLER"] = " ";//1
			$data_output_detalle[$key]["DescDocumento"] = str_pad($descDocumento, 20, " ", STR_PAD_RIGHT);//20 - Descripci�n o referencia del documento de la deuda, FACTURA DICIEMBRE
			$data_output_detalle[$key]["FechaVencimiento"] = $fechaVencimiento;//8 - Fecha de Vencimiento de la deuda, 25122019
			$data_output_detalle[$key]["FechaEmision"] = $fechaEmision;//8 - Fecha de emisi�n de la deuda, debe ser menor o igual a la fecha de vencimiento, 25122019
			$data_output_detalle[$key]["Deuda"] = str_pad($deuda, 12, "0", STR_PAD_LEFT);//12 - Monto de deuda a pagar, incluye 2 decimales sin, 000000016089
			$data_output_detalle[$key]["Mora"] = str_pad($mora, 12, "0", STR_PAD_LEFT);//12 - Importe de la mora,  incluye 2 decimales sin punto, 000000001000
			$data_output_detalle[$key]["GastosAdm"] = str_pad($gastosAdm, 12, "0", STR_PAD_LEFT);//12 - Gastos administrativos,  incluye 2 decimales sin punto, 000000000600
			$data_output_detalle[$key]["PagoMinimo"] = str_pad($pagoMinimo, 12, "0", STR_PAD_LEFT);//12 - Este valor debe ser el mismo valor del importe total, 000000017689
			$data_output_detalle[$key]["ImporteTotal"] = str_pad($importeTotal, 12, "0", STR_PAD_LEFT);//12 - Importe total a pagar del documento = Deuda + Mora + GatosAdm. Incluye 2 decimales sin punto, 000000017689
			$data_output_detalle[$key]["Periodo"] = str_pad($periodo, 2, "0", STR_PAD_LEFT);//2 - Indica el periodo (Mes) al que pertenece la deuda. Si no tiene periodo enviar con 00, 12
			$data_output_detalle[$key]["A�o"] = $anio;//4 - Indica el a�o de la deuda, 2019
			$data_output_detalle[$key]["Cuota"] = str_pad($cuota, 2, "0", STR_PAD_LEFT);//2 - Indica el n�mero de cuota de la deuda, si no maneja cuotas enviar con 00, 01
			$data_output_detalle[$key]["MonedaDoc"] = $monedaDoc;//1 - Indica la moneda en la que est� expresado los importes de la deuda, 2
			$data_output_detalle[$key]["Filler"] = "                              ";//30 - Campo libre no usado, completar con espacios
			
			//print_r($data_output_detalle[$key]);
			$suma_importes += $data_output_detalle[$key]["ImporteTotal"];
			$output_detalle .= implode('',$data_output_detalle[$key]);
			
		}

		$data_output["AMOUNT TRANSACTION"] = str_pad($suma_importes, 12, "0", STR_PAD_LEFT); //12-suma de los importes de las cuotas pendientes de pago enviadas

		//print_r($data_output);exit();	
		
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

	
	public function req_pago(Request $request){
	
		return $this->operacion("pg",$request);
		
	}
	
	public function req_anulacion(Request $request){
	
		return $this->operacion("an",$request);
		
	}

	public function ext_pago(Request $request){
	
		return $this->operacion("ep",$request);
		
	}

	public function ext_anulacion(Request $request){
	
		return $this->operacion("ea",$request);
		
	}

	function mb_sprintf_pad($string, $length, $padType = STR_PAD_RIGHT, $encoding = "UTF-8") {
		// cantidad de caracteres visibles
		$lenChars = mb_strlen($string, $encoding);

		// cantidad de bytes reales
		$lenBytes = strlen($string);

		// diferencia por caracteres multibyte
		$diff = $lenBytes - $lenChars;

		// ancho ajustado para sprintf
		$adjustedLength = $length + $diff;

		switch ($padType) {
			case STR_PAD_LEFT:
				return sprintf("%" . $adjustedLength . "s", $string);
			case STR_PAD_BOTH:
				// centrado: calculamos manualmente
				$totalPad = $length - $lenChars;
				$left  = floor($totalPad / 2);
				$right = $totalPad - $left;
				return str_repeat(" ", $left) . $string . str_repeat(" ", $right);
			case STR_PAD_RIGHT:
			default:
				return sprintf("%-" . $adjustedLength . "s", $string);
		}
	}

	//public function req_pago(Request $request){ 
	public function operacion($opcion,Request $request){ 
		
		/**********REQ PAGO************/
		/*
		{
        "input": "0200F038048188E080000000000000000080000000000000000000021000000000004045010171813565018062024010602000100820001000000090416408SAN0    898            SERV CLI X INTERNET                     6040160031510803563190       010000000000000100825807275        1507202416062024000000040450000000000000000000000000000000040450072024421                              "
}
		*/
		
		$input = $request->input('input');
		
		$arr_var_input = array("MESSAGE TYPE IDENTIFICATION","PRIMARY BIT MAP","SECONDARY BIT MAP","PRIMARY ACCOUNT NUMBER","PROCESSING CODE","AMOUNT TRANSACTION","TRACE","TIME LOCAL TRANSACTION","DATE LOCAL TRANSACTION","POS ENTRY MODE",
		"POS CONDITION CODE","ACQUIRER INSTITUTION ID CODE","FORWARD INSTITUTION ID CODE","RETRIEVAL REFERENCE NUMBER","CARD ACCEPTOR TERMINAL ID","CARD ACCEPTOR ID CODE","CARD ACCEPTOR NAME LOCATION","TRANSACTION CURRENCY CODE","LONGITUD","CodigoEmpresa",
		"TipoConsulta","NumConsulta","FormaPago","NumReferenciaOriginal","NumDocs");
		
		$arr_indice_input = array(1,5,21,37,56,62,74,80,86,94, 97,99,107,115,127,135,150,190,193,197, 204,205,219,221,233);
		$arr_longitud_input = array(4,16,16,19,6,12,6,6,8,3, 2,8,8,12,8,15,40,3,4,7, 1,14,2,12,2);
		
		foreach($arr_var_input as $key=>$row){
			$data_input[$row] = substr($input,($arr_indice_input[$key]-1),$arr_longitud_input[$key]);
		}
		
		//$arr_indice_input_detalle = array(235,238,253,254,262,270,282,294,306,318,320,324,326,327);
		//$arr_longitud_input_detalle = array(5,15,1,8,8,12,12,12,12,2,4,2,1,30);
		
		//$arr_indice_input_detalle = array(235,240,255,263,271,283,295,307,319,321, 325,327);
		//$arr_longitud_input_detalle = array(5,15,8,8,12,12,12,12,2,4, 2,1);

		$arr_indice_input_detalle = array(235,238,253,254,262,270,282,294,306,318, 320,324,326,327);
		$arr_longitud_input_detalle = array(3,15,1,8,8,12,12,12,12,2,4, 2,1,30);

		$arr_var_input_detalle = array("CodigoProducto","NumDocumento","FILLER","FechaVencimiento","FechaEmision","Deuda","Mora","GastosAdm","ImporteTotal","Periodo","Anio","Cuota","MonedaDoc","Filler");
		
		for($i=0;$i<(int)$data_input["NumDocs"];$i++){
			foreach($arr_var_input_detalle as $key=>$row){
				$inicio = ($arr_indice_input_detalle[$key]-1)+(124*$i);
				$data_input_detalle[$i][$row] = substr($input,$inicio,$arr_longitud_input_detalle[$key]);
			}
		}
		
		//print_r($data_input_detalle);exit();
		
		$p_mov ="";
		$p_mov.="{";
        foreach ($data_input_detalle as $key => $value) {
			$p_mov.="{";
			$p_mov.=$value["CodigoProducto"].",";
			
			//$p_mov.="0,";
			$p_mov.=trim($value["NumDocumento"]).",";
			
			//$p_mov.="NULL,";
			//$p_mov.=str_pad(" ", 30, " ", STR_PAD_RIGHT).",";

			$p_mov.=$value["FechaVencimiento"].",";
			//echo $p_mov;exit();
			$p_mov.=$value["FechaEmision"].",";
			$p_mov.=$value["Deuda"].",";
			$p_mov.=$value["Mora"].",";
			$p_mov.=$value["GastosAdm"].",";
			//$p_mov.="0,";
			$p_mov.=$value["ImporteTotal"].",";
			$p_mov.=(int)$value["Periodo"].",";
			$p_mov.=$value["Anio"].",";
			$p_mov.=$value["Cuota"].",";
			$p_mov.=$value["MonedaDoc"];
			
			//$p_mov.=str_pad(" ", 30, " ", STR_PAD_RIGHT).",";
			//$p_mov.="NULL";
			//$p_mov .= "                              ";

			//$p_mov.="0,";
			//$p_mov.="0";
			$p_mov.="},";
        }
		if(strlen($p_mov)>1)$p_mov=substr($p_mov,0,-1);
		$p_mov.="}";
		
		//echo $p_mov;exit();
		
		$comprobante_model = new Comprobante;
		
		$p[]=$opcion;//"pg";
		$p[]=strval($data_input["TipoConsulta"]);
		$p[]=(int)$data_input["NumConsulta"];
		$p[]=$p_mov;
		
		$actualiza_pago = $comprobante_model->actualiza_pago_pos($p);
		
		//exit();
		
		/**********RESP PAGO************/
		/*
		{
		"output": "0210F03804818E808000000000000000008000000000000000000002100000000000404501017181356501806202401060200010082000100000009041640800183800SAN0    6040298031510803563190       000TRANSACCION PROCESADA OK      SULLON VILELA FRANK GUILLERMO COOPAC SANTA ISABEL PERUN00000122820301008CREDITO INDIVIDUAL  25807275        CUOTA 42 CREDITO EFE1507202416062024000000040450000000000000000000000000000000040450000000040450072024421                              "
}
		*/
		
		$arr_var_igual = array("SECONDARY BIT MAP","PRIMARY ACCOUNT NUMBER","PROCESSING CODE","AMOUNT TRANSACTION","TRACE","TIME LOCAL TRANSACTION","DATE LOCAL TRANSACTION","POS ENTRY MODE","POS CONDITION CODE","ACQUIRER INSTITUTION ID CODE","FORWARD INSTITUTION ID CODE","RETRIEVAL REFERENCE NUMBER","CARD ACCEPTOR TERMINAL ID","TRANSACTION CURRENCY CODE","CodigoEmpresa","TipoConsulta","NumConsulta");
		
		$arr_var_output = array("MESSAGE TYPE IDENTIFICATION","PRIMARY BIT MAP","SECONDARY BIT MAP","PRIMARY ACCOUNT NUMBER","PROCESSING CODE","AMOUNT TRANSACTION","TRACE","TIME LOCAL TRANSACTION","DATE LOCAL TRANSACTION","POS ENTRY MODE","POS CONDITION CODE","ACQUIRER INSTITUTION ID CODE","FORWARD INSTITUTION ID CODE","RETRIEVAL REFERENCE NUMBER","APPROVAL CODE","RESPONSE CODE","CARD ACCEPTOR TERMINAL ID","TRANSACTION CURRENCY CODE","LONGITUD","CodigoEmpresa","TipoConsulta","NumConsulta","CodigoErrorOriginal","DescRespuesta","NombreCliente","NombreEmpresa","NumOperacionERP","NumDocs");
		
		foreach($arr_var_output as $key=>$row){
			$data_output[$row] = "";
			if(in_array($row, $arr_var_igual)){
				$data_output[$row] = $data_input[$row];
			}
		}
		
		//CONSTANTES
		$data_output["MESSAGE TYPE IDENTIFICATION"] = "0210";//4

		if($opcion=="pg"){
			$data_output["MESSAGE TYPE IDENTIFICATION"] = "0210";//4
		}
		if($opcion=="an"){
			$data_output["MESSAGE TYPE IDENTIFICATION"] = "0200";//4
		}
		if($opcion=="ep"){
			$data_output["MESSAGE TYPE IDENTIFICATION"] = "0410";//4
		}	
		if($opcion=="ea"){
			$data_output["MESSAGE TYPE IDENTIFICATION"] = "0210";//4
		}

		$data_output["PRIMARY BIT MAP"] = "F03804818E808000";//16
		$data_output["RESPONSE CODE"] = "00"; //2-De uso interno de Interbank. La Empresa siempre debe devolver ceros
		
		$destinatario = "";

		if($data_input["TipoConsulta"]==0){
			$agremiado_model = new Agremiado;
			$agremiado_data = $agremiado_model->getAgremiado('85',(int)$data_input["NumConsulta"]);
			$destinatario = $agremiado_data->apellido_paterno." ".$agremiado_data->apellido_materno." ".$agremiado_data->nombres;
		}
		
		//BASE DE DATOS
		/*
		$nombreEmpresa = "COLEGIO ARQ PERU";
		$nombreCliente = "GINOCCHIO MENDOZA PATRICIA MON";
		$numDocs = "3";
		$suma_importes = 5000;
		$correlativo = 301;
		$suma_longitud = 634;
		$numOperacionERP = 89063;
		*/ 
		
		$nombreEmpresa = "COLEGIO ARQ PERU";
		$nombreCliente = $destinatario;
		$numDocs = count($actualiza_pago);
		$suma_importes = 0;
		$correlativo = $this->generarCodigoUnico6();
		//$suma_longitud = (174*count($actualiza_pago))+112;//982//634;
		$suma_longitud = 634;
		$numOperacionERP = 89063;

		$data_output["AMOUNT TRANSACTION"] = str_pad($suma_importes, 12, "0", STR_PAD_LEFT); //12-suma de los importes de las cuotas pendientes de pago enviadas
		$data_output["APPROVAL CODE"] = str_pad($correlativo, 6, "0", STR_PAD_LEFT); //6-C�digo creado por la Empresa,c�digo �nico por transacci�n, codigo generado 
		$data_output["LONGITUD"] = str_pad($suma_longitud, 4, "0", STR_PAD_LEFT); //4-Suma la longitud de las l�neas desde P01 hasta el final
		$data_output["NombreCliente"] = str_pad($nombreCliente, 30, " ", STR_PAD_RIGHT); //30-Contiene el Nombre del DEUDOR al que pertenece las deudas
		$data_output["NombreEmpresa"] = str_pad($nombreEmpresa, 25, " ", STR_PAD_RIGHT); //25-Empresa cliente de IBK (Recaudador)
		$data_output["NumOperacionERP"] = str_pad($numOperacionERP, 12, "0", STR_PAD_LEFT); //4-Suma la longitud de las l�neas desde P01 hasta el final
		$data_output["NumDocs"] = str_pad($numDocs, 2, "0", STR_PAD_LEFT); //2-Cantidad de documentos por cobrar.
		
		//RESPUESTA
		$descRespuesta = "TRANSACCION PROCESADA OK";
		$data_output["CodigoErrorOriginal"] = "000"; //3-C�digo de respuesta, utilizar los c�digos de la hoja "RESPONSE CODE".
		
		if(count($actualiza_pago)==0){
			$descRespuesta = "CLIENTE SIN DEUDA PENDIENTE";
			$data_output["CodigoErrorOriginal"] = "022";
		}else{
			
			if(isset($actualiza_pago[0])){
				$descRespuesta = $actualiza_pago[0]->desc_respuesta;
				$data_output["CodigoErrorOriginal"] = $actualiza_pago[0]->codigo_error_original; //3-C�digo de respuesta, utilizar los c�digos de la hoja "RESPONSE CODE".
			}
		}

		//$data_output["DescRespuesta"] = str_pad($descRespuesta, 30, " ", STR_PAD_RIGHT); //30-descripci�n del c�digo en la l�nea anterior (P04)
		//$data_output["DescRespuesta"] = $this->mb_str_pad($descRespuesta, 30, " "); //30-descripci�n del c�digo en la l�nea anterior (P04)
		//$data_output["DescRespuesta"] = sprintf("%-30s", $descRespuesta);
		$data_output["DescRespuesta"] = $this->mb_sprintf_pad($descRespuesta, 30);

		//print_r($data_output);exit();
		$data_output_detalle = array();
		$output_detalle = "";
		//print_r($actualiza_pago);exit();
		foreach($actualiza_pago as $row){
			
			$codigoProducto = $row->codigo_producto;//12;
			$descrProducto = substr($row->descr_producto,0,20);//"DEUDA CUOTA";
			$numDocumento = $row->num_documento;//"FD221919437";
			$descDocumento = substr($row->desc_documento,0,20);//"FACTURA DICIEMBRE";
			
			$fechaVencimiento = date("dmY", strtotime($row->fecha_vencimiento));//"25122019";
			$fechaEmision = date("dmY", strtotime($row->fecha_emision));//"25122019";
			
			$deuda = $row->deuda;//16089;
			$mora = $row->mora;//1000;
			$gastosAdm = $row->gastos_adm;//600;
			$pagoMinimo = $row->pago_minimo;//17689;
			$importeTotal = $row->importe_total;//17689;
			
			$deuda = str_replace('.', '', $deuda);
			$mora = str_replace('.', '', $mora);
			$gastosAdm = str_replace('.', '', $gastosAdm);
			$pagoMinimo = str_replace('.', '', $pagoMinimo);
			$importeTotal = str_replace('.', '', $importeTotal);

			$periodo = $row->periodo;//9;
			$anio = $row->anio;//2024;
			$cuota = $row->cuota;//1;
			$monedaDoc = $row->moneda_doc;//1;
			
			$data_output_detalle[$key]["CodigoProducto"] = str_pad($codigoProducto, 3, "0", STR_PAD_LEFT);//3 - 17 o 19 servicios
			$data_output_detalle[$key]["DescrProducto"] = str_pad($descrProducto, 20, " ", STR_PAD_RIGHT);//20 - Contiene el nombre del Servicio, DEUDA CUOTA
			$data_output_detalle[$key]["NumDocumento"] = str_pad($numDocumento, 15, " ", STR_PAD_RIGHT);//15 - N�mero del documento de la deuda, se debe completar con espacios a la derecha, FD221919437
			$data_output_detalle[$key]["FILLER"] = " ";//1
			$data_output_detalle[$key]["DescDocumento"] = str_pad($descDocumento, 20, " ", STR_PAD_RIGHT);//20 - Descripci�n o referencia del documento de la deuda, FACTURA DICIEMBRE
			$data_output_detalle[$key]["FechaVencimiento"] = $fechaVencimiento;//8 - Fecha de Vencimiento de la deuda, 25122019
			$data_output_detalle[$key]["FechaEmision"] = $fechaEmision;//8 - Fecha de emisi�n de la deuda, debe ser menor o igual a la fecha de vencimiento, 25122019
			$data_output_detalle[$key]["Deuda"] = str_pad($deuda, 12, "0", STR_PAD_LEFT);//12 - Monto de deuda a pagar, incluye 2 decimales sin, 000000016089
			$data_output_detalle[$key]["Mora"] = str_pad($mora, 12, "0", STR_PAD_LEFT);//12 - Importe de la mora,  incluye 2 decimales sin punto, 000000001000
			$data_output_detalle[$key]["GastosAdm"] = str_pad($gastosAdm, 12, "0", STR_PAD_LEFT);//12 - Gastos administrativos,  incluye 2 decimales sin punto, 000000000600
			$data_output_detalle[$key]["PagoMinimo"] = str_pad($pagoMinimo, 12, "0", STR_PAD_LEFT);//12 - Este valor debe ser el mismo valor del importe total, 000000017689
			$data_output_detalle[$key]["ImporteTotal"] = str_pad($importeTotal, 12, "0", STR_PAD_LEFT);//12 - Importe total a pagar del documento = Deuda + Mora + GatosAdm. Incluye 2 decimales sin punto, 000000017689
			$data_output_detalle[$key]["Periodo"] = str_pad($periodo, 2, "0", STR_PAD_LEFT);//2 - Indica el periodo (Mes) al que pertenece la deuda. Si no tiene periodo enviar con 00, 12
			$data_output_detalle[$key]["A�o"] = $anio;//4 - Indica el a�o de la deuda, 2019
			$data_output_detalle[$key]["Cuota"] = str_pad($cuota, 2, "0", STR_PAD_LEFT);//2 - Indica el n�mero de cuota de la deuda, si no maneja cuotas enviar con 00, 01
			$data_output_detalle[$key]["MonedaDoc"] = $monedaDoc;//1 - Indica la moneda en la que est� expresado los importes de la deuda, 2
			$data_output_detalle[$key]["Filler"] = "                              ";//30 - Campo libre no usado, completar con espacios
			
			//print_r($data_output_detalle[$key]);
			$suma_importes += $data_output_detalle[$key]["ImporteTotal"];
			$output_detalle .= implode('',$data_output_detalle[$key]);
			
		}

		$data_output["AMOUNT TRANSACTION"] = str_pad($suma_importes, 12, "0", STR_PAD_LEFT); //12-suma de los importes de las cuotas pendientes de pago enviadas
		
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
