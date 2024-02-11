<input type="hidden" name="id_concepto_modal_sel" id="id_concepto_modal_sel" value="" />
<?php 
$total = 0;
$descuento = 0;
$valor_venta_bruto = 0;
$valor_venta = 0;
$igv = 0;
$n = 0;

//$count = $valorizacion->rowCount();
$tot_reg = count($valorizacion);
//print_r ("cuenta registros ->".$count);

foreach($valorizacion as $key=>$row):
	

	$n++;
	$monto = $row->monto;
	$stotal = str_replace(",","",number_format($monto/1.18,1));
	$igv_   = str_replace(",","",number_format($stotal * 0.18,1));
	$disabled = "";
	if($tot_reg!=$n) {

		$disabled = "disabled";
	}
	
	
		
?>
<tr style="font-size:13px">
	<td class="text-center">
        <div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions">		
			<input type="checkbox" key="<?php echo $key?>" class="mov" name="comprobante_detalles[<?php echo $key?>][id]" value="<?php echo $row->id?>" onchange="calcular_total(this)"  <?php echo $disabled?> />
			<input type="hidden" name="comprobante_detalle[<?php echo $key?>][chek]" value="" class="form-control form-control-sm text-right chek" />
			<input type="hidden" name="comprobante_detalle[<?php echo $key?>][id]" value="<?php echo $row->id?>" />
			<input type="hidden" name="comprobante_detalle[<?php echo $key?>][fecha]" value="<?php echo $row->fecha?>" />
			<input type="hidden" name="comprobante_detalle[<?php echo $key?>][denominacion]" value="<?php echo $row->concepto?>" />
			<input type="hidden" name="comprobante_detalle[<?php echo $key?>][monto]" value="<?php echo $row->monto?>" />

			<input type="hidden" name="comprobante_detalle[<?php echo $key?>][pu]" value="<?php echo $row->monto?>" />          
            <input type="hidden" name="comprobante_detalle[<?php echo $key?>][igv]" value="<?php echo $igv_?>" />
			<input type="hidden" name="comprobante_detalle[<?php echo $key?>][pv]" value="<?php echo $stotal?>" />
            <input type="hidden" name="comprobante_detalle[<?php echo $key?>][total]" value="<?php echo $row->monto?>" />

			<input type="hidden" name="comprobante_detalle[<?php echo $key?>][moneda]" value="<?php echo $row->moneda?>" />
			<input type="hidden" name="comprobante_detalle[<?php echo $key?>][id_moneda]" value="<?php echo $row->id_moneda?>" />
			<input type="hidden" name="comprobante_detalle[<?php echo $key?>][abreviatura]" value="<?php echo $row->abreviatura?>" />

			<input type="hidden" name="comprobante_detalle[<?php echo $key?>][cantidad]" value="1" /> 
			<input type="hidden" name="comprobante_detalle[<?php echo $key?>][descuento]" value="" />   
			<input type="hidden" name="comprobante_detalle[<?php echo $key?>][cod_contable]" value="" /> 
			<input type="hidden" name="comprobante_detalle[<?php echo $key?>][descripcion]" value="<?php echo $row->descripcion?>" />
			<input type="hidden" name="comprobante_detalle[<?php echo $key?>][vencio]" value="<?php echo $row->vencio?>" /> 
			<input type="hidden" name="comprobante_detalle[<?php echo $key?>][id_concepto]" value="<?php echo $row->id_concepto?>" /> 

			<input type="hidden" name="comprobante_detalle[<?php echo $key?>][item]" value="<?php echo $n?>" /> 
        </div>
    </td>
	
	<td class="text-left"><?php echo date("d/m/Y", strtotime($row->fecha_proceso))?></td>
    <td class="text-left"><?php echo $row->descripcion?></td>
	<?php if ($row->vencio=="1"){ ?>
		<td class="text-left" style="color:red" ><?php echo date("d/m/Y", strtotime($row->fecha_proceso))?></td>	
	<?php }else{?>
		<td class="text-left" ><?php echo date("d/m/Y", strtotime($row->fecha_proceso))?></td>
	<?php }?>

	<td class="text-left"><?php echo $row->abreviatura?></td>
	<td class="text-right val_total_">	
		<span class="val_descuento" style="float:left"></span>	
		<span class="val_total"><?php echo $row->monto?></span>
		
		<input type="hidden" class="id_concepto_modal_sel" value="<?php echo $row->id_concepto?>" />
	</td>

</tr>
<?php 
	$total += $row->monto;
	
endforeach;
?>

<tr>
	<th colspan="5" style="text-align:right;padding-right:55px!important;padding-bottom:0px;margin-bottom:0px">Deuda Total</th>
	<td style="padding-bottom:0px;margin-bottom:0px">
		<input type="text" readonly name="deudaTotal" id="deudaTotal" value="<?php echo $total?>" class="form-control form-control-sm text-right"/>
	</td>
</tr>
