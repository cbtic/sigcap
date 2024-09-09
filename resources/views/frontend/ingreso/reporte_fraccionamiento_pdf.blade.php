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
			<table style="margin:0px;padding:0px;padding-bottom:10px">
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
                                            <h2>Reporte de Deuda al: <?php echo $fecha_actual?> (en nuevos soles) </h2>
                                        </td>
                                    </tr>
                                    <tr style="padding:0px!important;margin:0px!important">
                                        <td style="padding:0px!important;margin:0px!important;width:100px;text-align:right">CAP:</td>
                                        <td style="padding:0px!important;margin:0px!important;width:60px;text-align:left"><?php echo $numero_cap?></td>
                                        <td style="padding:0px!important;margin:0px!important;text-align:right"></td>
                                        <td style="padding:0px!important;margin:0px!important;width:60px;text-align:right">Arquitecto:</td>
                                        <td style="padding:0px!important;margin:0px!important;width:100px;text-align:left"><?php echo $nombre_completo?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        </header>

        <table style="background-color:white !important;border-collapse:collapse;border-spacing:1px;padding-bottom:10px" width="100%">
			<tbody>
                <h2>1. DEUDA POR CUOTAS (FRACCIONABLE)</h2>
			</tbody>
		</table>
    	
		<table style="background-color:white !important;border-collapse:collapse;border-spacing:1px;" width="100%">
			<tbody>
                
				<tr>
                <td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:center" width="10%">ITEM</td>
                    <td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:center" width="60%">DESCRIPCIÓN</td>            
					<td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:center" width="20%">IMPORTE</td>
				</tr>
<!--
                <tr>
                <td class="td_left" style="border:1px solid #A4A4A4;padding-left:5px!important">VENTAS</td>
				</tr>
		-->		
				<?php 
                $item = 0;
                $total_monto = 0;
				foreach($deuda_cuota_fraccionamiento as $key=>$r){
                    $total_monto += $r->monto;
                    $item++;
                
				?>
				<tr>
                    <td class="td_left" style="border:1px solid #A4A4A4;padding-left:5px!important"><?php echo ($item)?></td>
                    <td class="td_left" style="border:1px solid #A4A4A4;padding-left:5px!important"><?php echo ($r->descripcion)?></td>
                    <td class="td_right" style="border:1px solid #A4A4A4;padding-left:5px!important"><?php echo  number_format($r->monto, 2, '.', ',');?></td>
				</tr>
				<?php
				} 
				?>
				
			</tbody>
		</table>

        <table class="table table-hover table-sm" style="width:35%!important;padding-top:15px" align="right">
            <thead>
                
                <tr style="font-size:13px">
                    <th class="td_left" style="background:#E5E5E5;border:1px solid #A4A4A4;padding-left:5px!important;width:70%">Total</th>
                    <th class="td_right" style="border:1px solid #A4A4A4;padding-left:5px!important"><span id="sesion_delegados"><?php echo number_format($total_monto, 2, '.', ',');?></span></th>
                </tr>
				
            </thead>
		</table>


        <table class="table table-hover table-sm" style="width:100%!important;padding-top:10px" align="center">
            <thead>
                
            <tr style="font-size:10px">
                <th class="td_left" style="border:0px solid #A4A4A4;padding-left:5px!important" align="center">DOY MI CONFORMIDAD AL REPORTE DE DEUDA ARRIBA MOSTRADO, ASCENDENTE A S/. <?php echo number_format($total_monto, 2, '.', ',');?>, Y ACEPTO ACOGERME AL FRACCIONAMIENTO DE LA DEUDA.</th>                    
            </tr>

            <tr style="font-size:10px">
                <th class="td_left" style="border:0px solid #A4A4A4;padding-left:5px!important" align="center">DECLARO CONOCER QUE EL FRACCIONAMIENTO ME ES OTORGADO POR UNICA VEZ Y QUE LA CONDICION DE HABILITACIÓN PROFESIONAL LA CONSERVARE SOLO SI, EN LO SUCESIVO, ME ENCUENTRO AL DIA CON EL PAGO DE LA CUOTA DE FRACCIONAMIENTO MAS LA CUOTA DEL MISMO MES.</th>                    
            </tr>
				
            </thead>
		</table>


        <table style="background-color:white !important;border-collapse:collapse;border-spacing:1px;padding-bottom:10px" width="100%">
			<tbody>
                <h2>CRONOGRAMA DE FRACCIONAMIENTO (N° 1)</h2>
			</tbody>
		</table>

        <table style="background-color:white !important;border-collapse:collapse;border-spacing:1px;" width="100%">
			<tbody>
                <tr>
                    <td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:center" width="50%">CONCEPTO</td>
                    <td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:center" width="25%">FECHA VENCIMIENTO</td>
					<td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:center" width="25%">IMPORTE</td>
				</tr>  

				
				<?php 
                
                $total_monto_f = 0;
				foreach($cronograma_fraccionamiento as $key=>$f){
                $total_monto_f += $f->monto;

                $fecha_texto = $f->fecha;
                // Convertir el texto en un objeto DateTime
                $fecha = new DateTime($fecha_texto);
                // Formatear la fecha en el formato deseado (por ejemplo, d-m-Y)
                $fecha_formateada = $fecha->format("d/m/Y");
                
				?>
				<tr>

                    <td class="td_left" style="border:1px solid #A4A4A4;padding-left:5px!important"><?php echo ($f->descripcion)?></td>
                    <td class="td_center" style="border:1px solid #A4A4A4;padding-left:5px!important"><?php echo $fecha_formateada ?></td>
                    <td class="td_right" style="border:1px solid #A4A4A4;padding-left:5px!important"><?php echo number_format($f->monto, 2, '.', ',');?></td>
				</tr>
				<?php
				} 
				?>
				
			</tbody>
		</table>
        <table class="table table-hover table-sm" style="width:35%!important;padding-top:15px" align="right">
            <thead>
                
                <tr style="font-size:13px">
                    <th class="td_left" style="background:#E5E5E5;border:1px solid #A4A4A4;padding-left:5px!important;width:70%">Total</th>
                    <th class="td_right" style="border:1px solid #A4A4A4;padding-left:5px!important"><span id="sesion_delegados"><?php echo number_format($total_monto_f, 2, '.', ',');?></span></th>
                </tr>
				
            </thead>
		</table>


        <table class="table table-hover table-sm" style="width:100%!important;padding-top:60px" align="center">
            <thead>
                
            <tr style="font-size:10px">
                <th class="td_center" style="border:0px solid #A4A4A4;padding-left:5px!important" align="center">_____________________________________</th>                    
            </tr>

            <tr style="font-size:10px">
                <th class="td_center" style="border:0px solid #A4A4A4;padding-left:5px!important" align="center"><?php echo $nombre_completo?></th>                    
            </tr>

            <tr style="font-size:10px">
                <th class="td_center" style="border:0px solid #A4A4A4;padding-left:5px!important" align="center">CAP: <?php echo $numero_cap?></th>                    
            </tr>

				
            </thead>
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