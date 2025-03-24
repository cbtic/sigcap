
					<div class="row" style="padding-left:15px; padding-right:15px">
						<div class="col-lg-4">
							<b>Denominaci&oacute;n</b>
						</div>
						<div class="col-lg-4">
							<b>Cantidad</b>
						</div>
						<div class="col-lg-4">
							<b>Total</b>
						</div>
					</div>

					<?php 
					//print_r($efectivo_detalle);
					//echo count($efectivo_detalle)."cdcds";
					//echo count(collect($efectivo_detalle));
					if($id==0 || count(collect($efectivo_detalle))==0){
						foreach($tipo_monedas as $index => $row){
						?>
							<div class="row" style="padding-left:15px; padding-right:15px">
								<div class="col-lg-4">
									<?php echo $row->denominacion?>
								</div>

								<input id="iddetalle" name="iddetalle[]" class="form-control form-control-sm" value="0" type="hidden"/>

								<input id="id_tipo_efectivo" name="id_tipo_efectivo[]" class="form-control form-control-sm" value="<?php echo $row->codigo?>" type="hidden"/>
								<div class="col-lg-4">
									<div class="form-group">
									<input id="cantidad_<?php echo $index?>" name="cantidad[]" class="form-control form-control-sm" value="" type="text" oninput="calculartotal(<?php echo $row->abreviatura; ?>, <?php echo $index; ?>)">
									</div>
								</div>
								<div class="col-lg-4">
									<div class="form-group">
										<input id="total_<?php echo $index?>" name="total[]" on class="form-control form-control-sm"  value="0" type="text" >
									</div>
								</div>
							</div>

							<script>
								calcularTotalGeneral();
							</script>

					<?php 
						}
					}else{
						foreach($efectivo_detalle as $index => $row){
						?>
							<div class="row" style="padding-left:15px; padding-right:15px">
								<div class="col-lg-4">
									<?php echo $row->denominacion?>
								</div>
								
								<input id="iddetalle" name="iddetalle[]" class="form-control form-control-sm" value="<?php echo $row->id ?>" type="hidden"/>
								<div class="col-lg-4">
									<div class="form-group">
									<input id="cantidad_<?php echo $index?>" name="cantidad[]" class="form-control form-control-sm" value="<?php echo $row->cantidad ?>" type="text" oninput="calculartotal(<?php echo $row->abreviatura; ?>, <?php echo $index; ?>)">
									</div>
								</div>
								<div class="col-lg-4">
									<div class="form-group">
										<input id="total_<?php echo $index?>" name="total[]" on class="form-control form-control-sm"  value="<?php echo $row->total ?>" type="text" >
									</div>
								</div>
							</div>
							<script>
								calcularTotalGeneral();
							</script>

						<?php 
						}
					}
					?>

					<div class="row" style="padding-left:15px; padding-right:15px">
						<div class="col-lg-4">
						</div>
						<div class="col-lg-4">
						</div>
						<div class="col-lg-4">
							<div class="form-group">
								<label class="control-label form-control-sm" id="total_">0</label>
							</div>
						</div>
					</div>
					
				</div>
				
				