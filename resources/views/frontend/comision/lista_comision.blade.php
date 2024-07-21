<!--<div data-bs-spy="scroll" data-bs-target="#navbar-example2" data-bs-offset="0" class="scrollspy-example" tabindex="0">-->
<?php 
foreach($comision as $row):?>
<tr style="font-size:13px">
	<td class="text-center">
	<input value="<?php echo $row->id?>"  type="checkbox" id="check_" name="check_[]">
	</td>
	<td class="text-left"><?php echo $row->denominacion?></td>
	<td class="text-left"><?php echo $row->comision?></td>
	<td class="text-left"><?php echo $row->dia_semana?></td>
	<!--<td class="text-left"><?php //echo $row->monto?></td>-->
	<!--<td class="text-left"><?php /*if($row->estado=='1') {echo "Activo";} else {echo "Inactivo";}*/?></td>-->
	<td class="text-left">
	<input class="btn btn-success pull-rigth" value="Titular" type="button" id="btnNuevo" style="margin-left:15px" onclick="modalAsignarDelegado(<?php echo $row->id?>);" />
	</td>
	<td class="text-left">
	<input class="btn btn-danger pull-rigth" value="X" type="button" id="btnEliminar" style="margin-left:10px; font-size: 10px;" onclick="eliminarComision(<?php echo $row->id?>, '<?php echo $row->estado?>');" />
	</td>
</tr>
<?php
endforeach;
?>
<!--</div>-->
