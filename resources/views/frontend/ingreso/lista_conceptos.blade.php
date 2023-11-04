<?php 
$total = 0;
$descuento = 0;
$valor_venta_bruto = 0;
$valor_venta = 0;
$igv = 0;

foreach($conceptos as $key=>$row):
	$monto = $row->importe;
	$stotal = str_replace(",","",number_format($monto/1.18,1));
	$igv_   = str_replace(",","",number_format($stotal * 0.18,1));
?>
<tr style="font-size:13px">
	<td class="text-center">
        <div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions">		
			<input type="checkbox" class="mov" name="conceptos[<?php echo $key?>][id]" value="<?php echo $row->id?>" onchange="calcular_total(this)" />
			<input type="hidden" name="concepto[<?php echo $key?>][id]" value="<?php echo $row->id?>" />
			<input type="hidden" name="concepto[<?php echo $key?>][codigo]" value="<?php echo $row->codigo?>" />
			<input type="hidden" name="concepto[<?php echo $key?>][denominacion]" value="<?php echo $row->denominacion?>" />
			<input type="hidden" name="concepto[<?php echo $key?>][importe]" value="<?php echo $row->importe?>" />

			<input type="hidden" name="concepto[<?php echo $key?>][pu]" value="<?php echo $row->importe?>" />          
            <input type="hidden" name="concepto[<?php echo $key?>][igv]" value="<?php echo $igv_?>" />
			<input type="hidden" name="concepto[<?php echo $key?>][pv]" value="<?php echo $stotal?>" />
            <input type="hidden" name="concepto[<?php echo $key?>][total]" value="<?php echo $row->importe?>" />

			<input type="hidden" name="concepto[<?php echo $key?>][moneda]" value="<?php echo $row->moneda?>" />
			<input type="hidden" name="concepto[<?php echo $key?>][id_moneda]" value="<?php echo $row->id_moneda?>" />
			<input type="hidden" name="concepto[<?php echo $key?>][cantidad]" value="1" /> 
			<input type="hidden" name="concepto[<?php echo $key?>][descuento]" value="" />   
			<input type="hidden" name="concepto[<?php echo $key?>][centro_costo]" value="centro_costo" />   
											
        </div>
    </td>
	
	<td class="text-left"><?php echo $row->codigo?></td>
    <td class="text-left"><?php echo $row->denominacion?></td>
	<td class="text-left"><?php echo $row->moneda?></td>
	<td class="text-left"><?php echo $row->importe?></td>

	<!--
	<td class="text-right val_total_">	
		<span class="val_descuento" style="float:left"></span>
		<span class="val_total"><?php //echo $row->importe?></span>	
		<input type="hidden" class="tipo_factura" value="FT" />
	</td>
-->

</tr>
<?php 
	$total += $row->importe;	
endforeach;
?>

<tr>
	<th colspan="3" style="text-align:right;padding-right:55px!important;padding-bottom:0px;margin-bottom:0px">Deuda Total</th>
	<td style="padding-bottom:0px;margin-bottom:0px">
		<input type="text" readonly name="deudaTotal" id="deudaTotal" value="<?php echo $total?>" class="form-control form-control-sm text-right"/>
	</td>
</tr>
