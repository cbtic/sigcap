<?php 

foreach($tipo_nombre_lista as $key=>$row):
	$estado = $row->estado;
	$predeterminado = $row->predeterminado;
	if($estado=='1'){$estado='Activo';}
	if($estado=='0'){$estado='Eliminado';}
	if($predeterminado=='1'){$predeterminado='SI';}
	if($predeterminado=='0'){$predeterminado='NO';}?>

<tr style="font-size:13px">
	<td class="text-left"><?php echo $row->tipo?></td>
	<td class="text-left"><?php echo $row->denominacion?></td>
	<td class="text-left"><?php echo $row->codigo?></td>
	<td class="text-left"><?php echo $row->tipo_nombre?></td>
	<td class="text-left"><?php echo $predeterminado?></td>
	<td class="text-left"><?php echo $estado?></td>
</tr>
<?php
endforeach;
?>

