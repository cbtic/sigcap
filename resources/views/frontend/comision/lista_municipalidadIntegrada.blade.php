<!--<div data-bs-spy="scroll" data-bs-target="#navbar-example2" data-bs-offset="0" class="scrollspy-example" tabindex="0">-->
<?php 
foreach($municipalidad_integradas as $row):?>
<tr style="font-size:13px">
	<td class="text-center">
	<input value="<?php echo $row->id?>"  type="checkbox" id="check_" name="check_[]" onchange="filtrar_comision(this)">
	</td>
	<td class="text-left"><?php echo $row->denominacion?></td>
	<td class="text-left"><?php echo $row->tipo_agrupacion?></td>
	<td class="text-left"><?php echo $row->monto?></td>
	<td class="text-left" style="width:100px">
	<input class="btn btn-danger pull-rigth" value="X" type="button" id="btnEliminar" style="margin-left:0px; font-size: 9px;float:left" onclick="eliminarMuniIntegrada(<?php echo $row->id?>, '<?php echo $row->estado?>');" />
	<?php if($row->tipo_agrupacion=="INTEGRADOS"){?>
		<button style="font-size:9px;margin-left:3px;float:left;padding-top:8px;padding-bottom:8px" type="button" class="btn btn-success" data-toggle="modal" onclick="modalMunicipalidadIntegrada(<?php echo $row->id?>)"><i class="fa fa-edit"></i></button>
	<?php } ?>
	</td>
</tr>
<?php
endforeach;
?>
<!--</div>-->
