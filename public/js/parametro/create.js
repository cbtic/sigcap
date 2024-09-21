
$(document).ready(function () {

	$('#btnNuevo').on('click', function () {
		window.location.reload();
	});
	
	$('#btnGuardar').on('click', function () {
		guardar_parametro()
	});

	$('#btnNuevoParametro').on('click', function () {
		modalParametro(0);
	});
	
	$('#btnBuscar').click(function () {
		fn_ListarBusqueda();
	});
});


function guardar_parametro(){
    var msg = "";
	fn_save();
}

function fn_save(){
    
    $.ajax({
			url: "/agremiado/send",
            type: "POST",
            data : $("#frmExpediente").serialize(),
            success: function (result) {  
                    
					window.location.reload();
            }
    });
}


function datatablenew(){
    var oTable = $('#tblSolicitud').dataTable({
        "bServerSide": true,
        "sAjaxSource": "/empresa/listar_empresa_ajax",
        "bProcessing": true,
        "sPaginationType": "full_numbers",
        "bFilter": false,
        "bSort": false,
        "info": true,
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
			
			var nombre_py_bus = $('#nombre_py_bus').val();
			var detalle_py_bus = $('#detalle_py_bus').val();
			var estado = $('#estado').val();
			var estado_py = $('#estado_py_bus').val();
			
			var _token = $('#_token').val();
            oSettings.jqXHR = $.ajax({
				"dataType": 'json',
                "type": "POST",
                "url": sSource,
                "data":{NumeroPagina:iNroPagina,NumeroRegistros:iCantMostrar,
						nombre_py_bus:nombre_py_bus,detalle_py_bus:detalle_py_bus,
						estado:estado,estado_py:estado_py,
						_token:_token
                       },
                "success": function (result) {
                    fnCallback(result);
					
					//var moneda = result.aaData[0].moneda;
					//alert(moneda);
					
					
                },
                "error": function (msg, textStatus, errorThrown) {
                }
            });
        },
		"fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
			if (aData.moneda == "DOLARES") {
				$('td', nRow).addClass('verde');
			} 
		},
        "aoColumnDefs":
            [	
			 	{
                "mRender": function (data, type, row, meta) {	
                	var numero = "";
					if(row.numero!= null)numero = row.numero;
					return numero;
                },
                "bSortable": false,
                "aTargets": [0]
                },
				{
                "mRender": function (data, type, row) {
                	var anio = "";
					if(row.anio!= null)anio = row.anio;
					return anio;
                },
                "bSortable": false,
                "aTargets": [1],
				},
				{
                "mRender": function (data, type, row) {
					var glosa = "";
					if(row.glosa!= null)glosa = row.glosa;
					return glosa;
                },
                "bSortable": false,
                "aTargets": [2],
                },
				{
                "mRender": function (data, type, row) {
					var descripcion = "";
					if(row.descripcion!= null)descripcion = row.descripcion;
					return descripcion;
                },
                "bSortable": false,
                "aTargets": [3],
                },
				{
                "mRender": function (data, type, row) {
                    var departamento = "";
					if(row.departamento!= null)departamento = row.departamento;
					return departamento;
                },
                "bSortable": false,
                "aTargets": [4]
                },
                {
                "mRender": function (data, type, row) {
                	var provincia = "";
					if(row.provincia!= null)provincia = row.provincia;
					return provincia;
                },
                "bSortable": false,
                "aTargets": [5]
                },
				{
                "mRender": function (data, type, row) {
                	var distrito = "";
					if(row.distrito!= null)distrito = row.distrito;
					return distrito;
                },
                "bSortable": false,
                "aTargets": [6]
                },
				{
                "mRender": function (data, type, row) {
                	var distrito_judicial = "";
					if(row.distrito_judicial!= null)distrito_judicial = row.distrito_judicial;
					return distrito_judicial;
                },
                "bSortable": false,
                "aTargets": [7]
                },
				{
                "mRender": function (data, type, row) {
                	var organo_jurisdiccional = "";
					if(row.organo_jurisdiccional!= null)organo_jurisdiccional = row.organo_jurisdiccional;
					return organo_jurisdiccional;
                },
                "bSortable": false,
                "aTargets": [8]
                },
				{
                "mRender": function (data, type, row) {
                	var nombre_materia = "";
					if(row.nombre_materia!= null)nombre_materia = row.nombre_materia;
					return nombre_materia;
                },
                "bSortable": false,
                "aTargets": [9]
                },
				{
                "mRender": function (data, type, row) {
                	var estado_exp = "";
					if(row.estado_exp!= null)estado_exp = row.estado_exp;
					return estado_exp;
                },
                "bSortable": false,
                "aTargets": [10]
                },
				{
                "mRender": function (data, type, row) {
                	var nombre_py = "";
					if(row.nombre_py!= null)nombre_py = row.nombre_py;
					return nombre_py;
                },
                "bSortable": false,
                "aTargets": [11]
                },
				
            ]


    });
}

function fn_ListarBusqueda() {
    datatablenew();
};

function modalParametro(id){
	
	$(".modal-dialog").css("width","85%");
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
			url: "/parametro/modal_parametro_nuevoParametro/"+id,
			type: "GET",
			success: function (result) {
					$("#diveditpregOpc").html(result);
					$('#openOverlayOpc').modal('show');
			}
	});

}
