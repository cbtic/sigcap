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
                                        <h2><?php echo $titulo?></h2>
                                    </td>
                                </tr>
                                <tr style="padding:0px!important;margin:0px!important">
                                    <td style="padding:0px!important;margin:0px!important;width:100px;text-align:right">Recaudación del día:</td>
                                    <td style="padding:0px!important;margin:0px!important;width:60px;text-align:left"><?php echo $f_fin?></td>
                                    <td style="padding:0px!important;margin:0px!important;text-align:right"></td>
                                    <td style="padding:0px!important;margin:0px!important;width:100px;text-align:right">TC:</td>
                                    <td style="padding:0px!important;margin:0px!important;width:60px;text-align:left">3.84<?php //echo $mesEnLetras?></td>

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
                    <td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:left" width="10%">N&Uacute;MERO DE CAP</td>
                    <td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:left" width="30%">APELLIDOS Y NOMBRES</td>
					<td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:left" width="8%">IMPORTE</td>
                    <td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:left" width="32%">CONCEPTO</td>
                    <td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:left" width="10%">PERIODO</td>
                    <td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:left" width="10%">FECHA VENCIMIENTO</td>
				</tr>

				<?php 
				foreach($valorizacion as $key=>$r){
				?>
				<tr>

                    <td class="td_left" style="border:1px solid #A4A4A4;padding-left:5px!important"><?php echo $r->numero_cap?></td>
                    <td class="td_left" style="border:1px solid #A4A4A4;padding-left:5px!important"><?php echo $r->apellidos_nombre?></td>
                    <td class="td_left" style="border:1px solid #A4A4A4;padding-left:5px!important">S/. <?php echo $r->monto?></td>
                    <td class="td_left" style="border:1px solid #A4A4A4;padding-left:5px!important"><?php echo $r->descripcion?></td>
                    <td class="td_left" style="border:1px solid #A4A4A4;padding-left:5px!important"><?php echo $r->periodo?></td>
                    <td class="td_left" style="border:1px solid #A4A4A4;padding-left:5px!important"><?php echo $r->fecha_vencimiento?></td>
				</tr>
				<?php
				} 
				?>
				
			</tbody>
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