<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>CAP</title>
        <link rel="stylesheet" type="text/css" href="css/pdf.css"  />
        <style>
			/*
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
			*/
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
											<h2>REPORTE DE MOVILIDAD DEL PERIODO
											<?php echo $periodo->descripcion?>
											<?php //echo $mesEnLetras?> <?php //echo $anio?> </h2>
										</td>
									</tr>
									<tr style="padding:0px!important;margin:0px!important">
										<td style="padding:0px!important;margin:0px!important;text-align:right">Año:</td>
										<td style="padding:0px!important;margin:0px!important;width:60px;text-align:left"><?php echo $anio?></td>
										<td style="padding:0px!important;margin:0px!important;text-align:right"></td>
										<td style="padding:0px!important;margin:0px!important;width:100px;text-align:right">Mes:</td>
										<td style="padding:0px!important;margin:0px!important;width:60px;text-align:left">
										<?php 
										/*
										setlocale(LC_ALL, 'es_ES');
										$dateObj   = DateTime::createFromFormat('!m', $mes);
										$mes_ = strftime('%B', $dateObj->getTimestamp());
										echo $mes_;
										*/
										?>
										<?php echo $mesEnLetras?>
										</td>
										<td style="padding:0px!important;margin:0px!important;text-align:right"></td>
										<td style="padding:0px!important;margin:0px!important;width:100px;text-align:right">Fecha Computo:</td>
										<td style="padding:0px!important;margin:0px!important;width:60px;text-align:left"><?php echo date("d-m-Y")?></td>
									</tr>
								</tbody>
							</table>
						</td>
					</tr>
				</tbody>
			</table>
        
    	<!--
		<table style="background-color:white !important;border-collapse:collapse;border-spacing:1px;" width="100%">
			<tbody>
				<tr>
					<td class="ancho_nro" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:center">N°</td>
					<td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;text-align:left;padding-top:5px;padding-bottom:5pxM;text-align:center" width="25%">Municipalidad</td>
					<td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:center" width="10%">Importe por Distrito S/.</td>
					<td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:center" width="12%">Importe Mes Actual S/.</td>
				</tr>
				
				<?php 
				//foreach($movilidad as $key=>$r){
				?>
				<tr>
					<td style="border:1px solid #A4A4A4;width:40px;text-align:center"><?php //echo ($key+1)?></td>
					<td class="td_left" style="border:1px solid #A4A4A4;padding-left:5px!important"><?php //echo $r->comision?></td>
					<td class="td_right" style="border:1px solid #A4A4A4;padding-right:10px!important"><?php //echo $r->monto?></td>
					<td class="td_right" style="border:1px solid #A4A4A4;padding-right:10px!important"><?php //echo ($r->cantidad>0)?$r->monto:"0"?></td>
				</tr>
				<?php
				//} 
				?>
				
			</tbody>
		</table>
		-->
		
		
		
		<table style="background-color:white !important;border-collapse:collapse;border-spacing:1px;" width="100%">
			<tbody>
				<tr>
					<td class="ancho_nro" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:center">N°</td>
					<td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;text-align:left;padding-top:5px;padding-bottom:5px;text-align:center">Municipalidad</td>
					
					<?php 
					foreach($meses as $keym=>$m){
					?>	
					<td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:center"><?php echo $m->mes?></td>
					<?php
					} 
					?>
				</tr>
				
				<?php 
				foreach($movilidad as $key=>$r){
				?>
				<tr>
					<td style="border:1px solid #A4A4A4;width:40px;text-align:center"><?php echo ($key+1)?></td>
					<td class="td_left" style="border:1px solid #A4A4A4;padding-left:5px!important"><?php echo $r->comision?></td>
					
					<?php 
					foreach($meses as $keym=>$m){
						$monto = 0;
						//$movilidadMes = \App\Models\ComisionMovilidade::getMovilidadMesByPeriodoAndMunicipalidad($id_periodo,$anio,$m->mes_,$r->id_municipalidad_integrada);
						if((int)$m->mes_<=(int)$mes){
							$movilidadMes = \App\Models\ComisionMovilidade::getMovilidadMesByPeriodoAndMunicipalidad($id_periodo,$m->anio_,/*$anio,*/$m->mes_,$r->id_municipalidad_integrada);
							$monto = (isset($movilidadMes->monto))?$movilidadMes->monto:"0";
						}
					?>
					<td class="td_right" style="border:1px solid #A4A4A4;padding-right:10px!important"><?php echo $monto?></td>
					<?php
					} 
					?>					
				</tr>
				<?php
                }//}} 
				?>
				
			</tbody>
		</table>
		
    </body>
</html>