<title>Sistema </title>

<style>
	.datepicker,
	.table-condensed {
		width: 250px;
		height: 250px;
	}

	/*****************/
	.modal-dialog {
		min-width: 30%;
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

	#tablemodal tbody tr:hover td,
	#tablemodal tbody tr:hover th {
		/*background-color: red!important;*/
		font-weight: bold;
		/*mix-blend-mode: difference;*/

	}


	fieldset.scheduler-border {
		border: solid 2px #c6c8ca !important;
		padding: 0 10px 10px 10px;
		border-bottom: none;
		width: 100%;
		color: #6c757d;
		font-weight: bold;
		margin: 15px 0px 10px 0px
	}

	legend.scheduler-border {
		width: auto !important;
		border: none;
		font-size: 14px;
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
		width: 20px;
		float: left;
		font-size: 11px;
		text-align: right;
		padding-top: 5px
	}

	.si {
		padding-right: 0px;
		padding-left: 3px;
		display: block;
		width: 20px;
		float: left;
		font-size: 11px;
		text-align: left;
		padding-top: 5px
	}

	#tablemodalm {}

	#modal_producto .ui-autocomplete {
		z-index: 2147483647 !important;
		background:#ffffffff;
		width: 200px;
	}

	#modal_producto .ui-autocomplete { height: 400px; overflow-y: scroll; overflow-x: hidden;}


	#modal_producto ul.auto-complete-list {
    list-style-type: none !important;
    margin: 0 !important;
    padding: 0 !important;
    position: absolute !important;
    z-index: 1500 !important;
    max-height: 250px !important;
    overflow: auto !important;
}

#modal_producto .ui-autocomplete, #modal_producto .ui-menu, #modal_producto .ui-menu-item {  z-index: 1006 !important; }


	#modal_producto.ui-menu,
	#modal_producto.ui-menu> #modal_producto .ui-menu-item,
	#modal_producto.ui-menu-item>a {
		min-width: 500px !important;
	}
	
/*
	.ui-widget {
  font-size: 0.75em;
}
  */
.ui-menu-item a {
  background-color: #fff;
}

.ui-menu-item .ui-menu-item-wrapper.ui-state-active {
    background: #6693bc !important;
    font-weight: bold !important;
    color: #ffffff !important;
} 
.ui-state-active, .ui-widget-content .ui-state-active, .ui-widget-header .ui-state-active, a.ui-button:active, .ui-button:active, .ui-state-active.ui-button:hover 
{
  border: 1px solid #000;
  background: #000;
}

.ui-helper-hidden-accessible { display:none; }

</style>

<script type="text/javascript">
	$(document).ready(function() {
		let date = new Date()
		let day = date.getDate()
		let month = date.getMonth() + 1
		let year = date.getFullYear()

		if (month < 10) {
			$('#txtFechaIni').val(`${day}-0${month}-${year}`);
			//console.log('${day}-0${month}-${year}')
		} else {
			//console.log('${day}-${month}-${year}')
			$('#txtFechaIni').val(`${day}-${month}-${year}`);
		}

		$('#txtCantidad').keypress(function (e) {
			if (e.keyCode == 13) {
				calcular();
			}
		});
		$('#txtPrecioVenta').keypress(function (e) {
			if (e.keyCode == 13) {
				calcular();
			}
		});
		$('#txtDescuento').keypress(function (e) {
			if (e.keyCode == 13) {
				calcular();
			}
		});		
		$('#txtTotal').keypress(function (e) {
			if (e.keyCode == 13) {
				calcular();
			}
		});												
																					
	});

	var tasa_igv_= 0.18;
	var um_ = "";
	var Cantidad_ = $('#txtCantidad').val();	
	var PrecioVenta_ = 0;
	var ValorUnitario_ = 0;
	var ValorVB_ = 0;
	var Descuento_ = 0;
	var ValorVenta_ = 0;
	var Igv_ = 0;
	var Total_ = 0;
	var id_um_=0;
	var codigo_producto_ = "";
	var id_producto_=0;
	var nombre_producto_ = "";

	var id_empresa_ = $('#empresa_id').val();
	var origen_ = $('#origen').val();
	if(id_empresa_==""){id_empresa_="0";}
	
	$('#txtProducto').autocomplete({
		appendTo: "#producto_list1",
		source: function(request, response) {
			$.ajax({
				url: 'obtener_producto_tipo_denominacion/all/' + $('#txtProducto').val()+'/'+id_empresa_+'/'+origen_,
				dataType: "json",
				success: function(data) {
					// alert(JSON.stringify(data));
					var resp = $.map(data, function(obj) {
						console.log(obj);

						id_um_ = obj.id_unidad_medida;
						um_ = obj.um;												
						PrecioVenta_ = obj.costo_unitario;
						codigo_producto_ = obj.codigo;
						id_producto_ = obj.id;
						nombre_producto_ = obj.nombre_producto;

						//return obj.denominacion;
						var hash = {
							key: obj.id,
							value: obj.denominacion
						};
						return hash;
					});
					//alert(JSON.stringify(resp));
					//console.log(JSON.stringify(resp));
					response(resp);
				},
				error: function() {
					//alert("cc");
				}
			});
		},
		select: function(event, ui) {
			//alert(ui.item.key);
			flag_select = true;
			$('#txtProducto').attr("readonly", true);
/*
			$('#txtUM').val(um_);
			$('#id_um').val(id_um_);
			$('#codigo_producto').val(codigo_producto_);
			$('#id_producto').val(id_producto_);
			$('#nombre_producto').val(nombre_producto_);
			$('#txtPrecioVenta').val(PrecioVenta_);
*/
			$("#id_producto").val(ui.item.key);
			codigo_producto_ = ui.item.key;

			$.ajax({
				url: 'obtener_producto_eqiv_id/'+codigo_producto_+'/' +id_empresa_+'/'+origen_,
				dataType: "json",
				success: function(data){
					var resp = $.map(data, function(obj) {
						console.log(obj);

						//alert(obj.um);				
					$('#txtUM').val(obj.um);
					$('#id_um').val(obj.id_unidad_medida);
					$('#codigo_producto').val(obj.codigo);
					$('#id_producto').val(obj.id);
					$('#nombre_producto').val(obj.nombre_producto);
					$('#txtPrecioVenta').val(obj.costo_unitario);
					calcular();

					});


				}

			});
		
			
		},
		minLength: 2,
		delay: 100
	}).blur(function() {
		if (typeof flag_select == "undefined") {
			$('#txtProducto').val("");
		}
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

	function calcular() {

		PrecioVenta_ = $('#txtPrecioVenta').val();
		Descuento_ = $('#txtDescuento').val();
		Cantidad_ = $('#txtCantidad').val();

		//alert(PrecioVenta_);


		ValorUnitario_ = PrecioVenta_ /(1+tasa_igv_);
		//ValorUnitario_ = Number(ValorUnitario_ .toFixed(2));		
		ValorVB_ = ValorUnitario_ * Cantidad_;
		ValorVenta_ = ValorVB_ - Descuento_;
		Igv_ = ValorVenta_ * tasa_igv_;
		//Igv_ = Number(Igv_.toFixed(2));
		Total_ = ValorVenta_ + Igv_;
		//Total_ =Number(Total_.toFixed(2));


		ValorUnitario_ = Number(ValorUnitario_ .toFixed(2));
		$('#txtValorUnitario').val(ValorUnitario_);
		
		ValorVB_ = Number(ValorVB_ .toFixed(2));
		$('#txtValorVB').val(ValorVB_);
		
		ValorVenta_ = Number(ValorVenta_ .toFixed(2));
		$('#txtValorVenta').val(ValorVenta_);

		Igv_ = Number(Igv_ .toFixed(2));
		$('#txtIgv').val(Igv_);
		
		Total_ = Number(Total_ .toFixed(2));
		$('#txtTotal').val(Total_);

	}








	function pad(str, max) {
		str = str.toString();
		return str.length < max ? pad("0" + str, max) : str;
	}

	function reformatDateString(s) {
		var b = s.split(/\D/);
		return b.reverse().join('/');
	}



	function FormatFecha(fecha) {
		//let date = new Date()
		let date = new Date(fecha)
		let day = date.getDate()
		let month = date.getMonth() + 1
		let year = date.getFullYear()

		let fechaFormat
		if (month < 10) {
			fechaFormat = `${day}-0${month}-${year}`
		} else {
			fechaFormat = `${day}-${month}-${year}`
		}
		return fechaFormat;
	}

	function eliminaFila(fila) {
		if (fila > 1) {
			cuentaproductos = cuentaproductos - 1;
			$('#fila' + pad(fila, 2)).remove();
		} else {
			$('#producto01').val("");
			$('#producto01').attr("readonly", false);
		}
	}
</script>


<body class="hold-transition skin-blue sidebar-mini">

	<div>
		<div class="justify-content-center" id="modal_producto">

			<div class="card">

				<div class="card-header" style="padding:5px!important;padding-left:20px!important">
					Registro de Papeleta
				</div>

				<div class="card-body">
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:10px">

							<div class="row">

								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:5px;padding-bottom:20px">

									<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
									
									<!--<input type="hidden" name="id_producto" id="id_producto" value="">-->
									<input type="hidden" name="id_um" id="id_um" value="">
									<input type="hidden" name="codigo_producto" id="codigo_producto" value="">
									<input type="hidden" name="nombre_producto" id="nombre_producto" value="">
									<input type="hidden" name="id_empresa_pr" id="id_empresa_pr" value="">

									<input type="hidden" name="id_descuento" id="id_descuento" value="1">

									<div class="row" style="padding-left:10px">
										<div class="card-body">
											<div class="row">
												
												<input type="checkbox" id="origen" name="origen" value="2" class="estado-checkbox" checked ?>
												<label for="cbox2" id="lblOrigen" > Origen interno</label>

												<div class="col-lg-12">
													<div class="form-group form-group-sm">
														<label class="form-control-sm">Producto</label>

														<td>
														<input type="text" name="txtProducto" id="txtProducto"
																class="form-control form-control-sm">
															
															<div class="input-group" style="position: absolute;"
																id="producto_list1"></div>

														</td>

													</div>

													<div class="col-lg-3">
														<div class="form-group">
															<label class="form-control-sm">id</label>
															<input type="text" name="id_producto" id="id_producto" value="" placeholder="" class="form-control form-control-sm">
														</div>
													</div>

												</div>
											</div>

											<div class="row">
												<div class="col-lg-6">
													<div class="form-group">
														<label class="form-control-sm">Cantidad</label>
														<input type="text" name="txtCantidad" id="txtCantidad" value="1" placeholder="" class="form-control form-control-sm" oninput="calcular()">
													</div>
												</div>
												<div class="col-lg-6">
													<div class="form-group">
														<label class="form-control-sm">Unidad Medida</label>
														<input type="text" name="txtUM" id="txtUM" value="" placeholder="" class="form-control form-control-sm" readonly="readonly">
													</div>
												</div>

											</div>

											<div class="row">
												<div class="col-lg-6">
													<div class="form-group">
														<label class="form-control-sm">Precio Venta</label>
														<input type="text" name="txtPrecioVenta" id="txtPrecioVenta" value="" placeholder="" class="form-control form-control-sm" oninput="calcular()">
													</div>
												</div>
												<div class="col-lg-6">
													<div class="form-group">
														<label class="form-control-sm">Valor Unitario</label>
														<input type="text" name="txtValorUnitario" id="txtValorUnitario" value="" placeholder="" class="form-control form-control-sm" readonly="readonly">
													</div>
												</div>
											</div>

											<div class="row">
												<div class="col-lg-4">
													<div class="form-group">
														<label class="form-control-sm">Valor Venta Bruto</label>
														<input type="text" name="txtValorVB" id="txtValorVB" value="" placeholder="" class="form-control form-control-sm" readonly="readonly">
													</div>
												</div>
												<div class="col-lg-4">
													<div class="form-group">
														<label class="form-control-sm">Descuento</label>
														<input type="text" name="txtDescuento" id="txtDescuento" value="0" placeholder="" class="form-control form-control-sm" oninput="calcular()">
													</div>
												</div>
												<div class="col-lg-4">
													<div class="form-group">
														<label class="form-control-sm">Valor Venta</label>
														<input type="text" name="txtValorVenta" id="txtValorVenta" value="" placeholder="" class="form-control form-control-sm" readonly="readonly">
													</div>
												</div>
											</div>

											<div class="row">
												<div class="col-lg-6">
													<div class="form-group">
														<label class="form-control-sm">IGV</label>
														<input type="text" name="txtIgv" id="txtIgv" value="20" placeholder="" class="form-control form-control-sm" readonly="readonly">
													</div>
												</div>
												<div class="col-lg-6">
													<div class="form-group">
														<label class="form-control-sm">Total</label>
														<input type="text" name="txtTotal" id="txtTotal" value="20" placeholder="" class="form-control form-control-sm" readonly="readonly">
													</div>
												</div>
											</div>

										</div>

									</div>
									<div style="margin-top:15px" class="form-group">
										<div id="divGuardar" class="col-sm-12 controls">
											<div class="btn-group btn-group-sm float-right" role="group" aria-label="Log Viewer Actions">
												<a href="javascript:void(0)" onClick="AddFila()" class="btn btn-sm btn-success">Aceptar</a>
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
					<!-- </section> -->
					<!-- /.content -->
				</div>
				<!-- /.content-wrapper -->
			</div>




			@push('after-scripts')

			<script src="{{ asset('js/ingreso.js') }}"></script>

			@endpush