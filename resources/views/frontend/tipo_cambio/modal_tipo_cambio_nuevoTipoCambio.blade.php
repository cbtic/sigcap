<title>Sistema SIGCAP</title>

<style>

.datepicker,
.table-condensed {
  width: 250px;
  height:250px;
}


.modal-dialog {
	width: 100%;
	max-width:30%!important
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


function fn_save_tipo_cambio(){
    
	var _token = $('#_token').val();
	var id = $('#id').val();
	var fecha = $('#fecha').val();
  var valor_compra = $('#valor_compra').val();
  var valor_venta = $('#valor_venta').val();
  
    $.ajax({
			url: "/tipo_cambio/send_tipo_cambio_nuevoTipoCambio",
            type: "POST",
            data : {_token:_token,id:id,fecha:fecha,valor_compra:valor_compra,valor_venta:valor_venta},
            success: function (result) {
				
              $('#openOverlayOpc').modal('hide');
              window.location.reload();

            }
    });
}

$(document).ready(function () {

  $('#fecha').datepicker({
        autoclose: true,
		format: 'dd-mm-yyyy',
		changeMonth: true,
		changeYear: true,
  });

});
</script>


<body class="hold-transition skin-blue sidebar-mini">

	<div class="panel-heading close-heading">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    </div>

    <div>
		<div class="justify-content-center">		

		<div class="card">
			
			<div class="card-header" style="padding:5px!important;padding-left:20px!important; font-weight: bold">
				Registro Tipo Cambio
			</div>
			
            <div class="card-body">

              <div class="row">

                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:5px;padding-bottom:20px">
                  
                  <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                  <input type="hidden" name="id" id="id" value="<?php echo $id?>">
                  
                  
                    <div class="row" style="padding:0px,10px,0px,10px">
                      
                      <div class="col-lg-3">
                        <div class="form-group">
                          <label class="control-label form-control-sm">Fecha</label>
                          <input id="fecha" name="fecha" on class="form-control form-control-sm"  value="<?php echo isset($tipo_cambio->fecha) ? date('d-m-Y', strtotime($tipo_cambio->fecha)) : date('d-m-Y');?>" type="text" >
                        </div>
                      </div>
                    </div>
                    <div class="row" style="padding:0px,10px,0px,10px">
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label class="control-label form-control-sm">Valor Venta</label>
                          <input id="valor_venta" name="valor_venta" on class="form-control form-control-sm"  value="<?php echo isset($tipo_cambio->valor_venta) ? number_format($tipo_cambio->valor_venta, 3, '.', ',') : ''?>" type="text" >
                        
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label class="control-label form-control-sm">Valor Compra</label>
                          <input id="valor_compra" name="valor_compra" on class="form-control form-control-sm"  value="<?php echo isset($tipo_cambio->valor_compra) ? number_format($tipo_cambio->valor_compra, 3, '.', ',') : ''?>" type="text" >
                        
                        </div>
                      </div>
                    </div>
                    
                    <div style="margin-top:15px" class="form-group">
                      <div class="col-sm-12 controls">
                        <div class="btn-group btn-group-sm float-right" role="group" aria-label="Log Viewer Actions">
                          <a href="javascript:void(0)" onClick="fn_save_tipo_cambio()" class="btn btn-sm btn-success">Guardar</a>
                        </div>
                                  
                      </div>
                    </div> 
                </div>
            </div>
          </div>
          </div>
        </section>
    </div>
    