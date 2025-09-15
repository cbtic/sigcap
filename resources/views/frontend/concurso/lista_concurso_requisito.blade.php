
<?php 
foreach($concursoRequisito as $row):?>
<tr style="font-size:13px">
	<!--<td class="text-left" style="vertical-align:middle"><?php //echo $row->id?></td>-->
	<td class="text-left" style="vertical-align:middle"><?php echo $row->requisito?></td>
	<td class="text-left" style="vertical-align:middle"><?php echo $row->tipo_documento?></td>
	<td class="text-left" style="vertical-align:middle">
	<?php if($row->requisito_archivo!=""){?>
	<a href="/img/documento_requisito/<?php echo $row->requisito_archivo?>" target="_blank" class="btn btn-sm btn-secondary">Ver Archivo</a>
	<?php }?>
	</td>
</tr>
<?php 
endforeach;
?>
