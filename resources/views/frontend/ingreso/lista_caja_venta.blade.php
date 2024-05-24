<table id="tblPlanilla" class="table table-hover table-sm">
	<thead>
		<tr style="font-size:13px">
			<th>Situacion</th>
			<th  class="text-right">Documento</th>
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
					<td class="text-right" style="vertical-align:middle"><?php echo $row->tipo ?></td>
					<td class="text-right" style="vertical-align:middle"><?php echo $row->total ?></td>
					<td class="text-right" style="vertical-align:middle"><?php echo $row->cantidad ?></td>

				</tr>
		<?php

				$total += $row->total;
				$cantidad += $row->cantidad;

			}
		}
		?>
	</tbody>
	<tfoot>
		<tr style="font-size:13px">
			<th class="text-left" style="vertical-align:middle" colspan="1">Totales Generales</th>
			<th class="text-right" style="vertical-align:middle;padding-left:0px!important"><?php echo $total ?></th>
			<th class="text-right" style="vertical-align:middle;padding-left:0px!important"><?php echo $cantidad ?></th>
		</tr>
	</tfoot>
</table>