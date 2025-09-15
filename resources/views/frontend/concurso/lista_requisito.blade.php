
<?php 
foreach($inscripcionDocumento as $row):?>
<tr style="font-size:13px">
	<!--<td class="text-left" style="vertical-align:middle"><?php //echo $row->id?></td>-->
	<td class="text-left" style="vertical-align:middle"><?php echo $row->orden_requisito?></td>
	<td class="text-left" style="vertical-align:middle"><?php echo $row->observacion?></td>
	<td class="text-left" style="vertical-align:middle"><?php echo $row->tipo_documento?></td>
	<td class="text-left" style="vertical-align:middle"><?php echo $row->fecha_documento?></td>
	<td class="text-left">
		<!--<img src="/img/documento/<?php echo $row->ruta_archivo?>" id="img_ruta" width="50px" height="50px" alt="" style="margin-top:10px" />-->
		<a href="/<?php echo $row->ruta_archivo?>" target="_blank" class="btn btn-sm btn-secondary">Ver Archivo</a>
	</td>
	<td class="text-left" style="vertical-align:middle">
		<div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions">
			<button style="font-size:12px;color:#FFFFFF" type="button" class="btn btn-sm btn-info" data-toggle="modal" onclick="modalRequisito(<?php echo $row->id?>)" >
				<i class="fa fa-edit" style="font-size:9px!important"></i> Editar
			</button>
			<a href="javascript:void(0)" onclick="eliminarInscripcionDocumento('<?php echo $row->id?>')" class="btn btn-sm btn-danger" style="font-size:12px;margin-left:10px">Eliminar</a>
		</div>
	</td>
</tr>
<?php 
endforeach;
?>
