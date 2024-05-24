<table id="tblPlanilla" class="table table-hover table-sm">
	<thead>
		<tr style="font-size:13px">
			<th>Condición</th>
			<th  class="text-right">Toral US$</th>
			<th class="text-right">Total S/</th>
			<th class="text-right">Total en Soles</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$total_us = 0;
		$total_tc = 0;
		$total_soles = 0;

		if ($resultado) {
			foreach ($resultado as $row) { ?>
				<tr style="font-size:13px">
					<td class="text-left" style="vertical-align:middle"><?php echo $row->condicion ?></td>
					<td class="text-right" style="vertical-align:middle"><?php echo $row->total_us ?></td>
					<td class="text-right" style="vertical-align:middle"><?php echo $row->total_tc ?></td>
					<td class="text-right" style="vertical-align:middle"><?php echo $row->total_soles ?></td>

				</tr>
		<?php

				$total_us += $row->total_us;
				$total_tc += $row->total_tc;
				$total_soles += $row->total_soles;


			}
		}
		?>
	</tbody>
	<tfoot>
		<tr style="font-size:13px">
			<th class="text-left" style="vertical-align:middle" colspan="1">Totales Generales</th>
			<th class="text-right" style="vertical-align:middle;padding-left:0px!important"><?php echo $total_us ?></th>
			<th class="text-right" style="vertical-align:middle;padding-left:0px!important"><?php echo $total_tc ?></th>
			<th class="text-right" style="vertical-align:middle;padding-left:0px!important"><?php echo $total_soles ?></th>
		</tr>
	</tfoot>
</table>