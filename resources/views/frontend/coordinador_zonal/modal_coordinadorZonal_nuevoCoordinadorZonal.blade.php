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

function AddFila(){
	
	//var newRow = "";
  var cantidad = $('#numero_sesion').val();
  var ind = $('#tblSesion tbody tr').length;

  for (var i = 0; i < cantidad; i++) { 

    var newRow = $('<tr>');
    var n = i+1;
    //var año = $('#periodo').val();
    var año = new Date().getFullYear();
    var mes_ = $('#mes').val();
    var cap = $('#numero_cap').val();
    var fecha = '<input id="fecha" name="fecha" class="form-control form-control-sm datepicker2"  value="" type="text">'
    var distrito = '<select name="municipalidad" id="municipalidad" class="form-control form-control-sm" onChange=""> <option value="">--Selecionar--</option> <?php foreach ($municipalidad as $row) {?> <option value="<?php echo $row->id?>"><?php echo $row->denominacion?></option> <?php } ?> </select>'
    var estado_sesion = '<select name="estado_sesion" id="estado_sesion" class="form-control form-control-sm" onChange=""> <option value="">--Selecionar--</option> <?php foreach ($estado_sesion as $row) {?> <option value="<?php echo $row->codigo?>"><?php echo $row->denominacion?></option> <?php } ?> </select>'
    var aprobar_pago = '<select name="aprobar_pago" id="aprobar_pago" class="form-control form-control-sm"> <option value="" selected="selected">--Seleccionar--</option> <option value="1">Si</option> <option value="0">No</option> </select>'
    var eliminar = '<button type="button" class="btn btn-danger btn-sm" onclick="EliminarFila(this)">Eliminar</button>';

    newRow.append('<td>'+n+'</td>');
    newRow.append('<td>'+cap+'</td>');
    newRow.append('<td>'+ fecha+'</td>');
    newRow.append('<td>'+ distrito+'</td>');
    newRow.append('<td>'+ estado_sesion+'</td>');
    newRow.append('<td>'+ aprobar_pago+'</td>');
    newRow.append('<td>'+ eliminar+'</td>');
    //newRow.append('<td>Cell 2 Data</td>');


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
          <div class="row">
            <!--aaaa-->
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:5px;padding-bottom:5px">

              <form method="post" action="#" enctype="multipart/form-data">
                <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="id" id="id" value="<?php echo $id ?>">
                <!--<input type="hidden" name="id_persona" id="id_persona">-->
                <div style="padding-left:15px">
                <div class="row">
                    <div class="col-lg-4">
                      <div class="form-group">
                        <label class="control-label form-control-sm">N&uacute;mero CAP</label>
                        <input name="numero_cap" id="numero_cap" type="text" class="form-control form-control-sm" value="<?php echo $agremiado->numero_cap?>"  onblur="" readonly='readonly'>
                          
                      </div>
                    </div>

                  <div class="col-lg-4">
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
                </div>
              </div>

                <div style="padding-left:15px">
                  <div class="row">
                    
                    <div class="col-lg-4">
                      <div class="form-group">
                        <label class="control-label form-control-sm">Sesiones Mes</label>
                        <select name="mes" id="mes" class="form-control form-control-sm" onchange="">
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
                    <div class="col-lg-4">
                      <div class="form-group">
                        <label class="control-label form-control-sm">N° sesi&oacute;n</label>
                          <select name="numero_sesion" id="numero_sesion" class="form-control form-control-sm">
                            <option value="" selected="selected">--Seleccionar N°--</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
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
                        </tr>
                        </thead>
                        <tbody>
                      </tbody>
                    </table>
                    <div class="btn-group btn-group-sm float-right" role="group" aria-label="Log Viewer Actions">
                        <a href="javascript:void(0)" onClick="GuardarSesion()" class="btn btn-sm btn-success">Grabar</a>
                      </div>
                    </div>
                  </div>
                </div>
          </section>
        </div>
        </div>
    </div>
    
          