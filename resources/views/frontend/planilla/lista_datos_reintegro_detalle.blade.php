<?php 

foreach($reintegro_detalle_lista as $key=>$row):?>
<tr style="font-size:13px">
	<td class="text-left"><?php echo $row->agremiado?></td>
	<td class="text-left"><?php echo $row->tipo_reintegro?></td>
	<td class="text-left"><?php echo $row->mes_reintegrar?></td>
	<td class="text-left"><?php echo $row->mes_ejecuta_reintegro?></td>
	<td class="text-left"><?php echo $row->cantidad?></td>
	<td class="text-left"><?php echo number_format($row->importe, 2); ?></td>
</tr>
<?php
endforeach;
?>

