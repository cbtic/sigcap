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
                                        <h2>FONDO COMUN</h2>
                                    </td>
                                </tr>
                                <tr style="padding:0px!important;margin:0px!important">
                                    <td style="padding:0px!important;margin:0px!important;width:100px;text-align:right">Periodo:</td>
                                    <td style="padding:0px!important;margin:0px!important;width:60px;text-align:left"><?php echo $denominacion_periodo?></td>
                                    <td style="padding:0px!important;margin:0px!important;text-align:right"></td>
                                    <td style="padding:0px!important;margin:0px!important;width:100px;text-align:right">Año:</td>
                                    <td style="padding:0px!important;margin:0px!important;width:60px;text-align:left;word-wrap: break-word; white-space: normal; max-width: 220px;"><?php echo $anio?></td>
                                    <td style="padding:0px!important;margin:0px!important;text-align:right"></td>
                                    <td style="padding:0px!important;margin:0px!important;width:100px;text-align:right">Meses:</td>
                                    <td style="padding:0px!important;margin:0px!important;width:60px;text-align:left;word-wrap: break-word; white-space: normal; max-width: 220px;"><?php echo $mesEnLetras?></td>
                                    <td style="padding:0px!important;margin:0px!important;text-align:right"></td>
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
					<td class="ancho_nro" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:left" width="25%">Municipalidad</td>
                    <td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:right" width="15%">Importe Bruto</td>
                    <td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:right" width="15%">IGV 18%</td>
                    <td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:right" width="15%">Comisión CAP RL 30%</td>
                    <td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:right" width="15%">Fondo Asistencia 2%</td>
					<td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:right" width="15%">Saldo a favor de Delegados</td>
				</tr>
				
				<?php 
                $total_importe_bruto = 0;
                $total_igv = 0;
                $total_comision_cap = 0;
                $total_fondo_asistencia = 0;
                $total_saldo_delegados = 0;

				foreach($fondoComun as $key=>$r){
                    
				?>
				<tr>
                    <td class="td_left" style="border:1px solid #A4A4A4;padding-left:5px!important"><?php echo $r->municipalidad?></td>
                    <td class="td_right" style="border:1px solid #A4A4A4;padding-left:5px!important"><?php echo number_format($r->importe_bruto, 2, '.', ',')?></td>
                    <td class="td_right" style="border:1px solid #A4A4A4;padding-left:5px!important"><?php echo number_format($r->importe_igv, 2, '.', ',')?></td>
                    <td class="td_right" style="border:1px solid #A4A4A4;padding-left:5px!important"><?php echo number_format($r->importe_comision_cap, 2, '.', ',')?></td>
                    <td class="td_right" style="border:1px solid #A4A4A4;padding-left:5px!important"><?php echo number_format($r->importe_fondo_asistencia, 2, '.', ',')?></td>
                    <td class="td_right" style="border:1px solid #A4A4A4;padding-left:5px!important"><?php echo number_format($r->saldo, 2, '.', ',')?></td>
				</tr>
				<?php
                    $total_importe_bruto += $r->importe_bruto;
                    $total_igv += $r->importe_igv;
                    $total_comision_cap += $r->importe_comision_cap;
                    $total_fondo_asistencia += $r->importe_fondo_asistencia;
                    $total_saldo_delegados += $r->saldo;
				} 
				?>
                <tr>
                    <td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;padding-top:5px;padding-bottom:5px;text-align:left" width="15%">Totales Generales</td>
                    <td class="td_right" style="border:1px solid #A4A4A4;padding-left:5px!important; font-weight: bold"><?php echo number_format($total_importe_bruto, 2, '.', ',')?></td>
                    <td class="td_right" style="border:1px solid #A4A4A4;padding-left:5px!important; font-weight: bold"><?php echo number_format($total_igv, 2, '.', ',')?></td>
                    <td class="td_right" style="border:1px solid #A4A4A4;padding-left:5px!important; font-weight: bold"><?php echo number_format($total_comision_cap, 2, '.', ',')?></td>
                    <td class="td_right" style="border:1px solid #A4A4A4;padding-left:5px!important; font-weight: bold"><?php echo number_format($total_fondo_asistencia, 2, '.', ',')?></td>
                    <td class="td_right" style="border:1px solid #A4A4A4;padding-left:5px!important; font-weight: bold"><?php echo number_format($total_saldo_delegados, 2, '.', ',')?></td>
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