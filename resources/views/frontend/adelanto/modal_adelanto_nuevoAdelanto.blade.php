<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<title>Sistema SIGCAP</title>

<style>
  .datepicker,
  .table-condensed {
    width: 250px;
    height: 250px;
  }


  .modal-dialog {
    width: 100%;
    max-width: 40% !important
  }

  #tablemodal {
    border-spacing: 0;
    display: flex;
    /*Se ajuste dinamicamente al tamano del dispositivo**/
    max-height: 80vh;
    /*El alto que necesitemos**/
    overflow-y: auto;
    /**El scroll verticalmente cuando sea necesario*/
    overflow-x: hidden;
    /*Sin scroll horizontal*/
    table-layout: fixed;
    /**Forzamos a que las filas tenga el mismo ancho**/
    width: 98vw;
    /*El ancho que necesitemos*/
    border: 1px solid #c4c0c9;
  }

  #tablemodal thead {
    background-color: #e2e3e5;
    position: fixed !important;
  }


  #tablemodal th {
    border-bottom: 1px solid #c4c0c9;
    border-right: 1px solid #c4c0c9;
  }

  #tablemodal th {
    font-weight: normal;
    margin: 0;
    max-width: 9.5vw;
    min-width: 9.5vw;
    word-wrap: break-word;
    font-size: 10px;
    font-weight: bold;
    height: 3.5vh !important;
    line-height: 12px;
    vertical-align: middle;
    /*height:20px;*/
    padding: 4px;
    border-right: 1px solid #c4c0c9;
  }

  #tablemodal td {
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

  #tablemodal tbody tr:hover td,
  #tablemodal tbody tr:hover th {
    font-weight: bold;
  }

  #tablemodalm {}

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

  input:checked+.slider {
    background-color: #4cae4c;
  }

  input:focus+.slider {
    box-shadow: 0 0 1px #4cae4c;
  }

  input:checked+.slider:before {
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

  .img_ruta {
    position: relative;
    float: left
  }

  .delete_ruta {
    background-image: url(img/delete.png);
    top: 0px;
    left: 110px;
    background-size: 100%;
    position: absolute;
    display: block;
    width: 30px;
    height: 30px;
    cursor: pointer
  }

  .no {
    padding-right: 3px;
    padding-left: 0px;
    display: block;
    width: 100px;
    float: left;
    font-size: 14px;
    text-align: right;
    padding-top: 5px
  }

  .si {
    padding-right: 0px;
    padding-left: 3px;
    display: block;
    width: 100px;
    float: left;
    font-size: 14px;
    text-align: left;
    padding-top: 5px
  }
</style>

<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" />


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js"></script>
<script type="text/javascript">


$(document).ready(function() {

  obtener_datos_adelanto();
  obtenerDelegado()

});

$("#profesion").select2();

$("#delegado").select2({ width: '100%' });


function obtener_profesional(){
	
  var numero_cap = $('#numero_cap').val();
  //console.log(numero_documento);
  $.ajax({
      url: '/adelanto/buscar_numero_cap/'+numero_cap,
      dataType: "json",
      success: function(result){

        if(result.sw==false){

          Swal.fire({
            title: 'El numero cap no existe',
            text: "¿Desea registrar como  nueva persona?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, Crear!'
          }).then((result) => {
            if (result.value) {
            modal_personaNuevo();
            //document.location="eliminar.php?codigo="+id;
            
            }
          });//$('#openOverlayOpc').modal('hide');
            
          /*
					bootbox.alert(result.msg);
					$('#openOverlayOpc').modal('hide');*/
				}else{
					$("#id_agremiado").val(result.persona.id);
          //$("#ruc").val(result.persona.numero_ruc);
          $("#nombres").val(result.persona.nombres);
          $("#apellido_paterno").val(result.persona.apellido_paterno);
          $("#apellido_materno").val(result.persona.apellido_materno);
          $("#fecha_nacimiento").val(result.persona.fecha_nacimiento);
				}
		}
    });
	/*var ruc = $("#numero_documento option:selected").attr("numero_ruc");
	var nombre = $("#numero_documento option:selected").attr("nombre");
  var apellido_paterno = $("#numero_documento option:selected").attr("apellido_paterno");
  var apellido_materno = $("#numero_documento option:selected").attr("apellido_materno");
  var fecha_nacimiento = $("#numero_documento option:selected").attr("fecha_nacimiento");
*/
	/*print_r(datos).exit();
	$("#moneda").val(moneda);
	$("#monto").val(monto);*/
	
}

function obtener_datos_adelanto(){
  if($("#delegado").val()!='' && $("#id_delegado_").val()!=''){

    if($('input[name="id_delegado_"]').length && $('input[name="id_delegado_"]').val() !=''){
      var id_agremiado = $("#id_delegado_").val();
    }else{
      var id_agremiado = $("#delegado").val();
    }

    /*if($("#delegado").val()!=''){
      var id_agremiado = $("#delegado").val();
    }else{
      var id_agremiado = $("#id_delegado_").val();
    }*/
    
    var msgLoader = "";
    msgLoader = "Procesando, espere un momento por favor";
    var heightBrowser = $(window).width()/2;
    $('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
      $('.loader').show();
  
    $.ajax({
      url: '/adelanto/obtener_datos_adelanto/' + id_agremiado,
      dataType: "json",
      success: function(result){
        
  
        var datos_adelanto = result[0];
       
        //console.log(datos_adelanto)
        $("#municipalidad").val(datos_adelanto.comision);
        $("#puesto").val(datos_adelanto.puesto);
  
        $('.loader').hide();
      }
    });
  }
  
}

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
        
        option += "<option value='" + oo.id_agremiado + "'>" + oo.numero_cap + " - " + oo.apellido_paterno + " " + oo.apellido_materno + " " + oo.nombres +  "</option>";
      });
      $('#delegado').html(option);

      $('.loader').hide();
    }
  });
}

function modal_personaNuevo(){
	$(".modal-dialog").css("width","85%");
	$('#openOverlayOpc').modal('show');
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
			url: "/persona/modal_personaNuevo",
			type: "get",
			data : $("#frmValorizacion").serialize(),
			success: function (result) {  
					$("#diveditpregOpc").html(result);
					//$('#openOverlayOpc').modal('show');
					
			}
	});

	//cargarConceptos();

}

  function fn_save_adelanto() {

    var _token = $('#_token').val();
    var id_persona = $('#id_persona').val();
    var id = $('#id').val();
    var tipo_documento = $('#tipo_documento').val();
    var numero_cap = $('#numero_cap').val();
    var nombres = $('#nombres').val();
    var apellido_paterno = $('#apellido_paterno').val();
    var apellido_materno = $('#apellido_materno').val();
    var monto = $('#monto').val();
    var numero_cuota = $('#numero_cuota').val();
	  var id_tiene_recibo = $('#id_tiene_recibo').val();
    var id_periodo = $('#id_periodo').val();
    var delegado = $('#delegado').val();
    var id_delegado_ = $('#id_delegado_').val();
    
	
    $.ajax({
      url: "/adelanto/send_adelanto_nuevoAdelanto",
      type: "POST",
      data: {
        _token:_token,
        id:id,
        id_persona:id_persona,
        tipo_documento:tipo_documento,
        numero_cap:numero_cap,
        nombres:nombres,
        apellido_paterno:apellido_paterno,
        apellido_materno:apellido_materno,
        monto:monto,
        id_periodo:id_periodo,
        delegado:delegado,
        numero_cuota:numero_cuota,
        id_tiene_recibo:id_tiene_recibo,
        id_delegado_:id_delegado_
      },
      success: function(result) {

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
    <div class="justify-content-center">
      <div class="card">
        <div class="card-header" style="padding:5px!important;padding-left:20px!important; font-weight: bold">
          Registro Adelantos
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:5px;padding-bottom:20px">

              <form method="post" action="#" enctype="multipart/form-data">
                <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="id" id="id" value="<?php echo $id ?>">
                
              <div class="row" style="padding-left:10px">

                <div class="col-lg-4">
                  <div class="form-group">
                    <label class="control-label form-control-sm">Periodo</label>
                    <select name="id_periodo" id="id_periodo" class="form-control form-control-sm" onChange="obtenerDelegado()" <?php if($id>0){?>disabled <?php }?> ?>>
                      <!--<option value="">--Seleccionar--</option>-->
                      <?php
                      foreach ($periodo as $row) {?>
                      <option value="<?php echo $row->id?>" <?php if($row->id==$adelanto->id_periodo_comision)echo "selected='selected'"?>><?php echo $row->descripcion?></option>
                      <?php 
                      }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="col-lg-9">
                  <div class="form-group">
                    <label class="control-label form-control-sm">Delegado</label>
                    <?php if($id>0){?>
                    <input id="delegado_" name="delegado_" class="form-control form-control-sm"  value="<?php echo $persona->apellido_paterno ." ". $persona->apellido_materno ." ". $persona->nombres ?>" type="text" readonly="readonly">										
                    <input type="hidden" name="id_delegado_" id="id_delegado_" value="<?php echo $adelanto->id_agremiado?>">
                    <?php }else{?>
                    <select name="delegado" id="delegado" class="form-control form-control-sm" onchange="obtener_datos_adelanto()">
                      <option value="">--Selecionar--</option>
                      
                    </select>
                    <?php }?>
                  </div>
                </div>
                <div class="col-lg-4">
                  <div class="form-group">
                    <label class="control-label form-control-sm">Municipalidad</label>
                    <input id="municipalidad" name="municipalidad" class="form-control form-control-sm" value="<?php //echo $adelanto->total_adelanto ?>" type="text" disabled='disabled'>
                  </div>
                </div>
                <div class="col-lg-4">
                  <div class="form-group">
                    <label class="control-label form-control-sm">Puesto</label>
                    <input id="puesto" name="puesto" class="form-control form-control-sm" value="<?php //echo $adelanto->total_adelanto ?>" type="text" disabled='disabled'>
                  </div>
                </div>
                <div class="col-lg-3">
                  <div class="form-group">
                    <label class="control-label form-control-sm">Tiene Recibo</label>
                    <select name="id_tiene_recibo" id="id_tiene_recibo" class="form-control form-control-sm">
                      <option value="">--Selecionar--</option>
                      <?php
                      foreach ($tiene_recibo as $row) {?>
                      <option value="<?php echo $row->codigo?>" <?php if($row->codigo==$adelanto->id_tiene_recibo)echo "selected='selected'"?>><?php echo $row->denominacion?></option>
                      <?php 
                      }
                      ?>
                    </select>
                    
                  </div>
                </div>
              </div>
              <div class="row" style="padding-left:10px">
                    
                <div class="col-lg-4">
                  <div class="form-group">
                    <label class="control-label form-control-sm">Monto</label>
                    <input id="monto" name="monto" class="form-control form-control-sm" value="<?php echo $adelanto->total_adelanto ?>" type="text" <?php $fecha_actual = date('Y-m-d'); if($fecha_pago!=null && $fecha_pago<$fecha_actual){?>disabled <?php }?>>
                  </div>
                </div>
                <div class="col-lg-4">
                  <div class="form-group">
                    <label class="control-label form-control-sm">N&uacute;mero Cuotas</label>
                    <input id="numero_cuota" name="numero_cuota" class="form-control form-control-sm" value="<?php echo $adelanto->nro_total_cuotas ?>" type="text" <?php $fecha_actual = date('Y-m-d'); if($fecha_pago!=null && $fecha_pago<$fecha_actual){?>disabled <?php }?>>
                  </div>
                </div>
              </div>
              <div style="margin-top:15px" class="form-group">
                <div class="col-sm-12 controls">
                  <div class="btn-group btn-group-sm float-right" role="group" aria-label="Log Viewer Actions">
                    <a href="javascript:void(0)" onClick="fn_save_adelanto()" class="btn btn-sm btn-success" style="margin-right: 15px;">Guardar</a>
                    <a href="javascript:void(0)" onClick="$('#openOverlayOpc').modal('hide');window.location.reload();" class="btn btn-md btn-warning">Cerrar</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        </section>
      </div>