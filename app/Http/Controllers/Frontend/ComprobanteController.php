<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comprobante;
use App\Models\Empresa;
use App\Models\ComprobanteDetalle;
use App\Models\TablaMaestra;
use App\Models\Valorizacione;
use App\Models\Persona;
use App\Models\Guia;


use Auth;

class ComprobanteController extends Controller
{
	public function index(){
        //$facturas_model = new Factura;
        //$facturas = $facturas_model->getFactura();
        //$facturas = Factura::where('fac_destinatario', 'like','%')->orderBy('id','desc')->get()->all();
        //print_r($facturas);

        return view('frontend.comprobante.all');
    }



	public function edit(Request $request){

        $trans = $request->Trans;
        $id_caja=$request->id_caja;

        //print_r($id_caja); exit();

		if($id_caja==""){
			$valorizaciones_model = new Valorizacione;
			$id_user = Auth::user()->id;
			$caja_usuario = $valorizaciones_model->getCajaIngresoByusuario($id_user,'91');
			//$id_caja = $caja_usuario->id_caja;
			$id_caja = (isset($caja_usuario->id_caja))?$caja_usuario->id_caja:0;
		}

		//echo $id_caja;exit();

        $TipoF = $request->TipoF;
        //$TipoF = 'BVBV';
		//echo $TipoF;
        if ($TipoF == 'FTFT') {$TipoF = 'FT'; $titulo = 'Nueva Factura';}
        if ($TipoF == 'BVBV') {$TipoF = 'BV'; $titulo = 'Nueva Boleta de Venta';}
        if ($TipoF == 'NCFT') {$TipoF = 'NCF'; $titulo = 'Nueva Nota Crédito Factura';}
        if ($TipoF == 'NCBV') {$TipoF = 'NCB'; $titulo = 'Nueva Nota Crédito Boleta de Venta';}
        if ($TipoF == 'NDFT') {$TipoF = 'NDF'; $titulo = 'Nueva Nota Dévito Factura';}
        if ($TipoF == 'NDBV') {$TipoF = 'NDB'; $titulo = 'Nueva Nota Dévito Boleta de Venta';}
        if ($TipoF == 'TKTK') {$TipoF = 'TK'; $titulo = 'Nuevo Ticket';}

        $empresa_model = new Empresa;
        $serie_model = new TablaMaestra;

		$tabla_model = new TablaMaestra;
		$forma_pago = $tabla_model->getMaestroByTipo('19');
        $tipooperacion = $tabla_model->getMaestroByTipo('103');
        $formapago = $tabla_model->getMaestroByTipo('104');


        if ($trans == 'FA'){

            //$serie = $serie_model->getMaestro('SERIES',$TipoF);
            $serie = $serie_model->getMaestroC('95',$TipoF);
            

            //$MonAd = $request->MonAd;
            $MonAd = 0;
            $total   = $request->total;

            $adelanto   = 'N';



            if ($MonAd != '0' && $total <> $MonAd){
                $total   = $MonAd;
                $adelanto   = 'S';
            }else{
                $MonAd = 0;
            }
            //echo "adelanto=>".$adelanto."<br>";


            $stotal = $total/1.18;
            $igv   = $stotal * 0.18;



            $factura_detalle = $request->comprobante_detalle;

            $ind = 0;
            foreach($request->comprobante_detalles as $key=>$det){
                $facturad[$ind] = $factura_detalle[$key];
                $ind++;
            }

            $ubicacion = $request->id_ubicacion;
            $persona = $request->id_persona;
            $tipoDocP = $request->tipo_documento;
			$empresa_id = $request->empresa_id;
            //echo $$tipoDocP;exit();

			// DNI = 78

            if($tipoDocP == "78" && $TipoF == 'FT'){
                //$ubicacion = $request->id_ubicacion_p;
                $empresa_id = $request->empresa_id;

                //echo $ubicacion;exit();
            }

            //echo "persona:".$persona." ubicacion".$ubicacion; exit();
			//echo $ubicacion; exit();
			//echo $TipoF;exit();
			if($ubicacion=="")$ubicacion=3070;
            if ($TipoF == 'BV' || $TipoF == 'TK'){
                $empresa = $empresa_model->getPersonaId($persona);

				if(!$empresa){
					//echo $ubicacion;exit();
					$empresa = $empresa_model->getEmpresaId($ubicacion);
				}

            }
            else{
                $empresa = $empresa_model->getEmpresaId($ubicacion);
            }
            return view('frontend.comprobante.create',compact('trans', 'titulo','empresa', 'facturad', 'total', 'igv', 'stotal','TipoF','ubicacion', 'persona','id_caja','serie', 'adelanto','MonAd','forma_pago','tipooperacion','formapago'));
        }
        if ($trans == 'FN'){
            //$serie = $serie_model->getMaestro('SERIES',$TipoF);
            $serie = $serie_model->getMaestroC('95',$TipoF);

            return view('frontend.factura.create',compact('trans', 'titulo','TipoF','id_caja','serie'));
        }
        if ($trans == 'FE'){

            //print_r($facturad);
            $fac_id = $request->fac_id;
            //$facturas_model = new Factura;
            //$factura = $facturas_model->getFactura();
            $facturas = Comprobante::where('id', $fac_id)->first();
            //$facturas = Factura::where('fac_destinatario', 'like','$fac_id')->orderBy('fac_numero','asc')->paginate(5);
            //print_r($facturas);
            $TipoF =  $facturas->fac_tipo;

            if ($TipoF == 'FT') {$titulo = 'Edita Factura';}
            if ($TipoF == 'BV') {$titulo = 'Edita Boleta de Venta';}
            if ($TipoF == 'NCF') {$titulo = 'Edita Nota Crédito Factura';}
            if ($TipoF == 'NCB') {$titulo = 'Edita Nota Crédito Boleta de Venta';}
            if ($TipoF == 'NDF') {$titulo = 'Edita Nota Dévito Factura';}
            if ($TipoF == 'NDB') {$titulo = 'Edita Nota Dévito Boleta de Venta';}
            if ($TipoF == 'TK') {$titulo = 'Edita Ticket';}


            $facturad = ComprobanteDetalle::where([
                'facd_serie' => $facturas->fac_serie,
                'facd_numero' => $facturas->fac_numero,
                'facd_tipo' => $facturas->fac_tipo
            ])->get();

            return view('frontend.factura.create',compact('trans', 'titulo','TipoF', 'facturas','facturad'));
        }
    }

	public function create(Request $request){


        //echo "Ubica=>".$request->id_ubicacion."<br>";
        //echo "Trans=>".$request->Trans."<br>";
        //echo "Total=>".$request->total."<br>";

       // echo "MonAd=>".$request->MonAd."<br>";
        //print_r($request->factura_detalle);
        //print_r($request->vsm_smodulo);
        //dd($request->all());

        //echo "vestab=>".$request->vestab."<br>";
        //echo "persona_id=>".$request->persona_id."<br>";
    

        $trans = $request->Trans;
        $id_caja=$request->id_caja;

		//if($id_caja=="")$id_caja = Session::get('id_caja');

		if($id_caja==""){
			$valorizaciones_model = new Valorizacione;
			$id_user = Auth::user()->id;
			$caja_usuario = $valorizaciones_model->getCajaIngresoByusuario($id_user,'CARRETA');
			//$id_caja = $caja_usuario->id_caja;
			$id_caja = (isset($caja_usuario->id_caja))?$caja_usuario->id_caja:0;
		}

		//echo $id_caja;exit();

        $TipoF = $request->TipoF;
        //$TipoF = 'BVBV';
		//echo $TipoF;
        if ($TipoF == 'FTFT') {$TipoF = 'FT'; $titulo = 'Nueva Factura';}
        if ($TipoF == 'BVBV') {$TipoF = 'BV'; $titulo = 'Nueva Boleta de Venta';}
        if ($TipoF == 'NCFT') {$TipoF = 'NCF'; $titulo = 'Nueva Nota Crédito Factura';}
        if ($TipoF == 'NCBV') {$TipoF = 'NCB'; $titulo = 'Nueva Nota Crédito Boleta de Venta';}
        if ($TipoF == 'NDFT') {$TipoF = 'NDF'; $titulo = 'Nueva Nota Dévito Factura';}
        if ($TipoF == 'NDBV') {$TipoF = 'NDB'; $titulo = 'Nueva Nota Dévito Boleta de Venta';}
        if ($TipoF == 'TKTK') {$TipoF = 'TK'; $titulo = 'Nuevo Ticket';}

        $empresa_model = new Empresa;
        $serie_model = new TablaMaestra;


        if ($trans == 'FA'){
            $serie = $serie_model->getMaestro('SERIES',$TipoF);

            $MonAd = $request->MonAd;
            $total   = $request->total;

            $adelanto   = 'N';



            if ($MonAd != '0' && $total <> $MonAd){
                $total   = $MonAd;
                $adelanto   = 'S';
            }else{
                $MonAd = 0;
            }
            //echo "adelanto=>".$adelanto."<br>";


            $stotal = $total/1.18;
            $igv   = $stotal * 0.18;



            $factura_detalle = $request->factura_detalle;

            ///echo $factura_detalle;exit();

            $ind = 0;
            foreach($request->factura_detalles as $key=>$det){
                $facturad[$ind] = $factura_detalle[$key];
                $ind++;
            }

            $ubicacion = $request->id_ubicacion;
            $persona = $request->persona_id;
            $tipoDocP = $request->tipo_documento;
            //echo $$tipoDocP;exit();

            if($tipoDocP == "DNI" && $TipoF == 'FT'){
                $ubicacion = $request->id_ubicacion_p;
            }

            if ($TipoF == 'BV'){
                $empresa = $empresa_model->getPersonaId($persona);
            }
            else{
                $empresa = $empresa_model->getEmpresaId($ubicacion);
            }
            return view('frontend.factura.create',compact('trans', 'titulo','empresa', 'facturad', 'total', 'igv', 'stotal','TipoF','ubicacion', 'persona','id_caja','serie', 'adelanto','MonAd'));
        }
        if ($trans == 'FN'){
            $serie = $serie_model->getMaestro('SERIES',$TipoF);


            return view('frontend.factura.create',compact('trans', 'titulo','TipoF','id_caja','serie'));
        }
        if ($trans == 'FE'){

            //print_r($facturad);
            $fac_id = $request->fac_id;
            //$facturas_model = new Factura;
            //$factura = $facturas_model->getFactura();
            $facturas = Factura::where('id', $fac_id)->first();
            //$facturas = Factura::where('fac_destinatario', 'like','$fac_id')->orderBy('fac_numero','asc')->paginate(5);
            //print_r($facturas);
            $TipoF =  $facturas->fac_tipo;

            if ($TipoF == 'FT') {$titulo = 'Edita Factura';}
            if ($TipoF == 'BV') {$titulo = 'Edita Boleta de Venta';}
            if ($TipoF == 'NCF') {$titulo = 'Edita Nota Crédito Factura';}
            if ($TipoF == 'NCB') {$titulo = 'Edita Nota Crédito Boleta de Venta';}
            if ($TipoF == 'NDF') {$titulo = 'Edita Nota Dévito Factura';}
            if ($TipoF == 'NDB') {$titulo = 'Edita Nota Dévito Boleta de Venta';}
            if ($TipoF == 'TK') {$titulo = 'Edita Ticket';}


            $facturad = FacturaDetalle::where([
                'facd_serie' => $facturas->fac_serie,
                'facd_numero' => $facturas->fac_numero,
                'facd_tipo' => $facturas->fac_tipo
            ])->get();
/*
            $ind = 0;
            foreach($factura_detalles as $key=>$det){
                $facturad[$ind] = $factura_detalle[$key];
                $ind++;
            }
*/
            //$TipoF =  $facturas->fac_id;
            //echo "fac_id=>".$request->fac_id."<br>";

            //print_r($facturad); exit();

            return view('frontend.factura.create',compact('trans', 'titulo','TipoF', 'facturas','facturad'));
        }
    }

    public function send(Request $request)
    {

		$sw = true;
		$msg = "";

		$id_user = Auth::user()->id;
        $facturas_model = new Comprobante;
		$guia_model = new Guia;

		//$facturaExiste = $facturas_model->getValidaFactura($request->TipoF,$request->ubicacion,$request->persona,$request->totalF);
		//if(count($facturaExiste)==0){

			/**********RUC***********/

			$tarifa = $request->facturad;

		   //print_r($tarifa);

			//echo "serieF=>".$request->serieF."<br>";
			//echo "TipoF=>".$request->TipoF."<br>";
			//echo "fechaF=>".$request->fechaF."<br>";
			//echo "vestab=>".$request->vestab."<br>";
			//echo "totalF=>".$request->totalF."<br>";
			//echo "ubicacion=>".$request->ubicacion."<br>";
			//echo "persona=>".$request->persona."<br>";

			//echo "id_caja=>".$request->id_caja."<br>";exit();
			//$val_estab = $request->vestab;



			$total = $request->totalF;
			$serieF = $request->serieF;
			$tipoF = $request->TipoF;
			$ubicacion_id = $request->ubicacion;
			$id_persona = $request->persona;
			$id_caja = $request->id_caja;
			$adelanto   = $request->adelanto;

			$trans = $request->trans;

			//$std =  $this->getTipoDocPersona($id_persona );

			//print_r($std);
			//exit();

			//1	DOLARES
			//2	SOLES

			if ($trans == 'FA' || $trans == 'FN'){

				$ws_model = new TablaMaestra;
				
				/*************************************/
				
				foreach ($tarifa as $key => $value) {
					//$vestab = $value['vestab'];
					//$vcodigo = $value['vcodigo'];
                    $id_val = $value['id'];

				}
				
				//$valoriza = Valorizacione::where('val_aten_estab', '=', $vestab)->where('val_codigo', '=', $vcodigo)->first();                
                $valoriza = Valorizacione::find($id_val);

				$id_moneda=1;
				if(isset($valoriza->id_moneda) && $valoriza->id_moneda == 1)$id_moneda=2;
				if(isset($valoriza->id_moneda) && $valoriza->id_moneda == 2)$id_moneda=1;
				
				//echo $valoriza->val_codigo."-----";
				//$ingreso = IngresoVehiculo::where('aten_establecimiento', '=', $valoriza->val_estab)->where('aten_numero', '=', $valoriza->val_aten_codigo)->first();
				
				/*************************************/
				
				$id_factura = $facturas_model->registrar_factura_moneda($serieF,     0, $tipoF, $ubicacion_id, $id_persona, $total,          '',           '',    0, $id_caja,          0,    'f',     $id_user,  $id_moneda);
																	 //(serie,  numero,   tipo,     ubicacion,     persona,  total, descripcion, cod_contable, id_v,   id_caja, descuento, accion, p_id_usuario, p_id_moneda)

				$factura = Comprobante::where('id', $id_factura)->get()[0];

				$fac_serie = $factura->serie;
				$fac_numero = $factura->numero;

				$factura_upd = Comprobante::find($id_factura);
				if(isset($factura_upd->tipo_cambio)) $factura_upd->tipo_cambio = $request->tipo_cambio;
				$factura_upd->save();


				//echo "adelanto=>".$request->adelanto."<br>";
				//echo "adelanto=>".$request->MonAd."<br>";
				
/*
				if(isset($ingreso->servicio) && $ingreso->servicio=="Venta de Productos Hidrobiologicos"){
					
					$serie="T001";$numero="0";$tipo="GR";$serie_relacionado="";$num_relacionado="";$tipo_relacionado="";$serie_baja="";$num_baja="";$tipo_baja="";$emisor_numdoc="20160453908";$emisor_tipodoc="0";$emisor_razsocial="FELMO SRLTDA";$receptor_numdoc=$factura->fac_cod_tributario;$receptor_tipodoc="0";$receptor_razsocial=$factura->fac_destinatario;$tercero_numdoc="";$tercero_tipodoc="";$tercero_razsocial="";$cod_motivo="";$desc_motivo="";$transbordo="";$peso_bruto=($ingreso->peso_a_cobrar/1000);$bultos="";$modo_traslado="";$fecha_traslado=$factura->fac_fecha;$transportista_numdoc="";$transportista_tipo_doc="";$transportista_razsoc="";$vehiculo_placa=$ingreso->placa;$conductor_numdoc="";$conductor_tipodoc="";$llegada_ubigeo="";$llegada_direccion=$request->guia_llegada_direccion;$partida_ubigeo="";$partida_direccion="AV. NESTOR GAMBETA Nº 6311 - CALLAO";$numero_contenedor="";$puerto_desembarque="";$observaciones="";$ruta_comprobante="";$email="";$estado_email="";$estado_sunat="";$anulado="N";$orden_item="0";$codigo="";$descripcion="";$cantidad="0";$unid_medida="";$accion="";
					
					$id_guia = $guia_model->registrar_guia($serie,$numero,$tipo,$serie_relacionado,$num_relacionado,$tipo_relacionado,$serie_baja,$num_baja,$tipo_baja,$emisor_numdoc,$emisor_tipodoc,$emisor_razsocial,$receptor_numdoc,$receptor_tipodoc,$receptor_razsocial,$tercero_numdoc,$tercero_tipodoc,$tercero_razsocial,$cod_motivo,$desc_motivo,$transbordo,$peso_bruto,$bultos,$modo_traslado,$fecha_traslado,$transportista_numdoc,$transportista_tipo_doc,$transportista_razsoc,$vehiculo_placa,$conductor_numdoc,$conductor_tipodoc,$llegada_ubigeo,$llegada_direccion,$partida_ubigeo,$partida_direccion,$numero_contenedor,$puerto_desembarque,$observaciones,$ruta_comprobante,$email,$estado_email,$estado_sunat,$anulado,$orden_item,$codigo,$descripcion,$cantidad,$unid_medida,"g");
					
					$guia = Guia::where('id', $id_guia)->get()[0];
					$guia_serie = $guia->guia_serie;
					$guia_numero = $guia->guia_numero;
					$guia_tipo = $guia->guia_tipo;
					
					$factura_upd = Factura::find($id_factura);
					$factura_upd->fac_serie_guia = $guia_serie;
					$factura_upd->fac_nro_guia = $guia_numero;
					$factura_upd->fac_tipo_guia = $guia_tipo;
					$factura_upd->save();
					
				}
                */
				
				foreach ($tarifa as $key => $value) {
					//echo "denominacion=>".$value['denominacion']."<br>";
					if ($adelanto == 'S'){
						$total   = $request->MonAd;
					}
					else{
						$total   = $value['monto'];
					}
					$descuento = $value['descuento'];
					if ($value['descuento']=='') $descuento = 0;
					$id_factura_detalle = $facturas_model->registrar_factura_moneda($serieF, $fac_numero, $tipoF, $value['item'], $value['id_concepto'], $total, $value['descripcion'], $value['cod_contable'], $value['id'], $id_factura, $descuento,    'd',     $id_user,  $id_moneda);
																				 //(  serie,      numero,   tipo,      ubicacion,               persona,  total,            descripcion,           cod_contable,         id_v,     id_caja,  descuento, accion, p_id_usuario, p_id_moneda)
					
                    /*
					if(isset($ingreso->servicio) && $ingreso->servicio=="Venta de Productos Hidrobiologicos"){
						$value['denominacion']="RESIDUOS HIDROBIOLOGICOS";
						$id_guia_detalle = $guia_model->registrar_guia($guia_serie,$guia_numero,$guia_tipo,$serie_relacionado,$num_relacionado,$tipo_relacionado,$serie_baja,$num_baja,$tipo_baja,$emisor_numdoc,$emisor_tipodoc,$emisor_razsocial,$receptor_numdoc,$receptor_tipodoc,$receptor_razsocial,$tercero_numdoc,$tercero_tipodoc,$tercero_razsocial,$cod_motivo,$desc_motivo,$transbordo,$peso_bruto,$bultos,$modo_traslado,$fecha_traslado,$transportista_numdoc,$transportista_tipo_doc,$transportista_razsoc,$vehiculo_placa,$conductor_numdoc,$conductor_tipodoc,$llegada_ubigeo,$llegada_direccion,$partida_ubigeo,$partida_direccion,$numero_contenedor,$puerto_desembarque,$observaciones,$ruta_comprobante,$email,$estado_email,$estado_sunat,$anulado,$value['item'],$value['vcodigo'],$value['denominacion'],1,"TM","d");
					}
                    */
				
				}

				$estado_ws = $ws_model->getMaestroByTipo('96');
				$flagWs = isset($estado_ws[0]->codigo)?$estado_ws[0]->codigo:1;

				if ($flagWs==2 && $id_factura>0 && ($tipoF=="FT" || $tipoF=="BV")){
					$this->firmar($id_factura);
				}

				//echo $id_factura;


			}
			if ($trans == 'FE') {
				//echo $request->id_factura;
				$id_factura = $request->id_factura;
			}

		//}else{
			//$sw = false;
			//$msg = "La Factura ingresada ya existe !!!";
			//$id_factura = 0;
		//}

		$array["sw"] = $sw;
        $array["msg"] = $msg;
		$array["id_factura"] = $id_factura;
        echo json_encode($array);

        //echo 1;

        //Mail::send(new SendContact($request));

        //return redirect()->back()->withFlashSuccess(__('alerts.frontend.contact.sent'));
    }
	public function show($id){
        $factura_model = new Comprobante;

        $factura = Comprobante::where('id', $id)->get()[0];


        $facd_serie = $factura->serie;
        $facd_numero = $factura->numero;
        $facd_tipo = $factura->tipo;

		//echo "facd_serie=>".$facd_serie."<br>";
		//echo "facd_numero=>".$facd_numero."<br>";
		//echo "facd_tipo=>".$facd_tipo."<br>";
		
		$id_guia = 0;
		
		if($factura->nro_guia!=""){
			$fac_serie_guia = $factura->serie_guia;
			$fac_nro_guia = $factura->nro_guia;
			$fac_tipo_guia = $factura->tipo_guia;
			
			$guia = Guia::where('guia_serie', '=', $fac_serie_guia)->where('guia_numero', '=', $fac_nro_guia)->where('guia_tipo', '=', $fac_tipo_guia)->first();
			$id_guia = $guia->id;
		}
        //echo "fac_tipo=>".$factura->fac_tipo."<br>";

        $factura_detail_model = new ComprobanteDetalle;
        $factura_detalles = ComprobanteDetalle::where([
            'serie' => $facd_serie,
            'numero' => $facd_numero,
            'tipo' => $facd_tipo
        ])->get();
        //print_r($factura_detalles);

        return view('frontend.comprobante.show',compact('factura','factura_detalles','id_guia'));
    }
	public function listar_comprobante(Request $request){
		$factura_model = new comprobante();
		$p[]=$request->fecha_ini;
		$p[]=$request->fecha_fin;
		$p[]=$request->tipo_documento;
        $p[]=$request->serie;
        $p[]=$request->numero;
        $p[]=$request->razon_social;
        $p[]=$request->estado_pago;
        $p[]=$request->anulado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		
		$data = $factura_model->listar_comprobante($p);
		
		$iTotalDisplayRecords = isset($data[0]->totalrows)?$data[0]->totalrows:0;
		//print_r($afiliacion);exit();

		$result["PageStart"] = $request->NumeroPagina;
		$result["pageSize"] = $request->NumeroRegistros;
		$result["SearchText"] = "";
		$result["ShowChildren"] = true;
		$result["iTotalRecords"] = $iTotalDisplayRecords;
		$result["iTotalDisplayRecords"] = $iTotalDisplayRecords;
		$result["aaData"] = $data;

		echo json_encode($result);

	}

    public function modal_factura($id){
		$id_user = Auth::user()->id;
		$factura = new comprobante;
		$negativo = "";
		if($id>0){
			$factura = comprobante::find($id);
			//$negativo = Negativo::where('factura_id',$id)->orderBy('id', 'desc')->first();
		} else {
			$factura = new comprobante;
		}
        //print ("hola");exit();
		return view('frontend.factura.modal_factura',compact('id','factura','negativo'));
	}
    
    public function nc_edit($id, $id_caja){

        $trans = "I";
       
        
		if($id_caja==""){
			$valorizaciones_model = new Valorizacione;
			$id_user = Auth::user()->id;
			$caja_usuario = $valorizaciones_model->getCajaIngresoByusuario($id_user,'91');
			//$id_caja = $caja_usuario->id_caja;
			$id_caja = (isset($caja_usuario->id_caja))?$caja_usuario->id_caja:0;
		}
       
      

        $comprobante_model=new Comprobante;
        $comprobante=$comprobante_model->getComprobanteById($id);
       

        $empresa_model = new Empresa;
        $serie_model = new TablaMaestra;

		$tabla_model = new TablaMaestra;
		$forma_pago = $tabla_model->getMaestroByTipo('19');
        $tipooperacion = $tabla_model->getMaestroByTipo('103');
        $formapago = $tabla_model->getMaestroByTipo('104');


        return view('frontend.comprobante.create_nc',compact('trans', 'comprobante','tipooperacion'));
        

    }

    public function nc_edita(Request $request){

        //echo("hola");
		echo $request->id_comprobante;
		exit();

        $id_caja = $request->id_caja_;
        $id = $request->id_comprobante_;

        $trans = "I";
       
        
		if($id_caja==""){
			$valorizaciones_model = new Valorizacione;
			$id_user = Auth::user()->id;
			$caja_usuario = $valorizaciones_model->getCajaIngresoByusuario($id_user,'91');
			//$id_caja = $caja_usuario->id_caja;
			$id_caja = (isset($caja_usuario->id_caja))?$caja_usuario->id_caja:0;
		}
       
      

        $comprobante_model=new Comprobante;
        $comprobante=$comprobante_model->getComprobanteById($id);
       

        $empresa_model = new Empresa;
        $serie_model = new TablaMaestra;

		$tabla_model = new TablaMaestra;
		$forma_pago = $tabla_model->getMaestroByTipo('19');
        $tipooperacion = $tabla_model->getMaestroByTipo('103');
        $formapago = $tabla_model->getMaestroByTipo('104');


        return view('frontend.comprobante.create_nc',compact('trans', 'comprobante','tipooperacion'));
        

    }
	
}
