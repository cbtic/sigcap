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

$tot_reg = count($carrito_deuda);
//$m = $tot_reg;

foreach ($carrito_deuda as $key => $row):
	$id_tipo_afectacion = $row->id_tipo_afectacion;

	$n++;
	$monto = $row->monto;
	$PrecioVenta_= $row->valor_unitario;
	$Descuento_  = $row->descuento_porcentaje;
	$Cantidad_ = $row->cantidad;
	
	if ($id_tipo_afectacion == '30') {
		$igv_   = 0;

		$ValorUnitario_ = str_replace(",", "", number_format($PrecioVenta_,  2));
		$ValorVB_ = str_replace(",", "", number_format($ValorUnitario_ * $Cantidad_, 2));
		$ValorVenta_ = str_replace(",", "", number_format($ValorVB_ - $Descuento_, 2));
		$Igv_ = 0;		
		$Total_ = str_replace(",", "", number_format($ValorVenta_ + $Igv_, 2));
		$stotal = $Total_;

	} else {

		$ValorUnitario_ = $PrecioVenta_ /(1+$tasa_igv_);
		$ValorVB_ = $ValorUnitario_ * $Cantidad_;
		$ValorVenta_ = $ValorVB_ - $Descuento_;
		$Igv_ = $ValorVenta_ * $tasa_igv_;		
		$Total_ = $ValorVenta_ + $Igv_;	
		
		$ValorUnitario_ = str_replace(",", "", number_format($ValorUnitario_, 2));
		$ValorVB_ = str_replace(",", "", number_format($ValorVB_, 2));
		$ValorVenta_ = str_replace(",", "", number_format($ValorVenta_, 2));
		$Igv_ = str_replace(",", "", number_format($Igv_, 2));		
		$Total_ = str_replace(",", "", number_format($Total_, 2));
		
		$stotal = $Total_;
		$igv_   = $Igv_;

	}

	$disabled = "";
	$obligatorio = $row->obligatorio_ultimo_pago;
	/*
	if ($tot_reg != $n) {
		if ($obligatorio =="1")$disabled = "disabled";
	}
	*/

	if ($n!=1) {
		if ($obligatorio =="1")$disabled = "disabled";
	}

?>
	<tr style="font-size:13px" data-toggle="tooltip" data-placement="top" title="<?php echo $row->exonerado_motivo ?>">
		<!--
		<td class="text-center">
			<div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions">
				

				<input type="checkbox" key="<?php echo $key ?>" class="mov" name="comprobante_detalles[<?php echo $key ?>][id]" value="<?php echo $row->id ?>" onchange="calcular_total(this)" <?php echo $disabled ?> />
				
				<input type="hidden" name="comprobante_detalle[<?php echo $key ?>][chek]" value="" class="form-control form-control-sm text-right chek" />
				<input type="hidden" id="comprobante_detalle_id" name="comprobante_detalle[<?php echo $key ?>][id]" value="<?php echo $row->id ?>" />
				<input type="hidden" name="comprobante_detalle[<?php echo $key ?>][fecha]" value="<?php echo $row->fecha ?>" />
				<input type="hidden" name="comprobante_detalle[<?php echo $key ?>][denominacion]" value="<?php echo $row->concepto ?>" />
	
				<input type="hidden" name="comprobante_detalle[<?php echo $key ?>][moneda]" value="<?php echo $row->moneda ?>" />
				<input type="hidden" name="comprobante_detalle[<?php echo $key ?>][id_moneda]" value="<?php echo $row->id_moneda ?>" />
				<input type="hidden" name="comprobante_detalle[<?php echo $key ?>][abreviatura]" value="<?php echo $row->abreviatura ?>" />

				<input type="hidden" id="comprobante_detalle_cantidad" name="comprobante_detalle[<?php echo $key ?>][cantidad]" value="1" />
				<input type="hidden" name="comprobante_detalle[<?php echo $key ?>][descuento]" value="0" />
				<input type="hidden" name="comprobante_detalle[<?php echo $key ?>][cod_contable]" value="" />
				<input type="hidden" id="descripcion" name="comprobante_detalle[<?php echo $key ?>][descripcion]" value="<?php echo $row->descripcion ?>" />
				<input type="hidden" id="vencio" name="comprobante_detalle[<?php echo $key ?>][vencio]" value="<?php echo $row->vencio ?>" />
				<input type="hidden" name="comprobante_detalle[<?php echo $key ?>][id_concepto]" value="<?php echo $row->id_concepto ?>" />
				<input type="hidden" name="comprobante_detalle[<?php echo $key ?>][id_tipo_afectacion]" value="<?php echo $row->id_tipo_afectacion ?>" />
				<input type="hidden" id="codigo_fraccionamiento" name="comprobante_detalle[<?php echo $key ?>][codigo_fraccionamiento]" value="<?php echo $row->codigo_fraccionamiento ?>" />
				<input type="hidden" name="comprobante_detalle[<?php echo $key ?>][item]" value="<?php echo $n ?>" />
			
			<input type="hidden" id="comprobante_detalle_precio_unitario" name="comprobante_detalle[<?php echo $key?>][precio_unitario]" value="<?php echo $ValorUnitario_?>" />
			<input type="hidden" id="comprobante_detalle_sub_total" name="comprobante_detalle[<?php echo $key?>][sub_total]" value="<?php echo $ValorVenta_?>" />
			<input type="hidden" id="comprobante_detalle_valor_venta_bruto" name="comprobante_detalle[<?php echo $key?>][valor_venta_bruto]" value="<?php echo $ValorVB_?>" />

			<input type="hidden" id="comprobante_detalle_monto" name="comprobante_detalle[<?php echo $key?>][monto]" value="<?php echo $Total_?>" />
			<input type="hidden" id="comprobante_detalle_pu" name="comprobante_detalle[<?php echo $key?>][pu]" value="<?php echo $ValorUnitario_?>" />
			<input type="hidden" id="comprobante_detalle_igv" name="comprobante_detalle[<?php echo $key?>][igv]" value="<?php echo $Igv_?>" />
			<input type="hidden" id="comprobante_detalle_pv" name="comprobante_detalle[<?php echo $key?>][pv]" value="<?php echo $PrecioVenta_?>" />
			<input type="hidden" id="comprobante_detalle_vv" name="comprobante_detalle[<?php echo $key?>][vv]" value="<?php echo $ValorVenta_?>" />			
			<input type="hidden" id="comprobante_detalle_total" name="comprobante_detalle[<?php echo $key?>][total]" value="<?php echo $Total_?>" />

			<input type="hidden" id="comprobante_detalle_unidad_medida_item" name="comprobante_detalle[<?php echo $key?>][unidad_medida_item]" value="ZZ" />
			<input type="hidden" id="comprobante_detalle_unidad_medida_comercial" name="comprobante_detalle[<?php echo $key?>][unidad_medida_comercial]" value="SERV" />

			</div>
		</td>
		-->
		<td class="text-left"><?php echo $n ?></td>
		<td class="text-left"><?php echo date("d/m/Y", strtotime($row->fecha_proceso)) ?></td>
		<td class="text-left"><?php echo $row->descripcion ?></td>

		<?php if ($row->vencio == "1") { ?>
			<td class="text-left" style="color:red"><?php echo date("d/m/Y", strtotime($row->fecha)) ?></td>
		<?php } else { ?>
			<td class="text-left"><?php echo date("d/m/Y", strtotime($row->fecha)) ?></td>
		<?php } ?>

		<?php if ($row->otro_concepto == "1") { ?>
			<td>
				<input type="text" value="<?php echo number_format($row->valor_unitario, 2) ?>" data-toggle="tooltip" data-placement="top" title="Ingresar la Precio"
					name="precio[]" id="precio" onkeyup="calcular_total_otros(this)" readonly
					class="precio input-sm  form-control form-control-sm text-center" style="margin-left:4px; width:80px" />
			</td>
		<?php } else { ?>			
			<td class="text-center"><?php echo number_format($row->valor_unitario, 2) ?></td>		
		<?php } ?>

		<?php if ($row->otro_concepto == "1") { ?>
			<td>
				<input type="text" value="<?php echo $row->cantidad ?>" data-toggle="tooltip" data-placement="top" title="Ingresar la cantidad"
					name="cantidad[]" id="cantidad" onkeyup="calcular_total_otros(this)" readonly
					class="cantidad input-sm  form-control form-control-sm text-center" style="margin-left:4px; width:80px" />
			</td>
		<?php } else { ?>
			<td class="text-center"><?php echo $row->cantidad ?></td>
		<?php } ?>


		<td class="text-right val_total_">
			<span class="val_descuento" style="float:left"></span>

			<span class="val_total"><?php echo $Total_ ?></span>
			<span hidden class="val_sub_total"><?php echo $ValorVenta_ ?></span>
			<span hidden class="val_igv"><?php echo $Igv_ ?></span>

			<span hidden class="id_concepto_modal_sel"><?php echo $row->id_concepto ?></span>
			<span hidden class="id_concepto"><?php echo $row->id_concepto ?></span>
			<span hidden class="id_tipo_afectacion_sel"><?php echo $row->id_tipo_afectacion ?></span>
			<span hidden class="obligatorio_ultimo_pago"><?php echo $row->obligatorio_ultimo_pago ?></span>

		</td>

		<td style="min-width:220px">
			<button class="btn btn-square link link-icon" <?php echo $disabled?> href="javascript:void(0);" onclick="agregarAlCarrito({{ $row->id }})" style="padding-left:35px!important;line-height:37px"><i class="fa fa-shopping-cart" style="line-height:unset !important;"></i></button>
            <button class="btn btn-square link link-icon" <?php echo $disabled?> href="javascript:void(0);" onclick="verItem({{ $row->id }})" style="padding-left:35px!important;line-height:37px"><i class="fa fa-search" style="line-height:unset !important;"></i></button>
		</td>

	</tr>
<?php
	$total += $row->monto;

endforeach;
?>
<tr>
	<input type="hidden" name="deudaTotal" id="deudaTotal" value="<?php echo number_format($total, 2) ?>" />
	
</tr>

