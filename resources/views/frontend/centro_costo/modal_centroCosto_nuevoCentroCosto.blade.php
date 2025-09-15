<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<title>Sistema SIGCAP</title>

<style>

.datepicker,
.table-condensed {
  width: 250px;
  height:250px;
}


.modal-dialog {
	width: 100%;
	max-width:40%!important
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
  font-weight:bold;
}

#tablemodalm{
	
}

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

input:checked + .slider {
  background-color: #4cae4c;
}

input:focus + .slider {
  box-shadow: 0 0 1px #4cae4c;
}

input:checked + .slider:before {
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

.no {padding-right:3px;padding-left:0px;display:block;width:100px;float:left;font-size:14px;text-align:right;padding-top:5px}
.si {padding-right:0px;padding-left:3px;display:block;width:100px;float:left;font-size:14px;text-align:left;padding-top:5px}

</style>

<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" />


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js"></script>
<script type="text/javascript">

function valida(){

		var msg = "0";

		var _token = $('#_token').val();
		var id = $('#id').val();
		var denominacion = $('#denominacion').val();
    var tipo_plan_contable = $('#tipo_plan_contable').val();

		if (denominacion==""){
			msg= "Falta ingresar una Denominaci&oacute;n";
		}

    if (tipo_plan_contable==""){
			msg= "Falta ingresar un tipo de Plan Contable";
		}

		if (msg=="0"){
			fn_save_plan_contable()		
		}
		else {
			Swal.fire(msg);
		}

	}

function fn_save_plan_contable(){
    
	var _token = $('#_token').val();
	var id = $('#id').val();
	var denominacion = $('#denominacion').val();
  var cuenta = $('#cuenta').val();
  var tipo_plan_contable = $('#tipo_plan_contable').val();
	
    $.ajax({
			url: "/plan_contable/send_plan_contable_nuevoPlanContable",
            type: "POST",
            data : {_token:_token,id:id,denominacion:denominacion,cuenta:cuenta,tipo_plan_contable:tipo_plan_contable},
            success: function (result) {
				
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
				Registro Plan Contable
			</div>
			
            <div class="card-body">

			<div class="row">

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:5px;padding-bottom:20px">
					
					<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
					<input type="hidden" name="id" id="id" value="<?php echo $id?>">
					
					
					<div class="row" style="padding-left:10px">
						
						<div class="col-lg-12">
							<div class="form-group">
								<label class="control-label form-control-sm">Denominaci&oacute;n</label>
								<input id="denominacion" name="denominacion" on class="form-control form-control-sm"  value="<?php echo $plan_contable->denominacion?>" type="text" readonly="readonly">
							
							</div>
						</div>
					</div>

          <div class="row" style="padding-left:10px">
						
						<div class="col-lg-12">
							<div class="form-group">
								<label class="control-label form-control-sm">Cuenta</label>
								<input id="cuenta" name="cuenta" on class="form-control form-control-sm"  value="<?php echo $plan_contable->cuenta?>" type="text" readonly="readonly">
							
							</div>
						</div>
					</div>

          <div class="col-lg-5">
									<div class="form-group">
										<label class="control-label form-control-sm">Tipo Plan Contable</label>
										<select name="tipo_plan_contable" id="tipo_plan_contable" class="form-control form-control-sm" onChange="">
											<option value="">--Selecionar--</option>
											<?php
												foreach ($tipo_plan_contable as $row) {?>
												<option value="<?php echo $row->codigo?>" <?php if($row->codigo==$plan_contable->id_tipo)echo "selected='selected'"?>><?php echo $row->denominacion?></option>
												<?php
											}
											?>
										</select>
									</div>
								</div>

					<div style="margin-top:15px" class="form-group">
						<div class="col-sm-12 controls">
							<div class="btn-group btn-group-sm float-right" role="group" aria-label="Log Viewer Actions">
								<a href="javascript:void(0)" onClick="valida()" class="btn btn-sm btn-success">Guardar</a>
							</div>
												
						</div>
					</div> 
              </div>
          </div>
        </div>
          </div>
        </section>
    </div>
    