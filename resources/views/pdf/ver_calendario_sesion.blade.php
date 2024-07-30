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
											<h2>REPORTE DE CALENDARIO DE SESION</h2>
										</td>
									</tr>
									<tr style="padding:0px!important;margin:0px!important">
										<td style="padding:0px!important;margin:0px!important;width:100px;text-align:right">Año:</td>
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
			
        </header>
        
    	
		<table style="background-color:white !important;border-collapse:collapse;border-spacing:1px;">
			<tbody>
				<tr>
					
					<td colspan="3" class="ancho_nro" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px"></td>
				
					<td colspan="6" class="ancho_nro" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px">1ra. Semana</td>
					<td colspan="6" class="ancho_nro" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px">2da. Semana</td>
					<td colspan="6" class="ancho_nro" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px">3ra. Semana</td>
					<td colspan="6" class="ancho_nro" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px">4ta. Semana</td>
					<td colspan="6" class="ancho_nro" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px">5ta. Semana</td>
					<td class="ancho_nro" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px">Total</td>
					
				</tr>
			
				<tr>
					
					<td colspan="3" class="ancho_nro" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px"></td>
				
					<?php
					$colspan = 3;
					$suma_total_delegado = 0;
					
					$fechaInicio = $anio."-".$mes."-01";
					$fechaFin = date("Y-m-t", strtotime($fechaInicio));
					
					$fechaInicioTemp = date("d-m-Y", strtotime($fechaInicio));
					$diax = (date('N', strtotime($fechaInicioTemp)));
					
					for($i=0;$i<($diax-1);$i++){
					?>
						<td class="ancho_nro" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;width:20px"><?php echo $dias[$i] ?></td>
					<?php	
					$colspan++;
					}
					
					for($i=strtotime($fechaInicio); $i<=strtotime($fechaFin); $i+=86400){
						$fechaInicioTemp = date("d-m-Y", $i);
						$dia = $dias[(date('N', strtotime($fechaInicioTemp))) - 1];
						if($dia!="D"){
						?>
						<td class="ancho_nro" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;width:20px"><?php echo $dia ?></td>
					<?php	
						$colspan++;
						}
					}
					
					
					
					
					for($i=((date('N', strtotime($fechaInicioTemp))));$i<7;$i++){
						if($dias[$i]!="D"){
					?>
						<td class="ancho_nro" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;width:20px"><?php echo $dias[$i] ?></td>
					<?php
						$colspan++;
						}	
					}
					
					?>
					
					<td class="ancho_nro" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;"></td>
				</tr>
				
				<?php foreach($municipalidadSesion as $row){
					
					$distritoSesion = \App\Models\ComisionSesione::getDistritoSesion($anio,$mes,$row->id);
					
					?>
					
					<tr>
					
						<td class="ancho_nro" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px"></td>
						<td class="ancho_nro" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px"><?php echo $row->municipalidad//$row->distrito?></td>
						<td class="ancho_nro" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px"></td>
						
					
						<?php 
						for($i=0;$i<($diax-1);$i++){
						?>
							<td class="ancho_nro" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px"><?php echo 0 ?></td>
						<?php	
						}
						
						for($i=strtotime($fechaInicio); $i<=strtotime($fechaFin); $i+=86400){
							$fechaInicioTemp = date("d", $i);
							$fechaInicioTemp_ = date("d-m-Y", $i);
							$dia = $dias[(date('N', strtotime($fechaInicioTemp_))) - 1];
							if($dia!="D"){
							?>
							<td class="ancho_nro" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px"><?php echo $fechaInicioTemp ?></td>
							<?php
							}
						}
						
						
						
						for($i=((date('N', strtotime($fechaInicioTemp_))));$i<7;$i++){
							if($dias[$i]!="D"){
						?>
							<td class="ancho_nro" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;width:20px"><?php echo 0 ?></td>
						<?php
							}	
						}
						
						?>
						
						
						<td class="ancho_nro" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px;"></td>
						
					</tr>
					
					<?php
				foreach($distritoSesion as $row0){
					
					$comisionSesion = \App\Models\ComisionSesione::getComisionDistritoSesion($anio,$mes,$row0->id_ubigeo,$row->id);
				?>
					
					<tr>
					
						<td class="ancho_nro" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;padding-top:5px;padding-bottom:5px"></td>
						<td class="ancho_nro" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;padding-top:5px;padding-bottom:5px"><?php echo $row0->distrito?></td>
						<td class="ancho_nro" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;padding-top:5px;padding-bottom:5px">CAP</td>
						
					
						<?php 
						for($i=0;$i<($diax-1);$i++){
						?>
							<td class="ancho_nro" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;padding-top:5px;padding-bottom:5px"></td>
						<?php	
						}
						
						for($i=strtotime($fechaInicio); $i<=strtotime($fechaFin); $i+=86400){
							$fechaInicioTemp = date("d", $i);
							$fechaInicioTemp_ = date("d-m-Y", $i);
							$dia = $dias[(date('N', strtotime($fechaInicioTemp_))) - 1];
							if($dia!="D"){
							?>
							<td class="ancho_nro" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;padding-top:5px;padding-bottom:5px"></td>
							<?php
							}
						}
						
						
						
						for($i=((date('N', strtotime($fechaInicioTemp_))));$i<7;$i++){
							if($dias[$i]!="D"){
						?>
							<td class="ancho_nro" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;padding-top:5px;padding-bottom:5px;width:20px"></td>
						<?php
							}	
						}
						
						?>
						
						<td class="ancho_nro" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;padding-top:5px;padding-bottom:5px;"></td>
						
						
					</tr>
					
					
					
					<?php foreach($comisionSesion as $row2){
						
						$delegadoSesion = \App\Models\ComisionSesione::getDelegadoComisionDistritoSesion($anio,$mes,$row0->id_ubigeo,$row2->id);
						
					?>
									
					<tr>
					
						<td class="ancho_nro" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;padding-top:5px;padding-bottom:5px"></td>
						<td class="ancho_nro" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;padding-top:5px;padding-bottom:5px">&nbsp;&nbsp;&nbsp;<?php echo $row2->comision?></td>
						<td class="ancho_nro" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;padding-top:5px;padding-bottom:5px"></td>
						
					
						<?php 
						for($i=0;$i<($diax-1);$i++){
						?>
							<td class="ancho_nro" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;padding-top:5px;padding-bottom:5px"></td>
						<?php	
						}
						
						for($i=strtotime($fechaInicio); $i<=strtotime($fechaFin); $i+=86400){
							$fechaInicioTemp = date("d", $i);
							$fechaInicioTemp_ = date("d-m-Y", $i);
							$dia = $dias[(date('N', strtotime($fechaInicioTemp_))) - 1];
							if($dia!="D"){
							?>
							<td class="ancho_nro" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;padding-top:5px;padding-bottom:5px"></td>
							<?php
							}
						}
						
						
						
						for($i=((date('N', strtotime($fechaInicioTemp_))));$i<7;$i++){
							if($dias[$i]!="D"){
						?>
							<td class="ancho_nro" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;padding-top:5px;padding-bottom:5px;width:20px"></td>
						<?php
							}	
						}
						
						?>
						
						<td class="ancho_nro" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;padding-top:5px;padding-bottom:5px;"></td>
						
					</tr>
					
					<?php 
					$total_delegado = 0;
					foreach($delegadoSesion as $row3){
					$total_delegado = 0;
					?>
					
					<tr>
					
						<td class="ancho_nro" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;padding-top:5px;padding-bottom:5px"><?php echo $row3->tipo?></td>
						<td class="ancho_nro" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;padding-top:5px;padding-bottom:5px">&nbsp;&nbsp;&nbsp;<?php echo $row3->delegado?></td>
						<td class="ancho_nro" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;padding-top:5px;padding-bottom:5px"><?php echo $row3->numero_cap?></td>
						
					
						<?php 
						for($i=0;$i<($diax-1);$i++){
						?>
							<td class="ancho_nro" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;padding-top:5px;padding-bottom:5px"></td>
						<?php	
						}
						
						for($i=strtotime($fechaInicio); $i<=strtotime($fechaFin); $i+=86400){
							$fechaInicioTemp = date("d", $i);
							$fechaInicioTemp_ = date("d-m-Y", $i);
							$dia = $dias[(date('N', strtotime($fechaInicioTemp_))) - 1];
							if($dia!="D"){
						
								$fechaSesion = \App\Models\ComisionSesione::getFechaDelegadoComisionDistritoSesion($anio,$mes,$row0->id_ubigeo,$row2->id,$row3->id,$fechaInicioTemp_);
							?>
							<td class="ancho_nro" style="text-align:center;border:1px solid #A4A4A4;font-style:italic;font-weight:bold;padding-top:5px;padding-bottom:5px"><?php echo isset($fechaSesion->tipo_sesion)?$fechaSesion->tipo_sesion:""?></td>
							<?php
							
							if(isset($fechaSesion->tipo_sesion) && ($fechaSesion->tipo_sesion=="O" || $fechaSesion->tipo_sesion=="E"))$total_delegado++;
							
							}
						}
						
						
						
						for($i=((date('N', strtotime($fechaInicioTemp_))));$i<7;$i++){
							if($dias[$i]!="D"){
						?>
							<td class="ancho_nro" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;padding-top:5px;padding-bottom:5px;width:20px"></td>
						<?php
							}	
						}
						$suma_total_delegado += $total_delegado;
						?>
						
						<td class="ancho_nro" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;padding-top:5px;padding-bottom:5px;text-align:center"><?php echo $total_delegado?></td>
						
							
					</tr>
					
					<?php }?>
					
					<?php }?>
						
					<?php }?>
				
				<?php }?>
				
				<tfoot>
				<tr>
				<td class="ancho_nro" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;padding-top:5px;padding-bottom:5px;text-align:left" colspan="<?php echo $colspan;?>">Total asistencia del mes</td>
				<td class="ancho_nro" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;padding-top:5px;padding-bottom:5px;text-align:center"><?php echo $suma_total_delegado?></td>
				</tr>
				</tfoot>
				
		</table>
		
        <footer>
        <script type="text/php">
            if (isset($pdf)) {
				$x = 730;
				$y = 573;
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