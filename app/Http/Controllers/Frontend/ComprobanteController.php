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

use App\Models\Agremiado;
use App\Models\ComprobantePago;

use App\Models\ComprobanteCuotaPago;

use App\Models\ComprobanteCuota;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

use Illuminate\Support\Facades\Auth;

class ComprobanteController extends Controller
{
	public function index(){
        //$facturas_model = new Factura;
        //$facturas = $facturas_model->getFactura();
        //$facturas = Factura::where('fac_destinatario', 'like','%')->orderBy('id','desc')->get()->all();
        //print_r($facturas);
        $tabla_model = new TablaMaestra;

        $formapago = $tabla_model->getMaestroByTipo('104');

        return view('frontend.comprobante.all',compact('formapago'));
    }

    public function cuadre_caja(){
        //$facturas_model = new Factura;
        //$facturas = $facturas_model->getFactura();
        //$facturas = Factura::where('fac_destinatario', 'like','%')->orderBy('id','desc')->get()->all();
        //print_r($facturas);

      

        return view('frontend.comprobante.cuadre_caja');
    }



	public function edit(Request $request){

        $trans = $request->Trans;
        $id_caja=$request->id_caja;
        $descuentopp=$request->DescuentoPP;
        $id_pronto_pago=$request->id_pronto_pago;

        $totalDescuento=$request->totalDescuento;

        $id_tipo_afectacion_pp=$request->id_tipo_afectacion_pp;

        $email=$request->email;

        
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
		//$forma_pago = $tabla_model->getMaestroByTipo('19');
        $forma_pago = $tabla_model->getMaestroByTipo('108');
        $tipooperacion = $tabla_model->getMaestroByTipo('103');
        $formapago = $tabla_model->getMaestroByTipo('104');

        $medio_pago = $tabla_model->getMaestroByTipo('19');

        
        if ($trans == 'FA'){

            //$serie = $serie_model->getMaestro('SERIES',$TipoF);
            $serie = $serie_model->getMaestroC('95',$TipoF);            

            //$MonAd = $request->MonAd;
            $MonAd = 0;
            $total   = $request->total;
            $stotal   = $request->stotal;            
            $igv   = $request->igv;

           // print_r($igv);exit();


            $deudaTotal   = $request->deudaTotal; 

            

            $adelanto   = 'N';

            if ($MonAd != '0' && $total <> $MonAd){
                $total   = $MonAd;
                $adelanto   = 'S';
            }else{
                $MonAd = 0;
            }
            
           // echo "id_tipo_afectacion_pp=>".$id_tipo_afectacion_pp."<br>";
/*
            if ($id_tipo_afectacion_pp=="30"){
                $stotal = $total;
                $igv   = 0;
            }
            else{
                $stotal = $total/1.18;
                $igv   = $stotal * 0.18;
            }
*/
            //exit($igv);

            $factura_detalle = $request->comprobante_detalle;

            //$factura_detalle->id_modulo = 3;

         //   print_r($request->comprobante_detalles);
           
            $ind = 0;
            //$id_concepto_det=0;
            $id_concepto_pp = $request->id_concepto_pp;




            if ($descuentopp!="S"){

                //$stotal = 0;
                //$igv = 0;

                foreach($request->comprobante_detalles as $key=>$det){
                    $facturad[$ind] = $factura_detalle[$key];
                   
                    //print_r($factura_detalle['id_concepto']);
                    //$id_concepto_det = $facturad[$ind]['id_concepto'];
                    
                    //$stotal= $stotal + $facturad[$ind]['total'];
                    //$igv= $igv + $facturad[$ind]['igv'];

                    $ind++;
                }
            }

            $ind = 0;
            foreach($request->comprobante_detalles as $key=>$det){
                $valorizad[$ind] = $factura_detalle[$key];
                $ind++;
            }

            
           // print_r($valorizad);

            //print_r($id_concepto_pp);exit();

            //if ($id_concepto_det != $id_concepto_pp)$id_tipo_afectacion_pp="0";

            /*
            if ($descuentopp!="S"){
                $stotal = $total;
                $igv   = 0;
            }
*/

           
/*
            if ($id_tipo_afectacion_pp==$id_concepto_det){
                $stotal = $total;
                $igv   = 0;
            }
            else{
                $stotal = $total/1.18;
                $igv   = $stotal * 0.18;
            }
*/



            if ($descuentopp=="S"){
                $items1 = array(
                    "chek" => 1, 
                    "id" => 0, 
                    "fecha" => date('d/m/Y'), 
                    "denominacion" => "PAGO CUOTA GREMIAL - DESCUENTO CUOTA GREMIAL PRONTOPAGO",
                    "monto" => $stotal,
                    "pu" =>$deudaTotal, 
                    "igv" => $igv, 
                    "pv" =>  $total, 
                    "total" => $total, 
                    "moneda" => "SOLES", 
                    "id_moneda" => 1, 
                    "abreviatura" => "SOLES", 
                    "cantidad" => 1, 
                    "descuento" => $request->totalDescuento,
                    "cod_contable" =>"", 
                    "descripcion" => 'PAGO CUOTA GREMIAL - DESCUENTO CUOTA GREMIAL PRONTOPAGO', 
                    "vencio" => 0, 
                    "id_concepto" => $request->id_concepto_pp,
                    "item" => 1, 
                    );
                    $facturad[1]=$items1;

                    $ind = 0;
                    foreach($request->comprobante_detalles as $key=>$det){                    
                        $valorizad[$ind] = $factura_detalle[$key];    
                        $ind++;
                    }
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


                if($persona==''){
                    $persona=-1; 
                   // $empresa=-1;
                   // $ubicacion=-1;
                }



                     

                    $empresa = $empresa_model->getPersonaId_BV($persona);

                   //echo $empresa;exit();

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

            //echo $TipoF; exit();

          

            return view('frontend.comprobante.create',compact('trans', 'titulo','empresa', 'facturad', 'total', 'igv', 'stotal','TipoF','ubicacion', 'persona','id_caja','serie', 'adelanto','MonAd','forma_pago','tipooperacion','formapago', 'totalDescuento','id_tipo_afectacion_pp', 'valorizad','descuentopp','id_pronto_pago', 'medio_pago'));
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

        //echo $id_caja;exit();



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

           // $total_pagar_abono = $request->total_pagar_abono;

            //echo($total_pagar_abono); exit();
           
            /*
            $total_pagar = $request->total_pagar;
            $total = $request->totalF;
            $total_redondeo = $total_pagar - $total;
            $fecha_hoy = date('Y-m-d');

            if ($total_pagar!="0"){
                $items1 = array(
                    "id" => 1081517, 
                    "fecha" => $fecha_hoy,
                    "denominacion" => "REDONDEO",
                    "descripcion" => "REDONDEO",
                    "monto" => round($total_redondeo,2),
                    "moneda" => "SOLES" ,
                    "id_moneda" => 1 ,
                    "descuento" => 0 ,
                    "cod_contable" => "",
                    "id_concepto" => 26464 ,
                    "igv" => 0 ,
                    "cantidad" => 1, 
                    "total" => round($total_redondeo,2), 
                    "item" => 999 ,

                    );
                $tarifa[999]=$items1;
            }
           
		   print_r($tarifa); exit();

*/

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
            $ubicacion_id2 = $request->ubicacion2;
			$id_persona = $request->persona;
            $id_persona2 = $request->persona2;

            if ($id_persona=='') $id_persona = 0;
            if ($id_persona2=='') $id_persona2 = '0';

            if ($ubicacion_id2=='') $ubicacion_id2 = '0';

            //print_r($id_persona); exit();


			$id_caja = $request->id_caja;
			$adelanto   = $request->adelanto;

			$trans = $request->trans;

			//$std =  $this->getTipoDocPersona($id_persona );

			//print_r($std);
			//exit();

			//1	DOLARES
			//2	SOLES

            $id_concepto = 0;

			if ($trans == 'FA' || $trans == 'FN'){

				$ws_model = new TablaMaestra;
				
				/*************************************/
				$id_moneda=1;

				foreach ($tarifa as $key => $value) {
					//$vestab = $value['vestab'];
					//$vcodigo = $value['vcodigo'];
                    $id_val = $value['id'];
                    $id_concepto = $value['id_concepto'];

                    $id_moneda = $value['id_moneda'];

				}
				
                $ubicacion_id = $request->ubicacion;        
            $ubicacion_id2 = $request->ubicacion2;
			$id_persona = $request->persona;
            $id_persona2 = $request->persona2;

/*
            echo "ubicacion_id -> {$ubicacion_id}\n ";
            echo "id_persona -> {$id_persona}\n ";

            echo "ubicacion_id2 -> {$ubicacion_id2}\n ";
            echo "id_persona2 -> {$id_persona2}\n ";
            
            exit();

*/

            $id_persona_act = 0;
            $id_ubicacion_act = 0;
           
            
            if ($id_persona2!='') {
                $id_persona_act = $id_persona2;
                $id_persona='';
                
            }else{
                $id_persona_act = $id_persona;
            }
            

            if ($ubicacion_id2!=''){
                $id_ubicacion_act = $ubicacion_id2;
                $ubicacion_id='';

            }else{
                $id_ubicacion_act = $ubicacion_id;

            }
             

            $direccion=$request->direccion;
            $correo=$request->email;

            if ($request->direccion2!=''){
                $direccion=$request->direccion2;
                $correo=$request->email2;
            }
/*
            echo "direccion -> {$direccion}\n ";
            echo "correo -> {$correo}\n ";

            echo "id_persona_act -> {$id_persona_act}\n ";
            echo "id_ubicacion_act -> {$id_ubicacion_act}\n ";

            echo "tipoF -> {$tipoF}\n ";

            echo "ubicacion_id -> {$ubicacion_id}\n ";
            echo "id_persona -> {$id_persona}\n ";

            echo "ubicacion_id2 -> {$ubicacion_id2}\n ";
            echo "id_persona2 -> {$id_persona2}\n ";
  */         
   //         exit();
/*
            direccion -> Av. candada 3394 
            correo -> frimacc@gmail.com 
            id_persona_act -> 
            id_ubicacion_act -> 28131 
            tipoF -> FT 
            ubicacion_id -> 28131 
            id_persona -> 
            ubicacion_id2 -> 
            id_persona2 ->
           
*/
            if ($id_persona_act != 0 || $id_ubicacion_act != 0 ) {

                

               // exit($id_persona_act);

                
                if ($tipoF == 'FT' &&  $ubicacion_id !='' )
                {

                    
                    $empresa = Empresa::where('id', $id_ubicacion_act)->first();
                    if($empresa){

                        $empresa->direccion = $direccion;
                        $empresa->email = $correo;
                        $empresa->save();
                    }
                }

                if ($tipoF == 'FT' &&  $id_persona != '' )
                {
                    $persona = Persona::where('id', $id_persona_act)->first();
                    if($persona){
                        $persona->direccion = $direccion;
                        $persona->correo = $correo;
                        $persona->save();
                    }

                    $persona2 = Agremiado::where('id_persona', $id_persona_act)->first();
                    if($persona2){
                        $persona2->direccion = $direccion;
                        $persona2->email1 = $correo;
                        $persona2->save();
                    }
                }

                if ($tipoF == 'BV' &&  $id_persona != '' )
                {
                    //exit($id_persona);
                   
                    
                    $persona = Persona::where('id', $id_persona_act)->first();                    
                    if($persona){
                        $persona->direccion = $direccion;
                        $persona->correo = $correo;    
                        $persona->save();                        
                    }
                    
                    $persona2 = Agremiado::where('id_persona', $id_persona_act)->first();
                    if($persona2){                        
                        $persona2->direccion = $direccion;
                        $persona2->email1 = $correo;
                        $persona2->save();
                    }
                    

                    
                }

                if ($tipoF == 'FT' &&  $ubicacion_id2 != '' )
                {
                    $empresa = Empresa::where('id', $id_ubicacion_act)->first();
                    if($empresa){
                        $empresa->direccion = $direccion;
                        $empresa->email = $correo;
                        $empresa->save();
                    }
                }    

                if ($tipoF == 'BV' &&  $id_persona2 != '') 
                {
                    $persona = Persona::where('id', $id_persona_act)->first();
                    if($persona){
                        $persona->direccion = $direccion;
                        $persona->correo = $correo;
                        $persona->save();
                    }

                    $persona2 = Agremiado::where('id_persona', $id_persona_act)->first();
                    if($persona2){  
                        $persona2->direccion = $direccion;
                        $persona2->email1 = $correo;
                        $persona2->save();
                    }
                }
                

            }

            //exit();
				//$valoriza = Valorizacione::where('val_aten_estab', '=', $vestab)->where('val_codigo', '=', $vcodigo)->first();                
              
                //$valoriza = Valorizacione::find($id_val);
				//$id_moneda=1;
				//if(isset($valoriza->id_moneda) && $valoriza->id_moneda == 1)$id_moneda=1;
				//if(isset($valoriza->id_moneda) && $valoriza->id_moneda == 2)$id_moneda=2;
                //$id_moneda=$valoriza->id_moneda;

				
				//echo $valoriza->val_codigo."-----";
				//$ingreso = IngresoVehiculo::where('aten_establecimiento', '=', $valoriza->val_estab)->where('aten_numero', '=', $valoriza->val_aten_codigo)->first();
				
				/*************************************/
				
                //print_r($serieF); exit();

                if($ubicacion_id=="")$ubicacion_id=$id_persona;

                $descuento =  $request->totalDescuento; 
                if ($request->totalDescuento=='') $descuento = 0;

                ///redondeo///
                $total_pagar = $request->total_pagar;
                if ($total_pagar!="0"){                         
                    $total_pagar = $request->total_pagar;
                    $total_g = $request->totalF;
                    $total_redondeo = $total_pagar - $total_g;

                    $total = $total+$total_redondeo;
                }

                ///Abono Directo///

                $total_pagar_abono = $request->total_pagar_abono;
                $total_abono= 0;

                if ($total_pagar_abono!="0"){                         
                    $total_pagar_abono = $request->total_pagar_abono;
                    $total_g = $request->totalF;
                    $total_abono= $total_pagar_abono - $total_g;

                    $total = $total+$total_abono;
                }


                //if ($id_concepto!= 26411) $id_tipo_afectacion_pp=0;
                //if ($id_concepto!= 26411 && $id_concepto!= 26412) $id_tipo_afectacion_pp=0;

                /*
                echo("ubicacion_id:".$ubicacion_id);
                echo(" - ");
                echo("id_persona_act:".$id_persona_act);
                echo(" - ");
                echo("ubicacion_id2:".$ubicacion_id2);
                echo(" - ");
                echo("id_persona2:".$id_persona2);
                
                exit();
                */
                
				$id_factura = $facturas_model->registrar_factura_moneda($serieF,     $id_tipo_afectacion_pp, $tipoF, $ubicacion_id, $id_persona_act, round($total,2),   $ubicacion_id2,      $id_persona2,    0, $id_caja,          $descuento,    'f',     $id_user,  $id_moneda);
																	 //(serie,  numero,   tipo,     ubicacion,     persona,  total, descripcion, cod_contable, id_v,   id_caja, descuento, accion, p_id_usuario, p_id_moneda)

                

				$factura = Comprobante::where('id', $id_factura)->get()[0];
            
				$fac_serie = $factura->serie;
				$fac_numero = $factura->numero;

				$factura_upd = Comprobante::find($id_factura);
				if(isset($factura_upd->tipo_cambio)) $factura_upd->tipo_cambio = $request->tipo_cambio;
                
                if($total>700 and $tipoF=='FT' ) {
                    $factura_upd->porc_detrac = $request->porcentaje_detraccion;
                    $factura_upd->monto_detrac = $request->monto_detraccion;
                    $factura_upd->cuenta_detrac = $request->nc_detraccion;

                    $factura_upd->tipo_detrac = $request->tipo_detraccion;
                    $factura_upd->afecta_detrac = $request->afecta_a;
                    $factura_upd->medio_pago_detrac = $request->medio_pago;                
                    //$factura_upd->detraccion = $request->tipo_cambio;
                    //$factura_upd->id_detra_cod_bos = $request->tipo_cambio;
                }

                $factura_upd->estado_pago =  $request->estado_pago;

                $factura_upd->id_forma_pago =  $request->id_formapago_;

                $factura_upd->tipo_operacion = $request->id_tipooperacion_;


                //$factura_upd->id_persona = $request->id_tipooperacion_;
                //$factura_upd->id_empresa = $request->id_tipooperacion_;



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
                

    
                if ($total_pagar!="0"){
                    $total_pagar = $request->total_pagar;
                    $total_g = $request->totalF;
                    $total_redondeo = $total_pagar - $total_g;
                    $fecha_hoy = date('Y-m-d');

                    $items1 = array(
                        "id" => 1081517, 
                        "fecha" => $fecha_hoy,
                        "denominacion" => "REDONDEO",
                        "descripcion" => "REDONDEO",
                        "monto" => round($total_redondeo,2),
                        "moneda" => "SOLES" ,
                        "id_moneda" => 1 ,
                        "descuento" => 0 ,
                        "cod_contable" => "",
                        "id_concepto" => 26464 ,
                        "igv" => 0 ,
                        "cantidad" => 1, 
                        "total" => round($total_redondeo,2), 
                        "item" => 999 ,
    
                        );
                    $tarifa[999]=$items1;
                }

                if ($total_abono!="0"){
                    $total_pagar_abono = $request->total_pagar_abono;
                    $total_g = $request->totalF;
                    $total_abono = $total_pagar_abono - $total_g;
                    $fecha_hoy = date('Y-m-d');

                    $items1 = array(
                        "id" => 1081517, 
                        "fecha" => $fecha_hoy,
                        "denominacion" => "REDONDEO",
                        "descripcion" => "REDONDEO",
                        "monto" => round($total_abono,2),
                        "moneda" => "SOLES" ,
                        "id_moneda" => 1 ,
                        "descuento" => 0 ,
                        "cod_contable" => "",
                        "id_concepto" => 26464 ,
                        "igv" => 0 ,
                        "cantidad" => 1, 
                        "total" => round($total_abono,2), 
                        "item" => 999 ,
    
                        );
                    $tarifa[999]=$items1;
                }
               
				
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
					$id_factura_detalle = $facturas_model->registrar_factura_moneda($serieF, $fac_numero, $tipoF, $value['cantidad'], $value['id_concepto'], $total, $value['descripcion'], $value['cod_contable'], $value['item'], $id_factura, $descuento,    'd',     $id_user,  $id_moneda);
					
                    
                    //(  serie,      numero,   tipo,      ubicacion,               persona,  total,            descripcion,           cod_contable,         id_v,     id_caja,  descuento, accion, p_id_usuario, p_id_moneda)
					
                    /*
					if(isset($ingreso->servicio) && $ingreso->servicio=="Venta de Productos Hidrobiologicos"){
						$value['denominacion']="RESIDUOS HIDROBIOLOGICOS";
						$id_guia_detalle = $guia_model->registrar_guia($guia_serie,$guia_numero,$guia_tipo,$serie_relacionado,$num_relacionado,$tipo_relacionado,$serie_baja,$num_baja,$tipo_baja,$emisor_numdoc,$emisor_tipodoc,$emisor_razsocial,$receptor_numdoc,$receptor_tipodoc,$receptor_razsocial,$tercero_numdoc,$tercero_tipodoc,$tercero_razsocial,$cod_motivo,$desc_motivo,$transbordo,$peso_bruto,$bultos,$modo_traslado,$fecha_traslado,$transportista_numdoc,$transportista_tipo_doc,$transportista_razsoc,$vehiculo_placa,$conductor_numdoc,$conductor_tipodoc,$llegada_ubigeo,$llegada_direccion,$partida_ubigeo,$partida_direccion,$numero_contenedor,$puerto_desembarque,$observaciones,$ruta_comprobante,$email,$estado_email,$estado_sunat,$anulado,$value['item'],$value['vcodigo'],$value['denominacion'],1,"TM","d");
					}
                    */
				
				}


                $valorizad_ = $request->valorizad;
                $numero_documento_b = $request->numero_documento_b;

                foreach ($valorizad_ as $key => $value) {

                    $id_val = $value['id'];

                    $id_concepto = $value['id_concepto'];

                    if ($id_concepto=='26474' || $id_concepto=='26483'){
    
                        $valorizaciones_model = new Valorizacione; 
    
                        $credipago = $valorizaciones_model->ActualizaValorizacionCredipago($id_val);
    
                    }

                    
                } 





                $descuentopp = $request->descuentopp;
                $id_pronto_pago = $request->id_pronto_pago;

                //if ($descuentopp =="S"){
                    //$valorizad = $request->valorizad;
                    //foreach ($valorizad as $key => $value) {
                    
                //echo "id_factura=>".$id_factura."<br>"; exit();
                

                //echo "id_val=>".$id_val."<br>"; exit();

                $valorizad = $request->valorizad;

                //print_r($tarifa); exit();

                    foreach ($valorizad as $key => $value) {
                        $id_val = $value['id'];
                        
                        $valoriza_upd = Valorizacione::find($id_val);

                       

                        $valoriza_upd->id_comprobante = $id_factura;
                        $valoriza_upd->pagado = "1";

                        $valoriza_upd->valor_unitario = $value['monto'];
                        $valoriza_upd->cantidad = $value['cantidad'];    


                        if ($descuentopp =="S")$valoriza_upd->id_pronto_pago = $id_pronto_pago;

                        $valoriza_upd->save();
                        
                    } 

                //}


/*                    
                foreach ($tarifa as $key => $value) {

                    $id_val = $value['id'];
                    $valoriza_upd1 = Valorizacione::find($id_val);

                    $valoriza_upd1->valor_unitario = $value['monto'];
                    $valoriza_upd1->cantidad = $value['cantidad'];                      
                
                    $valoriza_upd1->save();
                
                }  
*/


            if ($id_concepto == 26527 || $id_concepto == 26412 ) {
                $agremiado = Agremiado::where('id_persona', $id_persona)->get()[0];
                $agremiado->id_situacion = "73";
                $agremiado->save();
            }
            


			

            $id_persona = $request->persona;
            $ubicacion_id = $request->ubicacion;



            if ($id_concepto == 26411) {

                $id_persona = $request->persona;
                $valorizaciones_model = new Valorizacione;
                $totalDeuda = $valorizaciones_model->getBuscaDeudaAgremido($id_persona);
                $total_ = $totalDeuda->total;

                if ($total_ <= 2) {
                    $agremiado = Agremiado::where('id_persona', $id_persona)->get()[0];

                    if($agremiado->id_actividad_gremial != 225){
                        $agremiado->id_situacion = "73";
                        $agremiado->save();
                    }
                }
                else{
                    $agremiado = Agremiado::where('id_persona', $id_persona)->get()[0];
                    $agremiado->id_situacion = "74";
                    $agremiado->save();
                }

            }

            if($request->id_formapago_=='2'){
                $credito = $request->credito;
                //print_r($credito); 
                $item_ = 0;
        
                foreach ($credito as $key => $value) {
                    $total_credito = $value['total_frac'];
                    $fecha_cuota = $value['fecha_cuota'];
        
                    //print_r($total_frac); 
        
                    $item_++;
        
                    $comprobanteCuota = new ComprobanteCuota;
        
                    $comprobanteCuota->id_comprobante = $id_factura;
                    $comprobanteCuota->item = $item_;
                    $comprobanteCuota->monto = $total_credito;
                    $comprobanteCuota->fecha_vencimiento = $fecha_cuota;
                    $comprobanteCuota->id_usuario_inserta = $id_user;
        
                    $comprobanteCuota->save();   
        
                }

            }
            


            if(isset($request->idMedio)):
                foreach ($request->idMedio as $key => $value):
                    if($request->idMedio[$key]!=""){
                        $idMedio = $request->idMedio[$key];

                        $id_comprobante = $id_factura;
                        $monto = (isset($request->monto[$key]) && $request->monto[$key] > 0)?$request->monto[$key]:"0";
                        $nro_operacion = (isset($request->nroOperacion[$key]))?$request->nroOperacion[$key]:"";
                        $descripcion = (isset($request->descripcion[$key]))?$request->descripcion[$key]:"";                        
                        $fecha_vencimiento = $request->fecha[$key];

                        $item=1;
                        $fecha = date('d/m/Y');

                        if($monto!="0"){

                            $comprobantePago = new ComprobantePago;                        
                            $comprobantePago->id_medio = $idMedio;
                            $comprobantePago->fecha = $fecha;
                            $comprobantePago->item = $item;
                            $comprobantePago->nro_operacion = $nro_operacion;
                            $comprobantePago->id_comprobante = $id_comprobante;
                            $comprobantePago->descripcion = $descripcion;
                            $comprobantePago->monto = $monto;
                            $comprobantePago->fecha_vencimiento = date("Y-m-d",strtotime($fecha_vencimiento));
                            $comprobantePago->id_usuario_inserta = $id_user;
                        
                            $comprobantePago->save();    

                        }                    
                    }
                endforeach;
            endif;


            $estado_ws = $ws_model->getMaestroByTipo('96');
            $flagWs = isset($estado_ws[0]->codigo) ? $estado_ws[0]->codigo : 1;

            if ($flagWs == 2 && $id_factura > 0 && ($tipoF == "FT" || $tipoF == "BV")) {
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
    public function send_1(Request $request)
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

            $credito = $request->credito;

            $id_formapago = $request->id_formapago_;
            
            //print_r($id_formapago);
            //$credito = $request->credito;           
           
            /*

            if ($id_formapago==2){
                print_r($credito); exit();

                foreach ($credito as $key => $value){                
                   // if($request->total_frac[$key]!=""){
                        //$idMedio = $request->idMedio[$key];

                      //  $id_comprobante = $id_factura;
                        //$monto = (isset($request->monto[$key]) && $request->monto[$key] > 0)?$request->monto[$key]:"0";
                        
                        $total_frac = $value['total_frac'];
                        print_r($total_frac);                 
                   // }
                   }

            }
            */

            /*
            foreach ($tarifa as $key => $value) {
                //$vestab = $value['vestab'];
                //$vcodigo = $value['vcodigo'];
                $id_val = $value['id'];
                $id_concepto = $value['id_concepto'];

                $id_moneda = $value['id_moneda'];

            }

            exit();
            
*/


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
            $ubicacion_id2 = $request->ubicacion2;
			$id_persona = $request->persona;
            $id_persona2 = $request->persona2;

            if ($id_persona=='') $id_persona = 0;
            if ($id_persona2=='') $id_persona2 = '0';

            if ($ubicacion_id2=='') $ubicacion_id2 = '0';

            //print_r($id_persona); exit();


			$id_caja = $request->id_caja;
			$adelanto   = $request->adelanto;

			$trans = $request->trans;

			//$std =  $this->getTipoDocPersona($id_persona );

			//print_r($std);
			//exit();

			//1	DOLARES
			//2	SOLES

            $id_concepto = 0;

			if ($trans == 'FA' || $trans == 'FN'){

				$ws_model = new TablaMaestra;
				
				/*************************************/
				$id_moneda=1;

				foreach ($tarifa as $key => $value) {
					//$vestab = $value['vestab'];
					//$vcodigo = $value['vcodigo'];
                    $id_val = $value['id'];
                    $id_concepto = $value['id_concepto'];

                    $id_moneda = $value['id_moneda'];

				}
				
                $ubicacion_id = $request->ubicacion;        
            $ubicacion_id2 = $request->ubicacion2;
			$id_persona = $request->persona;
            $id_persona2 = $request->persona2;

/*
            echo "ubicacion_id -> {$ubicacion_id}\n ";
            echo "id_persona -> {$id_persona}\n ";

            echo "ubicacion_id2 -> {$ubicacion_id2}\n ";
            echo "id_persona2 -> {$id_persona2}\n ";
            
            exit();

*/

            $id_persona_act = 0;
            $id_ubicacion_act = 0;
           
            
            if ($id_persona2!='') {
                $id_persona_act = $id_persona2;
                $id_persona='';
                
            }else{
                $id_persona_act = $id_persona;
            }
            

            if ($ubicacion_id2!=''){
                $id_ubicacion_act = $ubicacion_id2;
                $ubicacion_id='';

            }else{
                $id_ubicacion_act = $ubicacion_id;

            }
             

            $direccion=$request->direccion;
            $correo=$request->email;

            if ($request->direccion2!=''){
                $direccion=$request->direccion2;
                $correo=$request->email2;
            }
/*
            echo "direccion -> {$direccion}\n ";
            echo "correo -> {$correo}\n ";

            echo "id_persona_act -> {$id_persona_act}\n ";
            echo "id_ubicacion_act -> {$id_ubicacion_act}\n ";

            echo "tipoF -> {$tipoF}\n ";

            echo "ubicacion_id -> {$ubicacion_id}\n ";
            echo "id_persona -> {$id_persona}\n ";

            echo "ubicacion_id2 -> {$ubicacion_id2}\n ";
            echo "id_persona2 -> {$id_persona2}\n ";
  */          
           // exit();

            if ($id_persona_act != 0 || $id_ubicacion_act != 0 ) {

               // exit($id_persona_act);

                
                if ($tipoF == 'FT' &&  $ubicacion_id =='' )
                {
                    $empresa = Empresa::where('id', $id_ubicacion_act)->get()[0];
                    $empresa->direccion = $direccion;
                    $empresa->email = $correo;
                    $empresa->save();
                }

                if ($tipoF == 'FT' &&  $id_persona != '' )
                {
                    $persona = Persona::where('id', $id_persona_act)->get()[0];
                    $persona->direccion = $direccion;
                    $persona->correo = $correo;
                    $persona->save();

                    $persona2 = Agremiado::where('id_persona', $id_persona_act)->get()[0];
                    $persona2->direccion = $direccion;
                    $persona2->email1 = $correo;
                    $persona2->save();
                }

                if ($tipoF == 'BV' &&  $id_persona != '' )
                {
                    //exit($id_persona);
                    $persona = Persona::where('id', $id_persona_act)->get()[0];
                    $persona->direccion = $direccion;
                    $persona->correo = $correo;
                    $persona->save();

                    $persona2 = Agremiado::where('id_persona', $id_persona_act)->get()[0];
                    $persona2->direccion = $direccion;
                    $persona2->email1 = $correo;
                    $persona2->save();
                }

                if ($tipoF == 'FT' &&  $ubicacion_id2 != '' )
                {
                    $empresa = Empresa::where('id', $id_ubicacion_act)->get()[0];
                    $empresa->direccion = $direccion;
                    $empresa->email = $correo;
                    $empresa->save();
                }    

                if ($tipoF == 'BV' &&  $id_persona2 != '') 
                {
                    $persona = Persona::where('id', $id_persona_act)->get()[0];
                    $persona->direccion = $direccion;
                    $persona->correo = $correo;
                    $persona->save();

                    $persona2 = Agremiado::where('id_persona', $id_persona_act)->get()[0];
                    $persona2->direccion = $direccion;
                    $persona2->email1 = $correo;
                    $persona2->save();
                }
                

            }
				//$valoriza = Valorizacione::where('val_aten_estab', '=', $vestab)->where('val_codigo', '=', $vcodigo)->first();                
              
                //$valoriza = Valorizacione::find($id_val);
				//$id_moneda=1;
				//if(isset($valoriza->id_moneda) && $valoriza->id_moneda == 1)$id_moneda=1;
				//if(isset($valoriza->id_moneda) && $valoriza->id_moneda == 2)$id_moneda=2;
                //$id_moneda=$valoriza->id_moneda;

				
				//echo $valoriza->val_codigo."-----";
				//$ingreso = IngresoVehiculo::where('aten_establecimiento', '=', $valoriza->val_estab)->where('aten_numero', '=', $valoriza->val_aten_codigo)->first();
				
				/*************************************/
				
                //print_r($serieF); exit();

                if($ubicacion_id=="")$ubicacion_id=$id_persona;

                $descuento =  $request->totalDescuento; 
                if ($request->totalDescuento=='') $descuento = 0;

                if ($id_concepto!= 26411) $id_tipo_afectacion_pp=0;

				$id_factura = $facturas_model->registrar_factura_moneda($serieF,     $id_tipo_afectacion_pp, $tipoF, $ubicacion_id, $id_persona, $total,   $ubicacion_id2,      $id_persona2,    0, $id_caja,          $descuento,    'f',     $id_user,  $id_moneda);
																	 //(serie,  numero,   tipo,     ubicacion,     persona,  total, descripcion, cod_contable, id_v,   id_caja, descuento, accion, p_id_usuario, p_id_moneda)

                

				$factura = Comprobante::where('id', $id_factura)->get()[0];
            
				$fac_serie = $factura->serie;
				$fac_numero = $factura->numero;

				$factura_upd = Comprobante::find($id_factura);
				if(isset($factura_upd->tipo_cambio)) $factura_upd->tipo_cambio = $request->tipo_cambio;
                
                if($total>700 and $tipoF=='FT') {
                    $factura_upd->porc_detrac = $request->porcentaje_detraccion;
                    $factura_upd->monto_detrac = $request->monto_detraccion;
                    $factura_upd->cuenta_detrac = $request->nc_detraccion;

                    $factura_upd->tipo_detrac = $request->tipo_detraccion;
                    $factura_upd->afecta_detrac = $request->afecta_a;
                    $factura_upd->medio_pago_detrac = $request->medio_pago;                
                    //$factura_upd->detraccion = $request->tipo_cambio;
                    //$factura_upd->id_detra_cod_bos = $request->tipo_cambio;
                }

                $factura_upd->estado_pago =  $request->estado_pago;

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
					$id_factura_detalle = $facturas_model->registrar_factura_moneda($serieF, $fac_numero, $tipoF, $value['cantidad'], $value['id_concepto'], $total, $value['descripcion'], $value['cod_contable'], $value['item'], $id_factura, $descuento,    'd',     $id_user,  $id_moneda);
					
                    
                    //(  serie,      numero,   tipo,      ubicacion,               persona,  total,            descripcion,           cod_contable,         id_v,     id_caja,  descuento, accion, p_id_usuario, p_id_moneda)
					
                    /*
					if(isset($ingreso->servicio) && $ingreso->servicio=="Venta de Productos Hidrobiologicos"){
						$value['denominacion']="RESIDUOS HIDROBIOLOGICOS";
						$id_guia_detalle = $guia_model->registrar_guia($guia_serie,$guia_numero,$guia_tipo,$serie_relacionado,$num_relacionado,$tipo_relacionado,$serie_baja,$num_baja,$tipo_baja,$emisor_numdoc,$emisor_tipodoc,$emisor_razsocial,$receptor_numdoc,$receptor_tipodoc,$receptor_razsocial,$tercero_numdoc,$tercero_tipodoc,$tercero_razsocial,$cod_motivo,$desc_motivo,$transbordo,$peso_bruto,$bultos,$modo_traslado,$fecha_traslado,$transportista_numdoc,$transportista_tipo_doc,$transportista_razsoc,$vehiculo_placa,$conductor_numdoc,$conductor_tipodoc,$llegada_ubigeo,$llegada_direccion,$partida_ubigeo,$partida_direccion,$numero_contenedor,$puerto_desembarque,$observaciones,$ruta_comprobante,$email,$estado_email,$estado_sunat,$anulado,$value['item'],$value['vcodigo'],$value['denominacion'],1,"TM","d");
					}
                    */
				
				}

                
                

                $descuentopp = $request->descuentopp;
                $id_pronto_pago = $request->id_pronto_pago;

                //if ($descuentopp =="S"){
                    //$valorizad = $request->valorizad;
                    //foreach ($valorizad as $key => $value) {
                    
                //echo "id_factura=>".$id_factura."<br>"; exit();
                

                //echo "id_val=>".$id_val."<br>"; exit();

                $valorizad = $request->valorizad;

                //print_r($tarifa); exit();

                    foreach ($valorizad as $key => $value) {
                        $id_val = $value['id'];
                        
                        $valoriza_upd = Valorizacione::find($id_val);

                       

                        $valoriza_upd->id_comprobante = $id_factura;
                        $valoriza_upd->pagado = "1";

                        $valoriza_upd->valor_unitario = $value['monto'];
                        $valoriza_upd->cantidad = $value['cantidad'];    


                        if ($descuentopp =="S")$valoriza_upd->id_pronto_pago = $id_pronto_pago;

                        $valoriza_upd->save();
                        
                    } 

                //}


/*                    
                foreach ($tarifa as $key => $value) {

                    $id_val = $value['id'];
                    $valoriza_upd1 = Valorizacione::find($id_val);

                    $valoriza_upd1->valor_unitario = $value['monto'];
                    $valoriza_upd1->cantidad = $value['cantidad'];                      
                
                    $valoriza_upd1->save();
                
                }  
*/


            if ($id_concepto == 26527 || $id_concepto == 26412 ) {
                $agremiado = Agremiado::where('id_persona', $id_persona)->get()[0];
                $agremiado->id_situacion = "73";
                $agremiado->save();
            }
            


			

            $id_persona = $request->persona;
            $ubicacion_id = $request->ubicacion;



            if ($id_concepto == 26411) {

                $id_persona = $request->persona;
                $valorizaciones_model = new Valorizacione;
                $totalDeuda = $valorizaciones_model->getBuscaDeudaAgremido($id_persona);
                $total_ = $totalDeuda->total;

                if ($total_ <= 2) {
                    $agremiado = Agremiado::where('id_persona', $id_persona)->get()[0];
                    $agremiado->id_situacion = "73";
                    $agremiado->save();
                }
                else{
                    $agremiado = Agremiado::where('id_persona', $id_persona)->get()[0];
                    $agremiado->id_situacion = "74";
                    $agremiado->save();
                }

            }



            if(isset($request->idMedio)):
                foreach ($request->idMedio as $key => $value):
                    if($request->idMedio[$key]!=""){
                        $idMedio = $request->idMedio[$key];

                        $id_comprobante = $id_factura;
                        $monto = (isset($request->monto[$key]) && $request->monto[$key] > 0)?$request->monto[$key]:"0";
                        $nro_operacion = (isset($request->nroOperacion[$key]))?$request->nroOperacion[$key]:"";
                        $descripcion = (isset($request->descripcion[$key]))?$request->descripcion[$key]:"";                        
                        $fecha_vencimiento = $request->fecha[$key];

                        $item=1;
                        $fecha = date('d/m/Y');

                        if($monto!="0"){

                            $comprobantePago = new ComprobantePago;                        
                            $comprobantePago->id_medio = $idMedio;
                            $comprobantePago->fecha = $fecha;
                            $comprobantePago->item = $item;
                            $comprobantePago->nro_operacion = $nro_operacion;
                            $comprobantePago->id_comprobante = $id_comprobante;
                            $comprobantePago->descripcion = $descripcion;
                            $comprobantePago->monto = $monto;
                            $comprobantePago->fecha_vencimiento = date("Y-m-d",strtotime($fecha_vencimiento));
                            $comprobantePago->id_usuario_inserta = $id_user;
                        
                            $comprobantePago->save();    

                        }                    
                    }
                endforeach;
            endif;

            $id_formapago = $request->id_formapago_;

            if ($id_formapago==2){

                //$credito = $request->credito;

                foreach ($request->credito as $key => $value):
                    if($request->idMedio[$key]!=""){
                        $idMedio = $request->idMedio[$key];

                        $id_comprobante = $id_factura;
                        $monto = (isset($request->monto[$key]) && $request->monto[$key] > 0)?$request->monto[$key]:"0";
                        $nro_operacion = (isset($request->nroOperacion[$key]))?$request->nroOperacion[$key]:"";
                        $descripcion = (isset($request->descripcion[$key]))?$request->descripcion[$key]:"";                        
                        $fecha_vencimiento = $request->fecha[$key];

                        $item=1;
                        $fecha = date('d/m/Y');

                        if($monto!="0"){

                            $comprobantePago = new ComprobantePago;                        
                            $comprobantePago->id_medio = $idMedio;
                            $comprobantePago->fecha = $fecha;
                            $comprobantePago->item = $item;
                            $comprobantePago->nro_operacion = $nro_operacion;
                            $comprobantePago->id_comprobante = $id_comprobante;
                            $comprobantePago->descripcion = $descripcion;
                            $comprobantePago->monto = $monto;
                            $comprobantePago->fecha_vencimiento = date("Y-m-d",strtotime($fecha_vencimiento));
                            $comprobantePago->id_usuario_inserta = $id_user;
                        
                            $comprobantePago->save();    

                        }                    
                    }
                endforeach;


            }


            



            $estado_ws = $ws_model->getMaestroByTipo('96');
            $flagWs = isset($estado_ws[0]->codigo) ? $estado_ws[0]->codigo : 1;

            if ($flagWs == 2 && $id_factura > 0 && ($tipoF == "FT" || $tipoF == "BV")) {
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


    public function send_nd(Request $request){
        //print_r($request); exit();
       $sw = true;
       $msg = "";

       $id_user = Auth::user()->id;
       $facturas_model = new Comprobante;
       $guia_model = new Guia;

           /**********RUC***********/

           $tarifa = $request->facturad;

          // print_r($request); exit();

           $total = $request->totalP;
           $serieF = $request->serieF;
           $tipoF = $request->tipoF;
           $ubicacion_id = $request->ubicacion;
           $cod_tributario = $request->numero_documento;
           $razon_social=$request->razon_social;
           $direccion=$request->direccion;
           $correo=$request->correo;
           $id_caja = $request->id_caja;
           $adelanto   = $request->adelanto;

           $afecta='0';            
           $tiponota='0';            
           $motivo=$request->motivo_;
           $afecta_ingreso='';

           $id_comprobante_ncdc = $request->id_comprobante_ncdc;
           $id_comprobante = $request->id_comprobante;


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

                    ///redondeo///
                    $total_pagar = $request->total_pagar;
                    //print_r($total_pagar);
                    //print_r('-');

                    if ($total_pagar!="0"){                         
                        $total_pagar = $request->total_pagar;
                        $total_g = $request->totalP;
                        $total_redondeo = $total_pagar - $total_g;
    
                        $total = $total+$total_redondeo;
                    }

                    
    
                    ///Abono Directo///
    
                    $total_pagar_abono = $request->total_pagar_abono;
                    $total_abono= 0;

                    //print_r($total_pagar_abono);
    
                    if ($total_pagar_abono!="0"){                         
                        $total_pagar_abono = $request->total_pagar_abono;
                        $total_g = $request->totalP;
                        $total_abono= $total_pagar_abono - $total_g;
    
                        $total = $total+$total_abono;
                    }

                   // print_r($total_abono);
              
               
               $id_moneda=1;

               $descuento = $value['descuento'];
       
              $id_factura = $facturas_model->registrar_comprobante_ncnd($serieF,     0, $tipoF,  $cod_tributario, $total,          '',           '',    $id_comprobante, $id_caja,          0,    'f',     $id_user,  1,$razon_social,$direccion,$id_comprobante_ncdc,$correo,$afecta,$tiponota,   $motivo,$afecta_ingreso );
             //  $id_factura = $facturas_model->registrar_factura_moneda($serieF,     $id_tipo_afectacion_pp, $tipoF, $ubicacion_id, $id_persona, $total,          '',           '',    0, $id_caja,          $descuento,    'f',     $id_user,  $id_moneda);

              // print_r($id_factura); exit();					       //(serie,  numero,   tipo,     ubicacion,     persona,  total, descripcion, cod_contable, id_v,   id_caja, descuento, accion, p_id_usuario, p_id_moneda)
             
               $factura = Comprobante::where('id', $id_factura)->get()[0];

               $fac_serie = $factura->serie;
               $fac_numero = $factura->numero;

               $factura_upd = Comprobante::find($id_factura);
               if(isset($factura_upd->tipo_cambio)) $factura_upd->tipo_cambio = $request->tipo_cambio;
               
               $factura_upd->save();



               if ($total_pagar!="0"){
                $total_pagar = $request->total_pagar;
                $total_g = $request->totalP;
                $total_redondeo = $total_pagar - $total_g;
                $fecha_hoy = date('Y-m-d');

                $items1 = array(
                    "id" => 1081517, 
                    "fecha" => $fecha_hoy,
                    "denominacion" => "REDONDEO.",
                    "descripcion" => "REDONDEO.",
                    "monto" => round($total_redondeo,2),
                    "moneda" => "SOLES" ,
                    "id_moneda" => 1 ,
                    "descuento" => 0 ,
                    "cod_contable" => "",
                    //"id_concepto" => 26464 ,
                    "importe" => round($total_redondeo,2),
                    "igv" => 0 ,
                    //"cantidad" => 1, 
                    "total" => round($total_redondeo,2), 
                    "item" => 999 ,

                    );
                $tarifa[999]=$items1;
            }

            
            
           // print_r($request->totalP);
            //print_r('-');
            //print_r($request->total_pagar_abono);

            if ($total_abono!="0"){
                $total_pagar_abono = $request->total_pagar_abono;
                $total_g = $request->totalP;
                $total_abono = $total_pagar_abono - $total_g;
                $fecha_hoy = date('Y-m-d');

                //print_r('=');
                //print_r($total_abono);

                $items1 = array(
                    "id" => 1081517, 
                    "fecha" => $fecha_hoy,
                    "denominacion" => "REDONDEO",
                    "descripcion" => "REDONDEO",
                    "tipoF" => "ND",
                    "monto" => round($total_abono,2),
                    "moneda" => "SOLES" ,
                    "id_moneda" => 1 ,
                    "descuento" => 0 ,
                    "cod_contable" => "",
                    //"id_concepto" => 26464 ,
                    "importe" => round($total_abono,2),
                    "igv" => 0 ,
                    "total" => round($total_abono,2), 
                    "item" => 999 ,
                    );
                $tarifa[999]=$items1;
            }

               //print_r($tarifa); exit();
               foreach ($tarifa as $key => $value) {
                   //echo "denominacion=>".$value['denominacion']."<br>";
                   if ($adelanto == 'S'){
                       $total   = $request->MonAd;
                   }
                   else{
                       //$total   = ;
                       $total   =$value['importe'];
                   }
                   $descuento = $value['descuento'];
                   if ($value['descuento']=='') $descuento = 0;
                   $id_factura_detalle = $facturas_model->registrar_comprobante($serieF, $fac_numero, $tipoF, $value['item'], $total, $value['descripcion'], "", $value['id'], $id_factura, $descuento,    'd',     $id_user,  $id_moneda);
                                                                                //(  serie,      numero,   tipo,      ubicacion, persona,  total,            descripcion,           cod_contable,         id_v,     id_caja,  descuento, accion, p_id_usuario, p_id_moneda)
                   
               
               }

               if(isset($request->idMedio)):
                foreach ($request->idMedio as $key => $value):
                    if($request->idMedio[$key]!=""){
                        $idMedio = $request->idMedio[$key];

                        $id_comprobante = $id_factura;
                        $monto = (isset($request->monto[$key]) && $request->monto[$key] > 0)?$request->monto[$key]:"0";
                        $nro_operacion = (isset($request->nroOperacion[$key]))?$request->nroOperacion[$key]:"";
                        $descripcion = (isset($request->descripcion[$key]))?$request->descripcion[$key]:"";                        
                        $fecha_vencimiento = $request->fecha[$key];

                        $item=1;
                        $fecha = date('d/m/Y');

                        if($monto!="0"){

                            $comprobantePago = new ComprobantePago;                        
                            $comprobantePago->id_medio = $idMedio;
                            $comprobantePago->fecha = $fecha;
                            $comprobantePago->item = $item;
                            $comprobantePago->nro_operacion = $nro_operacion;
                            $comprobantePago->id_comprobante = $id_comprobante;
                            $comprobantePago->descripcion = $descripcion;
                            $comprobantePago->monto = $monto;
                            $comprobantePago->fecha_vencimiento = date("Y-m-d",strtotime($fecha_vencimiento));
                            $comprobantePago->id_usuario_inserta = $id_user;
                        
                            $comprobantePago->save();    

                        }                    
                    }
                endforeach;
            endif;



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

        if (is_null($factura->id_comprobante_ncnd) ){
            $factura_referencia = Comprobante::where('id', -1)->get();
            $ref_comprobante="";
            $ref_tipo="";
        }   
        else{
            $factura_referencia = Comprobante::where('id', $factura->id_comprobante_ncnd)->get()[0];
            $ref_comprobante=  $factura_referencia->serie . " - " .$factura_referencia->numero ;
            $ref_tipo=$factura_referencia->tipo;
        }

        ;
        


        $facd_serie = $factura->serie;
        $facd_numero = $factura->numero;
        $facd_tipo = $factura->tipo;

		//echo "facd_serie=>".$facd_serie."<br>";
		//echo "facd_numero=>".$facd_numero."<br>";
		//echo "facd_tipo=>".$facd_tipo."<br>";
		
		$id_guia = 0;
        
        $datos_model = new Comprobante;
		
        $datos=  $datos_model->getDatosByComprobante($id);
        
        $cronograma=  $datos_model->getCronogramaPagos($id);
       

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

       // $model = new ComprobanteDetalle;
       // $comprobanteDetalle = $model->getMaestroByTipo(85);

       //print_r($factura);

        return view('frontend.comprobante.show',compact('factura','factura_detalles','id_guia','datos','cronograma','ref_comprobante','ref_tipo'));
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
        $p[]=$request->formapago;
        $p[]=$request->total_b;
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
        //echo($id);
        //echo("-");

        $id_origen= $request->id_comprobante_origen;
        //echo($id_origen);

        
        if ($id=="" ){
            $trans = "FN";
        }
        else{
            $trans = "FE";
        }
        
        
		if($id_caja==""){
			$valorizaciones_model = new Valorizacione;
			$id_user = Auth::user()->id;
			$caja_usuario = $valorizaciones_model->getCajaIngresoByusuario($id_user,'91');
			//$id_caja = $caja_usuario->id_caja;

			$id_caja = (isset($caja_usuario->id_caja))?$caja_usuario->id_caja:0;
		}
       
      //print_r($trans); 
      //echo($id);
     // exit();

        if ( $trans == "FN"){

            $comprobante_model=new Comprobante;
            $comprobante=$comprobante_model->getComprobanteById($id_origen);

            $facturad = ComprobanteDetalle::where([
                'serie' => $comprobante->serie,
                'numero' => $comprobante->numero,
                'tipo' => $comprobante->tipo
            ])->get();
           
            $afectacion=$facturad[0]->afect_igv;

       
        }
        else {
            $comprobante_model=new Comprobante;
            $comprobante=$comprobante_model->getComprobanteById($id);

            $facturad = ComprobanteDetalle::where([
                'serie' => $comprobante->serie,
                'numero' => $comprobante->numero,
                'tipo' => $comprobante->tipo
            ])->get();
        }
      //  print_r($comprobante); exit();

        if ($comprobante->tipo=="BV"){
            $persona_model= new Comprobante;
            $persona=  $persona_model->getPersonaDni($comprobante->cod_tributario);
           // print_r($persona); exit();
            $idcliente=$persona->id;
            
            $direccion=$persona->direccion;
            $correo=$persona->correo;
            
        }

        if ($comprobante->tipo=="FT"){
            $empresa_model= new Comprobante;
            $empresa=  $empresa_model->getEmpresaRuc($comprobante->cod_tributario);

            if($comprobante){
                $persona_model= new Comprobante;
                $persona=  $persona_model->getPersonaRuc($comprobante->cod_tributario);
                if($persona){
                    $idcliente=$persona->id;                 
                    $direccion=$persona->direccion;
                    $correo=$persona->email;
                }else{
                    $idcliente=$empresa->id;
                    $direccion=$empresa->direccion;
                    $correo=$empresa->email;
                }

            }else{
                 $idcliente=$empresa->id;
                 $direccion=$empresa->direccion;
                 $correo=$empresa->email;
            }
           
        }

        if ($comprobante->tipo=="NC"||$comprobante->tipo=="ND"){
            $empresa_model= new Comprobante;
            $empresa=  $empresa_model->getEmpresaRuc($comprobante->cod_tributario);

            if($comprobante){
                $persona_model= new Comprobante;
                $persona=  $persona_model->getPersonaRuc($comprobante->cod_tributario);
                if($persona){
                    $idcliente=$persona->id;                 
                    $direccion=$persona->direccion;
                    $correo=$persona->email;
                }else{
                    $idcliente=$empresa->id;
                    $direccion=$empresa->direccion;
                    $correo=$empresa->email;
                }

            }else{
                 $idcliente=$empresa->id;
                 $direccion=$empresa->direccion;
                 $correo=$empresa->email;
            }
           
        }
 
        
        $empresa_model = new Empresa;
        $serie_model = new TablaMaestra;

		$tabla_model = new TablaMaestra;
		$forma_pago = $tabla_model->getMaestroByTipo('108');
        $tipooperacion = $tabla_model->getMaestroByTipo('51');
        $formapago = $tabla_model->getMaestroByTipo('104');

        $serie = $serie_model->getMaestro('95');
        //print_r($tipoF); exit();

        //print_r($comprobante); exit();

        return view('frontend.comprobante.create_nc',compact('trans', 'comprobante','tipooperacion','serie','facturad','id_caja','forma_pago','direccion','correo','afectacion'));
        
    }

    public function nd_edita(Request $request){



        $id_caja = $request->id_caja_;

        $id = $request->id_comprobante;
        //echo($id);
        //echo("-");

        $id_origen= $request->id_comprobante_origen_nd;
       // echo($id_origen);

       // exit();
        
        if ($id=="" ){
            $trans = "FN";
        }
        else{
            $trans = "FE";
        }
        
        
		if($id_caja==""){
			$valorizaciones_model = new Valorizacione;
			$id_user = Auth::user()->id;
			$caja_usuario = $valorizaciones_model->getCajaIngresoByusuario($id_user,'91');
			//$id_caja = $caja_usuario->id_caja;

			$id_caja = (isset($caja_usuario->id_caja))?$caja_usuario->id_caja:0;
		}
       
        //print_r($trans); exit();

        if ( $trans == "FN"){

            $comprobante_model=new Comprobante;
            $comprobante=$comprobante_model->getComprobanteById($id_origen);

            //$id_comprobante_ncnd = $comprobante->tiene_nd;
            //$comprobante_ncnd=$comprobante_model->getComprobanteById($id_comprobante_ncnd);

            $facturad = ComprobanteDetalle::where([
                'serie' => $comprobante->serie,
                'numero' => $comprobante->numero,
                'tipo' => $comprobante->tipo
            ])->get();

            $afectacion=$facturad[0]->afect_igv;

            //print_r($comprobante); exit();
        }
        else {
            $comprobante_model=new Comprobante;
            $comprobante=$comprobante_model->getComprobanteById($id);

            //$id_comprobante_ncnd = $comprobante->tiene_nd;
            //$comprobante_ncnd=$comprobante_model->getComprobanteById($id_comprobante_ncnd);

            $facturad = ComprobanteDetalle::where([
                'serie' => $comprobante->serie,
                'numero' => $comprobante->numero,
                'tipo' => $comprobante->tipo
            ])->get();
        }

        


        if ($comprobante->tipo=="BV"){
            $persona_model= new Comprobante;
            $persona=  $persona_model->getPersonaDni($comprobante->cod_tributario);
           // print_r($persona); exit();
            $idcliente=$persona->id;
            
            $direccion=$persona->direccion_sunat;
            $correo=$persona->correo;
            
        }
/*
        if ($comprobante->tipo=="FT"){
            $empresa_model= new Comprobante;
            $empresa=  $empresa_model->getEmpresaRuc($comprobante->cod_tributario);
            $idcliente=$empresa->id;
            $direccion=$empresa->direccion;
            $correo=$empresa->email;
            
        }
        */
        if ($comprobante->tipo=="FT"){
            $empresa_model= new Comprobante;
            $empresa=  $empresa_model->getEmpresaRuc($comprobante->cod_tributario);

            if($comprobante){
                $persona_model= new Comprobante;
                $persona=  $persona_model->getPersonaRuc($comprobante->cod_tributario);
                if($persona){
                    $idcliente=$persona->id;                 
                    $direccion=$persona->direccion;
                    $correo=$persona->email;
                }else{
                    $idcliente=$empresa->id;
                    $direccion=$empresa->direccion;
                    $correo=$empresa->email;
                }
            }else{
                 $idcliente=$empresa->id;
                 $direccion=$empresa->direccion;
                 $correo=$empresa->email;
            }
           
        }

      

        $serie_model = new TablaMaestra;

		$tabla_model = new TablaMaestra;
		$forma_pago = $tabla_model->getMaestroByTipo('19');
        $tipooperacion = $tabla_model->getMaestroByTipo('52');
        $formapago = $tabla_model->getMaestroByTipo('104');

        $serie = $serie_model->getMaestro('95');

        $medio_pago = $tabla_model->getMaestroByTipo('19');


        return view('frontend.comprobante.create_nd',compact('trans', 'comprobante','tipooperacion','serie','facturad','id_caja','direccion','correo','medio_pago','afectacion'));
        

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

    public function forma_pago($term)
    {
       // print_r("Forma de Pago"); exit();
        $tabla_model = new TablaMaestra;
		$forma_pago = $tabla_model->getMaestroByTipoAndDenomina('19',$term);
         return response()->json($forma_pago);
    }

    public function credito_pago($id){
		
		$id_user = Auth::user()->id;
		$tabla_model = new TablaMaestra;

        $medio_pago = $tabla_model->getMaestroByTipo('19');
        $id_comprobante =0;

        
        $comprobante_model=new Comprobante;
        $comprobante=$comprobante_model->getComprobanteById($id);

        //print_r($comprobante);

        if($comprobante){
            $total=$comprobante->total;
            $total_credito=$comprobante->total_credito;
        }
        if (isset($variable))$total_credito="0";

		return view('frontend.comprobante.modal_credito_pago',compact('id','medio_pago','total','total_credito'));

    }

/*

    public function listar_credito_pago($id){

        $comprobante_model = new Comprobante; 
        $resultado = $comprobante_model->listar_credito_pago($id);
		return $resultado;

    }
        */

    public function listar_credito_pago(Request $request){
	
		//$puesto_model = new Concurso();
        $comprobante_model = new Comprobante;

		$p[]=$request->id;
		$p[]=1;          
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $comprobante_model->listar_credito_pago_paginado($p);
		$iTotalDisplayRecords = isset($data[0]->totalrows)?$data[0]->totalrows:0;

		$result["PageStart"] = $request->NumeroPagina;
		$result["pageSize"] = $request->NumeroRegistros;
		$result["SearchText"] = "";
		$result["ShowChildren"] = true;
		$result["iTotalRecords"] = $iTotalDisplayRecords;
		$result["iTotalDisplayRecords"] = $iTotalDisplayRecords;
		$result["aaData"] = $data;

        //print_r(json_encode($result)); exit();
		echo json_encode($result);

	
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
							"valorVentaItem"=> str_replace(",","",number_format($row->importe,2)), //"42.37",
							"descripcionItem"=> $row->descripcion,//"TRANSBORDO",
							"unidadMedidaItem"=> $row->unidad,
							"codigoProductoItem"=> ($row->cod_contable!="")?$row->cod_contable:"0000000", //"002",
                            "codigoDescuentoItem"=> "00",
							"valorUnitarioSinIgv"=> str_replace(",","",number_format($row->pu,2)), //"42.3728813559",
							"precioUnitarioConIgv"=> str_replace(",","",number_format($row->pu_con_igv,2)), //"50.0000000000",
							"unidadMedidaComercial"=> "SERV",
							"codigoAfectacionIGVItem"=> $row->afect_igv,
							"porcentajeDescuentoItem"=> str_replace(",","",number_format(($row->descuento*100)/$row->pu,2)),
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
		$data["tipoMoneda"] = ($factura->id_moneda=="1")?"PEN":"USD"; //"PEN";
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
		$data["totalDescuentos"] = str_replace(",","",number_format($factura->total_descuentos,2));
		$data["totalOPGravadas"] = "0.00"; //"127.12";
		$data["codigoPaisEmisor"] = "PE";
		$data["totalOPGratuitas"] = "0.00";        
		$data["docAfectadoFisico"] = false;
		$data["importeTotalVenta"] = str_replace(",","",number_format($factura->total,2)); //"150.00";
		$data["razonSocialEmisor"] = "COLEGIO DE ARQUITECTOS DEL PERU-REGIONAL LIMA";
		$data["totalOPExoneradas"] = "0.00";
		$data["totalOPNoGravadas"] = str_replace(",","",number_format($factura->subtotal,2));
		$data["codigoPaisReceptor"] = "PE";
		$data["departamentoEmisor"] = "JESUS MARIA";
		$data["descuentosGlobales"] = "0.00";
		$data["codigoTipoOperacion"] = "0101";
		$data["razonSocialReceptor"] = $factura->destinatario;//"Freddy Rimac Coral";
		$data["nombreComercialEmisor"] = "CAP";
		$data["tipoDocIdentidadEmisor"] = "6";
		$data["sumatoriaImpuestoBolsas"] = "0.00";
		$data["numeroDocIdentidadEmisor"] = "20172977911";//"20160453908";     
		$data["tipoDocIdentidadReceptor"] = $this->getTipoDocPersona($factura->tipo, $factura->cod_tributario);//"6";        
		$data["numeroDocIdentidadReceptor"] = $factura->cod_tributario; //"10040834643";
        $data["direccionReceptor"] = $factura->direccion;

        if ($factura->porc_detrac!="0")
        {
            
            $data["dtmontoDetraccion"] = $factura->monto_detrac;
           // $data["descripcionLeyenda"] = "OPERACIÓN SUJETA A DETRACCIÓN";
            $data["dtporcentajeDetraccion"] = $factura->porc_detrac;
            $data["dtnumeroCuentaBancoNacion"] = $factura->cuenta_detrac;
            $data["dtmontoTotalIncluidoDetraccion"] = $factura->total;

            $data["dtmedioPagoDetraccion"] = $factura->medio_pago_detrac;
            $data["dtcodigoBienServicio"] = $factura->afecta_detrac;
        }
        


      //  print_r(json_encode($data)); exit();


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
		print_r($results); 
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

        //

        if ($td == 'FT') {
            $tipoDoc = "6";
        } else {
            if ($td == 'NC') {
                $tipoDoc = "7";
            } else {
                if ($dni == '-') {
                    $tipoDoc = "0";
                } else {
                    $persona = Persona::where('numero_documento', $dni)->get()[0];
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
        }
        //print_r($tipoDoc);exit();
        return $tipoDoc;
    }

    public function firmar_nc($id_factura){

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
        foreach ($factura_detalles as $index => $row) {
            $items1 = array(
                    "ordenItem" => $row->item, //"2",
                    "adicionales" => [],
                    "cantidadItem" => $row->cantidad, //"1",
                    //"descuentoItem"=> $row->descuento,
                    "importeIGVItem" => str_replace(",", "", number_format($row->igv_total, 2)), //"7.63",
                    "montoTotalItem" => str_replace(",", "", number_format($row->importe, 2)), //"50.00",
                    "valorVentaItem" => str_replace(",", "", number_format($row->pu, 2)), //"42.37",
                    "descripcionItem" => $row->descripcion, //"TRANSBORDO",
                    "unidadMedidaItem" => $row->unidad,
                    //"codigoProductoItem"=> ($row->cod_contable!="")?$row->cod_contable:"0000000", //"002",
                    "valorUnitarioSinIgv" => str_replace(",", "", number_format($row->pu_con_igv, 2)), //"42.3728813559",
                    "precioUnitarioConIgv" => str_replace(",", "", number_format($row->importe, 2)), //"50.0000000000",
                    "unidadMedidaComercial" => "SERV",
                    "codigoAfectacionIGVItem" => "10",
                    //"porcentajeDescuentoItem"=> "0.00",
                    "codTipoPrecioVtaUnitarioItem" => "01"
                );
            $items[$index] = $items1;
        }
/*
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
 */
		$data["items"] = $items;
       // $data["server"] = $items2;

       
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
		$data["numeroDocIdentidadEmisor"] = "20172977911";//"20160453908";        
		$data["tipoDocIdentidadReceptor"] = $this->getTipoDocPersona($factura->tipo, $factura->cod_tributario);//"6";                
		$data["numeroDocIdentidadReceptor"] = $factura->cod_tributario; //"10040834643";

        //$data["direccionReceptor"] = $factura->direccion;

       // print_r($data); exit();

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
		print_r($results); 
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

    public function send_nc(Request $request)
    {
        $sw = true;
        $msg = "";
       

        $id_user = Auth::user()->id;
        $facturas_model = new Comprobante;
        $guia_model = new Guia;
 
            /**********RUC***********/
            

            $tarifa = $request->facturad;
 
            
            $total = $request->totalP;
            $serieF = $request->serieF;
            $tipoF = $request->tipoF;
            $ubicacion_id = $request->ubicacion;
            $cod_tributario = $request->numero_documento;
            $razon_social=$request->razon_social;
            $direccion=$request->direccion;
            $correo=$request->correo;
            $id_caja = $request->id_caja;
            $adelanto   = $request->adelanto;
            $afecta=$request->_afecta;            
            $tiponota=$request->_afecta;            
        	$motivo=$request->motivo_;
            $afecta_ingreso=$request->afecta_ingreso;
          
 
            $id_comprobante_ncdc = $request->id_comprobante_ncdc;
            $id_comprobante = $request->id_comprobante;

            $id_comprobante_origen=$request->id_comprobante_origen;

            //echo("id_comprobante_origen: ".$id_comprobante_origen);
            
            

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
                
               $id_factura = $facturas_model->registrar_comprobante_ncnd($serieF,     0, $tipoF,  $cod_tributario, $total,          '',           '',    $id_comprobante, $id_caja,          0,    'f',      $id_user,  1,$razon_social,$direccion,$id_comprobante_ncdc,$correo,$afecta,$tiponota,   $motivo,$afecta_ingreso);
              //  $id_factura = $facturas_model->registrar_factura_moneda($serieF,     $id_tipo_afectacion_pp, $tipoF, $ubicacion_id, $id_persona, $total,          '',           '',    0, $id_caja,          $descuento,    'f',     $id_user,  $id_moneda);
 
               // print_r($id_factura); exit();					       //(serie,  numero,   tipo,     ubicacion,     persona,  total, descripcion, cod_contable, id_v,   id_caja, descuento, accion, p_id_usuario, p_id_moneda)
              
                $factura = Comprobante::where('id', $id_factura)->get()[0];
 
                $fac_serie = $factura->serie;
                $fac_numero = $factura->numero;
 
                $factura_upd = Comprobante::find($id_factura);
                if(isset($factura_upd->tipo_cambio)) $factura_upd->tipo_cambio = $request->tipo_cambio;
                //print_r($tarifa); exit();

                $factura_upd->save();
 
               
                foreach ($tarifa as $key => $value) {
                    //echo "denominacion=>".$value['denominacion']."<br>";
                    if ($adelanto == 'S'){
                        $total   = $request->MonAd;
                    }
                    else{
                        //$total   = $value['importe'];
                        $total   =$value['importe'];
                    }
                    $descuento = $value['descuento'];
                    if ($value['descuento']=='') $descuento = 0;
                    $id_factura_detalle = $facturas_model->registrar_comprobante_ncnd($serieF, $fac_numero, $tipoF, $value['item'], $total, $value['descripcion'], "", $value['id'], $id_factura, $descuento,    'd',     $id_user,  $id_moneda,$razon_social,$direccion,$id_comprobante_ncdc,$correo,$afecta,$tiponota,   $motivo,$afecta_ingreso);
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
    }

    public function obtener_credito_pago($id){
		
		$comprobante_model = new Comprobante;
		$credito_pago = $comprobante_model->getCuotaPagoById($id);
		
		echo json_encode($credito_pago);
	}

    public function eliminar_credito_pago($id){

		$cuotaPago = ComprobanteCuotaPago::find($id);		
        $id_comprobante = $cuotaPago->id_comprobante;
        $monto = $cuotaPago->monto;  
        $cuotaPago->estado= "0";
		$cuotaPago->save();

        /*
        $comprobante = Comprobante::find($id_comprobante);
		$comprobante->total_credito= $comprobante->total_credito-$monto;
		$comprobante->save();
*/
        
        $cuotaPagos = ComprobanteCuotaPago::where([
            'id_comprobante' => $id_comprobante
        ])->where('estado', '=', '1')->get();
        $monto=0;

        
        foreach ($cuotaPagos as $index => $row) {

            $monto= $monto+$row->monto; 

        }
       // print_r($monto); exit();


        $comprobante = Comprobante::find($id_comprobante);
        $comprobante->total_credito= $monto;            
        $comprobante->save(); 
		
		//echo "success";
        echo $comprobante->total_credito;

    }

    public function send_credito_pago(Request $request){
	
		$id_user = Auth::user()->id;
		
		if($request->id == 0){
			$cuotaPago = new ComprobanteCuotaPago;
			$cuotaPago->id_usuario_inserta = $id_user;
            $cuotaPago->item = 1;
            
		}else{
			$cuotaPago = ComprobanteCuotaPago::find($request->id);
            $cuotaPago->id_usuario_actualiza = $id_user;            
		}
		
		
		$cuotaPago->fecha = $request->fecha;
        $cuotaPago->fecha_vencimiento = $request->fecha;
        $cuotaPago->id_medio = $request->id_medio;
        $cuotaPago->id_comprobante = $request->id_comprobante;
        $cuotaPago->nro_operacion = $request->nro_operacion;
        $cuotaPago->monto = $request->monto;
        $cuotaPago->save();




       // $comprobante = Comprobante::find($request->id_comprobante);

       // echo($request->id_comprobante);
        //echo($request->monto);
        //exit();


        //echo($comprobante->total_credito);
/*
        if (isset($comprobante->total_credito)){
            $cuotaPagos = ComprobanteCuotaPago::where([
                'id_comprobante' => $request->id_comprobante
            ])->where('estado', '=', '1')->get();
            $monto=0;

            foreach ($cuotaPagos as $index => $row) {

                $monto= $monto+$row->monto; 

            }
            $comprobante->total_credito= $comprobante->total_credito;            
        }else{
            $monto=$request->monto;
            $comprobante->total_credito= $monto;                
        }
        */

        $cuotaPagos = ComprobanteCuotaPago::where([
            'id_comprobante' => $request->id_comprobante
        ])->where('estado', '=', '1')->get();
        $monto=0;

        //echo($cuotaPagos);
        //exit();

        foreach ($cuotaPagos as $index => $row) {            
            $monto= $monto+$row->monto; 
        }

        //echo($monto);

        //$comprobante->total_credito= $comprobante->total_credito; 


        
        $comprobante = Comprobante::find($request->id_comprobante);
        $comprobante->total_credito= $monto; 
        $comprobante->save(); 

        $comprobante1 = Comprobante::find($request->id_comprobante);
        $retante = $comprobante1->total - $monto;
        if ($retante<= 0){
            $comprobante1->estado_pago= "C";
            $comprobante1->save(); 
        }

        echo $monto;
		
    }

}