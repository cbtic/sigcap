
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
                        
						<p>Le informamos que recientemente se ha registrado con su Nro de CAP {{$datos_correo[0]->numero_cap}}, el proyecto {{$datos_correo[0]->nombre_proyecto}} con los siguientes datos:</p>
                        <p>
                            <?php
                            //$originalDate = $pasaje->fecha_viaje;
                            //$fecha_viaje = date("d-m-Y", strtotime($originalDate));
                            ?>
                        <ul>
                            <li>Tipo de Tramite: {{$datos_correo[0]->tipo_tramite}}</li>
                            <li>Distrito: {{$datos_correo[0]->distrito}}</li>
                        </ul>
                        </p>
						
						<p>Se ha constatado que
                            @foreach($datos_correo as $dato)
                                @if({{$dato->situacion}}=='INHABILITADO'){
                                    el <b>proyectista {{$dato->nombres}} con CAP N {{$dato->numero_cap}} se encuentra {{$dato->situacion}}</b>, 
                                }
                                @endif
                            @endforeach
                            por lo que debe proceder a HABILITARSE previa aprobación de la solicitud, para lo cual se debe comunicar con el área de CAJA a los teléfonos </p>
						
                        <p>627-1200 anexo 181-182-184</p>
                        
						<p>954-495-957 </p>
						<p>	¿No reconoce este proyecto?</p>
						<p>	Haga click aquí para alertar al Área de Asuntos Técnicos
						</p>
					
                    </div>
					
					<br />
					<br />
					
                </div>
            </div>

        </div>

    </div>
</div>