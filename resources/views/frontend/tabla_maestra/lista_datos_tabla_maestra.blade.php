<?php 

foreach($tipo_nombre_lista as $key=>$row):?>
<tr style="font-size:13px">
	<td class="text-left"><?php echo $row->tipo?></td>
	<td class="text-left"><?php echo $row->denominacion?></td>
	<td class="text-left"><?php echo $row->codigo?></td>
	<td class="text-left"><?php echo $row->tipo_nombre?></td>
</tr>
<?php
endforeach;
?>

