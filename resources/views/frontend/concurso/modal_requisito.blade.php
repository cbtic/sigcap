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
	 
	datatablenewRequisito();

	$(".upload").on('click', function() {
        var formData = new FormData();
        var files = $('#image')[0].files[0];
        formData.append('file',files);
        $.ajax({
			headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "/concurso/upload_documento_requisito",
            type: 'post',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response != 0) {
					var extension = "";
					//extension = response.split(".");
					//extension = split(".", limit).pop();;
					extension = response.substring(response.lastIndexOf('.') + 1);
					//alert(extension);
					//$("#img_ruta").attr("src", "/img/pdf.png");
					
					if(extension=="doc" || extension=="docx" || extension=="pdf" || extension=="xls" || extension=="xlsx"){
						$("#img_ruta").attr("src", "/img/check.png");
					}else{
                    	$("#img_ruta").attr("src", "/img/frontend/tmp_documento_requisito/"+response);
					}
					$("#img_foto").val(response);
                } else {
                    alert('Formato de imagen incorrecto.');
                }
            }
        });
        return false;
    });


});

function datatablenewRequisito(){
    var oTable1 = $('#tblPuesto').dataTable({
        "bServerSide": true,
        "sAjaxSource": "/concurso/listar_requisito",
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
			
			var id_concurso = $('#id_concurso').val();
			//var denominacion = $('#nombre').val();
			var estado = $('#estado').val();
			
			var _token = $('#_token').val();
            oSettings.jqXHR = $.ajax({
				"dataType": 'json',
                //"contentType": "application/json; charset=utf-8",
                "type": "POST",
                "url": sSource,
                "data":{NumeroPagina:iNroPagina,NumeroRegistros:iCantMostrar,
						id_concurso:id_concurso,estado:estado,
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
                	var tipo_documento = "";
					if(row.tipo_documento!= null)tipo_documento = row.tipo_documento;
					return tipo_documento;
                },
                "bSortable": true,
                "aTargets": [1]
                },
				
                {
                "mRender": function (data, type, row) {
                	var requisito = "";
					if(row.requisito!= null)requisito = row.requisito;
					return requisito;
                },
                "bSortable": true,
                "aTargets": [2]
                },
				
				{
                "mRender": function (data, type, row) {
                	var newRow = "";
					if(row.requisito_archivo!=null)newRow = '<a href="/img/documento_requisito/'+row.requisito_archivo+'" target="_blank" class="btn btn-sm btn-secondary">Ver Archivo</a>';
					return newRow;
                },
                "bSortable": true,
                "aTargets": [3]
                },
				
				{
					"mRender": function (data, type, row) {
						
						var html = '<div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions">';
						html += '<button style="font-size:12px" type="button" class="btn btn-sm btn-success" data-toggle="modal" onclick="editarRequisito('+row.id+')" ><i class="fa fa-edit"></i> Editar</button>';
						
						html += '<a href="javascript:void(0)" onclick=eliminarRequisito('+row.id+') class="btn btn-sm btn-danger" style="font-size:12px;margin-left:10px">Eliminar</a>';
						
						html += '</div>';
						return html;
					},
					"bSortable": false,
					"aTargets": [4],
				},

            ]


    });

}

function editarRequisito(id){

	$.ajax({
		url: '/concurso/obtener_requisito/'+id,
		dataType: "json",
		success: function(result){
			//alert(result);
			console.log(result);
			$('#id').val(result.id);
			$('#id_tipo_documento').val(result.id_tipo_documento);
			$('#denominacion').val(result.denominacion);
			
			var extension = "";
			extension = result.requisito_archivo.substring(result.requisito_archivo.lastIndexOf('.') + 1);
			if(extension=="doc" || extension=="docx" || extension=="pdf" || extension=="xls" || extension=="xlsx"){
						$("#img_ruta").attr("src", "/img/check.png");
			}else{
				$("#img_ruta").attr("src", "/img/frontend/tmp_documento_requisito/"+result.requisito_archivo);
			}
			$("#img_foto").val(result.requisito_archivo);
			
			
		}
		
	});

}

function eliminarRequisito(id){
	
    bootbox.confirm({ 
        size: "small",
        message: "&iquest;Deseas eliminar el Requisito?", 
        callback: function(result){
            if (result==true) {
                fn_eliminar_requisito(id);
            }
        }
    });
    //$(".modal-dialog").css("width","30%");
}

function fn_eliminar_requisito(id){
	
	$.ajax({
            url: "/concurso/eliminar_requisito/"+id,
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
	$("#img_ruta").attr("src", "/img/sin_imagen.jpg");
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
				Edici&oacute;n Requisito
			</div>
			
            <div class="card-body">

			<div class="row">

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:10px">
					
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<input type="hidden" name="id_concurso" id="id_concurso" value="<?php echo $id?>">
					<input type="hidden" name="id" id="id" value="0">
					
					<div class="row">
						<!--
						<div class="col-lg-1 col-md-12 col-sm-12 col-xs-12"> 
							<label class="control-label">Id</label>								
						</div>
						<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
							<input id="id_plan_" name="id_plan_" class="form-control form-control-sm"   type="text" readonly  >
						</div>
						-->
						<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
							<label class="control-label form-control-sm">Tipo Documento</label>
						</div>
						<div class="col-lg-7 col-md-12 col-sm-12 col-xs-12">
							<select name="id_tipo_documento" id="id_tipo_documento" class="form-control form-control-sm" onChange="">
								<option value="">--Selecionar--</option>
								<?php
								foreach ($tipo_documento as $row) {?>
								<option value="<?php echo $row->codigo?>" ><?php echo $row->denominacion?></option>
								<?php 
								}
								?>
							</select>
						</div>

					</div>

					<div class="row" style="padding-top:10px">
						
						<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
							<label class="control-label form-control-sm form-control-sm">Requisito</label>
						</div>
						<div class="col-lg-7 col-md-12 col-sm-12 col-xs-12">
							<input id="denominacion" name="denominacion" class="form-control form-control-sm"  value="" type="text"  >
						</div>
						
					</div>
					
					<div class="row" style="padding-top:10px">
					
					<div class="col-lg-12">
						<div class="form-group">
							
							<span class="btn btn-sm btn-warning btn-file">
								Examinar <input id="image" name="image" type="file" />
							</span>
							<input type="button" class="btn btn-sm btn-primary upload" value="Subir" style="margin-left:10px">
							<?php
							$img = "/img/sin_imagen.jpg";
							//if($inscripcionDocumento->ruta_archivo!="")$img="/img/documento/".$inscripcionDocumento->ruta_archivo;
							?>
							<img src="<?php echo $img?>" id="img_ruta" width="200px" height="150px" alt="" style="margin-top:10px" />
							<input type="hidden" id="img_foto" name="img_foto" value="" />
						</div>	
					</div>
					</div>
					
					<div style="margin-top:10px" class="form-group">
						<div class="col-sm-12 controls">
							<div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions">
								<a href="javascript:void(0)" onClick="fn_save_requisito()" class="btn btn-sm btn-primary">Guardar</a>
								
								<a href="javascript:void(0)" onClick="limpiar()" class="btn btn-sm btn-warning" style="margin-left:10px">Limpiar</a>
								
							</div>
												
						</div>
					</div> 
				
                <div class="card-body">				

                    <div class="table-responsive">
                    <table id="tblPuesto" class="table table-hover table-sm">
                        <thead>
                        <tr style="font-size:13px">
                            <th>Id</th>
                            <th>Tipo Documento</th>
							<th>Requisito</th>
							<th>Archivo</th>
							<th>Acciones</th>
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
				
					<!--
					<div style="margin-top:10px" class="form-group">
						<div class="col-sm-12 controls">
							<div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions">
								<a href="javascript:void(0)" onClick="fn_save()" class="btn btn-sm btn-success">Guardar</a>
								
							</div>
												
						</div>
					</div> 
					-->
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

