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

    $('#valor_reintegro_').hide();
    
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
	 
	calculoVistaPrevia();
    activarEtapas();
	
});

function formatoMoneda(num) {
    return num.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
}

function calculoVistaPrevia(){
    var igv_valor_ = {{$parametro[0]->igv}} * 100;
    var valor_minimo_edificaciones = {{$parametro[0]->valor_minimo_edificaciones}};
    var uit_edificaciones = {{$parametro[0]->valor_uit}};
    var sub_total_minimo = valor_minimo_edificaciones * uit_edificaciones;
    var igv_valor = {{$parametro[0]->igv}};
    var igv_minimo	= igv_valor * sub_total_minimo;
    var total_minimo = sub_total_minimo + igv_minimo;
    $('#minimo').val(formatoMoneda(total_minimo));
    $('#igv').val(igv_valor_+"%");
    //var_dump($total_minimo);exit;
    
    var valor_obra_= {{$liquidacion[0]->valor_obra}};
    var porcentaje_calculo_edificacion = {{$parametro[0]->porcentaje_calculo_edificacion}};
    var sub_total= valor_obra_* porcentaje_calculo_edificacion;
    //var sub_total_formateado = number_format(sub_total, 2, '.', ',');
    var igv_total=sub_total*igv_valor;
    //var igv_total_formateado = number_format(igv_total, 2, '.', ',');
    //var_dump($total_minimo);exit;
    var total=sub_total+igv_total;
    //var total_formateado = number_format(total, 2, '.', ',');
    $('#sub_total').val(sub_total);
    $('#igv_').val(igv_total);
    $('#total').val(formatoMoneda(total));
    
    if(total<total_minimo){
        var total_ = total_minimo;
        var valor_minimo_edificaciones= {{$parametro[0]->valor_minimo_edificaciones}};
        var uit_minimo= {{$parametro[0]->valor_uit}};
        var sub_total_minimo=valor_minimo_edificaciones*uit_minimo;
        var igv_minimo=sub_total_minimo*igv_valor;
        //$sub_total_formateado_ = number_format($sub_total_minimo, 2, '.', ',');
        //$igv_total_formateado_ = number_format($igv_minimo, 2, '.', ',');
        //$total_formateado_ = number_format($total_minimo, 2, '.', ',');
        $('#sub_total').val(formatoMoneda(sub_total));
        $('#igv_').val(formatoMoneda(igv_total));
        $('#total').val(formatoMoneda(total));
        $('#sub_total2').val(formatoMoneda(sub_total_minimo));
        $('#igv2').val(formatoMoneda(igv_minimo));
        $('#total2').val(formatoMoneda(total_minimo));
    }else{
        $('#sub_total').val(formatoMoneda(sub_total));
        $('#igv_').val(formatoMoneda(igv_total));
        $('#total').val(formatoMoneda(total));
        $('#sub_total2').val(formatoMoneda(sub_total));
        $('#igv2').val(formatoMoneda(igv_total));
        $('#total2').val(formatoMoneda(total));
    }
    //var_dump($total_minimo);exit;
}

function activarEtapas(){
    if($('#etapas').val()==1){
        $('#n_etapas_').show();
    }else{
        $('#n_etapas_').hide();
    }
}

function habilitar_reintegro(){

    if($('#instancia').val()==250){
        $('#valor_reintegro_').show();
        /*$('#total2').val('0');
        $('#igv2').val('0');
        $('#sub_total2').val('0');*/
    }
}

function calcularReintegro(){

    if($('#instancia').val()==250){
        if($('#valor_reintegro').val()!=''){
            var reintegro=parseFloat($('#valor_reintegro').val());
            var igv_=parseFloat($('#igv').val());
            var valor_edificaciones=parseFloat($('#factor').val());

            var sub_totalR=reintegro*valor_edificaciones;
            var igv_totalR=sub_totalR*igv_/100;
            var totalR=sub_totalR+igv_totalR;
            
            if(totalR<parseFloat($('#minimo').val())){
                
                var total_minimo = parseFloat($('#minimo').val());
                var igv_minimo = total_minimo*igv_/100;
                var sub_total_minimo = total_minimo - igv_minimo;

                var sub_totalR=reintegro*valor_edificaciones;
                var igv_totalR=sub_totalR*igv_/100;
                var totalR=sub_totalR+igv_totalR;

                $('#total2').val(formatoMoneda(total_minimo));
                $('#igv2').val(formatoMoneda(igv_minimo));
                $('#sub_total2').val(formatoMoneda(sub_total_minimo));
                $('#total').val(formatoMoneda(totalR));
                $('#igv_').val(formatoMoneda(igv_totalR));
                $('#sub_total').val(formatoMoneda(sub_totalR));
            }else{

                //var sub_totalR_formateado = number_format(sub_totalR, 2, '.', ',');
                //var igv_totalR_formateado = number_format(igv_totalR, 2, '.', ',');
                //var totalR_formateado = number_format(totalR, 2, '.', ',');
                $('#total2').val(formatoMoneda(totalR));
                $('#igv2').val(formatoMoneda(igv_totalR));
                $('#sub_total2').val(formatoMoneda(sub_totalR));
                $('#total').val(formatoMoneda(totalR));
                $('#igv_').val(formatoMoneda(igv_totalR));
                $('#sub_total').val(formatoMoneda(sub_totalR));
            }
            
        }
    }
}

function cambioPlantaTipica(){

    if($('#tipo_liquidacion1').val()==136){
        var valor_planta_tipica=parseFloat($('#total2').val());
        var igv_PT=parseFloat($('#igv').val());
        
        var sub_totalPT=valor_planta_tipica/(1+(igv_PT/100));
        var igv_totalPT=sub_totalPT*igv_PT/100;

        if(valor_planta_tipica<parseFloat($('#minimo').val())){
            
            var total_minimoPT = parseFloat($('#minimo').val());
            var igv_minimoPT = total_minimoPT*igv_PT/100;
            var sub_total_minimoPT = total_minimoPT - igv_minimoPT;

            $('#total2').val(formatoMoneda(total_minimoPT));
            $('#igv2').val(formatoMoneda(igv_minimoPT));
            $('#sub_total2').val(formatoMoneda(sub_total_minimoPT));
            $('#total').val(formatoMoneda(valor_planta_tipica));
            $('#igv_').val(formatoMoneda(igv_totalPT));
            $('#sub_total').val(formatoMoneda(sub_totalPT));
        }else{
            $('#igv2').val(formatoMoneda(igv_totalPT));
            $('#sub_total2').val(formatoMoneda(sub_totalPT));
            $('#total').val(formatoMoneda(valor_planta_tipica));
            $('#igv_').val(formatoMoneda(igv_totalPT));
            $('#sub_total').val(formatoMoneda(sub_totalPT));
            $('#total2').val(formatoMoneda(valor_planta_tipica));
        }
    }
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

function valida(){
    
    var msg="";
    var situacion=$("#situacion").val();
    var id_solicitud=$("#id").val();
    
    if(situacion=="FALLECIDO"){
        msg+="El agremiado est&aacute; FALLECIDO";
    }

    if(situacion=="INHABILITADO"){
        msg+="El agremiado est&aacute; INHABILITADO";
    }
    
    if(msg!=""){
        bootbox.alert(msg); 

        $.ajax({
            url: "/derecho_revision/correo_credipago/" + id_solicitud,
            method: 'GET',
            success: function(result) {
               
            },
        });

        return false;
    }else if(situacion=="HABILITADO" || situacion==""){
        $.ajax({
            url: "/derecho_revision/valida_credipago_unico/" + id_solicitud,
            method: 'GET',
            success: function(result) {
                
                //alert(result[0].cantidad);
                if(result[0].cantidad>0){
                    bootbox.alert("Existe una liquidacion pendiente, no puede generar otra");
                }else{
                    fn_save_credipago();
                }
                
            },
        });
        
    } 
}

function fn_save_credipago(){
    
	var _token = $('#_token').val();
	var id = $('#id').val();
	var id_comision = $('#id_comision').val();
	var id_regional = $('#id_regional').val();
	var id_tipo_sesion = $('#id_tipo_sesion').val();
	var observaciones = $('#observacion').val();
	
	var msgLoader = "";
	msgLoader = "Procesando, espere un momento por favor";
	var heightBrowser = $(window).width()/2;
	$('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
    $('.loader').show();
	
    $.ajax({
			url: "/derecho_revision/send_credipago_liquidacion",
            type: "POST",
			data : $('#frmReintegroSolicitud').serialize(),
            success: function (result) {

				//alert(result[0].sw);
				//datatablenew();
				$('.loader').hide();
				
                if(result[0].sw==true){
                    $('#openOverlayOpc').modal('hide');
                    //window.location.reload();
                    datatablenew();
				}else{
					//var mensaje ="Existe más de un registro con el mismo DNI o RUC, debe de solicitar a sistemas que actualice la Base de Datos.";
					bootbox.alert({
						message: "Existe más de un registro de propietario con el mismo DNI o RUC, debe de solicitar a sistemas que actualice la Base de Datos.",
						//className: "alert_style"
                   
					});
                    $('#openOverlayOpc').modal('hide');
					//datatablenew();
				}
            }
    });
}


</script>


<body class="hold-transition skin-blue sidebar-mini">

  <div class="panel-heading close-heading">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
  </div>
  <div>
    <div class="justify-content-center">
      <div class="card">
        <div class="card-header" style="padding:5px!important;padding-left:20px!important; font-weight: bold">
          Solicitud de Derecho de Revisi&oacute;n - Edificaciones
        </div>
        <div class="card-body">
          
		  <form method="post" action="#" id="frmReintegroSolicitud" name="frmReintegroSolicitud" enctype="multipart/form-data">
		  
		  <div class="row">
            <!--aaaa-->
			
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:5px;padding-bottom:5px">

                <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="id" id="id" value="<?php echo $id ?>">
                <!--<input type="hidden" name="id_persona" id="id_persona">-->
                <div style="padding: 0px 0px 15px 10px; font-weight: bold">
                    Datos Generales de la Obra
                </div>
                <div class="row" style="padding-left:10px">
                    <div class="col-lg-12">
                        <label class="control-label form-control-sm">Nombre del Proyecto</label>
                        <input id="nombre_proyecto" name="nombre_proyecto" on class="form-control form-control-sm"  value="<?php echo $liquidacion[0]->nombre?>" type="text" readonly='readonly'>
                    </div>
                </div>

                <div class="row" style="padding-left:10px">
                    <div class="col-lg-12">
                        <label class="control-label form-control-sm">Propietario</label>
                        <input id="propietario" name="propietario" on class="form-control form-control-sm"  value="<?php echo $liquidacion[0]->propietario?>" type="text" readonly='readonly'>
                    </div>
                </div>

                <div class="row" style="padding-left:10px">
                    <div class="col-lg-3">
                        <label class="control-label form-control-sm">Valor Total Obra</label>
                        <?php
                        $valor_obra_=$liquidacion[0]->valor_obra;
                        $valor_obra_formateado = number_format($valor_obra_, 2, '.', ',');
                        ?>
                        <input id="valor_total_obra" name="valor_total_obra" on class="form-control form-control-sm"  value="<?php echo $valor_obra_formateado?>" type="text" readonly='readonly'>
                    </div>
                    <!--<div class="col-lg-3">
                        <label class="control-label form-control-sm">&Aacute;rea del Terreno</label>
                        <input id="area_terreno" name="area_terreno" on class="form-control form-control-sm"  value="<?php //echo $liquidacion[0]->area_total?>" type="text" readonly='readonly'>
                    </div>-->
                    <div class="col-lg-3">
                        <label class="control-label form-control-sm">&Aacute;rea Techada (m2)</label>
                        <input id="area_techada" name="area_techada" on class="form-control form-control-sm"  value="<?php echo number_format($liquidacion[0]->area_total, 2, '.', ',');?>" type="text" readonly='readonly'>
                    </div>
                </div>
                <div style="padding: 15px 0px 15px 10px; font-weight: bold">
                    Ubicaci&oacute;n
                </div>
                <div class="row" style="padding-left:10px">
                    <div class="col-lg-3">
                        <label class="control-label form-control-sm">Departamento</label>
                        <input id="departamento" name="departamento" on class="form-control form-control-sm"  value="<?php echo $departamento?>" type="text" readonly='readonly'>
                    </div>
                    <div class="col-lg-3">
                        <label class="control-label form-control-sm">Provincia</label>
                        <input id="provincia" name="provincia" on class="form-control form-control-sm"  value="<?php echo $provincia?>" type="text" readonly='readonly'>
                    </div>
                    <div class="col-lg-3">
                        <label class="control-label form-control-sm">Distrito</label>
                        <input id="distrito" name="distrito" on class="form-control form-control-sm"  value="<?php echo $distrito?>" type="text" readonly='readonly'>
                    </div>
                </div>
                <div class="row" style="padding-left:10px">
                    <div class="col-lg-2">
                        <label class="control-label form-control-sm">Tipo</label>
                        <input id="tipo" name="tipo" on class="form-control form-control-sm"  value="<?php echo $liquidacion[0]->tipo?>" type="text" readonly='readonly'>
                    </div>
                    <div class="col-lg-10">
                        <label class="control-label form-control-sm">Direcci&oacute;n</label>
                        <input id="direccion_proyecto" name="direccion_proyecto" on class="form-control form-control-sm"  value="<?php echo $liquidacion[0]->direccion_proyecto?>" type="text" readonly='readonly'>
                    </div>
                </div>
                <div style="padding: 15px 0px 15px 10px; font-weight: bold">
                    Datos del Arquitecto Principal
                </div>
                <div class="row" style="padding-left:10px">
                    <div class="col-lg-3">
                        <label class="control-label form-control-sm">N&uacute;mero <?php echo $proyectista_[0]->tipo_colegiatura?></label>
                        <input id="numero_cap" name="numero_cap" on class="form-control form-control-sm"  value="<?php echo $proyectista_[0]->numero_cap?>" type="text" readonly='readonly'>
                    </div>
                    <div class="col-lg-3">
                        <label class="control-label form-control-sm">Nombres</label>
                        <input id="agremiado" name="agremiado" on class="form-control form-control-sm"  value="<?php echo $proyectista_[0]->nombres?>" type="text" readonly='readonly'>
                    </div>
                    <div class="col-lg-3">
                        <label class="control-label form-control-sm">Ubicaci&oacute;n</label>
                        <input id="ubicacion" name="ubicacion" on class="form-control form-control-sm"  value="<?php echo $proyectista_[0]->ubicacion?>" type="text" readonly='readonly'>
                    </div>
                    <div class="col-lg-3">
                        <label class="control-label form-control-sm">N° Regional</label>
                        <input id="n_regional" name="n_regional" on class="form-control form-control-sm"  value="<?php echo $proyectista_[0]->numero_regional?>" type="text" readonly='readonly'>
                    </div>
                </div>
                <div class="row" style="padding-left:10px">
                    <div class="col-lg-3">
                        <label class="control-label form-control-sm">Direcci&oacute;n</label>
                        <input id="direccion_agremiado" name="direccion_agremiado" on class="form-control form-control-sm"  value="<?php echo $proyectista_[0]->direccion?>" type="text" readonly='readonly'>
                    </div>
                    <div class="col-lg-3">
                        <label class="control-label form-control-sm">Zonal</label>
                        <input id="zonal" name="zonal" on class="form-control form-control-sm"  value="<?php echo $proyectista_[0]->local?>" type="text" readonly='readonly'>
                    </div>
                    <div class="col-lg-3">
                        <label class="control-label form-control-sm">Regional</label>
                        <input id="regional" name="regional" on class="form-control form-control-sm"  value="<?php echo $proyectista_[0]->regional?>" type="text" readonly='readonly'>
                    </div>
                </div>
                <div class="row" style="padding-left:10px">
                    <div class="col-lg-3">
                        <label class="control-label form-control-sm">Autoriza</label>
                        <input id="autoriza" name="autoriza" on class="form-control form-control-sm"  value="<?php echo $proyectista_[0]->autoriza?>" type="text" readonly='readonly'>
                    </div>
                    <div class="col-lg-3">
                        <label class="control-label form-control-sm">Actividad Gremial</label>
                        <input id="act_gremial" name="act_gremial" on class="form-control form-control-sm"  value="<?php echo $proyectista_[0]->actividad?>" type="text" readonly='readonly'>
                    </div>
                    <div class="col-lg-3">
                        <label class="control-label form-control-sm">Situaci&oacute;n</label>
                        <input id="situacion" name="situacion" on class="form-control form-control-sm"  value="<?php echo $proyectista_[0]->situacion?>" type="text" readonly='readonly'>
                    </div>
                </div>
                <?php if(count($proyectista_solicitud)>1){?>
						<div style="padding: 10px 0px 15px 10px; font-weight: bold">
							Proyectista Asociados
						</div>
						
						<?php } ?>
						
						<?php 
							foreach($proyectista_solicitud as $row){
							if($row->numero_cap!=$datos_proyectista[0]->numero_cap){
						?>
							
						<div class="row" style="padding-left:10px">
							<div class="col-lg-1" hidden>
								<label class="control-label form-control-sm">Tipo Proyectista</label>
								<select name="tipo_proyectista_row[]" id="tipo_proyectista_row" class="form-control form-control-sm" onChange="">
									<option value="0">--Selecionar--</option>
									<?php
									foreach ($tipo_proyectista as $row_) {?>
									<option value="<?php echo $row_->codigo?>" <?php if($row_->codigo==$row->id_tipo_profesional)echo "selected='selected'"?>><?php echo $row_->denominacion?></option>
									<?php
									}
									?>
								</select>
							</div>
							<div class="col-lg-3">
								<div class="form-group" id="numero_cap_">
									<label class="control-label form-control-sm">N° <?php echo $row->tipo_colegiatura?></label>
									<input id="numero_cap_row" name="numero_cap_row[]" on class="form-control form-control-sm"  value="<?php echo $row->numero_cap?>" type="text" onChange="obtenerProyectista()"readonly='readonly'>
									<input id="tipo_colegiatura_row" name="tipo_colegiatura_row[]" value="<?php echo $row->tipo_colegiatura?>" type="hidden">
								</div>
							</div>
                            <div class="col-lg-3" >
								<div class="form-group "id="agremiado_">
									<label class="control-label form-control-sm">Nombre</label>
									<input id="agremiado_row" name="agremiado_row" on class="form-control form-control-sm"  value="<?php echo $row->agremiado?>" type="text" readonly='readonly'>
								</div>
							</div>
							<div class="col-lg-3">
								<div class="form-group" id="situacion_">
									<label class="control-label form-control-sm">Situaci&oacute;n</label>
									<input id="situacion_row" name="situacion_row" on class="form-control form-control-sm"  value="<?php echo $row->situacion?>" type="text" readonly='readonly'>
								</div>
							</div>

							<div class="col-lg-3">
								<div class="form-group" id="direccion_agremiado_">
									<label class="control-label form-control-sm">T&eacute;lefono</label>
									<input id="direccion_agremiado_row" name="direccion_agremiado_row" on class="form-control form-control-sm"  value="<?php echo $row->celular1?>" type="text" readonly='readonly'>
								</div>
							</div>

							<div class="col-lg-3">
								<div class="form-group" id="n_regional_">
									<label class="control-label form-control-sm">Email</label>
									<input id="n_regional_row" name="n_regional_row" on class="form-control form-control-sm"  value="<?php echo $row->email1?>" type="text" readonly='readonly'>
								</div>
							</div>
							<div class="col-lg-3">
								<div class="form-group" id="act_gremial_">
									<label class="control-label form-control-sm">Actividad Gremial</label>
									<input id="act_gremial_row" name="act_gremial_row" on class="form-control form-control-sm"  value="<?php echo $row->actividad?>" type="text" readonly='readonly'>
								</div>
							</div>
							<div class="col-lg-1" hidden>
								<label class="control-label form-control-sm">Principal_asociado</label>
								<select name="principal_asociado_row" id="principal_asociado_row" class="form-control form-control-sm" onChange="">
									<option value="0">--Selecionar--</option>
									<?php
									foreach ($principal_asociado as $row_) {?>
									<option value="<?php echo $row_->codigo?>" <?php if($row_->codigo==$row->id_tipo_proyectista)echo "selected='selected'"?>><?php echo $row_->denominacion?></option>
									<?php
									}
									?>
								</select>
							</div>
						</div>
						
						
						<?php 
								}
							} 
						?>
                    </div>
                </div>
                <div style="padding: 0px 0px 15px 10px; font-weight: bold">
							Datos del Proyecto
						</div>

						<div class="col-lg-4" style=";padding-right:15px">
							<label class="control-label form-control-sm">Datos T&eacute;cnicos del proyecto</label>
							<select name="tipo_proyecto" id="tipo_proyecto" class="form-control form-control-sm" onChange="" disabled>
								<option value="">--Selecionar--</option>
								<?php
								foreach ($tipo_proyecto as $row) {?>
								<option value="<?php echo $row->codigo?>" <?php if($row->codigo==$derechoRevision_->id_tipo_tramite)echo "selected='selected'"?>><?php echo $row->denominacion?></option>
								<?php
							    }
								?>
							</select>
						</div>
						<div style="padding: 10px 0px 15px 10px; font-weight: bold">
							Uso de la Edificaci&oacute;n
						</div>
						
						<div class="row">
							<div class="col-lg-10" style=";padding-right:15px">
								<div class="row" style="padding-left:10px">
									<div class="col-lg-12" id="uso-container">
									
						<?php 
							foreach($datos_usoEdificaciones as $key=>$row){
							$sub_tipo_uso = App\Models\TablaMaestra::getMaestroByTipoAndSubTipo(111,$row->id_tipo_uso);
						?>
										<div class="row uso-row">
											<div class="col-lg-5" style=";padding-right:15px">
											<label class="control-label form-control-sm">Tipo de Uso</label>
											<select name="tipo_uso[]" id="tipo_uso" class="form-control form-control-sm" onChange="obtenerSubTipoUso(this)" disabled>
												<option value="">--Seleccionar--</option>
												<?php
												foreach ($tipo_uso as $row_) {?>
												<option value="<?php echo $row_->codigo?>" <?php if($row_->codigo==$row->id_tipo_uso)echo "selected='selected'"?>><?php echo $row_->denominacion?></option>
												<?php
												}
												?>
											</select>
										</div>
										<div class="col-lg-5" style=";padding-right:15px">
											<label class="control-label form-control-sm">Sub-Tipo de Uso</label>
											<select name="sub_tipo_uso[]" id="sub_tipo_uso" class="form-control form-control-sm" onChange="" disabled>
												<option value="">--Seleccionar--</option>
												<?php
												foreach ($sub_tipo_uso as $row_) {?>
												<option value="<?php echo $row_->codigo?>" <?php if($row_->codigo==$row->id_sub_tipo_uso)echo "selected='selected'"?>><?php echo $row_->denominacion?></option>
												<?php
												}
												?>
											</select>
										</div>
										<div class="col-lg-2">
											<label class="control-label form-control-sm">&Aacute;rea Techada</label>
											<input id="area_techada" name="area_techada[]" on class="form-control form-control-sm"  value="<?php echo number_format($row->area_techada, 2, '.', ',');?>" type="text" onChange="" readonly>
										</div>
									</div>
                                    
						<?php 
								//}
							} 
						?>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-10 d-flex justify-content-end">
                            <div class="row" style="width: 100%; justify-content: flex-end;">
                                    <div class="col-lg-2">
                                        <label class="control-label form-control-sm">&Aacute;rea Techada Total</label>
                                        <input id="area_techada_total" name="area_techada_total" on class="form-control form-control-sm"  value="<?php echo number_format($derechoRevision_->area_total, 2, '.', ',');?>" type="text" readonly='readonly'>
                                    </div>
                                </div>
                            </div>
                        </div>

						<div style="padding: 10px 0px 15px 10px; font-weight: bold">
							Presupuesto
						</div>
						<div class="row">
							<div class="col-lg-9" style=";padding-right:15px">
								
								<div class="row" style="padding-left:10px">
									<div class="col-lg-12" id="presupuesto-container">
									
                                    <?php 
                                        foreach($datos_presupuesto as $key=>$row){	
                                    ?>
								
                                        <div class="row presupuesto-row">
                                            <div class="col-lg-6" style=";padding-right:15px">
                                                <label class="control-label form-control-sm">Tipo de Obra</label>
                                                <select name="tipo_obra[]" id="tipo_obra" class="form-control form-control-sm" onChange="" disabled>
                                                    <option value="">--Selecionar--</option>
                                                    <?php
                                                    foreach ($tipo_obra as $row_) {?>
                                                    <option value="<?php echo $row_->codigo?>" <?php if($row_->codigo==$row->id_tipo_obra)echo "selected='selected'"?>><?php echo $row_->denominacion?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-lg-2">
                                                <label class="control-label form-control-sm">&Aacute;rea Techada m2</label>
                                                <input id="area_techada_presupuesto" name="area_techada_presupuesto[]" on class="form-control form-control-sm"  value="<?php echo number_format($row->area_techada, 2, '.', ',');?>" type="text" readonly>
                                            </div>
                                            <div class="col-lg-2">
                                                <label class="control-label form-control-sm">Valor Unitario S/</label>
                                                <input id="valor_unitario" name="valor_unitario[]" on class="form-control form-control-sm"  value="<?php echo number_format($row->valor_unitario, 2, '.', ',');?>" type="text" readonly>
                                            </div>
                                            <div class="col-lg-2">
                                                <label class="control-label form-control-sm">Presupuesto</label>
                                                <input id="presupuesto" name="presupuesto[]" on class="form-control form-control-sm"  value="<?php echo number_format($row->total_presupuesto, 2, '.', ',');?>" type="text" readonly='readonly'>
                                            </div>
                                        </div>
                                    <?php 
                                        } 
                                    ?>		
									</div>
								</div>
                            </div>
                            <div class="col-lg-1-5" style="border-left:2px solid #ccc;">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <label class="control-label form-control-sm">Azotea</label>
                                        <input id="azotea" name="azotea" on class="form-control form-control-sm"  value="<?php echo $derechoRevision_->azotea?>" type="text" readonly>
                                    </div>
                                </div>
								<div class="row">
									<div class="col-lg-12">
                                        <label class="control-label form-control-sm">N° de Pisos</label>
                                        <input id="n_pisos" name="n_pisos" on class="form-control form-control-sm"  value="<?php echo $derechoRevision_->numero_piso?>" type="text" readonly>
                                    </div>
                                </div>
                            </div>
							<div class="col-lg-1-5">
								<div class="row">
									<div class="col-lg-12">
                                        <label class="control-label form-control-sm">N° S&oacute;tanos</label>
                                        <input id="n_sotanos" name="n_sotanos" on class="form-control form-control-sm"  value="<?php echo $derechoRevision_->numero_sotano?>" type="text" readonly>
                                    </div>
                                </div>
								<div class="row">
									<div class="col-lg-12">
                                        <label class="control-label form-control-sm">Semis&oacute;tano</label>
                                        <input id="semisotano" name="semisotano" on class="form-control form-control-sm"  value="<?php echo $derechoRevision_->semisotano?>" type="text" readonly>
                                    </div>
                                </div>
								<div class="row">
									<div class="col-lg-12" hidden>
                                        <label class="control-label form-control-sm">Fecha Registro</label>
                                        <input id="fecha_registro" name="fecha_registro" on class="form-control form-control-sm"  value="<?php echo date('Y-m-d', strtotime($derechoRevision_->fecha_registro)); ?>" type="text" readonly='readonly'>
                                    </div>
                                </div>
                            </div>
                        </div>
                <div style="padding: 15px 0px 15px 10px; font-weight: bold">
                    C&aacute;lculo Liquidaci&oacute;n
                </div>
                <div class="row" style="padding-left:10px">
                    <div class="col-lg-5">
                        <div class="form-group">
                            <label class="control-label form-control-sm">Tipo Liquidaci&oacute;n 1</label>
                            <select name="tipo_liquidacion1" id="tipo_liquidacion1" class="form-control form-control-sm">
                                <option value="">--Selecionar--</option>
                                <?php
                                foreach ($tipo_liquidacion as $row) {
                                    if (in_array($row->codigo, [135,142,136,138,306,137,143,258])){
                                ?>
                                <option value="<?php echo $row->codigo?>" <?php if($row->codigo=='135')echo "selected='selected'"?>><?php echo $row->denominacion?></option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="form-group">
                            <label class="control-label form-control-sm">Instancia</label>
                            <select name="instancia" id="instancia" class="form-control form-control-sm" onChange="habilitar_reintegro()">
                                <option value="">--Selecionar--</option>
                                <?php
                                foreach ($instancia as $row) {?>
                                <option value="<?php echo $row->codigo?>" <?php if($row->codigo=='246')echo "selected='selected'"?>><?php echo $row->denominacion?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row" style="padding-left:10px">
                    <div class="col-lg-5">
                        <div class="form-group">
                            <label class="control-label form-control-sm">Tipo Liquidaci&oacute;n 2</label>
                            <select name="tipo_liquidacion2" id="tipo_liquidacion2" class="form-control form-control-sm">
                                <option value="">--Selecionar--</option>
                                <?php
                                foreach ($tipo_liquidacion as $row) {
                                    if (in_array($row->codigo, [143,258])){
                                ?>
                                <option value="<?php echo $row->codigo?>" <?php if($row->codigo=='258')echo "selected='selected'"?>><?php echo $row->denominacion?></option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <label class="control-label form-control-sm">Municipalidad</label>
                        <input id="municipalidad" name="municipalidad" on class="form-control form-control-sm"  value="<?php echo $liquidacion[0]->municipalidad;?>" type="text" readonly='readonly'>
                    </div>
                </div>
                <div class="row" style="padding-left:10px">
                    <div class="col-lg-3">
                        <label class="control-label form-control-sm">N&uacute;mero Revisi&oacute;n</label>
                        <input id="numero_revision" name="numero_revision" on class="form-control form-control-sm"  value="<?php echo $liquidacion[0]->numero_revision?>" type="text">
                    </div>
                    <div class="col-lg-3">
                        <div id="valor_reintegro_" name="valor_reintegro_">
                            <label class="control-label form-control-sm">Valor Reintegro S/.</label>
                            <input id="valor_reintegro" name="valor_reintegro" on class="form-control form-control-sm"  value="<?php //echo $liquidacion[0]->situacion?>" type="text" onChange="calcularReintegro()">
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <label class="control-label form-control-sm">Por Etapas</label>
                        <select name="etapas" id="etapas" class="form-control form-control-sm" onChange="activarEtapas()">
                            <?php
                            $valorSeleccionado = isset($liquidacion[0]->etapa) ? $liquidacion[0]->etapa : '0';
                            ?>
                            <option value="" <?php echo ($valorSeleccionado == '') ? 'selected="selected"' : '';?>>--Selecionar--</option>
                            <option value="1" <?php echo ($valorSeleccionado == '1') ? 'selected="selected"' : '';?>>SI</option>
                            <option value="0" <?php echo ($valorSeleccionado == '0') ? 'selected="selected"' : '';?>>NO</option>
                        </select>
                    </div>
                    <div class="col-lg-2">
                        <div id="n_etapas_" name="n_etapas_">
                            <label class="control-label form-control-sm">N&uacute;mero de Etapas</label>
                            <select name="n_etapas" id="n_etapas" class="form-control form-control-sm">
                                <?php
                                $valorSeleccionado = isset($liquidacion[0]->numero_etapa) ? $liquidacion[0]->numero_etapa : '';
                                ?>
                                <option value="">--Selecionar--</option>
                                    <?php
                                    for ($i=1; $i<=10;$i++) {
                                    ?>
                                    <option value="<?php echo $i;?>" <?php echo ($valorSeleccionado == $i) ? 'selected="selected"' : '';?>><?php echo $i?></option>
                                    <?php
                                    }
                                    ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row" style="padding-left:10px;padding-top:15px">
                    <div class="col-lg-6" style="padding:10px; border:1px solid #ccc;">
                        <div class="row" style="padding-left:10px;">
                            <div class="col-lg-6">
                                <label class="control-label form-control-sm">Factor</label>
                                <input id="factor" name="factor" on class="form-control form-control-sm"  value="<?php echo $parametro[0]->porcentaje_calculo_edificacion?>" type="text" readonly='readonly'>
                            </div>
                            <div class="col-lg-6">
                                <label class="control-label form-control-sm">M&iacute;mino</label>
                                
                                <input id="minimo" name="minimo" on class="form-control form-control-sm"  value="<?php //echo $total_minimo?>" type="text" readonly='readonly'>
                            </div>
                        </div>
                        <div class="row" style="padding-left:10px;">
                            <div class="col-lg-6">
                                <label class="control-label form-control-sm">% IGV</label>
                                
                                <input id="igv" name="igv" on class="form-control form-control-sm"  value="<?php //echo $igv_valor . '%'?>" type="text" readonly='readonly'>
                            </div>
                            <div class="col-lg-6">
                                <label class="control-label form-control-sm">M&aacute;ximo</label>
                                <input id="maximo" name="maximo" on class="form-control form-control-sm"  value="<?php //echo $liquidacion[0]->situacion?>" type="text" readonly='readonly'>
                            </div>
                        </div>
                        <div class="row" style="padding-left:10px;">
                            <div class="col-lg-12">
                                <label class="control-label form-control-sm">Observaci&oacute;n</label>
                                <input id="observacion" name="observacion" on class="form-control form-control-sm"  value="<?php //echo $liquidacion[0]->situacion?>" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6" style="padding:10px; border:1px solid #ccc;">
                        <div class="row" style="padding-left:10px;">
                            <div class="col-lg-6">
                                <label class="control-label form-control-sm">Sub Total</label>
                                
                                <input id="sub_total" name="sub_total" on class="form-control form-control-sm"  value="<?php //echo $sub_total_formateado?>" type="text" readonly='readonly'>
                            </div>
                            <div class="col-lg-6">
                                <label class="control-label form-control-sm">Sub Total</label>
                                <input id="sub_total2" name="sub_total2" on class="form-control form-control-sm"  value="<?php //echo $sub_total_formateado_?>" type="text" readonly='readonly'>
                            </div>
                        </div>
                        <div class="row" style="padding-left:10px;">
                            <div class="col-lg-6">
                                <label class="control-label form-control-sm">IGV</label>
                                <?php
                                
                                
                                ?>
                                <input id="igv_" name="igv_" on class="form-control form-control-sm"  value="<?php //echo $igv_total_formateado?>" type="text" readonly='readonly'>
                            </div>
                            <div class="col-lg-6">
                                <label class="control-label form-control-sm">IGV</label>
                                <input id="igv2" name="igv2" on class="form-control form-control-sm"  value="<?php //echo $igv_total_formateado_?>" type="text" readonly='readonly'>
                            </div>
                        </div>
                        <div class="row" style="padding-left:10px;">
                            <div class="col-lg-6">
                                <label class="control-label form-control-sm">Total</label>
                                <?php
                                
                                ?>
                                <input id="total" name="total" on class="form-control form-control-sm"  value="<?php //echo $total_formateado?>" type="text" readonly='readonly'>
                            </div>
                            <div class="col-lg-6">
                                <label class="control-label form-control-sm">Total a Pagar Soles</label>
                                <input id="total2" name="total2" on class="form-control form-control-sm"  value="<?php //echo $total_formateado_?>" type="text" onChange="cambioPlantaTipica()">
                            </div>
                        </div>
						
						<div style="margin-top:15px" class="form-group">
							<div class="col-sm-12 controls">
								<div class="btn-group btn-group-sm float-right" role="group" aria-label="Log Viewer Actions">
									
									<a href="javascript:void(0)" onClick="valida()" class="btn btn-sm btn-success">Generar Credipago</a>
									
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

