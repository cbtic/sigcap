
<?php 
foreach($concursoRequisito as $row):?>
<tr style="font-size:13px">
	<td class="text-left" style="vertical-align:middle"><?php echo $row->id?></td>
	<td class="text-left" style="vertical-align:middle"><?php echo $row->tipo_documento?></td>
	<td class="text-left" style="vertical-align:middle"><?php echo $row->requisito?></td>
</tr>
<?php 
endforeach;
?>
