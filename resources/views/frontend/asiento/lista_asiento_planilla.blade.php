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
		$importe_bruto = 0;
		$sub_total = 0;
		$importe_igv = 0;
		$importe_comision_cap = 0;
		$importe_fondo_asistencia = 0;
		$saldo = 0;


		if ($asientoPlanilla) {
			foreach ($asientoPlanilla as $row) { ?>
				<tr style="font-size:13px">
					<td class="text-left" style="vertical-align:middle"><?php echo $row->municipalidad ?></td>
					<td class="text-right" style="vertical-align:middle"><?php echo $row->importe_bruto ?></td>
					<td class="text-right" style="vertical-align:middle"><?php echo $row->importe_igv ?></td>
					<td class="text-right" style="vertical-align:middle"><?php echo $row->importe_comision_cap ?></td>
					<td class="text-right" style="vertical-align:middle"><?php echo $row->importe_fondo_asistencia ?></td>
					<td class="text-right" style="vertical-align:middle"><?php echo $row->saldo ?></td>

					id, 
					id_persona, 
					cuenta, 
					debe, 
					haber, 
					glosa, 
					centro_costo, 
					presupuesto, 
					codigo_financiero, 
					medio_pago, 
					id_tipo_documento, 
					serie, 
					numero, 
					fecha_documento, 
					fecha_vencimiento, 
					id_moneda, 
					tipo_cambio, 
					id_estado_doc, 
					estado, 
					id_usuario_inserta, 
					id_asiento_planilla, 
					id_periodo_comision, i
					d_periodo_comision_detalle

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