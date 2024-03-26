<table id="tblPlanilla" class="table table-hover table-sm">
	<thead>
		<tr style="font-size:13px">
			<th>Cuenta</th>
			<th>Nombre</th>                            
			<th class="text-right">Debe</th>
			<th class="text-right">Haber</th>                            
			<th>Moneda</th>
			<th>Tipo Cambio</th>
			<th class="text-right">Equivalente</th>
			<th>Tipo Doc.</th>
			<th>Numero</th>
			<th>Código</th>
			<th>Razon Social</th>
			<th>C.C.</th>
			<th>Presupuesto</th>
			<th>F.E</th>
			<th>Glosa</th>
			<th>M. Pago</th>
			<th>Estado</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$debe = 0;
		$haber = 0;



		if ($asientoPlanilla) {
			foreach ($asientoPlanilla as $key=>$row) { ?>
				<tr style="font-size:13px">

					<input type="hidden" name="asiento[<?php echo $key?>][id]" value="<?php echo $row->id?>" />
					<input type="hidden" name="asiento[<?php echo $key?>][id_persona]" value="<?php echo $row->id_persona?>" />
					<input type="hidden" name="asiento[<?php echo $key?>][id_asiento_planilla]" value="<?php echo $row->id_asiento_planilla?>" />
					<input type="hidden" name="asiento[<?php echo $key?>][id_periodo_comision]" value="<?php echo $row->id_periodo_comision?>" />
					<input type="hidden" name="asiento[<?php echo $key?>][id_periodo_comision_detalle]" value="<?php echo $row->id_periodo_comision_detalle?>" />
					<input type="hidden" name="asiento[<?php echo $key?>][id_moneda]" value="<?php echo $row->id_moneda?>" />
					

					<td class="text-left"  style="vertical-align:middle"><?php echo $row->cuenta ?></td>
					<td class="text-left"  style="vertical-align:middle"><?php echo $row->persona ?></td>
					<td class="text-right" style="vertical-align:middle"><?php echo $row->debe ?></td>
					<td class="text-right"  style="vertical-align:middle"><?php echo $row->haber ?></td>
					<td class="text-left" style="vertical-align:middle"><?php echo $row->glosa ?></td>
					<td class="text-left"  style="vertical-align:middle"><?php echo $row->centro_costo ?></td>
					<td class="text-left" style="vertical-align:middle"><?php echo $row->presupuesto ?></td>
					<td class="text-left"  style="vertical-align:middle"><?php echo $row->codigo_financiero ?></td>
					<td class="text-left" style="vertical-align:middle"><?php echo $row->medio_pago ?></td>
					<td class="text-left"  style="vertical-align:middle"><?php echo $row->id_tipo_documento ?></td>
					<td class="text-center" style="vertical-align:middle"><?php echo $row->serie ?></td>
					<td class="text-center"  style="vertical-align:middle"><?php echo $row->numero ?></td>
					<td class="text-left" style="vertical-align:middle"><?php echo $row->fecha_documento ?></td>
					<td class="text-left"  style="vertical-align:middle"><?php echo $row->fecha_vencimiento ?></td>
					<td class="text-left" style="vertical-align:middle"><?php echo $row->id_moneda ?></td>
					<td class="text-right"  style="vertical-align:middle"><?php echo $row->tipo_cambio ?></td>
					<td class="text-right" style="vertical-align:middle"><?php echo $row->id_estado_doc ?></td>

				</tr>
		<?php
				$debe += $row->debe;
				$haber += $row->haber;
			}
		}
		?>
	</tbody>
	<tfoot>
		<tr style="font-size:13px">
			<th class="text-left" style="vertical-align:middle" colspan="1">Totales Generales</th>
			<th class="text-right" style="vertical-align:middle;padding-left:0px!important"><?php echo $debe ?></th>
			<th class="text-right" style="vertical-align:middle;padding-left:0px!important"><?php echo $haber ?></th>
			<th class="text-right" style="vertical-align:middle;padding-left:0px!important"></th>
			<th class="text-right" style="vertical-align:middle;padding-left:0px!important"></th>
			<th class="text-right" style="vertical-align:middle;padding-left:0px!important"></th>
		</tr>
	</tfoot>
</table>