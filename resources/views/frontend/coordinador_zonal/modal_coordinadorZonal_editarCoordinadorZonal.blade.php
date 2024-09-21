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
    max-width: 50% !important
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


$("#profesion").select2();

$('#fecha_programada_').datepicker({
  autoclose: true,
  dateFormat: 'dd/mm/yy',
  changeMonth: true,
  changeYear: true,
});

$('#fecha_ejecucion_').datepicker({
  autoclose: true,
  dateFormat: 'dd/mm/yy',
  changeMonth: true,
  changeYear: true,
});

function obtenerAgremiadoCoordinador(){
		
  var numero_cap = $("#frmEditarSesion #numero_cap").val();
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
    url: '/agremiado/obtener_datos_agremiado_coordinador_zonal/' + numero_cap,
    dataType: "json",
    success: function(result){
      
      var agremiado = result.agremiado;
      //var tipo_documento = parseInt(agremiado.tipo_documento);
      //var nombre = persona.apellido_paterno+" "+persona.apellido_materno+", "+persona.nombres;
      $('#frmEditarSesion #apellido_paterno').val(agremiado.apellido_paterno);
      $('#frmEditarSesion #apellido_materno').val(agremiado.apellido_materno);
      $('#frmEditarSesion #nombre').val(agremiado.nombres);
      //$('#telefono').val(persona.telefono);
      //$('#email').val(persona.email);
      
      $('.loader').hide();

    }
    
  });
  
}

function obtener_profesional(){
	
  var numero_cap = $('#numero_cap').val();
  //console.log(numero_documento);
  $.ajax({
      url: '/prestamo/buscar_numero_cap/'+numero_cap,
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

function guardarSesion(){
 	/*
  var dataToSend={
  sesion: {
        n: n,
        cap: cap,
        fecha: $('#fecha').val(), // Obtener el valor del input fecha
        municipalidad: $('#municipalidad').val(), // Obtener el valor del select municipalidad
        estado_sesion: $('#estado_sesion').val(), // Obtener el valor del select estado_sesion
        aprobar_pago: $('#aprobar_pago').val() // Obtener el valor del select aprobar_pago
        // Otros datos que desees enviar
    }
  };
	*/
  //alert($('#tblConceptos'));

$.ajax({
  		url: "/coordinador_zonal/send_coordinador_sesion",
        type: "POST",
        data : $("#frmCoordinador").serialize(),
        //data: dataToSend,
        //dataType: 'json', 
        success: function (result) {				
    		$('#openOverlayOpc').modal('hide');
			
        }
});
}

function save_sesion_(){
 	/*
  var dataToSend={
  sesion: {
        n: n,
        cap: cap,
        fecha: $('#fecha').val(), // Obtener el valor del input fecha
        municipalidad: $('#municipalidad').val(), // Obtener el valor del select municipalidad
        estado_sesion: $('#estado_sesion').val(), // Obtener el valor del select estado_sesion
        aprobar_pago: $('#aprobar_pago').val() // Obtener el valor del select aprobar_pago
        // Otros datos que desees enviar
    }
  };
	*/
  //alert($('#tblConceptos'));

$.ajax({
  		url: "/coordinador_zonal/send_coordinador_sesion_editar",
        type: "POST",
        data : $("#frmEditarSesion").serialize(),
        //data: dataToSend,
        //dataType: 'json', 
        success: function (result) {				
    		$('#openOverlayOpc').modal('hide');
        window.location.reload();
        }
});
}
/*function AddFila(){
	
	//var newRow = "";
  var cantidad = $('#numero_sesion').val();
  $('#tblConceptos tbody').html("");
  var newRow = "";
  for (var i = 0; i < cantidad; i++) { 
    newRow = "";
    
    var n = i+1;
    //var año = $('#periodo').val();
    var año = new Date().getFullYear();
    var mes_ = $('#mes').val();
    var cap = $('#numero_cap').val();
    var fecha = '<input id="fecha" name="fecha[]" class="form-control form-control-sm datepicker2"  value="" type="text">'
    var distrito = '<select name="municipalidad[]" id="municipalidad" class="form-control form-control-sm" onChange=""> <option value="">--Selecionar--</option> <?php foreach ($municipalidad as $row) {?> <option value="<?php echo $row->id?>"><?php echo $row->denominacion?></option> <?php } ?> </select>'
    var estado_sesion = '<select name="estado_sesion[]" id="estado_sesion" class="form-control form-control-sm" onChange=""> <option value="">--Selecionar--</option> <?php foreach ($estado_sesion as $row) {?> <option value="<?php echo $row->codigo?>"><?php echo $row->denominacion?></option> <?php } ?> </select>'
    var aprobar_pago = '<select name="aprobar_pago[]" id="aprobar_pago" class="form-control form-control-sm"> <option value="" selected="selected">--Seleccionar--</option> <option value="1">Si</option> <option value="0">No</option> </select>'
    //var informe = '<select name="informe[]" id="informe" class="form-control form-control-sm"> <option value="" selected="selected">--Seleccionar--</option> <option value="1">Si</option> <option value="0">No</option> </select>'
    var eliminar = '<button type="button" class="btn btn-danger btn-sm" onclick="EliminarFila(this)">Eliminar</button>';
    var informe =  '<span class="btn btn-warning btn-file">Examinar <input id="image_'+i+'" name="image[]" type="file" /></span><input type="button" class="btn btn-sm btn-primary" value="Subir" id="upload_'+i+'" onclick="upload_img('+i+')" name="subir" style="margin-left:10px"><img src="/img/logo-sin-fondo2.png" id="img_ruta_'+i+'" width="80px" height="50px" alt="" style="margin-left:10px"><input type="hidden" id="img_foto_'+i+'" name="img_foto[]" value="" />'
      newRow+='<tr>';
      newRow+='<td>'+n+'</td>';
      newRow+='<td>'+cap+'</td>';
      newRow+='<td>'+ fecha+'</td>';
      newRow+='<td>'+ distrito+'</td>';
      newRow+='<td>'+ estado_sesion+'</td>';
      newRow+='<td>'+ aprobar_pago+'</td>';
      newRow+='<td>'+ informe+'</td>';
      newRow+='<td>'+ eliminar+'</td>';
      newRow+='</tr>';
    //newRow.append('<td>Cell 2 Data</td>');


    $('#tblSesion tbody').append(newRow);*/
	
	
	/**************/
	
	//$("#upload_"+i).on('click', function() {
	
	
	/***************/
    
  /*}
 
  $('.datepicker2').datepicker({
  format: "dd-mm-yyyy",
  autoclose: true,
  container: '#openOverlayOpc modal-body'
  //defaultDate: '01/07/2024'

	});

  

 
}*/

	function upload_img(i){
		//console.log(m);
		//alert("okkk"+m);
		console.log($('#image_'+i));
		var formData = new FormData();
		var files = $('#image_'+i)[0].files[0];
		formData.append('file',files);
		$.ajax({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			url: "/coordinador_zonal/upload_informe",
			type: 'post',
			data: formData,
			contentType: false,
			processData: false,
			success: function(response) {
				
				//var ind_img = $("#ind_img").val();
				
				if (response != 0) {
					$("#img_ruta_"+i).attr("src", "/img/informe/tmp/"+response).show();
					//$(".delete_ruta").show();
					$("#img_foto_"+i).val(response);

					ind_img++;
					/*
					var newRow = "";
					newRow += '<div class="img_ruta">';
					newRow += '<img src="" id="img_ruta_'+ind_img+'" width="130px" height="165px" alt="" style="text-align:center;margin-top:8px;display:none;margin-left:10px" />';
					newRow += '<span class="delete_ruta" style="display:none" onclick="DeleteImagen(this)"></span>';
					newRow += '<input type="hidden" id="img_foto_'+ind_img+'" name="img_foto[]" value="" />';
					newRow += '</div>';

					$("#divImagenes").append(newRow);
					$("#ind_img").val(ind_img);
					*/
				} else {
					alert('Formato de imagen incorrecto.');
				}
				
			}
		});
		
		
	//});
	}
	

/*function AddFila1(){
	
	//var newRow = "";
  var cantidad = $('#numero_sesion').val();
  $('#tblConceptos tbody').html("");
  //var cantidad = $("#tblSesion tr").length;

  var newRow = "";

  for (var i = 0; i < cantidad; i++) { 

    //var newRow = $('<tr>');
    var n = i+1;
    //var año = $('#periodo').val();
    
    var año = new Date().getFullYear();
    var mes_ = $('#mes').val();
    var cap = $('#numero_cap').val();
    
    var fecha = '<input id="fecha" name="sesion['+n+'][fecha]" class="form-control form-control-sm datepicker2"  value="" type="text">'
    var distrito = '<select name="sesion['+n+'][municipalidad]" id="municipalidad" class="form-control form-control-sm" onChange=""> <option value="">--Selecionar--</option> <?php foreach ($municipalidad as $row) {?> <option value="<?php echo $row->id?>"><?php echo $row->denominacion?></option> <?php } ?> </select>'
    var estado_sesion = '<select name="sesion['+n+'][estado_sesion]" id="estado_sesion" class="form-control form-control-sm" onChange=""> <option value="">--Selecionar--</option> <?php foreach ($estado_sesion as $row) {?> <option value="<?php echo $row->codigo?>"><?php echo $row->denominacion?></option> <?php } ?> </select>'
    var aprobar_pago = '<select name="sesion['+n+'][aprobar_pago]" id="aprobar_pago" class="form-control form-control-sm"> <option value="" selected="selected">--Seleccionar--</option> <option value="1">Si</option> <option value="0">No</option> </select>'
    var eliminar = '<button type="button" class="btn btn-danger btn-sm" onclick="EliminarFila(this)">Eliminar</button>';
    
    //newRow+='<tr>';
    newRow+='<td>'+n+'</td>';
    newRow+='<td>'+cap+'</td>';
    newRow+='<td>'+ fecha+'</td>';
    newRow+='<td>'+ distrito+'</td>';
    newRow+='<td>'+ estado_sesion+'</td>';
    newRow+='<td>'+ aprobar_pago+'</td>';
    newRow+='<td>'+ eliminar+'</td>';
    //newRow.append('<td>Cell 2 Data</td>');*/
/*
    newRow+='<tr>';
    newRow+='<td> <input input id="fecha" type="hidden" name="sesion[' + n + '][fecha]" value="''"> </td>';
    newRow+='<td> <select name="sesion['+n+'][municipalidad]" class="form-control form-control-sm" onChange=""> <option value="">--Selecionar--</option> <?php foreach ($municipalidad as $row) {?> <option value="<?php echo $row->id?>"><?php echo $row->denominacion?></option> <?php } ?> </select> <td> '
    newRow+='<td> <select name="sesion['+n+'][estado_sesion]" class="form-control form-control-sm" onChange=""> <option value="">--Selecionar--</option> <?php foreach ($estado_sesion as $row) {?> <option value="<?php echo $row->codigo?>"><?php echo $row->denominacion?></option> <?php } ?> </select> <td>  '
    newRow+='<td> <select name="sesion['+n+'][aprobar_pago]" class="form-control form-control-sm"> <option value="" selected="selected">--Seleccionar--</option> <option value="1">Si</option> <option value="0">No</option> </select> <td> '
    newRow+='<td> <button type="button" class="btn btn-danger btn-sm" onclick="EliminarFila(this)">Eliminar</button> <td> ';
    
    newRow+='</tr>';*/

    /*$('#tblSesion tbody').append(newRow);
  }
 
  $('.datepicker2').datepicker({
  format: "dd-mm-yyyy",
  autoclose: true,
  container: '#openOverlayOpc modal-body'
  //defaultDate: '01/07/2024'

	});

 
}*/

function EliminarFila(button) {
    $(button).closest('tr').remove();
  }

/*function CrearFilas(numeroFilas) {

  
   
    AddFila();
  
}*/

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

  function fn_save_prestamo() {

    var _token = $('#_token').val();
    var id_persona = $('#id_persona').val();
    var id = $('#id').val();
    var tipo_documento = $('#tipo_documento').val();
    var numero_cap = $('#numero_cap').val();
    var nombres = $('#nombres').val();
    var apellido_paterno = $('#apellido_paterno').val();
    var apellido_materno = $('#apellido_materno').val();
    var id_tipo_prestamo = $('#id_tipo_prestamo').val();
    var monto = $('#monto').val();
    var numero_cuota = $('#numero_cuota').val();

    $.ajax({
      url: "/prestamo/send_prestamo_nuevoPrestamo",
      type: "POST",
      data: {
        _token: _token,
        id: id,
        id_persona:id_persona,
        tipo_documento: tipo_documento,
        numero_cap: numero_cap,
        nombres: nombres,
        apellido_paterno: apellido_paterno,
        apellido_materno: apellido_materno,
        id_tipo_prestamo: id_tipo_prestamo,
        monto: monto,
        numero_cuota: numero_cuota
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
          Editar Sesiones - Coordinador Zonal
        </div>
        <div class="card-body">
          
		  <form method="post" action="#" id="frmEditarSesion" name="frmEditarSesion" enctype="multipart/form-data">
		  
		  <div class="row">
            <!--aaaa-->
			
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:5px;padding-bottom:5px">

                <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="id" id="id" value="<?php echo $id ?>">
                <!--<input type="hidden" name="id_persona" id="id_persona">-->
                <div style="padding-left:15px">
                  <div class="row">
                    <div class="col-lg-5">
                      <div class="form-group">
                        <label class="control-label form-control-sm">Regional</label>
                        <input type="hidden" name="id_regional_" id="id_regional_" value="" />
                        <select name="id_regional" id="id_regional" class="form-control form-control-sm" onChange="" disabled='disabled'>
                          <option value="">--Selecionar--</option>
                          <?php
                          foreach ($region as $row) {?>
                          <option value="<?php echo $row->id?>" <?php if($row->id==5)echo "selected='selected'"?>><?php echo $row->denominacion?></option>
                          <?php 
                          }
                          ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label class="control-label form-control-sm">Periodo</label>
                        <select name="periodo_" id="periodo_" class="form-control form-control-sm" onChange="" disabled='disabled'>
                          <option value="">--Selecionar--</option>
                            <?php
                              foreach ($periodo as $row) {?>
                              <option value="<?php echo $row->id?>" <?php if($row->id==$comision_sesion->id_periodo_comisione)echo "selected='selected'"?>><?php echo $row->descripcion?></option>
                              <?php
                                }
                                ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-lg-4">
                      <div class="form-group">
                        <label class="control-label form-control-sm">Tipo Comisi&oacute;n</label>
                        <input type="hidden" name="tipo_comision_" id="tipo_comision_" value="" />
                        <select name="tipo_comision" id="tipo_comision" class="form-control form-control-sm" onChange="obtenerComision()" disabled='disabled'>
                          <option value="0">--Tipo Comisi&oacute;n--</option>
                            <?php
                            foreach ($tipo_comision as $row) {?>
                              <option value="<?php echo $row->codigo?>" <?php if($row->codigo==$comision->id_tipo_comision)echo "selected='selected'"?>><?php echo $row->denominacion?></option>
                            <?php
                            }
                            ?>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-2">
                      <div class="form-group">
                        <label class="control-label form-control-sm">N&uacute;mero CAP</label>
                        <input name="numero_cap_" id="numero_cap_" type="text" class="form-control form-control-sm" value="<?php echo $agremiado->numero_cap?>"  onchange="" readonly='readonly'>
                      </div>
                    </div>
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label class="control-label form-control-sm">Apellido Paterno</label>
                        <input name="apellido_paterno_" id="apellido_paterno_" type="text" class="form-control form-control-sm" value="<?php echo $persona->apellido_paterno?>"  onblur="" readonly='readonly'>
                      </div>
                    </div>
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label class="control-label form-control-sm">Apellido Materno</label>
                        <input name="apellido_materno_" id="apellido_materno_" type="text" class="form-control form-control-sm" value="<?php echo $persona->apellido_materno?>"  onblur="" readonly='readonly'>
                      </div>
                    </div>
                    <div class="col-lg-4">
                      <div class="form-group">
                        <label class="control-label form-control-sm">Nombres</label>
                        <input name="nombres_" id="nombres_" type="text" class="form-control form-control-sm" value="<?php echo $persona->nombres?>"  onblur="" readonly='readonly'>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="control-label form-control-sm">Comision</label>
                        <input name="comision_" id="comision_" type="text" class="form-control form-control-sm" value="<?php echo $comision_nombre?>"  onblur="" readonly='readonly'>
                      </div>
                    </div>
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label class="control-label form-control-sm">Fecha Programada</label>
                        <input id="fecha_programada_" name="fecha_programada_" class="form-control form-control-sm datepicker2"  value="<?php echo $comision_sesion->fecha_programado?>" type="text">
                        </div>
                    </div>
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label class="control-label form-control-sm">Fecha Ejecuci&oacute;n</label>
                        <input id="fecha_ejecucion_" name="fecha_ejecucion_" class="form-control form-control-sm datepicker2"  value="<?php echo $comision_sesion->fecha_ejecucion?>" type="text">
                        </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="control-label form-control-sm">Municipalidad</label>
                        <select name="municipalidad_" id="municipalidad_" class="form-control form-control-sm" onChange=""> 
                          <option value="">--Selecionar--</option> 
                            <?php 
                              foreach ($municipalidad as $row) {?> 
                              <option value="<?php echo $row->id?>" <?php if($row->id==$comision_sesion->id_municipalidad)echo "selected='selected'"?>><?php echo $row->denominacion?></option> 
                              <?php 
                              } 
                            ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label class="control-label form-control-sm">Estado Sesi&oacute;n</label>
                        <select name="estado_sesion_" id="estado_sesion_" class="form-control form-control-sm" onChange=""> 
                          <option value="">--Selecionar--</option> 
                          <?php 
                            foreach ($estado_sesion as $row) {?> 
                            <option value="<?php echo $row->codigo?>" <?php if($row->codigo==$comision_sesion->id_estado_aprobacion)echo "selected='selected'"?>><?php echo $row->denominacion?></option> 
                            <?php 
                            }   
                          ?> 
                        </select>
                      </div>
                    </div>
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label class="control-label form-control-sm">Aprobar Pago</label>
                          <select name="aprobar_pago_" id="aprobar_pago_" class="form-control form-control-sm"> 
                            <option value="">--Selecionar--</option> 
                            <?php 
                              foreach ($aprobar_pago as $row=>$value) {?> 
                              <!--<option value="<?php //echo $row?>" <?php //if($row==$id_aprobar_pago)echo "selected='selected'"?>><?php //echo $row?></option> -->
                              <?php 
                              //if($row==1){$row=2;}else{$row=1;}
                              $selected = ($row ==$id_aprobar_pago) ? "selected='selected'" : "";
                              echo "<option value='{$row}' {$selected}>{$value}</option>";
                              ?>
                              <?php 
                              }   
                            ?> 
                          </select>
                      </div>
                    </div>
                  </div>
                  <div style="margin-top:15px" class="form-group">
                    <div class="col-sm-12 controls">
                      <div class="btn-group btn-group-sm float-right" role="group" aria-label="Log Viewer Actions">
                        <a href="javascript:void(0)" onClick="save_sesion_()" class="btn btn-sm btn-success">Guardar</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
				</form>
				
          </section>
        </div>
        </div>
    </div>
    
          