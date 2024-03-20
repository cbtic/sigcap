//alert("ok");
//jQuery.noConflict(true);

$(document).ready(function () {
	
	$('#btnBuscar').click(function () {
		fn_ListarBusqueda();
	});

	$('#ruc').keypress(function(e){
		if(e.which == 13) {
			datatablenew();
		}
	});

	$('#razon_social').keypress(function(e){
		if(e.which == 13) {
			datatablenew();
		}
	});

	$('#dni').keypress(function(e){
		if(e.which == 13) {
			datatablenew();
		}
	});

	$('#agremiado').keypress(function(e){
		if(e.which == 13) {
			datatablenew();
		}
	});

	$('#estado').keypress(function(e){
		if(e.which == 13) {
			datatablenew();
			return false;
		}
	});
		
	$('#periodo').keypress(function(e){
		if(e.which == 13) {
			datatablenew();
			return false;
		}
	});

	$('#btnNuevo').click(function () {
		modalBeneficiario(0);
	});
		
	datatablenew();


	$(function() {
		$('#modalEmpresaForm #apellido_paterno').keyup(function() {
			this.value = this.value.toLocaleUpperCase();
		});
	});
	$(function() {
		$('#modalEmpresaForm #apellido_materno').keyup(function() {
			this.value = this.value.toLocaleUpperCase();
		});
	});
	$(function() {
		$('#modalEmpresaForm #nombres').keyup(function() {
			this.value = this.value.toLocaleUpperCase();
		});
	});


	$(function() {
		$('#modalEmpresaTitularForm #apellido_paterno').keyup(function() {
			this.value = this.value.toLocaleUpperCase();
		});
	});
	$(function() {
		$('#modalEmpresaTitularForm #apellido_materno').keyup(function() {
			this.value = this.value.toLocaleUpperCase();
		});
	});
	$(function() {
		$('#modalEmpresaTitularForm #nombres').keyup(function() {
			this.value = this.value.toLocaleUpperCase();
		});
	});
});


function validaTipoDocumento(){
	var tipo_documento = $("#tipo_documento").val();
	$('#nombre_afiliado').val("");
	$('#empresa_afiliado').val("");
	$('#empresa_direccion').val("");
	$('#empresa_representante').val("");
	$('#codigo_afiliado').val("");	
	$('#fecha_afiliado').val("");
				
	if(tipo_documento == "RUC"){
		$('#divNombreApellido').hide();
		$('#divCodigoAfliado').hide();
		$('#divFechaAfliado').hide();
		$('#divDireccionEmpresa').show();
		$('#divRepresentanteEmpresa').show();
	}else{
		$('#divNombreApellido').show();
		$('#divCodigoAfliado').show();
		$('#divFechaAfliado').show();
		$('#divDireccionEmpresa').hide();
		$('#divRepresentanteEmpresa').hide();
	}
}

function datatablenew(){
    var oTable1 = $('#tblAfiliado').dataTable({
        "bServerSide": true,
        "sAjaxSource": "/beneficiario/listar_beneficiario_ajax",
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
			
			var id = $('#id').val();
			var ruc = $('#ruc').val();
			var dni = $('#dni').val();
			var razon_social = $('#razon_social').val();
			var agremiado = $('#agremiado').val();
			var estado = $('#estado').val();
			var _token = $('#_token').val();
            oSettings.jqXHR = $.ajax({
				"dataType": 'json',
                //"contentType": "application/json; charset=utf-8",
                "type": "POST",
                "url": sSource,
                "data":{NumeroPagina:iNroPagina,NumeroRegistros:iCantMostrar,
						id:id,ruc:ruc,dni:dni,agremiado:agremiado,razon_social:razon_social,estado:estado,
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
                	var ruc = "";
					if(row.ruc!= null)ruc = row.ruc;
					return ruc;
                },
                "bSortable": false,
                "aTargets": [0],
				"className": "dt-center",
				//"className": 'control'
                },
				/*{
                "mRender": function (data, type, row) {
                    var nombre_comercial = "";
					if(row.nombre_comercial!= null)nombre_comercial = row.nombre_comercial;
					return nombre_comercial;
                },
                "bSortable": false,
                "aTargets": [1]
                },*/
                {
                "mRender": function (data, type, row) {
                	var razon_social = "";
					if(row.razon_social!= null)razon_social = row.razon_social;
					return razon_social;
                },
                "bSortable": false,
                "aTargets": [1],
				"className": "dt-center",
                },
				{
				"mRender": function (data, type, row) {
					var numero_documento = "";
					if(row.numero_documento!= null)numero_documento = row.numero_documento;
					return numero_documento;
				},
				"bSortable": false,
				"aTargets": [2]
				},
				{
					"mRender": function (data, type, row) {
						var agremiado = "";
						if(row.agremiado!= null)agremiado = row.agremiado;
						return agremiado;
					},
					"bSortable": false,
					"aTargets": [3]
				},
				{
					"mRender": function (data, type, row) {
						var sexo = "";
						if(row.sexo!= null)sexo = row.sexo;
						return sexo;
					},
					"bSortable": false,
					"aTargets": [4]
				},
				{
					"mRender": function (data, type, row) {
						var fecha_nacimiento = "";
						if(row.fecha_nacimiento!= null)fecha_nacimiento = row.fecha_nacimiento;
						return fecha_nacimiento;
					},
					"bSortable": false,
					"aTargets": [5]
				},
				{
					"mRender": function (data, type, row) {
						var concepto = "";
						if(row.concepto!= null)concepto = row.concepto;
						return concepto;
					},
					"bSortable": false,
					"aTargets": [6]
				},
				{
					"mRender": function (data, type, row) {
						var estado_beneficiario = "";
						if(row.estado_beneficiario!= null)estado_beneficiario = row.estado_beneficiario;
						return estado_beneficiario;
					},
					"bSortable": false,
					"aTargets": [7]
				},
				{
					"mRender": function (data, type, row) {
						var estado = "";
						var clase = "";
						if(row.estado == 1){
							estado = "Eliminar";
							clase = "btn-danger";
						}
						if(row.estado == 0){
							estado = "Activar";
							clase = "btn-success";
						}
						
						var html = '<div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions">';
						html += '<button style="font-size:12px" type="button" class="btn btn-sm btn-success" data-toggle="modal" onclick="modalBeneficiario('+row.id+')" ><i class="fa fa-edit"></i> Editar</button>';
						html += '<a href="javascript:void(0)" onclick=eliminarBeneficiario('+row.id+','+row.estado+') class="btn btn-sm '+clase+'" style="font-size:12px;margin-left:10px">'+estado+'</a>';
						
						//html += '<a href="javascript:void(0)" onclick=modalResponsable('+row.id+') class="btn btn-sm btn-info" style="font-size:12px;margin-left:10px">Detalle Responsable</a>';
						
						html += '</div>';
						return html;
					},
					"bSortable": false,
					"aTargets": [8],
				},

            ]


    });

}

function fn_ListarBusqueda() {
    datatablenew();
};

function modalBeneficiario(id){
	
	$(".modal-dialog").css("width","85%");
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
			url: "/beneficiario/modal_beneficiario_/"+id,
			type: "GET",
			success: function (result) {  
					$("#diveditpregOpc").html(result);
					$('#openOverlayOpc').modal('show');
			}
	});

}

function eliminarBeneficiario(id,estado){
	var act_estado = "";
	if(estado==1){
		act_estado = "Eliminar";
		estado_=0;
	}
	if(estado==0){
		act_estado = "Activar";
		estado_=1;
	}
    bootbox.confirm({ 
        size: "small",
        message: "&iquest;Deseas "+act_estado+" el beneficiario?", 
        callback: function(result){
            if (result==true) {
                fn_eliminar_beneficiario(id,estado_);
            }
        }
    });
    $(".modal-dialog").css("width","30%");
}

function fn_eliminar_beneficiario(id,estado){
	
	//alert(id,estado);
    $.ajax({
            url: "/beneficiario/eliminar_beneficiario/"+id+"/"+estado,
            type: "GET",
            success: function (result) {
                //if(result="success")obtenerPlanDetalle(id_plan);
				datatablenew();
            }
    });
}

