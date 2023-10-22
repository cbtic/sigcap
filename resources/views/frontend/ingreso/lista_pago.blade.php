<thead>
<tr style="font-size:13px">
	<th>Fecha</th>
	<!--<th>Tipo</th>-->
	<th>Serie</th>
	<th>Numero</th>
	<th>Concepto</th>
	<th class="sum">Monto</th>
	<th>Pago</th>
	<th>Deuda</th>
</tr>
</thead>
<tbody>
<?php 
$total = 0;
foreach($pago as $row):?>
<tr style="font-size:13px" class="test" data-toggle="tooltip" data-placement="top" title="<?php echo $row->usuario_registro?>">
	<td class="text-left"><?php echo date("d/m/Y", strtotime($row->fecha))?></td>
	<!--<td class="text-left">
	<?php 
		//if($row->fac_tipo=="FT") echo "FACTURA";
		//if($row->fac_tipo=="BV") echo "BOLETA";
		//if($row->fac_tipo=="TK") echo "TICKET";
	?>
	</td>-->
    <td class="text-left"><?php echo $row->serie?></td>
	<td class="text-left"><?php echo $row->numero?></td>
	<td class="text-left"><?php echo $row->descripcion;
		if($row->descripcion=="OTPHID SERVICIO"){
			echo '&nbsp;&nbsp;<span id="badge_empresa" class="badge badge-warning">PESAJE</span>';
		}else{
			if($row->tipo=="FT")echo '&nbsp;&nbsp;<span id="badge_empresa" class="badge badge-success">RENTA</span>';
			else if($row->tipo=="TK")echo '&nbsp;&nbsp;<span id="badge_empresa" class="badge badge-info">SERVICIOS</span>';
			else echo '&nbsp;&nbsp;<span id="badge_empresa" class="badge badge-warning">PESAJE</span>';
		}
	?>
	</td>
	<td class="text-left"><?php echo $row->total?></td>
	<td class="text-left">
		<div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions">
			<a href="/factura/<?php echo $row->id_comprobante?>" class="btn btn-sm btn-success" style="font-size:9px!important" target="_blank">
				<i class="fa fa-search" style="font-size:9px!important"></i>
			</a>
		</div>
	</td>
	<td class="text-left">
		<div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions">
			<button style="font-size:12px" type="button" class="btn btn-sm btn-warning" data-toggle="modal" onclick="modalValorizacionFactura(<?php echo $row->id_comprobante?>)" >
				<i class="fa fa-search" style="font-size:9px!important"></i>
			</button>
		</div>
	</td>
</tr>
<?php 
	
	$total += $row->total;
endforeach;
?>
</tbody>
<tfoot>
<tr>
	<th colspan="3" style="text-align:right;padding-right:55px!important;padding-bottom:0px;margin-bottom:0px">Pago Total</th>
	<td colspan="2" style="padding-bottom:0px;margin-bottom:0px">
		<input type="text" readonly name="pagoTotal" id="pagoTotal" value="<?php echo $total?>" class="form-control form-control-sm text-right"/>
	</td>
	<td colspan="2" style="padding-bottom:0px;margin-bottom:0px">&nbsp;
		
	</td>
</tr>
</tfoot>
