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

//print_r ($valorizacion); exit();

foreach($valorizacion as $key=>$row):
	$id_tipo_afectacion = $row->id_tipo_afectacion;

	$n++;
	$monto = $row->monto;

	if($id_tipo_afectacion=='30'){
		$stotal =str_replace(",","",number_format($monto));
		$igv_   = 0;
	
	}else{
		$stotal = str_replace(",","",number_format($monto/1.18,1));
		$igv_   = str_replace(",","",number_format($stotal * 0.18,1));	
	}

	$disabled = "";
	if($tot_reg!=$n) {

		$disabled = "disabled";
	}
	
	
		
?>
<tr style="font-size:13px" data-toggle="tooltip" data-placement="top" title="<?php echo $row->exonerado_motivo ?>"  >	
	<td class="text-center">
        <div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions">		
			<input type="checkbox" key="<?php echo $key?>" class="mov" name="comprobante_detalles[<?php echo $key?>][id]" value="<?php echo $row->id?>" onchange="calcular_total(this)"  <?php echo $disabled?> />
			<input type="hidden" name="comprobante_detalle[<?php echo $key?>][chek]" value="" class="form-control form-control-sm text-right chek" />
			<input type="hidden" id="comprobante_detalle_id" name="comprobante_detalle[<?php echo $key?>][id]" value="<?php echo $row->id?>" />
			<input type="hidden" name="comprobante_detalle[<?php echo $key?>][fecha]" value="<?php echo $row->fecha?>" />
			<input type="hidden" name="comprobante_detalle[<?php echo $key?>][denominacion]" value="<?php echo $row->concepto?>" />
			<input type="hidden" name="comprobante_detalle[<?php echo $key?>][monto]" value="<?php echo $row->monto?>" />

			<input type="hidden" name="comprobante_detalle[<?php echo $key?>][pu]" value="<?php echo $row->monto?>" />          
            <input type="hidden" id="comprobante_detalle_igv" name="comprobante_detalle[<?php echo $key?>][igv]" value="<?php echo $igv_?>" />
			<input type="hidden" name="comprobante_detalle[<?php echo $key?>][pv]" value="<?php echo $stotal?>" />
            <input type="hidden" id="comprobante_detalle_total" name="comprobante_detalle[<?php echo $key?>][total]" value="<?php echo $row->monto?>" />

			<input type="hidden" name="comprobante_detalle[<?php echo $key?>][moneda]" value="<?php echo $row->moneda?>" />
			<input type="hidden" name="comprobante_detalle[<?php echo $key?>][id_moneda]" value="<?php echo $row->id_moneda?>" />
			<input type="hidden" name="comprobante_detalle[<?php echo $key?>][abreviatura]" value="<?php echo $row->abreviatura?>" />

			<input type="hidden" id="comprobante_detalle_cantidad" name="comprobante_detalle[<?php echo $key?>][cantidad]" value="1" /> 
			<input type="hidden" name="comprobante_detalle[<?php echo $key?>][descuento]" value="0" />   
			<input type="hidden" name="comprobante_detalle[<?php echo $key?>][cod_contable]" value="" /> 
			<input type="hidden" name="comprobante_detalle[<?php echo $key?>][descripcion]" value="<?php echo $row->descripcion?>" />
			<input type="hidden" id="vencio" name="comprobante_detalle[<?php echo $key?>][vencio]" value="<?php echo $row->vencio?>" /> 
			<input type="hidden" name="comprobante_detalle[<?php echo $key?>][id_concepto]" value="<?php echo $row->id_concepto?>" /> 

			<input type="hidden" name="comprobante_detalle[<?php echo $key?>][id_tipo_afectacion]" value="<?php echo $row->id_tipo_afectacion?>" /> 

			<input type="hidden" id="codigo_fraccionamiento" name="comprobante_detalle[<?php echo $key?>][codigo_fraccionamiento]" value="<?php echo $row->codigo_fraccionamiento?>" /> 

			<input type="hidden" name="comprobante_detalle[<?php echo $key?>][item]" value="<?php echo $n?>" /> 
        </div>
    </td>
	<td class="text-left"><?php echo $n?></td>	
	<td class="text-left"><?php echo date("d/m/Y", strtotime($row->fecha_proceso))?></td>
    <td class="text-left"><?php echo $row->descripcion?></td>

	<?php if ($row->vencio=="1"){ ?>
		<td class="text-left" style="color:red" ><?php echo date("d/m/Y", strtotime($row->fecha))?></td>	
	<?php }else{?>
		<td class="text-left" ><?php echo date("d/m/Y", strtotime($row->fecha))?></td>
	<?php }?>

	<td class="text-right"><span class="val_precio"><?php echo number_format($row->valor_unitario,2)?></span></td>
	
	<?php if ($row->otro_concepto=="1"){ ?>
		<td>
		<input type="text" value="<?php echo $row->cantidad?>"  data-toggle="tooltip" data-placement="top" title="Ingresar la cantidad" 
		name="cantidad[]"  id="cantidad" onkeyup="calcular_total_otros(this)" readonly
		class="cantidad input-sm  form-control form-control-sm text-center" style="margin-left:4px; width:80px" />	
		</td>
	<?php }else{?>
		<td class="text-center" ><?php echo $row->cantidad?></td>
	<?php }?>


	<td class="text-right val_total_">	
		<span class="val_descuento" style="float:left"></span>	

		<span class="val_total"><?php echo number_format($monto*$row->cantidad,2)?></span>		
		<span hidden class="val_sub_total"><?php echo number_format($stotal,2)?></span>
		<span hidden class="val_igv"><?php echo number_format($igv_,2)?></span>


		<span hidden class="id_concepto_modal_sel"><?php echo $row->id_concepto?></span>
		<span hidden class="id_concepto"><?php echo $row->id_concepto?></span>
		<span hidden class="id_tipo_afectacion_sel"><?php echo $row->id_tipo_afectacion?></span>

	</td>
	
	<td>	
		

	</td>


</tr>
<?php 
	$total += $row->monto;
	//$total += $total;
	//$stotal += $stotal;
	//$igv_ += $igv_;

	
endforeach;
?>
<tr>
	<input type="hidden" name="deudaTotal" id="deudaTotal" value="<?php echo number_format($total,2)?>" />
<!--
	<th colspan="5" style="text-align:right;padding-right:55px!important;padding-bottom:0px;margin-bottom:0px">Deuda Total</th>
	<td style="padding-bottom:0px;margin-bottom:0px">
		<input type="text" readonly name="deudaTotal" id="deudaTotal" value="<//?php echo number_format($total,2)?>" class="form-control form-control-sm text-right"/>
	</td>
-->
</tr>


