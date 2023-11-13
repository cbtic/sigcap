<!--<div data-bs-spy="scroll" data-bs-target="#navbar-example2" data-bs-offset="0" class="scrollspy-example" tabindex="0">-->
<?php 
foreach($municipalidad as $row):?>
<tr style="font-size:13px">
	<td class="text-center">
	<input value="<?php //echo $row->id?>"  type="checkbox" id="check_" name="check_[]">
	</td>
	<td class="text-left"><?php echo $row->denominacion?></td>
	<td class="text-left"><?php echo $row->tipo_municipalidad?></td>
</tr>
<?php
endforeach;
?>


<!--</div>-->