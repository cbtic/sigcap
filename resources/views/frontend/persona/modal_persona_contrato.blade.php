<title>Sistema de CAP - Lima</title>

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
	max-width:45%!important
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
		
});
</script>

<script type="text/javascript">

$('#openOverlayOpc').on('shown.bs.modal', function() {
     $('#fecha').datepicker({
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
            url: "/persona/upload_vacuna",
            type: 'post',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response != 0) {
                    $("#img_ruta").attr("src", "/img/frontend/tmp_vacuna/"+response);
					$("#img_foto").val(response);
                } else {
                    alert('Formato de imagen incorrecto.');
                }
            }
        });
        return false;
    });
});

function fn_save(){
    
	var _token = $('#_token').val();
	var id_persona = $('#id_persona').val();

	var fech_crea = $('#fech_crea').val();
	var tipo_cont_con = $('#tipo_cont_con').val();
	var nume_cont_con = $('#nume_cont_con').val();
	var fech_reso_cnt = $('#fech_reso_cnt').val();
	var fech_inic_cnt = $('#fech_inic_cnt').val();
	var fech_fina_cnt = $('#fech_fina_cnt').val();
	var id_cargo = $('#id_cargo').val();
	var mont_cont_ctr = $('#mont_cont_ctr').val();
	var deno_part_cnt = $('#deno_part_cnt').val();
	var func_cont_cnt = $('#func_cont_cnt').val();

	
	var msg = "";
    if(id_persona == "")msg += "Debe ingresar el numero de documento <br>";
    if(tipo_cont_con==""){msg+="Debe ingresar el Tipo <br>";}
    if(nume_cont_con==""){msg+="Debe ingresar el Número Contrato<br>";}

	if(mont_cont_ctr==""){msg+="Debe ingresar el Monto<br>";}
	if(deno_part_cnt==""){msg+="Debe ingresar el concurso<br>";}
	if(func_cont_cnt==""){msg+="Debe ingresar las funciones<br>";}
    
	if(msg!=""){
        bootbox.alert(msg); 
        return false;
    }
	
	
	var msgLoader = "";
	msgLoader = "Procesando, espere un momento por favor";
	var heightBrowser = $(window).width()/2;
	$('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
    $('.loader').show();
	//$('#guardar').hide();
	$("#btnGuardar").prop('disabled', true);
	
    $.ajax({
			url: "/persona/send_persona_contrato",
            type: "POST",
            data : {_token:_token,id_persona:id_persona,tipo_cont_con:tipo_cont_con,nume_cont_con:nume_cont_con,fech_reso_cnt:fech_reso_cnt,fech_inic_cnt:fech_inic_cnt,fech_fina_cnt:fech_fina_cnt,id_cargo:id_cargo,mont_cont_ctr:mont_cont_ctr,deno_part_cnt:deno_part_cnt,func_cont_cnt:func_cont_cnt,fech_crea:fech_crea},

			success: function (result) {
				$('.loader').hide();
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



//obtener_cuota_();


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
				Nuevo Contrato
			</div>
			
            <div class="card-body">

			<div class="row">

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:10px">
					
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<input type="hidden" name="id_persona" id="id_persona" value="<?php echo $id_persona?>">
					
					<div class="row">
						
						<div class="col-lg-3">
							<div class="form-group">
								<label class="control-label">F. Registro</label>
								<input placeholder="Fecha Registro" autocomplete="off" type="text" wire:model="fech_crea" id="fech_crea" class="form-control form-control-sm datepicker" <?php if($id!=0)echo "readonly"?> data-provide="datepicker" data-date-autoclose="true" 
									data-date-format="yyyy-mm-dd" data-date-today-highlight="true"                        
									onchange="this.dispatchEvent(new InputEvent('input'))" value="<?php echo $fecha_actual?>" >
									@error('fech_crea') <span ...>Dato requerido</span> @enderror										
							</div>
						</div>							

						<div class="col-lg-3">
							<div class="form-group" style="padding-top:0px;padding-bottom:0px;margin-top:0px;margin-bottom:0px">
								<label class="control-label">Tipo</label>
								<select name="tipo_cont_con" id="tipo_cont_con" class="form-control form-control-sm" <?php if($id!=0)echo "readonly"?>>
									<option value="0">Seleccionar</option>
									<option value="P"  ><?php echo "PRINCIPAL"?></option>
									<option value="A"  ><?php echo "ADENDA"?></option>									
								</select>
								@error('tipo_cont_con') <span ...>Dato requerido</span> @enderror
							</div>
						</div>

						<div class="col-lg-3">
							<div class="form-group" style="padding-top:0px;padding-bottom:0px;margin-top:0px;margin-bottom:0px">
								<label class="control-label">Nro. Contrato</label>
								<input id="nume_cont_con" name="nume_cont_con" class="form-control form-control-sm"  value="" type="text">
								@error('nume_cont_con') <span ...>Dato requerido</span> @enderror
							</div>
						</div>
						<div class="col-lg-3">
							<div class="form-group">
								<label class="control-label">F. Suscrip</label>
								<input placeholder="Fecha Suscrip" autocomplete="off" type="text" wire:model="fech_reso_cnt" id="fech_reso_cnt" class="form-control form-control-sm datepicker" <?php if($id!=0)echo "readonly"?> data-provide="datepicker" data-date-autoclose="true" 
									data-date-format="yyyy-mm-dd" data-date-today-highlight="true"                        
									onchange="this.dispatchEvent(new InputEvent('input'))" value="<?php echo $fecha_actual?>" >
									@error('fech_reso_cnt') <span ...>Dato requerido</span> @enderror										
							</div>
						</div>

					</div>		
					<div class="row">
						<div class="col-lg-3">
							<div class="form-group">
								<label class="control-label">F. Inicio</label>
								<input placeholder="Fecha Inicio" autocomplete="off" type="text" wire:model="fech_inic_cnt" id="fech_inic_cnt" class="form-control form-control-sm datepicker" <?php if($id!=0)echo "readonly"?> data-provide="datepicker" data-date-autoclose="true" 
									data-date-format="yyyy-mm-dd" data-date-today-highlight="true"                        
									onchange="this.dispatchEvent(new InputEvent('input'))" value="<?php echo $fecha_actual?>" >
									@error('fech_inic_cnt') <span ...>Dato requerido</span> @enderror										
							</div>
						</div>		
						<div class="col-lg-3">
							<div class="form-group">
								<label class="control-label">F. Fin</label>
								<input placeholder="Fecha Fin" autocomplete="off" type="text" wire:model="fech_fina_cnt" id="fech_fina_cnt" class="form-control form-control-sm datepicker" <?php if($id!=0)echo "readonly"?> data-provide="datepicker" data-date-autoclose="true" 
									data-date-format="yyyy-mm-dd" data-date-today-highlight="true"                        
									onchange="this.dispatchEvent(new InputEvent('input'))" value="<?php echo $fecha_actual?>" >
									@error('fech_fina_cnt') <span ...>Dato requerido</span> @enderror										
							</div>
						</div>		
						<div class="col-lg-6">
							<div class="form-group" style="padding-top:0px;padding-bottom:0px;margin-top:0px;margin-bottom:0px">
								<label class="control-label">Cargo</label>
								<select name="id_cargo" id="id_cargo" class="form-control form-control-sm">
										<option value="0">Seleccionar</option>
										<?php foreach($cargo as $row):?>
											<option value="<?php echo $row->id?>" <?php if($row->id=='')echo "selected='selected'"?> ><?php echo $row->denominacion?></option>
										<?php  endforeach;?>
								</select>
								@error('id_cargo') <span ...>Dato requerido</span> @enderror
							</div>
						</div>

					</div>
					<div class="row">							

					</div>
					<div class="row">
						<div class="col-lg-3">
							<div class="form-group" style="padding-top:0px;padding-bottom:0px;margin-top:0px;margin-bottom:0px">
								<label class="control-label">Monto Contratado</label>
								<input id="mont_cont_ctr" name="mont_cont_ctr" class="form-control form-control-sm"  value="" type="text">
								@error('mont_cont_ctr') <span ...>Dato requerido</span> @enderror
							</div>
						</div>						
						<div class="col-lg-3">
							<div class="form-group" style="padding-top:0px;padding-bottom:0px;margin-top:0px;margin-bottom:0px">
								<label class="control-label">Concurso Público</label>
								<input id="deno_part_cnt" name="deno_part_cnt" class="form-control form-control-sm"  value="" type="text">
								@error('deno_part_cnt') <span ...>Dato requerido</span> @enderror
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group" style="padding-top:0px;padding-bottom:0px;margin-top:0px;margin-bottom:0px">
								<label class="control-label">Funciones</label>
								<input id="func_cont_cnt" name="func_cont_cnt" class="form-control form-control-sm"  value="" type="text">
								@error('func_cont_cnt') <span ...>Dato requerido</span> @enderror
							</div>
						</div>
														
					</div>	
					
					<div style="margin-top:10px" class="row form-group">
						<div class="col-sm-12 controls">
							<div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions" style="float:right">
								<!--<a href="javascript:void(0)" id="btnGuardar" onClick="fn_save()" class="btn btn-sm btn-success">Guardar</a>-->
								<input class="btn btn-sm btn-success" value="Guardar" type="button" id="btnGuardar" onClick="fn_save()">
								
								</div>
							
						</div>
					</div> 
					
              </div>
			  
			  
			  <div class="card-body">
							
					<div class="table-responsive">
					<table id="tblAdelanto" class="table table-hover table-sm">
					<thead>
					<tr style="font-size:13px">
						<th>Nro. Adenda</th>
						<th>Nro. Contrato</th>
						<th>Fecha Inicio</th>
						<th>Fecha Final</th>
						<th>Tipo</th>
						<th>Monto</th>
					</tr>
					</thead>
					<tbody style="font-size:13px">
					<?php
						foreach($contrato as $key=>$row){
					?>	
						<tr>
							<td><?php echo $row->nume_cont_con?></td>
							<td><?php echo $row->nume_cont_con?></td>
							<td><?php echo $row->fech_inic_cnt?></td>
							<td><?php echo $row->fech_fina_cnt?></td>
							<td><?php echo $row->tipo_cont_con?></td>
							<td><?php echo $row->mont_cont_ctr?></td>

							

						</tr>
					<?php
						}
					?>
					</tbody>
					</table>
					
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

	/*
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
	*/
});

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
</script>

