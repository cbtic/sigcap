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

#tablemodalm{
	
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
	//$('#hora_solicitud').focus();
	//$('#hora_solicitud').mask('00:00');
	//$("#id_empresa").select2({ width: '100%' });
});
</script>

<script type="text/javascript">

$('#openOverlayOpc').on('shown.bs.modal', function() {
     $('#fecha_documento').datepicker({
		format: "dd-mm-yyyy",
		autoclose: true,
		container: '#openOverlayOpc modal-body'
     });
	 /*
	 $('#fecha_inscripcion').datepicker({
		format: "dd-mm-yyyy",
		autoclose: true,
		container: '#openOverlayOpc modal-body'
     });
	 */
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


$(document).ready(function() {
    $(".upload").on('click', function() {
        var formData = new FormData();
        var files = $('#image')[0].files[0];
        formData.append('file',files);
        $.ajax({
			headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "/concurso/upload_documento",
            type: 'post',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response != 0) {
					
					var extension = "";
					extension = response.substring(response.lastIndexOf('.') + 1);
					
					if(extension=="doc" || extension=="docx" || extension=="pdf" || extension=="xls" || extension=="xlsx"){
						$("#img_ruta").attr("src", "/img/check.png");
					}else{
						$("#img_ruta").attr("src", "/img/frontend/tmp_documento/"+response);
					}
					
					$("#img_foto").val(response);
                } else {
                    alert('Formato de imagen incorrecto.');
                }
            }
        });
        return false;
    });
});


function fn_save_documento(){
    
	var _token = $('#_token').val();
	var id = $('#id').val();
	var id_concurso_inscripcion = $("#id_concurso_inscripcion").val();
	var id_tipo_documento = $('#id_tipo_documento').val();
	var observacion = $('#observacion').val();
	var img_foto = $('#img_foto').val();
	var fecha_documento = $('#fecha_documento').val();
	var orden_requisito = $('#orden_requisito').val();
	
	var msg = "";
	
	if(id_tipo_documento == "0")msg += "Debe seleccionar un Tipo de documento <br>";
	if(fecha_documento == "")msg += "Debe ingresar una Fecha de documento <br>";
	if(img_foto == "")msg += "Debe subir un documento <br>";
	if(observacion == "")msg += "Debe ingresar una Observaci&oacute;n o Nombre del documento <br>";

	if(msg!=""){
        bootbox.alert(msg);
        return false;
    }
	
    $.ajax({
			url: "/concurso/send_concurso_documento",
            type: "POST",
            data : {_token:_token,id:id,id_concurso_inscripcion:id_concurso_inscripcion,id_tipo_documento:id_tipo_documento,observacion:observacion,img_foto:img_foto,fecha_documento:fecha_documento,orden_requisito:orden_requisito},
			dataType: 'json',
            success: function (result) { 
			
				if(result.cantidad>0){
					bootbox.alert("El orden de requisito ingresado ya existe, verifique y cambielo"); 
        			return false;
				}
			
				$('#openOverlayOpc').modal('hide');
				//window.location.reload();
				datatablenew();
				cargarRequisitos(id_concurso_inscripcion);
				$("#divAlertaDocumento").hide();
				
				var msg_alerta = "";
				if(result.inscripcionDocumento>=result.concursoRequisito){
					msg_alerta = "&iquest;Se registro correctamente "+result.inscripcionDocumento+" de "+result.concursoRequisito+" requisitos, <b style='font-size: 20px;'>ha culminado con adjuntar los requisitos</b>.";
				}
				
				if(result.inscripcionDocumento<result.concursoRequisito){
					msg_alerta = "&iquest;Se registro correctamente "+result.inscripcionDocumento+" de "+result.concursoRequisito+" requisitos, deseas registrar otro documento?";
				}

				bootbox.confirm({ 
					size: "small",
					//message: "&iquest;Se registro correctamente, deseas registrar otro documento?, caso contrario ya culmino su postulaci&oacute;n", 
					message: msg_alerta,
					callback: function(result){
						if (result==true) {
							modalRequisito(0);
						}
					}
				});
				
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
				Edici&oacute;n Documento
			</div>
			
            <div class="card-body">

			<div class="row">

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:10px">
					
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<input type="hidden" name="id" id="id" value="<?php echo $id?>">
					
					
					<div class="row">
						
						<?php 
							$readonly=$id>0?"readonly='readonly'":'';
							$readonly_=$id>0?'':"readonly='readonly'";
						?>
						
						<div class="col-lg-2">
							<div class="form-group">
								<label class="control-label form-control-sm">Orden Requisito</label>
								<input id="orden_requisito" name="orden_requisito" class="form-control form-control-sm"  value="<?php echo $inscripcionDocumento->orden_requisito?>" type="text">
							</div>
						</div>
						
						<div class="col-lg-12">
							<div class="form-group">
								<label class="control-label form-control-sm">Tipo Documento</label>
								<select name="id_tipo_documento" id="id_tipo_documento" class="form-control form-control-sm" onChange="">
									<option value="0">--Selecionar--</option>
									<?php
									foreach ($tipo_documento as $row) {?>
									<option value="<?php echo $row->codigo?>" <?php if($row->codigo==$inscripcionDocumento->id_tipo_documento)echo "selected='selected'"?>><?php echo $row->denominacion?></option>
									<?php 
									}
									?>
								</select>
							</div>
						</div>
						
						<div class="col-lg-12">
							<div class="form-group">
								<label class="control-label form-control-sm">Fecha Documento</label>
								<input id="fecha_documento" name="fecha_documento" class="form-control form-control-sm"  value="<?php echo $inscripcionDocumento->fecha_documento?>" type="text">
							</div>
						</div>
						
						<div class="col-lg-12">
							<div class="form-group">
								
								<span class="btn btn-sm btn-warning btn-file">
									Examinar <input id="image" name="image" type="file" />
								</span>
								<input type="button" class="btn btn-sm btn-primary upload" value="Subir" style="margin-left:10px">
								<?php
								$img = "/img/logo-sin-fondo2.png";
								if($inscripcionDocumento->ruta_archivo!="")$img="/".$inscripcionDocumento->ruta_archivo;
								?>
								<img src="<?php echo $img?>" id="img_ruta" width="240px" height="150px" alt="" style="margin-top:10px" />
								<input type="hidden" id="img_foto" name="img_foto" value="<?php echo $inscripcionDocumento->ruta_archivo?>" />
							</div>	
						</div>
						
						<div class="col-lg-12">
							<div class="form-group">
								<label class="control-label">Observaci&oacute;n / Nombre del documento</label>
								<input id="observacion" name="observacion" class="form-control form-control-sm"  value="<?php echo $inscripcionDocumento->observacion?>" type="text"  >
							</div>
						</div>

					</div>
					
					<div style="margin-top:10px" class="form-group">
						<div class="col-sm-12 controls">
							<div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions">
								<a href="javascript:void(0)" onClick="fn_save_documento()" class="btn btn-sm btn-success">Guardar</a>
								
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

