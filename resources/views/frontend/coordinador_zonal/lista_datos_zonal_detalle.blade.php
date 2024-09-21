<?php 

foreach($zonal_detalle as $key=>$row):?>
<tr style="font-size:13px">
	<td class="text-left"><?php echo $row->periodo?></td>
	<td class="text-left"><?php echo $row->tipo_coordinador?></td>
	<td class="text-left"><?php echo $row->municipalidad?></td>
	<td class="text-left"><a href="javascript:void(0)" onclick="eliminarZonalDetalle(<?php echo $row->id?>,<?php echo $row->estado?>)" class="btn btn-sm btn-danger" style="font-size:12px;margin-left:10px">Eliminar</a></td>
</tr>
<?php
endforeach;
?>

<script>
function eliminarZonalDetalle(id,estado){
	var act_estado = "";
	if(estado==1){
		act_estado = "Eliminar";
		estado_=0;
	}
	if(estado==0){
		act_estado = "Activar";
		estado_=1;
	}
    bootbox.confirm({ 
        size: "small",
        message: "&iquest;Deseas "+act_estado+" la Municipalidad?", 
        callback: function(result){
            if (result==true) {
                fn_eliminar_zonal_detalle(id,estado_);
            }
        }
    });
    $(".modal-dialog").css("width","30%");
}

function fn_eliminar_zonal_detalle(id,estado){

    $.ajax({
            url: "/coordinador_zonal/eliminar_zonal_detalle/"+id+"/"+estado,
            type: "GET",
            success: function (result) {
                //if(result="success")obtenerPlanDetalle(id_plan);
				//datatablenew();
				//limpiar();
				datatableZonalDetalle()
            }
    });
}

</script>

