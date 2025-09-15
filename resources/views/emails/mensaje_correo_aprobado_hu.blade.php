
<div class="container">
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-6">
            <div id="postlist">
                <div class="panel">
                    <div class="panel-heading">
                        <div class="text-center">
                            <div class="row">
                                <div class="col-sm-12" style="background:#1C77B9!important;text-align:center;padding-top:10px;padding-bottom:10px">
                                    <img width="200px" height="80px" style="text-align:center" src="http://pruebasigcap.limacap.org:8082/img/logo-sin-fondo2.png" align="center">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body" style="border:2px solid #1C77B9!important;padding:10px">
                        
						<p>Estimado <b>Arq. {{$datos_correo[0]->nombres}}</b></p>
                        
						<p>Le informamos que se aprobó su solicitud de derecho de revisión Habilitación Urbana.</p>
                        <p>
                            <?php
                            //$originalDate = $pasaje->fecha_viaje;
                            //$fecha_viaje = date("d-m-Y", strtotime($originalDate));
                            ?>
                        <ul>
                            <li>Tipo de Tramite: {{$datos_correo[0]->tipo_tramite}}</li>
                            <li>Área Bruta del Terreno: {{ number_format($datos_correo[0]->area_total, 2, '.', ',') m2 }}</li>
                            <li>Distrito: {{$datos_correo[0]->distrito}}</li>
                            <li>Dirección: {{$datos_correo[0]->direccion}}</li>
                            <li>Propietario: {{$datos_correo[0]->propietario}}</li>
                            <li></li>
                            <li>El número de Liquidación (Credipago) {{$datos_correo[0]->credipago}} Monto a Pagar: S/.{{ number_format($datos_correo[0]->total, 2, '.', ',') }}</li>
                        </ul>
                        </p>
						
						<p> Puede realizar el pago de la liquidación en el siquiente <a href="https://limacap.org/formulario-de-pago/" target="_blank">link</a>.</p>
						</p>
					
                    </div>
					
					<br />
					<br />
					
                </div>
            </div>

        </div>

    </div>
</div>