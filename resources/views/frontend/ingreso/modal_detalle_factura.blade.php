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


function buscarDetalleFactura(){

    var forma_pago = $('#forma_pago_bus').val();
    var estado_pago = $('#estado_pago_bus').val();
    var medio_pago = $('#medio_pago_bus').val();
    var id = $('#id').val();
    var total = $('#total_b').val();

    if(forma_pago==''){forma_pago=0}
    if(estado_pago==''){estado_pago=0}
    if(medio_pago==''){medio_pago=0}
    if(total==''){total=0}

    const tbody = $('#tblValorizacionFactura_');

    tbody.empty();

    let total_acumulado = 0;

    $.ajax({
            url: "/ingreso/obtener_detalle_factura/"+id+"/"+forma_pago+"/"+estado_pago+"/"+medio_pago+"/"+total,                        
            type: "GET",
            success: function (result) {  

                result.forEach(factura => {

                    const cod_tributario = factura.cod_tributario || factura.ruc;
                    const destinatario = factura.destinatario || factura.nombre_comercial;

                    const row = `
                       <tr style="font-size:13px">
                        <td class="text-left">${factura.serie}</td>
                        <td class="text-left">${factura.numero}</td>
                        <td class="text-left">${factura.tipo}</td>
                        <td class="text-left">${new Date(factura.fecha).toLocaleDateString('es-PE')}</td>
                        <td class="text-left">${cod_tributario}</td>
                        <td class="text-left">${destinatario}</td>
                        <td class="text-right">${parseFloat(factura.subtotal).toFixed(2)}</td>
                        <td class="text-right">${parseFloat(factura.impuesto).toFixed(2)}</td>
                        <td class="text-right">${parseFloat(factura.total).toFixed(2)}</td>
                        <td class="text-center">${factura.anulado}</td>
                        <td class="text-left">${factura.forma_pago}</td>
                        <td class="text-left">${factura.estado_pago}</td>
                        <td class="text-left">${factura.medio_pago}</td>
                        <td class="text-left">${factura.usuario}</td>
                        <td class="text-center">
                            <div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions">
                                <a href="/comprobante/${factura.id}" class="btn btn-sm btn-success" target="_blank">
                                    <i class="fa fa-search"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                `;
                    tbody.append(row);
                    total_acumulado += parseFloat(factura.total); 
                });

                const totalRow = `
                    <tr style="font-size:13px">
                        <td class="text-right">TOTAL:</td>
                        <td class="text-right">${total_acumulado.toFixed(2)}</td>
                    </tr>
                `;
                tbody.append(totalRow);
                        
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

function validarDecimal(input) {
    // Expresión regular para permitir solo números y un punto decimal
    var regex = /^[0-9]*\.?[0-9]*$/;
    
    // Verificar si el valor ingresado coincide con la expresión regular
    if (!regex.test(input.value)) {
        // Si no coincide, eliminar el último carácter ingresado
        input.value = input.value.slice(0, -1);
    }
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

                        <input type="hidden" name="id" id="id" value="<?php echo $id?>">

                        <div class="row">
                            <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <select name="forma_pago_bus" id="forma_pago_bus" class="form-control form-control-sm" onChange="">
                                        <option value="">--Selecionar Forma Pago--</option>
                                        <?php
                                        foreach ($forma_pago as $row) {?>
                                        <option value="<?php echo $row->codigo?>"><?php echo $row->denominacion?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                <select name="estado_pago_bus" id="estado_pago_bus" class="form-control form-control-sm">
                                    <option value="" selected="selected">--Seleccionar Estado Pago--</option>
                                    <option value="P">PENDIENTE</option>
                                    <option value="C">CANCELADO</option>
                                </select>
                            </div>

                            <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <select name="medio_pago_bus" id="medio_pago_bus" class="form-control form-control-sm" onChange="">
                                        <option value="">--Selecionar Medio Pago--</option>
                                        <?php
                                        foreach ($medio_pago as $row) {?>
                                        <option value="<?php echo $row->codigo?>"><?php echo $row->denominacion?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">                                    
                                    <input type="text" name="total_b" id="total_b" value="" oninput="validarDecimal(this)" placeholder="Total" class="form-control form-control-sm">
                                </div>
                            </div>

                            <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12" style="padding-right:0px">

                                <input class="btn btn-warning" value="Buscar" type="button" id="btnBuscar" onclick="buscarDetalleFactura()" />

                            </div>
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
									<th>SubTotal</th>
									<th>IGV</th>
									<th>Total</th>				
									<th>Anulado</th>
									<th>Forma Pago</th>
                                    <th>Estado Pago</th>
                                    <th>Medio Pago</th>
									<th>Usuario</th>
									<th class="text-right">Factura</th>
								</tr>
								</thead>
								<tbody id="tblValorizacionFactura_">
								<?php 
                                $total_acumulado = 0;
								foreach($factura as $key=>$row):
									$cod_tributario=$row->cod_tributario;
									$destinatario=$row->destinatario;
									if($cod_tributario=="")$cod_tributario=$row->ruc;
									if($destinatario=="")$destinatario=$row->nombre_comercial;
								?>
								<tr style="font-size:13px">
									<td class="text-left"><?php echo $row->serie?></td>
									<td class="text-left"><?php echo $row->numero?></td>
									<td class="text-left"><?php echo $row->tipo?></td>
									<td class="text-left"><?php echo date('d-m-Y', strtotime($row->fecha));?></td>
									<td class="text-left"><?php echo $cod_tributario?></td>
									<td class="text-left"><?php echo $destinatario?></td>
									<td class="text-right"><?php echo number_format($row->subtotal,2)?></td>
									<td class="text-right"><?php echo number_format($row->impuesto,2)?></td>
									<td class="text-right"><?php echo number_format($row->total,2)?></td>									
									<td class="text-center"><?php echo $row->anulado?></td>
									<td class="text-left"><?php echo $row->forma_pago?></td>
                                    <td class="text-left"><?php echo $row->estado_pago?></td>
                                    <td class="text-left"><?php echo $row->medio_pago?></td>

									<td class="text-left"><?php echo $row->usuario?></td>
									<td class="text-center">
									<div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions">
										<a href="/comprobante/<?php echo $row->id?>" class="btn btn-sm btn-success" target="_blank"><i class="fa fa-search"></i></a>
									</div>
									</td>
								</tr>
								<?php 
                                $total_acumulado += $row->total;
								endforeach;
								?>
                                <tr style="font-size:13px">
                                    <td class="text-right">TOTAL: </td>
                                    <td class="text-right"><?php echo number_format($total_acumulado,2)?></td>
                                </tr>
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
    
    