<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>CAP</title>
        <link rel="stylesheet" type="text/css" href="css/pdf.css"/>
        <style>
            .td_left{
                text-align: left !important;
            }
			.td_right{
                text-align: right !important;
            }
            .td_ancho_n{
                width: 3%;
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
                padding-left: 1px !important;
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
				padding:0px 5px;
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
            .info{
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
				position: fixed;
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
            
			<table style="width:100%;margin:0px;padding:0px;padding-bottom:10px">
				<tbody>
					<tr>
						<td class="td_left logo" style="width:70%; text-align:left;">
							<img src="img/logo_encabezado.jpg" width="180" />
						</td>
						<td class="td_left titulo_principal" style="width:15%; text-align:left;padding:0px!important;margin:0px!important">
                            Fecha de Impresi&oacute;n:<br>
                            Hora de Impresi&oacute;n:
						</td>
                        <td class="td_left titulo_principal" style="width:15%; text-align:left;padding:0px!important;margin:0px!important">
                            <?php echo $fecha_actual?><br>
                            <?php echo $hora_actual?>
						</td>
					</tr>
				</tbody>
			</table>
			
        </header>
        <table style="background-color:white !important;border-collapse:collapse;border-spacing:1px;padding-bottom:10px" width="100%">
			<tbody>
                <tr>
                    <td style="padding:0px!important;margin:0px!important; text-align:center" class="titulo_principal">
											
                        <h2>HISTORIAL DE PAGOS</h2>

                    </td>
                </tr>
			</tbody>
		</table>

        <table style="background-color:white !important;border-collapse:collapse;border-spacing:1px;padding-bottom:10px" width="100%">
			<tbody>
                <tr>
                    <td style ="text-align: left" width="10%">
                        N° CAP:
                    </td>
                    <td style ="text-align: left" width="15%">
                        <?php echo $numero_cap?>
                    </td>
                    <td style ="text-align: left" width="75%">
                        <?php echo $nombre_completo?>
                    </td>
                    </tr>
			</tbody>
		</table>
        <table style="background-color:white !important;border-collapse:collapse;border-spacing:1px;padding-bottom:10px" width="100%">
			<tbody>
                <tr>
                    <td style="font-size : 8.5px;padding-left:5px!important" width="60%">
                        *** Las deudas que est&aacute;n registradas en D&oacute;lares se muestra en Soles con el tipo de cambio S/. <?php echo number_format($tipo_cambio[0]->valor_venta, 3, '.', ',')?> del dia <?php echo $tipo_cambio[0]->fecha?>.
                    </td>
                </tr>
			</tbody>
		</table>
        <?php 
        $total_deuda = 0;
        foreach($denominacion_reporte_deudas as $key2=>$k){
        ?>
        <table style="background-color:white !important;border-collapse:collapse;border-spacing:1px;padding-bottom:10px" width="100%">
			<tbody>
                <h2><?php echo ($key2+1)?>. <?php echo $k->denominacion?></h2>
			</tbody>
		</table>
    	
		<table style="background-color:white !important;border-collapse:collapse;border-spacing:1px;" width="100%">
			<tbody>
				<tr>
					<td class="ancho_nro" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:center" width="5%">Item</td>
					<td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:center" width="15%">Descripci&oacute;n</td>
					<td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:center" width="10%">Importe</td>
                    <td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:center" width="10%">F. Vcto</td>
                    <td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:center" width="10%">Fecha Pago</td>
                    <td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:center" width="10%">N° Comprobante</td>
                    <td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:center" width="10%">Forma Pago</td>
                    <td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:center" width="10%">Condici&oacute;n Pago</td>
                    <td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:center" width="10%">N° Cheque/N° Operaci&oacute;n</td>
                    <td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:center" width="10%">Estado Pago</td>
				</tr>
				
				<?php 
                $total_monto_pagado = 0;
                $total_monto_pendiente = 0;
				foreach($datos_reporte_deudas as $key=>$r){
                    if ($k->denominacion == $r->denominacion):
                        $total_deuda +=  $r->importe;
                        if($r->estado_pago=='PENDIENTE'){
                            $total_monto_pendiente += $r->importe;
                        }
                        else if($r->estado_pago=='PAGADO'){
                            $total_monto_pagado += $r->importe;
                        }
				?>
				<tr>
					<td style="border:1px solid #A4A4A4;width:40px;text-align:center"><?php echo $r->row_num?></td>
                    <td class="td_left" style="border:1px solid #A4A4A4;padding-left:5px!important"><?php echo $r->descripcion?></td>
					<td class="td_left" style="border:1px solid #A4A4A4;padding-left:5px!important"><?php echo number_format($r->importe, 2, '.', ',')?></td>
                    <td class="td_left" style="border:1px solid #A4A4A4;padding-left:5px!important"><?php echo date('d/m/Y', strtotime($r->fecha_vencimiento)); ?>
                    <td class="td_left" style="border:1px solid #A4A4A4;padding-left:5px!important"><?php echo date('d/m/Y', strtotime($r->fecha_pago)); ?>
                    <td class="td_left" style="border:1px solid #A4A4A4;padding-left:5px!important"><?php echo $r->comprobante?></td>
                    <td class="td_left" style="border:1px solid #A4A4A4;padding-left:5px!important"><?php echo $r->forma_pago?></td>
                    <td class="td_left" style="border:1px solid #A4A4A4;padding-left:5px!important"><?php echo $r->condicion?></td>
                    <td class="td_left" style="border:1px solid #A4A4A4;padding-left:5px!important"><?php echo $r->nro_operacion?></td>
                    <td class="td_left" style="border:1px solid #A4A4A4;padding-left:5px!important"><?php echo $r->estado_pago?></td>
				</tr>
				<?php
                    endif;
				} 
				?>
				
			</tbody>
		</table>
        <table style="background-color:white !important;border-collapse:collapse;border-spacing:1px;" width="100%">
            <tbody>
                <!--<tr>
					<td class="ancho_nro" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:right" width="80%"><?php //echo 'TOTAL DEUDA PENDIENTE: S/'?></td>
                    <td class="ancho_nro" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:right" width="20%"><?php //echo number_format($total_monto_pendiente, 2, '.', ',')?></td>
				</tr>-->
                <tr>
					<td class="ancho_nro" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:right" width="80%"><?php echo 'TOTAL PAGO '. $k->denominacion .': S/'?></td>
                    <td class="ancho_nro" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:right" width="20%"><?php echo number_format($total_monto_pagado, 2, '.', ',')?></td>
				</tr>
            </tbody>
        </table>
		<?php
        } 
        ?>
        <table style="background-color:white !important;border-collapse:collapse;border-spacing:1px;" width="100%">
            <tbody>
                <tr>
					<td class="ancho_nro" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:right" width="80%"><?php echo 'TOTAL PAGO: S/'?></td>
                    <td class="ancho_nro" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:right" width="20%"><?php echo number_format($total_deuda, 2, '.', ',')?></td>
				</tr>
            </tbody>
        </table>
        
		<!--<table style="margin-top: 10px">
            <tr>
                <td class="td_ancho_espacios"></td>
                <td class="td_ancho_espacios"></td>
            </tr>
        </table>-->
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