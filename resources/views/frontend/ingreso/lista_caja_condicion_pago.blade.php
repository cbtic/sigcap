<table id="tlbCondicion" class="table table-hover table-sm">
	<thead>
		<tr style="font-size:13px">
			<th>Condición</th>
			<!--<th  class="text-right">Total US$</th>
			<th class="text-right">Total S/</th>
-->
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
					<!--
					<td class="text-right" style="vertical-align:middle"><//?php echo number_format($row->total_us,2) ?></td>
					<td class="text-right" style="vertical-align:middle"><//?php echo number_format($row->total_tc,2) ?></td>
			-->
					<td class="text-right" style="vertical-align:middle"><?php echo number_format($row->total_soles,2) ?></td>

				</tr>
		<?php
			//if ($row->tipo=="FT" || $row->tipo=="BV") {
				$total_us += $row->total_us;
				$total_tc += $row->total_tc;
				$total_soles += $row->total_soles;
			//}


			}
		}
		?>
	</tbody>
	<tfoot>
		<tr style="font-size:13px">
			<th class="text-left" style="vertical-align:middle" colspan="1">Totales Generales</th>
			<!--
			<th class="text-right" style="vertical-align:middle;padding-left:0px!important"><//?php echo number_format($total_us,2) ?></th>
			<th class="text-right" style="vertical-align:middle;padding-left:0px!important"><//?php echo number_format($total_tc,2) ?></th>
	-->
			<th class="text-right" style="vertical-align:middle;padding-left:0px!important"><?php echo number_format($total_soles,2) ?></th>
		</tr>
	</tfoot>
</table>