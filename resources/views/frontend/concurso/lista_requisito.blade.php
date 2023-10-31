
<?php 
foreach($inscripcionDocumento as $row):?>
<tr style="font-size:13px">
	<td class="text-left"><?php echo $row->id?></td>
	<td class="text-left"><?php echo $row->tipo_documento?></td>
	<td class="text-left"><?php echo $row->observacion?></td>
	<td class="text-left"></td>
	<td class="text-left">
		<div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions">
			<button style="font-size:12px" type="button" class="btn btn-sm btn-warning" data-toggle="modal" onclick="modalValorizacionFactura(<?php //echo $row->id_factura?>)" >
				<i class="fa fa-search" style="font-size:9px!important"></i>
			</button>
		</div>
	</td>
</tr>
<?php 
endforeach;
?>
