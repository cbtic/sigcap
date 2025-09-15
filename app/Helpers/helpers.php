<?php 

function convertir_entero($parametro){
		
	$total2_ = $parametro;
	$total2_ = preg_replace('/[^\d.]/','',$total2_);
	$total2_ = floatval($total2_);
	return $total2_;
}


function readFunctionPostgres($function, $parameters = null){

	$_parameters = '';
	if (count($parameters) > 0) {
	  $_parameters = implode("','", $parameters);
	  $_parameters = "'" . $_parameters . "',";
	}
	
	DB::select("BEGIN;");
	$cad = "select " . $function . "(" . $_parameters . "'ref_cursor');";
	//echo $cad;
	DB::select($cad);
	$cad = "FETCH ALL IN ref_cursor;";
	$data = DB::select($cad);
	DB::select("END;");
	return $data;
}

function readFunctionPostgresTransaction($function, $parameters = null){
	
	$_parameters = '';
	if (count($parameters) > 0) {
		
		foreach($parameters as $par){
			if(is_string($par))$_parameters .= "'" . $par . "',";
			else $_parameters .= "" . $par . ",";
		}
		if(strlen($_parameters)>1)$_parameters= substr($_parameters,0,-1);
		
	}
	
	$cad = "select " . $function . "(" . $_parameters . ");";
	$data = DB::select($cad);
	return $data[0]->$function;
}


?>