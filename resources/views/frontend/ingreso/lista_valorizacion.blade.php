<input type="hidden" name="tipo_factura" id="tipo_factura" value="" />
<?php 
$total = 0;
$descuento = 0;
$valor_venta_bruto = 0;
$valor_venta = 0;
$igv = 0;

foreach($valorizacion as $key=>$row):?>
<tr style="font-size:13px">
	<td class="text-center">
        <div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions">		
			<input type="checkbox" class="mov" name="comprobante_detalle[<?php echo $key?>][id]" value="<?php echo $row->id?>" onchange="calcular_total(this)" />
			<input type="hidden" name="comprobante_detalle[<?php echo $key?>][fecha]" value="<?php echo $row->fecha?>" />
			<input type="hidden" name="comprobante_detalle[<?php echo $key?>][concepto]" value="<?php echo $row->concepto?>" />
			<input type="hidden" name="comprobante_detalle[<?php echo $key?>][monto]" value="<?php echo $row->monto?>" />
			<input type="hidden" name="comprobante_detalle[<?php echo $key?>][moneda]" value="<?php echo $row->moneda?>" />


        </div>
    </td>
	<td class="text-left"><?php echo date("d/m/Y", strtotime($row->fecha))?></td>
    <td class="text-left"><?php echo $row->concepto//$row->vsm_smodulod?>
	
	
	</td>
	<td class="text-right val_total_">
	
	<span class="val_descuento" style="float:left"></span>
	<span class="val_total"><?php echo $row->monto?></span>
	<input type="hidden" class="tipo_factura" value="FT" />
	</td>

</tr>
<?php 
	$total += $row->monto;

	
endforeach;
?>

<tr>
	<th colspan="3" style="text-align:right;padding-right:55px!important;padding-bottom:0px;margin-bottom:0px">Deuda Total</th>
	<td style="padding-bottom:0px;margin-bottom:0px">
		<input type="text" readonly name="deudaTotal" id="deudaTotal" value="<?php echo $total?>" class="form-control form-control-sm text-right"/>
	</td>
</tr>
