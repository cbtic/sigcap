
<?php 
foreach($delegados as $row){
	$id_delegado = ($row->id_delegado>0)?$row->id_delegado:$row->id_agremiado;
	$id_tipo = ($row->id_delegado>0)?1:2;
	
	$btnDisabled="";
	$btnDisabledEliminar="";
	if($row->id_aprobar_pago==2)$btnDisabled="disabled='disabled'";
	
	if(str_contains($row->puesto,"TITULAR"))$btnDisabledEliminar="disabled='disabled'";
	
?>
<tr style='font-size:13px'>
<input type='hidden' name='id_delegado[]' value='<?php echo $id_delegado?>'>
<input type='hidden' name='id_tipo[]' value='<?php echo $id_tipo?>'>
<td class='text-left'>
<?php
$puesto = $row->puesto;
$disabled = "";
if($puesto=="")$puesto="ASESOR / ESPECIALISTA";
echo $puesto; 

if($puesto=="ASESOR / ESPECIALISTA" || $puesto=="SUPLENTE")$disabled = "disabled='disabled'";
?></td>
<td class='text-left'><?php echo $row->numero_cap?></td>
<td class='text-left'><?php echo $row->apellido_paterno." ".$row->apellido_materno." ".$row->nombres?></td>
<td class='text-left'><?php echo $row->situacion?></td>
<td class='text-center'>
<input type="radio" <?php echo $disabled?> name="coordinador" value="<?php echo $id_delegado?>" <?php if($row->coordinador==1)echo "checked='checked'"?> onChange="guardar_coordinador(<?php echo $row->id?>,<?php echo $id_delegado?>)" />
</td>
<td class='text-center'>
<input type="checkbox" class="<?php if($row->situacion!="INHABILITADO" )echo "id_aprobar_pago"?>" name="id_aprobar_pago[<?php echo $id_delegado?>]" value="<?php echo $id_delegado?>" onchange="habilitarAprobar(this)"
<?php 
if($row->id_aprobar_pago==2)echo "checked='checked'";
if($row->situacion=="INHABILITADO" )echo "disabled='disabled'";
?> 
/>
</td>

<td class='text-left'><?php echo $row->numero_cap_anterior?></td>
<td class='text-left'><?php echo $row->apellido_paterno_anterior." ".$row->apellido_materno_anterior." ".$row->nombres_anterior?></td>
<td class='text-left'><button style='font-size:12px' type='button' class='btn btn-sm btn-warning' data-toggle='modal' onclick=modalHistorialDelegadoSesion('<?php echo $row->id?>') >Ver Historial</button></td>


<td class='text-left'><button <?php echo $btnDisabled?> style='font-size:12px' type='button' class='btn btn-sm btn-success edit_delegado' data-toggle='modal' onclick=modalAsignarDelegadoSesion('<?php echo $row->id?>') >Editar</button></td>
<td class='text-left'>
	<button <?php echo $btnDisabled?> <?php echo $btnDisabledEliminar?> style='font-size:12px' type='button' class='btn btn-sm btn-danger delete_delegado' data-toggle='modal' onclick=eliminarDelegadoSesion('<?php echo $row->id?>') >Eliminar</button>
</td>
<?php 
}
?>
