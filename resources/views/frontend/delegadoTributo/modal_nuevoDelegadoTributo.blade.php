<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
	max-width:40%!important
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

/*********************************************************/
.switch {
  position: relative;
  display: inline-block;
  width: 42px;
  height: 24px;
}

/* Hide default HTML checkbox */
.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

/* The slider */
.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #337ab7;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 18px;
  width: 18px;
  left: 0px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #4cae4c;
}

input:focus + .slider {
  box-shadow: 0 0 1px #4cae4c;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}

.no {padding-right:3px;padding-left:0px;display:block;width:100px;float:left;font-size:14px;text-align:right;padding-top:5px}
.si {padding-right:0px;padding-left:3px;display:block;width:100px;float:left;font-size:14px;text-align:left;padding-top:5px}

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

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js"></script>
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
	obtenerDelegado();
	obtenerAnioPerido();
	$('#ruc').blur(function () {
		var id = $('#id').val();
			if(id==0) {
				validaRuc(this.value);
			}
		//validaRuc(this.value);
	});

});
</script>

<script type="text/javascript">

$('#openOverlayOpc').on('shown.bs.modal', function() {
	$('#fecha_solicitud').datepicker({
		format: "dd-mm-yyyy",
		autoclose: true,
		container: '#openOverlayOpc modal-body'
	});
});

$('#openOverlayOpc').on('shown.bs.modal', function() {
	$('#fecha_inicio').datepicker({
		format: "dd-mm-yyyy",
		autoclose: true,
		container: '#openOverlayOpc modal-body'
	});
});

$('#openOverlayOpc').on('shown.bs.modal', function() {
	$('#fecha_fin').datepicker({
		format: "dd-mm-yyyy",
		autoclose: true,
		container: '#openOverlayOpc modal-body'
	});
});

$(document).ready(function() {
	 
	$("#delegado").select2({ width: '100%' });
	
	

});

function obtenerDelegado(){

	var periodo = $("#id_periodo").val();
		
	var msgLoader = "";
	msgLoader = "Procesando, espere un momento por favor";
	var heightBrowser = $(window).width()/2;
	$('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
    $('.loader').show();
	
	$.ajax({
		url: '/delegadoTributo/obtener_datos_delegado/' + periodo,
		dataType: "json",
		success: function(result){
			
			var agremiado = result.agremiado;
			var option = "";
			$('#delegado').html("");
			$(agremiado).each(function (ii, oo) {
				
				option += "<option value='" + oo.id_agremiado + "'>" + oo.apellido_paterno + " " + oo.apellido_materno + " " + oo.nombres +  "</option>";
			});
			$('#delegado').html(option);

			$('.loader').hide();

		}
		
	});

}

function validar_delegado(){

	var id_delegado = $('#delegado').val();

	var msgLoader = "";
	msgLoader = "Procesando, espere un momento por favor";
	var heightBrowser = $(window).width()/2;
	$('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
    $('.loader').show();
	
	$.ajax({
		url: '/delegadoTributo/validar_delegado/' + id_delegado,
		dataType: "json",
		success: function(result){
			
			//var_dump(result);exit();
			if(result>0){
				bootbox.alert({
					
					message: "Ya existe un registro de este delegado en la Base de Datos.",
					
				});
			}else{
				obtener_datos_delegado_();
			}
			$('.loader').hide();
		}
		
	});

}

function obtenerAnioPerido(){
	
	var id_periodo = $('#id_periodo').val();
	
	$.ajax({
		url: '/planilla/obtener_anio_periodo/'+id_periodo,
		dataType: "json",
		success: function(result){
			var option = "";
			$('#anio').html("");
			//option += "<option value='0'>--Seleccionar--</option>";
			$(result).each(function (ii, oo) {
				option += "<option value='"+oo.anio+"'>"+oo.anio+"</option>";
			});
			$('#anio').html(option);
		}
		
	});
	
}

function obtener_datos_delegado_(){

	var id_agremiado = $('#delegado').val();

	var msgLoader = "";
	msgLoader = "Procesando, espere un momento por favor";
	var heightBrowser = $(window).width()/2;
	$('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
    $('.loader').show();
	
	$.ajax({
		url: '/agremiado/obtener_datos_agremiado_id/' + id_agremiado,
		dataType: "json",
		success: function(result){
			
			var agremiado = result.agremiado[0];
			
			$('#numero_cap').val(agremiado.numero_cap);
			$('#apellido_paterno').val(agremiado.apellido_paterno);
			$('#apellido_materno').val(agremiado.apellido_materno);
			$('#nombres').val(agremiado.nombres);

			$('.loader').hide();

		}
		
	});
	
}

function fn_save_(){
	
    $.ajax({
			url: "/delegadoTributo/send_delegadoTributo",
            type: "POST",
            data : $("#frmTributo").serialize(),
			success: function (result) {
    
				$('#openOverlayOpc').modal('hide');
				window.location.reload();
		
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

	<div class="panel-heading close-heading">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    </div>

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
		
			<div class="card-header" style="padding:5px!important;padding-left:20px!important; font-weight: bold">
				Datos del Delegado
			</div>
			
            <div class="card-body">

			<form method="post" action="#" id="frmTributo" name="frmTributo" enctype="multipart/form-data">

			<div class="row">

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:5px;padding-bottom:20px">
			
					<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
					<input type="hidden" name="id" id="id" value="<?php echo $id?>">
					
					<div class="row"  style="padding-left:10px">

						<div class="col-lg-4">
							<div class="form-group">
								<label class="control-label form-control-sm">Periodo</label>
								<select name="id_periodo" id="id_periodo" class="form-control form-control-sm" onChange="obtenerDelegado();obtenerAnioPerido()">
									<!--<option value="">--Seleccionar--</option>-->
									<?php
									foreach ($periodo as $row) {?>
									<option value="<?php echo $row->id?>" <?php if($row->id==$delegadoTributo->id_periodo_comision)echo "selected='selected'"?>><?php echo $row->descripcion?></option>
									<?php 
									}
									?>
								</select>
							</div>
						</div>

						<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
							<label class="control-label required-field form-control-sm">Año</label>
							<?php if($id>0){?>
								<input id="anio_" name="anio_" class="form-control form-control-sm"  value="<?php echo $delegadoTributo->anio?>" type="text" readonly="readonly">										
								<?php }else{?>
								<select name="anio" id="anio" class="form-control form-control-sm">
									<option value="">--Selecionar--</option>
								</select>
							<?php }?>
						</div>

						<div class="col-lg-9">
							<div class="form-group">
								<label class="control-label form-control-sm">Delegado</label>
								<?php if($id>0){?>
								<input id="delegado_" name="delegado_" class="form-control form-control-sm"  value="<?php echo $persona_->apellido_paterno ." ". $persona_->apellido_materno ." ". $persona_->nombres ?>" type="text" readonly="readonly">
								<input type="hidden" name="id_delegado_" id="id_delegado_" value="<?php echo $delegadoTributo->id_agremiado?>">								
								<?php }else{?>
								<select name="delegado" id="delegado" class="form-control form-control-sm" onchange="validar_delegado()">
									<option value="">--Selecionar--</option>
									
								</select>
								<?php }?>
							</div>
						</div>
						
						<div class="col-lg-3">
							<div class="form-group">
								<label class="control-label form-control-sm">N° CAP</label>
								<input id="numero_cap" name="numero_cap" class="form-control form-control-sm"  value="<?php if($id>0) echo $agremiado_->numero_cap?>" type="text" readonly="readonly">													
							</div>
						</div>
						
						<div class="col-lg-4">
							<div class="form-group">
								<label class="control-label form-control-sm">Apellido Paterno</label>
								<input id="apellido_paterno" name="apellido_paterno" class="form-control form-control-sm"  value="<?php if($id>0) echo $persona_->apellido_paterno?>" type="text" readonly="readonly">																				
							</div>
						</div>

						<div class="col-lg-4">
							<div class="form-group">
								<label class="control-label form-control-sm">Apellido Materno</label>
								<input id="apellido_materno" name="apellido_materno" class="form-control form-control-sm "  value="<?php if($id>0) echo $persona_->apellido_materno?>" type="text" readonly="readonly">																				
								
							</div>
						</div>

						<div class="col-lg-4">
							<div class="form-group">
								<label class="control-label form-control-sm">Nombres</label>
								<input id="nombres" name="nombres" class="form-control form-control-sm"  value="<?php if($id>0) echo $persona_->nombres?>" type="text" readonly="readonly">																				
							</div>
						</div>

					</div>
					<div class="row"  style="padding-left:10px">
						<div class="col-lg-4">
							<div class="form-group">
								<label class="control-label form-control-sm">Emite</label>
								<select name="emite" id="emite" class="form-control form-control-sm" onChange="">
									<option value="">--Selecionar--</option>
									<?php
									foreach ($emite as $row) {?>
									<?php if($row->codigo==9 || $row->codigo==13){?>
									<option value="<?php echo $row->codigo?>" <?php if($row->codigo==13)echo "selected='selected'"?>><?php echo $row->denominacion?></option>
									<?php
									}
									}
									?>
								</select>
							</div>
						</div>
						<div class="col-lg-8">
							<div class="form-group">
								<label class="control-label form-control-sm">Entidad Financiera</label>
								<select name="entidad_financiera" id="entidad_financiera" class="form-control form-control-sm" onChange="">
									<option value="">--Selecionar--</option>
									<?php
									foreach ($bancos as $row) {?>
									<option value="<?php echo $row->codigo?>" <?php if($row->codigo==$delegadoTributo->id_banco)echo "selected='selected'"?>><?php echo $row->denominacion?></option>
									<?php
									}
									?>
								</select>
							</div>
						</div>

						<div class="col-lg-4">
							<div class="form-group">
								<label class="control-label form-control-sm">N&uacute;mero de Cuenta</label>
								<input id="numero_cuenta" name="numero_cuenta" class="form-control form-control-sm"  value="<?php echo $delegadoTributo->numero_cuenta?>" type="text">																				
							</div>
						</div>

						<div class="col-lg-5">
							<div class="form-group">
								<label class="control-label form-control-sm">CCI</label>
								<input id="cci" name="cci" class="form-control form-control-sm"  value="<?php echo $delegadoTributo->cci?>" type="text">																				
							</div>
						</div>

						<div class="col-lg-3">
							<div class="form-group">
								<label class="control-label form-control-sm">Aplica Tributo Mayor a</label>
								<input id="monto_minimo" name="monto_minimo" class="form-control form-control-sm"  value="<?php echo $parametro[0]->monto_minimo_rh?>" type="text" readonly='readonly'>																				
							</div>
						</div>

						<div class="col-lg-4">
							<div class="form-group">
								<label class="control-label form-control-sm">Tipo</label>
								<select name="tipo_tributo" id="tipo_tributo" class="form-control form-control-sm" onChange="">
									<option value="">--Selecionar--</option>
									<?php
									foreach ($tipo_tributo as $row) {?>
									<?php if($row->codigo!=459){?>
									<option value="<?php echo $row->codigo?>" <?php if($row->codigo==$delegadoTributo->id_tipo_tributo)echo "selected='selected'"?>><?php echo $row->denominacion?></option>
									<?php
									}
									}
									?>
								</select>
							</div>
						</div>

						<div class="col-lg-2">
							<div class="form-group">
								<label class="control-label form-control-sm">Fecha de Solicitud</label>
								<input id="fecha_solicitud" name="fecha_solicitud" class="form-control form-control-sm"  value="<?php if($delegadoTributo->fecha_solicitud!="")echo date("d-m-Y", strtotime($delegadoTributo->fecha_solicitud))?>" type="text">																				
							</div>
						</div>

						<div class="col-lg-2">
							<div class="form-group">
								<label class="control-label form-control-sm">Fecha Inicio</label>
								<input id="fecha_inicio" name="fecha_inicio" class="form-control form-control-sm"  value="<?php if($delegadoTributo->fecha_inicio!="")echo date("d-m-Y", strtotime($delegadoTributo->fecha_inicio))?>" type="text">																				
							</div>
						</div>

						<div class="col-lg-2">
							<div class="form-group">
								<label class="control-label form-control-sm">Fecha de Fin</label>
								<input id="fecha_fin" name="fecha_fin" class="form-control form-control-sm"  value="<?php if($delegadoTributo->fecha_fin!="")echo date("d-m-Y", strtotime($delegadoTributo->fecha_fin))?>" type="text">																				
							</div>
						</div>
						
					</div>

					<div style="margin-top:15px" class="form-group">
						<div class="col-sm-12 controls">
							<div class="btn-group btn-group-sm float-right" role="group" aria-label="Log Viewer Actions">
							
								<a href="javascript:void(0)" onClick="fn_save_()" class="btn btn-sm btn-success" style="margin-right: 15px;">Guardar</a>
								<a href="javascript:void(0)" onClick="$('#openOverlayOpc').modal('hide');window.location.reload();" class="btn btn-md btn-warning">Cerrar</a>
								
							</div>
												
						</div>
					</div> 
					
              </div>
			  
              
          </div>
          <!-- /.box -->
          

        </div>
        <!--/.col (left) -->
            
     
          </div>
		</form>
          <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    
<script type="text/javascript">
$(document).ready(function () {
	
	
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
$(document).ready(function() {
	
	$('#persona_').keyup(function() {
		this.value = this.value.toLocaleUpperCase();
	});
		
	$('#persona_').focusin(function() { $('#persona_').select(); });
	/*
	$('#usuario_').autocomplete({
		appendTo: "#usuario_busqueda",
		source: function(request, response) {
			$.ajax({
			url: '/empresa/list_usuario/'+$('#usuario_').val(),
			dataType: "json",
			success: function(data){
			   var resp = $.map(data,function(obj){
					var hash = {key: obj.id, value: obj.usuario};
					return hash;
			   }); 
			   response(resp);
			},
			error: function() {
			}
		});
		},
		select: function (event, ui) {
			$("#user_id").val(ui.item.key);
		},
			minLength: 2,
			delay: 100
	  });
	*/
	
	$('#empresa_').keyup(function() {
		this.value = this.value.toLocaleUpperCase();
	});
		
	$('#empresa_').focusin(function() { $('#empresa_').select(); });
	
	$('#empresa_').autocomplete({
		appendTo: "#empresa_busqueda",
		source: function(request, response) {
			$.ajax({
			url: '/empresa/list_empresa/'+$('#empresa_').val(),
			dataType: "json",
			success: function(data){
			   var resp = $.map(data,function(obj){
					var hash = {key: obj.id, value: obj.razon_social, ruc: obj.ruc};
					return hash;
			   }); 
			   response(resp);
			},
			error: function() {
			}
		});
		},
		select: function (event, ui) {
			$("#id_empresa").val(ui.item.key);
		},
			minLength: 1,
			delay: 100
	  });
	  
	  $('#persona_').autocomplete({
		appendTo: "#persona_busqueda",
		source: function(request, response) {
			$.ajax({
			url: '/persona/list_persona/'+$('#persona_').val(),
			dataType: "json",
			success: function(data){
			   var resp = $.map(data,function(obj){
					var hash = {key: obj.id, value: obj.persona};
					return hash;
			   }); 
			   response(resp);
			},
			error: function() {
			}
		});
		},
		select: function (event, ui) {
			$("#id_persona").val(ui.item.key);
		},
			minLength: 1,
			delay: 100
	  });
	  
	
});

</script>

