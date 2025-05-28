<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>CAP</title>
        <link rel="stylesheet" type="text/css" href="css/pdf.css"  />
        <style>
            .td_left{
                text-align: left !important;
            }
			.td_right{
                text-align: right !important;
            }
            .td_ancho_n{
                width: 4%;
                text-align: center
            }
            .cantidad{
                width: 11%;
            }
            .td_ancho_espacios{
                width: 5%;
            }
            .td_ancho_codigo{
                width: 10%;
            } 
            .td_ancho_especialidad{
                width: 25%;
            }
            td{
                padding-left: 2px !important;
            }
            table{
                font-size: 10px !important; 
                font-family: Roboto,"Helvetica Neue",Helvetica,Arial,sans-serif;
            }
            .ancho_producto{
                width: 45%;
            }
            .titulos{
                font-weight: bold;
				padding:0px 10px;
            }
            h2{
                font-size: 15px !important
            }
            .titulo_principal{
                 width: 80%;
            }
            .logo{
                 width: 10%;
            }
            .grado{
                width: 14%;
            }
            .dni{
                width: 8%;
            }
			.rectangulo{
				padding:3px
			}
			
			footer{
				margin-bottom:0px;
				padding:0px;
				/*position: fixed;*/
				height:60px;
				line-height:60px;
				text-align:left;
				border:0px;
				margin-left:10px;
				font-size: 7px !important;
				font-family:Arial, Helvetica, sans-serif;
				color:#000000!important
			}
			
			header {
                position: fixed;
                top: 0px;
                left: 10px;
                right: 10px;
                height: 50px;
            }
        </style>
    </head>
	
    <body style="font-size: 11px; font-family: arial;border:1px solid #A4A4A4;padding:90px 10px 10px 10px">
		<header>
            
			<table style="margin:0px;padding:0px;padding-bottom:10px" width="100%">
				<tbody>
					<tr>
						<td colspan="1" class="td_left logo">
							<img src="img/logo_encabezado.jpg" width="180" />
						</td>
						<td colspan="2" class="titulo_principal" style="padding:0px!important;margin:0px!important">
							<table style="margin:0px!important;padding:0px!important;">
								<tbody style="padding:0px!important;margin:0px!important">
									<tr style="padding:0px!important;margin:0px!important">
										<td style="padding:0px!important;margin:0px!important" align="center" colspan="11" class="titulo_principal">
											<h2>PLANILLA DE DELEGADOS</h2>
										</td>
									</tr>
									<tr style="padding:0px!important;margin:0px!important">
										<td style="padding:0px!important;margin:0px!important;width:100px;text-align:right">Año:</td>
										<td style="padding:0px!important;margin:0px!important;width:60px;text-align:left"><?php echo $anio?></td>
										<td style="padding:0px!important;margin:0px!important;text-align:right"></td>
										<td style="padding:0px!important;margin:0px!important;width:100px;text-align:right">Mes:</td>
										<td style="padding:0px!important;margin:0px!important;width:60px;text-align:left"><?php echo $mes?></td>
										<td style="padding:0px!important;margin:0px!important;text-align:right"></td>
										<td style="padding:0px!important;margin:0px!important;width:100px;text-align:right">N&deg; C&oacute;mputo:</td>
										<td style="padding:0px!important;margin:0px!important;width:60px;text-align:left"><?php if($computoSesion)echo $computoSesion->id?></td>
										<td style="padding:0px!important;margin:0px!important;width:100px;text-align:right">Fecha C&oacute;mputo:</td>
										<td style="padding:0px!important;margin:0px!important;width:60px;text-align:left"><?php if($computoSesion)echo date("d-m-Y", strtotime($computoSesion->fecha))?></td>
									</tr>
								</tbody>
							</table>
						</td>
					</tr>
				</tbody>
			</table>
			
        </header>
        
    	
		<table style="background-color:white !important;border-collapse:collapse;border-spacing:1px;" width="100%">
			<tbody>
				<tr>
					<td class="ancho_nro" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:center">N°</td>
					<td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;text-align:left;padding-top:5px;padding-bottom:5pxM;text-align:center" width="25%">Delegado</td>
					<td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:center" width="10%">Municipio</td>
					<td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:center" width="12%">Sesiones</td>
					<td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:center" width="12%">Sub Total</td>
					<td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:center" width="12%">Adelanto  
			<br />Con Rec. 
			<br />Hon.</td>
					<td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:center" width="12%">(+) 
			<br />Reintegro</td>
					<td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:center" width="12%">(+) 
			<br />Adicional 
			<br />por 
			<br />Coordinador</td>
					<td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:center" width="12%">Total 
			<br />Honorario 
			<br />Bruto por 
			<br />Sesiones</td>
					<td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:center" width="12%">Movilidad 
			<br />Por Sesion 
			<br />Regular</td>
			<td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:center" width="12%">Total 
			<br />Honorario por 
			<br />Movilidad</td>
			<td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:center" width="12%">Reintegro
			<br />por Pago a Asesores
			<br />Asumido por el CAP RL</td>
			<td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:center" width="12%">Total Honorario
			<br />Bruto</td>
			<td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:center" width="12%">I.R. 4TA 
			<br />8.00 %</td>
			<td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:center" width="12%">Total Honorario
			<br />Neto</td>
			<td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:center" width="12%">Dscto</td>
			<td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:center" width="12%">Saldo</td>
				</tr>
				
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
				 
				foreach($planilla as $key=>$row){
				?>
				<tr>
					<td style="border:1px solid #A4A4A4;width:40px;text-align:center"><?php echo ($key+1)?></td>
					<td class="td_left" style="border:1px solid #A4A4A4;padding-left:5px!important"><?php echo $row->delegado?></td>
					<td class="td_right" style="border:1px solid #A4A4A4;padding-right:10px!important"><?php echo $row->municipalidad?></td>
					<td class="td_right" style="border:1px solid #A4A4A4;padding-right:10px!important"><?php echo $row->sesiones?></td>
					
					<td class="td_right" style="border:1px solid #A4A4A4;padding-right:10px!important"><?php echo number_format($row->sub_total,2)?></td>
					<td class="td_right" style="border:1px solid #A4A4A4;padding-right:10px!important"><?php echo number_format($row->adelanto,2)?></td>
					<td class="td_right" style="border:1px solid #A4A4A4;padding-right:10px!important"><?php echo number_format($row->reintegro,2)?></td>
					<td class="td_right" style="border:1px solid #A4A4A4;padding-right:10px!important"><?php echo number_format($row->coordinador,2)?></td>
					<td class="td_right" style="border:1px solid #A4A4A4;padding-right:10px!important"><?php echo number_format($row->total_bruto_sesiones,2)?></td>
					<td class="td_right" style="border:1px solid #A4A4A4;padding-right:10px!important"><?php echo number_format($row->movilidad_sesion,2)?></td>
					
					<td class="td_right" style="border:1px solid #A4A4A4;padding-right:10px!important"><?php echo number_format($row->total_movilidad,2)?></td>
					<td class="td_right" style="border:1px solid #A4A4A4;padding-right:10px!important"><?php echo number_format($row->reintegro_asesor,2)?></td>
					<td class="td_right" style="border:1px solid #A4A4A4;padding-right:10px!important"><?php echo number_format($row->total_bruto,2)?></td>
					<td class="td_right" style="border:1px solid #A4A4A4;padding-right:10px!important"><?php echo number_format($row->ir_cuarta,2)?></td>
					<td class="td_right" style="border:1px solid #A4A4A4;padding-right:10px!important"><?php echo number_format($row->total_honorario,2)?></td>
					<td class="td_right" style="border:1px solid #A4A4A4;padding-right:10px!important"><?php echo number_format($row->descuento,2)?></td>
					<td class="td_right" style="border:1px solid #A4A4A4;padding-right:10px!important"><?php echo number_format($row->saldo,2)?></td>
					
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
						//$sesiones_asesor++;
						$sesiones_asesor+=$row->sesiones;
					}
				
				} 
				?>
				
			</tbody>
			<tfoot>
				<tr style="font-size:13px">
					<th class="text-left" style="vertical-align:middle" colspan="3">Totales Generales</th>
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
			
				
		<?php
			
		$sesiones_asesor = 0.5 * $sesiones_asesor;
		$fondo_comun_saldo = (isset($fondo_comun->saldo))?$fondo_comun->saldo:0;
		$fondo_comun_neto = ($fondo_comun_saldo) - $reintegro - $total_movilidad - $coordinador;
		$total_sesiones = $sesiones - $sesiones_asesor;
		
		$importe_por_sesion=0;
		if($total_sesiones>0)$importe_por_sesion = $fondo_comun_neto / $total_sesiones;
		
		?>
		
			<tr>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
			
            <tr>
                <td colspan="4">Saldo a favor de los Delegados Pro Fondo Comun</td>
                <td colspan="2"><?php echo number_format($fondo_comun_saldo,2)?></td>
				<td colspan="5"></td>
				<td colspan="4">Fondo Comun</td>
				<td colspan="2"><?php echo number_format($fondo_comun_neto,2)?></td>
            </tr>
			<tr>
                <td colspan="4">Menos Pagos a Destiempo de Meses pasados</td>
                <td colspan="2"><?php echo number_format($reintegro,2)?></td>
				<td colspan="5"></td>
				<td colspan="4">Total acumulado de Sesiones del Mes</td>
				<td colspan="2"><?php echo $sesiones?></td>
            </tr>
			<tr>
                <td colspan="4">Menos movilidad a Delegados</td>
                <td colspan="2"><?php echo number_format($total_movilidad,2)?></td>
				<td colspan="5"></td>
				<td colspan="4">Sesion de asesores a cargo del CAP RL</td>
				<td colspan="2"><?php echo $sesiones_asesor?></td>
            </tr>
			<tr>
                <td colspan="4">Menos Pago Fijo a Coordinadores</td>
                <td colspan="2"><?php echo number_format($coordinador,2)?></td>
				<td colspan="5"></td>
				<td colspan="4">SALDO FINAL DE SESIONES</td>
				<td colspan="2"><?php echo $total_sesiones?></td>
            </tr>
			<tr>
                <td colspan="4">Monto Neto = Fondo Comun</td>
                <td colspan="2"><?php echo number_format($fondo_comun_neto,2)?></td>
				<td colspan="5"></td>
				<td colspan="4">Importe por Sesion</td>
				<td colspan="2"><?php echo number_format($importe_por_sesion,2)?></td>
            </tr>
		</tfoot>			
		</table>
		
        <footer>
        <script type="text/php">
            if (isset($pdf)) {
				$x = 510;
				$y = 815;
                $text = "Pagina {PAGE_NUM} de {PAGE_COUNT}";
                $font = null;
                $size = 8;
                $color = array(.16, .16, .16);
                $word_space = 0.0;  //  default
                $char_space = 0.0;  //  default
                $angle = 0.0;   //  default
                $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
            }
        </script>
		</footer>
    </body>
</html>