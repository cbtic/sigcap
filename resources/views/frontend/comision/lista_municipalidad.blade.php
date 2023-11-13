
<?php 
foreach($municipalidad as $row):?>
<tr style="font-size:13px">
	<td class="text-center" style="vertical-align:middle">
	<input value="<?php echo $row->id?>"  type="checkbox" id="check_" name="check_[]">
	</td>
	<td class="text-left" style="vertical-align:middle"><?php echo $row->denominacion?></td>
	<td class="text-left" style="vertical-align:middle"><?php echo $row->tipo_municipalidad?></td>
</tr>
<?php
endforeach;
?>
