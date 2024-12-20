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
											<h2>REPORTE DE COMPUTO DE SESION</h2>
										</td>
									</tr>
									<tr style="padding:0px!important;margin:0px!important">
										<td style="padding:0px!important;margin:0px!important;text-align:right">Año:</td>
										<td style="padding:0px!important;margin:0px!important;text-align:left"><?php echo $anio?></td>
										<td style="padding:0px!important;margin:0px!important;text-align:right"></td>
										<td style="padding:0px!important;margin:0px!important;100px;text-align:right">Mes:</td>
										<td style="padding:0px!important;margin:0px!important;text-align:left"><?php echo $mesEnLetras?></td>
										<td style="padding:0px!important;margin:0px!important;text-align:right"></td>
										<td style="padding:0px!important;margin:0px!important;text-align:right">Fecha Computo:</td>
										<td style="padding:0px!important;margin:0px!important;text-align:left"><?php echo date("d-m-Y")?></td>
									</tr>
								</tbody>
							</table>
						</td>
					</tr>
				</tbody>
			</table>
			
        
        
    	
		<table style="background-color:white !important;border-collapse:collapse;border-spacing:1px;" width="100%">
			<tbody>
				<tr>
					
					<td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;text-align:left;padding-top:5px;padding-bottom:5px">Municipalidad</td>
					<td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px">Comisión</td>
					<td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px">Delegado</td>  
					<td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px">Número CAP</td>
					<td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px">Puesto</td>
					<td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px">Coord.</td>
					<td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px">Sesiones Comp.</td>
					<td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px">Sesiones Adic.</td>
					<td class="titulos" style="border:1px solid #A4A4A4;font-style:italic;font-weight:bold;background:#dbeddc;padding-top:5px;padding-bottom:5px">Total</td>
				</tr>
				
				<?php 
				$n = 0;
				$suma_computada = 0;
				$suma_adicional = 0;
				$suma_total = 0; 
				$suma_computada_ = 0;
				$suma_adicional_ = 0;
				$suma_total_ = 0; 
				$total_sesion_delegado = 0;
				$total_sesion_suplente = 0;
				$total_sesion_especialista = 0;
				$total_sesion_coordinador_zonal = 0;
				$total_sesion = 0;
				
				foreach($comisionSesion as $key=>$r){
					if($key==0){
						$municipalidad_old = $r->municipalidad;
						$comision_old = $r->comision;
						$total_sesion_delegado = $r->total_sesion_delegado;
						$total_sesion_suplente = $r->total_sesion_suplente;
						$total_sesion_especialista = $r->total_sesion_especialista;
						$total_sesion_coordinador_zonal = $r->total_sesion_coordinador_zonal;
						$total_sesion = $total_sesion_delegado + $total_sesion_coordinador_zonal + $total_sesion_suplente + $total_sesion_especialista;
					}
					
					$n++;
				
					if($municipalidad_old!=$r->municipalidad){
					?>
					<tr>
						<th colspan="6" class="td_left" style="background:#E5E5E5;border:1px solid #A4A4A4;padding-left:5px!important">Sub Total</th>
						<th class="td_left" style="background:#E5E5E5;border:1px solid #A4A4A4;padding-left:5px!important"><?php echo $suma_computada_?></th>
						<th class="td_left" style="background:#E5E5E5;border:1px solid #A4A4A4;padding-left:5px!important"><?php echo $suma_adicional_?></th>
						<th class="td_left" style="background:#E5E5E5;border:1px solid #A4A4A4;padding-left:5px!important"><?php echo $suma_total_?></th>
					</tr>
					<?php
						$suma_computada_ = 0;
						$suma_adicional_ = 0;
						$suma_total_ = 0;
					}
					?>
				<tr>
					
					<td class="td_left" style="border:1px solid #A4A4A4;padding-left:5px!important">
					<?php
						if($key==0 || $municipalidad_old!=$r->municipalidad)echo $r->municipalidad;
					?>
					</td>
					<td class="td_left" style="border:1px solid #A4A4A4;padding-left:5px!important">
					<?php 
						if($key==0 || ($municipalidad_old."|".$comision_old!=$r->municipalidad."|".$r->comision))echo $r->comision;
					?>
					</td>
					<td class="td_left" style="border:1px solid #A4A4A4;padding-left:5px!important"><?php echo $r->delegado?></td>
					<td class="td_left" style="border:1px solid #A4A4A4;padding-left:5px!important"><?php echo $r->numero_cap?></td>
					<td class="td_left" style="border:1px solid #A4A4A4;padding-left:5px!important"><?php echo $r->puesto?></td>
					<td class="td_left" style="border:1px solid #A4A4A4;padding-left:5px!important"><?php echo $r->coordinador?></td>
					<td class="td_left" style="border:1px solid #A4A4A4;padding-left:5px!important"><?php echo $r->computada?></td>
					<td class="td_left" style="border:1px solid #A4A4A4;padding-left:5px!important"><?php echo $r->adicional?></td>
					<td class="td_left" style="border:1px solid #A4A4A4;padding-left:5px!important"><?php echo $r->total?></td>
				</tr>
				<?php 
				
					$suma_computada += $r->computada;
					$suma_adicional += $r->adicional;
					$suma_total += $r->total;
					
					$suma_computada_ += $r->computada;
					$suma_adicional_ += $r->adicional;
					$suma_total_ += $r->total;
					
					
					
					$municipalidad_old = $r->municipalidad;
					$comision_old = $r->comision;
					
				} 
				
				if(($key+1) == count($comisionSesion)){
				?>
				<tr>
					<th colspan="6" class="td_left" style="background:#E5E5E5;border:1px solid #A4A4A4;padding-left:5px!important">Sub Total</th>
					<th class="td_left" style="background:#E5E5E5;border:1px solid #A4A4A4;padding-left:5px!important"><?php echo $suma_computada_?></th>
					<th class="td_left" style="background:#E5E5E5;border:1px solid #A4A4A4;padding-left:5px!important"><?php echo $suma_adicional_?></th>
					<th class="td_left" style="background:#E5E5E5;border:1px solid #A4A4A4;padding-left:5px!important"><?php echo $suma_total_?></th>
				</tr>
				<?php
					$suma_computada_ = 0;
					$suma_adicional_ = 0;
					$suma_total_ = 0;
				}
				
				?>
				
			</tbody>
			<tfoot>
				<tr>
					<th colspan="6" class="td_left" style="border:1px solid #A4A4A4;padding-left:5px!important">Total</th>
					<th class="td_left" style="border:1px solid #A4A4A4;padding-left:5px!important"><?php echo $suma_computada?></th>
					<th class="td_left" style="border:1px solid #A4A4A4;padding-left:5px!important"><?php echo $suma_adicional?></th>
					<th class="td_left" style="border:1px solid #A4A4A4;padding-left:5px!important"><?php echo $suma_total?></th>
				</tr>
			</tfoot>
		</table>
		
		
		<table class="table table-hover table-sm" style="padding-top:15px" align="right">
			<thead>
			<tr style="font-size:13px">
				<th class="td_left" style="background:#E5E5E5;border:1px solid #A4A4A4;padding-left:5px!important;">Sesiones delegados</th>
				<th class="td_left" style="border:1px solid #A4A4A4;padding-left:5px!important"><?php echo $total_sesion_delegado?></th>
			</tr>
			<tr style="font-size:13px">
				<th class="td_left" style="background:#E5E5E5;border:1px solid #A4A4A4;padding-left:5px!important;">Sesiones suplentes</th>
				<th class="td_left" style="border:1px solid #A4A4A4;padding-left:5px!important"><?php echo $total_sesion_suplente?></th>
			</tr>
			<tr style="font-size:13px">
				<th class="td_left" style="background:#E5E5E5;border:1px solid #A4A4A4;padding-left:5px!important;">Sesiones especialistas</th>
				<th class="td_left" style="border:1px solid #A4A4A4;padding-left:5px!important"><?php echo $total_sesion_especialista?></th>
			</tr>
			<tr style="font-size:13px">
				<th class="td_left" style="background:#E5E5E5;border:1px solid #A4A4A4;padding-left:5px!important">Sesiones coordinador zonal</th>
				<th class="td_left" style="border:1px solid #A4A4A4;padding-left:5px!important"><?php echo $total_sesion_coordinador_zonal?></th>
			</tr>
			<tr style="font-size:13px">
				<th class="td_left" style="background:#E5E5E5;border:1px solid #A4A4A4;padding-left:5px!important">Total de sesiones</th>
				<th class="td_left" style="border:1px solid #A4A4A4;padding-left:5px!important"><?php echo $total_sesion?></th>
			</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
		
		<table class="table table-hover table-sm" style="padding-top:15px" align="left">
			<thead>
			<tr style="font-size:13px">
				<th class="td_left" style="background:#E5E5E5;border:1px solid #A4A4A4;padding-left:5px!important;">Calendario de sesiones</th>
				<th class="td_left" style="border:1px solid #A4A4A4;padding-left:5px!important"><?php echo $calendarioSesion?></th>
			</tr>
			<tr style="font-size:13px">
				<th class="td_left" style="background:#E5E5E5;border:1px solid #A4A4A4;padding-left:5px!important;">Sesiones coordinado zonal</th>
				<th class="td_left" style="border:1px solid #A4A4A4;padding-left:5px!important"><?php echo $calendarioCoordinadorZonalSesion?></th>
			</tr>
			<tr style="font-size:13px">
				<th class="td_left" style="background:#E5E5E5;border:1px solid #A4A4A4;padding-left:5px!important">(-) Diferencia de Reportes</th>
				<th class="td_left" style="border:1px solid #A4A4A4;padding-left:5px!important"><?php echo $total_sesion - $calendarioSesion - $calendarioCoordinadorZonalSesion?></th>
			</tr>
			<tr style="font-size:13px">
				<th class="td_left" style="background:#E5E5E5;border:1px solid #A4A4A4;padding-left:5px!important">Total de sesiones</th>
				<th class="td_left" style="border:1px solid #A4A4A4;padding-left:5px!important"><?php echo $total_sesion?></th>
			</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
		
    </body>
</html>