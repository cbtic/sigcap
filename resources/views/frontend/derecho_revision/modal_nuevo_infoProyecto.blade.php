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

.form-check.tipo {
    margin-left: 0;
}

.form-check.subtipo {
    margin-left: 20px;
}

.form-check.subsubtipo {
    margin-left: 40px;
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
	$(".upload").on('click', function() {
		var id = $(this).attr("id");
        var formData = new FormData();
		//alert(id);return false;
        var formData = new FormData();
        var files = $('#image'+id)[0].files[0];
        var maxSize = 10 * 1024 * 1024;

		if (files.size > maxSize) {
			bootbox.alert("El archivo supera el tamaño máximo permitido de 15 MB.");
			return; 
		}
        formData.append('file',files);
        $.ajax({
			headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "/derecho_revision/upload_solicitud",
            type: 'post',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
				
                if (response != 0) {
					var extension = "";
					extension = response.substring(response.lastIndexOf('.') + 1);

                    //alert(id);
					
					if(extension=="doc" || extension=="docx" || extension=="pdf" || extension=="xls" || extension=="xlsx"){
						$("#img_ruta"+id).attr("src", "/img/check.png");
					}else{
                    	$("#img_ruta"+id).attr("src", "/img/frontend/tmp_derecho_revision/"+response);
					}
					$("#img_foto"+id).val(response);
                } else {
                    alert('Formato de imagen incorrecto.');
                }
            }
        });
		return false;
    });
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

function fn_save_infoProyeto(){
    
	var _token = $('#_token').val();
	var id = $('#id').val();
    var id_solicitud = $('#id_solicitud').val();
    var areaBruta = $('#areaBruta').val();
	
    var selectedProcedures = [];
    $('input[name="grupo_tramite1"]:checked').each(function() {
        selectedProcedures.push($(this).val());
    });

    var selectedProcedures2 = [];
    $('input[name="grupo_tramite2"]:checked').each(function() {
        selectedProcedures2.push($(this).val());
    });

    var selectedProceduresStr = selectedProcedures.join(', ');

    var selectedProceduresStr2 = selectedProcedures2.join(', ');
	
	var img_foto1 = $('#img_foto1').val();
	var img_foto2 = $('#img_foto2').val();
	var img_foto3 = $('#img_foto3').val();
	
    if (selectedProcedures.length === 0 || selectedProcedures2.length === 0 || areaBruta === '') {
        
        bootbox.alert('Por favor complete todos los campos obligatorios.');
        return;
    }

	$.ajax({
			url: "/derecho_revision/send_nueno_infoProyecto",
            type: "POST",
            data : {_token:_token,id:id,procedimientos_complementarios: selectedProceduresStr,
                    procedimientos_complementarios2: selectedProceduresStr2,areaBruta:areaBruta,
                    id_solicitud:id_solicitud,img_foto1:img_foto1,img_foto2:img_foto2,img_foto3:img_foto3},
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
				Registro de Informaci&oacute;n del Proyecto
			</div>
			
            <div class="card-body">
			<form method="post" action="#" id="frmProyectistaNuevo" name="frmProyectistaNuevo">
			<div class="row">

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:5px;padding-bottom:20px">
                        
                    <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="id" id="id" value="<?php echo $id?>">
                    
                    <div style="padding: 0px 0px 15px 10px; font-weight: bold">
                        Tipo de Tramite
                    </div>
                    
                    <div class="row" style="padding-left:10px">
                        <div class="col-lg-6" >
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" id="check_opc1" name="grupo_tramite1" <?php if (in_array(1, $selectedIdsTramite)) echo "checked='checked'"; ?>>
                                <label class="form-check-label" for="check_opc1">
                                    Habilitaci&oacute;n Urbana
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="2" id="check_opc2" name="grupo_tramite1" <?php if (in_array(2, $selectedIdsTramite)) echo "checked='checked'"; ?>>
                                <label class="form-check-label" for="check_opc2">
                                    Regularizaci&oacute;n de habilitaci&oacute;n urbana
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="3" id="check_opc3" name="grupo_tramite1" <?php if (in_array(3, $selectedIdsTramite)) echo "checked='checked'"; ?>>
                                <label class="form-check-label" for="check_opc3">
                                    Modificaci&oacute;n de proyecto aprobado de habilitaci&oacute;n urbana
                                </label>
                            </div>
                            <div class="row">
                                <div class="col-lg-3" >
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="7" id="check_opc4" name="grupo_tramite1" <?php if (in_array(7, $selectedIdsTramite)) echo "checked='checked'"; ?>>
                                        <label class="form-check-label" for="check_opc4">
                                            Otros
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-9" >
                                    <input id="otro" name="otro" on class="form-control form-control-sm"  value="" type="text" onChange="" <?php if (in_array(0, $selectedIdsTramite)) echo "checked='checked'"; ?>>
                                </div>
                            </div>
                        </div>   
                        <div class="col-lg-6" >  
                            <div style="padding: 0px 0px 15px 10px; font-weight: bold">
                                Procedimientos Complementarios
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="4" id="check_opc5" name="grupo_tramite1" <?php if (in_array(4, $selectedIdsTramite)) echo "checked='checked'"; ?>>
                                <label class="form-check-label" for="check_opc5">
                                    Independizaci&oacute;n o parcelaci&oacute;n de terrenos rusticos
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="5" id="check_opc6" name="grupo_tramite1" <?php if (in_array(5, $selectedIdsTramite)) echo "checked='checked'"; ?>>
                                <label class="form-check-label" for="check_opc6">
                                    Subdivisi&oacute;n de lote urbano
                                </label>
                            </div>
                        </div>
                    </div>

                    <div style="padding: 20px 0px 15px 10px; font-weight: bold">
                        Tipo de Habilitaci&oacute;n Urbana
                    </div>
                    
                    <div class="row" style="padding-left:10px">
                        <div class="col-lg-6" >
                            <div class="form-check tipo">
                                <input class="form-check-input" type="checkbox" value="1" id="check_opc8" name="grupo_tramite2" <?php if (in_array(1, $selectedIds)) echo "checked='checked'"; ?>>
                                <label class="form-check-label" for="check_opc8">
                                    Uso de Vivienda o urbanizaci&oacute;n
                                </label>
                            </div>

                            <div class="form-check subtipo">
                                <input class="form-check-input" type="checkbox" value="2" id="check_opc9" name="grupo_tramite2" <?php if (in_array(2, $selectedIds)) echo "checked='checked'"; ?>
                                onclick="document.getElementById('check_opc8').checked = this.checked || document.getElementById('check_opc10').checked || document.getElementById('check_opc14').checked || document.getElementById('check_opc15').checked;">
                                <label class="form-check-label" for="check_opc9">
                                    Tipo Convecional
                                </label>
                            </div>

                            <div class="form-check subtipo">
                                <input class="form-check-input" type="checkbox" value="3" id="check_opc10" name="grupo_tramite2" <?php if (in_array(3, $selectedIds)) echo "checked='checked'"; ?>
                                onclick="document.getElementById('check_opc8').checked = this.checked || document.getElementById('check_opc9').checked || document.getElementById('check_opc14').checked || document.getElementById('check_opc15').checked;">
                                <label class="form-check-label" for="check_opc10">
                                    Con Construcci&oacute;n simultanea
                                </label>
                            </div>

                            <div class="form-check subsubtipo">
                                <input class="form-check-input" type="checkbox" value="13" id="check_opc11" name="grupo_tramite2" <?php if (in_array(13, $selectedIds)) echo "checked='checked'"; ?>
                                onclick=" document.getElementById('check_opc10').checked = this.checked || document.getElementById('check_opc12').checked || document.getElementById('check_opc13').checked;
                                document.getElementById('check_opc8').checked = this.checked || document.getElementById('check_opc12').checked || document.getElementById('check_opc13').checked;">
                                <label class="form-check-label" for="check_opc11">
                                    Con Venta Garantizada de Lotes
                                </label>
                            </div>

                            <div class="form-check subsubtipo">
                                <input class="form-check-input" type="checkbox" value="4" id="check_opc12" name="grupo_tramite2" <?php if (in_array(4, $selectedIds)) echo "checked='checked'"; ?>
                                onclick="document.getElementById('check_opc10').checked = this.checked || document.getElementById('check_opc11').checked || document.getElementById('check_opc13').checked;
                                document.getElementById('check_opc8').checked = this.checked || document.getElementById('check_opc11').checked || document.getElementById('check_opc13').checked;">
                                <label class="form-check-label" for="check_opc12">
                                    Con Venta de Viviendas edificadas
                                </label>
                            </div>

                            <div class="form-check subsubtipo">
                                <input class="form-check-input" type="checkbox" value="14" id="check_opc13" name="grupo_tramite2" <?php if (in_array(14, $selectedIds)) echo "checked='checked'"; ?>
                                onclick="document.getElementById('check_opc10').checked = this.checked || document.getElementById('check_opc11').checked || document.getElementById('check_opc12').checked;
                                document.getElementById('check_opc8').checked = this.checked || document.getElementById('check_opc11').checked || document.getElementById('check_opc12').checked;">
                                <label class="form-check-label" for="check_opc13">
                                    Destinada a vivienda temporal o vacacional
                                </label>
                            </div>

                            <div class="form-check subtipo">
                                <input class="form-check-input" type="checkbox" value="5" id="check_opc14" name="grupo_tramite2" <?php if (in_array(5, $selectedIds)) echo "checked='checked'"; ?>
                                onclick="document.getElementById('check_opc8').checked = this.checked || document.getElementById('check_opc9').checked || document.getElementById('check_opc10').checked || document.getElementById('check_opc15').checked;">
                                <label class="form-check-label" for="check_opc14">
                                    De tipo Progresivo
                                </label>
                            </div>

                            <div class="form-check subtipo">
                                <input class="form-check-input" type="checkbox" value="12" id="check_opc15" name="grupo_tramite2" <?php if (in_array(12, $selectedIds)) echo "checked='checked'"; ?>
                                onclick="document.getElementById('check_opc8').checked = this.checked || document.getElementById('check_opc9').checked || document.getElementById('check_opc10').checked || document.getElementById('check_opc14').checked;">
                                <label class="form-check-label" for="check_opc15">
                                    Otros
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-6" >  
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="15" id="check_opc16" name="grupo_tramite2" <?php if (in_array(15, $selectedIds)) echo "checked='checked'"; ?>>
                                <label class="form-check-label" for="check_opc16">
                                    Uso Comercial
                                </label>
                            </div>
                            <div class="form-check tipo">
                                <input class="form-check-input" type="checkbox" value="6" id="check_opc17" name="grupo_tramite2" <?php if (in_array(6, $selectedIds)) echo "checked='checked'"; ?>>
                                <label class="form-check-label" for="check_opc17">
                                    Uso Industrial
                                </label>
                            </div>

                            <div class="form-check subtipo">
                                <input class="form-check-input" type="checkbox" value="7" id="check_opc18" name="grupo_tramite2" <?php if (in_array(7, $selectedIds)) echo "checked='checked'"; ?>
                                onclick="document.getElementById('check_opc17').checked = this.checked || document.getElementById('check_opc19').checked;">
                                <label class="form-check-label" for="check_opc18">
                                    Convencional
                                </label>
                            </div>

                            <div class="form-check subtipo">
                                <input class="form-check-input" type="checkbox" value="8" id="check_opc19" name="grupo_tramite2" <?php if (in_array(8, $selectedIds)) echo "checked='checked'"; ?>
                                onclick="document.getElementById('check_opc17').checked = this.checked || document.getElementById('check_opc18').checked;">
                                <label class="form-check-label" for="check_opc19">
                                    Con Construcci&oacute;n simultanea
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="9" id="check_opc20" name="grupo_tramite2" <?php if (in_array(9, $selectedIds)) echo "checked='checked'"; ?>>
                                <label class="form-check-label" for="check_opc20">
                                    Usos Especiales
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="10" id="check_opc21" name="grupo_tramite2" <?php if (in_array(10, $selectedIds)) echo "checked='checked'"; ?>>
                                <label class="form-check-label" for="check_opc21">
                                    En riberos y laderas
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="11" id="check_opc22" name="grupo_tramite2" <?php if (in_array(11, $selectedIds)) echo "checked='checked'"; ?>>
                                <label class="form-check-label" for="check_opc22">
                                    Reurbanizaci&oacute;n
                                </label>
                            </div>

                        </div>
                        
                    </div>
                    <div class="row" style="padding-left:0px;padding-top:20px">
                        <div class="col-lg-5">
                            <label class="control-label form-control-sm">&Aacute;rea Bruta del Terreno Declarado (m2)</label>
                        </div>
                        <div class="col-lg-3">
                            <input id="areaBruta" name="areaBruta" on class="form-control form-control-sm"  value="<?php echo $uso_edificion->area_techada?>" type="text" onChange=""
                            @if ($solicitud_->id_resultado == 4) readonly @endif>
                        </div>
                    </div>

                    <div class="row" style="padding-left:0px;padding-top:20px">
                        <div class="col-lg-3">
                            <label class="control-label form-control-sm">Formato de Registro</label>
                        </div>
                        <div class="col-lg-1-5">
                            <span class="btn btn-sm btn-warning btn-file" style="float:left">
                                Examinar <input id="image1" name="image1" type="file" />
                            </span>
                        </div>
                        <div class="col-lg-6">
                        <!--<i id="fileExcel" class="fa fa-file-excel" style="display:none;color:#00B300;font-size:35px;block;float:left;padding-left:10px"></i>
                        -->
                        <input type="button" class="btn btn-primary upload" id="1" value="Subir" style="margin-left:10px;float:left;">
                        <?php
						$img = "/img/logo-sin-fondo2.png";
						//if($inscripcionDocumento->ruta_archivo!="")$img="/".$inscripcionDocumento->ruta_archivo;
						?>
                        @if(count($selectedDocumentos_registro) > 0)
                            <img src="/img/derecho_revision/{{ $selectedDocumentos_registro[0] }}" id="img_ruta1" width="140px" height="50px" alt="" style="margin-left:10px" />
                            <input type="hidden" id="img_foto1" name="img_foto1" value="{{ $selectedDocumentos_registro[0] }}" style="padding-left:10px" />
                        @else
						<img src="<?php echo $img ?>" id="img_ruta1" width="140px" height="50px" alt="" style="margin-left:10px" />
                        <input type="hidden" id="img_foto1" name="img_foto1" value="" style="padding-left:10px" />
                        @endif
                        </div>
                    </div>

                    <div class="row" style="padding-left:0px;padding-top:20px">
                        <div class="col-lg-3">
                            <label class="control-label form-control-sm">Plano de Ubicaci&oacute;n</label>
                        </div>
                        <div class="col-lg-1-5">
                            <span class="btn btn-sm btn-warning btn-file" style="float:left">
                                Examinar <input id="image2" name="image2" type="file" />
                            </span>
                        </div>
                        <div class="col-lg-6">
                        <!--<i id="fileExcel" class="fa fa-file-excel" style="display:none;color:#00B300;font-size:35px;block;float:left;padding-left:10px"></i>
                        -->
                        <input type="button" class="btn btn-primary upload" id="2" value="Subir" style="margin-left:10px;float:left">
                        <?php 
						$img = "/img/logo-sin-fondo2.png";
						//if($inscripcionDocumento->ruta_archivo!="")$img="/".$inscripcionDocumento->ruta_archivo;
						?>
                         @if(count($selectedDocumentos_plano) > 0)
                            <img src="/img/derecho_revision/{{ $selectedDocumentos_plano[0] }}" id="img_ruta1" width="140px" height="50px" alt="" style="margin-left:10px" />
                            <input type="hidden" id="img_foto2" name="img_foto2" value="{{ $selectedDocumentos_plano[0] }}" style="padding-left:10px" />
                        @else
						<img src="<?php echo $img ?>" id="img_ruta2" width="140px" height="50px" alt="" style="margin-left:10px" />
                        <input type="hidden" id="img_foto2" name="img_foto2" value="" />
                        @endif
                        </div>
                    </div>

                    <div class="row" style="padding-left:0px;padding-top:20px">
                        <div class="col-lg-3">
                            <label class="control-label form-control-sm">FUHU</label>
                        </div>
                        <div class="col-lg-1-5">
                            <span class="btn btn-sm btn-warning btn-file" style="float:left">
                                Examinar <input id="image3" name="image3" type="file" />
                            </span>
                        </div>
                        <div class="col-lg-6">
                        <!--<i id="fileExcel" class="fa fa-file-excel" style="display:none;color:#00B300;font-size:35px;block;float:left;padding-left:10px"></i>
                        -->
                        <input type="button" class="btn btn-primary upload" id="3" value="Subir" style="margin-left:10px;float:left">
                        <?php 
						$img = "/img/logo-sin-fondo2.png";
						//if($inscripcionDocumento->ruta_archivo!="")$img="/".$inscripcionDocumento->ruta_archivo;
						?>
                        @if(count($selectedDocumentos_fuhu) > 0)
                            <img src="/img/derecho_revision/{{ $selectedDocumentos_fuhu[0] }}" id="img_ruta1" width="140px" height="50px" alt="" style="margin-left:10px" />
                            <input type="hidden" id="img_foto3" name="img_foto3" value="{{ $selectedDocumentos_fuhu[0] }}" style="padding-left:10px" />
                        @else
						<img src="<?php echo $img ?>" id="img_ruta3" width="140px" height="50px" alt="" style="margin-left:10px" />
								
                        <input type="hidden" id="img_foto3" name="img_foto3" value="" />
                        @endif
                        </div>
                    </div>

                    <div style="margin-top:10px" class="form-group">
                        <div class="col-sm-12 controls">
                            <div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions" style="float:right">
                                <a href="javascript:void(0)" onClick="fn_save_infoProyeto()" class="btn btn-sm btn-success">Guardar</a>
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

