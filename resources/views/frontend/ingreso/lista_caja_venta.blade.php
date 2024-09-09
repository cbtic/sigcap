<table id="tblPlanilla" class="table table-hover table-sm">
	<thead>
		<tr style="font-size:13px">
			<th>Situación</th>
			<th class="text-left">Documento</th>
			<th class="text-right">Total</th>
			<th class="text-right">Cantidad</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$total = 0;
		$cantidad = 0;

		if ($resultado) {
			foreach ($resultado as $row) { ?>
				<tr style="font-size:13px">
					<td class="text-left" style="vertical-align:middle"><?php echo $row->situacion ?></td>
					<td class="text-left" style="vertical-align:middle"><?php echo $row->tipo ?></td>
					<td class="text-right" style="vertical-align:middle"><?php echo number_format($row->total,2) ?></td>
					<td class="text-right" style="vertical-align:middle"><?php echo $row->cantidad ?></td>

				</tr>
		<?php
		
			if ($row->tipo_=="FT" || $row->tipo_=="BV" || $row->tipo_=="NC" || $row->tipo_=="ND") {
				$total += $row->total;
				$cantidad += $row->cantidad;
			}

			}
		}
		?>
	</tbody>
	<tfoot>
		<tr style="font-size:13px">
			<th class="text-left" style="vertical-align:middle" colspan="2">Totales Generales</th>
			<th class="text-right" style="vertical-align:middle;padding-left:0px!important"><?php echo number_format($total,2) ?></th>
			<th class="text-right" style="vertical-align:middle;padding-left:0px!important"><?php echo $cantidad ?></th>
		</tr>
	</tfoot>
</table>