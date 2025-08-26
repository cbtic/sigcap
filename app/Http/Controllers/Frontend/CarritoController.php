<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Carrito;

class CarritoController extends Controller
{
    
    public function index(){
        /*
        $regione_model = new Regione;
		$tablaMaestra_model = new TablaMaestra;
		$region = $regione_model->getRegionAll();
		$situacion_cliente = $tablaMaestra_model->getMaestroByTipo(14);
		$categoria_cliente = $tablaMaestra_model->getMaestroByTipo(18);
		$act_gremial_cliente = $tablaMaestra_model->getMaestroByTipo(46);
		*/
		return view('frontend.carrito.all'/*,compact('region','situacion_cliente','categoria_cliente','act_gremial_cliente')*/);

    }

    public function detalle(){
        /*
        $regione_model = new Regione;
		$tablaMaestra_model = new TablaMaestra;
		$region = $regione_model->getRegionAll();
		$situacion_cliente = $tablaMaestra_model->getMaestroByTipo(14);
		$categoria_cliente = $tablaMaestra_model->getMaestroByTipo(18);
		$act_gremial_cliente = $tablaMaestra_model->getMaestroByTipo(46);
		*/
		$carrito_model = new Carrito;
		$carrito_items = $carrito_model->getCarritoDetalle(1);
		return view('frontend.carrito.all_detalle',compact('carrito_items'/*,'region','situacion_cliente','categoria_cliente','act_gremial_cliente'*/));

    }

    public function item(){
        /*
        $regione_model = new Regione;
		$tablaMaestra_model = new TablaMaestra;
		$region = $regione_model->getRegionAll();
		$situacion_cliente = $tablaMaestra_model->getMaestroByTipo(14);
		$categoria_cliente = $tablaMaestra_model->getMaestroByTipo(18);
		$act_gremial_cliente = $tablaMaestra_model->getMaestroByTipo(46);
		*/
		return view('frontend.carrito.item'/*,compact('region','situacion_cliente','categoria_cliente','act_gremial_cliente')*/);

    }

}
