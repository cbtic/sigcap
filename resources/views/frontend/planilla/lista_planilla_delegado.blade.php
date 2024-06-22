
<div class="row" style="padding-left:10px">
	<div class="col-lg-1">
		<label class="control-label form-control-sm">N&deg; C&oacute;mputo</label>
		<input id="num_computo" name="num_computo" class="form-control form-control-sm" value="<?php echo $computoSesion->id?>" type="text" readonly="readonly">
	</div>
	<div class="col-lg-1">
		<label class="control-label form-control-sm">Fecha C&oacute;mputo</label>
		<input id="fecha_computo" name="fecha_computo" class="form-control form-control-sm" value="<?php echo date("d-m-Y", strtotime($computoSesion->fecha))?>" type="text" readonly="readonly">
	</div>
</div>

<table id="tblPlanilla" class="table table-hover table-sm">
	<thead>
	<tr style="font-size:13px">
		<th>Delegado</th>
		<th>Municipio</th>
		<th class="text-center">Sesiones</th>
		<th class="text-center">Sub Total</th>
		<th class="text-center">Adelanto  
			<br />Con Rec. 
			<br />Hon.
		</th>
		<th class="text-center">(+) 
			<br />Reintegro</th>
		<th class="text-center">(+) 
			<br />Adicional 
			<br />por 
			<br />Coordinador</th>
		<th class="text-center">Total 
			<br />Honorario 
			<br />Bruto por 
			<br />Sesiones</th>
		<th class="text-center">Movilidad 
			<br />Por Sesion 
			<br />Regular</th>
		<th class="text-center">Total 
			<br />Honorario por 
			<br />Movilidad</th>
		<th class="text-center">Reintegro
			<br />por Pago a Asesores
			<br />Asumido por el CAP RL</th>
		<th class="text-center">Total Honorario
			<br />Bruto</th>
		<th class="text-center">I.R. 4TA 
			<br />8.00 %</th>
		<th class="text-center">Total Honorario
			<br />Neto</th>
		<th class="text-center">Dscto</th>
		<th class="text-center">Saldo</th>
		<th>OBSERVACI&Oacute;N</th>
	</tr>
	</thead>
	<tbody>
		<?php 
		
		function redondear_dos_decimal($valor) {
		   $float_redondeado=round($valor * 100) / 100;
		   return $float_redondeado;
		}
		
		$sesiones=0;
		$sesiones_asesor=0;
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
			foreach($planilla as $row){
			?>
		<tr style="font-size:13px">
			<td class="text-left" style="vertical-align:middle"><?php echo $row->delegado?></td>
			<td class="text-left" style="vertical-align:middle"><?php echo $row->municipalidad?></td>
			<td class="text-center" style="vertical-align:middle"><?php echo $row->sesiones?></td>
			<td class="text-right" style="vertical-align:middle"><?php echo number_format($row->sub_total,2)?></td>
			<td class="text-right" style="vertical-align:middle"><?php echo number_format($row->adelanto,2)?></td>
			<td class="text-right" style="vertical-align:middle"><?php echo number_format($row->reintegro,2)?></td>
			<td class="text-right" style="vertical-align:middle"><?php echo number_format($row->coordinador,2)?></td>
			<td class="text-right" style="vertical-align:middle"><?php echo number_format($row->total_bruto_sesiones,2)?></td>
			<td class="text-right" style="vertical-align:middle"><?php echo number_format($row->movilidad_sesion,2)?></td>
			<td class="text-right" style="vertical-align:middle"><?php echo number_format($row->total_movilidad,2)?></td>
			<td class="text-right" style="vertical-align:middle"><?php echo number_format($row->reintegro_asesor,2)?></td>
			<td class="text-right" style="vertical-align:middle"><?php echo number_format($row->total_bruto,2)?></td>
			<td class="text-right" style="vertical-align:middle"><?php echo number_format($row->ir_cuarta,2)?></td>
			<td class="text-right" style="vertical-align:middle"><?php echo number_format($row->total_honorario,2)?></td>
			<td class="text-right" style="vertical-align:middle"><?php echo number_format($row->descuento,2)?></td>
			<td class="text-right" style="vertical-align:middle"><?php echo number_format($row->saldo,2)?></td>
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
				
				if($row->reintegro_asesor>0){
					$sesiones_asesor++;
				}
				
			}
		}
		?>
	</tbody>
	<tfoot>
		<tr style="font-size:13px">
			<th class="text-left" style="vertical-align:middle" colspan="2">Totales Generales</th>
			<th class="text-center" style="vertical-align:middle"><?php echo $sesiones?></th>
			<th class="text-right" style="vertical-align:middle"><?php echo number_format($sub_total,2)?></th>
			<th class="text-right" style="vertical-align:middle"><?php echo number_format($adelanto,2)?></th>
			<th class="text-right" style="vertical-align:middle"><?php echo number_format($reintegro,2)?></th>
			<th class="text-right" style="vertical-align:middle"><?php echo number_format($coordinador,2)?></th>
			<th class="text-right" style="vertical-align:middle"><?php echo number_format($total_bruto_sesiones,2)?></th>
			<th class="text-right" style="vertical-align:middle"><?php echo number_format($movilidad_sesion,2)?></th>
			<th class="text-right" style="vertical-align:middle"><?php echo number_format($total_movilidad,2)?></th>
			<th class="text-right" style="vertical-align:middle"><?php echo number_format($reintegro_asesor,2)?></th>
			<th class="text-right" style="vertical-align:middle"><?php echo number_format($total_bruto,2)?></th>
			<th class="text-right" style="vertical-align:middle"><?php echo number_format($ir_cuarta,2)?></th>
			<th class="text-right" style="vertical-align:middle"><?php echo number_format($total_honorario,2)?></th>
			<th class="text-right" style="vertical-align:middle"><?php echo number_format($descuento,2)?></th>
			<th class="text-right" style="vertical-align:middle"><?php echo number_format($saldo,2)?></th>
			<th class="text-left"></th>
		</tr>
	</tfoot>
</table>


	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
			<?php
			
			$sesiones_asesor = 0.5 * $sesiones_asesor;
			$fondo_comun_saldo = (isset($fondo_comun->saldo))?$fondo_comun->saldo:0;
			$fondo_comun_neto = ($fondo_comun_saldo) - $reintegro - $total_movilidad - $coordinador;
			$total_sesiones = $sesiones - $sesiones_asesor;
			
			$importe_por_sesion=0;
			if($total_sesiones>0)$importe_por_sesion = $fondo_comun_neto / $total_sesiones;
			
			?>
			<div class="row">
				<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
				Saldo a favor de los Delegados Pro Fondo Comun
				</div>
				<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
				<?php echo number_format($fondo_comun_saldo,2)?>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
				Menos Pagos a Destiempo de Meses pasados
				</div>
				<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
				<?php echo number_format($reintegro,2)?>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
				Menos movilidad a Delegados
				</div>
				<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
				<?php echo number_format($total_movilidad,2)?>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
				Menos Pago Fijo a Coordinadores
				</div>
				<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
				<?php echo number_format($coordinador,2)?>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
				Monto Neto = Fondo Comun
				</div>
				<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
				<?php echo number_format($fondo_comun_neto,2)?>
				</div>
			</div>
		
		</div>
		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
			
			<div class="row">
				<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
				Fondo Comun
				</div>
				<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
				<?php echo number_format($fondo_comun_neto,2)?>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
				Total acumulado de Sesiones del Mes
				</div>
				<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
				<?php echo $sesiones?>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
				Sesion de asesores a cargo del CAP RL
				</div>
				<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
				<?php echo $sesiones_asesor?>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
				SALDO FINAL DE SESIONES
				</div>
				<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
				<?php echo $total_sesiones?>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
				Importe por Sesion
				</div>
				<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
				<?php echo number_format($importe_por_sesion,2)?>
				</div>
			</div>
			
		</div>
	</div>
	


