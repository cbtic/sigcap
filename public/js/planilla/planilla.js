
$(document).ready(function () {
	
	$("#id_regional_bus").select2({ width: '100%' });
	
	$('#btnBuscar').click(function () {
		fn_ListarBusqueda();
	});
		
	$('#btnNuevo').click(function () {
		bootbox.confirm({ 
			size: "small",
			message: "&iquest;Esta seguro de generar el reporte?", 
			callback: function(result){
				if (result==true) {
					guardar_computo()
				}
			}
		});
	});
	
	
});

obtenerAnioPerido();

function obtenerAnioPerido(){
	
	var id_periodo = $('#id_periodo_bus').val();
	
	$.ajax({
		url: '/planilla/obtener_anio_periodo/'+id_periodo,
		dataType: "json",
		success: function(result){
			var option = "";
			$('#anio').html("");
			//option += "<option value='0'>--Seleccionar--</option>";
			$(result).each(function (ii, oo) {
				option += "<option value='"+oo.anio+"'>"+oo.anio+"</option>";
			});
			$('#anio').html(option);
		}
		
	});
	
}

function cargarPlanillaDelegado(){
       
	$("#divPlanilla").html("");
	$.ajax({
			//url: "/concurso/obtener_concurso_documento/"+id_concurso_inscripcion,
			url: "/planillaDelegado/obtener_planilla_delegado",
			data : $("#frmPlanilla").serialize(),
			type: "POST",
			success: function (result) {  
					$("#divPlanilla").html(result);
			}
	});

}

function generarPlanilla(){
	
	$.ajax({
			url: "/planilla/send_planilla_delegado",
			type: "POST",
			data : $("#frmPlanilla").serialize(),
			success: function (result) {
					
					if(result==false){
						bootbox.alert("Planilla ya esta registrado"); 
						return false;
					}
					
					cargarPlanillaDelegado();
			}
	});
	
}

