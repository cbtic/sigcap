
<?php 
foreach($dictamen as $row):?>
<tr style="font-size:13px">
	<!--<td class="text-left" style="vertical-align:middle"><?php //echo $row->codigo?></td>-->
	<td class="text-left" style="vertical-align:middle"><?php echo $row->tipo_sol?></td>
	<td class="text-left" style="vertical-align:middle"><?php echo $row->distrito?></td>
	<td class="text-left" style="vertical-align:middle"><?php echo $row->numero_revision?></td>
	<td class="text-left" style="vertical-align:middle"><?php echo $row->credipago?></td>
	<td class="text-left" style="vertical-align:middle"><?php echo round($row->total,2)?></td>
	<!--<td class="text-left" style="vertical-align:middle"><?php //echo $row->fecha_liquidacion?></td>
	<td class="text-left" style="vertical-align:middle"><?php //echo $row->nombre?></td>
	<td class="text-left" style="vertical-align:middle"><?php //echo $row->direccion?></td>-->
	<td class="text-left" style="vertical-align:middle"><?php echo $row->dictamen?></td>
	<td class="text-left" style="vertical-align:middle"><?php echo $row->numero_expediente?></td>
	<td class="text-left">
		<div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions">
			<button style="font-size:12px;" type="button" class="btn btn-sm btn-warning" data-toggle="modal" onclick="modalVerProyectista(<?php echo $row->id_solicitud?>)"><i class="fa fa-edit" style="font-size:9px!important"></i>Proyectista
			</button>
		</div>
	</td>
	
</tr>
<?php 
endforeach;
?>
