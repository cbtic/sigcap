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
	 
	 

});

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
	var id_regional = 5;
	var idagremiado =$('#idagremiado_').val();
	var fecha_sol =$('#fecha_r_').val();
	var fecha_emi =$('#fecha_e_').val();
	var validez=$('#vigencia_').val();
	var ev="";
	var codigo=$('#codigo_').val();
	var observaciones=$('#observacion_').val();
	var estado=1;
	var tipo=$('#id_tipo').val();
	
    $.ajax({
			url: "/certificado/send_certificado",
            type: "POST",
            data : {_token:_token,id:id,id_regional:id_regional,observaciones:observaciones,estado:estado,observaciones:observaciones,codigo:codigo,ev:ev,fecha_emi:fecha_emi,validez:validez,fecha_sol:fecha_sol,tipo:tipo,idagremiado:idagremiado},
			//dataType: 'json',
            success: function (result) {
				$('#openOverlayOpc').modal('hide');
				//window.location.reload();
				datatablenew();
								
            }
    });
}

function obtenerAgremiado(){

	var ncap=$('#cap_').val();

$.ajax({
	url: '/afiliacion_seguro/obtener_agremiado/'+ncap,
	dataType: "json",
	success: function(result){
		//alert(result);
		console.log(result);
		
		$('#idagremiado_').val(result.id);
		$('#nombre_').val(result.nombre_completo);
		$('#situacion_').val(result.situacion);
		
	}
});
}

function valida_pago(){
var idagremiado=$('#idagremiado_').val();
var serie=$('#serie_').val();
var numero=$('#numero_').val();
var concepto=1;

$.ajax({
url: '/certificado/valida_pago/'+idagremiado+"/"+serie+"/"+numero+"/"+concepto,
dataType: "json",
success: function(result){
	//alert(result);
	console.log(result);
	
	$('#fecha_e_').val(result.fecha_e);
	$('#vigencia_').val(result.vigencia);
	$('#codigo_').val(result.codigo);
	
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
				Edici&oacute;n de Certificados
			</div>
		
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:10px">
					
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<input type="hidden" name="id" id="id" value="<?php echo $id?>">
					
					<div class="row">
						
						<?php 
							$readonly=$id>0?"readonly='readonly'":'';
							$readonly_=$id>0?'':"readonly='readonly'";
						?>
						<div class="card-body" style="margin-top:1px;margin-bottom:1px">
							<div class="row">	
									<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
										<label class="control-label">CAP</label>
										<input id="cap_" name="cap_" class="form-control form-control-sm"  value="<?php  echo $id?>" type="text"  >							
										<a href="javascript:void(0)" onClick="obtenerAgremiado('<?php  echo $id?>')" class="btn btn-sm btn-success">Buscar</a>
									</div>
									<div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions">
										
								
									</div>
									
									<div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
										<label class="control-label">Apellidos y Nombres</label>
										<input id="nombre_" name="nombre_" class="form-control form-control-sm"  value="<?php echo $id?>" type="text" readonly  >
										<input id="idagremiado_" name="idagremiado_" class="form-control form-control-sm"  value="<?php echo $id?>" type="hidden"  readonly  >
									</div>
									<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
										<label class="control-label">Situaci&oacute;n</label>
										<input id="situacion_" name="situacion_" class="form-control form-control-sm"  value="<?php echo $id?>" type="text"  >
									</div>

								</div>
								<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
										<label class="control-label">Correo electr&oacute;nico</label>
										<input id="email_" name="email_" class="form-control form-control-sm"  value="<?php echo $id?>" type="text"  >
								</div>
						</div>
						
					
					<div style="margin-top:10px" class="form-group">
						<div class="col-sm-12 controls">
							<div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions">
								<a href="javascript:void(0)" onClick="fn_save()" class="btn btn-sm btn-success">Imprimir</a>
								<a href="javascript:void(0)" onClick="fn_save()" class="btn btn-sm btn-success">Enviar</a>
								
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

