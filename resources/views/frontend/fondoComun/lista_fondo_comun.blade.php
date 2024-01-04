<table id="tblPlanilla" class="table table-hover table-sm">
	<thead>
		<tr style="font-size:13px">
			<th>Municipalidad</th>
			<th  class="text-right">Importe Bruto</th>
			<th class="text-right">IGV 18%</th>
			<th class="text-right">Comisi&oacute;n CAP RL 30%</th>
			<th class="text-right">Fondo Asistencia 2%</th>
			<th class="text-right">Saldo a favor de Delegados</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$importe_bruto = 0;
		$sub_total = 0;
		$importe_igv = 0;
		$importe_comision_cap = 0;
		$importe_fondo_asistencia = 0;
		$saldo = 0;


		if ($fondoComun) {
			foreach ($fondoComun as $row) { ?>
				<tr style="font-size:13px">
					<td class="text-left" style="vertical-align:middle"><?php echo $row->municipalidad ?></td>
					<td class="text-right" style="vertical-align:middle"><?php echo $row->importe_bruto ?></td>
					<td class="text-right" style="vertical-align:middle"><?php echo $row->importe_igv ?></td>
					<td class="text-right" style="vertical-align:middle"><?php echo $row->importe_comision_cap ?></td>
					<td class="text-right" style="vertical-align:middle"><?php echo $row->importe_fondo_asistencia ?></td>
					<td class="text-right" style="vertical-align:middle"><?php echo $row->saldo ?></td>
				</tr>
		<?php

				$importe_bruto += $row->importe_bruto;
				$importe_igv += $row->importe_igv;
				$importe_comision_cap += $row->importe_comision_cap;
				$importe_fondo_asistencia += $row->importe_fondo_asistencia;
				$saldo += $row->saldo;
			}
		}
		?>
	</tbody>
	<tfoot>
		<tr style="font-size:13px">
			<th class="text-left" style="vertical-align:middle" colspan="1">Totales Generales</th>
			<th class="text-right" style="vertical-align:middle;padding-left:0px!important"><?php echo $importe_bruto ?></th>
			<th class="text-right" style="vertical-align:middle;padding-left:0px!important"><?php echo $importe_igv ?></th>
			<th class="text-right" style="vertical-align:middle;padding-left:0px!important"><?php echo $importe_comision_cap ?></th>
			<th class="text-right" style="vertical-align:middle;padding-left:0px!important"><?php echo $importe_fondo_asistencia ?></th>
			<th class="text-right" style="vertical-align:middle;padding-left:0px!important"><?php echo $saldo ?></th>
		</tr>
	</tfoot>
</table>