<title>Sistema de Felmo</title>

<style>/*
.table-fixed thead,
.table-fixed tfoot{
  width: 97%;
}

.table-fixed tbody {
  height: 230px;
  overflow-y: auto;
  width: 100%;
}

.table-fixed thead,
.table-fixed tbody,
.table-fixed tfoot,
.table-fixed tr,
.table-fixed td,
.table-fixed th {
  display: block;
}

.table-fixed tbody td,
.table-fixed thead > tr> th,
.table-fixed tfoot > tr> td{
  float: left;
  border-bottom-width: 0;
}
*/
/*****************/
.modal-dialog {
	min-width: 90%;
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

/*
tr:nth-child(2n) {
    background: none repeat scroll 0 0 #edebeb;
}  
*/

#tablemodalm{
	/*
	width: 30em;
	overflow-x: auto;
	white-space: nowrap;
	*/
	
	/*background-color: #fed9ff; 
      width: 600px; 
      height: 150px; 
      overflow-x: hidden;
      overflow-y: auto; 
      text-align: center; 
      padding: 20px;*/
}
</style>

<script type="text/javascript">

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

function guardarCita__(){
	alert("fdssf");
}

function guardarCita(id_medico,fecha_cita){
    
    var msg = "";
    var id_ipress = $('#id_ipress').val();
    var id_consultorio = $('#id_consultorio').val();
    var fecha_atencion = $('#fecha_atencion').val();
    var dni_beneficiario = $("#dni_beneficiario").val();
	//alert(id_ipress);
	if(dni_beneficiario == "")msg += "Debe ingresar el numero de documento <br>";
    if(id_ipress==""){msg+="Debe ingresar una Ipress<br>";}
    if(id_consultorio==""){msg+="Debe ingresar un Consultorio<br>";}
    if(fecha_atencion==""){msg+="Debe ingresar una fecha de atencion<br>";}
   
    if(msg!=""){
        bootbox.alert(msg); 
        return false;
    }
    else{
        fn_save_cita(id_medico,fecha_cita);
    }
}

function fn_save_cita(id_medico,fecha_cita){
    /*
	var tipodoc_beneficiario = $('#tipodoc_beneficiario').val();
	var nrodocafiliado = $('#nrodocafiliado').val();
	var nrodocafiliado = $('#nrodocafiliado').val();
    var id_ipress = $('#id_ipress').val();
    var id_consultorio = $('#id_consultorio').val();
	*/	
    var fecha_atencion_original = $('#fecha_atencion').val();
	
    $.ajax({
            url: "registrar_cita",
            type: "POST",
            //data:{id_medico:id_medico,id_ipress:id_ipress,id_consultorio:id_consultorio,fecha_atencion:fecha_cita},
			data : $("#frmCita").serialize()+"&id_medico="+id_medico+"&fecha_cita="+fecha_cita,
            success: function (result) {  
                    $('#openOverlayOpc').modal('hide');
                    //parent.$('#idMaestroPersona').val(result);
                    //parent.obtenerinformacionpersona();
					
					/*
					var date = new Date();
					var d = date.getDate();
					var m = date.getMonth();
					var y = date.getFullYear();
					fullCalendar();
					*/
					//$('#calendar').fullCalendar({ events: "cronograma_cita",    });
					$('#calendar').fullCalendar("refetchEvents");
					modalDelegar(fecha_atencion_original);

            }
    });
}


function validarLiquidacion() {
	
	var msg = "";
	var sw = true;
	
	var saldo_liquidado = $('#saldo_liquidado').val();
	var estado = $('#estado').val();
	
	if(saldo_liquidado == "")msg += "Debe ingresar un saldo liquidado <br>";
	if(estado == "")msg += "Debe ingresar una observacion <br>";
	
	if(msg!=""){
		bootbox.alert(msg);
		//return false;
	} else {
		//submitFrm();
		document.frmLiquidacion.submit();
	}
	return false;
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

            <div class="card-body" style="padding:5px!important;">

			<div class="row">

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			
					<div class="card">
                        <div class="card-header">
                            <strong>
                                Consulta de Facturas
                            </strong>
                        </div>
                        <div class="card-body">
						
							<div class="table-responsive overflow-auto" style="max-height: 670px;">
							
							<table id="tblValorizacionFactura" class="table table-hover table-sm">
								<thead>
								<tr style="font-size:13px">
									<th>Serie</th>
									<th>Nro.</th>
									<th>Tipo</th>
									<th>Fecha</th>
									<th>Ruc</th>
									<th>Raz&oacute;n Social</th>
									<th>Placa</th>
									<th>Afiliaci&oacute;n</th>
									<th>SubTotal</th>
									<th>IGV</th>
									<th>Total</th>
									<th>Estado</th>
									<th>Anulado</th>
									<th>Caja</th>
									<th>Usuario</th>
									<th class="text-right">Factura</th>
								</tr>
								</thead>
								<tbody>
								<?php 
								foreach($factura as $key=>$row):
									$fac_cod_tributario=$row->fac_cod_tributario;
									$fac_destinatario=$row->fac_destinatario;
									if($fac_cod_tributario=="")$fac_cod_tributario=$row->ruc;
									if($fac_destinatario=="")$fac_destinatario=$row->nombre_comercial;
								?>
								<tr style="font-size:13px">
									<td class="text-left"><?php echo $row->fac_serie?></td>
									<td class="text-left"><?php echo $row->fac_numero?></td>
									<td class="text-left"><?php echo $row->fac_tipo?></td>
									<td class="text-left"><?php echo $row->fac_fecha?></td>
									<td class="text-left"><?php echo $fac_cod_tributario?></td>
									<td class="text-left"><?php echo $fac_destinatario?></td>
									<td class="text-left"><?php echo $row->placa?></td>
									<td class="text-left"><?php echo $row->plan_denominacion?></td>
									<td class="text-right"><?php echo number_format($row->fac_subtotal,2)?></td>
									<td class="text-right"><?php echo number_format($row->fac_impuesto,2)?></td>
									<td class="text-right"><?php echo number_format($row->fac_total,2)?></td>
									<td class="text-center"><?php echo $row->fac_estado_pago?></td>
									<td class="text-center"><?php echo $row->fac_anulado?></td>
									<td class="text-left"><?php echo $row->caja?></td>
									<td class="text-left"><?php echo $row->usuario?></td>
									<td class="text-center">
									<div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions">
										<a href="/factura/<?php echo $row->id?>" class="btn btn-sm btn-success" target="_blank"><i class="fa fa-search"></i></a>
									</div>
									</td>
								</tr>
								<?php 		
								endforeach;
								?>
							</tbody>
							</table>
							</div><!--table-responsive-->
					
					
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
    
    