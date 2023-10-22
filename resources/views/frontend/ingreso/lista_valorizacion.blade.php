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
			
        </div>
    </td>
	<td class="text-left"><?php echo date("d/m/Y", strtotime($row->fecha))?></td>
    <td class="text-left"><?php echo $row->concepto//$row->vsm_smodulod?>
	<td class="text-right"><?php echo $row->monto//$row->vsm_smodulod?>
	
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
