<?php 

foreach($observacion_lista as $key=>$row):?>
<tr style="font-size:13px">
	<td class="text-left"><?php echo $row->id_observacion?></td>
	<td class="text-left"><?php echo $row->id_solicitud?></td>
	<td class="text-left"><?php echo $row->observacion?></td>
	<td class="text-left"><?php echo $row->fecha?></td>
	<td class="text-left"><?php echo $row->usuario?></td>
</tr>
<?php
endforeach;
?>
