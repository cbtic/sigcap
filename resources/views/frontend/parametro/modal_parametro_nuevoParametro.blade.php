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


function fn_save_parametro(){
    
	var _token = $('#_token').val();
	var id = $('#id').val();
	var anio = $('#anio').val();
  var porcentaje_calculo_edificacion = $('#porcentaje_calculo_edificacion').val();
  var valor_minimo_edificaciones = $('#valor_minimo_edificaciones').val();
  var valor_metro_cuadrado_habilitacion_urbana = $('#valor_metro_cuadrado_habilitacion_urbana').val();
  var valor_minimo_hu = $('#valor_minimo_hu').val();
  var valor_maximo_hu = $('#valor_maximo_hu').val();
  var valor_uit = $('#valor_uit').val();
  var igv = $('#igv').val();
  var valor_rh = $('#valor_rh').val();
  
	
    $.ajax({
			url: "/parametro/send_parametro_nuevoParametro",
            type: "POST",
            data : {_token:_token,id:id,anio:anio,porcentaje_calculo_edificacion:porcentaje_calculo_edificacion,
            valor_metro_cuadrado_habilitacion_urbana:valor_metro_cuadrado_habilitacion_urbana,valor_minimo_edificaciones:valor_minimo_edificaciones,
            valor_minimo_hu:valor_minimo_hu,valor_maximo_hu:valor_maximo_hu,valor_uit:valor_uit,igv:igv,valor_rh:valor_rh},
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
				Registro Par&aacute;metro
			</div>
			
            <div class="card-body">

              <div class="row">

                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:5px;padding-bottom:20px">
                  
                  <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                  <input type="hidden" name="id" id="id" value="<?php echo $id?>">
                  
                  
                    <div class="row" style="padding:0px,10px,0px,10px">
                      
                      <div class="col-lg-3">
                        <div class="form-group">
                          <label class="control-label form-control-sm">Año</label>
                          <input id="anio" name="anio" on class="form-control form-control-sm"  value="<?php echo $parametro->anio?>" type="text" >
                        
                        </div>
                      </div>
                    </div>
                    <fieldset name="edificaciones" style="border:1px solid #A4A4A4; padding: 10px">
                      <legend class="control-label form-control-sm">Edificaciones</legend>
                      <div class="row" style="padding:0px,10px,0px,10px">

                        <div class="col-lg-6">
                          <div class="form-group">
                            <label class="control-label form-control-sm">% Calculo Edificacion</label>
                            <input id="porcentaje_calculo_edificacion" name="porcentaje_calculo_edificacion" on class="form-control form-control-sm"  value="<?php echo $parametro->porcentaje_calculo_edificacion?>" type="text" >
                          
                          </div>
                        </div>
                        <div class="col-lg-6">
                          <div class="form-group">
                            <label class="control-label form-control-sm">Valor M&iacute;nimo % de UIT - Edificaciones</label>
                            <input id="valor_minimo_edificaciones" name="valor_minimo_edificaciones" on class="form-control form-control-sm"  value="<?php echo $parametro->valor_minimo_edificaciones?>" type="text" >
                          
                          </div>
                        </div>
                      </div>
                    </fieldset>
                    <fieldset name="hu" style="border:1px solid #A4A4A4; padding: 10px">
                      <legend class="control-label form-control-sm">Habilitaci&oacute;n Urbana</legend>
                      <div class="row" style="padding:0px,10px,0px,10px">
                        <div class="col-lg-4">
                          <div class="form-group">
                            <label class="control-label form-control-sm">Valor m2 HU</label>
                            <input id="valor_metro_cuadrado_habilitacion_urbana" name="valor_metro_cuadrado_habilitacion_urbana" on class="form-control form-control-sm"  value="<?php echo $parametro->valor_metro_cuadrado_habilitacion_urbana?>" type="text" >
                          </div>
                        </div>
                        <div class="col-lg-4">
                          <div class="form-group">
                            <label class="control-label form-control-sm">Costo M&iacute;nimo - HU</label>
                            <input id="valor_minimo_hu" name="valor_minimo_hu" on class="form-control form-control-sm"  value="<?php echo $parametro->valor_minimo_hu?>" type="text" >
                          </div>
                        </div>
                        <div class="col-lg-4">
                          <div class="form-group">
                            <label class="control-label form-control-sm">Valor M&aacute;ximo Ha (m2) - HU</label>
                            <input id="valor_maximo_hu" name="valor_maximo_hu" on class="form-control form-control-sm"  value="<?php echo $parametro->valor_maximo_hu?>" type="text" >
                          </div>
                        </div>
                      </div>
                    </fieldset>
                    <div class="row" style="padding:0px,10px,0px,10px">
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label class="control-label form-control-sm">Valor UIT</label>
                          <input id="valor_uit" name="valor_uit" on class="form-control form-control-sm"  value="<?php echo $parametro->valor_uit?>" type="text" >
                        
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label class="control-label form-control-sm">IGV</label>
                          <input id="igv" name="igv" on class="form-control form-control-sm"  value="<?php echo $parametro->igv?>" type="text" >
                          </div>
                        </div>
                     
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label class="control-label form-control-sm">Aplica Tributo Mayor a (RH)</label>
                          <input id="valor_rh" name="valor_rh" on class="form-control form-control-sm"  value="<?php echo $parametro->monto_minimo_rh?>" type="text" >
                          </div>
                        </div>
                      </div>
                    </div>
                    
                    <div style="margin-top:15px" class="form-group">
                      <div class="col-sm-12 controls">
                        <div class="btn-group btn-group-sm float-right" role="group" aria-label="Log Viewer Actions">
                          <a href="javascript:void(0)" onClick="fn_save_parametro()" class="btn btn-sm btn-success">Guardar</a>
                        </div>
                                  
                      </div>
                    </div> 
                </div>
            </div>
          </div>
          </div>
        </section>
    </div>
    