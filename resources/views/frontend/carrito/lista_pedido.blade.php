<input type="hidden" name="id_concepto_modal_sel" id="id_concepto_modal_sel" value="" />
<input type="hidden" name="obligatorio_ultimo_pago" id="obligatorio_ultimo_pago" value="" />
<?php
$total = 0;
$descuento = 0;
$valor_venta_bruto = 0;
$valor_venta = 0;
$igv = 0;
$n = 0;

$ValorUnitario_ = 0;
$ValorVB_ = 0;
$ValorVenta_ = 0;
$Igv_ = 0;
$Total_ = 0;
$tasa_igv_=0.18;
$Cantidad_=1;
$Descuento_ = 0;
$tot_reg = count($pedido);

foreach ($pedido as $key => $row):
	$n++;
	$disabled = "";
	$data = json_decode($row->response);
	if(isset($data->dataMap))$c = preg_split('//', $data->dataMap->TRANSACTION_DATE, -1, PREG_SPLIT_NO_EMPTY);
?>
	<tr style="font-size:13px" data-toggle="tooltip" data-placement="top">
		<td class="text-left"><?php echo $row->purchase_number ?></td>
		<td class="text-left"><?php 
			//echo date("d/m/Y", strtotime($row->fecha_proceso)) 
			if(isset($data->dataMap))echo $c[4].$c[5]."/".$c[2].$c[3]."/".$c[0].$c[1]." ".$c[6].$c[7].":".$c[8].$c[9].":".$c[10].$c[11]; 
		?></td>
		<td class="text-left"><?php echo $row->email ?></td>
		<td class="text-left"><?php if(isset($data->dataMap))echo $data->dataMap->CARD." (".$data->dataMap->BRAND.")"; ?></td>
		<td class="text-left"><?php if(isset($data->order))echo $data->order->amount. " ".$data->order->currency; ?></td>
		<td>
            <a class="btn btn-square link link-icon" href="pedido/show/{{$row->id}}" style="padding-left:35px!important;line-height:37px"><i class="fa fa-search" style="line-height:unset !important;"></i></a>
		</td>

	</tr>
<?php
	//$total += $row->monto;

endforeach;
?>
<tr>
	<input type="hidden" name="deudaTotal" id="deudaTotal" value="<?php //echo number_format($total, 2) ?>" />
	
</tr>

