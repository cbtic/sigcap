<?php 
foreach($mucipalidad_detalles as $row):?>
<tr style="font-size:13px">
	<td class="text-left"><?php echo $row->id?>
	</td>
	<td class="text-left"><?php echo $row->denominacion?></td>
	<td class="text-left">
		<div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions">
			<!--<button style="font-size:12px" type="button" class="btn btn-sm btn-success" data-toggle="modal" onclick="editarPuesto(<?php echo $row->id?>)" ><i class="fa fa-edit"></i> Editar</button>-->
			<a href="javascript:void(0)" onclick=eliminarMunicipalidadDetalle(<?php echo $row->id?>) class="btn btn-sm btn-danger" style="font-size:12px;margin-left:10px">Eliminar</a>
		</div>
	</td>
</tr>
<?php
endforeach;
?>
<!--</div>-->
