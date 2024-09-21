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


//$("#profesion").select2({ width: '100%' });

$("#concepto").select2({ width: '100%' });

//datatablenewEmpresaBeneficiario();
/*function actualizarTablaBeneficiario(){
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
}*/

/*
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

}*/

function AddFila(){
	
  var cantidad = $('#numero_beneficiario').val();
  $('#frmBeneficiario').html("");
  var nuevoContenido = "";
  var n_beneficiario_vigente ="";
  var m;
  for (var i = 0; i < cantidad; i++) {
    
    var n = i+1;

	  var id_n = '<input type="hidden" name="id_n" id="'+ i +'" value="">'
	  var etiqueta_dni_beneficiario = '<label class="form-control-sm form-control-sm">DNI</label>'
    var dni_beneficiario = '<input type="text" name="dni_beneficiario[]" id="dni_beneficiario' + i + '" value="" placeholder="" class="form-control form-control-sm" onchange ="obtener_profesional_('+i+')">';
    var etiqueta_apellidoP_beneficiario = '<label class="form-control-sm form-control-sm">Apellido Paterno</label>'
	  var apellidoP_beneficiario = '<input id="apellidoP_beneficiario' + i + '" name="apellidoP_beneficiario[]" class="form-control form-control-sm" value="" type="text" readonly>'
    var etiqueta_apellidoM_beneficiario = '<label class="form-control-sm form-control-sm">Apellido Materno</label>'
	  var apellidoM_beneficiario = '<input id="apellidoM_beneficiario' + i + '" name="apellidoM_beneficiario[]" class="form-control form-control-sm" value="" type="text" readonly>'
    var etiqueta_nombres_beneficiario = '<label class="form-control-sm form-control-sm">Nombres</label>'
	  var nombres_beneficiario = '<input id="nombres_beneficiario' + i + '" name="nombres_beneficiario[]" class="form-control form-control-sm" value="" type="text" readonly>'
    var etiqueta_estado_beneficiario = '<label class="form-control-sm form-control-sm">Estado</label>'
	  //var estado_beneficiario = '<input id="estado_beneficiario' + i + '" name="estado_beneficiario[]" class="form-control form-control-sm" value="" type="text">'
    //var informe = '<select name="informe[]" id="informe" class="form-control form-control-sm"> <option value="" selected="selected">--Seleccionar--</option> <option value="1">Si</option> <option value="0">No</option> </select>'
    
    
    var estado_beneficiario = '<select name="estado_beneficiario[]" id="estado_beneficiario" class="form-control form-control-sm"><option value="">--Selecionar--</option><?php foreach ($estado_concepto as $row) {?> <option value="<?php echo $row->codigo?>" <?php if($row->codigo==$beneficiario->id_estado_beneficiario)echo "selected='selected'"?>><?php echo $row->denominacion?></option> <?php } ?> </select>'
   
    /*if(estado_beneficiario==1){
      n_beneficiario_vigente++
    }*/

    nuevoContenido +='<div class="form-group">';
    //nuevoContenido += '<label class="control-label form-control-sm">Fila ' + n + '</label>';
    nuevoContenido += '<div class="row">';
    nuevoContenido += '<div class="col-lg-2">' + '<div class="form-group">' + etiqueta_dni_beneficiario;
    nuevoContenido += dni_beneficiario;
    nuevoContenido += '</div>';
    nuevoContenido += '</div>';
    nuevoContenido += '<div class="col-lg-2">' + '<div class="form-group">' + etiqueta_apellidoP_beneficiario;
    nuevoContenido += apellidoP_beneficiario;
    nuevoContenido += '</div>';
    nuevoContenido += '</div>';
    nuevoContenido += '<div class="col-lg-2">' + '<div class="form-group">' + etiqueta_apellidoM_beneficiario;
    nuevoContenido += apellidoM_beneficiario;
    nuevoContenido += '</div>';
    nuevoContenido += '</div>';
    //nuevoContenido += '<div class="row">';
    nuevoContenido += '<div class="col-lg-4">' + '<div class="form-group">' + etiqueta_nombres_beneficiario;
    nuevoContenido += nombres_beneficiario;
    nuevoContenido += '</div>';
    nuevoContenido += '</div>';
    nuevoContenido += '<div class="col-lg-2">' + '<div class="form-group">' + etiqueta_estado_beneficiario;
    nuevoContenido += estado_beneficiario;
    nuevoContenido += '</div>';
    nuevoContenido += '</div>';
    nuevoContenido += '</div>';
    nuevoContenido += '</div>';
      //$('#tblSesion tbody').append(newRow);
      if(estado_beneficiario.value=="1"){
      m++}
    //var estado_beneficiario_value = document.getElementById('estado_beneficiario').value;

    // Verificar si el valor seleccionado es '1' y luego incrementar la variable n_beneficiario_vigente
    /*if (estado_beneficiario_value == '1') {
        n_beneficiario_vigente++;
    }*/
  }
    //formulario += '</form>';
    nuevoContenido += '<input type="hidden" name="numero_vigente" id="numero_vigente" value="'+m+'">'
  $('#frmBeneficiario').html(nuevoContenido);

}

function obtener_empresa(){

  var ruc = $('#ruc').val();

  $.ajax({
      url: '/empresa/obtener_datos_empresa/'+ruc,
      dataType: "json",
      success: function(result){

					$('#razon_social').val(result.empresa.razon_social);
		}
    });

}


function obtener_profesional_($i){
	
  var numero_ = $i;

  var numero_documento_ = $('#dni_beneficiario'+ numero_).val();
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
            if (result.value) {
              var numero_documento_ = $('#dni_beneficiario'+ numero_).val();
              modal_personaNuevoBeneficiario(numero_documento_,numero_);
              /*$('#frmEmpresaBeneficiario').modal([
                backdrop:'static',
                keyboard: false
              ]);

              
                $('#frmPersona2').modal.('show');
         
              */
            }
          });
      
				}else{

					$('#apellidoP_beneficiario'+numero_).val(result.persona.apellido_paterno);
          $('#apellidoM_beneficiario'+numero_).val(result.persona.apellido_materno);
          $('#nombres_beneficiario'+numero_).val(result.persona.nombres);
				}
		}
    });
	
}

function obtener_profesional(){
	

  var numero_documento_ = $('#dni_beneficiario_edit').val();
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
            if (result.value) {
              var numero_documento_ = $('#dni_beneficiario_edit').val();
              modal_personaNuevoBeneficiarioEdit(numero_documento_);
              /*$('#frmEmpresaBeneficiario').modal([
                backdrop:'static',
                keyboard: false
              ]);

              
                $('#frmPersona2').modal.('show');
         
              */
            }
          });
      
				}else{

					$('#apellidoP_beneficiario_edit').val(result.persona.apellido_paterno);
          $('#apellidoM_beneficiario_edit').val(result.persona.apellido_materno);
          $('#nombres_beneficiario_edit').val(result.persona.nombres);
				}
		}
    });
	
}

function obtener_profesional_beneficiario($i){
	
  var numero_ = $i;

  var numero_documento_ = $('#dni_beneficiario'+ numero_).val();

  //var numero_documento_ = $('#dni').val();
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
            if (result.value) {
              var numero_documento_ = $('#dni_beneficiario'+ numero_).val();
              modal_personaNuevoBeneficiario(numero_documento_);
              /*$('#frmEmpresaBeneficiario').modal([
                backdrop:'static',
                keyboard: false
              ]);

              
                $('#frmPersona2').modal.('show');
         
              */
            }
          });
      
				}else{

					$('#apellidoP_beneficiario'+numero_).val(result.persona.apellido_paterno);
          $('#apellidoM_beneficiario'+numero_).val(result.persona.apellido_materno);
          $('#nombres_beneficiario'+numero_).val(result.persona.nombres);
          //$('#estado_beneficiario'+numero_).val(result.persona.nombres);
				}
		}
    });
	
}

function save_beneficiario(){
    
    var msg = "";
    var _token = $('#_token').val();
    var id = $('#id').val();
    var dni = $('#dni').val();
    var numero_beneficiario = $('#numero_beneficiario').val();
    var ruc = $('#ruc').val();
    var numero_vigente = $('#numero_vigente').val();
    var concepto = $('#concepto').val();
    var estado_beneficiario = $('#estado_beneficiario').val();
    var observacion = $('#observacion').val();
    
    //if(dni == "")msg += "Debe ingresar un DNI <br>";
    
      if(msg!=""){
          bootbox.alert(msg);
          return false;
      }
    
      $.ajax({
        url: "/beneficiario/send_beneficiario",
              type: "POST",
			  data : $("#frmEmpresaBeneficiario").serialize(),
			  /*
              data : {_token:_token,id:id,dni:dni,ruc:ruc,concepto:concepto,
              estado_beneficiario:estado_beneficiario,observacion:observacion},
			  */
              success: function (result) {
          
                $('#openOverlayOpc').modal('hide');
                //window.location.reload();
                datatablenew();
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

function modal_personaNuevoBeneficiario($dni,$i){

  var numero_ = $i;
  
  var dni = $('#dni_beneficiario'+ numero_).val();

  $('#dni_').val(dni);

  
  //alert(dni);exit();
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

function modal_personaNuevoBeneficiarioEdit($numero_documento_){


var dni = $('#dni_beneficiario_edit').val();

$('#dni_').val(dni);


//alert(dni);exit();
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
                <!--<input type="hidden" name="id_empresa" id="id_empresa" value="<?php //echo $empresa->id ?>">-->
                <input type="hidden" name="id_edit" id="id_edit" value="<?php echo $id ?>">
                
                
                  <div class="row">

                    <div class="col-lg-2">
                      <div class="form-group">
                        <label class="control-label form-control-sm">RUC</label>
                        <input name="ruc" id="ruc" type="text" class="form-control form-control-sm" value="<?php echo $empresa->ruc?>" onBlur="obtener_empresa()">
                          
                      </div>
                    </div>

                    <div class="col-lg-5">
                      <div class="form-group">
                        <label class="control-label form-control-sm">Raz&oacute;n Social</label>
                        <input name="razon_social" id="razon_social" type="text" class="form-control form-control-sm" value="<?php echo $empresa->razon_social?>" onBlur="" readonly='readonly'>
                          
                      </div>
                    </div>

                    <div class="col-lg-9">
                      <div class="form-group">
                        <label class="control-label form-control-sm">Concepto</label>
                        <select name="concepto" id="concepto" onChange="" class="form-control form-control-sm">
                          <option value="">--Selecionar--</option>
                          <?php
                          foreach ($concepto as $row) {?>
                            <option value="<?php echo $row->id?>" <?php if($row->id==$beneficiario->id_concepto)echo "selected='selected'"?>><?php echo $row->denominacion?></option>
                          <?php
                          }
                          ?>
                        </select>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-lg-2">
                      <div class="form-group" id='numero_beneficiario_'>
                        <label class="control-label form-control-sm">N&uacute;mero Beneficiarios</label>
                        <input id="numero_beneficiario" name="numero_beneficiario" class="form-control form-control-sm" value="<?php //echo $agremiado->id_situacion?>" type="text" onChange="AddFila()">
                        <input type="hidden" id="dni_" name="dni_" class="form-control form-control-sm" value="<?php //echo $agremiado->id_situacion?>" type="text">
                      </div>
                    </div>
                  </div>

                  <!--<div class="modal-body">-->
                    <div id="frmBeneficiario">
                     <!--<label class="control-label form-control-sm">aaaaaaa</label>-->
                    </div>
                    <div class="row">
                      <div class="col-lg-2">
                        <div class="form-group" id='dni_beneficiario_edit_'>
                          <label class="form-control-sm form-control-sm">DNI</label>
                          <input type="text" name="dni_beneficiario_edit" id="dni_beneficiario_edit" value="<?php echo $dni?>" placeholder="" class="form-control form-control-sm" onchange ="obtener_profesional()">
                        </div>
                      </div>
                      <div class="col-lg-2">
                        <div class="form-group" id='apellidoP_beneficiario_edit_'>
                          <label class="form-control-sm form-control-sm">Apellido Paterno</label>
                          <input id="apellidoP_beneficiario_edit" name="apellidoP_beneficiario_edit" class="form-control form-control-sm" value="" type="text" readonly>
                        </div>
                      </div>
                      <div class="col-lg-2">
                        <div class="form-group" id='apellidoM_beneficiario_edit_'>
                          <label class="form-control-sm form-control-sm">Apellido Materno</label>
                          <input id="apellidoM_beneficiario_edit" name="apellidoM_beneficiario_edit" class="form-control form-control-sm" value="" type="text" readonly>
                        </div>
                      </div>
                      <div class="col-lg-4">
                        <div class="form-group" id='nombres_beneficiario_edit_'>
                          <label class="form-control-sm form-control-sm">Nombres</label>
                          <input id="nombres_beneficiario_edit" name="nombres_beneficiario_edit" class="form-control form-control-sm" value="" type="text" readonly>
                        </div>
                      </div>
                      <div class="col-lg-2">
                        <div class="form-group" id='estado_beneficiario_edit_'>
                          <label class="form-control-sm form-control-sm">Estado</label>
                          <select name="estado_beneficiario_edit" id="estado_beneficiario_edit" class="form-control form-control-sm"><option value="">--Selecionar--</option><?php foreach ($estado_concepto as $row) {?> <option value="<?php echo $row->codigo?>" <?php if($row->codigo==$estado_beneficiario)echo "selected='selected'"?>><?php echo $row->denominacion?></option> <?php } ?> </select>
                        </div>
                      </div>
                    </div>
                  <!--</div>-->

                  <!--<div class="row">
                    <div class="col-lg-2">
                      <div class="form-group">
                        <label class="control-label form-control-sm">DNI</label>
                        <input name="dni" id="dni" type="text" class="form-control form-control-sm" value="<?php //echo $persona->numero_documento?>" onchange="obtener_profesional_()" >
                          
                      </div>
                    </div>
                  
                    <div class="col-lg-2">
                      <div class="form-group" style="padding-top:0px;padding-bottom:0px;margin-top:0px;margin-bottom:0px">
                        <label class="control-label form-control-sm">Apellido Paterno</label>
                        <input id="apellido_paterno" name="apellido_paterno" class="form-control form-control-sm" value="<?php //echo $persona->apellido_paterno ?>" type="text" readonly="readonly">
                      </div>
                    </div>

                    <div class="col-lg-2">
                      <div class="form-group" style="padding-top:0px;padding-bottom:0px;margin-top:0px;margin-bottom:0px">
                        <label class="control-label form-control-sm">Apellido Materno</label>
                        <input id="apellido_materno" name="apellido_materno" class="form-control form-control-sm" value="<?php //echo $persona->apellido_materno ?>" type="text" readonly="readonly">
                      </div>
                    </div>
                    
                      <div class="col-lg-4">
                        <div class="form-group" style="padding-top:0px;padding-bottom:0px;margin-top:0px;margin-bottom:0px">
                          <label class="control-label form-control-sm">Nombres</label>
                          <input id="nombres" name="nombres" class="form-control form-control-sm" value="<?php //echo $persona->nombres ?>" type="text" readonly="readonly">
                        </div>
                      </div>
                      <div class="col-lg-2">
                    
                      <div class="form-group">
                        <label class="control-label form-control-sm">Estado</label>
                        <select name="estado_beneficiario" id="estado_beneficiario" class="form-control form-control-sm">
                          --><!--<option value="">--Selecionar--</option>
                          <?php
                          //foreach ($estado_concepto as $row) {?>
                          <option value="<?php //echo $row->codigo?>" <?php //if($row->codigo==$beneficiario->id_estado_beneficiario)echo "selected='selected'"?>><?php //echo $row->denominacion?></option>
                          <?php
                          //}
                          ?>
                        </select>
                      </div>
                    </div>
                  </div>-->

                  <div class="row">
                    
                    <div class="col-lg-12">
                      <div class="form-group">
                        <label class="control-label form-control-sm">Observaci&oacute;n</label>
                        <textarea type="text" name="observacion" id="observacion" rows="2" placeholder="" class="form-control form-control-sm"><?php echo $beneficiario->observacion?></textarea>
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
                </div>
                </form>
            </div>
          </div>
        </div>
        </section>
      </div>

<script type="text/javascript">

$(document).ready(function () {

  //$("#concepto").select2({ width: '100%' });

  if($('#id_edit').val()==0){
    $('#dni_beneficiario_edit_').hide();
    $('#apellidoP_beneficiario_edit_').hide();
    $('#apellidoM_beneficiario_edit_').hide();
    $('#nombres_beneficiario_edit_').hide();
    $('#estado_beneficiario_edit_').hide();
  }else{
    $('#numero_beneficiario_').hide();
    obtener_profesional();
  }
  
	
});

</script>

