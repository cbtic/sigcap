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
					<td class="text-left" style="vertical-align:middle">
                        <a href="javascript:void(0);"  onclick="abrirPdfMunicipalidad('<?php echo addslashes($row->id_ubigeo); ?>', <?php echo $anio; ?>, <?php echo $mes; ?>)"
                           style="font-size: 12px; text-decoration: underline; color: blue;">
                            <?php echo htmlspecialchars($row->municipalidad); ?>
                        </a>
                    </td>
					<td class="text-right" style="vertical-align:middle"><?php echo number_format($row->importe_bruto,2) ?></td>
					<td class="text-right" style="vertical-align:middle"><?php echo number_format($row->importe_igv,2) ?></td>
					<td class="text-right" style="vertical-align:middle"><?php echo number_format($row->importe_comision_cap,2) ?></td>
					<td class="text-right" style="vertical-align:middle"><?php echo number_format($row->importe_fondo_asistencia,2) ?></td>
					<td class="text-right" style="vertical-align:middle"><?php echo number_format($row->saldo,2) ?></td>
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
			<th class="text-right" style="vertical-align:middle;padding-left:0px!important"><?php echo number_format($importe_bruto,2) ?></th>
			<th class="text-right" style="vertical-align:middle;padding-left:0px!important"><?php echo number_format($importe_igv,2) ?></th>
			<th class="text-right" style="vertical-align:middle;padding-left:0px!important"><?php echo number_format($importe_comision_cap,2) ?></th>
			<th class="text-right" style="vertical-align:middle;padding-left:0px!important"><?php echo number_format($importe_fondo_asistencia,2) ?></th>
			<th class="text-right" style="vertical-align:middle;padding-left:0px!important"><?php echo number_format($saldo,2) ?></th>
		</tr>
	</tfoot>
</table>

<script>
function abrirPdfMunicipalidad(id_ubigeo,anio,mes) {
	//alert(municipalidad+anio+mes);
	var href = '/fondoComun/fondoComun_pdf/'+id_ubigeo+'/'+anio+'/'+mes;
	window.open(href, '_blank');
}
</script>
