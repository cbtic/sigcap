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
	var id_ubigeo_municipalidad = $("#id_ubigeo_municipalidad").val();
	var idProvinciaMunicipalidad = id_ubigeo_municipalidad.substring(2,4);
	var idDistritoMunicipalidad = id_ubigeo_municipalidad.substring(4,6);
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
	 
	var id_ubigeo = "<?php echo $municipalidad->id_ubigeo?>";
	var idProvincia = id_ubigeo.substring(2,4);
	var idDistrito = id_ubigeo.substring(4,6);
	
	//alert(id_ubigeo+"|"+idProvincia+"|"+idDistrito);
	
	obtenerProvinciaEdit(idProvincia);	 
	obtenerDistritoEdit(idProvincia,idDistrito);
	
});

function obtenerProvinciaEdit(idProvincia){
	
	var id = $('#id_departamento_domiciliario').val();
	if(id=="")return false;
	$('#id_provincia_domiciliario').attr("disabled",true);
	$('#id_distrito_domiciliario').attr("disabled",true);
	
	var msgLoader = "";
	msgLoader = "Procesando, espere un momento por favor";
	var heightBrowser = $(window).width()/2;
	$('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
    $('.loader').show();
	
	$.ajax({
		url: '/agremiado/obtener_provincia/'+id,
		dataType: "json",
		success: function(result){
			var option = "<option value='' selected='selected'>Seleccionar</option>";
			$('#id_provincia_domiciliario').html("");
			var selected = "";
			$(result).each(function (ii, oo) {
				selected = "";
				if(idProvincia == oo.id_provincia)selected = "selected='selected'";
				option += "<option value='"+oo.id_provincia+"' "+selected+" >"+oo.desc_ubigeo+"</option>";
			});
			$('#id_provincia_domiciliario').html(option);
			$('#id_provincia_domiciliario').attr("disabled",false);
			$('.loader').hide();
			
		}
		
	});
	
}

function obtenerDistritoEdit(idProvincia,idDistrito){
	
	var id_departamento = $('#id_departamento_domiciliario').val();
	var id = idProvincia;
	if(id=="")return false;
	$('#id_distrito_domiciliario').attr("disabled",true);
	
	var msgLoader = "";
	msgLoader = "Procesando, espere un momento por favor";
	var heightBrowser = $(window).width()/2;
	$('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
    $('.loader').show();
	
	$.ajax({
		url: '/agremiado/obtener_distrito/'+id_departamento+'/'+id,
		dataType: "json",
		success: function(result){
			var option = "<option value=''>Seleccionar</option>";
			$('#id_distrito_domiciliario').html("");
			var selected = "";
			$(result).each(function (ii, oo) {
				selected = "";
				if(id_departamento+idProvincia+idDistrito == oo.id_ubigeo)selected = "selected='selected'";
				option += "<option value='"+oo.id_ubigeo+"' "+selected+" >"+oo.desc_ubigeo+"</option>";
			});
			$('#id_distrito_domiciliario').html(option);
			$('#id_distrito_domiciliario').attr("disabled",false);
			$('.loader').hide();
			
		}
		
	});
	
}

function validacion(){
    
    var msg = "";
    var cobservaciones=$("#frmComentar #cobservaciones").val();
    
    if(cobservaciones==""){msg+="Debe ingresar una Observacion <br>";}
    
    if(msg!=""){
        bootbox.alert(msg); 
        return false;
    }
}

function obtenerProvinciaDomiciliario(){
	
	var id = $('#id_departamento_domiciliario').val();
	if(id=="")return false;
	$('#id_provincia_domiciliario').attr("disabled",true);
	$('#id_distrito_domiciliario').attr("disabled",true);
	
	var msgLoader = "";
	msgLoader = "Procesando, espere un momento por favor";
	var heightBrowser = $(window).width()/2;
	$('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
    $('.loader').show();
	
	$.ajax({
		url: '/municipalidad/obtener_provincia/'+id,
		dataType: "json",
		success: function(result){
			var option = "<option value='' selected='selected'>Seleccionar</option>";
			$('#id_provincia_domiciliario').html("");
			$(result).each(function (ii, oo) {
				option += "<option value='"+oo.id_provincia+"'>"+oo.desc_ubigeo+"</option>";
			});
			$('#id_provincia_domiciliario').html(option);
			
			var option2 = "<option value=''>Seleccionar</option>";
			$('#id_distrito_domiciliario').html(option2);
			
			$('#id_provincia_domiciliario').attr("disabled",false);
			$('#id_distrito_domiciliario').attr("disabled",false);
			
			$('.loader').hide();
			
		}
		
	});
	
}


function obtenerDistritoDomiciliario(){
	
	var id_departamento = $('#id_departamento_domiciliario').val();
	var id = $('#id_provincia_domiciliario').val();
	if(id=="")return false;
	$('#id_distrito_domiciliario').attr("disabled",true);
	
	var msgLoader = "";
	msgLoader = "Procesando, espere un momento por favor";
	var heightBrowser = $(window).width()/2;
	$('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
    $('.loader').show();
	
	$.ajax({
		url: '/municipalidad/obtener_distrito/'+id_departamento+'/'+id,
		dataType: "json",
		success: function(result){
			var option = "<option value=''>Seleccionar</option>";
			$('#id_distrito_domiciliario').html("");
			$(result).each(function (ii, oo) {
				option += "<option value='"+oo.id_ubigeo+"'>"+oo.desc_ubigeo+"</option>";
			});
			$('#id_distrito_domiciliario').html(option);
			
			$('#id_distrito_domiciliario').attr("disabled",false);
			$('.loader').hide();
			
		}
		
	});
	
}


function fn_save(){
    
	var _token = $('#_token').val();
	var id  = $('#id').val();
	var denominacion = $('#denominacion_').val();
	var tipo_municipalidad=$('#tipo_municipalidad_').val();	
	var id_departamento_domiciliario=$('#id_departamento_domiciliario').val();	
	var id_provincia_domiciliario=$('#id_provincia_domiciliario').val();	
	var id_distrito_domiciliario=$('#id_distrito_domiciliario').val();	
	
    $.ajax({
			url: "/municipalidad/send_municipalidad",
            type: "POST",
            data : {_token:_token,id:id,denominacion:denominacion,tipo_municipalidad:tipo_municipalidad,id_departamento_domiciliario:id_departamento_domiciliario,id_provincia_domiciliario:id_provincia_domiciliario,id_distrito_domiciliario:id_distrito_domiciliario},
			//dataType: 'json',
			
	
            success: function (result) {
				
			/*	if(result.sw==false){
					bootbox.alert(result.msg);
				}
*/
				$('#openOverlayOpc').modal('hide');
				window.location.reload();

								
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
				Edici&oacute;n Municipalidad
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

						<div class="col-lg-12">
							<div class="form-group">
								<label class="control-label">Denominacion</label>
								<input id="denominacion_" name="denominacion_" class="form-control form-control-sm"  value="<?php echo $municipalidad->denominacion?>" type="text"  >
							</div>
						</div>

						<div class="col-lg-12">
							<div class="form-group">
								<label class="control-label">Tipo de Municipalidad</label>
								<select name="tipo_municipalidad_" id="tipo_municipalidad_" class="form-control form-control-sm" onChange="">
									<option value="">--Selecionar--</option>
									<?php
									foreach ($tipo_municipalidad as $row) {?>
									<option value="<?php echo $row->codigo?>" <?php if($row->codigo==$municipalidad->id_tipo_municipalidad)echo "selected='selected'"?>><?php echo $row->denominacion?></option>
									<?php 
									}
									?>
								</select>
							</div>
						</div>

						<div class="card-body" style="margin-top:15px;margin-bottom:15px">
										
							<div style="clear:both"></div>
							
							<div class="row">
								<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
								Departamento
								</div>
								<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
								
								<input type="hidden" name="id_ubigeo_municipalidad" id="id_ubigeo_municipalidad" value="<?php echo $municipalidad->id_ubigeo?>">
								<select name="id_departamento_domiciliario" id="id_departamento_domiciliario" class="form-control form-control-sm" onChange="obtenerProvinciaDomiciliario()">
									<option value="">--Selecionar--</option>
									<?php
									foreach ($departamento as $row) {?>
									<option value="<?php echo $row->id_departamento?>" <?php if($row->id_departamento==substr($municipalidad->id_ubigeo,0,2))echo "selected='selected'"?>><?php echo $row->desc_ubigeo ?></option>
									<?php 
									}
									?>
								</select>
								</div>
								<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
								Provincia
								</div>
								<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
								<select name="id_provincia_domiciliario" id="id_provincia_domiciliario" class="form-control form-control-sm" onChange="obtenerDistritoDomiciliario()">
									<option value="">--Selecionar--</option>
								</select>
								</div>
								<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
								Distrito
								</div>
								<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
								<select name="id_distrito_domiciliario" id="id_distrito_domiciliario" class="form-control form-control-sm" onChange="">
									<option value="">--Selecionar--</option>
								</select>
								</div>
							</div>
						</div>
					</div>
		
					
					<div style="margin-top:10px" class="form-group">
						<div class="col-sm-12 controls">
							<div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions">
								<a href="javascript:void(0)" onClick="fn_save()" class="btn btn-sm btn-success">Guardar</a>
								
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

