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
	$('#hora_solicitud').mask('00:00');
	//$("#id_empresa").select2({ width: '100%' });
});
</script>

<script type="text/javascript">

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

function fn_save_estudio(){
    
	var _token = $('#_token').val();
	var id = $('#id').val();
	var id_agremiado = $('#id_agremiado').val();
	var id_universidad = $('#id_universidad').val();
	var id_especialidad = $('#id_especialidad').val();
	var tesis = $('#tesis').val();
	var fecha_egresado = $('#fecha_egresado').val();
	var fecha_graduado = $('#fecha_graduado').val();
	var libro = $('#libro').val();
	var folio = $('#folio').val();
	
	//alert(id_agremiado);
	//return false;
	
    $.ajax({
			url: "/agremiado/send_agremiado_estudio",
            type: "POST",
            data : {_token:_token,id:id,id_agremiado:id_agremiado,id_universidad:id_universidad,id_especialidad:id_especialidad,tesis:tesis,fecha_egresado:fecha_egresado,fecha_graduado:fecha_graduado,libro:libro,folio:folio},
            success: function (result) {
				
				$('#openOverlayOpc').modal('hide');
				window.location.reload();
				
				/*
				$('#openOverlayOpc').modal('hide');
				if(result==1){
					bootbox.alert("La persona o empresa ya se encuentra registrado");
				}else{
					window.location.reload();
				}
				*/
            }
    });
}

function fn_save_empresa(){
    
	var _token = $('#_token').val();
	var id = $('#id').val();
	var ruc = $('#ruc').val();
	var nombre_comercial = $('#nombre_comercial').val();
	var razon_social = $('#razon_social').val();
	var direccion = $('#direccion').val();
	var representante = $('#representante').val();
	//var estado = $('#estado').val();
	
	//alert(id_agremiado);
	//return false;
	
    $.ajax({
			url: "/empresa/send_empresa_nuevoEmpresa",
            type: "POST",
            data : {_token:_token,id:id,ruc:ruc,nombre_comercial:nombre_comercial,razon_social:razon_social,direccion:direccion,representante:representante},
            success: function (result) {
				
				$('#openOverlayOpc').modal('hide');
				window.location.reload();
				
				/*
				$('#openOverlayOpc').modal('hide');
				if(result==1){
					bootbox.alert("La persona o empresa ya se encuentra registrado");
				}else{
					window.location.reload();
				}
				*/
            }
    });
}

function valida(){
	var msg = "0";

	var _token = $('#_token').val();
	var id = $('#id').val();
	var fecha_inicio = $('#fecha_inicio').val();
	var fecha_fin = $('#fecha_fin').val();

	if (fecha_inicio==""){
		msg= "Falta ingresar una Fecha Inicio";
	}else if (fecha_fin==""){
		msg= "Falta ingresar una Fecha Fin";
	}

	if (msg=="0"){
		fn_save_periodoComision()		
	}
	else {
		Swal.fire(msg);
	}

}

function fn_save_periodoComision(){
    
	var _token = $('#_token').val();
	var id = $('#id').val();
	var descripcion = $('#descripcion').val();
	var fecha_inicio = $('#fecha_inicio').val();
	var tipo = $('#id_tipo').val();
	
	var fijar_periodo;
	if ($('#fijar_periodo').is(':checked')) {
		fijar_periodo = $('#fijar_periodo').val();
	} else {
		fijar_periodo = 0;
	}
	
	var fecha_fin = $('#fecha_fin').val();
	
    $.ajax({
			url: "/periodoComision/send_periodoComision_nuevoPeriodoComision",
            type: "POST",
            data : {_token:_token,id:id,
				descripcion:descripcion,fijar_periodo:fijar_periodo,fecha_inicio:fecha_inicio,fecha_fin:fecha_fin,tipo:tipo},
            success: function (result) {
				
				$('#openOverlayOpc').modal('hide');
				window.location.reload();
				datatablenew();
				
				/*
				$('#openOverlayOpc').modal('hide');
				if(result==1){
					bootbox.alert("La persona o empresa ya se encuentra registrado");
				}else{
					window.location.reload();
				}
				*/
            }
    });
}


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
				Registro de Periodo
			</div>
			
            <div class="card-body">

			<div class="row">

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:5px;padding-bottom:20px">
					
					<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
					<input type="hidden" name="id" id="id" value="<?php echo $id?>">
					
					
					<div class="row" style="padding-left:10px">
						
						<!--<div class="col-lg-4">
							<div class="form-group">
								<label class="control-label form-control-sm">Fecha Inicio</label>
								<input id="fecha_inicio" name="fecha_inicio" class="form-control form-control-sm"  value="<?php /*echo $periodoComision->fecha_inicio*/?>" type="text">						
							</div>
						</div>-->
						
						
						<div class="col-lg-3">
							<div class="form-group">
								<label class="control-label form-control-sm">Descripci&oacute;n</label>
								<input id="descripcion" name="descripcion" class="form-control form-control-sm"  value="<?php echo $periodoComision->descripcion?>" type="text" readonly="readonly" >
							
							</div>
						</div>
						<div class="col-lg-4">
							<div class="form-group">
								<label class="control-label form-control-sm">Tipo</label>
								<select name="id_tipo" id="id_tipo" class="form-control form-control-sm" onChange="">
									<option value="">--Selecionar--</option>
									<?php
									foreach ($tipo_concurso as $row) {?>
									<option value="<?php echo $row->codigo?>" <?php if($row->codigo==$periodoComision->id_tipo_concurso)echo "selected='selected'"?>><?php echo $row->denominacion?></option>
									<?php
									}
									?>
								</select>
							</div>
						</div>
						<div class="col-lg-3" style="padding-top:40px">
							<div class="form-group">

							<input type="hidden" name="fijar_periodo" value="0"> <!-- Valor predeterminado -->
							<input type="checkbox" name="fijar_periodo" value="1" id="fijar_periodo" <?php echo $periodoComision->activo ? 'checked' : '' ?>>

							<!--<input type="checkbox" name="fijar_periodo" value="1" id="fijar_periodo" <?php echo $periodoComision->activo ? 'checked' :'' ?>>
							<input type="checkbox" class="fijar_periodo" id="fijar_periodo" name="fijar_periodo" value="" <?php //if($row->id_aprobar_pago==2)echo "checked='checked'"?> />-->
							<label class="control-label form-control-sm">Fijar Periodo</label>
							</div>
						</div>
					</div>
					<div class="row" style="padding-left:10px">
						<!--<div class="col-lg-6">
							<label class="control-label form-control-sm">Fecha Inicio</label>
							<div style="float:left" class="col-lg-10 md-form md-outline input-with-post-icon">
								<input placeholder="Fecha" type="date" id="fecha_inicio" class="form-control form-control-sm" value="<?php echo $periodoComision->fecha_inicio?>" type="text">
							</div>
						</div>-->

						<div class="col-lg-6">
							<div class="form-group">
								<label class="control-label form-control-sm">Fecha Inicio</label>
								<input id="fecha_inicio" name="fecha_inicio" class="form-control form-control-sm"  value="<?php if($periodoComision->fecha_inicio!="")echo date('d-m-Y',strtotime($periodoComision->fecha_inicio))?>" type="text"  >
							</div>
						</div>

						<div class="col-lg-6">
							<div class="form-group">
								<label class="control-label form-control-sm">Fecha Fin</label>
								<input id="fecha_fin" name="fecha_fin" class="form-control form-control-sm"  value="<?php if($periodoComision->fecha_fin!="")echo date('d-m-Y',strtotime($periodoComision->fecha_fin))?>" type="text"  >
							</div>
						</div>
						
						<!--<div class="col-lg-6">
							<label class="control-label form-control-sm">Fecha Fin</label>
							<div style="float:left" class="col-lg-10 md-form md-outline input-with-post-icon">
								<input placeholder="Fecha" type="date" id="fecha_fin" class="form-control form-control-sm" value="<?php echo $periodoComision->fecha_fin?>" type="text">
								
							</div>
						</div>-->
					</div>
						<!--
						<div class="col-lg-4">
							<div class="form-group">
								<label class="control-label form-control-sm">Fecha Fin</label>
								<input id="fecha_fin" name="fecha_fin" class="form-control form-control-sm"  value="<?php /*echo $periodoComision->fecha_fin*/?>" type="text">						
							</div>
						</div>
						</div>-->
					<div style="margin-top:15px" class="form-group ">
						<div class="col-sm-12 controls">
							<div class="btn-group btn-group-sm float-right" role="group" aria-label="Log Viewer Actions">
								<a href="javascript:void(0)" onClick="valida()" class="btn btn-sm btn-success">Guardar</a>
							</div>
												
						</div>
					</div> 

				<div class="card-body">				
                    <div class="table-responsive">
						<table id="tblPlan" class="table table-hover table-sm">
							<thead>
							<tr style="font-size:13px">
								<th>Id</th>
								<th>Periodo </th>
								<th>Estado</th>                            
							</tr>
							</thead>
							
							<tbody style="font-size:13px">
								<?php foreach($listaPeriodoComisionDetalle as $row){?>
								<tr>
									<th><?php echo $row->id?></th>
									<th><?php echo $row->denominacion?></th>
									<th><?php  if($row->estado=="1")echo("ACTIVO");?></th>
								</tr>														
								<?php }?>
							</tbody>								
						</table>
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

