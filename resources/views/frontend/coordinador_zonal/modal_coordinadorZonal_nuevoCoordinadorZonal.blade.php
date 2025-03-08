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
    max-width: 70% !important
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


$(document).ready(function () {

  obtenerUltimoMes();

});

$("#profesion").select2();

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
          window.location.reload();
          }
  });
}

function AddFila(){
	
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
    var estado_sesion = '<select name="estado_sesion[]" id="estado_sesion" class="form-control form-control-sm" onChange="cambiarEstado()"> <option value="">--Selecionar--</option> <?php foreach ($estado_sesion as $row) {?> <option value="<?php echo $row->codigo?>"><?php echo $row->denominacion?></option> <?php } ?> </select>'
    var aprobar_pago = '<select name="aprobar_pago[]" id="aprobar_pago" class="form-control form-control-sm"> <option value="" selected="selected">--Seleccionar--</option> <option value="2">Si</option> <option value="1">No</option> </select>'
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


    $('#tblSesion tbody').append(newRow);
	
    cambiarEstado();
	/**************/
	
	//$("#upload_"+i).on('click', function() {
	
	
	/***************/
    /*
	$('.datepicker2').datepicker({
	  format: "dd-mm-yyyy",
	  autoclose: true,
	  container: '#openOverlayOpc modal-body',
	});
	*/
	//var today = new Date();
	//var mes = ($("#mes").val()-1);
	//$('.datepicker2').datepicker("startDate", new Date(today.getFullYear(),mes,01) );
	
	//$('.datepicker2').datepicker("maxDate", new Date(2024,2,13) );
	//$('.datepicker2').datepicker("minDate", new Date(2024,2,03) );
	
	/**************************/
	/*
	$('.datepicker2').datepicker('destroy');
	$('.datepicker2').datepicker('option', 'minDate', new Date(2024,2,13));
	$('.datepicker2').datepicker('option', 'maxDate', new Date(2024,2,03));
	*/
	$(function () {
		/*
	    $.fn.datepicker.dates['es'] = {
			days: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
		    daysShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
		    daysMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
		    months: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
		    monthsShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
		    today: 'Hoy',
		    clear: 'Limpiar',
		    format: 'dd/mm/yy',
		    titleFormat: "MM yyyy", 
		    weekStart: 1
		};
		*/
		$.datepicker.regional['es'] = {
		  closeText: 'Cerrar',
		  prevText: '<Ant',
		  nextText: 'Sig>',
		  currentText: 'Hoy',
		  monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
		  monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
		  dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
		  dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
		  dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
		  weekHeader: 'Sm',
		  dateFormat: 'dd/mm/yy',
		  firstDay: 1,
		  isRTL: false,
		  showMonthAfterYear: false,
		  yearSuffix: ''
		};
		
		$.datepicker.setDefaults($.datepicker.regional['es']);
		/*
		$("#datepicker").datepicker({
		    language: 'es', 
		    autoclose: true, 
		    todayHighlight: true,
		}).datepicker('update', new Date());
		*/
	});
	/*******************************/
	
	var mes = ($("#mes").val()-1);
	const obtenerFechaInicioDeMes = () => {
	const fechaInicio = new Date();
		//return new Date(fechaInicio.getFullYear(), fechaInicio.getMonth(), 1);
		return new Date(fechaInicio.getFullYear(), mes, 1);
	};
	
	const obtenerFechaFinDeMes = () => {
		const fechaFin = new Date();
		//return new Date(fechaFin.getFullYear(), fechaFin.getMonth() + 1, 0);
		return new Date(fechaFin.getFullYear(), mes + 1, 0);
	};
	
	const fechaInicio = obtenerFechaInicioDeMes();
	const fechaFin = obtenerFechaFinDeMes();
	var anio = new Date().getFullYear(); // Año actual

  const fechaPredeterminada = new Date(anio, mes, 1);


	$('.datepicker2').datepicker({
	  format: "dd-mm-yyyy",
	  autoclose: true,
	  container: '#openOverlayOpc modal-body',
	  //startDate: fechaInicio,
	  //endDate: fechaFin 
	}).datepicker('update', fechaPredeterminada);
	
	
	/*
	$('.datepicker2').datepicker({
        dateFormat: 'yy-mm-dd',
        showButtonPanel: true,
        changeMonth: true,
        changeYear: true,
yearRange: '1999:2012',
        showOn: "button",
        buttonImage: "images/calendar.gif",
        buttonImageOnly: true,
        startDate: new Date(1999, 10 - 1, 25),
        maxDate: '+30Y',
        inline: true
    });
	*/
	/**************************/
	
	
  }
 	
	/*
  $('.datepicker2').datepicker({
  format: "dd-mm-yyyy",
  autoclose: true,
  container: '#openOverlayOpc modal-body',
  setDate: new Date(2008,9,03)

	});
	*/
  

 
}

	function upload_img(i){
		//console.log(m);
		//alert("okkk"+m);
    var fileInput = $('#image_'+i)[0];
    var file = fileInput.files[0];
    var maxSize = 10 * 1024 * 1024;

    if (file.size > maxSize) {
        bootbox.alert("El archivo supera el tamaño máximo permitido de 15 MB.");
        return; 
    }
		console.log($('#image_'+i));
		var formData = new FormData();
		var files = $('#image_'+i)[0].files[0];
		formData.append('file',files);

    var msgLoader = "";
    msgLoader = "Procesando, espere un momento por favor";
    var heightBrowser = $(window).width()/2;
    $('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
    $('.loader').show();

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
          $('.loader').hide();
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
          $('.loader').hide();
					alert('Formato de imagen incorrecto.');
				}
				$('.loader').hide();
			}
		});
    
		
		
	//});
	}
	
function cambiarEstado() {
  $('select[name="estado_sesion[]"]').on('change', function() {
      
      var index = $('select[name="estado_sesion[]"]').index(this);
      
      var estado = $(this).val();
      
      var aprobarPago = (estado == 2) ? 2 : 1;
      
      $('select[name="aprobar_pago[]"]').eq(index).val(aprobarPago);
  });
}


function AddFila1(){
	
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
    var aprobar_pago = '<select name="sesion['+n+'][aprobar_pago]" id="aprobar_pago" class="form-control form-control-sm"> <option value="" selected="selected">--Seleccionar--</option> <option value="2">Si</option> <option value="1">No</option> </select>'
    var eliminar = '<button type="button" class="btn btn-danger btn-sm" onclick="EliminarFila(this)">Eliminar</button>';
    
    //newRow+='<tr>';
    newRow+='<td>'+n+'</td>';
    newRow+='<td>'+cap+'</td>';
    newRow+='<td>'+ fecha+'</td>';
    newRow+='<td>'+ distrito+'</td>';
    newRow+='<td>'+ estado_sesion+'</td>';
    newRow+='<td>'+ aprobar_pago+'</td>';
    newRow+='<td>'+ eliminar+'</td>';
    //newRow.append('<td>Cell 2 Data</td>');
/*
    newRow+='<tr>';
    newRow+='<td> <input input id="fecha" type="hidden" name="sesion[' + n + '][fecha]" value="''"> </td>';
    newRow+='<td> <select name="sesion['+n+'][municipalidad]" class="form-control form-control-sm" onChange=""> <option value="">--Selecionar--</option> <?php foreach ($municipalidad as $row) {?> <option value="<?php echo $row->id?>"><?php echo $row->denominacion?></option> <?php } ?> </select> <td> '
    newRow+='<td> <select name="sesion['+n+'][estado_sesion]" class="form-control form-control-sm" onChange=""> <option value="">--Selecionar--</option> <?php foreach ($estado_sesion as $row) {?> <option value="<?php echo $row->codigo?>"><?php echo $row->denominacion?></option> <?php } ?> </select> <td>  '
    newRow+='<td> <select name="sesion['+n+'][aprobar_pago]" class="form-control form-control-sm"> <option value="" selected="selected">--Seleccionar--</option> <option value="1">Si</option> <option value="0">No</option> </select> <td> '
    newRow+='<td> <button type="button" class="btn btn-danger btn-sm" onclick="EliminarFila(this)">Eliminar</button> <td> ';
    
    newRow+='</tr>';*/

    $('#tblSesion tbody').append(newRow);
  }
 
  $('.datepicker2').datepicker({
  format: "dd-mm-yyyy",
  autoclose: true,
  container: '#openOverlayOpc modal-body'
  //defaultDate: '01/07/2024'

	});

 
}

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

  function obtenerUltimoMes(){

  $.ajax({
      url: '/coordinador_zonal/obtener_ultimo_mes',
      dataType: "json",
      success: function(result){

        var ultimo_mes = result[0].mes;
        //alert(ultimo_mes);

        $('#mes').val(ultimo_mes); 
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
          Registro de Sesiones - Coordinador Zonal
        </div>
        <div class="card-body">
          
		  <form method="post" action="#" id="frmCoordinador" name="frmCoordinador" enctype="multipart/form-data">
		  
		  <div class="row">
            <!--aaaa-->
			
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:5px;padding-bottom:5px">

                <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="id" id="id" value="<?php echo $id ?>">
                <!--<input type="hidden" name="id_persona" id="id_persona">-->
                <div style="padding-left:15px">
                <div class="row">
                  <div class="col-lg-1">
                    <div class="form-group">
                      <label class="control-label form-control-sm">N&uacute;mero CAP</label>
                      <input name="numero_cap" id="numero_cap" type="text" class="form-control form-control-sm" value="<?php echo $agremiado->numero_cap?>"  onblur="" readonly='readonly'>
                        
                    </div>
                  </div>

                  <div class="col-lg-3">
                    <div class="form-group">
                      <label class="control-label form-control-sm">Agremiado</label>
                      <input name="agremiado" id="agremiado" type="text" class="form-control form-control-sm" value="<?php echo $persona->apellido_paterno.' '.$persona->apellido_materno.' '.$persona->nombres?>"  onblur="" readonly='readonly'>
                        
                    </div>
                  </div>

                  <div class="col-lg-2">
                    <div class="form-group">
                      <label class="control-label form-control-sm">Zonal</label>
                      <input name="zonal" id="zonal" type="text" class="form-control form-control-sm" value="<?php echo $zonal[0]->denominacion?>"  onblur="" readonly='readonly'>
                        
                    </div>
                  </div>

                  <div class="col-lg-2">
                      <div class="form-group">
                        <label class="control-label form-control-sm">Periodo</label>
                        <select name="periodo" id="periodo" class="form-control form-control-sm" onChange="" disabled='disabled'>
                          <option value="">--Selecionar--</option>
                            <?php
                              foreach ($periodo as $row) {?>
                              <option value="<?php echo $row->id?>" <?php if($row->id==$coordinadorZonal->id_periodo)echo "selected='selected'"?>><?php echo $row->descripcion?></option>
                              <?php
                                }
                                ?>
                        </select>
                      </div>
                    </div>
                
                    
                    <div class="col-lg-2">
                      <div class="form-group">
                        <label class="control-label form-control-sm">Sesiones Mes</label>
                        <select name="mes" id="mes" class="form-control form-control-sm" onChange="">
                          <option value="">--Selecionar Mes--</option>
                          <?php
                          foreach ($mes as $row) {?>
                          <option value="<?php echo $row->codigo?>" <?php if($row->codigo==$coordinadorZonal->id_mes)echo "selected='selected'"?>><?php echo $row->denominacion?></option>
                          <?php
                          }
                          ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-lg-1">
                      <div class="form-group">
                        <label class="control-label form-control-sm">N° sesi&oacute;n</label>
                          <select name="numero_sesion" id="numero_sesion" class="form-control form-control-sm">
                            <option value="" selected="selected">--Seleccionar N°--</option>
                            <?php for($i = 1; $i <= 10; $i++): ?>
                              <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php endfor; ?>
                        </select>
                      </div>
                    </div>
                  
                  <div style="margin-top:37px" class="form-group">
                    <div class="col-sm-12 controls">
                      <div class="btn-group btn-group-sm float-right" role="group" aria-label="Log Viewer Actions">
                        <a href="javascript:void(0)" onClick="AddFila()" class="btn btn-sm btn-success">Agregar</a>
                        <!--<button type="button" id="btnAgregar" class="btn btn-sm btn-success" onclick="AddFila()">Agregar</button>-->
                      </div>
                    </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <div style="display:none">
                    <select class="form-control" id="distrito" tabindex="16" style="width: 500px">
                      <option value="">Seleccionar Distrito</option>
                      <?php //foreach($especie as $row):?>
                      <option value="<?php //echo $row->id?>"><?php //echo $row->denominacion?></option>
                      <?php //endforeach;?>
                    </select>  
                  </div>
                  <!--
                  <button type="button" id="addRow" style="margin-left:10px;float:right" class="btn btn-success btn-xs">
                  <i class="fa fa-plus"></i> Agregar</button>
                  -->
                  <div class="table-responsive">
                  <table id="tblSesion" class="table table-hover table-sm">
                      <thead>
                        <tr>
                          <!--<th width="35%">N°</th>-->
                          <th>N°</th>
                          <!--<th>Medida</th>-->
                          <th>CAP</th>
                          <th>Fecha</th>
                          <th>Distrito</th>
                          <!--<th id="thImporte" style="display:none">Importe</th>-->
                          <th>Estado</th>
                          <th>Aprobar Pago</th>
                          <th width="250px">Informe</th>
                          <th>Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                      </tbody>
                    </table>
                    <div class="btn-group btn-group-sm float-right" role="group" aria-label="Log Viewer Actions">
                        <a href="javascript:void(0)" onClick="guardarSesion()" class="btn btn-sm btn-success">Grabar</a>
                      </div>
                    </div>
                  </div>
                </div>
				
				</form>
				
          </section>
        </div>
        </div>
    </div>
    
          