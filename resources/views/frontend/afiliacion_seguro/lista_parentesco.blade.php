<?php 

foreach($parentesco_lista as $key=>$row):
	//echo $row->id_seguro_afiliado_parentesco;
?>
<tr style="font-size:13px">
	<td class="text-center">
        <div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions">		
			
			<input type="checkbox" <?php if($row->id_seguro_afiliado_parentesco>0)echo "disabled='disabled'"?> class="mov" name="parentescos[<?php echo $key?>][id]" value="<?php echo $row->id?> " />
			<input type="hidden" name="parentesco[<?php echo $key?>][id]" value="<?php echo $row->id?>" />
			<input type="hidden" name="parentesco[<?php echo $key?>][id_afiliacion]" value="<?php echo $row->id_afiliacion?>" />
			<input type="hidden" name="parentesco[<?php echo $key?>][id_agremiado]" value="<?php echo $row->id_agremiado?>" />
			<input type="hidden" name="parentesco[<?php echo $key?>][id_familia]" value="<?php echo $row->id_familia?>" />
			<input type="hidden" name="parentesco[<?php echo $key?>][edad]" value="<?php echo $row->edad?>" />
			<input type="hidden" name="parentesco[<?php echo $key?>][sexo]" value="<?php echo $row->id_sexo?>" />
            <input type="hidden" name="parentesco[<?php echo $key?>][id_plan]" value="<?php echo $row->id_plan?>" />
			
            
        </div>
    </td>
	
    <td class="text-left"><?php echo $row->id?> </td>
	<td class="text-left"><?php echo $row->parentesco?> </td>
	<td class="text-left"><?php echo $row->dependencia?> </td>
	<td class="text-left"><?php echo $row->nombre?> </td>
	<td class="text-left"><?php echo $row->sexo?> </td>
	<td class="text-left"><?php echo $row->edad?> </td>
	<td class="text-left"><?php echo $row->plan?> </td>
	<td class="text-left"><?php echo $row->monto?> </td>
	<td class="text-left"><?php echo $row->moneda?> </td>
	


</tr>
<?php 
	

	
endforeach;
?>

