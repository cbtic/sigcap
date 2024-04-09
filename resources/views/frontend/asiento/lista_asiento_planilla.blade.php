<table id="tblPlanilla" class="table table-hover table-sm">
	<thead>
		<tr style="font-size:13px">
			<th>Cuenta</th>
			<th>Nom. Cuenta</th>                            
			<th class="text-right">Debe</th>
			<th class="text-right">Haber</th>                            
			<th>Moneda</th>
			<th>Tipo Cambio</th>
			<th class="text-right">Equivalente</th>
			<th>Tipo Doc.</th>
			<th>Numero</th>
			<th>Ruc</th>
			<th>Razon Social</th>
			<th>C.C.</th>
			<th>Presupuesto</th>
			<th>F.E</th>
			<th>Glosa</th>
			<th>M. Pago</th>
			<th>Grupo</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$debe = 0;
		$haber = 0;



		if ($asientoPlanilla) {
			foreach ($asientoPlanilla as $key=>$row) { 
				//$debe_ =$row->debe;
				//$debe_ =str_replace(",","",number_format($debe));
				?>
				<tr style="font-size:13px">

					<input type="hidden" name="asiento[<?php echo $key?>][id]" value="<?php echo $row->id?>" />
					<input type="hidden" name="asiento[<?php echo $key?>][id_persona]" value="<?php echo $row->id_persona?>" />
					<input type="hidden" name="asiento[<?php echo $key?>][id_asiento_planilla]" value="<?php echo $row->id_asiento_planilla?>" />
					<input type="hidden" name="asiento[<?php echo $key?>][id_periodo_comision]" value="<?php echo $row->id_periodo_comision?>" />
					<input type="hidden" name="asiento[<?php echo $key?>][id_periodo_comision_detalle]" value="<?php echo $row->id_periodo_comision_detalle?>" />
					<input type="hidden" name="asiento[<?php echo $key?>][id_moneda]" value="<?php echo $row->id_moneda?>" />

					<input type="hidden" name="asiento[<?php echo $key?>][fecha_documento]" value="<?php echo $row->fecha_documento?>" />
					<input type="hidden" name="asiento[<?php echo $key?>][fecha_vencimiento]" value="<?php echo $row->fecha_vencimiento?>" />
					

					<td class="text-left"  style="vertical-align:middle"><?php echo $row->cuenta ?></td>
					<td class="text-left"  style="vertical-align:middle"><?php echo $row->cuenta_den ?></td>
					<td class="text-right" style="vertical-align:middle"><?php echo round($row->debe,3) ?></td>
					<td class="text-right"  style="vertical-align:middle"><?php echo round($row->haber,3) ?></td>
					<td class="text-center" style="vertical-align:middle"><?php echo $row->id_moneda ?></td>
					<td class="text-center"  style="vertical-align:middle"><?php echo $row->tipo_cambio ?></td>
					<td class="text-right"  style="vertical-align:middle"><?php echo round($row->equivalente,2) ?></td>
					<td class="text-left"  style="vertical-align:middle"><?php echo $row->id_tipo_documento ?></td>
					<td class="text-center" style="vertical-align:middle"><?php echo $row->numero_comprobante ?></td>					
					<td class="text-left"  style="vertical-align:middle"><?php echo $row->numero_ruc ?></td>
					<td class="text-left"  style="vertical-align:middle"><?php echo $row->desc_cliente_sunat ?></td>
					<td class="text-left"  style="vertical-align:middle"><?php echo $row->centro_costo ?></td>
					<td class="text-left" style="vertical-align:middle"><?php echo $row->presupuesto ?></td>
					<td class="text-left"  style="vertical-align:middle"><?php echo $row->codigo_financiero ?></td>
					<td class="text-left" style="vertical-align:middle"><?php echo $row->glosa ?></td>
					<td class="text-left" style="vertical-align:middle"><?php echo $row->medio_pago ?></td>
					<td class="text-left" style="vertical-align:middle"><?php echo $row->id_grupo ?></td>
					



				</tr>
		<?php
				if($row->debe!='')$debe += $row->debe;
				if($row->haber!='')$haber += $row->haber;
			}
		}
		?>
	</tbody>
	<tfoot>
		<tr style="font-size:13px">
			<th class="text-left" style="vertical-align:middle" colspan="1">Totales Generales</th>
			<th class="text-right" style="vertical-align:middle;padding-left:0px!important"></th>
			<th class="text-right" style="vertical-align:middle;padding-left:0px!important"><?php echo round($debe,3) ?></th>
			<th class="text-right" style="vertical-align:middle;padding-left:0px!important"><?php echo round($haber,3) ?></th>			
			<th class="text-right" style="vertical-align:middle;padding-left:0px!important"></th>
			<th class="text-right" style="vertical-align:middle;padding-left:0px!important"></th>
		</tr>
	</tfoot>
</table>