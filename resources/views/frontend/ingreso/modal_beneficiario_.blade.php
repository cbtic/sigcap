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
    max-width: 60% !important
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


$("#profesion").select2({ width: '100%' });

//datatablenewEmpresaBeneficiario();
function actualizarTablaBeneficiario(){
    // Realiza una solicitud AJAX para obtener los datos actualizados

    var id_empresa = $('#frmEmpresaBeneficiario #id_empresa').val();
    $.ajax({
        url: '/ingreso/obtener_datos_actualizados/'+id_empresa,
        method: "GET",
        success: function(response) {

          $('#tblBeneficiario').dataTable().fnDestroy();
          $("#tblBeneficiario tbody").html("");
            
            $('#tblBeneficiario').dataTable({
                "bFilter": false,
                "paging": false,
                "info": false,
                "bSort": false,

            });

            $('#tblBeneficiario').addClass("table table-hover table-sm").css("font-size", "13px");
            // Llena la tabla con los datos actualizados
            response.forEach(function(row) {
                $('#tblBeneficiario').dataTable().fnAddData([
                    row.numero_documento,
                    row.nombres,
                    row.direccion,
                    row.numero_celular,
                    row.correo
                ]);
            });
        },
        error: function(xhr, status, error) {
            // Maneja el error si la solicitud falla
            console.error("Error al obtener los datos actualizados:", error);
        }
    });
}


function datatablenewEmpresaBeneficiario(){
    var oTable1 = $('#tblBeneficiario').dataTable({
        "bServerSide": true,
        "sAjaxSource": "/ingreso/listar_empresa_beneficiario_ajax",
        "bProcessing": true,
        "sPaginationType": "full_numbers",
        //"paging":false,
        "bFilter": false,
        "bSort": false,
        "info": true,
		//"responsive": true,
        "language": {"url": "/js/Spanish.json"},
        "autoWidth": false,
        "bLengthChange": true,
        "destroy": true,
        "lengthMenu": [[10, 50, 100, 200, 60000], [10, 50, 100, 200, "Todos"]],
        "aoColumns": [
                        {},
        ],
		"dom": '<"top">rt<"bottom"flpi><"clear">',
        "fnDrawCallback": function(json) {
            $('[data-toggle="tooltip"]').tooltip();
        },

        "fnServerData": function (sSource, aoData, fnCallback, oSettings) {

            var sEcho           = aoData[0].value;
            var iNroPagina 	= parseFloat(fn_util_obtieneNroPagina(aoData[3].value, aoData[4].value)).toFixed();
            var iCantMostrar 	= aoData[4].value;
			
			var id_empresa = $('#id_empresa').val();
			var _token = $('#_token').val();
      oSettings.jqXHR = $.ajax({
				"dataType": 'json',
            //"contentType": "application/json; charset=utf-8",
            "type": "POST",
            "url": sSource,
            "data":{NumeroPagina:iNroPagina,NumeroRegistros:iCantMostrar,
            id_empresa:id_empresa,
            _token:_token
                    },
            "success": function (result) {
                fnCallback(result);
            },
            "error": function (msg, textStatus, errorThrown) {
                //location.href="login";
            }
          });
        },

        "aoColumnDefs":
            [	
				{
          "mRender": function (data, type, row) {
            var numero_documento = "";
            if(row.numero_documento!= null)numero_documento = row.numero_documento;
            return numero_documento;
          },
          "bSortable": false,
          "aTargets": [0],
          "className": "dt-center",
          //"className": 'control'
        },
				
				{
          "mRender": function (data, type, row) {
            var nombres = "";
            if(row.nombres!= null)nombres = row.nombres;
            return nombres;
          },
          "bSortable": true,
          "aTargets": [1]
        },
				
        {
        "mRender": function (data, type, row) {
          var direccion = "";
            if(row.direccion!= null)direccion = row.direccion;
            return direccion;
          },
          "bSortable": true,
          "aTargets": [2]
        },
				
				{
          "mRender": function (data, type, row) {
            var numero_celular = "";
            if(row.numero_celular!= null)numero_celular = row.numero_celular;
            return numero_celular;
          },
          "bSortable": true,
          "aTargets": [3]
        },

				{
          "mRender": function (data, type, row) {
            var correo = "";
            if(row.correo!= null)correo = row.correo;
            return correo;
          },
          "bSortable": true,
          "aTargets": [4]
        },

      ]

    });

}


function obtener_profesional_(){
	
  var numero_documento_ = $('#dni').val();
  //console.log(numero_documento);
  $.ajax({
      url: '/persona/obtenerPersona/'+numero_documento_,
      dataType: "json",
      success: function(result){

        if(result.sw==false){

          Swal.fire({
            title: 'El numero de documento no existe',
            text: "¿Desea registrar como  nueva persona?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, Crear!'
          }).then((result) => {
            //alert(result);exit();
            if (result.value) {
              var numero_documento_ = $('#dni').val();
              modal_personaNuevoBeneficiario(numero_documento_);
            //document.location="eliminar.php?codigo="+id;
            
            }
          });//$('#openOverlayOpc').modal('hide');
            
          /*
					bootbox.alert(result.msg);
					$('#openOverlayOpc').modal('hide');*/
				}else{

					$('#apellido_paterno').val(result.persona.apellido_paterno);
          $('#apellido_materno').val(result.persona.apellido_materno);
          $('#nombres').val(result.persona.nombres);
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

function save_beneficiario(){
    
    var msg = "";
    var _token = $('#_token').val();
    var id = $('#id').val();
    var dni = $('#dni').val();
    var ruc = $('#ruc').val();
    var periodo = $('#periodo').val();
    var concepto = $('#concepto').val();
    var estado_beneficiario = $('#estado_beneficiario').val();
    var observacion = $('#observacion').val();
    
    if(dni == "")msg += "Debe ingresar un DNI <br>";
    
      if(msg!=""){
          bootbox.alert(msg);
          return false;
      }
    
      $.ajax({
        url: "/ingreso/send_beneficiario",
              type: "POST",
              data : {_token:_token,id:id,dni:dni,ruc:ruc,
              periodo:periodo,concepto:concepto,estado_beneficiario:estado_beneficiario,
              observacion:observacion},
              success: function (result) {
          
				
              }
      });
  }

function obtenerPersona(){
		
    var dni = $("#dni").val();
    var msg = "";

    //bootbox.alert(dni);
    
    if(dni == "")msg += "Debe ingresar el numero de documento <br>";
    
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
      url: '/persona/obtenerPersona/' + dni,
      dataType: "json",
      success: function(result){

        //bootbox.alert(result);
        
        if(result.sw==false){

          Swal.fire({
            title: 'El numero de documento no existe',
            text: "¿Desea registrar como  nueva persona?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, Crear!'
          }).then((result) => {
            if (result.value) {
            //modal_persona_new();
            modal_personaNuevoBeneficiario();
            //document.location="eliminar.php?codigo="+id;
            
            }
          });
        }else{
					var persona = result.persona;
        //var tipo_documento = parseInt(agremiado.tipo_documento);
        //var nombre = persona.apellido_paterno+" "+persona.apellido_materno+", "+persona.nombres;
        //$('#dni').val(persona.numero_documento);
        $('#apellido_paterno').val(persona.apellido_paterno);
        $('#apellido_materno').val(persona.apellido_materno);
        $('#nombres').val(persona.nombres);
        //$('#telefono').val(persona.telefono);
        //$('#email').val(persona.email);
        
        $('.loader').hide();
				}
  
      }
      
    });
    
  }

function modal_personaNuevoBeneficiario(){

  var numero_documento_ = $('#dni').val();

	$(".modal-dialog").css("width","85%");
	$('#openOverlayOpc').modal('show');
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
			url: "/persona/modal_personaNuevoBeneficiario",
			type: "get",
			data : $("#frmEmpresaBeneficiario").serialize(),
			success: function (result) {  
					$("#diveditpregOpc").html(result);


					//$('#openOverlayOpc').modal('show');
					
			}
	});

	//cargarConceptos();

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
          Registro Beneficiarios
        </div>
        <div class="card-body">
          <div class="row">
            <!--aaaa-->
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:5px;padding-bottom:20px">

              <form method="post" id="frmEmpresaBeneficiario" action="#" enctype="multipart/form-data">
                <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="id_empresa" id="id_empresa" value="<?php echo $empresa->id ?>">
                <!--<input type="hidden" name="id_persona" id="id_persona">-->
                
                
                  <div class="row">
                    <div class="col-lg-4">
                      <div class="form-group">
                        <label class="control-label form-control-sm">RUC</label>
                        <input name="ruc" id="ruc" type="text" class="form-control form-control-sm" value="<?php echo $empresa->ruc?>" onBlur="" readonly='readonly'>
                          
                      </div>
                    </div>

                    <div class="col-lg-4">
                      <div class="form-group">
                        <label class="control-label form-control-sm">N&uacute;mero Documento</label>
                        <input name="dni" id="dni" type="text" class="form-control form-control-sm" value="<?php echo $persona->numero_documento?>" onChange="obtener_profesional_()" >
                          
                      </div>
                    </div>
                  </div>

                  <div class="row">

                    <div class="col-lg-4">
                      <div class="form-group" style="padding-top:0px;padding-bottom:0px;margin-top:0px;margin-bottom:0px">
                        <label class="control-label form-control-sm">Apellido Paterno</label>
                        <input id="apellido_paterno" name="apellido_paterno" class="form-control form-control-sm" value="<?php echo $persona->apellido_paterno ?>" type="text" readonly="readonly">
                      </div>
                    </div>

                    <div class="col-lg-4">
                      <div class="form-group" style="padding-top:0px;padding-bottom:0px;margin-top:0px;margin-bottom:0px">
                        <label class="control-label form-control-sm">Apellido Materno</label>
                        <input id="apellido_materno" name="apellido_materno" class="form-control form-control-sm" value="<?php echo $persona->apellido_materno ?>" type="text" readonly="readonly">
                      </div>
                    </div>
                      <div class="col-lg-4">
                        <div class="form-group" style="padding-top:0px;padding-bottom:0px;margin-top:0px;margin-bottom:0px">
                          <label class="control-label form-control-sm">Nombres</label>
                          <input id="nombres" name="nombres" class="form-control form-control-sm" value="<?php echo $persona->nombres ?>" type="text" readonly="readonly">
                        </div>
                      </div>
                  
                </div>
              </div>
                
                </div>

                  <div style="margin-top:15px" class="form-group">
                    <div class="col-sm-12 controls">
                      <div class="btn-group btn-group-sm float-right" role="group" aria-label="Log Viewer Actions">
                        <a href="javascript:void(0)" onClick="save_beneficiario()" class="btn btn-sm btn-success">Guardar</a>
                      </div>
                    </div>
                  </div>

                  <div class="card-body">

                    <div class="table-responsive">
                    <table id="tblBeneficiario" class="table table-hover table-sm">
                        <thead>
                        <tr style="font-size:13px">
                            <th>N&uacute;mero Documento</th>
                            <th>Nombres</th>
                            <th>Direcci&oacute;n</th>
                            <th>Celular</th>
                            <th>Correo</th>
                            
                            <!--<th>Acciones</th>-->
                        </tr>
                        </thead>
                        <tbody>
						
                        <?php foreach ($empresa_beneficiario as $row) {?>
						
                        <tr style='font-size:13px'>
                          <td class='text-left'><?php echo $row->numero_documento?></td>
                          <td class='text-left'><?php echo $row->nombres?></td>
                          <td class='text-left'><?php echo $row->direccion?></td>
                          <td class='text-left'><?php echo $row->numero_celular?></td>
                          <td class='text-left'><?php echo $row->correo?></td>
						
                        <?php } ?>
						
                        </tbody>
                    </table>
                    </div>
                    </div>

                </div>
                </form>
            </div>
          </div>
        </div>
        </section>
      </div>

<script type="text/javascript">
$(document).ready(function () {
	actualizarTablaBeneficiario();
	//var id_empresa = $('#id_empresa').val();
  //datatablenewEmpresaBeneficiario(id_empresa);
	
});

</script>

