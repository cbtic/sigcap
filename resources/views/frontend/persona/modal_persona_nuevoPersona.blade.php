<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
		height: 250px;
	}


	.modal-dialog {
		width: 100%;
		max-width: 50% !important
	}

	#tablemodal {
		border-spacing: 0;
		display: flex;
		/*Se ajuste dinamicamente al tamano del dispositivo**/
		max-height: 80vh;
		/*El alto que necesitemos**/
		overflow-y: auto;
		/**El scroll verticalmente cuando sea necesario*/
		overflow-x: hidden;
		/*Sin scroll horizontal*/
		table-layout: fixed;
		/**Forzamos a que las filas tenga el mismo ancho**/
		width: 98vw;
		/*El ancho que necesitemos*/
		border: 1px solid #c4c0c9;
	}

	#tablemodal thead {
		background-color: #e2e3e5;
		position: fixed !important;
	}


	#tablemodal th {
		border-bottom: 1px solid #c4c0c9;
		border-right: 1px solid #c4c0c9;
	}

	#tablemodal th {
		font-weight: normal;
		margin: 0;
		max-width: 9.5vw;
		min-width: 9.5vw;
		word-wrap: break-word;
		font-size: 10px;
		font-weight: bold;
		height: 3.5vh !important;
		line-height: 12px;
		vertical-align: middle;
		/*height:20px;*/
		padding: 4px;
		border-right: 1px solid #c4c0c9;
	}

	#tablemodal td {
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

	.btn-file {
		position: relative;
		overflow: hidden;
	}

	.btn-file input[type=file] {
		position: absolute;
		top: 0;
		right: 0;
		min-width: 100%;
		min-height: 100%;
		font-size: 100px;
		text-align: right;
		filter: alpha(opacity=0);
		opacity: 0;
		outline: none;
		background: white;
		cursor: inherit;
		display: block;
	}

	.img_ruta {
		position: relative;
		float: left
	}

	.delete_ruta {
		background-image: url(img/delete.png);
		top: 0px;
		left: 110px;
		background-size: 100%;
		position: absolute;
		display: block;
		width: 30px;
		height: 30px;
		cursor: pointer
	}

	#tablemodal tbody tr:hover td,
	#tablemodal tbody tr:hover th {
		/*background-color: red!important;*/
		font-weight: bold;
		/*mix-blend-mode: difference;*/

	}

	#tablemodalm {}

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

	input:checked+.slider {
		background-color: #4cae4c;
	}

	input:focus+.slider {
		box-shadow: 0 0 1px #4cae4c;
	}

	input:checked+.slider:before {
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

	.no {
		padding-right: 3px;
		padding-left: 0px;
		display: block;
		width: 100px;
		float: left;
		font-size: 14px;
		text-align: right;
		padding-top: 5px
	}

	.si {
		padding-right: 0px;
		padding-left: 3px;
		display: block;
		width: 100px;
		float: left;
		font-size: 14px;
		text-align: left;
		padding-top: 5px
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js"></script>
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

		$('#ruc').blur(function() {
			var id = $('#id').val();
			if (id == 0) {
				validaRuc(this.value);
			}
			//validaRuc(this.value);
		});

	});
</script>

<script type="text/javascript">
	$('#openOverlayOpc').on('shown.bs.modal', function() {
		$('#fecha_egresado').datepicker({
			format: "dd-mm-yyyy",
			autoclose: true,
			container: '#openOverlayOpc modal-body'
		});
	});

	$('#openOverlayOpc').on('shown.bs.modal', function() {
		$('#fecha_graduado').datepicker({
			format: "dd-mm-yyyy",
			autoclose: true,
			container: '#openOverlayOpc modal-body'
		});
	});

	$(document).ready(function() {



	});

	function validacion() {

		var msg = "";
		var cobservaciones = $("#frmComentar #cobservaciones").val();

		if (cobservaciones == "") {
			msg += "Debe ingresar una Observacion <br>";
		}

		if (msg != "") {
			bootbox.alert(msg);
			return false;
		}
	}

	function validaRuc(ruc) {
		var settings = {
			"url": "https://apiperu.dev/api/ruc/" + ruc,
			"method": "GET",
			"timeout": 0,
			"headers": {
				"Authorization": "Bearer 20b6666ddda099db4204cf53854f8ca04d950a4eead89029e77999b0726181cb"
			},
		};

		$.ajax(settings).done(function(response) {
			console.log(response);

			if (response.success == true) {

				var data = response.data;

				$('#razon_social').val('')
				$('#direccion').val('')
				$('#nombre_comercial').val('')

				$('#razon_social').val(data.nombre_o_razon_social).attr('readonly', true);
				$('#nombre_comercial').val(data.nombre_o_razon_social).attr('readonly', true);
				//$('#direccion').attr('readonly', true);

				if (data.direccion_completa != "") {
					$('#direccion').val(data.direccion_completa).attr('readonly', true);
				} else {
					$('#direccion').attr('readonly', false);
				}

				//alert(data.direccion_completa);

			} else {
				Swal.fire("RUC Inv&aacute;lido. Revise el RUC digitado!");
				return false;
			}


		});
	}

	function guardarCita__() {
		alert("fdssf");
	}

	function guardarCita(id_medico, fecha_cita) {

		var msg = "";
		var id_ipress = $('#id_ipress').val();
		var id_consultorio = $('#id_consultorio').val();
		var fecha_atencion = $('#fecha_atencion').val();
		var dni_beneficiario = $("#dni_beneficiario").val();
		//alert(id_ipress);
		if (dni_beneficiario == "") msg += "Debe ingresar el numero de documento <br>";
		if (id_ipress == "") {
			msg += "Debe ingresar una Ipress<br>";
		}
		if (id_consultorio == "") {
			msg += "Debe ingresar un Consultorio<br>";
		}
		if (fecha_atencion == "") {
			msg += "Debe ingresar una fecha de atencion<br>";
		}

		if (msg != "") {
			bootbox.alert(msg);
			return false;
		} else {
			fn_save_cita(id_medico, fecha_cita);
		}
	}

	function fn_save_estudio() {

		var _token = $('#_token').val();
		var id = $('#id').val();
		var id_agremiado = $('#id_agremiado').val();
		var id_universidad = $('#id_universidad').val();
		var id_especialidad = $('#id_especialidad').val();
		var tesis = $('#tesis').val();
		var fecha_egresado = $('#fecha_egresado').val();
		var fecha_graduado = $('#fecha_graduado').val();
		var libro = $('#libro').val();
		var folio = $('#folio').val();

		//alert(id_agremiado);
		//return false;

		$.ajax({
			url: "/agremiado/send_agremiado_estudio",
			type: "POST",
			data: {
				_token: _token,
				id: id,
				id_agremiado: id_agremiado,
				id_universidad: id_universidad,
				id_especialidad: id_especialidad,
				tesis: tesis,
				fecha_egresado: fecha_egresado,
				fecha_graduado: fecha_graduado,
				libro: libro,
				folio: folio
			},
			success: function(result) {

				$('#openOverlayOpc').modal('hide');
				window.location.reload();

				/*
				$('#openOverlayOpc').modal('hide');
				if(result==1){
					bootbox.alert("La persona o empresa ya se encuentra registrado");
				}else{
					window.location.reload();
				}
				*/
			}
		});
	}

	function valida(){
		var msg = "0";

		var _token = $('#_token').val();
		var id = $('#id').val();
		var tipo_documento = $('#tipo_documento').val();
		var numero_documento = $('#numero_documento').val();
		var ruc = $('#ruc').val();
		var nombre = $('#nombre').val();
		var apellido_paterno = $('#apellido_paterno').val();
		var apellido_materno = $('#apellido_materno').val();
		var fecha_nacimiento = $('#fecha_nacimiento').val();
		var lugar_nacimiento = $('#lugar_nacimiento').val();
		var nacionalidad = $('#nacionalidad').val();
		var sexo = $('#sexo').val();
		var numero_celular = $('#numero_celular').val();
		var correo = $('#correo').val();
		var direccion = $('#direccion').val();

		if (tipo_documento==""){
			msg= "Falta seleccionar un Tipo de Documento";
		}else if (numero_documento==""){
			msg= "Falta ingresar una N&uacute;mero de Documento";
		}else if (nombre==""){
			msg= "Falta ingresar un Nombre";
		}else if (apellido_paterno==""){
			msg= "Falta ingresar un Apellido Paterno";
		}else if (apellido_materno==""){
			msg= "Falta ingresar un Apellido Materno";
		}else if (fecha_nacimiento==""){
			msg= "Falta seleccionar una Fecha de Nacimiento";
		}else if (lugar_nacimiento==""){
			msg= "Falta ingresar un Lugar de Nacimiento";
		}else if (nacionalidad==""){
			msg= "Falta seleccionar una Nacionalidad";
		}else if (sexo==""){
			msg= "Falta seleccionar un Sexo";
		}else if (numero_celular==""){
			msg= "Falta ingresar un N&uacute;mero de Celular";
		}else if (!validarCelular(numero_celular)) { 
			msg = "Ingrese un Número de Celular V&aacute;lido";
		}else if (correo==""){
			msg= "Falta ingresar un Correo";
		}else if (!validateEmail(correo)) {
        	msg = "Ingrese un Correo Electr&oacute;nico V&aacute;lida";
    	}else if (direccion==""){
			msg= "Falta ingresar una Direcci&oacute;n";
		}

		if (msg=="0"){
			fn_save_persona()		
		}
		else {
			Swal.fire(msg);
		}

	}

	function validateEmail(email) {
		var re = /\S+@\S+\.\S+/;
		return re.test(email);
	}

	function validarCelular(celular) {
		var re = /^\d{7,9}$/;
		return re.test(celular);
	}

	function fn_save_persona() {

		var msg = "";
		var _token = $('#_token').val();
		var id = $('#id').val();
		var tipo_documento = $('#tipo_documento').val();
		var numero_documento = $('#numero_documento').val();
		var nombre = $('#nombre').val();
		var apellido_paterno = $('#apellido_paterno').val();
		var apellido_materno = $('#apellido_materno').val();
		var fecha_nacimiento = $('#fecha_nacimiento').val();
		var grupo_sanguineo = $('#grupo_sanguineo').val();
		var lugar_nacimiento = $('#lugar_nacimiento').val();
		var nacionalidad = $('#nacionalidad').val();
		var sexo = $('#sexo').val();
		var numero_celular = $('#numero_celular').val();
		var correo = $('#correo').val();
		var direccion = $('#direccion').val();
		var img_foto = $('#img_foto').val();
		var ruc = $('#ruc').val();
		var id_ubigeo_nacimiento = $('#id_distrito_nacimiento').val();
/*
		if(result.sw==false){
			bootbox.alert("El DNI ingresado ya existe !!!");
			return false;
		}
		else{
			$.ajax({
			url: "/persona/send_persona_nuevoPersona",
			type: "POST",
			data: {
				_token: _token,
				id: id,
				tipo_documento: tipo_documento,
				numero_documento: numero_documento,
				nombre: nombre,
				apellido_paterno: apellido_paterno,
				apellido_materno: apellido_materno,
				fecha_nacimiento: fecha_nacimiento,
				grupo_sanguineo: grupo_sanguineo,
				lugar_nacimiento: lugar_nacimiento,
				nacionalidad: nacionalidad,
				sexo: sexo,
				numero_celular: numero_celular,
				correo: correo,
				direccion: direccion,
				img_foto: img_foto
			},
			dataType: 'json',
			success: function(result) {
				if(result.sw==false){
					bootbox.alert(result.msg);
					$('#openOverlayOpc').modal('hide');
				}else{
					$('#openOverlayOpc').modal('hide');
					window.location.reload();
				}
            }
		});
		}*/
		$.ajax({
			url: "/persona/send_persona_nuevoPersona",
			type: "POST",
			data: {
				_token: _token,
				id: id,
				tipo_documento: tipo_documento,
				numero_documento: numero_documento,
				nombre: nombre,
				apellido_paterno: apellido_paterno,
				apellido_materno: apellido_materno,
				fecha_nacimiento: fecha_nacimiento,
				grupo_sanguineo: grupo_sanguineo,
				lugar_nacimiento: lugar_nacimiento,
				nacionalidad: nacionalidad,
				sexo: sexo,
				numero_celular: numero_celular,
				correo: correo,
				direccion: direccion,
				img_foto: img_foto,
				ruc:ruc,
				id_ubigeo_nacimiento:id_ubigeo_nacimiento
			},
			dataType: 'json',
			success: function(result) {
				if(result.sw==false){
					Swal.fire("El DNI ingresado ya existe !!!");
					$('#openOverlayOpc').modal('hide');
				}else{
					$('#openOverlayOpc').modal('hide');
					window.location.reload();
				}
            }});
	}

	function fn_liberar(id) {

		//var id_estacionamiento = $('#id_estacionamiento').val();
		var _token = $('#_token').val();

		$.ajax({
			url: "/estacionamiento/liberar_asignacion_estacionamiento_vehiculo",
			type: "POST",
			data: {
				_token: _token,
				id: id
			},
			success: function(result) {
				$('#openOverlayOpc').modal('hide');
				cargarAsignarEstacionamiento();
			}
		});
	}

	function obtenerBeneficiario(){
		
		//var id_tipo_documento = $("#tipo_documento").val();
		var numero_documento = $("#numero_documento").val();
		var msg = "";

		//alert(tipo_documento);
		//alert(numero_documento);
		//exit();
		
		if (msg != "") {
			bootbox.alert(msg);
			return false;
		}

		if (numero_documento == "") {
			bootbox.alert(msg);
			return false;
		}

		
		$.ajax({
			url: '/persona/buscar_persona/'+ numero_documento,
			dataType: "json",
			success: function(result){
				
				if(result.sw==1){
					bootbox.alert("Se puede grabar");
				}

				if(result.sw==2){
					bootbox.alert("No es colaborador de CAP - Lima, los datos han sido obtenidos de Reniec");
				}
				if(result.sw==3){
					bootbox.alert("El numero de documento no se encontro en CAP - Lima ni en Reniec");
					return false;
				}
				

				var persona = result.persona;
				var persona_detalle = result.persona_detalle;
				//bootbox.alert("Datos recuperados ->" + persona.apellido_materno);
				
				var nombre = persona.apellido_paterno+" "+persona.apellido_materno+", "+persona.nombres;
				$('#nombres').val(nombre);
				$('#fecha_nacimiento').val(persona.fecha_nacimiento);
				$('#sexo').val(persona.sexo);
				$('#id').val(persona.id);
				$('#id_per_det').val(0);
				

				//$('#telefono_').val(persona_detalle.telefono);
				//$('#email_').val(persona_detalle.email);

				//$('#tipo_documento').attr("disabled",true);
				$('#numero_documento').attr("disabled",true);
			}	
		},
		{
			url: '/persona/buscar_persona/'+ numero_documento,
			dataType: "json",
			success: function(result){
				
				if(result.sw==2){
					bootbox.alert("No es colaborador de CAP - Lima, los datos han sido obtenidos de Reniec");
					//$('#telefono').attr("disabled",false);
					//$('#email').attr("disabled",false);
				}
				if(result.sw==3){
					bootbox.alert("El numero de documento no se encontro en CAP - Lima ni en Reniec");
					//$('#numero_documento').val("");
					
					/*
					$('#numero_documento').attr("disabled",false);
					$('#nombres').attr("disabled",false).attr("placeholder","Ingrese Nombres");
					
					$('#divApellidoP').show();
					$('#divApellidoM').show();
					
					$('#apellidop').attr("placeholder","Apellido Paterno");
					$('#apellidom').attr("placeholder","Apellido Materno");
					
					$('#telefono').attr("disabled",false);
					$('#email').attr("disabled",false);
					*/
					return false;
				}
				

				var persona = result.persona;
				var persona_detalle = result.persona_detalle;
				//bootbox.alert("Datos recuperados ->" + persona.apellido_materno);
				
				var nombre = persona.apellido_paterno+" "+persona.apellido_materno+", "+persona.nombres;
				$('#nombres').val(nombre);
				$('#fecha_nacimiento').val(persona.fecha_nacimiento);
				$('#sexo').val(persona.sexo);
				$('#id').val(persona.id);
				$('#id_per_det').val(0);
				

				//$('#telefono').val(persona_detalle.telefono);
				//$('#email').val(persona_detalle.email);

				//$('#tipo_documento').attr("disabled",true);
				//$('#numero_documento').attr("disabled",true);
			}	
		}
		);
		
	}

	function validarLiquidacion() {

		var msg = "";
		var sw = true;

		var saldo_liquidado = $('#saldo_liquidado').val();
		var estado = $('#estado').val();

		if (saldo_liquidado == "") msg += "Debe ingresar un saldo liquidado <br>";
		if (estado == "") msg += "Debe ingresar una observacion <br>";

		if (msg != "") {
			bootbox.alert(msg);
			//return false;
		} else {
			//submitFrm();
			document.frmLiquidacion.submit();
		}
		return false;
	}


	function obtenerVehiculo(id, obj) {

		//$("#tblPlan tbody text-white").attr('class','bg-primary text-white');
		if (obj != undefined) {
			$("#tblSinReservaEstacionamiento tbody tr").each(function(ii, oo) {
				var clase = $(this).attr("clase");
				$(this).attr('class', clase);
			});

			$(obj).attr('class', 'bg-success text-white');
		}
		//$('#tblPlanDetalle tbody').html("");
		$('#id_empresa').val(id);
		var id_estacionamiento = $('#id_estacionamiento').val();
		$.ajax({
			url: '/estacionamiento/obtener_vehiculo/' + id + '/' + id_estacionamiento,
			dataType: "json",
			success: function(result) {

				var newRow = "";
				$('#tblPlanDetalle').dataTable().fnDestroy(); //la destruimos
				$('#tblPlanDetalle tbody').html("");
				$(result).each(function(ii, oo) {
					newRow += "<tr class='normal'><td>" + oo.placa + "</td>";
					newRow += '<td class="text-left" style="padding:0px!important;margin:0px!important">';
					newRow += '<div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions">';
					newRow += '<a href="javascript:void(0)" onClick=fn_save("' + oo.id_vehiculo + '") class="btn btn-sm btn-normal">';
					newRow += '<i class="fa fa-2x fa-check" style="color:green"></i></a></a></div></td></tr>';
				});
				$('#tblPlanDetalle tbody').html(newRow);

				$('#tblPlanDetalle').DataTable({
					//"sPaginationType": "full_numbers",
					"paging": false,
					"dom": '<"top">rt<"bottom"flpi><"clear">',
					"language": {
						"url": "/js/Spanish.json"
					},
				});

				$("#system-search2").keyup(function() {
					var dataTable = $('#tblPlanDetalle').dataTable();
					dataTable.fnFilter(this.value);
				});

			}

		});

	}

	function cargar_tipo_proveedor() {

		var tipo_proveedor = 0;
		if ($('#tipo_proveedor_').is(":checked")) tipo_proveedor = 1;

		$("#divPersona").hide();
		$("#divEmpresa").hide();

		$("#empresa_").val("");
		$("#persona_").val("");

		$("#id_empresa").val("");
		$("#id_persona").val("");

		if (tipo_proveedor == 0) $("#divPersona").show();
		if (tipo_proveedor == 1) $("#divEmpresa").show();

	}

	$(document).ready(function() {
	
		var id_ubigeo = "<?php echo $persona->id_ubigeo_nacimiento?>";
		var idProvincia = id_ubigeo.substring(2,4);
		var idDistrito = id_ubigeo.substring(4,6);
				
		obtenerProvinciaNacimientoEdit(idProvincia);	 
		obtenerDistritoNacimientoEdit(idProvincia,idDistrito);
	
		$(".upload").on('click', function() {
			var formData = new FormData();
			var files = $('#image')[0].files[0];
			formData.append('file', files);
			$.ajax({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				url: "/persona/upload",
				type: 'post',
				data: formData,
				contentType: false,
				processData: false,
				success: function(response) {
					//alert(response);
					if (response != 0) {
						$("#img_ruta").attr("src", "/img/frontend/tmp_agremiado/" + response);
						//alert("/img/frontend/tmp_agremiado/" + response);
						$("#img_foto").val(response);
						//alert($("#img_foto").val());

					} else {
						alert('Formato de imagen incorrecto.');
					}
				}
			});
			return false;
		});

		$(".delete").on('click', function() {
			$("#img_ruta").attr("src", "/img/profile-icon.png");
			$("#img_foto").val("");
		});

	});

	function obtenerProvinciaNacimiento(){
	
		var id = $('#id_departamento_nacimiento').val();
		if(id=="")return false;
		$('#id_provincia_nacimiento').attr("disabled",true);
		$('#id_distrito_nacimiento').attr("disabled",true);
		
		var msgLoader = "";
		msgLoader = "Procesando, espere un momento por favor";
		var heightBrowser = $(window).width()/2;
		$('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
		$('.loader').show();
		
		$.ajax({
			url: '/agremiado/obtener_provincia/'+id,
			dataType: "json",
			success: function(result){
				var option = "<option value='' selected='selected'>Seleccionar</option>";
				$('#id_provincia_nacimiento').html("");
				$(result).each(function (ii, oo) {
					option += "<option value='"+oo.id_provincia+"'>"+oo.desc_ubigeo+"</option>";
				});
				$('#id_provincia_nacimiento').html(option);
				
				var option2 = "<option value=''>Seleccionar</option>";
				$('#id_distrito_nacimiento').html(option2);
				
				$('#id_provincia_nacimiento').attr("disabled",false);
				$('#id_distrito_nacimiento').attr("disabled",false);
				
				$('.loader').hide();
				
			}
			
		});
		
	}

	function obtenerDistritoNacimiento(){
		
		var id_departamento = $('#id_departamento_nacimiento').val();
		var id = $('#id_provincia_nacimiento').val();
		if(id=="")return false;
		$('#id_distrito_nacimiento').attr("disabled",true);
		
		var msgLoader = "";
		msgLoader = "Procesando, espere un momento por favor";
		var heightBrowser = $(window).width()/2;
		$('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
		$('.loader').show();
		
		$.ajax({
			url: '/agremiado/obtener_distrito/'+id_departamento+'/'+id,
			dataType: "json",
			success: function(result){
				var option = "<option value=''>Seleccionar</option>";
				$('#id_distrito_nacimiento').html("");
				$(result).each(function (ii, oo) {
					option += "<option value='"+oo.id_ubigeo+"'>"+oo.desc_ubigeo+"</option>";
				});
				$('#id_distrito_nacimiento').html(option);
				
				$('#id_distrito_nacimiento').attr("disabled",false);
				$('.loader').hide();
				
			}
			
		});
		
	}

	function obtenerProvinciaNacimientoEdit(idProvincia){
	
		var id = $('#id_departamento_nacimiento').val();
		if(id=="")return false;
		$('#id_provincia_nacimiento').attr("disabled",true);
		$('#id_distrito_nacimiento').attr("disabled",true);
		
		var msgLoader = "";
		msgLoader = "Procesando, espere un momento por favor";
		var heightBrowser = $(window).width()/2;
		$('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
		$('.loader').show();
		
		$.ajax({
			url: '/agremiado/obtener_provincia/'+id,
			dataType: "json",
			success: function(result){
				var option = "<option value='' selected='selected'>Seleccionar</option>";
				$('#id_provincia_nacimiento').html("");
				var selected = "";
				$(result).each(function (ii, oo) {
					selected = "";
					if(idProvincia == oo.id_provincia)selected = "selected='selected'";
					option += "<option value='"+oo.id_provincia+"' "+selected+" >"+oo.desc_ubigeo+"</option>";
				});
				$('#id_provincia_nacimiento').html(option);
				
				//var option2 = "<option value=''>Seleccionar</option>";
				//$('#id_distrito_nacimiento').html(option2);
				
				$('#id_provincia_nacimiento').attr("disabled",false);
				//$('#id_distrito_nacimiento').attr("disabled",false);
				
				$('.loader').hide();
				
			}
			
		});
		
	}

	function obtenerDistritoNacimientoEdit(idProvincia,idDistrito){
		//alert("ok");
		var id_departamento = $('#id_departamento_nacimiento').val();
		var id = idProvincia;
		if(id=="")return false;
		$('#id_distrito_nacimiento').attr("disabled",true);
		
		var msgLoader = "";
		msgLoader = "Procesando, espere un momento por favor";
		var heightBrowser = $(window).width()/2;
		$('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
		$('.loader').show();
		
		$.ajax({
			url: '/agremiado/obtener_distrito/'+id_departamento+'/'+id,
			dataType: "json",
			success: function(result){
				var option = "<option value=''>Seleccionar</option>";
				$('#id_distrito_nacimiento').html("");
				var selected = "";
				$(result).each(function (ii, oo) {
					selected = "";
					if(id_departamento+idProvincia+idDistrito == oo.id_ubigeo)selected = "selected='selected'";
					option += "<option value='"+oo.id_ubigeo+"' "+selected+" >"+oo.desc_ubigeo+"</option>";
				});
				$('#id_distrito_nacimiento').html(option);
				$('#id_distrito_nacimiento').attr("disabled",false);
				$('.loader').hide();
				
			}
			
		});
		
	}

	/*
	$('#fecha_solicitud').datepicker({
		autoclose: true,
		dateFormat: 'dd-mm-yy',
		changeMonth: true,
		changeYear: true,
		container: '#openOverlayOpc modal-body'
	});
	*/
	/*
	$('#fecha_solicitud').datepicker({
		format: "dd/mm/yyyy",
		startDate: "01-01-2015",
		endDate: "01-01-2020",
		todayBtn: "linked",
		autoclose: true,
		todayHighlight: true,
		container: '#openOverlayOpc modal-body'
	});
	*/

	/*				
	format: "dd/mm/yyyy",
	startDate: "01-01-2015",
	endDate: "01-01-2020",
	todayBtn: "linked",
	autoclose: true,
	todayHighlight: true,
	container: '#myModal modal-body'
	*/
</script>


<body class="hold-transition skin-blue sidebar-mini">

	<div class="panel-heading close-heading">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	</div>

	<div>
		<!--
        <section class="content-header">
          <h1>
            <small style="font-size: 20px">Programados del Medicos del dia <?php //echo $fecha_atencion
																			?></small>
          </h1>
        </section>
		-->
		<div class="justify-content-center">

			<div class="card">

				<div class="card-header" style="padding:5px!important;padding-left:20px!important; font-weight: bold">
					Registro Personas
				</div>

				<div class="card-body">

					<div class="row">
						<!--aaaa-->
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:5px;padding-bottom:20px">

							<form method="post" action="#" enctype="multipart/form-data">
								<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
								<input type="hidden" name="id" id="id" value="<?php echo $id ?>">


								<div class="row">
									<div class="col-lg-7">
										<div class="col-lg-7">
											<div class="form-group">
												<label class="control-label form-control-sm">Tipo Documento</label>
												<select name="tipo_documento" id="tipo_documento" class="form-control form-control-sm" onChange="">
													<option value="">--Selecionar--</option>
													<?php
													foreach ($tipo_documento as $row) { ?>
														<option value="<?php echo $row->codigo ?>" <?php if ($row->codigo == '78') echo "selected='selected'" ?>><?php echo $row->denominacion ?></option>
													<?php
													}
													?>
												</select>
											</div>
										</div>
										<div class="col-lg-7">
											<div class="form-group" style="padding-top:0px;padding-bottom:0px;margin-top:0px;margin-bottom:0px">
												<label class="control-label form-control-sm">N&uacute;mero Documento</label>
												<input id="numero_documento" name="numero_documento" class="form-control form-control-sm" value="<?php echo $persona->numero_documento ?>"  type="text">
											</div>
										</div>

										

										<div class="col-lg-7">
											<div class="form-group" style="padding-top:0px;padding-bottom:0px;margin-top:0px;margin-bottom:0px">
												<label class="control-label form-control-sm">RUC</label>
												<input id="ruc" name="ruc" class="form-control form-control-sm" value="<?php echo $persona->numero_ruc?>" type="text">
											</div>
										</div>

									</div>

									<div class="col-lg-5">
										<div class="form-group" style="text-align:center">
											<span class="btn btn-sm btn-warning btn-file">
												Examinar <input id="image" name="image" type="file" />
											</span>

											<input type="button" class="btn btn-sm btn-primary upload" value="Subir" style="margin-left:10px">

											<input type="button" class="btn btn-sm btn-danger delete" value="Eliminar" style="margin-left:10px">

											<?php
											$url_foto = "/img/profile-icon.png";
											if ($persona->foto != "") $url_foto = "/img/agremiado/" . $persona->foto;

											$foto = "";
											if ($persona->foto != "") $foto = $persona->foto;
											?>
											<img src="<?php echo $url_foto ?>" id="img_ruta" width="130px" height="165px" alt="" style="text-align:center;margin-top:8px" />
											<input type="hidden" id="img_foto" name="img_foto" value="<?php echo $foto ?>" />

										</div>
									</div>
								</div>

								<div style="padding-left:15px">
									<div class="row">
										<div class="col-lg-4">
											<div class="form-group">
												<label class="control-label form-control-sm">Nombres</label>
												<input id="nombre" name="nombre" class="form-control form-control-sm" value="<?php echo $persona->nombres ?>" type="text" readonly="readonly">
											</div>
										</div>
										<div class="col-lg-4">
											<div class="form-group">
												<label class="control-label form-control-sm">Apellido Paterno</label>
												<input id="apellido_paterno" name="apellido_paterno" class="form-control form-control-sm" value="<?php echo $persona->apellido_paterno ?>" type="text" readonly="readonly">
											</div>
										</div>
										<div class="col-lg-4">
											<div class="form-group">
												<label class="control-label form-control-sm">Apellido Materno</label>
												<input id="apellido_materno" name="apellido_materno" class="form-control form-control-sm" value="<?php echo $persona->apellido_materno ?>" type="text" readonly="readonly">
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-lg-3">
											<div class="form-group">
												<label class="control-label form-control-sm">Fecha Nacimiento</label>
												<input placeholder="fecha_nacimiento" type="date" id="fecha_nacimiento" class="form-control form-control-sm" value="<?php echo $persona->fecha_nacimiento ?>" type="text">
											</div>
										</div>
										<div class="col-lg-3">
											<div class="form-group">
												<label class="control-label form-control-sm">Grupo Sanguineo</label>
												<select name="grupo_sanguineo" id="grupo_sanguineo" class="form-control form-control-sm" onChange="">
													<option value="">--Selecionar--</option>
													<?php
													foreach ($grupo_sanguineo as $row) { ?>
														<option value="<?php echo $row->codigo ?>" <?php if ($row->codigo == $persona->grupo_sanguineo) echo "selected='selected'" ?>><?php echo $row->denominacion ?></option>
													<?php
													}
													?>
												</select>
											</div>
										</div>
										<div class="col-lg-3">
											<div class="form-group">
												<label class="control-label form-control-sm">Lugar Nacimiento</label>
												<input id="lugar_nacimiento" name="lugar_nacimiento" class="form-control form-control-sm" value="<?php echo $persona->lugar_nacimiento ?>" type="text">
											</div>
										</div>
										<div class="col-lg-3">
											<div class="form-group">
												<label class="control-label form-control-sm">Nacionalidad</label>
												<select name="nacionalidad" id="nacionalidad" class="form-control form-control-sm" onChange="">
													<option value="">--Selecionar--</option>
													<?php
													foreach ($nacionalidad as $row) { ?>
														<option value="<?php echo $row->codigo ?>" <?php if ($row->codigo == $persona->id_nacionalidad) echo "selected='selected'" ?>><?php echo $row->denominacion ?></option>
													<?php
													}
													?>
												</select>
											</div>
										</div>
										<div class="col-lg-3">
											<div class="form-group">
												<label class="control-label form-control-sm">Departamento</label>
												<input type="hidden" name="id_ubigeo_nacimiento" id="id_ubigeo_nacimiento" value="<?php echo $persona->id_ubigeo_nacimiento?>">
												<select name="id_departamento_nacimiento" id="id_departamento_nacimiento" class="form-control form-control-sm" onChange="obtenerProvinciaNacimiento()">
													<option value="">--Selecionar--</option>
													<?php
													foreach ($departamento as $row) {?>
													<option value="<?php echo $row->id_departamento?>" <?php if($row->id_departamento==substr($persona->id_ubigeo_nacimiento,0,2))echo "selected='selected'"?>><?php echo $row->desc_ubigeo ?></option>
													<?php 
													}
													?>
												</select>
											</div>
										</div>
										<div class="col-lg-3">
											<div class="form-group">
												<label class="control-label form-control-sm">Provincia</label>
												<select name="id_provincia_nacimiento" id="id_provincia_nacimiento" class="form-control form-control-sm" onChange="obtenerDistritoNacimiento()">
													<option value="">--Selecionar--</option>
												</select>
											</div>
										</div>
										<div class="col-lg-3">
											<div class="form-group">
												<label class="control-label form-control-sm">Distrito</label>
												<select name="id_distrito_nacimiento" id="id_distrito_nacimiento" class="form-control form-control-sm" onChange="">
													<option value="">--Selecionar--</option>
												</select>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-lg-3">
											<div class="form-group">
												<label class="control-label form-control-sm">Sexo</label>
												<select name="sexo" id="sexo" class="form-control form-control-sm" onChange="">
													<option value="">--Selecionar--</option>
													<?php
													foreach ($sexo as $row) { ?>
														<option value="<?php echo $row->codigo ?>" <?php if ($row->codigo == $persona->id_sexo) echo "selected='selected'" ?>><?php echo $row->denominacion ?></option>
													<?php
													}
													?>
												</select>
											</div>
										</div>
										<div class="col-lg-3">
											<div class="form-group">
												<label class="control-label form-control-sm">N&uacute;mero Celular</label>
												<input id="numero_celular" name="numero_celular" class="form-control form-control-sm" value="<?php echo $persona->numero_celular ?>" type="text">
											</div>
										</div>
										<div class="col-lg-6">
											<div class="form-group">
												<label class="control-label form-control-sm">Correo</label>
												<input id="correo" name="correo" class="form-control form-control-sm" value="<?php echo $persona->correo ?>" type="text">
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-lg-6">
											<div class="form-group">
												<label class="control-label form-control-sm">Direcci&oacute;n</label>
												<input id="direccion" name="direccion" class="form-control form-control-sm" value="<?php echo $persona->direccion ?>" type="text">
											</div>
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
			$(document).ready(function() {


				$('#numero_documento').blur(function() {
					var id = $('#id').val();
					if (id == 0) {
						validaDni(this.value);
					}
				});

				$('#tblReservaEstacionamiento').DataTable({
					"dom": '<"top">rt<"bottom"flpi><"clear">'
				});
				$("#system-search").keyup(function() {
					var dataTable = $('#tblReservaEstacionamiento').dataTable();
					dataTable.fnFilter(this.value);
				});

				$('#tblReservaEstacionamientoPreferente').DataTable({
					"dom": '<"top">rt<"bottom"flpi><"clear">'
				});
				$("#system-searchp").keyup(function() {
					var dataTable = $('#tblReservaEstacionamientoPreferente').dataTable();
					dataTable.fnFilter(this.value);
				});

				$('#tblSinReservaEstacionamiento').DataTable({
					"dom": '<"top">rt<"bottom"flpi><"clear">'
				});
				$("#system-search2").keyup(function() {
					var dataTable = $('#tblSinReservaEstacionamiento').dataTable();
					dataTable.fnFilter(this.value);
				});


			});
		</script>

		<script type="text/javascript">
			$(document).ready(function() {

				$('#persona_').keyup(function() {
					this.value = this.value.toLocaleUpperCase();
				});

				$('#persona_').focusin(function() {
					$('#persona_').select();
				});
				/*
				$('#usuario_').autocomplete({
					appendTo: "#usuario_busqueda",
					source: function(request, response) {
						$.ajax({
						url: '/empresa/list_usuario/'+$('#usuario_').val(),
						dataType: "json",
						success: function(data){
							var resp = $.map(data,function(obj){
								var hash = {key: obj.id, value: obj.usuario};
								return hash;
							}); 
							response(resp);
						},
						error: function() {
						}
					});
					},
					select: function (event, ui) {
						$("#user_id").val(ui.item.key);
					},
						minLength: 2,
						delay: 100
					});
				*/

				$('#empresa_').keyup(function() {
					this.value = this.value.toLocaleUpperCase();
				});

				$('#empresa_').focusin(function() {
					$('#empresa_').select();
				});

				$('#empresa_').autocomplete({
					appendTo: "#empresa_busqueda",
					source: function(request, response) {
						$.ajax({
							url: '/empresa/list_empresa/' + $('#empresa_').val(),
							dataType: "json",
							success: function(data) {
								var resp = $.map(data, function(obj) {
									var hash = {
										key: obj.id,
										value: obj.razon_social,
										ruc: obj.ruc
									};
									return hash;
								});
								response(resp);
							},
							error: function() {}
						});
					},
					select: function(event, ui) {
						$("#id_empresa").val(ui.item.key);
					},
					minLength: 1,
					delay: 100
				});

				$('#persona_').autocomplete({
					appendTo: "#persona_busqueda",
					source: function(request, response) {
						$.ajax({
							url: '/persona/list_persona/' + $('#persona_').val(),
							dataType: "json",
							success: function(data) {
								var resp = $.map(data, function(obj) {
									var hash = {
										key: obj.id,
										value: obj.persona
									};
									return hash;
								});
								response(resp);
							},
							error: function() {}
						});
					},
					select: function(event, ui) {
						$("#id_persona").val(ui.item.key);
					},
					minLength: 1,
					delay: 100
				});


			});

			function validaDni(dni) {

				var numero_documento = $("#numero_documento").val();
				var msg = "";

				if (msg != "") {
					bootbox.alert(msg);
					return false;
				}

				if (tipo_documento == "0" || numero_documento == "") {
					bootbox.alert(msg);
					return false;
				}

				var settings = {
					"url": "https://apiperu.dev/api/dni/" + dni,
					"method": "GET",
					"timeout": 0,
					"headers": {
						"Authorization": "Bearer 20b6666ddda099db4204cf53854f8ca04d950a4eead89029e77999b0726181cb"
					},
				};

				$.ajax(settings).done(function(response) {
					console.log(response);

					if (response.success == true) {

						var data = response.data;

						$('#apellido_paterno').val('')
						$('#apellido_materno').val('')
						$('#nombre').val('')

						$('#apellido_paterno').val(data.apellido_paterno);
						$('#apellido_materno').val(data.apellido_materno);
						$('#nombre').val(data.nombres);

						//alert(data.nombre_o_razon_social);

					} else {
						Swal.fire("DNI Inv&aacute;lido. Revise el DNI digitado!");
						return false;
					}

				});
			}
		</script>