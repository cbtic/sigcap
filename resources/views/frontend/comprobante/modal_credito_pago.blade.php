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
	 
	//datatablenewPlan();

});

function datatablenewPlan(){
    var oTable1 = $('#tblPlan').dataTable({
        "bServerSide": true,
        "sAjaxSource": "/seguro/listar_plan",
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
			
			var id_seguro = $('#id_seguro').val();
			//var denominacion = $('#nombre').val();
			var estado = $('#estado').val();
			
			var _token = $('#_token').val();
            oSettings.jqXHR = $.ajax({
				"dataType": 'json',
                //"contentType": "application/json; charset=utf-8",
                "type": "POST",
                "url": sSource,
                "data":{NumeroPagina:iNroPagina,NumeroRegistros:iCantMostrar,
						id_seguro:id_seguro,estado:estado,
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
                	var fecha_inicio = "";
					if(row.fecha_inicio!= null)fecha_inicio = row.fecha_inicio;
					return fecha_inicio;
                },
                "bSortable": true,
                "aTargets": [3]
                },
				{
                "mRender": function (data, type, row) {
                	var fecha_fin = "";
					if(row.fecha_fin!= null)fecha_fin = row.fecha_fin;
					return fecha_fin;
                },
                "bSortable": true,
                "aTargets": [4]
                },
				{
                "mRender": function (data, type, row) {
                	var monto = "";
					if(row.monto!= null)monto = row.monto;
					return monto;
                },
                "bSortable": true,
                "aTargets": [5]
                },
				{
                "mRender": function (data, type, row) {
                	var moneda = "";
					if(row.moneda!= null)moneda = row.moneda;
					return moneda;
                },
                "bSortable": true,
                "aTargets": [6]
                },
				{
                "mRender": function (data, type, row) {
                	var edad_minima = "";
					if(row.edad_minima!= null)edad_minima = row.edad_minima;
					return edad_minima;
                },
                "bSortable": true,
                "aTargets": [7]
                },
				{
                "mRender": function (data, type, row) {
                	var edad_maxima = "";
					if(row.edad_maxima!= null)edad_maxima = row.edad_maxima;
					return edad_maxima;
                },
                "bSortable": true,
                "aTargets": [8]
                },
				{
                "mRender": function (data, type, row) {
                	var sexo = "";
					if(row.sexo!= null)sexo = row.sexo;
					return sexo;
                },
                "bSortable": true,
                "aTargets": [9]
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
					"aTargets": [10]
				},
				{
					"mRender": function (data, type, row) {
						
						var html = '<div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions">';
						html += '<button style="font-size:12px" type="button" class="btn btn-sm btn-success" data-toggle="modal" onclick="editarPlan('+row.id+')" ><i class="fa fa-edit"></i> Editar</button>';
						
						html += '<a href="javascript:void(0)" onclick=eliminarPlan('+row.id+') class="btn btn-sm btn-danger" style="font-size:12px;margin-left:10px">Eliminar</a>';
						
						html += '</div>';
						return html;
					},
					"bSortable": false,
					"aTargets": [11],
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
			$('#edad_minima').val(result.edad_minima);
			$('#edad_maxima').val(result.edad_maxima);
			$('#sexo').val(result.sexo);
			$('#parentesco').val(result.id_parentesco);
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
	$('#edad_minima').val("");
	$('#edad_maxima').val("");
	$('#sexo').val("");
	$('#parentesco').val("");
}

function fn_save(){
    
	var _token = $('#_token').val();
	var id = $('#id').val();
	var id_medio = $('#id_medio').val();
	var fecha = $('#fecha').val();
	var nro_operacion = $('#nro_operacion').val();	
	var monto =$('#monto').val();	

    $.ajax({
			url: "/comprobante/send_pago_credito",
            type: "POST",
            data : {_token:_token,id:id,id_medio:id_medio,fecha:fecha,nro_operacion:nro_operacion,monto:monto },
			success: function (result) {
				//$('#openOverlayOpc').modal('hide');
				//datatablenewPlan();
				//limpiar();
								
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
				Pago de Crédito
			</div>
			
            <div class="card-body">

			<div class="row">

            	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:10px">
					
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<input type="hidden" name="id_seguro" id="id_seguro" value="<?//php echo $id?>">
					<input type="hidden" name="id" id="id" value="0">

					<div class="row">
						<div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
							<label class="control-label">Medio</label>
						</div>
						<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
							<select name="id_medio" id="id_medio" class="form-control form-control-sm" onChange="">
								<option value="">--Selecionar--</option>

								<?php
								foreach ($medio_pago as $row) { ?>
									<option value="<?php echo $row->codigo ?>"> <?php echo $row->denominacion ?></option>
									
								<?php
								}
								?>

							</select>
						</div>

						<div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
							<label class="control-label">Monto</label>
						</div>
						<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
							<input id="monto" name="monto" class="form-control form-control-sm"  value="<?php //echo $seguro->descripcion?>" type="text"  >
						</div>

						<div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
							<label class="control-label">Nro Operación</label>
						</div>
						<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
							<input id="nro_operacion" name="nro_operacion" class="form-control form-control-sm"  value="<?php //echo $seguro->descripcion?>" type="text"  >
						</div>
						
						<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
							<label class="control-label">Fecha </label>
						</div>
						<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
							<input id="fecha" name="fecha" class="form-control form-control-sm"  value="<?php //echo $seguro->descripcion?>" type="date"  >
						</div>


					</div>
					
				
					<div style="margin-top:10px" class="form-group">
						<div class="col-sm-12 controls">
							<div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions">
								<a href="javascript:void(0)" onClick="fn_save()" class="btn btn-sm btn-primary">Guardar</a>
								
								<a href="javascript:void(0)" onClick="limpiar()" class="btn btn-sm btn-warning" style="margin-left:10px">Limpiar</a>
								
							</div>
												
						</div>
					</div> 
				</div> 
				
                <div class="card-body">				
                    <div class="table-responsive">
                    <table id="tblPlan" class="table table-hover table-sm">
                        <thead>
                        <tr style="font-size:13px">
                            <th>Id</th>
							<th>Fecha </th>
							<th>Medio Pago</th>                            
							<th>Nro Operacion</th>							
							<th>Monto</th>
                            <th>Acciones</th>
                        </tr>
                        </thead>
                        <tbody style="font-size:13px">
						<tbody style="font-size:13px">
							<?php foreach($lista as $row){?>
							<tr>
								<th><?php echo $row->id?></th>
								<th><?php echo $row->fecha?></th>
								<th><?php echo $row->denominacion?></th>
								<th><?php echo $row->nro_operacion?></th>
								<th><?php echo $row->monto?></th>
																
								<th>
								<div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions">
								<button style="font-size:12px" type="button" class="btn btn-sm btn-success" data-toggle="modal" onclick="modalEstudio(<?php echo $row->id?>)" ><i class="fa fa-edit"></i> Editar</button>
								<a href="javascript:void(0)" onclick="eliminarEstudio(<?php echo $row->id?>)" class="btn btn-sm btn-danger" style="font-size:12px;margin-left:10px">Eliminar</a>
								</div>
								</th>
							</tr>														
							<?php }?>
						</tbody>
						</tbody>
                    </table>
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

