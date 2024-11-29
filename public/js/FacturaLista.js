//alert("ok");
//jQuery.noConflict(true);

$(document).ready(function () {

	$('#btnBuscar').click(function () {
		fn_ListarBusqueda();
	});

    $('#btnNuevo').click(function () {
		modalFactura(0);
	});
    
	datatablenew();

	$("#plan_id").select2();
	$("#ubicacion_id").select2();

	$('#fecha_ini').datepicker({
        autoclose: true,
		format: 'dd-mm-yyyy',
		changeMonth: true,
		changeYear: true,
    });

	$('#fecha_fin').datepicker({
        autoclose: true,
        format: 'dd-mm-yyyy',
		changeMonth: true,
		changeYear: true,
    });

	$('#fecha_inicio_desde').datepicker({
        autoclose: true,
		format: 'dd-mm-yyyy',
		changeMonth: true,
		changeYear: true,
    });

	$('#fecha_inicio_hasta').datepicker({
        autoclose: true,
        format: 'dd-mm-yyyy',
		changeMonth: true,
		changeYear: true,
    });

	/*
    $('#tblAlquiler').dataTable({
    	"language": {
    	"emptyTable": "No se encontraron resultados"
    	}
	});
	*/
	/*
	$('#tblAlquiler').dataTable( {
            "language": {
                "sProcessing":     "Procesando...",
                "sLengthMenu":     "Mostrar _MENU_ registros",
                "sZeroRecords":    "No se encontraron resultados",
                "sEmptyTable":     "Ningun dato disponible en esta tabla",
                "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix":    "",
                "sSearch":         "Buscar:",
                "sUrl":            "",
                "sInfoThousands":  ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                        "sFirst":    "Primero",
                        "sLast":     "ultimo",
                        "sNext":     "Siguiente",
                        "sPrevious": "Anterior"
                },
                "oAria": {
                        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            }
        } );
	*/


	$(function() {
		$('#modalPersonaForm #apellido_paterno').keyup(function() {
			this.value = this.value.toLocaleUpperCase();
		});
	});
	$(function() {
		$('#modalPersonaForm #apellido_materno').keyup(function() {
			this.value = this.value.toLocaleUpperCase();
		});
	});
	$(function() {
		$('#modalPersonaForm #nombres').keyup(function() {
			this.value = this.value.toLocaleUpperCase();
		});
	});


	$(function() {
		$('#modalPersonaTitularForm #apellido_paterno').keyup(function() {
			this.value = this.value.toLocaleUpperCase();
		});
	});
	$(function() {
		$('#modalPersonaTitularForm #apellido_materno').keyup(function() {
			this.value = this.value.toLocaleUpperCase();
		});
	});
	$(function() {
		$('#modalPersonaTitularForm #nombres').keyup(function() {
			this.value = this.value.toLocaleUpperCase();
		});
	});
});





function datatablenew(){

    var oTable1 = $('#tblFactura').dataTable({
        "bServerSide": true,
        "sAjaxSource": "/comprobante/listar_comprobante",
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

			var fecha_ini = $('#fecha_ini').val();
            var fecha_fin = $('#fecha_fin').val();
			var tipo_documento = $('#tipo_documento').val();
            var serie = $('#serie').val();
            var numero = $('#numero').val();
            var razon_social = $('#razon_social').val();
            var estado_pago = $('#estado_pago').val();
            var anulado = $('#anulado').val();
            var total_b = $('#total_b').val();

            var caja_b = $('#id_caja').val();
            var usuario_b = $('#id_usuario').val();
            var medio_pago = $('#id_mediopago').val();

            
            var sunat = $('#sunat').val();
            var formapago = $('#id_formapago').val();
            var pdf = $('#pdf').val();
			var _token = $('#_token').val();
            oSettings.jqXHR = $.ajax({
				"dataType": 'json',
                //"contentType": "application/json; charset=utf-8",
                "type": "POST",
                "url": sSource,
                "data":{NumeroPagina:iNroPagina,NumeroRegistros:iCantMostrar,
						fecha_ini:fecha_ini,fecha_fin:fecha_fin,
						tipo_documento:tipo_documento, serie:serie, numero:numero, razon_social:razon_social, estado_pago:estado_pago, anulado:anulado, formapago:formapago,
                        sunat:sunat, pdf:pdf, total_b:total_b, caja_b:caja_b, usuario_b:usuario_b, medio_pago:medio_pago,  _token:_token
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
                	var serie = "";
					if(row.serie!= null)serie = row.serie;
					return serie;
                },
                "bSortable": false,
                "aTargets": [0],
				"className": "dt-center",
				//"className": 'control'
                },
				{
                "mRender": function (data, type, row) {
                    var numero = "";
					if(row.numero!= null)numero = row.numero;
					return numero;
                },
                "bSortable": false,
                "aTargets": [1]
                },
                {
                "mRender": function (data, type, row) {
					var tipo = "";
					if(row.tipo!= null)tipo = row.tipo;
					return tipo;
                },
                "bSortable": false,
                //"className": "dt-center",
                "aTargets": [2],
                },
                {
                    "mRender": function (data, type, row) {
                        var fecha = "";
                        if(row.fecha!= null)fecha = row.fecha;
                        return fecha;
                    },
                    "bSortable": false,
                    //"className": "dt-center",
                    "aTargets": [3],
                },
				{
                "mRender": function (data, type, row) {
                    var cod_tributario = "";
					if(row.cod_tributario!= null)cod_tributario = row.cod_tributario;
					return cod_tributario;
                },
                "bSortable": false,
                "aTargets": [4],
				"className": 'control'
                },
				{
                "mRender": function (data, type, row) {
                    var destinatario = "";
					if(row.destinatario!= null)destinatario = row.destinatario;
					return destinatario;
                },
                "bSortable": false,
                "aTargets": [5]
                },
/*
				{
                "mRender": function (data, type, row) {
                    var plan_denominacion = "";
					if(row.plan_denominacion!= null)plan_denominacion = row.plan_denominacion;
					return plan_denominacion;
                },
                "bSortable": false,
                "aTargets": [6]
                },
                */
				{
                "mRender": function (data, type, row) {
                    var subtotal = "";
					if(row.subtotal!= null)subtotal = parseFloat(row.subtotal).toFixed(2);
					return subtotal;
                },
                "bSortable": false,
                "className": "text-right",
                "aTargets": [6]
                },
				{
                "mRender": function (data, type, row) {
                    var impuesto = "";
					if(row.impuesto!= null)impuesto = parseFloat(row.impuesto).toFixed(2);
					return impuesto;
                },
                "bSortable": false,
                "className": "text-right",
                "aTargets": [7]
                },
				{
                "mRender": function (data, type, row) {
                    var total = "";
					if(row.total!= null)total = parseFloat(row.total).toFixed(2);
					return total;
                },
                "bSortable": false,
                "className": "text-right",
                "aTargets": [8]
                },
				{
                "mRender": function (data, type, row) {
                    var estado_pago = "";
					if(row.estado_pago!= null)estado_pago = row.estado_pago;
					return estado_pago;
                },
                "bSortable": false,
                "aTargets": [9]
                },
				{
                "mRender": function (data, type, row) {
                    var anulado = "";
					if(row.anulado!= null)anulado = row.anulado;
					return anulado;
                },
                "bSortable": false,
                "aTargets": [10]
                },
				{
                "mRender": function (data, type, row) {
                    var caja = "";
					if(row.caja!= null)caja = row.caja;
					return caja;
                },
                "bSortable": false,
                "aTargets": [11]
                },
                {
                "mRender": function (data, type, row) {
                    var usuario = "";
                    if(row.usuario!= null)usuario = row.usuario;
                    return usuario;
                },
                "bSortable": false,
                "aTargets": [12]
                },
                {
                    "mRender": function (data, type, row) {
                        var forma_pago = "";
                        if(row.forma_pago!= null)forma_pago = row.forma_pago;
                        return forma_pago;
                    },
                    "bSortable": false,
                    "aTargets": [13]
                },                    
				{
                    "mRender": function (data, type, row) {
                        var restante_credito = "";
                        var forma_pago = "";
                        if(row.forma_pago!= null)forma_pago = row.forma_pago;

                        if(forma_pago=="CREDITO"){
                            if(row.restante_credito!= null && forma_pago=="CREDITO")restante_credito = row.restante_credito;
                        }
                        return restante_credito;
                    },
                    "bSortable": false,
                    "className": "text-right",
                    "aTargets": [14]
                },
              
				{
                    "mRender": function (data, type, row) {
                        var sunat = "";
                        if(row.sunat!= null)
                        {
                            sunat = row.sunat;
                            return sunat;
                        }
                        else{
                            var today = new Date();
                            var dd = today.getDate();
                            var mm = today.getMonth()+1; 
                            var yyyy = today.getFullYear();

                            if(dd<10)dd='0'+dd;                             
                            
                            if(mm<10)mm='0'+mm;
                             
                            today = yyyy+'-'+mm+'-'+dd;

                            if ((row.tipo=="FT" || row.tipo=="BV"|| row.tipo=="NC"|| row.tipo=="ND")&&(row.fecha).slice(0, -9)==today){
                                var opcion="";
                                if (row.tipo=="FT" || row.tipo=="BV")opcion = "firmar";
                                if (row.tipo=="NC")opcion = "firmarNC";
                                if (row.tipo=="ND")opcion = "firmarND";
                                var html = '<div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions">';                                
                                html += '<a href="/comprobante/'+opcion+'/'+row.id+'" class="btn btn-sm btn-info" target="_blank"><i class="fa fa-paper-plane"></i></a>';
                                return html;
                            }
                            else{
                                return sunat;
                            }
                            
                        }
                        
                       
                    },
                    "bSortable": false,
                    "aTargets": [15]
                },              
				{
                    "mRender": function (data, type, row) {
                        var forma_pago = "";
                        if(row.forma_pago!= null)forma_pago = row.forma_pago;

                        if(forma_pago=="CREDITO"){
                            var html = '<div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions">';                       
                            html += '<button style="font-size:12px" type="button" class="btn btn-sm btn-warning" data-toggle="modal" onclick="modalCreditoPago('+row.id+')" ><i class="fa fa-edit"></i> </button>';
                        }else{
                            var html = '<div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions">';                                                   
                        }
                        return html;    


                    },
                    "bSortable": false,
                    "aTargets": [16],
                },                
				{
                    "mRender": function (data, type, row) {
                        var html = '<div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions">';
                        html += '<a href="/comprobante/'+row.id+'" class="btn btn-sm btn-success" target="_blank"><i class="fa fa-search"></i></a>';
                        return html;
                    },
                    "bSortable": false,
                    "aTargets": [17],
                },
                

            ]


    });

}

function fn_ListarBusqueda() {
    datatablenew();
};



function modalCreditoPago(id){
	
	$(".modal-dialog").css("width","85%");
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
			url: "/comprobante/credito_pago/"+id,
			type: "GET",
			success: function (result) {  
					$("#diveditpregOpc").html(result);
					$('#openOverlayOpc').modal('show');
			}
	});

}

function modalFactura(id){
	
	$(".modal-dialog").css("width","85%");
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
			url: "/factura/modal_factura/"+id,
			type: "GET",
			success: function (result) {  
					$("#diveditpregOpc").html(result);
					$('#openOverlayOpc').modal('show');
			}
	});

}

function reporteFactura(){


    var fecha_ini = $('#fecha_ini').val();
    var fecha_fin = $('#fecha_fin').val();
    var tipo_documento = $('#tipo_documento').val();
    var serie = $('#serie').val();
    var numero = $('#numero').val();
    var razon_social = $('#razon_social').val();
    var estado_pago = $('#estado_pago').val();
    var anulado = $('#anulado').val();
	if (fecha_ini == "")fecha_ini = 0;
    if (fecha_fin == "")fecha_fin = 0;
    if (tipo_documento == "") tipo_documento= 0;
    if (serie == "")serie = 0;
    if (numero == "")numero = 0;
    if (razon_social == "")razon_social = 0;
    if (estado_pago == "")estado_pago = 0;
    if (anulado == "")anulado = 0;
	location.href = '/factura/exportar_factura/'  + fecha_ini + '/' + fecha_fin + '/' + tipo_documento + '/'+ serie + '/'+ numero + '/'+  razon_social + '/'+ estado_pago + '/'+ anulado ;

}


function modalLiquidacion(id){

	$(".modal-dialog").css("width","80%");
	$('#openOverlayOpc').modal('show');
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
			url: "/ingreso/modal_liquidacion/"+id,
			type: "GET",
			success: function (result) {
					$("#diveditpregOpc").html(result);
			}
	});

}



