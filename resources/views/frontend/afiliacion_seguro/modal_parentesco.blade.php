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
	 
	datatablenewPlan();

});


function cargarPagos(){
       
	
	var tipo_documento = $("#tipo_documento").val();
	var persona_id = 0;
	if(tipo_documento=="RUC")persona_id = $('#id_ubicacion').val();
	else persona_id = $('#persona_id').val();
	
	$('#tblPago').dataTable().fnDestroy();
    $("#tblPago tbody").html("");
	$.ajax({
			//url: "/ingreso/obtener_pago/"+numero_documento,
			url: "/ingreso/obtener_pago/"+tipo_documento+"/"+persona_id,
			type: "GET",
			success: function (result) {  
					$("#tblPago").html(result);
					$('[data-toggle="tooltip"]').tooltip();
					
					$('#tblPago').DataTable({
						//"sPaginationType": "full_numbers",
						//"paging":false,
						"searching": false,
						"info": false,
						"bSort" : false,
						"dom": '<"top">rt<"bottom"flpi><"clear">',
						"language": {"url": "/js/Spanish.json"},
					});
							
			}
	});

}

function datatablenewPlan(){
	
	
	var id_agremiado =  $('#idagremiado_').val();
	var id_afiliacion =  $('#id_afiliacion').val();
	var id_seguro =  $('#id_seguro').val();
	
	
    $("#tblParentesco tbody").html("");
	$.ajax({
			url: "/afiliacion_seguro/obtener_parentesco/"+id_afiliacion+"/"+id_agremiado+"/"+id_seguro,
			type: "GET",
			success: function (result) {  
					$("#tblParentesco tbody").html(result);
			}
	});
}

function datatablenewPlan1(){
    var oTable1 = $('#tblParentesco').dataTable({
        "bServerSide": true,
        "sAjaxSource": "/afiliacion_seguro/listar_parentesco",
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
			
			var id_afilliacion = $('#idagremiado_').val();

			//print_r("dddddddddddd",id_afilliacion); exit();

			//var denominacion = $('#nombre').val();
			var estado = $('#estado').val();
			
			var _token = $('#_token').val();
            oSettings.jqXHR = $.ajax({
				"dataType": 'json',
                //"contentType": "application/json; charset=utf-8",
                "type": "POST",
                "url": sSource,
                "data":{NumeroPagina:iNroPagina,NumeroRegistros:iCantMostrar,
					id_afilliacion:id_afilliacion,estado:estado,
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
                	var id = "";
					if(row.id!= null)id = row.id;
					return id;
                },
                "bSortable": false,
                "aTargets": [0],
				"className": "dt-center",
				//"className": 'control'
                },
				
				{
                "mRender": function (data, type, row) {
                	var parentesco = "";
					if(row.parentesco!= null)parentesco = row.parentesco;
					return parentesco;
                },
                "bSortable": true,
                "aTargets": [1]
                },

				{
                "mRender": function (data, type, row) {
                	var nombre = "";
					if(row.nombre!= null)nombre = row.nombre;
					return nombre;
                },
                "bSortable": true,
                "aTargets": [2]
                },
				
				
				{
                "mRender": function (data, type, row) {
                	var sexo = "";
					if(row.sexo!= null)sexo = row.sexo;
					return sexo;
                },
                "bSortable": true,
                "aTargets": [3]
                },

				{
                "mRender": function (data, type, row) {
                	var edad = "";
					if(row.edad!= null)edad = row.edad;
					return edad;
                },
                "bSortable": true,
                "aTargets": [4]
                },
				
				{
					"mRender": function (data, type, row) {
						var estado = "";
						if(row.estado == 1){
							estado = "Activo";
						}
						if(row.estado == 0){
							estado = "Inactivo";
						}
						return estado;
					},
					"bSortable": false,
					"aTargets": [5]
				},
				
				{
					"mRender": function (data, type, row) {
						
						var html = '<div class="form-check form-switch">';
						html += '<input class="form-check-input"  onclick=fn_save_fila('+row.id+','+ row.id_familia +') type="checkbox" role="switch" id="check_" name="check_">';
						
						html += '</div>';
						return html;
					},
					"bSortable": false,
					"aTargets": [6],
				},

            ]


    });

}

function editarPlan(id){

	$.ajax({
		url: '/seguro/obtener_plan/'+id,
		dataType: "json",
		success: function(result){
			//alert(result);
			console.log(result);
			$('#id').val(result.id);
			$('#nombre_plan_').val(result.nombre);
			$('#descripcion_').val(result.descripcion);
			$('#fecha_inicio').val(result.fecha_inicio);
			$('#fecha_fin').val(result.fecha_fin);
			$('#monto').val(result.monto);
		}
		
	});

}

function eliminarPlan(id){
	
    bootbox.confirm({ 
        size: "small",
        message: "&iquest;Deseas eliminar el Plan?", 
        callback: function(result){
            if (result==true) {
                fn_eliminar_plan(id);
            }
        }
    });
    //$(".modal-dialog").css("width","30%");
}

function fn_eliminar_plan(id){
	
	$.ajax({
            url: "/seguro/eliminar_plan/"+id,
            type: "GET",
            success: function (result) {
				datatablenewPlan();
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
	$('#nombre_plan_').val("");
	$('#descripcion_').val("");
	$('#fecha_inicio').val("");	
	$('#fecha_fin').val("");
	$('#monto').val("");
}

function fn_save(){
	var _token = $('#_token').val();
	
	var mov = $('.mov:checked').length;

	var idafiliacion = $('#id_afiliacion').val();
	var id_agremiado = $('#id_agremiado').val();
	var id_plan = $('#id_plan').val();

	if(mov=="0")msg+="Debe seleccionar por lo menos a un familiar <br>";

    $.ajax({
			url: "/afiliacion_seguro/send_parentesco_fila",
            type: "POST",
            data : {_token:_token,id:id,idafiliacion:idafiliacion,id_agremiado:id_agremiado,idfamilia:idfamilia},
			success: function (result) {
				//$('#openOverlayOpc').modal('hide');
				datatablenewPlan();
				limpiar();
								
            }
    });
}

function Guardar() {

	var msg = "";
	var mov = $('.mov:checked').length;
	//if(mov=="0")msg+="Debe seleccionar al menos un familiar <br>";

	if(msg!=""){
		bootbox.alert(msg);
	} else {
		//document.frmSeguroParentesco.submit();
		guardar_seguro_afiliado_parentesco();
	}
	return false;
}

function guardar_seguro_afiliado_parentesco() {

    $.ajax({
        url: "/afiliacion_seguro/send_seguro_afiliado_parentesco",
        type: "POST",
        data: $("#frmSeguroParentesco").serialize(),
        success: function(result) {
			//Limpiar();
            $('#openOverlayOpc').modal('hide');
			datatablenew();
			location.reload();
        }
    });
}


function fn_save_fila(id,idfamilia){
 
	var _token = $('#_token').val();
	
	var mov = $('.mov:checked').length;

	var idafiliacion = $('#id_afiliacion').val();
	var id_agremiado = $('#id_agremiado').val();
	var id_plan = $('#id_plan').val();

	if(mov=="0")msg+="Debe seleccionar por lo menos a un familiar <br>";

    $.ajax({
			url: "/afiliacion_seguro/send_parentesco_fila",
            type: "POST",
            data : {_token:_token,id:id,idafiliacion:idafiliacion,id_agremiado:id_agremiado,idfamilia:idfamilia},
			success: function (result) {
				//$('#openOverlayOpc').modal('hide');
				datatablenewPlan();
				limpiar();
								
            }
    });
	
}


</script>


<body class="hold-transition skin-blue sidebar-mini">

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
			
			<div class="card-header" style="padding:5px!important;padding-left:20px!important">
				Lista de Familiares
			</div>
			
            <div class="card-body">

			<div class="row">

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:10px">
				<form class="form-horizontal" method="post" action="{{ route('frontend.seguro.create')}}" id="frmSeguroParentesco" name="frmSeguroParentesco" autocomplete="off" >
					
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<input type="hidden" name="id_afiliacion" id="id_afiliacion" value="<?php echo $id?>">
					<input type="hidden" name="id" id="id" value="0">
					<input type="hidden" name="id_seguro" id="id_seguro" value="<?php echo $datos_seguro_agremiado->id_seguro?>">
					
					<div class="col-lg-5 col-md-12 col-sm-12 col-xs-12">
							<label class="control-label">Agremiado Titular</label>
					</div>

					<div class="row">
						
						<div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
							<label class="control-label">CAP</label>
						</div>
						<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
							<input id="cap_" name="cap_" class="form-control form-control-sm"  value="<?php echo $datos_seguro_agremiado->cap?>" type="textarea" readonly  >
						</div>
						<div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
							<label class="control-label">Agremiado</label>
						</div>
						<div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
							<input id="agremiado_" name="agremiado_" class="form-control form-control-sm"  value="<?php echo $datos_seguro_agremiado->agremiado?>" type="textarea" readonly   >
							<input id="idagremiado_" name="idagremiado_" class="form-control form-control-sm"  value="<?php echo $datos_seguro_agremiado->id_agremiado?>" type="hidden" readonly    >
						
						</div>

					</div>
					

					<div class="row">						
						<div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
							<label class="control-label">Seguro</label>
						</div>
						<div class="col-lg-5 col-md-12 col-sm-12 col-xs-12">
							<input id="seguro_" name="seguro_" class="form-control form-control-sm"  value="<?php echo $datos_seguro_agremiado->seguro?>" type="textarea" readonly   >
						</div>	
						<div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
							<label class="control-label">Plan</label>
						</div>
						<div class="col-lg-5 col-md-12 col-sm-12 col-xs-12">
							<input id="plan_" name="plan_" class="form-control form-control-sm"  value="<?php echo $datos_seguro_agremiado->plan?>" type="textarea" readonly   >
						</div>
				
					</div>

					<div class="row">						
												
						<div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
							<label class="control-label">F. ini.</label>
						</div>
						<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
							<input id="plan_" name="plan_" class="form-control form-control-sm"  value="<?php echo $datos_seguro_agremiado->fecha_inicio?>" type="textarea" readonly   >
						</div>
						
						<div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
							<label class="control-label">F. fin</label>
						</div>
						<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
							<input id="plan_" name="plan_" class="form-control form-control-sm"  value="<?php echo $datos_seguro_agremiado->fecha_fin?>" type="textarea" readonly   >
						</div>
						<div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
							<label class="control-label">Monto</label>
						</div>
						<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
							<input id="monto_" name="monto_" class="form-control form-control-sm"  value="<?php echo $datos_seguro_agremiado->monto?>" type="textarea" readonly   >
						</div>
					</div>

			
				
                <div class="card-body">				
					<div class="col-lg-5 col-md-12 col-sm-12 col-xs-12">
							<label class="control-label">Familiares</label>
					</div>
                    <div class="table-responsive">
                    <table id="tblParentesco" class="table table-hover table-sm">
                        <thead>
                        <tr style="font-size:13px">
							<th>Sel.</th>
							<th>Id</th>
                            <th>Parentesco</th>
							<th>Apellidos y nombres</th>
							<th>sexo</th>
							<th>Edad</th>
							<th>Plan</th>
							<th>Monto</th>
							<th>Moneda</th>
                            
                        </tr>
                        </thead>
                        <tbody style="font-size:13px">
											<?php  
											//$n = 0;
											//foreach($plan_seguro as $row){
												//if(!isset($row->msg)){
											?>
											<!--
											<tr>
												
												<td width="10%"><?php //echo $row->id?></td>
												<td width="30%"><?php //echo $row->nombre?></td>
												<td width="15%"><?php //echo $row->fecha_inicio?></td>
												<td width="15%"><?php //echo $row->fecha_fin?></td>
												<td width="10%"><?php //echo $row->monto?></td>												
												<td width="10%"><?php //echo $row->estado?></td>
												<td> <button style="font-size:12px" type="button" class="btn btn-sm btn-success" data-toggle="modal" onClick="modalSeguro('+row.id+')" ><i class="fa fa-edit"></i> Editar</button><d>
												
											</tr>
											<?php 
												//}else{
													
												//}
												//}	
											?>
											-->
										</tbody>
                    </table>
                </div>
				
					
					<div style="margin-top:10px" class="form-group">
						<div class="col-sm-12 controls">
							<div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions">
								<a href="javascript:void(0)" onClick="Guardar()" class="btn btn-sm btn-success">Guardar</a>
								
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

