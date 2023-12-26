
<?php 
foreach($dictamen as $row):?>
<tr style="font-size:13px">
	<td class="text-left" style="vertical-align:middle"><?php echo $row->codigo?></td>
	<td class="text-left" style="vertical-align:middle"><?php echo $row->tipo_sol?></td>
	<td class="text-left" style="vertical-align:middle"><?php echo $row->numero_revision?></td>
	<td class="text-left" style="vertical-align:middle"><?php echo $row->credipago?></td>
	<td class="text-left" style="vertical-align:middle"><?php echo $row->nombre?></td>
	<td class="text-left" style="vertical-align:middle"><?php echo $row->direccion?></td>
	<td class="text-left" style="vertical-align:middle"><?php echo $row->dictamen?></td>
</tr>
<?php 
endforeach;
?>
