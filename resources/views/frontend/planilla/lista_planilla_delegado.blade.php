
<table id="tblPlanilla" class="table table-hover table-sm">
	<thead>
	<tr style="font-size:13px">
		<th>Delegado</th>
		<th>Municipio</th>
		<th>Sesiones</th>
		<th>Sub Total</th>
		<th>Adelanto  
			<br />Con Rec. 
			<br />Hon.
		</th>
		<th>(+) 
			<br />Reintegro</th>
		<th>(+) 
			<br />Adicional 
			<br />por 
			<br />Coordinador</th>
		<th>Total 
			<br />Honorario 
			<br />Bruto por 
			<br />Sesiones</th>
		<th>Movilidad 
			<br />Por Sesion 
			<br />Regular</th>
		<th>Total 
			<br />Honorario por 
			<br />Movilidad</th>
		<th>Reintegro
			<br />por Pago a Asesores
			<br />Asumido por el CAP RL</th>
		<th>Total Honorario
			<br />Bruto</th>
		<th>I.R. 4TA 
			<br />8.00 %</th>
		<th>Total Honorario
			<br />Neto</th>
		<th>Dscto</th>
		<th>Saldo</th>
		<th>OBSERVACI&Oacute;N</th>
	</tr>
	</thead>
	<tbody>
		<?php 
		$sesiones=0;
		$sub_total=0;
		$adelanto=0;
		$reintegro=0;
		$coordinador=0;
		$total_bruto_sesiones=0;
		$movilidad_sesion=0;
		$total_movilidad=0;
		$reintegro_asesor=0;
		$total_bruto=0;
		$ir_cuarta=0;
		$total_honorario=0;
		$descuento=0;
		$saldo=0;
		
		if($planilla){
			foreach($planilla as $row){?>
		<tr style="font-size:13px">
			<td class="text-left" style="vertical-align:middle"><?php echo $row->delegado?></td>
			<td class="text-left" style="vertical-align:middle"><?php echo $row->municipalidad?></td>
			<td class="text-left" style="vertical-align:middle"><?php echo $row->sesiones?></td>
			<td class="text-left" style="vertical-align:middle"><?php echo $row->sub_total?></td>
			<td class="text-left" style="vertical-align:middle"><?php echo $row->adelanto?></td>
			<td class="text-left" style="vertical-align:middle"><?php echo $row->reintegro?></td>
			<td class="text-left" style="vertical-align:middle"><?php echo $row->coordinador?></td>
			<td class="text-left" style="vertical-align:middle"><?php echo $row->total_bruto_sesiones?></td>
			<td class="text-left" style="vertical-align:middle"><?php echo $row->movilidad_sesion?></td>
			<td class="text-left" style="vertical-align:middle"><?php echo $row->total_movilidad?></td>
			<td class="text-left" style="vertical-align:middle"><?php echo $row->reintegro_asesor?></td>
			<td class="text-left" style="vertical-align:middle"><?php echo $row->total_bruto?></td>
			<td class="text-left" style="vertical-align:middle"><?php echo $row->ir_cuarta?></td>
			<td class="text-left" style="vertical-align:middle"><?php echo $row->total_honorario?></td>
			<td class="text-left" style="vertical-align:middle"><?php echo $row->descuento?></td>
			<td class="text-left" style="vertical-align:middle"><?php echo $row->saldo?></td>
			<td class="text-left" style="vertical-align:middle"><?php echo $row->observaciones?></td>	
		</tr>
		<?php 
		
				$sesiones+=$row->sesiones;
				$sub_total+=$row->sub_total;
				$adelanto+=$row->adelanto;
				$reintegro+=$row->reintegro;
				$coordinador+=$row->coordinador;
				$total_bruto_sesiones+=$row->total_bruto_sesiones;
				$movilidad_sesion+=$row->movilidad_sesion;
				
				$total_movilidad+=$row->total_movilidad;
				$reintegro_asesor+=$row->reintegro_asesor;
				$total_bruto+=$row->total_bruto;
				$ir_cuarta+=$row->ir_cuarta;
				$total_honorario+=$row->total_honorario;
				$descuento+=$row->descuento;
				$saldo+=$row->saldo;
			}
		}
		?>
	</tbody>
	<tfoot>
		<tr style="font-size:13px">
			<th class="text-left" style="vertical-align:middle" colspan="2">Totales Generales</th>
			<th class="text-left" style="vertical-align:middle;padding-left:0px!important"><?php echo $sesiones?></th>
			<th class="text-left" style="vertical-align:middle;padding-left:0px!important"><?php echo $sub_total?></th>
			<th class="text-left" style="vertical-align:middle;padding-left:0px!important"><?php echo $adelanto?></th>
			<th class="text-left" style="vertical-align:middle;padding-left:0px!important"><?php echo $reintegro?></th>
			<th class="text-left" style="vertical-align:middle;padding-left:0px!important"><?php echo $coordinador?></th>
			<th class="text-left" style="vertical-align:middle;padding-left:0px!important"><?php echo $total_bruto_sesiones?></th>
			<th class="text-left" style="vertical-align:middle;padding-left:0px!important"><?php echo $movilidad_sesion?></th>
			<th class="text-left" style="vertical-align:middle;padding-left:0px!important"><?php echo $total_movilidad?></th>
			<th class="text-left" style="vertical-align:middle;padding-left:0px!important"><?php echo $reintegro_asesor?></th>
			<th class="text-left" style="vertical-align:middle;padding-left:0px!important"><?php echo $total_bruto?></th>
			<th class="text-left" style="vertical-align:middle;padding-left:0px!important"><?php echo $ir_cuarta?></th>
			<th class="text-left" style="vertical-align:middle;padding-left:0px!important"><?php echo $total_honorario?></th>
			<th class="text-left" style="vertical-align:middle;padding-left:0px!important"><?php echo $descuento?></th>
			<th class="text-left" style="vertical-align:middle;padding-left:0px!important"><?php echo $saldo?></th>
			<th></th>
		</tr>
	</tfoot>
</table>


