
<?php 
foreach($dictamen as $row):?>
<tr style="font-size:13px">
	<td class="text-left" style="vertical-align:middle"><?php echo $row->id?></td>
	<td class="text-left" style="vertical-align:middle"><?php echo $row->ruta_dictamen?></td>
	<td class="text-left" style="vertical-align:middle"><?php echo $row->observaciones?></td>
</tr>
<?php 
endforeach;
?>
