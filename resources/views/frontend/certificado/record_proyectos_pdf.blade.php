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
                font-size: 9px !important; 
                /*font-family: Roboto,"Helvetica Neue",Helvetica,Arial,sans-serif;*/
                font-family: "Helvetica", sans-serif;
                
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
            .contenido_cuerpo{
                font-family: 'Arial MT', Arial, sans-serif;
                text-align: justify;
                font-size: 16px;
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
										<td style="padding:0px!important;margin:0px!important" align="left" class="titulo_principal">
											<h2>REPORTE DE PROYECTOS Y DE REVISION</h2>
                                            <h2>Del <?php echo $fecha_colegiado?> al <?php echo $fecha_actual?> </h2>

										</td>
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
                <tr>
                    <td style ="text-align: center">
                        CAP <?php echo $numero_cap?> <br>
                        <?php echo $tratodesc?> <?php echo $agremiado?>
                    </td>
                    <td style="border:1px solid #A4A4A4; font-size : 8.5px;padding-left:5px!important" width="60%">
                        NOTA IMPORTANTE: LA BASE DE DATOS GENERAL DE OBRAS DEL CAP LIMA CORRESPONDE A LO INGRESADO EN EL SISTEMA DE CAJA
                        DESDE EL AÑO 1988 A LA FECHA
                    </td>
                </tr>
			</tbody>
		</table>
    	
		<table style="background-color:white !important;border-collapse:collapse;border-spacing:1px; table-layout: fixed;" width="100%">
			<tbody>
                
				<tr>
					<td class="ancho_nro" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:center" width="3%">#</td>
					<td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:center" width="7%">Tipo</td>
					<td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:center" width="8%">Fecha</td>
					<td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:center" width="9%">Credipago</td>
                    <td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:center" width="12%">Propietario</td>
                    <td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:center" width="17%">Nombre Proyecto</td>
                    <td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:center" width="11%">Distrito</td>
                    <td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:center" width="8%">Area Lote</td>
                    <td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:center" width="8%">Area Construida</td>
                    <td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:center" width="8%">Area Remodelada</td>
                    <td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;text-align:center" width="9%">Tipo Proyecto</td>
				</tr>
				
				<?php 
                
                $total_area_total = 0;
                $total_area_techada = 0;
                $total_area_remodelada = 0;

				foreach($proyectos as $key=>$r){
				?>
				<tr>
					<td style="border:1px solid #A4A4A4;width:40px;text-align:center"><?php echo ($key+1)?></td>
                    <td class="td_left" style="border:1px solid #A4A4A4;padding-left:5px!important; font-size:7px"><?php echo $r->tipo?></td>
					<td class="td_left" style="border:1px solid #A4A4A4;padding-left:5px!important; font-size:7px"><?php echo date('d-m-Y', strtotime($r->fecha));?></td>
					<td class="td_left" style="border:1px solid #A4A4A4;padding-right:10px!important; font-size:7px"><?php echo $r->credipago?></td>
					<td class="td_left" style="border:1px solid #A4A4A4;padding-right:10px!important; font-size:7px"><?php echo $r->propietario?></td>
                    <td class="td_left" style="border:1px solid #A4A4A4;padding-left:5px!important; font-size:7px"><?php echo $r->nombreproyecto?></td>
					<td class="td_left" style="border:1px solid #A4A4A4;padding-right:10px!important; font-size:7px"><?php echo $r->distrito?></td>
                    <td class="" style="border:1px solid #A4A4A4;padding-left:5px!important;text-align:right; font-size:7px"><?php echo $r->area_total !== null ? number_format($r->area_total,2,'.',',') : '-';?></td>
                    <td class="" style="border:1px solid #A4A4A4;padding-left:5px!important;text-align:right; font-size:7px"><?php echo $r->total_area_techada_m2 !== null ? number_format($r->total_area_techada_m2,2,'.',',') : '-';?></td>
                    <td class="" style="border:1px solid #A4A4A4;padding-left:5px!important;text-align:right; font-size:7px"><?php echo $r->area_remodelada?></td>
                    <td class="td_left" style="border:1px solid #A4A4A4;padding-left:5px!important; font-size:7px"><?php echo $r->tipo_profesional!== 'NULL' ? $r->tipo_profesional : ''; ?></td>

                    <?php 
                    
                    $total_area_total += $r->area_total; 
                    $total_area_techada += $r->total_area_techada_m2; 
                    $total_area_remodelada += $r->area_remodelada; 
                    
                    ?>

				</tr>
				<?php
				} 
				?>
                <tr>
                    <!--<td class="td_left" style="border:1px solid #A4A4A4;padding-left:5px!important"></td>-->
                    <td colspan="7"  class="td_left" style="border:1px solid #A4A4A4;padding-left:5px!important; font-size: 7px"><b>TOTAL</b></td>
                    <td class="td_right" style="border:1px solid #A4A4A4;padding-left:5px!important; font-size: 7px"><b><?php echo number_format($total_area_total,2,'.',',') ?></b></td>
                    <td class="td_right" style="border:1px solid #A4A4A4;padding-left:5px!important; font-size: 7px"><b><?php echo number_format($total_area_techada,2,'.',',') ?></b></td>
                    <td class="td_right" style="border:1px solid #A4A4A4;padding-left:5px!important; font-size: 7px"><b><?php echo number_format($total_area_remodelada,2,'.',',') ?></b></td>
                    <td class="td_left" style="border:1px solid #A4A4A4;padding-left:5px!important"></td>
                </tr>
			</tbody>
		</table>
        <br></br>
        <div style="text-align: center; position: relative; height: 100px;">
            <img width="200px" height="80px" src="img/firma_gerente_general_guillermo_benvenuto.jpeg">
        <div>
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