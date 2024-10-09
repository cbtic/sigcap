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
                                        <h2><?php echo $titulo?> <?php //echo $anio?> </h2>
                                    </td>
                                </tr>
                            <tr style="padding:0px!important;margin:0px!important">
                            <td style="padding:0px!important;margin:0px!important;width:100px;text-align:right">Recaudación del día:</td>
                            <td style="padding:0px!important;margin:0px!important;width:60px;text-align:left"><?php echo $f_inicio?></td>
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
                    <td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:center" width="25%">VENTAS</td>
                    <td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:center" width="5%">REF US$</td>
					<td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:center" width="5%">Total S.</td>
				</tr>
<!--
                <tr>
                <td class="td_left" style="border:1px solid #A4A4A4;padding-left:5px!important">VENTAS</td>
				</tr>
		-->		
				<?php 
                $total_monto = 0;
				foreach($venta as $key=>$r){
                $total_monto += $r->total;
				?>
				<tr>

                    <td class="td_left" style="border:1px solid #A4A4A4;padding-left:5px!important"><?php echo ($r->tipo)?></td>
                    <td class="td_right" style="border:1px solid #A4A4A4;padding-left:5px!important">0.00<?php //echo ($r->descripcion)?></td>
                    <td class="td_right" style="border:1px solid #A4A4A4;padding-left:5px!important"><?php echo number_format($r->total,2)?></td>
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
                    <th class="td_left" style="border:1px solid #A4A4A4;padding-left:5px!important"><span id="sesion_delegados"><?php echo number_format($total_monto, 2, '.', ',');?></span></th>
                </tr>
				
            </thead>
		</table>

        <table style="background-color:white !important;border-collapse:collapse;border-spacing:1px;" width="100%">
			<tbody>
                <tr>
                    <td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:center" width="25%">FORMAS DE RECAUDACIÓN</td>
                    <td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:center" width="5%">REF US$</td>
					<td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:center" width="5%">Total S.</td>
				</tr>  
                <!--              
                <tr>
                <td class="td_left" style="border:1px solid #A4A4A4;padding-left:5px!important">FORMAS DE RECAUDACIÓN</td>
				</tr>
            -->
				
				<?php 
                $total_monto_f = 0;
				foreach($forma_pago as $key=>$f){
                $total_monto_f += $f->total_soles;
				?>
				<tr>

                    <td class="td_left" style="border:1px solid #A4A4A4;padding-left:5px!important"><?php echo ($f->condicion)?></td>
                    <td class="td_right" style="border:1px solid #A4A4A4;padding-left:5px!important"><?php echo number_format($f->total_us,2)?></td>
                    <td class="td_right" style="border:1px solid #A4A4A4;padding-left:5px!important"><?php echo number_format($f->total_soles,2)?></td>
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
                    <th class="td_left" style="border:1px solid #A4A4A4;padding-left:5px!important"><span id="sesion_delegados"><?php echo number_format($total_monto_f, 2, '.', ',');?></span></th>
                </tr>
				
            </thead>
		</table>

        <table style="background-color:white !important;border-collapse:collapse;border-spacing:1px;" width="100%">
			<tbody>
                <tr>
                    <td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:center" width="25%">DESCRIPCIÓN DE LOS INGRESOS</td>
                    <td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:center" width="5%">REF US$</td>
					<td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:center" width="5%">Total S.</td>
				</tr>   
                <!--             
                <tr>
                <td class="td_left" style="border:1px solid #A4A4A4;padding-left:5px!important">DESCRIPCIÓN DE LOS INGRESOS</td>
				</tr>
            -->
				<?php 
                $total_monto_d = 0;
				foreach($detalle_venta as $key=>$d){
                $total_monto_d += $d->importe;
				?>
				<tr>

                    <td class="td_left" style="border:1px solid #A4A4A4;padding-left:5px!important"><?php echo ($d->denominacion)?></td>
                    <td class="td_right" style="border:1px solid #A4A4A4;padding-left:5px!important">0.00<?php //echo ($f->total_us)?></td>
                    <td class="td_right" style="border:1px solid #A4A4A4;padding-left:5px!important"><?php echo number_format($d->importe,2)?></td>
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
                    <th class="td_left" style="border:1px solid #A4A4A4;padding-left:5px!important"><span id="sesion_delegados"><?php echo number_format($total_monto_d, 2, '.', ',');?></span></th>
                </tr>
				
            </thead>
		</table>

        
        <table style="background-color:white !important;border-collapse:collapse;border-spacing:1px;" width="100%">
			<tbody>
                <tr>
                    <td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:center" width="25%">NOTAS DE CREDITO Y OTROS</td>
                    
				</tr>  
            </tbody>
        </table>        
        <table style="background-color:white !important;border-collapse:collapse;border-spacing:1px;" width="100%">
			<tbody>
                <tr>
                    <td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:center" width="10%">Tipo</td>
                    <td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:center" width="5%">Comprobante</td>
                    <td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:center" width="25%">Destinatario</td>
                    <td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:center" width="5%">REF US$</td>
                    <td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:center" width="5%">Total</td>
                    
				</tr>   
                <!--             
                <tr>
                <td class="td_left" style="border:1px solid #A4A4A4;padding-left:5px!important">DESCRIPCIÓN DE LOS INGRESOS</td>
				</tr>
            -->
				<?php 
                $total_monto_d = 0;
				foreach($comprobante_ncnd as $key=>$d){
                $total_monto_d += $d->total;
				?>
				<tr>
                 

                    <td class="td_left" style="border:1px solid #A4A4A4;padding-left:5px!important"><?php echo ($d->tipo_documento)?></td>
                    <td class="td_left" style="border:1px solid #A4A4A4;padding-left:5px!important"><?php echo ($d->numero)?></td>
                    <td class="td_left" style="border:1px solid #A4A4A4;padding-left:5px!important"><?php echo ($d->destinatario)?></td>
                    <td class="td_right" style="border:1px solid #A4A4A4;padding-left:5px!important"><?php echo number_format($d->us,2)?></td>
                    <td class="td_right" style="border:1px solid #A4A4A4;padding-left:5px!important"><?php echo number_format($d->total,2)?></td>

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
                    <th class="td_left" style="border:1px solid #A4A4A4;padding-left:5px!important"><span id="sesion_delegados"><?php echo number_format($total_monto_d, 2, '.', ',');?></span></th>
                </tr>
				
            </thead>
		</table>


        <table style="background-color:white !important;border-collapse:collapse;border-spacing:1px;" width="100%">
			<tbody>
                <tr>
                    <td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:center" width="25%">DOCUMENTOS UTILIZADOS</td>
                    <td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:center" width="5%">CANTIDAD</td>
					
				</tr>   
                <!--             
                <tr>
                <td class="td_left" style="border:1px solid #A4A4A4;padding-left:5px!important">DESCRIPCIÓN DE LOS INGRESOS</td>
				</tr>
            -->
				<?php 
                 $total_cuenta = 0;
                 foreach($comprobante_conteo as $key=>$d){
                 $total_cuenta += $d->cantidad;
                 ?>
                 <tr>
 
                     <td class="td_left" style="border:1px solid #A4A4A4;padding-left:5px!important"><?php echo ($d->tipo_documento)?></td>
                     <td class="td_right" style="border:1px solid #A4A4A4;padding-left:5px!important"><?php echo $d->cantidad?></td>
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
                    <th class="td_left" style="border:1px solid #A4A4A4;padding-left:5px!important"><span id="sesion_delegados"><?php echo number_format($total_cuenta, 0, '.', ',');?></span></th>
                </tr>
				
            </thead>
		</table>

        <table style="background-color:white !important;border-collapse:collapse;border-spacing:1px;" width="100%">
			<tbody>
                <tr>
                    <td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:center" width="25%">TIPO DOCUMENTO</td>
                    <td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:center" width="5%">NUMERO</td>
					
				</tr>   
                <!--             
                <tr>
                <td class="td_left" style="border:1px solid #A4A4A4;padding-left:5px!important">DESCRIPCIÓN DE LOS INGRESOS</td>
				</tr>
            -->
				<?php 
                 $total_cuenta = 0;
                 foreach($comprobante_lista as $key=>$d){
                 $total_cuenta += 1;
                 ?>
                 <tr>
 
                     <td class="td_left" style="border:1px solid #A4A4A4;padding-left:5px!important"><?php echo ($d->tipo_documento)?></td>
                     <td class="td_right" style="border:1px solid #A4A4A4;padding-left:5px!important"><?php echo $d->numero?></td>
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
                    <th class="td_left" style="border:1px solid #A4A4A4;padding-left:5px!important"><span id="sesion_delegados"><?php echo number_format($total_cuenta, 0, '.', ',');?></span></th>
                </tr>
				
            </thead>
		</table>
		
        <table style="background-color:white !important;border-collapse:collapse;border-spacing:1px;" width="100%">
			<tbody>
                <tr>
                    <td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:center" width="25%">INGREOSS COMPLEMENTARIOS DEL DIA</td>
                    
				</tr>  
            </tbody>
        </table>        
        <table style="background-color:white !important;border-collapse:collapse;border-spacing:1px;" width="100%">
			<tbody>
                <tr>
                    <td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:center" width="10%">fecha</td>
                    <td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:center" width="50%">Comprobante</td>
                    
                    <td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:center" width="15%">REF US$</td>
                    <td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:center" width="15%">Total</td>
                    
				</tr>   
                <!--             
                <tr>
                <td class="td_left" style="border:1px solid #A4A4A4;padding-left:5px!important">DESCRIPCIÓN DE LOS INGRESOS</td>
				</tr>
            -->
				<?php 
                $total_monto_d = 0;
				foreach($ingresos_complementarios as $key=>$d){
                $total_monto_d += $d->importe;
				?>
				<tr>
       

                    <td class="td_left" style="border:1px solid #A4A4A4;padding-left:5px!important"><?php echo ($d->fecha)?></td>
                    <td class="td_left" style="border:1px solid #A4A4A4;padding-left:5px!important"><?php echo ($d->comprobante)?></td>
                
                    <td class="td_right" style="border:1px solid #A4A4A4;padding-left:5px!important"><?php echo number_format($d->usd,2)?></td>
                    <td class="td_right" style="border:1px solid #A4A4A4;padding-left:5px!important"><?php echo number_format($d->importe,2)?></td>

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
                    <th class="td_left" style="border:1px solid #A4A4A4;padding-left:5px!important"><span id="sesion_delegados"><?php echo number_format($total_monto_d, 2, '.', ',');?></span></th>
                </tr>
				
            </thead>
		</table>


        <table class="table table-hover table-sm" style="width:100%!important;padding-top:15px" align="center">
            <thead>
                
            <tr style="font-size:10px">
                    <th class="td_center" style="border:0px solid #A4A4A4;padding-left:5px!important" align="center">_____________________________________</th>
                    <th class="td_center" style="border:0px solid #A4A4A4;padding-left:5px!important" align="center">_____________________________________</th>
                </tr>

                <tr style="font-size:10px">
                    <th class="td_center" style="border:0px solid #A4A4A4;padding-left:5px!important" align="center">AREVALO IPANAQUE MELLANY GLEENDA</th>
                    <th class="td_center" style="border:0px solid #A4A4A4;padding-left:5px!important" align="center"><span id="sesion_delegados"><?php echo $usuario?> </span></th>
                </tr>

                <tr style="font-size:10px">
                    <th class="td_center" style="border:0px solid #A4A4A4;padding-left:5px!important" align="center">ENCARGADO(A) DE CAJA</th>
                    <th class="td_center" style="border:0px solid #A4A4A4;padding-left:5px!important" align="center"><span id="sesion_delegados">Cajero</span></th>
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