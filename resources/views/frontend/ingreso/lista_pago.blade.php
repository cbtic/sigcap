<thead>
<tr style="font-size:13px">
	<th>Fecha</th>
	<!--<th>Tipo</th>-->
	<th>Serie</th>
	<th>Numero</th>
	<th>Concepto</th>
	<th>Est.Pago</th>
	<th class="sum">Monto</th>
	<th>Pago</th>
	<th>Deuda</th>
	<th>NC</th>
	<th>ND</th>
</tr>
</thead>
<tbody>
<?php 
$total = 0;
foreach($pago as $row){?>
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
	<td class="text-left" ><?php echo $row->numero?>
	<input type="hidden" class="id_comprobante" value="<?php echo $row->id_comprobante?>" />
	</td>

	<td class="text-left"><?php echo $row->descripcion;
	/*
		if($row->descripcion=="OTPHID SERVICIO"){
			echo '&nbsp;&nbsp;<span id="badge_empresa" class="badge badge-warning">PESAJE</span>';
		}else{
			if($row->tipo=="FT")echo '&nbsp;&nbsp;<span id="badge_empresa" class="badge badge-success">RENTA</span>';
			else if($row->tipo=="TK")echo '&nbsp;&nbsp;<span id="badge_empresa" class="badge badge-info">SERVICIOS</span>';
			else echo '&nbsp;&nbsp;<span id="badge_empresa" class="badge badge-warning">SERVICIOS</span>';
		}
		*/
	?>
	</td>
	<td class="text-left"><?php echo $row->estado_pago?></td>
	<td class="text-left"><?php echo $row->total?></td>	
	<td class="text-left">
		<div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions">
			<a href="/comprobante/<?php echo $row->id_comprobante?>" class="btn btn-sm btn-success" style="font-size:9px!important" target="_blank">
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
	<td class="text-left">
		@hasanyrole('Administrator|Caja|Caja Jefe')
                                        
		<form class="form-horizontal" method="post" action="{{route('frontend.comprobante.nc_edita')}}" id="frmPagos" name="frmPagos" autocomplete="off">		
		
		<input type='hidden' name="id_comprobante" id="id_comprobante" value="">		
		<input type='hidden' name="id_comprobante_origen" id="id_comprobante_origen" value="<?php echo $row->id_comprobante?>">	

		<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">		
		

		<?php 
		if($row->tiene_nc=== null){?>
			
			<input class="btn btn-secondary pull-light" value="NC" type="button" id="btnBoleta" onclick="nc(<?php echo $row->id_comprobante?>,<?php echo $row->tiene_nc?>)">

		<?php 	
		}else{
		?>
			
			<input class="btn btn-primary pull-light" value="NC" type="button" id="btnBoleta" onclick="fn_nc_nd(<?php echo $row->tiene_nc?>)">


		<?php 	
		};                       
		?>

		
		</form>
		@endhasanyrole
	</td>
	<td class="text-left">

		@hasanyrole('Administrator|Caja|Caja Jefe')
	    <form class="form-horizontal" method="post" action="{{route('frontend.comprobante.nd_edita')}}" id="frmPagos_nd" name="frmPagos_nd" autocomplete="off">		
		<input type='hidden' name="id_comprobante" id="id_comprobante" value="">		
		<input type='hidden' name="id_comprobante_origen_nd" id="id_comprobante_origen_nd" value="<?php echo $row->id_comprobante?>">	
		
		<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
		<?php 
		if($row->tiene_nd=== null){?>
			<input class="btn btn-secondary pull-rigth" value="ND" type="button" id="btnBoleta" onclick="nd(<?php echo $row->id_comprobante?>,<?php echo $row->tiene_nd?>)">
		<?php 	
		}else{
		?>			
			<input class="btn btn-primary pull-light" value="ND" type="button" id="btnBoleta" onclick="fn_nc_nd(<?php echo $row->tiene_nd?>)">
		<?php 	
		};                       
		?>

		
		
		</form>
		@endhasanyrole
	</td>
</tr>
<?php 	
	$total += $row->total;
	};
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

<script type="text/javascript">

	function fn_nc_nd(id) {
		//alert("OK");
		//var html = '<div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions">';                                
		//html += '<a href="/comprobante/'+id+'" class="btn btn-sm btn-info" target="_blank"><i class="fa fa-paper-plane"></i></a>';
		//return html;
		if (id == "")id = 0;
		var href = '/comprobante/' + id;
		window.open(href, '_blank');

	}
</script>
