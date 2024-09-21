<title>Sistema SIGCAP</title>

<style>
/*
.datepicker {
  z-index: 1600 !important; 
}
*/
/*.datepicker{ z-index:99999 !important; }*/

.datepicker,
.table-condensed {
  width: 250px;
  height:250px;
}


.modal-dialog {
	width: 100%;
	max-width:60%!important
  }
  
#tablemodal{
    border-spacing: 0;
    display: flex;/*Se ajuste dinamicamente al tamano del dispositivo**/
    max-height: 80vh; /*El alto que necesitemos**/
    overflow-y: auto; /**El scroll verticalmente cuando sea necesario*/
    overflow-x: hidden;/*Sin scroll horizontal*/
    table-layout: fixed;/**Forzamos a que las filas tenga el mismo ancho**/
    width: 98vw; /*El ancho que necesitemos*/
    border:1px solid #c4c0c9;
}

#tablemodal thead{
    background-color: #e2e3e5;
    position: fixed !important;
}


#tablemodal th{
    border-bottom: 1px solid #c4c0c9;
    border-right: 1px solid #c4c0c9;
}

#tablemodal th{
    font-weight: normal;
    margin: 0;
    max-width: 9.5vw; 
    min-width: 9.5vw;
    word-wrap: break-word;
    font-size: 10px;
	font-weight:bold;
    height: 3.5vh !important;
	line-height:12px;
	vertical-align:middle;
	/*height:20px;*/
    padding: 4px;
    border-right: 1px solid #c4c0c9;
}

#tablemodal td{
    font-weight: normal;
    margin: 0;
    max-width: 9.5vw; 
    min-width: 9.5vw;
    word-wrap: break-word;
    font-size: 11px;
    height: 3.5vh !important;
    padding: 4px;
    border-right: 1px solid #c4c0c9;
}

#tablemodal tbody tr:hover td, #tablemodal tbody tr:hover th {
  /*background-color: red!important;*/
  font-weight:bold;
  /*mix-blend-mode: difference;*/
  
}

</style>

<!--<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet"/>-->
<!--<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>-->
<!--<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>-->


<!--<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>-->


<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" />
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>-->

<!--
<script src="resources/plugins/timepicker/bootstrap-timepicker.min.js"></script>
<link rel="stylesheet" href="resources/plugins/timepicker/bootstrap-timepicker.min.css">
-->

<!--
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker-standalone.css">
-->

<!--
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/3.1.4/js/bootstrap-datetimepicker.min.js" integrity="sha512-r/mHP22LKVhxWFlvCpzqMUT4dWScZc6WRhBMVUQh+SdofvvM1BS1Hdcy94XVOod7QqQMRjLQn5w/AQOfXTPvVA==" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/3.1.4/css/bootstrap-datetimepicker.css" integrity="sha512-HWqapTcU+yOMgBe4kFnMcJGbvFPbgk39bm0ExFn0ks6/n97BBHzhDuzVkvMVVHTJSK5mtrXGX4oVwoQsNcsYvg==" crossorigin="anonymous" />
-->

<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js"></script>-->
<script type="text/javascript">

/*
jQuery(function($){
$.mask.definitions['H'] = "[0-1]";
$.mask.definitions['h'] = "[0-9]";
$.mask.definitions['M'] = "[0-5]";
$.mask.definitions['m'] = "[0-9]";
$.mask.definitions['P'] = "[AaPp]";
$.mask.definitions['p'] = "[Mm]";
});
*/
$(document).ready(function() {
	$("#concepto").select2({ width: '100%' });
	//$('#hora_solicitud').focus();
	//$('#hora_solicitud').mask('00:00');
	//$("#id_empresa").select2({ width: '100%' });
});
</script>

<script type="text/javascript">

$('#openOverlayOpc').on('shown.bs.modal', function() {
     $('#fecha_solicitud').datepicker({
		format: "dd-mm-yyyy",
		autoclose: true,
		//container: '#openOverlayOpc modal-body'
		container: '#openOverlayOpc modal-body'
     });
	 /*
	 $('#hora_solicitud').timepicker({
		showInputs: false,
		container: '#openOverlayOpc modal-body'
	});
	*/
	 
});

$(document).ready(function() {
	 
	 

});

function validacion(){
    
    var msg = "";
    var cobservaciones=$("#frmComentar #cobservaciones").val();
    
    if(cobservaciones==""){msg+="Debe ingresar una Observacion <br>";}
    
    if(msg!=""){
        bootbox.alert(msg); 
        return false;
    }
}


function valida(){
	var mensaje= "0";

	var _token = $('#_token').val();
	var id = $('#id').val();
	var id_regional = $('#id_regional').val();
	var nombre = $('#denominacion_').val();
	var descripcion =$('#descripcion_').val();	
	var concepto =$('#concepto').val();	
	

	if (nombre==""){
	   mensaje= "Falta ingresar la denominacion del Seguro";

	}

	if (mensaje=="0")[
		fn_save()		
		]
	else {
		Swal.fire(mensaje);
	}

}

function fn_save(){
    
	var _token = $('#_token').val();
	var id = $('#id').val();
	var id_regional = $('#id_regional').val();
	var nombre = $('#denominacion_').val();
	var descripcion =$('#descripcion_').val();	
	var concepto =$('#concepto').val();	

    $.ajax({
			url: "/seguro/send_seguro",
            type: "POST",
            data : {_token:_token,id:id,id_regional:id_regional,nombre:nombre,descripcion:descripcion,concepto:concepto},
            success: function (result) {
				$('#openOverlayOpc').modal('hide');
				window.location.reload();
				//datatablenew();
								
            }
    });

}



</script>


<body class="hold-transition skin-blue sidebar-mini">

    <div>
		<!--
        <section class="content-header">
          <h1>
            <small style="font-size: 20px">Programados del Medicos del dia <?php //echo $fecha_atencion?></small>
          </h1>
        </section>
		-->
		<div class="justify-content-center">		

		<div class="card">
			
			<div class="card-header" style="padding:5px!important;padding-left:20px!important">
				Edici&oacute;n Seguros
			</div>
			
            <div class="card-body">

			<div class="row">

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:10px">
					
					<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
					<input type="hidden" name="id" id="id" value="<?php echo $id?>">
					
					
					<div class="row">
						
						<?php 
							$readonly=$id>0?"readonly='readonly'":'';
							$readonly_=$id>0?'':"readonly='readonly'";
						?>
						
						<div class="col-lg-12">
							<div class="form-group">
								<label class="control-label form-control-sm">Regional</label>
								<select name="id_regional" readonly id="id_regional" class="form-control form-control-sm" onChange="">
									<option value="">--Selecionar--</option>
									<?php
									foreach ($region as $row) {?>
									<option value="<?php echo $row->id?>" <?php if($row->id==$id_regional)echo "selected='selected'"?>><?php echo $row->denominacion?></option>
									<?php 
									}
									?>
								</select>
							</div>
						</div>
						
						<div class="col-lg-12">
							<div class="form-group">
								<label class="control-label">Denominacion</label>
								<input id="denominacion_" name="denominacion_" class="form-control form-control-sm"  value="<?php echo $seguro->nombre?>" type="text"  >
							</div>
						</div>

						<div class="col-lg-12">
							<div class="form-group">
								<label class="control-label">Descripción</label>
								<input id="descripcion_" name="descripcion_" class="form-control form-control-sm"  value="<?php echo $seguro->descripcion?>" type="textarea"  >
							</div>
						</div>
						<div class="col-lg-10">
									<div class="form-group">
										<label class="control-label form-control-sm">Concepto</label>
										<select name="concepto" id="concepto" class="form-control form-control-sm" onChange="">
										<option value="">--Selecionar--</option>
											<?php
												foreach ($concepto as $row) {?>
											<option value="<?php echo $row->id?>" <?php if($row->id==$seguro->id_concepto)echo "selected='selected'"?>><?php echo $row->denominacion?></option>
											<?php 
											}
											?>
										</select>
									</div>
								</div>
					
				
					</div>
					<!--
					<div class="card">
					<div class="card-header">
						Detalles Plan
					</div>
					<div class="card-body">
						
						<div class="row">
							<div class="col-lg-1 col-md-12 col-sm-12 col-xs-12"> 
								<label class="control-label">Id</label>								
							</div>
							<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
								<input id="id_plan_" name="id_plan_" class="form-control form-control-sm"   type="text" readonly  >
							</div>
							<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
								<label class="control-label">Nombre Plan</label>
							</div>
							<div class="col-lg-7 col-md-12 col-sm-12 col-xs-12">
								<input id="nombre_plan_" name="nombre_plan_" class="form-control form-control-sm"  value="<?php echo $seguro->descripcion?>" type="textarea"  >
							</div>

						</div>

						<div class="row">
							
							<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
								<label class="control-label">Fecha Inicio</label>
							</div>
							<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
								<input id="descripcion_" name="descripcion_" class="form-control form-control-sm"  value="<?php echo $seguro->descripcion?>" type="date"  >
							</div>
							<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
								<label class="control-label">Fecha Fin</label>
							</div>
							<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
								<input id="descripcion_" name="descripcion_" class="form-control form-control-sm"  value="<?php echo $seguro->descripcion?>" type="date"  >
							</div>
							<div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
								<label class="control-label">Monto</label>
							</div>
							<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
								<input id="descripcion_" name="descripcion_" class="form-control form-control-sm"  value="<?php echo $seguro->descripcion?>" type="text"  >
							</div>
						</div>
						

						<div class="row">
							<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
								<label class="control-label">Descripcion</label>
							</div>
							<div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
								<input id="descripcion_" name="descripcion_" class="form-control form-control-sm"  value="<?php echo $seguro->descripcion?>" type="textarea"  >
							</div>
						</div>
					</div>
					</div>

					<div style="margin-top:10px" class="form-group">
						<div class="col-sm-12 controls">
							<div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions">
								<a href="javascript:void(0)" onClick="fn_save()" class="btn btn-sm btn-primary">Añadir</a>
								
							</div>
												
						</div>
					</div> 
				<form class="form-horizontal" method="post" action="" id="grdPlanSeguro" autocomplete="off">
				<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
				
                <div class="card-body">				

                    <div class="table-responsive">
                    <table id="tblAfiliado" class="table table-hover table-sm">
                        <thead>
                        <tr style="font-size:13px">
                            <th>Id</th>
                            <th>Plan</th>
							<th>Fecha Inicio</th>
							<th>Fecha Fin</th>
							<th>Monto</th>                                                        
							<th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                        </thead>
                        <tbody style="font-size:13px">
											<?php  
											//$n = 0;
											//foreach($plan_seguro as $row){
												//if(!isset($row->msg)){
											?>
											<tr>
												
												<td width="10%"><?php //echo $row->id?></td>
												<td width="30%"><?php //echo $row->nombre?></td>
												<td width="15%"><?php //echo $row->fecha_inicio?></td>
												<td width="15%"><?php //echo $row->fecha_fin?></td>
												<td width="10%"><?php //echo $row->monto?></td>												
												<td width="10%"><?php //echo $row->estado?></td>
												<td> <button style="font-size:12px" type="button" class="btn btn-sm btn-success" data-toggle="modal" onClick="modalSeguro('+row.id+')" ><i class="fa fa-edit"></i> Editar</button><d>
												
											</tr>
											<?php 
												//}else{
													
												//}
												//}	
											?>
										</tbody>
                    </table>
                </div>
				-->
			</form>
					
					<div style="margin-top:10px" class="form-group">
						<div class="col-sm-12 controls">
							<div class="btn-group btn-group-sm float-right" role="group" aria-label="Log Viewer Actions">
								<a href="javascript:void(0)" onClick="valida()" class="btn btn-sm btn-success">Guardar</a>
								
							</div>
												
						</div>
					</div> 
					
              </div>
			  
              
          </div>
          <!-- /.box -->
          

        </div>
        <!--/.col (left) -->
            
     
          </div>
          <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    
<script type="text/javascript">
$(document).ready(function () {

	$('#ruc_').blur(function () {
		var id = $('#id').val();
			if(id==0) {
				validaRuc(this.value);
			}
		//validaRuc(this.value);
	});
	
	
	
	
});


</script>

<script type="text/javascript">
$(document).ready(function() {
	//$('#numero_placa').focus();
	//$('#numero_placa').mask('AAA-000');
	//$('#vehiculo_numero_placa').mask('AAA-000');
	
	
});




</script>

