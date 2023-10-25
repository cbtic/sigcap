<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Comprobante;
use App\Models\Empresa;
use App\Models\ComprobantDetalle;
use App\Models\TablaMaestra;
use App\Models\Valorizacione;
use App\Models\Persona;

use Auth;

use Illuminate\Http\Request;

class FacturaController extends Controller
{
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


        print_r($request);exit();
        

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

            //print_r($facturad); //exit();

            return view('frontend.factura.create',compact('trans', 'titulo','TipoF', 'facturas','facturad'));
        }
    }
}
