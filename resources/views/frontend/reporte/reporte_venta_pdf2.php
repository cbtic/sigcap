<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>CAP</title>
        <link rel="stylesheet" type="text/css" href="css/pdf.css"  />
        <style>
            
        </style>
    </head>
	
    <body>
		 
    	
		<table width="100%">
			<tbody>
				<tr>
					<td>Emisión</td>
					<td>TD</td>
					<td>Serie</td>
					<td>Numero</td>  
					<td>Cod. Tributario</td>
					<td>Destinatario</td>
					<td>Cantidad</td>
					<td>Descripcion</td>
					<td>Total</td>
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

                 foreach($reporte_ventas as $key=>$d){
					$total_cuenta += 1;

					
                 ?>
				 
				<?php 
                if ($total_cuenta==1) {  ?> 
					<tr>				
						<td colspan="9"><?php echo ($d->concepto)?></td>
						
					</tr>
                <?php 
					$concepto_tmp=$d->concepto;
                 } else {
					if ($concepto_tmp!=$d->concepto) {
				 ?>
				 			<tr>
								<th colspan="8">Total </th>
								
								<th><?php echo number_format($suma_total_parcial, 2, '.', ',');?></th>
							</tr>

					<tr>				
						<td colspan="9"><?php echo ($d->concepto)?></td>
						
					</tr>
				<?php 
					$suma_afecto_parcial =0;
					$suma_inafecto_parcial = 0;
					$suma_igv_parcial =0;
					$suma_total_parcial =0;

					$concepto_tmp=$d->concepto;
					}
                 }
				 ?>
				

                 <tr>
       
                    <td><?php echo ($d->fecha)?></td>  
                     <td><?php echo ($d->tipo)?></td>
                    
					 <td><?php echo $d->serie?></td>
					 <td><?php echo $d->numero?></td>
				
					 <td><?php echo $d->cod_tributario?></td>
					 <td><?php echo $d->destinatario?></td>
                     <td><?php echo $d->cantidad?></td>
                     <td><?php echo $d->descripcion?></td>

					 <td><?php echo number_format($d->importe, 2, '.', ',');   ?></td>
					 
					 
                 </tr>
				<?php
					
					$suma_total += $d->importe;

					
					$suma_total_parcial += $d->importe;

					if ($total_cuenta==count($reporte_ventas)) {
						
						?>
						   <tr>
								<th colspan="8">Total </th>
								
								<th><?php echo number_format($suma_total_parcial, 2, '.', ',');?></th>
							</tr>

					   <?php 
	
						   }
						
				} 
				?>
				
			</tbody>
			<tfoot>
				<tr>
					<th colspan="8">Total General</th>
					
					<th><?php echo number_format($suma_total, 2, '.', ',');?></th>
				</tr>
			</tfoot>
		</table>
		
		
			
		<!--<table style="margin-top: 10px">
            <tr>
                <td class="td_ancho_espacios"></td>
                <td class="td_ancho_espacios"></td>
            </tr>
        </table>-->
        <footer>
        <script type="text/php">
            /*if (isset($pdf)) {
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
            }*/
        </script>
		</footer>
    </body>
</html>