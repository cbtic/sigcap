<?php 

function convertir_entero($parametro){
		
	$total2_ = $parametro;
	$total2_ = preg_replace('/[^\d.]/','',$total2_);
	$total2_ = floatval($total2_);
	return $total2_;
}

?>