<?php 

foreach($suspension_lista as $key=>$row):?>
<tr style="font-size:13px">
	<td class="text-left"><?php echo $row->id_agremiado?></td>
	<td class="text-left"><?php echo $row->fecha_inicio?></td>
	<td class="text-left"><?php echo $row->fecha_fin?></td>
	<td class="text-left"><?php echo $row->documento?></td>
</tr>
<?php
endforeach;
?>

