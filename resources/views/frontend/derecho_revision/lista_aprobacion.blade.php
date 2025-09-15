<?php 

foreach($aprobacion_lista as $key=>$row):?>
<tr style="font-size:13px">
	<td class="text-left"><?php echo $row->id?></td>
	<td class="text-left"><?php echo $row->usuario?></td>
	<td class="text-left"><?php echo $row->fecha_aprobacion?></td>
	<td class="text-left"><?php echo $row->nota?></td>
</tr>
<?php
endforeach;
?>
