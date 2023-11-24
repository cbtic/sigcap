<title>Sistema de Felmo</title>

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
	max-width:50%!important
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


.btn-file {
  position: relative;
  overflow: hidden;
}
.btn-file input[type=file] {
  position: absolute;
  top: 0;
  right: 0;
  min-width: 100%;
  min-height: 100%;
  font-size: 100px;
  text-align: right;
  filter: alpha(opacity=0);
  opacity: 0;
  outline: none;
  background: white;
  cursor: inherit;
  display: block;
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

<!--
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js"></script>
-->

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


	//upload_imagen()
	//alert("okk");

/*
function upload_imagen(){
 	//e.preventDefault();
	var _token = $('#_token').val();
	//alert(_token);
	new AjaxUpload($('#link_ruta_desembolso'), {
		action: "/prestamo/upload",
		data:  {_token : _token},
		name: 'file',
		autoSubmit: true,
		onSubmit: function(file, extension) {
		  //$('div.preview').addClass('loading');
		},
		onComplete: function(file, response) {//alert(response);
			$('#img_ruta_desembolso').attr('src',url+"/img/frontend/tmp/"+file);
			$('#ruta_desembolso').val("")
			$('#ruta_desembolso').val(file);
		}
	});
}
*/
</script>

<script type="text/javascript">
/*
$('#openOverlayOpc').on('shown.bs.modal', function() {
     $('#fecha_solicitud').datepicker({
		format: "dd-mm-yyyy",
		autoclose: true,
		container: '#openOverlayOpc modal-body'
     });

});
*/
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

function guardarCita__(){
	alert("fdssf");
}

function guardarCita(id_medico,fecha_cita){

    var msg = "";
    var id_ipress = $('#id_ipress').val();
    var id_consultorio = $('#id_consultorio').val();
    var fecha_atencion = $('#fecha_atencion').val();
    var dni_beneficiario = $("#dni_beneficiario").val();
	//alert(id_ipress);
	if(dni_beneficiario == "")msg += "Debe ingresar el numero de documento <br>";
    if(id_ipress==""){msg+="Debe ingresar una Ipress<br>";}
    if(id_consultorio==""){msg+="Debe ingresar un Consultorio<br>";}
    if(fecha_atencion==""){msg+="Debe ingresar una fecha de atencion<br>";}

    if(msg!=""){
        bootbox.alert(msg);
        return false;
    }
    else{
        fn_save_cita(id_medico,fecha_cita);
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
            url: "/persona/upload",
            type: 'post',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response != 0) {
                    $("#img_ruta").attr("src", "/img/frontend/tmp/"+response);
					$("#img_foto").val(response);
                } else {
                    alert('Formato de imagen incorrecto.');
                }
            }
        });
        return false;
    });

	$(".delete").on('click', function() {
		$("#img_ruta").attr("src", "/dist/img/profile-icon.png");
		$("#img_foto").val("");
	});

});

function fn_save(){

	var _token = $('#_token').val();
	var id  = $('#id').val();
	var tipo_documento = $('#tipo_documento_').val();
	var numero_documento = $('#numero_documento_').val();
	var apellido_paterno = $('#apellido_paterno_').val();
	var apellido_materno = $('#apellido_materno_').val();
	var nombres = $('#nombres_').val();
	var codigo = $('#codigo_').val();
	var ocupacion = $('#ocupacion_').val();
	var telefono = $('#telefono_').val();
	var ruc = $('#ruc_').val();
	var email = $('#email_').val();
	var observacion = $('#observacion_').val();
	var img_foto = $('#img_foto').val();
	var flag_negativo = 0;

	if($("#flag_negativo_").is(':checked'))flag_negativo = 1;

	$.ajax({
			url: "/persona/send_persona",
            type: "POST",
            data : {_token:_token,id:id,tipo_documento:tipo_documento,numero_documento:numero_documento,apellido_paterno:apellido_paterno,
					apellido_materno:apellido_materno,nombres:nombres,codigo:codigo,ocupacion:ocupacion,telefono:telefono,email:email,ruc:ruc,
					flag_negativo:flag_negativo,observacion:observacion,img_foto:img_foto},
			dataType: 'json',
            success: function (result) {
				if(result.sw==false){
					bootbox.alert(result.msg);
				}

				$('#openOverlayOpc').modal('hide');
				datatablenew();
            }
    });
}

function fn_liberar(id){

	//var id_estacionamiento = $('#id_estacionamiento').val();
	var _token = $('#_token').val();

    $.ajax({
			url: "/estacionamiento/liberar_asignacion_estacionamiento_vehiculo",
            type: "POST",
            data : {_token:_token,id:id},
            success: function (result) {
				$('#openOverlayOpc').modal('hide');
				cargarAsignarEstacionamiento();
            }
    });
}


function validarLiquidacion() {

	var msg = "";
	var sw = true;

	var saldo_liquidado = $('#saldo_liquidado').val();
	var estado = $('#estado').val();

	if(saldo_liquidado == "")msg += "Debe ingresar un saldo liquidado <br>";
	if(estado == "")msg += "Debe ingresar una observacion <br>";

	if(msg!=""){
		bootbox.alert(msg);
		//return false;
	} else {
		//submitFrm();
		document.frmLiquidacion.submit();
	}
	return false;
}


function obtenerVehiculo(id,obj){

	//$("#tblPlan tbody text-white").attr('class','bg-primary text-white');
	if(obj!=undefined){
		$("#tblSinReservaEstacionamiento tbody tr").each(function (ii, oo) {
			var clase = $(this).attr("clase");
			$(this).attr('class',clase);
		});

		$(obj).attr('class','bg-success text-white');
	}
	//$('#tblPlanDetalle tbody').html("");
	$('#id_empresa').val(id);
	var id_estacionamiento = $('#id_estacionamiento').val();
	$.ajax({
		url: '/estacionamiento/obtener_vehiculo/'+id+'/'+id_estacionamiento,
		dataType: "json",
		success: function(result){

			var newRow = "";
			$('#tblPlanDetalle').dataTable().fnDestroy(); //la destruimos
			$('#tblPlanDetalle tbody').html("");
			$(result).each(function (ii, oo) {
				newRow += "<tr class='normal'><td>"+oo.placa+"</td>";
				newRow += '<td class="text-left" style="padding:0px!important;margin:0px!important">';
				newRow += '<div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions">';
				newRow += '<a href="javascript:void(0)" onClick=fn_save("'+oo.id_vehiculo+'") class="btn btn-sm btn-normal">';
				newRow += '<i class="fa fa-2x fa-check" style="color:green"></i></a></a></div></td></tr>';
			});
			$('#tblPlanDetalle tbody').html(newRow);

			$('#tblPlanDetalle').DataTable({
				//"sPaginationType": "full_numbers",
				"paging":false,
				"dom": '<"top">rt<"bottom"flpi><"clear">',
				"language": {"url": "/js/Spanish.json"},
			});

			$("#system-search2").keyup(function() {
				var dataTable = $('#tblPlanDetalle').dataTable();
			   dataTable.fnFilter(this.value);
			});

		}

	});

}

/*
$('#fecha_solicitud').datepicker({
	autoclose: true,
	dateFormat: 'dd-mm-yy',
	changeMonth: true,
	changeYear: true,
	container: '#openOverlayOpc modal-body'
});
*/
/*
$('#fecha_solicitud').datepicker({
	format: "dd/mm/yyyy",
	startDate: "01-01-2015",
	endDate: "01-01-2020",
	todayBtn: "linked",
	autoclose: true,
	todayHighlight: true,
	container: '#openOverlayOpc modal-body'
});
*/

/*
format: "dd/mm/yyyy",
startDate: "01-01-2015",
endDate: "01-01-2020",
todayBtn: "linked",
autoclose: true,
todayHighlight: true,
container: '#myModal modal-body'
*/
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
				Edici&oacute;n Persona
			</div>

            <div class="card-body">

			<div class="row">

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:10px">

					<form method="post" action="#" enctype="multipart/form-data">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<input type="hidden" name="id" id="id" value="<?php echo $id?>">

					<!--
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="form-group">
							<div id="custom-search-input">
								<div class="input-group">
									<input id="vehiculo_empresa" class="form-control form-control-sm ui-autocomplete-input" placeholder="Buscar Empresa" name="vehiculo_empresa" type="text" autocomplete="off">
								</div>
								<div class="input-group" id="vehiculo_empresa_busqueda"><ul class="ui-autocomplete ui-front ui-menu ui-widget ui-widget-content" id="ui-id-278" tabindex="0" style="display: none;"></ul></div>
							</div>
						</div>
					</div>
					-->
					<div class="row">
						<?php
							$readonly=$id>0?"readonly='readonly'":'';
							$disabled=$id>0?"disabled='disabled'":'';
						?>

                        <div class="col-lg-7">
                            <div class="col-lg-12">
                                <div class="form-group" style="padding-top:0px;padding-bottom:0px;margin-top:0px;margin-bottom:0px">
                                    <label class="control-label">Tipo Documento</label>
                                    <select name="tipo_documento_" id="tipo_documento_" class="form-control form-control-sm" onChange="validaTipoDocumento()" value="<?php echo $persona->numero_documento?>" type="text" <?php echo $disabled?> >
                                        <option value="<?php echo $persona::TIPO_DOCUMENTO_DNI?>" <?php if($persona::TIPO_DOCUMENTO_DNI==$persona->tipo_documento)echo "selected='selected'" ?> ><?php echo $persona::TIPO_DOCUMENTO_DNI?></option>
                                        <option value="<?php echo $persona::TIPO_DOCUMENTO_CARNET_EXTRANJERIA?>" <?php if($persona::TIPO_DOCUMENTO_CARNET_EXTRANJERIA==$persona->tipo_documento)echo "selected='selected'" ?>><?php echo $persona::TIPO_DOCUMENTO_CARNET_EXTRANJERIA?></option>
                                        <option value="<?php echo $persona::TIPO_DOCUMENTO_PASAPORTE?>" <?php if($persona::TIPO_DOCUMENTO_PASAPORTE==$persona->tipo_documento)echo "selected='selected'" ?> ><?php echo $persona::TIPO_DOCUMENTO_PASAPORTE?></option>
                                    <!--   <option value="<?php echo $persona::TIPO_DOCUMENTO_RUC?>" <?php if($persona::TIPO_DOCUMENTO_RUC==$persona->tipo_documento)echo "selected='selected'" ?> ><?php echo $persona::TIPO_DOCUMENTO_RUC?></option>   -->
                                        <option value="<?php echo $persona::TIPO_DOCUMENTO_CEDULA?>" <?php if($persona::TIPO_DOCUMENTO_CEDULA==$persona->tipo_documento)echo "selected='selected'" ?> ><?php echo $persona::TIPO_DOCUMENTO_CEDULA?></option>
                                        <option value="<?php echo $persona::TIPO_DOCUMENTO_PTP?>" <?php if($persona::TIPO_DOCUMENTO_PTP==$persona->tipo_documento)echo "selected='selected'" ?> ><?php echo $persona::TIPO_DOCUMENTO_PTP?></option>
                                        <option value="<?php echo $persona::TIPO_DOCUMENTO_CPP?>" <?php if($persona::TIPO_DOCUMENTO_CPP==$persona->tipo_documento)echo "selected='selected'" ?> ><?php echo $persona::TIPO_DOCUMENTO_CPP?></option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group" style="padding-top:0px;padding-bottom:0px;margin-top:0px;margin-bottom:0px">
                                    <label class="control-label">N. Documento</label>
                                    <!--<input id="numero_documento_" name="numero_documento_" class="form-control form-control-sm"  value="<?php echo $persona->numero_documento?>" type="text">-->
                                    <input id="numero_documento_" name="numero_documento_" class="form-control form-control-sm"  value="<?php echo $persona->numero_documento?>" type="text" <?php echo $readonly?> >
                                </div>
                            </div>


                            <div class="col-lg-12">
                                <div class="form-group" style="padding-top:0px;padding-bottom:0px;margin-top:0px;margin-bottom:0px">
                                    <label class="control-label">RUC</label>
                                    <input id="ruc_" name="ruc_" class="form-control form-control-sm"  value="<?php echo $persona->ruc?>" type="text">
                                </div>
                            </div>
                        </div>

						<div class="col-lg-5">
							<div class="form-group" style="text-align:center">
								<!--<input id="image" name="image" type="file" />-->
								<span class="btn btn-sm btn-warning btn-file">
									Examinar <input id="image" name="image" type="file" />
								</span>

								<input type="button" class="btn btn-sm btn-primary upload" value="Subir" style="margin-left:10px">

								<input type="button" class="btn btn-sm btn-danger delete" value="Eliminar" style="margin-left:10px">

								<?php
								$url_foto = "/dist/img/profile-icon.png";
								if($persona->foto!="" && $persona->foto!="ruta" && $persona->foto!="mail@mail.com")$url_foto = "/img/dni_asociados/".$persona->foto;

								$foto = "";
								if($persona->foto!="" && $persona->foto!="ruta" && $persona->foto!="mail@mail.com")$foto = $persona->foto;
								?>
								<img src="<?php echo $url_foto?>" id="img_ruta" width="130px" height="165px" alt="" style="text-align:center;margin-top:8px" />
								<input type="hidden" id="img_foto" name="img_foto" value="<?php echo $foto?>" />
							</div>
						</div>
						<!--
						<div class="col-lg-4">
                            <img src="/img/dni_asociados/<?php //echo $persona->foto?>" alt="">
						</div>
						-->
					</div>

					<div style="padding-left:15px">
					<div class="row">

						<div class="col-lg-12">
							<div class="form-group" style="padding-top:0px;padding-bottom:0px;margin-top:0px;margin-bottom:0px">
								<label class="control-label">Apellido Paterno</label>
								<input id="apellido_paterno_" name="apellido_paterno_" class="form-control form-control-sm"  value="<?php echo $persona->apellido_paterno?>" type="text" readonly>
							</div>
						</div>

					</div>

					<div class="row">

						<div class="col-lg-12">
							<div class="form-group" style="padding-top:0px;padding-bottom:0px;margin-top:0px;margin-bottom:0px">
								<label class="control-label">Apellido Materno</label>
								<input id="apellido_materno_" name="apellido_materno_" class="form-control form-control-sm"  value="<?php echo $persona->apellido_materno?>" type="text" readonly>
							</div>
						</div>

					</div>

					<div class="row">

						<div class="col-lg-12">
							<div class="form-group" style="padding-top:0px;padding-bottom:0px;margin-top:0px;margin-bottom:0px">
								<label class="control-label">Nombre</label>
								<input id="nombres_" name="nombres_" class="form-control form-control-sm"  value="<?php echo $persona->nombres?>" type="text" readonly>
							</div>
						</div>

					</div>

					<div class="row">

						<div class="col-lg-6">
							<div class="form-group" style="padding-top:0px;padding-bottom:0px;margin-top:0px;margin-bottom:0px">
								<label class="control-label">C&oacute;digo</label>
								<input id="codigo_" name="codigo_" class="form-control form-control-sm"  value="<?php echo $persona->codigo?>" type="text">
							</div>
						</div>

						<div class="col-lg-6">
							<div class="form-group" style="padding-top:0px;padding-bottom:0px;margin-top:0px;margin-bottom:0px">
								<label class="control-label">Ocupaci&oacute;n</label>
								<input id="ocupacion_" name="ocupacion_" class="form-control form-control-sm"  value="<?php echo $persona->ocupacion?>" type="text">
							</div>
						</div>

					</div>

					<div class="row">

						<div class="col-lg-6">
							<div class="form-group" style="padding-top:0px;padding-bottom:0px;margin-top:0px;margin-bottom:0px">
								<label class="control-label">Tel&eacute;fono</label>
								<input id="telefono_" name="telefono_" class="form-control form-control-sm"  value="<?php echo $persona->telefono?>" type="text">
							</div>
						</div>

						<div class="col-lg-6">
							<div class="form-group" style="padding-top:0px;padding-bottom:0px;margin-top:0px;margin-bottom:0px">
								<label class="control-label">Correo</label>
								<input id="email_" name="email_" class="form-control form-control-sm"  value="<?php echo $persona->email?>" type="text">
							</div>
						</div>

					</div>

					<div class="row">

						<div class="col-lg-3">
							<div class="form-group" style="padding-top:10px;padding-bottom:0px;margin-top:0px;margin-bottom:0px">
								<label class="control-label" style="float:left">Flag Negativo</label>
								<input type="checkbox" name="flag_negativo_" id="flag_negativo_" <?php if($persona->flag_negativo=="1")echo "checked='checked'"?> style="text-align:left;width:15px;float:left;margin-left:15px;margin-top:5px" />
							</div>
						</div>
						<div class="col-lg-9">
							<div class="form-group" style="padding-top:10px;padding-bottom:0px;margin-top:0px;margin-bottom:0px">
								<input id="observacion_" name="observacion_" class="form-control form-control-sm"  value="<?php if(isset($negativo->observacion))echo $negativo->observacion?>" type="text" style="float:left">
							</div>
						</div>

					</div>

					<div style="margin-top:10px" class="form-group">
						<div class="col-sm-12 controls">
							<div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions" style="float:right">
								<a href="javascript:void(0)" onClick="fn_save()" class="btn btn-sm btn-success">Guardar</a>
							</div>

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

	$('#numero_documento_').blur(function () {
		var id = $('#id').val();
			if(id==0) {
				validaDni(this.value);
			}
	});

	$('#tblReservaEstacionamiento').DataTable({
		"dom": '<"top">rt<"bottom"flpi><"clear">'
		});
	$("#system-search").keyup(function() {
		var dataTable = $('#tblReservaEstacionamiento').dataTable();
		dataTable.fnFilter(this.value);
	});

	$('#tblReservaEstacionamientoPreferente').DataTable({
		"dom": '<"top">rt<"bottom"flpi><"clear">'
		});
	$("#system-searchp").keyup(function() {
		var dataTable = $('#tblReservaEstacionamientoPreferente').dataTable();
		dataTable.fnFilter(this.value);
	});

	$('#tblSinReservaEstacionamiento').DataTable({
		"dom": '<"top">rt<"bottom"flpi><"clear">'
		});
	$("#system-search2").keyup(function() {
		var dataTable = $('#tblSinReservaEstacionamiento').dataTable();
		dataTable.fnFilter(this.value);
	});


});

</script>

<script type="text/javascript">
/*
$(document).ready(function() {
	$('#numero_placa').focus();
	$('#numero_placa').mask('AAA-000');
	$('#vehiculo_numero_placa').mask('AAA-000');

	$('#vehiculo_numero_placa').keyup(function() {
		this.value = this.value.toLocaleUpperCase();
	});

	$('#vehiculo_empresa').keyup(function() {
		this.value = this.value.toLocaleUpperCase();
	});

	$('#vehiculo_empresa').focusin(function() { $('#vehiculo_empresa').select(); });

	$('#vehiculo_empresa').autocomplete({
		appendTo: "#vehiculo_empresa_busqueda",
		source: function(request, response) {
			$.ajax({
			url: '/pesaje/list/'+$('#vehiculo_empresa').val(),
			dataType: "json",
			success: function(data){
			   var resp = $.map(data,function(obj){
					var hash = {key: obj.id, value: obj.razon_social, ruc: obj.ruc};
					//if(obj.razon_social=='') { actualiza_ruc("") }
					return hash;
			   });
			   response(resp);
			},
			error: function() {
				//actualiza_ruc("");
			}
		});
		},
		select: function (event, ui) {
			$('#vehiculo_empresa').blur();
			$('#ruc').val(ui.item.ruc);
			//if (ui.item.value != ''){
			//actualiza_ruc(ui.item.value);
			//}
			obtener_vehiculos(ui.item.key);
			$("#id_empresa").val(ui.item.key); // save selected id to hidden input
		},
			minLength: 2,
			delay: 100
	  });


	$('#modalVehiculoSaveBtn').click(function (e) {
		e.preventDefault();
		$(this).html('Enviando datos..');

		$.ajax({
		  data: $('#modalVehiculoForm').serialize(),
		  url: "/vehiculo/send_ajax_asignar",
		  type: "POST",
		  dataType: 'json',
		  success: function (data) {

			  $('#modalVehiculoForm').trigger("reset");
			  //$('#vehiculoModal').modal('hide');
			  $('#openOverlayOpc').modal('hide');

        alert(data.msg);
        $("#nombre_empresa").val(data.vehiculo_empresa);
        $("#numero_placa").val(data.vehiculo_numero_placa);
        $("#numero_ejes").val(data.ejes);
        $("#numero_documento").val(data.ruc);
        $("#nombres_razon_social").val(data.razon_social);
        $("#empresa_direccion").val(data.direccion);

        $("#modalVehiculoSaveBtn").html("Grabar");

		  },
		  error: function(data) {
        mensaje = "Revisar el formulario:\n\n";
        $.each( data["responseJSON"].errors, function( key, value ) {
          mensaje += value +"\n";
        });
        $("#modalVehiculoSaveBtn").html("Grabar");
        alert(mensaje);
      }
	  });
	});

});
*/

function actualiza_ruc(razon_social) {
	$.ajax({
		url: '/pesaje/obtener_ruc/'+razon_social,
		dataType: 'json',
		type: 'GET',
		success: function(result){
			//alert(result);
			$('#ruc').val(result);
		},
		error: function(){
			$('#ruc').val('');
		}

	});
}


function obtener_vehiculos(id){

	option = {
		url: '/pesaje/obtener_vehiculo_empresa/' + id,
		type: 'GET',
		dataType: 'json',
		data: {}
	};
	$.ajax(option).done(function (data) {

		var option = "<option value='0'>Seleccionar</option>";
		$("#id_vehiculo").html("");
		$(data).each(function (ii, oo) {
			option += "<option value='"+oo.id+"'>"+oo.placa+"</option>";
		});
		$("#id_vehiculo").html(option);
		$("#id_vehiculo").val(id).select2();

		/*
		var cantidad = data.cantidad;
		var cantidadEstablecimiento = data.cantidadEstablecimiento;
		var cantidadAlmacen = data.cantidadAlmacen;
		$(cmb).closest("tr").find(".limpia_text").val("");
		$(cmb).closest("tr").find("#nro_stocks").val(cantidad);
		$(cmb).closest("tr").find("#nro_stocks_establecimiento").val(cantidadEstablecimiento);
		$(cmb).closest("tr").find("#nro_stocks_almacen").val(cantidadAlmacen);
		$(cmb).closest("tr").find("#nro_med_solictados").val("");
		$(cmb).closest("tr").find("#nro_med_entregados").val("");
		$(cmb).closest("tr").find("#lotes_lote").val("");
		$(cmb).closest("tr").find("#lotes_cantidad").val("");
		$(cmb).closest("tr").find("#lotes_registro_sanitario").val("");
		$(cmb).closest("tr").find("#lotes_fecha_vencimiento").val("");
		*/
	});

}

function validaDni(dni){
	var settings = {
		"url": "https://apiperu.dev/api/dni/"+dni,
		"method": "GET",
		"timeout": 0,
		"headers": {
		  "Authorization": "Bearer 20b6666ddda099db4204cf53854f8ca04d950a4eead89029e77999b0726181cb"
		},
	  };

	  $.ajax(settings).done(function (response) {
		console.log(response);

		if (response.success == true){

			var data= response.data;

			$('#apellido_paterno_').val('')
			$('#apellido_materno_').val('')
			$('#nombres_').val('')
			$('#codigo_').val('')
			$('#ocupacion_').val('')
			$('#telefono_').val('')
			$('#email_').val('')

			$('#apellido_paterno_').val(data.apellido_paterno);
			$('#apellido_materno_').val(data.apellido_materno);
			$('#nombres_').val(data.nombres);

			//alert(data.nombre_o_razon_social);

		}
		else{
			bootbox.alert("DNI Invalido,... revise el DNI digitado ¡");
			return false;
		}

	  });
}

function validaTipoDocumento(){
	var tipo_documento = $("#tipo_documento_").val();

	$('#numero_documento_').val("");
	$('#apellido_paterno_').val("");
	$('#apellido_materno_').val("");
	$('#nombres_').val("");
	$('#codigo_').val("");
	$('#ocupacion_').val("");
	$('#telefono_').val("");
	$('#email_').val("");


	if(tipo_documento == "DNI"){
		$('#apellido_paterno_').attr('readonly', true);
		$('#apellido_materno_').attr('readonly', true);
		$('#nombres_').attr('readonly', true);
	}else{
		$('#apellido_paterno_').attr('readonly', false);
		$('#apellido_materno_').attr('readonly', false);
		$('#nombres_').attr('readonly', false);
	}

}


</script>

