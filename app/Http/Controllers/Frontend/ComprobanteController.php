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

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

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
        $descuentopp=$request->DescuentoPP;

        $totalDescuento=$request->totalDescuento;

        $id_tipo_afectacion_pp=$request->id_tipo_afectacion_pp;
        
        
        //print_r($id_tipo_afectacion_pp); exit();

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

            if ($id_tipo_afectacion_pp=="30"){
                $stotal = $total;
                $igv   = 0;
            }
            else{
                $stotal = $total/1.18;
                $igv   = $stotal * 0.18;
            }

            //exit($igv);

            $factura_detalle = $request->comprobante_detalle;

            //$factura_detalle->id_modulo = 3;

           // print_r($request->comprobante_detalles);exit();
           
            $ind = 0;
            foreach($request->comprobante_detalles as $key=>$det){
                $facturad[$ind] = $factura_detalle[$key];
                $ind++;
            }
            //print_r($facturad);exit();


            if ($descuentopp=="S"){
                $items1 = array(
                    "chek" => 1, 
                    "id" => 0, 
                    "fecha" => "20/02/2024", 
                    "denominacion" => "DESCUENTO CUOTA GREMIAL PRONTOPAGO",
                    "monto" => $request->totalDescuento*-1,
                    "pu" => $request->totalDescuento*-1, 
                    "igv" => 0, 
                    "pv" => 0, 
                    "total" => $request->totalDescuento*-1, 
                    "moneda" => "SOLES", 
                    "id_moneda" => 1, 
                    "abreviatura" => "SOLES", 
                    "cantidad" => 1, 
                    "descuento" => $request->totalDescuento,
                    "cod_contable" =>"", 
                    "descripcion" => 'DESCUENTO CUOTA GREMIAL PRONTOPAGO', 
                    "vencio" => 0, 
                    "id_concepto" => $request->id_concepto_pp,
                    "item" => 0, 
                    );
                    $facturad[$ind]=$items1;
            }

             //print_r($facturad);exit();


            $ubicacion = $request->id_ubicacion;
            $persona = $request->id_persona;
            $tipoDocP = $request->tipo_documento;
			$empresa_id = $request->empresa_id;
           // echo $$tipoDocP;exit();

			// DNI = 78

            if($tipoDocP == "78" && $TipoF == 'FT'){
                //$ubicacion = $request->id_ubicacion_p;
                $empresa_id = $request->empresa_id;

                //echo $ubicacion;exit();
            }

            //echo "persona:".$persona." ubicacion".$ubicacion; exit();
			//echo $ubicacion; exit();
			
			//if($ubicacion=="")$ubicacion=3070;
            if ($TipoF == 'BV' || $TipoF == 'TK'){

                //echo $persona;exit();

                $empresa = $empresa_model->getPersonaId_BV($persona);

				if(!$empresa){
					//echo $ubicacion;exit();
					$empresa = $empresa_model->getEmpresaId($ubicacion);
				}

            }
            else{
                //echo $ubicacion;exit();
                if ($tipoDocP == "79"){
                    $empresa = $empresa_model->getEmpresaId($ubicacion);
                }
                else{
                    $empresa = $empresa_model->getPersonaId($persona);
                }
                
            }
          

            return view('frontend.comprobante.create',compact('trans', 'titulo','empresa', 'facturad', 'total', 'igv', 'stotal','TipoF','ubicacion', 'persona','id_caja','serie', 'adelanto','MonAd','forma_pago','tipooperacion','formapago', 'totalDescuento','id_tipo_afectacion_pp'));
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
                'serie' => $facturas->fac_serie,
                'numero' => $facturas->fac_numero,
                'tipo' => $facturas->fac_tipo
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
                'serie' => $facturas->fac_serie,
                'numero' => $facturas->fac_numero,
                'tipo' => $facturas->fac_tipo
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

        $id_tipo_afectacion_pp = $request->id_tipo_afectacion_pp;
         

		//$facturaExiste = $facturas_model->getValidaFactura($request->TipoF,$request->ubicacion,$request->persona,$request->totalF);
		//if(count($facturaExiste)==0){

			/**********RUC***********/

			$tarifa = $request->facturad;

		  // print_r($tarifa); exit();

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
				
                //print_r($serieF); exit();

                if($ubicacion_id=="")$ubicacion_id=$id_persona;

                

                $descuento =  $request->totalDescuento; 
                if ($request->totalDescuento=='') $descuento = 0;

				$id_factura = $facturas_model->registrar_factura_moneda($serieF,     $id_tipo_afectacion_pp, $tipoF, $ubicacion_id, $id_persona, $total,          '',           '',    0, $id_caja,          $descuento,    'f',     $id_user,  $id_moneda);
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
					
					$serie="T001";$numero="0";$tipo="GR";$serie_relacionado="";$num_relacionado="";$tipo_relacionado="";$serie_baja="";$num_baja="";$tipo_baja="";$emisor_numdoc="20160453908";$emisor_tipodoc="0";$emisor_razsocial="CAP - Lima SRLTDA";$receptor_numdoc=$factura->fac_cod_tributario;$receptor_tipodoc="0";$receptor_razsocial=$factura->fac_destinatario;$tercero_numdoc="";$tercero_tipodoc="";$tercero_razsocial="";$cod_motivo="";$desc_motivo="";$transbordo="";$peso_bruto=($ingreso->peso_a_cobrar/1000);$bultos="";$modo_traslado="";$fecha_traslado=$factura->fac_fecha;$transportista_numdoc="";$transportista_tipo_doc="";$transportista_razsoc="";$vehiculo_placa=$ingreso->placa;$conductor_numdoc="";$conductor_tipodoc="";$llegada_ubigeo="";$llegada_direccion=$request->guia_llegada_direccion;$partida_ubigeo="";$partida_direccion="AV. NESTOR GAMBETA Nº 6311 - CALLAO";$numero_contenedor="";$puerto_desembarque="";$observaciones="";$ruta_comprobante="";$email="";$estado_email="";$estado_sunat="";$anulado="N";$orden_item="0";$codigo="";$descripcion="";$cantidad="0";$unid_medida="";$accion="";
					
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

    public function send_nc(Request $request)
    {
         //print_r($request); exit();
        $sw = true;
		$msg = "";

		$id_user = Auth::user()->id;
        $facturas_model = new Comprobante;
		$guia_model = new Guia;

			/**********RUC***********/

			$tarifa = $request->facturad;

			$total = $request->totalF;
			$serieF = $request->serieF;
			$tipoF = $request->tipoF;
			$ubicacion_id = $request->ubicacion;
			$cod_tributario = $request->numero_documento;
			$id_caja = $request->id_caja;
			$adelanto   = $request->adelanto;

			$trans = $request->trans;
            
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
               
				
				$id_moneda=1;

                $descuento = $value['descuento'];
		
				$id_factura = $facturas_model->registrar_comprobante($serieF,     0, $tipoF,  $cod_tributario, $total,          '',           '',    0, $id_caja,          0,    'f',     $id_user,  1);
               // print_r($id_factura); exit();					       //(serie,  numero,   tipo,     ubicacion,     persona,  total, descripcion, cod_contable, id_v,   id_caja, descuento, accion, p_id_usuario, p_id_moneda)
              
				$factura = Comprobante::where('id', $id_factura)->get()[0];

				$fac_serie = $factura->serie;
				$fac_numero = $factura->numero;

				$factura_upd = Comprobante::find($id_factura);
				if(isset($factura_upd->tipo_cambio)) $factura_upd->tipo_cambio = $request->tipo_cambio;
                
				$factura_upd->save();

				//print_r($tarifa); exit();
				foreach ($tarifa as $key => $value) {
					//echo "denominacion=>".$value['denominacion']."<br>";
					if ($adelanto == 'S'){
						$total   = $request->MonAd;
					}
					else{
						//$total   = $value['monto'];
                        $total   ="1";
					}
					$descuento = $value['descuento'];
					if ($value['descuento']=='') $descuento = 0;
					$id_factura_detalle = $facturas_model->registrar_comprobante($serieF, $fac_numero, $tipoF, $value['item'], $total, $value['descripcion'], "", $value['id'], $id_factura, $descuento,    'd',     $id_user,  $id_moneda);
																				 //(  serie,      numero,   tipo,      ubicacion, persona,  total,            descripcion,           cod_contable,         id_v,     id_caja,  descuento, accion, p_id_usuario, p_id_moneda)
					
				
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
    
    

    public function nc_edita(Request $request){

        $id_caja = $request->id_caja_;
        $id = $request->id_comprobante;
        $id_nc = $request->id_comprobante_nc;
        $tipoF="NC";

        if ($id=="" ){
            $trans = "FE";
        }
        else{
            $trans = "FN";
        }
        
        
		if($id_caja==""){
			$valorizaciones_model = new Valorizacione;
			$id_user = Auth::user()->id;
			$caja_usuario = $valorizaciones_model->getCajaIngresoByusuario($id_user,'91');
			//$id_caja = $caja_usuario->id_caja;
			$id_caja = (isset($caja_usuario->id_caja))?$caja_usuario->id_caja:0;
		}
       
      
        if ( $trans == "FN"){
            $comprobante_model=new Comprobante;
            $comprobante=$comprobante_model->getComprobanteById($id);

            $facturad = ComprobanteDetalle::where([
                'serie' => $comprobante->serie,
                'numero' => $comprobante->numero,
                'tipo' => $comprobante->tipo
            ])->get();

           // print_r($facturad);
            //exit();
        }
        else {
            $comprobante_model=new Comprobante;
            $comprobante=$comprobante_model->getComprobanteById($id_nc);

            $facturad = ComprobanteDetalle::where([
                'serie' => $comprobante->serie,
                'numero' => $comprobante->numero,
                'tipo' => $comprobante->tipo
            ])->get();
        }
        
        $empresa_model = new Empresa;
        $serie_model = new TablaMaestra;

		$tabla_model = new TablaMaestra;
		$forma_pago = $tabla_model->getMaestroByTipo('19');
        $tipooperacion = $tabla_model->getMaestroByTipo('51');
        $formapago = $tabla_model->getMaestroByTipo('104');

        $serie = $serie_model->getMaestro('95');
        //print_r($tipoF); exit();

        return view('frontend.comprobante.create_nc',compact('trans', 'comprobante','tipooperacion','serie','facturad','tipoF','id_caja'));
        
    }

    public function nd_edita(Request $request){

        $id_caja = $request->id_caja_;
        $id = $request->id_comprobante;
        $id_nc = $request->id_comprobante_nc;

        if ($id=="" ){
            $trans = "FE";
        }
        else{
            $trans = "FN";
        }
        
        
		if($id_caja==""){
			$valorizaciones_model = new Valorizacione;
			$id_user = Auth::user()->id;
			$caja_usuario = $valorizaciones_model->getCajaIngresoByusuario($id_user,'91');
			//$id_caja = $caja_usuario->id_caja;
			$id_caja = (isset($caja_usuario->id_caja))?$caja_usuario->id_caja:0;
		}
       
      
        if ( $trans == "FN"){
            $comprobante_model=new Comprobante;
            $comprobante=$comprobante_model->getComprobanteById($id);

            $facturad = ComprobanteDetalle::where([
                'serie' => $comprobante->serie,
                'numero' => $comprobante->numero,
                'tipo' => $comprobante->tipo
            ])->get();

           // print_r($facturad);
            //exit();
        }
        else {
            $comprobante_model=new Comprobante;
            $comprobante=$comprobante_model->getComprobanteById($id_nc);

            $facturad = ComprobanteDetalle::where([
                'serie' => $comprobante->serie,
                'numero' => $comprobante->numero,
                'tipo' => $comprobante->tipo
            ])->get();
        }

        $empresa_model = new Empresa;
        $serie_model = new TablaMaestra;

		$tabla_model = new TablaMaestra;
		$forma_pago = $tabla_model->getMaestroByTipo('19');
        $tipooperacion = $tabla_model->getMaestroByTipo('103');
        $formapago = $tabla_model->getMaestroByTipo('104');

        $serie = $serie_model->getMaestro('95');


        return view('frontend.comprobante.create_nd',compact('trans', 'comprobante','tipooperacion','serie','facturad'));
        

    }

    public function envio_factura_sunat_automatico($fecha){

        $factura_model = new Comprobante;
        //$fecha = str_replace("-","/",$fecha);
        $facturas = $factura_model->get_envio_pendiente_factura_sunat($fecha);

        $log = ['Fecha Factura' => $fecha,
        'description' => 'Fecha de envio de las facturas automaticas'];

        //first parameter passed to Monolog\Logger sets the logging channel name
        $facturaLog = new Logger('factura_sunat');
        $facturaLog->pushHandler(new StreamHandler(storage_path('logs/factura_sunat.log')), Logger::INFO);
        $facturaLog->info('FacturaLog', $log);

		foreach($facturas as $row){
			//echo $row->id."<br>";
			$this->firmar($row->id);

            $log = ['Id Factura firmada' => $row->id,
            'description' => 'Id de la factura automatica'];

            $facturaLog->pushHandler(new StreamHandler(storage_path('logs/factura_sunat.log')), Logger::INFO);
            $facturaLog->info('FacturaLog', $log);
		}
    }
	
    public function firmar($id_factura){

        //echo $this->getTipoDocumento("BV");exit();

		$factura = Comprobante::where('id', $id_factura)->get()[0];
		$factura_detalles = ComprobanteDetalle::where([
            'serie' => $factura->serie,
            'numero' => $factura->numero,
            'tipo' => $factura->tipo
        ])->get();
		//print_r($factura); exit();
        //print_r($factura_detalles); exit();		
		$cabecera = array("valor1","valor2");
		$detalle = array("valor1","valor2");
		foreach($factura_detalles as $index => $row ) {
			$items1 = array(
							"ordenItem"=> $row->item, //"2",
							"adicionales"=> [],
							"cantidadItem"=> $row->cantidad, //"1",
							"descuentoItem"=> $row->descuento,
							"importeIGVItem"=> str_replace(",","",number_format($row->igv_total,2)),//"7.63",
							"montoTotalItem"=> str_replace(",","",number_format($row->importe,2)), //"50.00",
							"valorVentaItem"=> str_replace(",","",number_format($row->pu,2)), //"42.37",
							"descripcionItem"=> $row->descripcion,//"TRANSBORDO",
							"unidadMedidaItem"=> $row->unidad,
							"codigoProductoItem"=> ($row->cod_contable!="")?$row->cod_contable:"0000000", //"002",
							"valorUnitarioSinIgv"=> str_replace(",","",number_format($row->pu_con_igv,2)), //"42.3728813559",
							"precioUnitarioConIgv"=> str_replace(",","",number_format($row->importe,2)), //"50.0000000000",
							"unidadMedidaComercial"=> "SERV",
							"codigoAfectacionIGVItem"=> "10",
							"porcentajeDescuentoItem"=> "0.00",
							"codTipoPrecioVtaUnitarioItem"=> "01"
							);
			$items[$index]=$items1;
        }
 
		$data["items"] = $items;
		$data["anulado"] = false;
		$data["declare"] = "0"; // 0->dechlare 1>declare instante
		$data["version"] = "2.1";
		$data["adjuntos"] = [];
		$data["anticipos"] = [];
		$data["esFicticio"] = false;
		$data["keepNumber"] = "false";
		$data["tipoCorreo"] = "1";
        $data["formaPago"] = "CONTADO";
		$data["tipoMoneda"] = ($factura->id_moneda=="2")?"PEN":"USD"; //"PEN";
		$data["adicionales"] = [];
		$data["horaEmision"] = date("h:i:s", strtotime($factura->fecha)); // "12:12:04";//$cabecera->fecha
		$data["serieNumero"] = $factura->serie."-".$factura->numero; // "F001-000002";
		$data["fechaEmision"] = date("Y-m-d",strtotime($factura->fecha)); //"2021-03-18";
		$data["importeTotal"] = str_replace(",","",number_format($factura->total,2)); //"150.00";
		$data["notification"] = "1";
		$data["sumatoriaIGV"] = str_replace(",","",number_format($factura->impuesto,2)); //"22.88";
		$data["sumatoriaISC"] = "0.00";
		$data["ubigeoEmisor"] = "150139";
		$data["montoEnLetras"] = $factura->letras; //"CIENTO CINCUENTA Y 00/100";
		$data["tipoDocumento"] = $this->getTipoDocumento($factura->tipo);
		$data["correoReceptor"] = $factura->correo_des; //"frimacc@gmail.com";
		$data["distritoEmisor"] = "LIMA";
		$data["esContingencia"] = false;
		$data["telefonoEmisor"] = "511 4710739";
		$data["totalAnticipos"] = "0.00";
		$data["direccionEmisor"] = "AV. SAN FELIPE NRO. 999 LIMA - LIMA - JESUS MARIA ";
		$data["provinciaEmisor"] = "LIMA";
		$data["totalDescuentos"] = "0.00";
		$data["totalOPGravadas"] = str_replace(",","",number_format($factura->subtotal,2)); //"127.12";
		$data["codigoPaisEmisor"] = "PE";
		$data["totalOPGratuitas"] = "0.00";
		$data["docAfectadoFisico"] = false;
		$data["importeTotalVenta"] = str_replace(",","",number_format($factura->total,2)); //"150.00";
		$data["razonSocialEmisor"] = "COLEGIO DE ARQUITECTOS DEL PERU-REGIONAL LIMA";
		$data["totalOPExoneradas"] = "0.00";
		$data["totalOPNoGravadas"] = "0.00";
		$data["codigoPaisReceptor"] = "PE";
		$data["departamentoEmisor"] = "JESUS MARIA";
		$data["descuentosGlobales"] = "0.00";
		$data["codigoTipoOperacion"] = "0101";
		$data["razonSocialReceptor"] = $factura->destinatario;//"Freddy Rimac Coral";
		$data["nombreComercialEmisor"] = "CAP";
		$data["tipoDocIdentidadEmisor"] = "6";
		$data["sumatoriaImpuestoBolsas"] = "0.00";
		$data["numeroDocIdentidadEmisor"] = "20160453908";//"20160453908";
		$data["tipoDocIdentidadReceptor"] = $this->getTipoDocPersona($factura->tipo, $factura->cod_tributario);//"6";
		$data["numeroDocIdentidadReceptor"] = $factura->cod_tributario; //"10040834643";
        $data["direccionReceptor"] = $factura->direccion;

        //print_r($data); exit();


		$databuild_string = json_encode($data);
        //print_r($databuild_string);exit();

		//$chbuild = curl_init("https://easyfact.tk/see/rest/01");
        $chbuild = curl_init(config('values.ws_fac_host')."/see/rest/".$this->getTipoDocumento($factura->tipo));
        //echo config('values.ws_fac_host')."/see/rest/".$this->getTipoDocumento($factura->tipo);exit();

		$username = config('values.ws_fac_user');
		$password = config('values.ws_fac_clave');

        curl_setopt($chbuild, CURLOPT_HEADER, true);
        curl_setopt($chbuild, CURLOPT_HTTPHEADER, array(
            'Accept: application/json',
            'Content-Type: application/json',
			'Authorization: Basic '. base64_encode("$username:$password")
			)
        );
        curl_setopt($chbuild, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($chbuild, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($chbuild, CURLOPT_POSTFIELDS, $databuild_string);
        $results = curl_exec($chbuild);
        //print_r($results);
        //exit();
        $facturaLog = new Logger('factura_sunat');

        $log = ['Resultados' => $results,
        'description' => 'Resultados devueltos'];
        //first parameter passed to Monolog\Logger sets the logging channel name
        $facturaLog->pushHandler(new StreamHandler(storage_path('logs/factura_sunat.log')), Logger::INFO);
        $facturaLog->info('FacturaLog', $log);

		if (curl_errno($chbuild)) {
			$error_msg = curl_error($chbuild);
			echo $error_msg;

            $log = ['Error' => $error_msg,
            'description' => 'Errores'];
            //first parameter passed to Monolog\Logger sets the logging channel name
            $facturaLog->pushHandler(new StreamHandler(storage_path('logs/factura_sunat.log')), Logger::WARNING);
            $facturaLog->info('FacturaLog', $log);
		}
		//print_r($results); exit();
        curl_close($chbuild);

        
		//$results = substr($results,strpos($results,'{'),strlen($results));
        $results = substr($results,strpos($results,'{'),strlen($results));
        $respbuild = json_decode($results, true);
		//echo "<br>";
		//print_r($respbuild); exit();
            
        $body = $respbuild["body"];
            
        if(count($body)>0){
            //print_r($body);
            //echo "******<br>";
            $single = $body["single"];
            //print_r($single);
            //echo "********<br>";
            $id = $single["id"];
            $_number = $single["_number"];
            $result = $single["result"];
            $hash = $single[ "hash"];
            //$signature = $single["signature"];

            if($result == "FIRMADO"){

                $fecha = $factura->fecha;
                //echo $fecha;

                //$fecha = "2021-03-24";
                //$porciones = explode("/", $fecha);
                $dia = substr($fecha, 8, 2); //$porciones[2];
                $mes = substr($fecha, 5, 2); //$porciones[1];
                $anio = substr($fecha, 0, 4);
                //$anio = $fecha; //$porciones[0];




                $fac_ruta_comprobante = config('values.ws_fac_host')."/see/server/consult/pdf?nde=20160453908&td=" .$this->getTipoDocumento($factura->tipo) ."&se=" .$factura->serie. "&nu=" .$factura->numero. "&fe=".date("Y-m-d",strtotime($factura->fecha))."&am=" .$factura->total;
                //$fac_ruta_comprobante = config('values.ws_fac_host')."/see/server/consult/pdf?nde=20601973759&td=" .$this->getTipoDocumento($factura->tipo) ."&se=" .$factura->serie. "&nu=" .$factura->numero. "&fe=".date("Y-m-d",strtotime($factura->fecha))."&am=" .$factura->total;

                if (
					//test.easyfact.tk
                    $this->download_pdf(config('values.ws_fac_dominio'), $fac_ruta_comprobante, $this->getTipoDocumento($factura->tipo)."_".$factura->serie."_".$factura->numero."_".$anio.$mes.$dia.".pdf") =="OK"
                    ) {
                    // Guardar nombre del pdf en la base de datos.
                    $factura = Comprobante::find($id_factura);
                    $factura->estado_sunat = "FIRMADO";
                    // Nueva ruta del PDF descargado
                    //$factura->fac_ruta_comprobante = "storage/factura_".$data["serieNumero"].".pdf";
                    $factura->ruta_comprobante = "storage/".$this->getTipoDocumento($factura->tipo)."_".$factura->serie."_".$factura->numero."_".$anio.$mes.$dia.".pdf";
                    $factura->save();

                }
            }
        }

        //$respbuild->result;

    }

    public function download_pdf($host_name, $input_url, $output_filename) {

        // Create a stream
        $opts = [
            "http" => [
                "method" => "GET",
                "header" => "Host: $host_name\r\n"
                    . "User-Agent: Mozilla/5.0 (X11; Linux x86_64; rv:71.0) Gecko/20100101 Firefox/71.0\r\n"
                    . "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8\r\n"
                    . "Accept-Language: en-US,en;q=0.5\r\n"
                    . "Accept-Encoding: gzip, deflate, br\r\n"
            ],
        ];

        $context = stream_context_create($opts);
        $data = file_get_contents($input_url, false, $context);

        \Storage::disk('public')->put($output_filename, $data);

        return 'OK';
     }
    
    public function getTipoDocumento($fac_tipo){
        $codigo_fac_tipo = "";
        switch ($fac_tipo) {
            case "FT":
                $codigo_fac_tipo = "01";
            break;
            case "BV":
                $codigo_fac_tipo = "03";
            break;
            case "NC":
                $codigo_fac_tipo = "07";
            break;
            case "ND":
                $codigo_fac_tipo = "08";
            break;
            default:
            $codigo_fac_tipo = "";
        }

        return $codigo_fac_tipo;

    }

    public function getTipoDocPersona($td, $dni){

        $tipoDoc = "";

        if ($td == 'FT'){
            $tipoDoc = "6";
        }
        else{
            if ($dni=='-'){
                $tipoDoc = "0";
            }
            else{
                $persona= Persona::where('numero_documento', $dni)->get()[0];
                $tipoDocB = $persona->tipo_documento;
                switch ($tipoDocB) {
                    case "DNI":
                        $tipoDoc = "1";
                    break;
                    case "CARNET_EXTRANJERIA":
                        $tipoDoc = "4";
                    break;

                    case "PASAPORTE":
                        $tipoDoc = "7";
                    break;

                    case "CEDULA":
                        $tipoDoc = "A";
                    break;

                    case "PTP/PTEP":
                        $tipoDoc = "B";
                    break;

                    // incluir un codigo para el nuevo tipo CPP/CSR
                    case "CPP/CSR":
                        $tipoDoc = "F";
                    break;

                    default:
                    $tipoDoc = "0";

                }
            }
        }
        return $tipoDoc;
    }

    public function firmarNC($id_factura){

        //echo $this->getTipoDocumento("BV");exit();

		$factura = Comprobante::where('id', $id_factura)->get()[0];
		$factura_detalles = ComprobanteDetalle::where([
            'serie' => $factura->serie,
            'numero' => $factura->numero,
            'tipo' => $factura->tipo
        ])->get();
		//print_r($factura); exit();
        //print_r($factura_detalles); exit();		
		$cabecera = array("valor1","valor2");
		$detalle = array("valor1","valor2");
		foreach($factura_detalles as $index => $row ) {
			$items1 = array(
							"ordenItem"=> $row->item, //"2",
							"adicionales"=> [],
							"cantidadItem"=> $row->cantidad, //"1",
							//"descuentoItem"=> $row->descuento,
							"importeIGVItem"=> str_replace(",","",number_format($row->igv_total,2)),//"7.63",
							"montoTotalItem"=> str_replace(",","",number_format($row->importe,2)), //"50.00",
							"valorVentaItem"=> str_replace(",","",number_format($row->pu,2)), //"42.37",
							"descripcionItem"=> $row->descripcion,//"TRANSBORDO",
							"unidadMedidaItem"=> $row->unidad,
							//"codigoProductoItem"=> ($row->cod_contable!="")?$row->cod_contable:"0000000", //"002",
							"valorUnitarioSinIgv"=> str_replace(",","",number_format($row->pu_con_igv,2)), //"42.3728813559",
							"precioUnitarioConIgv"=> str_replace(",","",number_format($row->importe,2)), //"50.0000000000",
							"unidadMedidaComercial"=> "SERV",
							"codigoAfectacionIGVItem"=> "10",
							//"porcentajeDescuentoItem"=> "0.00",
							"codTipoPrecioVtaUnitarioItem"=> "01"
							);
			$items[$index]=$items1;
        }

        $items2 = array(
            "serie"=>$factura->serie,
            "numero"=> $factura->numero,
            "idEmpresa"=> 1034,
            "idUsuario"=> 2564,
            "noValidar"=> false,
            "idPuntoventa"=> 1700,
            "idListaPrecio"=> 0,
            "enviarAdjuntoDescomprimido"=> false
        );
        $items2[$index]=$items2;
 
		$data["items"] = $items;
        $data["server"] = $items2;

		$data["anulado"] = false;
		$data["declare"] = "0"; // 0->dechlare 1>declare instante
		$data["version"] = "2.1";
		$data["adjuntos"] = [];
		//$data["anticipos"] = [];
		$data["esFicticio"] = false;
		$data["keepNumber"] = "false";
		$data["tipoCorreo"] = "1";
       // $data["formaPago"] = "CONTADO";
		$data["tipoMoneda"] = ($factura->id_moneda=="2")?"PEN":"USD"; //"PEN";
		$data["adicionales"] = [];
		$data["horaEmision"] = date("h:i:s", strtotime($factura->fecha)); // "12:12:04";//$cabecera->fecha
		$data["serieNumero"] = $factura->serie."-".$factura->numero; // "F001-000002";
		$data["fechaEmision"] = date("Y-m-d",strtotime($factura->fecha)); //"2021-03-18";
		$data["importeTotal"] = str_replace(",","",number_format($factura->total,2)); //"150.00";
		$data["notification"] = "1";
		$data["sumatoriaIGV"] = str_replace(",","",number_format($factura->impuesto,2)); //"22.88";
		$data["sumatoriaISC"] = "0.00";
		$data["ubigeoEmisor"] = "150139";
        $data["creditoCuotas"] = [];
		//$data["montoEnLetras"] = $factura->letras; //"CIENTO CINCUENTA Y 00/100";
		$data["tipoDocumento"] = $this->getTipoDocumento($factura->tipo);
		$data["correoReceptor"] = $factura->correo_des; //"frimacc@gmail.com";
		$data["distritoEmisor"] = "LIMA";
		$data["esContingencia"] = false;
        $data["motivoSustento"] = "DESCUENTO GLOBAL";
		//$data["telefonoEmisor"] = "511 4710739";
		$data["totalAnticipos"] = "0.00";
		$data["direccionEmisor"] = "AV. SAN FELIPE NRO. 999 LIMA - LIMA - JESUS MARIA ";
		$data["provinciaEmisor"] = "LIMA";
        $data["tipoNotaCredito"] = "04";
		$data["totalDescuentos"] = "0.00";
		$data["totalOPGravadas"] = str_replace(",","",number_format($factura->subtotal,2)); //"127.12";
		$data["codigoPaisEmisor"] = "PE";
		$data["totalOPGratuitas"] = "0.00";
        $data["direccionReceptor"] = "AV. SAN FELIPE NRO. 999 LIMA - LIMA - JESUS MARIA ";
		$data["docAfectadoFisico"] = false;
		//$data["importeTotalVenta"] = str_replace(",","",number_format($factura->total,2)); //"150.00";
		$data["razonSocialEmisor"] = "COLEGIO DE ARQUITECTOS DEL PERU-REGIONAL LIMA";
		$data["totalOPExoneradas"] = "0.00";
		$data["totalOPNoGravadas"] = "0.00";
		$data["codigoPaisReceptor"] = "PE";
		$data["departamentoEmisor"] = "JESUS MARIA";
		//$data["descuentosGlobales"] = "0.00";
		//$data["codigoTipoOperacion"] = "0101";
		$data["razonSocialReceptor"] = $factura->destinatario;//"Freddy Rimac Coral";
        $data["serieNumeroAfectado"] = $factura->serie."-".$factura->numero;
        $data["serieNumeroModifica"] = $factura->serie."-".$factura->numero;

        $data["sumatoriaOtrosCargos"] = "0";

		//$data["nombreComercialEmisor"] = "CAP";		       
        $data["nombreComercialEmisor"] = "COLEGIO DE ARQUITECTOS DEL PERU-REGIONAL LIMA";
        $data["tipoDocumentoModifica"] = "01";
        $data["fechaDocumentoAfectado"] = "2023-11-13";
        $data["tipoDocIdentidadEmisor"] = "6";
		$data["sumatoriaImpuestoBolsas"] = "0.00";
		$data["numeroDocIdentidadEmisor"] = "20160453908";//"20160453908";        
		$data["tipoDocIdentidadReceptor"] = $this->getTipoDocPersona($factura->tipo, $factura->cod_tributario);//"6";        
		$data["numeroDocIdentidadReceptor"] = $factura->cod_tributario; //"10040834643";

        //$data["direccionReceptor"] = $factura->direccion;

        //print_r($data); exit();


		$databuild_string = json_encode($data);
        //print_r($databuild_string);exit();

		//$chbuild = curl_init("https://easyfact.tk/see/rest/01");
        $chbuild = curl_init(config('values.ws_fac_host')."/see/rest/".$this->getTipoDocumento($factura->tipo));
        //echo config('values.ws_fac_host')."/see/rest/".$this->getTipoDocumento($factura->tipo);exit();

		$username = config('values.ws_fac_user');
		$password = config('values.ws_fac_clave');

        curl_setopt($chbuild, CURLOPT_HEADER, true);
        curl_setopt($chbuild, CURLOPT_HTTPHEADER, array(
            'Accept: application/json',
            'Content-Type: application/json',
			'Authorization: Basic '. base64_encode("$username:$password")
			)
        );
        curl_setopt($chbuild, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($chbuild, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($chbuild, CURLOPT_POSTFIELDS, $databuild_string);
        $results = curl_exec($chbuild);
        //print_r($results);
        //exit();
        $facturaLog = new Logger('factura_sunat');

        $log = ['Resultados' => $results,
        'description' => 'Resultados devueltos'];
        //first parameter passed to Monolog\Logger sets the logging channel name
        $facturaLog->pushHandler(new StreamHandler(storage_path('logs/factura_sunat.log')), Logger::INFO);
        $facturaLog->info('FacturaLog', $log);

		if (curl_errno($chbuild)) {
			$error_msg = curl_error($chbuild);
			echo $error_msg;

            $log = ['Error' => $error_msg,
            'description' => 'Errores'];
            //first parameter passed to Monolog\Logger sets the logging channel name
            $facturaLog->pushHandler(new StreamHandler(storage_path('logs/factura_sunat.log')), Logger::WARNING);
            $facturaLog->info('FacturaLog', $log);
		}
		//print_r($results); exit();
        curl_close($chbuild);

        
		//$results = substr($results,strpos($results,'{'),strlen($results));
        $results = substr($results,strpos($results,'{'),strlen($results));
        $respbuild = json_decode($results, true);
		//echo "<br>";
		//print_r($respbuild); exit();
            
        $body = $respbuild["body"];
            
        if(count($body)>0){
            //print_r($body);
            //echo "******<br>";
            $single = $body["single"];
            //print_r($single);
            //echo "********<br>";
            $id = $single["id"];
            $_number = $single["_number"];
            $result = $single["result"];
            $hash = $single[ "hash"];
            //$signature = $single["signature"];

            if($result == "FIRMADO"){

                $fecha = $factura->fecha;
                //echo $fecha;

                //$fecha = "2021-03-24";
                //$porciones = explode("/", $fecha);
                $dia = substr($fecha, 8, 2); //$porciones[2];
                $mes = substr($fecha, 5, 2); //$porciones[1];
                $anio = substr($fecha, 0, 4);
                //$anio = $fecha; //$porciones[0];




                $fac_ruta_comprobante = config('values.ws_fac_host')."/see/server/consult/pdf?nde=20160453908&td=" .$this->getTipoDocumento($factura->tipo) ."&se=" .$factura->serie. "&nu=" .$factura->numero. "&fe=".date("Y-m-d",strtotime($factura->fecha))."&am=" .$factura->total;
                //$fac_ruta_comprobante = config('values.ws_fac_host')."/see/server/consult/pdf?nde=20601973759&td=" .$this->getTipoDocumento($factura->tipo) ."&se=" .$factura->serie. "&nu=" .$factura->numero. "&fe=".date("Y-m-d",strtotime($factura->fecha))."&am=" .$factura->total;

                if (
					//test.easyfact.tk
                    $this->download_pdf(config('values.ws_fac_dominio'), $fac_ruta_comprobante, $this->getTipoDocumento($factura->tipo)."_".$factura->serie."_".$factura->numero."_".$anio.$mes.$dia.".pdf") =="OK"
                    ) {
                    // Guardar nombre del pdf en la base de datos.
                    $factura = Comprobante::find($id_factura);
                    $factura->estado_sunat = "FIRMADO";
                    // Nueva ruta del PDF descargado
                    //$factura->fac_ruta_comprobante = "storage/factura_".$data["serieNumero"].".pdf";
                    $factura->ruta_comprobante = "storage/".$this->getTipoDocumento($factura->tipo)."_".$factura->serie."_".$factura->numero."_".$anio.$mes.$dia.".pdf";
                    $factura->save();

                }
            }
        }

        //$respbuild->result;

    }
}
