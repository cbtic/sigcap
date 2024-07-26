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
					<td class="ancho_nro" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px" width="3%">Emisión</td>
					<td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;text-align:left;padding-top:5px;padding-bottom:5px" width="1%">TD</td>
					<td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px" width="1%">Serie</td>
					<td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px" width="1%">Numero</td>  
					<td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px" width="2%">Fecha</td>
					<td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px" width="1%">tipo</td>
					<td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px" width="1%">serie</td>
					<td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px" width="1%">Número</td>
					<td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px" width="2%">Cod. Tributario</td>
					<td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px" width="5%">Destinatario</td>
					<td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px" width="1%">Importe afecto</td>
					<td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px" width="1%">Importe afecto</td>
					<td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px" width="1%">I.G.V.</td>
					<td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px" width="1%">Total</td>
				</tr>
				
				<?php 
                 $total_cuenta = 0;
				 
				 $suma_afecto=0;
				 $suma_inafecto=0;
				 $suma_igv=0;
				 $suma_total=0;

				 $suma_afecto_parcial=0;
				 $suma_inafecto_parcial=0;
				 $suma_igv_parcial=0;
				 $suma_total_parcial=0;
				//var_dump($reporte_ventas ); exit();
                 foreach($reporte_ventas as $id_concepto=>$items){
					$total_cuenta += 1;
					 
					//echo number_format($d->id_concepto);
                 ?>
					 <table>
            <thead>
			<?php var_dump($items->comprobante_detalles.id_concepto); exit(); ?>
                <tr>
					
                    <th>Campo 1</th>
                    <th>Campo 2</th>
                    <th>Campo 3</th>
                    <!-- Agrega más campos según sea necesario -->
                </tr>
				
				
            </thead>
            <tbody>
				
        </table>

					 <?php
					 	
				
			}
				?>
				
			</tbody>
			<tfoot>
				<tr>
					<th colspan="10" class="td_right" style="border:1px solid #A4A4A4;padding-left:5px!important">Total General</th>
					<th class="td_right" style="border:1px solid #A4A4A4;padding-left:5px!important"><?php echo number_format($suma_afecto, 2, '.', ',');?></th>
					<th class="td_right" style="border:1px solid #A4A4A4;padding-left:5px!important"><?php echo number_format($suma_inafecto, 2, '.', ',');?></th>
					<th class="td_right" style="border:1px solid #A4A4A4;padding-left:5px!important"><?php echo number_format($suma_igv, 2, '.', ',');?></th>
					<th class="td_right" style="border:1px solid #A4A4A4;padding-left:5px!important"><?php echo number_format($suma_total, 2, '.', ',');?></th>
				</tr>
			</tfoot>
		</table>
		
		@foreach ($reporte_ventas as $category => $items)
        <h2>Category: {{ id_concepto }}</h2>
        <table>
            <thead>
                <tr>
                    <th>Campo 1</th>
                    <th>Campo 2</th>
                    <th>Campo 3</th>
                    <!-- Agrega más campos según sea necesario -->
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                    <tr>
                        <td>{{ $item->campo1 }}</td>
                        <td>{{ $item->campo2 }}</td>
                        <td>{{ $item->campo3 }}</td>
                        <!-- Agrega más campos según sea necesario -->
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach
			
		<!--<table style="margin-top: 10px">
            <tr>
                <td class="td_ancho_espacios"></td>
                <td class="td_ancho_espacios"></td>
            </tr>
        </table>-->
        <footer>
        <script type="text/php">
            if (isset($pdf)) {
				$x = 760;
				$y = 572;
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