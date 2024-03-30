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
     $('#fecha').datepicker({
		format: "dd-mm-yyyy",
		autoclose: true,
		container: '#openOverlayOpc modal-body'
     });
	 
	 $('#fecha_inscripcion_inicio').datepicker({
		format: "dd-mm-yyyy",
		autoclose: true,
		container: '#openOverlayOpc modal-body'
     });
	 
	 $('#fecha_inscripcion_fin').datepicker({
		format: "dd-mm-yyyy",
		autoclose: true,
		container: '#openOverlayOpc modal-body'
     });
	 
	 $('#fecha_acreditacion_inicio').datepicker({
		format: "dd-mm-yyyy",
		autoclose: true,
		container: '#openOverlayOpc modal-body'
     });
	 
	 $('#fecha_acreditacion_fin').datepicker({
		format: "dd-mm-yyyy",
		autoclose: true,
		container: '#openOverlayOpc modal-body'
     });
	 
});

$(document).ready(function() {
	 
	 

});

var id_tipo_concurso = "<?php echo $concurso->id_tipo_concurso?>";
var id_sub_tipo_concurso = "<?php echo $concurso->id_sub_tipo_concurso?>";
//alert(id_tipo_concurso);

if(id_tipo_concurso>0){
	obtenerSubTipoConcursoEdit(id_tipo_concurso,id_sub_tipo_concurso);
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


function fn_save(){
    
	var _token = $('#_token').val();
	var id = $('#id').val();
	var id_tipo_concurso = $('#id_tipo_concurso').val();
	var id_sub_tipo_concurso = $('#id_sub_tipo_concurso').val();
	var periodo = $('#periodo').val();
	var fecha =$('#fecha').val();
	var fecha_inscripcion_inicio =$('#fecha_inscripcion_inicio').val();
	var fecha_inscripcion_fin =$('#fecha_inscripcion_fin').val();
	var fecha_acreditacion_inicio =$('#fecha_acreditacion_inicio').val();
	var fecha_acreditacion_fin =$('#fecha_acreditacion_fin').val();
	
    $.ajax({
			url: "/concurso/send_concurso",
            type: "POST",
            data : {_token:_token,id:id,id_tipo_concurso:id_tipo_concurso,id_sub_tipo_concurso:id_sub_tipo_concurso,periodo:periodo,fecha:fecha,fecha_inscripcion_inicio:fecha_inscripcion_inicio,fecha_inscripcion_fin:fecha_inscripcion_fin,fecha_acreditacion_inicio:fecha_acreditacion_inicio,fecha_acreditacion_fin:fecha_acreditacion_fin},
			//dataType: 'json',
            success: function (result) {
				$('#openOverlayOpc').modal('hide');
				//window.location.reload();
				datatablenew();
								
            }
    });
}

function obtenerSubTipoConcurso(){
	
	var id_tipo_concurso = $('#id_tipo_concurso').val();
	
	$.ajax({
		url: '/concurso/listar_maestro_by_tipo_subtipo/93/'+id_tipo_concurso,
		dataType: "json",
		success: function(result){
			var option = "<option value='0'>Seleccionar</option>";
			$("#id_sub_tipo_concurso").html("");
			$(result).each(function (ii, oo) {
				option += "<option value='"+oo.codigo+"'>"+oo.denominacion+"</option>";
			});
			$("#id_sub_tipo_concurso").html(option);
		}
		
	});
	
}

function obtenerSubTipoConcursoEdit(id_tipo_concurso,id_sub_tipo_concurso){
	
	//var id_tipo_concurso = $('#id_tipo_concurso').val();
	
	$.ajax({
		url: '/concurso/listar_maestro_by_tipo_subtipo/93/'+id_tipo_concurso,
		dataType: "json",
		success: function(result){
			var option = "<option value='0'>Seleccionar</option>";
			$("#id_sub_tipo_concurso").html("");
			var selected = "";
			$(result).each(function (ii, oo) {
				selected = "";
				if(id_sub_tipo_concurso == oo.codigo)selected = "selected='selected'";
				option += "<option value='"+oo.codigo+"' "+selected+" >"+oo.denominacion+"</option>";
			});
			$("#id_sub_tipo_concurso").html(option);
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
				Edici&oacute;n Concurso
			</div>
			
            <div class="card-body">

			<div class="row">

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:10px">
					
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<input type="hidden" name="id" id="id" value="<?php echo $id?>">
					
					
					<div class="row">
						
						<?php 
							$readonly=$id>0?"readonly='readonly'":'';
							$readonly_=$id>0?'':"readonly='readonly'";
						?>
						
						<div class="col-lg-6">
							<div class="form-group">
								<label class="control-label form-control-sm">Tipo Concurso</label>
								<select name="id_tipo_concurso" id="id_tipo_concurso" class="form-control form-control-sm" onChange="obtenerSubTipoConcurso()">
									<option value="">--Selecionar--</option>
									<?php
									foreach ($tipo_concurso as $row) {?>
									<option value="<?php echo $row->codigo?>" <?php if($row->codigo==$concurso->id_tipo_concurso)echo "selected='selected'"?>><?php echo $row->denominacion?></option>
									<?php 
									}
									?>
								</select>
							</div>
						</div>
						
						<div class="col-lg-6">
							<div class="form-group">
								<label class="control-label form-control-sm">SubTipo Concurso</label>
								<select name="id_sub_tipo_concurso" id="id_sub_tipo_concurso" class="form-control form-control-sm" onChange="">
									<option value="">--Selecionar--</option>
								</select>
							</div>
						</div>

						<div class="col-lg-6">
							<div class="form-group">
								<label class="control-label form-control-sm">Periodo</label>
								<?php 
								if($periodo_activo){
								?>
								<select name="periodo" id="periodo" class="form-control form-control-sm" onChange="" disabled="disabled">
									<option value="">--Selecionar--</option>
									<?php
									foreach ($periodo as $row) {?>
									<option value="<?php echo $row->id?>" <?php if($row->id==$periodo_activo->id)echo "selected='selected'"?>><?php echo $row->descripcion?></option>
									<?php 
									}
									?>
								</select>
								<?php
								}else{
								?>
								<select name="periodo" id="periodo" class="form-control form-control-sm" onChange="">
									<option value="">--Selecionar--</option>
									<?php
									foreach ($periodo as $row) {?>
									<option value="<?php echo $row->id?>" <?php 
									if($id==0 && $row->id==$periodo_ultimo->id)echo "selected='selected'";
									if($id>0 && $row->id==$concurso->id_periodo)echo "selected='selected'";
									?>><?php echo $row->descripcion?></option>
									<?php 
									}
									?>
								</select>
								<?php } ?>
							</div>
						</div>
						
						<div class="col-lg-6">
							<div class="form-group">
								<label class="control-label">Fecha Concurso</label>
								<input id="fecha" name="fecha" class="form-control form-control-sm"  value="<?php if($concurso->fecha!="")echo date('d/m/Y',strtotime($concurso->fecha))?>" type="text"  >
							</div>
						</div>

						<div class="col-lg-6">
							<div class="form-group">
								<label class="control-label">Fecha Inscripci&oacute;n Inicio</label>
								<input id="fecha_inscripcion_inicio" name="fecha_inscripcion_inicio" class="form-control form-control-sm"  value="<?php if($concurso->fecha_inscripcion_inicio!="")echo date('d-m-Y',strtotime($concurso->fecha_inscripcion_inicio))?>" type="text"  >
							</div>
						</div>
						
						<div class="col-lg-6">
							<div class="form-group">
								<label class="control-label">Fecha Inscripci&oacute;n Fin</label>
								<input id="fecha_inscripcion_fin" name="fecha_inscripcion_fin" class="form-control form-control-sm"  value="<?php if($concurso->fecha_inscripcion_fin!="")echo date('d-m-Y',strtotime($concurso->fecha_inscripcion_fin))?>" type="text"  >
							</div>
						</div>
						
						<div class="col-lg-6">
							<div class="form-group">
								<label class="control-label">Fecha Acreditaci&oacute;n Inicio</label>
								<input id="fecha_acreditacion_inicio" name="fecha_acreditacion_inicio" class="form-control form-control-sm"  value="<?php if($concurso->fecha_acreditacion_inicio!="")echo date('d-m-Y',strtotime($concurso->fecha_acreditacion_inicio))?>" type="text"  >
							</div>
						</div>
						
						<div class="col-lg-6">
							<div class="form-group">
								<label class="control-label">Fecha Acreditaci&oacute;n Fin</label>
								<input id="fecha_acreditacion_fin" name="fecha_acreditacion_fin" class="form-control form-control-sm"  value="<?php if($concurso->fecha_acreditacion_fin!="")echo date('d-m-Y',strtotime($concurso->fecha_acreditacion_fin))?>" type="text"  >
							</div>
						</div>
					
				
					</div>
					
					<div style="margin-top:10px" class="form-group">
						<div class="col-sm-12 controls">
							<div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions">
								<a href="javascript:void(0)" onClick="fn_save()" class="btn btn-sm btn-success">Guardar</a>
								
							</div>
												
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

