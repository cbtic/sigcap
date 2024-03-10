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
	 
	$('#dni_propietario_').show();
    $('#nombre_propietario_').show();
    $('#direccion_dni_').show();
    $('#celular_dni_').show();
    $('#email_dni_').show();
    $('#ruc_propietario_').hide();
    $('#razon_social_propietario_').hide();
    $('#direccion_ruc_').hide();
    $('#telefono_ruc_').hide();
    $('#email_ruc_').hide();
	

});

function obtenerPropietario(){
	
	var id_tipo_documento = $("#id_tipo_documento").val();

	$('#dni_propietario_').show();
    $('#nombre_propietario_').show();
    $('#direccion_dni_').show();
    $('#celular_dni_').show();
    $('#email_dni_').show();
    $('#ruc_propietario_').hide();
    $('#razon_social_propietario_').hide();
    $('#direccion_ruc_').hide();
    $('#telefono_ruc_').hide();
    $('#email_ruc_').hide();
	
	if (id_tipo_documento == "")//SELECCIONAR
	{
		
		$('#dni_propietario_').show();
        $('#nombre_propietario_').show();
        $('#direccion_dni_').show();
        $('#celular_dni_').show();
        $('#email_dni_').show();
        $('#ruc_propietario_').hide();
        $('#razon_social_propietario_').hide();
        $('#direccion_ruc_').hide();
        $('#telefono_ruc_').hide();
        $('#email_ruc_').hide();

	} else if (id_tipo_documento == "78")//DNI
	{
		
		$('#dni_propietario_').show();
        $('#nombre_propietario_').show();
        $('#direccion_dni_').show();
        $('#celular_dni_').show();
        $('#email_dni_').show();
        $('#ruc_propietario_').hide();
        $('#razon_social_propietario_').hide();
        $('#direccion_ruc_').hide();
        $('#telefono_ruc_').hide();
        $('#email_ruc_').hide();

	} else if (id_tipo_documento == "79") //Responsable de Tramite
	{
		$('#dni_propietario_').hide();
        $('#nombre_propietario_').hide();
        $('#direccion_dni_').hide();
        $('#celular_dni_').hide();
        $('#email_dni_').hide();
        $('#ruc_propietario_').show();
        $('#razon_social_propietario_').show();
        $('#direccion_ruc_').show();
        $('#telefono_ruc_').show();
        $('#email_ruc_').show();

	} 
}

function obtenerProyectista(){
		
    var numero_cap = $("#numero_cap").val();
    var msg = "";
    
    if(numero_cap == "")msg += "Debe ingresar el numero de documento <br>";
    
    if (msg != "") {
        bootbox.alert(msg);
        return false;
    }
    
    var msgLoader = "";
    msgLoader = "Procesando, espere un momento por favor";
    var heightBrowser = $(window).width()/2;
    $('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
    $('.loader').show();
    
    $.ajax({
        url: '/agremiado/obtener_datos_agremiado/' + numero_cap,
        dataType: "json",
        success: function(result){
            
            var agremiado = result.agremiado;
            //var tipo_documento = parseInt(agremiado.tipo_documento);
            //var nombre = persona.apellido_paterno+" "+persona.apellido_materno+", "+persona.nombres;
            $('#frmProyectistaNuevo #agremiado').val(agremiado.agremiado);
            $('#frmProyectistaNuevo #situacion').val(agremiado.situacion);
            $('#frmProyectistaNuevo #celular').val(agremiado.celular);
            $('#frmProyectistaNuevo #email').val(agremiado.email);
            
            //$('#telefono').val(persona.telefono);
            //$('#email').val(persona.email);
            
            $('.loader').hide();

        }
        
    });
    
}

function obtenerDatosDni(){
		
    var dni_propietario = $("#dni_propietario").val();
    var msg = "";
    
    if(dni_propietario == "")msg += "Debe ingresar el numero de documento <br>";
    
    if (msg != "") {
        bootbox.alert(msg);
        return false;
    }
    
    var msgLoader = "";
    msgLoader = "Procesando, espere un momento por favor";
    var heightBrowser = $(window).width()/2;
    $('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
    $('.loader').show();
    
    $.ajax({
        url: '/persona/obtener_datos_persona/' + dni_propietario,
        dataType: "json",
        success: function(result){
            var persona = result.persona;

            if(persona!="0")
			{
                $('#nombre_propietario').val(persona.nombres);
                $('#direccion_dni').val(persona.direccion);
                $('#celular_dni').val(persona.numero_celular);
                $('#email_dni').val(persona.correo);
                
                $('.loader').hide();
				
			}else{
				msg += "La Persona no esta registrado en la Base de Datos de CAP <br>";
                $('#nombre_propietario').val("");
                $('#direccion_dni').val("");
                $('#celular_dni').val("");
                $('#email_dni').val("");
				$('.loader').hide();
				
			}

			if (msg != "") {
				bootbox.alert(msg);
				return false;
			}


        }
        
    });
    
}


function obtenerDatosRuc(){
    
    var ruc_propietario = $("#ruc_propietario").val();
    var msg = "";
    
    if(ruc_propietario == "")msg += "Debe ingresar el RUC <br>";
    
    if (msg != "") {
        bootbox.alert(msg);
        return false;
    }
    
    var msgLoader = "";
    msgLoader = "Procesando, espere un momento por favor";
    var heightBrowser = $(window).width()/2;
    $('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
    $('.loader').show();
    
    $.ajax({
        url: '/empresa/obtener_datos_empresa/' + ruc_propietario,
        dataType: "json",
        success: function(result){
            var empresa = result.empresa;

            if(empresa!="0")
            {
                $('#razon_social_propietario').val(empresa.razon_social);
                $('#direccion_ruc').val(empresa.direccion);
                $('#telefono_ruc').val(empresa.telefono);
                $('#email_ruc').val(empresa.email);
                
                $('.loader').hide();
                
            }else{
                msg += "La Empresa no esta registrada en la Base de Datos de CAP <br>";
                $('#razon_social_propietario').val("");
                $('#direccion_ruc').val("");
                $('#telefono_ruc').val("");
                $('#email_ruc').val("");
                $('.loader').hide();
                
            }

            if (msg != "") {
                bootbox.alert(msg);
                return false;
            }


        }
        
    });
    
}
    

function editarPuesto(id){

	$.ajax({
		url: '/concurso/obtener_puesto/'+id,
		dataType: "json",
		success: function(result){
			//alert(result);
			console.log(result);
			$('#id').val(result.id);
			$('#id_tipo_plaza').val(result.id_tipo_plaza);
			$('#numero_plazas').val(result.numero_plazas);
		}
		
	});

}

function eliminarPuesto(id){
	
    bootbox.confirm({ 
        size: "small",
        message: "&iquest;Deseas eliminar el Puesto?", 
        callback: function(result){
            if (result==true) {
                fn_eliminar_puesto(id);
            }
        }
    });
    //$(".modal-dialog").css("width","30%");
}

function fn_eliminar_puesto(id){
	
	$.ajax({
            url: "/concurso/eliminar_puesto/"+id,
            type: "GET",
            success: function (result) {
				datatablenewRequisito();
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

function limpiar(){
	$('#id').val("0");
	$('#id_tipo_documento').val("");
	$('#denominacion').val("");
	$('#img_foto').val("");
}

function fn_save_requisito(){
    
	var _token = $('#_token').val();
	var id = $('#id').val();
	var id_concurso = $('#id_concurso').val();
	var id_tipo_documento = $('#id_tipo_documento').val();
	var denominacion = $('#denominacion').val();
	var img_foto = $('#img_foto').val();
	
	$.ajax({
			url: "/concurso/send_requisito",
            type: "POST",
            data : {_token:_token,id:id,id_concurso:id_concurso,id_tipo_documento:id_tipo_documento,denominacion:denominacion,img_foto:img_foto},
			success: function (result) {
				//$('#openOverlayOpc').modal('hide');
				datatablenewRequisito();
				limpiar();
								
            }
    });
}

function fn_save_propietario(){
    
	var _token = $('#_token').val();
	var id = $('#id').val();
    var ruc_propietario = $('#ruc_propietario').val();
	var razon_social_propietario = $('#razon_social_propietario').val();
    var direccion_ruc = $('#direccion_ruc').val();
	var telefono_ruc = $('#telefono_ruc').val();
	var email_ruc = $('#email_ruc').val();
    var dni_propietario = $('#dni_propietario').val();
	var nombre_propietario = $('#nombre_propietario').val();
    var direccion_dni = $('#direccion_dni').val();
	var celular_dni = $('#celular_dni').val();
	var email_dni = $('#email_dni').val();
	
	$.ajax({
			url: "/derecho_revision/send_nueno_propietario",
            type: "POST",
            data : {_token:_token,id:id,ruc_propietario:ruc_propietario,razon_social_propietario:razon_social_propietario,direccion_ruc:direccion_ruc,telefono_ruc:telefono_ruc,email_ruc:email_ruc,dni_propietario:dni_propietario,nombre_propietario:nombre_propietario,direccion_dni:direccion_dni,celular_dni:celular_dni,email_dni:email_dni},
			success: function (result) {
				$('#openOverlayOpc').modal('hide');
				window.location.reload();
								
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
                    Registro de Propietario
                </div>
                
                <div class="card-body">
                <form method="post" action="#" id="frmPropietarioaNuevo" name="frmPropietarioNuevo">
                    <div class="row">

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:5px;padding-bottom:20px">
                        
                        <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="id" id="id" value="<?php echo $id?>">
                        
                            <div class="row" style="padding-left:10px">
                            
                                <div class="col-lg-4">
                                    <label class="control-label form-control-sm">Tipo Documento</label>
                                    <select name="id_tipo_documento" id="id_tipo_documento" class="form-control form-control-sm" onchange="obtenerPropietario()">
                                        <option value="">--Selecionar--</option>
                                        <?php
                                        foreach ($tipo_documento as $row) {?>
                                        <option value="<?php echo $row->codigo?>" <?php if($row->codigo==$persona->id_tipo_documento)echo "selected='selected'"?>><?php echo $row->denominacion?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="col-lg-3">
                                    <div class="form-group" id="dni_propietario_">
                                    <label class="control-label form-control-sm">DNI</label>
                                    <input id="dni_propietario" name="dni_propietario" on class="form-control form-control-sm"  value="<?php echo $persona->numero_documento?>" type="text" onchange="obtenerDatosDni()">
                                    </div>
                                    <div class="form-group" id="ruc_propietario_">
                                        <label class="control-label form-control-sm">RUC</label>
                                        <input id="ruc_propietario" name="ruc_propietario" on class="form-control form-control-sm"  value="<?php echo $empresa->ruc?>" type="text" onchange="obtenerDatosRuc()">
                                    </div>
                                </div>

                                <div class="col-lg-5" >
                                <div class="form-group" id="nombre_propietario_">
                                    <label class="control-label form-control-sm">Nombre</label>
                                    <input id="nombre_propietario" name="nombre_propietario" on class="form-control form-control-sm"  value="<?php echo $persona->desc_cliente_sunat?>" type="text" onchange="" readonly='readonly'>
                                    </div>
                                    <div class="form-group" id="razon_social_propietario_">
                                        <label class="control-label form-control-sm">Raz&oacute;n Social</label>
                                        <input id="razon_social_propietario" name="razon_social_propietario" on class="form-control form-control-sm"  value="<?php echo $empresa->razon_social?>" type="text" onchange="" readonly='readonly'>
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="padding-left:10px;padding-top:25px">
                                <div class="col-lg-6" >
                                    <div class="form-group" id="direccion_dni_">
                                        <label class="control-label form-control-sm">Direcci&oacute;n</label>
                                        <input id="direccion_dni" name="direccion_dni" on class="form-control form-control-sm"  value="<?php echo $persona->direccion?>" type="text" onchange="" readonly='readonly'>
                                    </div>
                                    <div class="form-group" id="direccion_ruc_">
                                        <label class="control-label form-control-sm">Direcci&oacute;n</label>
                                        <input id="direccion_ruc" name="direccion_ruc" on class="form-control form-control-sm"  value="<?php echo $empresa->direccion?>" type="text" onchange="" readonly='readonly'>
                                    </div>
                                </div>
                               
                                <div class="col-lg-4" >
                                    <div class="form-group" id="celular_dni_">
                                        <label class="control-label form-control-sm">Celular</label>
                                        <input id="celular_dni" name="celular_dni" on class="form-control form-control-sm"  value="<?php echo $persona->numero_celular?>" type="text" onchange="" readonly='readonly'>
                                    </div>
                                    <div class="form-group" id="telefono_ruc_">
                                        <label class="control-label form-control-sm">Tel&eacute;fono</label>
                                        <input id="telefono_ruc" name="telefono_ruc" on class="form-control form-control-sm"  value="<?php echo $empresa->telefono?>" type="text" onchange="" readonly='readonly'>
                                    </div>
                                </div>

                                <div class="col-lg-5" >
                                    <div class="form-group" id="email_dni_">
                                        <label class="control-label form-control-sm">Email</label>
                                        <input id="email_dni" name="email_dni" on class="form-control form-control-sm"  value="<?php echo $persona->correo?>" type="text" onchange="" readonly='readonly'>
                                    </div>
                                    <div class="form-group" id="email_ruc_">
                                        <label class="control-label form-control-sm">Email</label>
                                        <input id="email_ruc" name="email_ruc" on class="form-control form-control-sm"  value="<?php echo $empresa->email?>" type="text" onchange="" readonly='readonly'>
                                    </div>
                                </div>
                            </div>
                            <div style="margin-top:10px" class="form-group">
                                <div class="col-sm-12 controls">
                                    <div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions" style="float:right">
                                        <a href="javascript:void(0)" onClick="fn_save_propietario()" class="btn btn-sm btn-success">Guardar</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                </div>
                <!-- /.box -->
                
            </div>
        <!--/.col (left) -->
     
        </div>
          <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
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

