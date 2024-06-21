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


$("#profesion").select2();

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

$('.datepicker2').datepicker({
  format: "dd-mm-yyyy",
  autoclose: true,
  container: '#openOverlayOpc modal-body'
  //defaultDate: '01/07/2024'

	});

function editarDetalle(){

  var inputs = document.querySelectorAll('.adelanto-input, .fecha-input');

  inputs.forEach(function(input) {
    
    input.disabled  = false;

    var fila = input.closest('tr');
 
    //var fechaPagoCell = fila.querySelector('.fecha-pago input');
    //var fechaPagoString = fechaPagoCell.innerText;
    //var partes = fechaPagoString.split('-');
    //var fechaPago = new Date(partes[2], partes[1] - 1, partes[0]);
    var fechaPagoInput = fila.querySelector('.fecha-pago input');
    var fechaPagoString = fechaPagoInput.value;
    var partes = fechaPagoString.split('-');
    var fechaPago = new Date(partes[2], partes[1] - 1, partes[0]);

    //var fechaPago = new Date(fechaPagoString);
    
    var fechaActual = new Date();
    /*var opciones = { day: '2-digit', month: '2-digit', year: 'numeric' };
    var fechaFormateada = fechaActual.toLocaleDateString('es-ES', opciones);
    fechaFormateada = fechaFormateada.replace(/\//g, '-');*/
    //alert(fechaActual);
    if (fechaPago < fechaActual) {
      input.disabled = true;
    }else{
      input.disabled  = false;
    }
  });
}

function fn_save_detalle(){

  var totalPago = 0;
  var adelantoPagar = [];
  var idAdelantoDetalle = [];
  var fechas_pago = [];

  $("input[name='fecha[]']").each(function() {
    fechas_pago.push($(this).val());
  });

  

  $("input[name='adelanto_pagar[]']").each(function(){
    var monto_detalle = parseFloat($(this).val().replace(',',''))

    totalPago += monto_detalle;
    adelantoPagar.push(monto_detalle);
    
  });

  $("input[name='id_adelanto_detalle[]']").each(function(){
    var id_detalle = $(this).val();

    idAdelantoDetalle.push(id_detalle);
  });
  //alert(idAdelantoDetalle);
  var totalAdelanto = ("<?php echo $adelanto_detalle[0]->total_adelanto; ?>");
  var id = "<?php echo $id; ?>";
  var _token = "{{ csrf_token() }}";

  if(totalPago==totalAdelanto){
    //alert('El total es igual');
    $.ajax({
      url: "/adelanto/send_detalle_adelanto",
      type: "POST",
      data: {
        _token:_token,
        id: id,
        adelanto_pagar: JSON.stringify(adelantoPagar),
        id_adelanto_detalle: JSON.stringify(idAdelantoDetalle),
        fecha: JSON.stringify(fechas_pago)
        
      },
      //dataType: 'json',
      success: function(result) {
        $('#openOverlayOpc').modal('hide');
        //window.location.reload();
        datatablenew();

      }
    });
    
  }else{
    bootbox.alert("El total no coincide con las cuotas");
  }
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

    $.ajax({
      url: "/adelanto/send_adelanto_nuevoAdelanto",
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
          Detalle Adelantos
        </div>
        <div class="card-body">
          <div class="row">
            <!--aaaa-->
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:5px;padding-bottom:20px">

              <div class="card-body">	
                <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="id" id="id" value="<?php echo $id ?>">	
                <!--<input type='hidden' name='total_adelanto' value='<?php //echo $adelanto_detalle->total_adelanto?>'>-->

                <div class="table-responsive">
                <table id="tblPuesto" class="table table-hover table-sm">
                    <thead>
                    <tr style="font-size:13px">
                        <th>Detalle Cuota</th>
                        <th>Monto</th>
                        <th>Fecha Vencimiento</th>
                        <!--<th>Estado</th>-->
                    </tr>
                    </thead>
                    <tbody style="font-size:13px">
                    <?php foreach ($adelanto_detalle as $row) {?>
										<tr style='font-size:13px'>
											<input type='hidden' name='id_adelanto_detalle[]' value='<?php echo $row->id?>'>
											<td class='text-left id_cuota'><?php echo 'cuota '.$row->numero_cuota?></td>
											<td class='text-left'><input type='text' name='adelanto_pagar[]' value='<?php echo number_format($row->adelanto_pagar, 2, '.', ',')?>' size="10" class="adelanto-input" disabled='disabled' onchange=""></td>
											<!--<td class='text-left fecha-pago'><?php //echo $row->fecha_pago?></td>-->
											<td class='text-left fecha-pago'><input id="fecha" name="fecha[]" class="form-control form-control-sm datepicker2 fecha-input"  value="<?php echo $row->fecha_pago?>" type="text" disabled='disabled' style="width: 140px;" onchange="editarDetalle()">
										<?php } ?>
                    </tr>
                    <tr style='border-top: 1px solid #000;'>
                      <td class='text-left' style='border-top: 1px solid #000;'><?php echo 'Total Adelanto '?></td>
                      <td class='text-left' style='border-top: 1px solid #000;'><?php echo number_format($adelanto_detalle[0]->total_adelanto, 2, '.', ',')?></td>
                    </tr>
										</tbody>
                </table>
                </div>
                  <div style="margin-top:15px" class="form-group">
                    <div class="col-sm-12 controls">
                      <div class="btn-group btn-group-sm float-right" role="group" aria-label="Log Viewer Actions">
                        <a href="javascript:void(0)" onClick="editarDetalle()" class="btn btn-sm btn-success" id="editarBtn">Editar</a>
                        <a href="javascript:void(0)" onClick="fn_save_detalle()" class="btn btn-sm btn-success" style="font-size:12px;margin-left:10px">Guardar</a>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
          </div>
        </div>
        </section>
      </div>