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
                                        <h2>DETALLE DE FONDO COMUN <?php //echo $mesEnLetras?> <?php //echo $anio?> </h2>
                                    </td>
                                </tr>
            <tr style="padding:0px!important;margin:0px!important">
                <td style="padding:0px!important;margin:0px!important;width:100px;text-align:right">Año:</td>
                <td style="padding:0px!important;margin:0px!important;width:60px;text-align:left"><?php echo $anio?></td>
                <td style="padding:0px!important;margin:0px!important;text-align:right"></td>
                <td style="padding:0px!important;margin:0px!important;width:100px;text-align:right">Mes:</td>
                <td style="padding:0px!important;margin:0px!important;width:60px;text-align:left"><?php echo $mesEnLetras?></td>
                <td style="padding:0px!important;margin:0px!important;text-align:right"></td>
                <td style="padding:0px!important;margin:0px!important;width:100px;text-align:right">Municipalidad:</td>
                <td style="padding:0px!important;margin:0px!important;width:60px;text-align:left"><?php echo $municipalidad_denominacion?></td>
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
					<td class="ancho_nro" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:center" width="5%">N°</td>
                    <td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:center" width="10%">Nombre/Razon Social</td>
                    <td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:center" width="10%">DNI/RUC</td>
                    <td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:center" width="10%">Credipago</td>
                    <td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:center" width="20%">Glosa</td>
					<td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:center" width="5%">Serie</td>
					<td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:center" width="5%">Numero</td>
                    <td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:center" width="5%">Tipo</td>
					<td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:center" width="10%">Fecha Pago</td>
                    <td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:center" width="10%">Importe</td>
				</tr>
				
				<?php 
                $total_monto = 0;
				foreach($fondoComun as $key=>$r){
                $total_monto += $r->monto;
				?>
				<tr>
					<td style="border:1px solid #A4A4A4;width:40px;text-align:center"><?php echo ($key+1)?></td>
                    <td class="td_left" style="border:1px solid #A4A4A4;padding-left:5px!important"><?php echo ($r->destinatario_final)?></td>
                    <td class="td_left" style="border:1px solid #A4A4A4;padding-left:5px!important"><?php echo ($r->destinatario_documento_final)?></td>
                    <td class="td_left" style="border:1px solid #A4A4A4;padding-left:5px!important"><?php echo ($r->credipago)?></td>
                    <td class="td_left" style="border:1px solid #A4A4A4;padding-left:5px!important"><?php echo ($r->descripcion)?></td>
                    <td class="td_left" style="border:1px solid #A4A4A4;padding-left:5px!important"><?php echo $r->serie?></td>
					<td class="td_left" style="border:1px solid #A4A4A4;padding-right:10px!important"><?php echo $r->numero?></td>
                    <td class="td_left" style="border:1px solid #A4A4A4;padding-right:10px!important"><?php echo $r->tipo?></td>
					<td class="td_left" style="border:1px solid #A4A4A4;padding-left:5px!important"><?php echo date('d-m-Y', strtotime($r->fecha_pago));?></td>
					<td class="td_right" style="border:1px solid #A4A4A4;padding-right:10px!important"><?php echo number_format($r->monto, 2, '.', ',')?></td>
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