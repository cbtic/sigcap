<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <h4 class="card-title mb-3" style="color:#373F41!important;font-size:30px;font-weight:bold">
            {{$titulo}}
        </h4>
    </div>
</div>

<div class="col col-sm-12 align-self-center">
                                
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    
                                    <!--
                                    <input type="hidden" name="trans" id="trans" value="FA">
                                    <input type="hidden" name="TipoF" value="<?php //if ($trans == 'FA'){echo $TipoF;}?>">
                                    -->
                                    
                                    <input type="hidden" name="vestab" value="1">
                                    <input type="hidden" name="totalF" value="<?php //if ($trans == 'FA'){echo $total;}?>">
                                    <input type="hidden" name="ubicacion" value="<?php //if ($trans == 'FA'){echo $ubicacion;}?>">
                                    <input type="hidden" name="persona" value="<?php if ($trans == 'FA'){echo $persona;}?>">
                                    <input type="hidden" name="persona2" id="persona2" value="<?php //if ($trans == 'FA'){echo $persona;}?>">
                                    <input type="hidden" name="ubicacion2" id="ubicacion2" value="<?php //if ($trans == 'FA'){echo $ubicacion;}?>">
                                    <input type="hidden" name="id_caja" value="<?php //if ($trans == 'FA'){echo $id_caja;}?>">
                                    <input type="hidden" name="MonAd" value="<?php //if ($trans == 'FA'){echo $MonAd;}?>">
                                    <input type="hidden" name="adelanto" value="<?php //if ($trans == 'FA'){echo $adelanto;}?>">
                                    <input type="hidden" name="id_factura" value="<?php //if ($trans == 'FE'){echo $facturas->id;}?>">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div id="" class="row">
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    <div class="card">
                                                        <div class="card-header btn-secondary">
                                                            <div id="" class="row">
                                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                    <strong>
                                                                        Datos del Cliente
                                                                    </strong>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div id="fsFiltro" class="card-body" >
                                                            <div id="" class="row">
                                                                <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                                                    <div class="form-group">
                                                                        <label class="form-control-sm">Serie</label>

                                                                        <input type="text" name="serieF" id="serieF" 
                                                                        value="<?php 
                                                                        if ($trans == 'FA'||$trans == 'FN'){
                                                                            foreach($serie as $row){
                                                                                if($row->predeterminado=="1"){
                                                                                    echo $row->denominacion;
                                                                                }
                                                                            }
                                                                        }
                                                                            
                                                                        if ($trans == 'FE'){
                                                                            echo $facturas->fac_serie;
                                                                        }
                                                                        ?>"
                                                                        readonly class="form-control form-control-sm">

                                                                        <!--<select name="serieF" id="serieF" class="form-control form-control-sm" disabled="disabled">-->
                                                                            
                                                                        <!--</select>-->
                                                                    </div>
                                                                </div>

                                                                <!--
                                                                <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12"name="divNumeroF" id="divNumeroF">
                                                                    <div class="form-group">
                                                                        <label class="form-control-sm">Número</label>
                                                                        <input type="text" name="numerof" readonly
                                                                            id="numerof" value="<?php if ($trans == 'FE'){echo $facturas->fac_numero;}?>"
                                                                            placeholder="" class="form-control form-control-sm text-center"  >
                                                                    </div>
                                                                </div>
                                                                -->

                                                                <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                                                    <div class="form-group">
                                                                        <label class="form-control-sm">Fecha Emisión</label>
                                                                        <?php if ($trans == 'FA'||$trans == 'FN'){?>
                                                                            <input type="text" name="fechaF" id="fechaF" value="<?php echo date("d/m/Y")?>"
                                                                            placeholder="" readonly class="form-control form-control-sm">
                                                                        <?php } ?>
                                                                        <?php if ($trans == 'FE'){?>
                                                                            <input type="text" name="fechaFE" id="fechaFE" value="<?php echo date("d/m/Y", strtotime($facturas->fac_fecha)) ?>"
                                                                            placeholder="" class="form-control form-control-sm text-center" readonly>
                                                                        <?php } ?>
                                                                        
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div id="" class="row">
                                                    <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                                        <label class="form-control-sm">RUC/DNI</label>
                                                        <div class="input-group">
                                                            <input type="text" name="numero_documento" readonly id="numero_documento" value="<?php if ($trans == 'FA') {
                                                                echo $empresa->ruc;
                                                            }
                                                            if ($trans == 'FE') {
                                                                echo $comprobante->cod_tributario;
                                                            } ?>" placeholder="" class="form-control form-control-sm">
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="form-control-sm">Razón Social/Nombre</label>
                                                            <input type="text" name="razon_social" readonly id="razon_social" value="<?php if ($trans == 'FA') {
                                                                echo $empresa->razon_social;
                                                            }
                                                            if ($trans == 'FE') {
                                                                echo $comprobante->destinatario;
                                                            } ?>" placeholder="" class="form-control form-control-sm">
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="form-control-sm">Email</label>
                                                            <input type="text" name="email"  id="email" value="<?php if ($trans == 'FA') {
                                                                echo $empresa->email;
                                                            }
                                                            if ($trans == 'FE') {
                                                                echo $comprobante->email;
                                                            } ?>" placeholder="" class="form-control form-control-sm">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="form-control-sm">Dirección</label>
                                                            <input type="text" name="direccion"  id="direccion" value="<?php if ($trans == 'FA') {
                                                                echo $empresa->direccion;
                                                            }
                                                            if ($trans == 'FE') {
                                                                echo $comprobante->direccion;
                                                            } 
                                                            ?>" placeholder="" class="form-control form-control-sm">
                                                        </div>
                                                    </div>
                                                    
                                                </div>

                                                @if($sw)
                                                <a href="javascript:void(0);" onclick="verRepresentante()" id="btnRepresentante" class="agregar-rep">
        ➕ Agregar a un Tercero
    </a>
                                                @endif

                                                <fieldset id="divRepresentante" style="display:none; margin-top:15px; border:1px solid #ccc; padding:10px; border-radius:6px;">
                                                <legend style="font-size:14px; font-weight:bold; color:#373F41;">Datos del Tercero</legend>
                                                <div id="" class="row">
                                                    <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                                        <label class="form-control-sm">RUC/DNI</label>
                                                        <div class="input-group">

                                                            <input class="form-control input-sm text-uppercase" type="text" name="numero_documento2" id="numero_documento2" autocomplete="OFF" maxlength="12" required="" tabindex="0">
                                                            
                                                            <button type="button" class="btn btn-square link link-icon" href="javascript:void(0);" onclick="obtenerRepresentante()" style="padding-left:0px!important;padding-right:0px!important;line-height:37px;min-width:4rem"><i class="fa fa-search" style="line-height:unset !important;"></i></button>

                                                        </div>                                                        
                                                    </div>

                                                    <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="form-control-sm">Razón Social/Nombre</label>
                                                            <input type="text" name="razon_social2" readonly id="razon_social2" value="" placeholder="" class="form-control form-control-sm">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="form-control-sm">Email</label>
                                                            <input type="text" name="email2"  id="email2" value="" placeholder="" class="form-control form-control-sm">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="form-control-sm">Dirección</label>
                                                            <input type="text" name="direccion2"  id="direccion2" value="" placeholder="" class="form-control form-control-sm">
                                                        </div>
                                                    </div>

                                                </div>
                                                
                                                </fieldset>

                                                        </div>
                                                        <!--card-body-->
                                                    </div>
                                                    <!--card-->
                                                </div>
                                            </div>
                                            <br>

                                            <div id="" class="row">
                                                <div class="col-lg-12 col-md-12 col-sm-8 col-xs-8">
                                                    <div class="card">
                                                        <div class="card-header btn-secondary">
                                                            <strong>
                                                                Detalle Resumen
                                                                <?php
                                                                if ($trans == 'FN'){?>
                                                                    <button type="button" id="addRow" style="margin-left:10px" class="btn btn-info btn-sm"><i class="fa fa-plus"></i> Agregar Item(s)</button>
                                                                <?php } ?>
                                                            </strong>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="table-responsive overflow-auto" style="max-height: 500px;">
                                                                <table id="tblDetalle" class="table table-hover">
                                                                    <thead>
                                                                        <tr>
                                                                            <th class="text-right" width="5%">#</th>
                                                                            <th class="text-center" width="10%">Cant.</th>
                                                                            <th width="40%">Descripción</th>
                                                                            <th class="text-right" width="15%">PU</th>
                                                                            <th class="text-right" width="15%">V.Venta</th>
                                                                            <th width="40%">%Dscto.</th>
                                                                            <th class="text-right" width="15%">IGV</th>
                                                                            <th class="text-right" width="15%">Total</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php $n = 0;
                                                                        $smodulo = "";
                                                                        if ($trans == 'FA' || $trans == 'FE'){?>
                                                                            @foreach ($pedido_item as $factura_detalle)
                                                                                <tr>
                                                                                    <td class="text-right"><?php $n = $n + 1; echo $n;?></td>
                                                                                    <td class="text-center">{{ $factura_detalle->cantidad }} </td>
                                                                                    <td class="text-left">{{ $factura_detalle->nombre }}</td>
                                                                                    <td class="text-right">{{ number_format($factura_detalle->precio_unitario,2)  }}</td>
                                                                                    <td class="text-right">{{ number_format($factura_detalle->valor_venta,2) }}</td> 
                                                                                    <td class="text-left">{{ number_format($pedido->descuento_total,2)  }}</td>
                                                                                    <td class="text-right">{{ number_format($factura_detalle->impuesto,2)  }}</td>
                                                                                    <td class="text-right" >{{ number_format($factura_detalle->total,2) }}</td>

                                                                                    <?php
                                                                                    if ($trans == 'FN'){?>
                                                                                        <td class="text-center">
                                                                                            <div data-toggle="tooltip" data-placement="top" data-html="true" title="<b>Editar Factura</b>">
                                                                                                <a href="/editar_receta_vale/1" class="btn btn-success btn-xs"><i class="fa fa-edit"></i></a>
                                                                                            </div>
                                                                                        </td>
                                                                                        <td class="text-center">
                                                                                            <div data-toggle="tooltip" data-placement="top" data-html="true" title="<b>Anular Factura</b>">
                                                                                                <a href="/ver_receta_atendida/1/" class="btn btn-danger btn-xs"><i class="fa fa-xing"></i></a>
                                                                                            </div>
                                                                                        </td>
                                                                                    <?php } ?>
                                                                                </tr>
                                                                                <input type="hidden" name="facturad[<?php //echo $key?>][item]" value="<?php echo $n?>" />
                                                                            @endforeach
                                                                        <?php } ?>
                                                                        
                                                                        <input type="hidden" name="smodulo_guia" id="smodulo_guia" value="<?php echo $smodulo?>" />
                                                                        
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            <!--table-responsive-->
                                                        </div>
                                                        <!--card-body-->
                                                    </div>
                                                    <!--card-->
                                                </div>
                                                <!--card-->

                                                </div>
                                                <br>
                                                
                                                <div class="row">
                                                <div class="col-lg-6 offset-lg-6 col-md-6 offset-md-6 col-12">
                                                <div class="card">
                                                    <div class="card-header btn-secondary">
                                                        <strong>
                                                            Información de Pago
                                                        </strong>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="table-responsive">
                                                            <table id="tblPago" class="table table-hover">
                                                                <tbody>
                                                                    <tr style="display:none">
                                                                        <th></th>
                                                                        <th>Anticipos</th>
                                                                        <th></th>
                                                                        <th></th>
                                                                        <th class="text-right"><span
                                                                                id="anticipos"></span> 0.00</th>
                                                                    </tr>
                                                                    <tr style="display:none">
                                                                        <th></th>
                                                                        <th>Descuentos</th>
                                                                        <th></th>
                                                                        <th></th>
                                                                        <th class="text-right"><span
                                                                                id="descuentos"></span> 0.00</th>
                                                                    </tr>
                                                                    <tr>
                                                                        <th></th>
                                                                        <th>Ope Gravadas</th>
                                                                        <th></th>
                                                                        <th></th>
                                                                        <th class="text-right"><span
                                                                                id="gravadas"></span> 
                                                                                {{ number_format($pedido->subtotal,2)  }}
                                                                        </th>
                                                                    </tr>
                                                                    <tr style="display:none">
                                                                        <th></th>
                                                                        <th>Ope Inafectas</th>
                                                                        <th></th>
                                                                        <th></th>
                                                                        <th class="text-right"><span
                                                                                id="inafectas"></span> 0.00</th>
                                                                    </tr>
                                                                    <tr style="display:none">
                                                                        <th></th>
                                                                        <th>Ope Exoneradas</th>
                                                                        <th></th>
                                                                        <th></th>
                                                                        <th class="text-right"><span
                                                                                id="exoneradas"></span> 0.00</th>
                                                                    </tr>
                                                                    <tr>
                                                                        <th></th>
                                                                        <th>I.G.V.</th>
                                                                        <th></th>
                                                                        <th></th>
                                                                        <th class="text-right"><span
                                                                                id="igv"></span> 
                                                                                {{ number_format($pedido->impuesto_total,2)  }}
                                                                            </th>
                                                                    </tr>
                                                                    <tr>
                                                                        <th></th>
                                                                        <th>Total</th>
                                                                        <th></th>
                                                                        <th></th>
                                                                        <th class="text-right"><span
                                                                                id="totalP"></span> 
                                                                                {{ number_format($pedido->total_general,2)  }}
                                                                        </th>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <!--table-responsive-->
                                                    </div>
                                                    <!--card-body-->
                                                </div>
                                                <!--card-->
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right" style="margin-top:30px">
                                                <button type="button" onclick="guardarFactura()" class="btn btn-primary" id="btnGenTicket">{{$btn_titulo}}</button> 
                                            </div>
                                            </div>
                                        </div>
                                    
                                            <!--
                                            <a class='flotante' name="guardar" id="guardar" onclick="guardarFactura()" href='#' ><img src='/img/btn_save.png' border="0"/></a>
                                            -->
                                    
                                
                                    </div>



                            </div>
                        </div>



                    </div>
                </div>
            </div>

	</section>
	
	<section class="seccion-sidebar">
		
	</section>
</div>

</main>
		<div class="fondo-curva">
			<img src="https://pagalo.pe/imagenes/new/curva.svg" class="curva"></div>
		</div>

<div class="btn-sidebar" id="btn-sidebar" data-toggle="modal" data-target="#modalSidebar" style="display: none;"><i class="icon icon-pagalo-info" aria-hidden="true" title="Informacion"></i></div>
	<div class="modal-sidebar modal fade" id="modalSidebar" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-body">
					<button type="button" class="opcion-cerrar close" data-dismiss="modal" aria-label="Cerrar" title="" data-toggle="tooltip" data-original-title="Cerrar">
						<i class="icon icon-pagalo-close" aria-hidden="true"></i>
					</button>
					<div class="contenido"></div>
				</div>
			</div>
		</div>
	</div>

	
	<footer>
		


