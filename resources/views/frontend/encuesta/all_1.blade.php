<link rel="stylesheet" href="<?php echo URL::to('/') ?>/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" defer></script>

<style>
    #tblAfiliado tbody tr{
        font-size:13px
    }
    .table-sortable tbody tr {
        cursor: move;
    }

    #global {
        height: 650px !important;
        width: auto;
        border: 1px solid #ddd;
        margin:15px
    }
    
    .margin{
        margin-bottom: 20px;
    }
    .margin-buscar{
        margin-bottom: 5px;
        margin-top: 5px;
    }

    .clickable{
        cursor: pointer;   
    }

    .panel-body{
        display: block;
    }
    
    .dataTables_filter {
       display: none;
    }

    .loader {
        width: 100%;
        height: 100%;
        overflow: hidden; 
        top: 0px;
        left: 0px;
        z-index: 10000;
        text-align: center;
        position:absolute; 
        background-color: #000;
        opacity:0.6;
        filter:alpha(opacity=40);
        display:none;
    }

    .dataTables_processing {
        position: absolute;
        top: 50%;
        left: 50%;
        width: 500px!important;
        font-size: 1.7em;
        border: 0px;
        margin-left: -17%!important;
        text-align: center;
        background: #3c8dbc;
        color: #FFFFFF;
    }

    .required:after {
        content: " *";
        color: red;
    }

    .rating-options {
        display: flex;
        justify-content: space-between;
        width: 100%;
    }

    .rating-option {
        display: flex;
        flex-direction: column;
        align-items: center;
    }
</style>

@extends('frontend.layouts.app')

@section('title', ' | Encuesta de Calidad de Evaluadores')

@section('breadcrumb')
<ol class="breadcrumb" style="padding-left:130px;margin-top:0px;background-color:#283659">
    <li class="breadcrumb-item text-primary">Inicio</li>
    <li class="breadcrumb-item active">Encuesta de Calidad</li>
</ol>
@endsection

@section('content')

<div class="loader"></div>

<div class="justify-content-center">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12">
                    <h4 class="card-title mb-0 text-primary">
                        Encuesta de Calidad de Evaluadores
                    </h4>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col col-sm-12 align-self-center">
                    <div class="card">
                        <div class="card-header">
                            <strong>Formulario de Encuesta</strong>
                        </div>
                        
                        <form class="form-horizontal" method="post" action="{{ route('frontend.guardar.encuesta') }}" id="frmEncuesta" autocomplete="off">
    
                            @csrf
                            <input type="hidden" name="id" id="id" value="0">
                            
                            <div class="card-body" style="padding: 20px;">
                                <!-- Sección de Datos del Expediente -->
                                <div class="row" style="margin-bottom: 20px;">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="municipalidad_tramite" class="control-label required">Municipalidad de Trámite:</label>
                                            <input type="text" class="form-control" id="municipalidad_tramite" name="municipalidad_tramite" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="fecha_entrevista" class="control-label required">Fecha de Entrevista:</label>
                                            <input type="date" class="form-control" id="fecha_entrevista" name="fecha_entrevista" required>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row" style="margin-bottom: 20px;">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="numero_expediente" class="control-label required">Número de Expediente:</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="numero_expediente" name="numero_expediente" required>
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary" type="button" id="buscarExpediente">Buscar Expediente</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Sección de Opinión Técnica -->
                                <div class="card" style="margin-bottom: 20px;">
                                    <div class="card-header bg-primary text-white">
                                        <strong>OPINIÓN DEL CONOCIMIENTO TÉCNICO Y NORMATIVO</strong>
                                    </div>
                                    <div class="card-body">
                                        <p>Califique cada ítem del 1 al 5, siendo 1 que el servicio fue insatisfactorio y 5 que el servicio fue muy satisfactorio</p>
                                        
                                        <div class="form-group">
                                            <label class="control-label required">Las observaciones tenían sustento normativo específico:</label>
                                            <div class="rating-options">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <div class="rating-option">
                                                        <input type="radio" id="sustento_normativo_{{ $i }}" name="sustento_normativo" value="{{ $i }}" required>
                                                        <label for="sustento_normativo_{{ $i }}">{{ $i }}</label>
                                                    </div>
                                                @endfor
                                            </div>
                                        </div>
                                        
                                        <!-- Más preguntas de calificación -->
                                    </div>
                                </div>
                                
                                <!-- Sección de Calidad del Servicio -->
                                <div class="card" style="margin-bottom: 20px;">
                                    <div class="card-header bg-primary text-white">
                                        <strong>OPINIÓN DE LA CALIDAD DEL SERVICIO</strong>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label class="control-label required">¿Le aclararon sus dudas en la entrevista?</label>
                                            <div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="aclararon_dudas" id="aclararon_dudas_si" value="1" required>
                                                    <label class="form-check-label" for="aclararon_dudas_si">Sí</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="aclararon_dudas" id="aclararon_dudas_no" value="0">
                                                    <label class="form-check-label" for="aclararon_dudas_no">No</label>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Más preguntas sí/no -->
                                    </div>
                                </div>
                                
                                <!-- Sección de Presidente de Comisión -->
                                <div class="card" style="margin-bottom: 20px;">
                                    <div class="card-header bg-primary text-white">
                                        <strong>OPINIÓN SOBRE EL DESEMPEÑO DEL PRESIDENTE DE LA COMISIÓN TÉCNICA</strong>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="presidente_comision" class="control-label required">Nombre o colegiatura del Presidente:</label>
                                            <select class="form-control" id="presidente_comision" name="presidente_comision" required>
                                                <option value="">Seleccione...</option>
                                                @foreach($presidentes as $presidente)
                                                    <option value="{{ $presidente->id }}">{{ $presidente->nombre }} ({{ $presidente->numero_cap }})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        
                                        <!-- Preguntas de calificación para el presidente -->
                                    </div>
                                </div>
                                
                                <!-- Secciones similares para Delegado 1, Delegado 2, Especialista y Delegado AD HOC -->
                                
                                <!-- Botón de envío -->
                                <div class="form-group text-center">
                                    <button type="submit" class="btn btn-primary">Enviar Encuesta</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para búsqueda avanzada -->
<div id="openOverlayOpc" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div id="id_content_OverlayoneOpc" class="modal-content" style="padding: 0px;margin: 0px">
            <div class="modal-body" style="padding: 0px;margin: 0px">
                <div id="diveditpregOpc"></div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('after-scripts')
<script>
    $(document).ready(function() {
        // Buscar expediente
        $('#buscarExpediente').click(function() {
            var numeroExpediente = $('#numero_expediente').val();
            
            if (numeroExpediente) {
                $('.loader').show();
                
                $.ajax({
                    url: "{{ route('frontend.buscar.expediente') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        numero_expediente: numeroExpediente
                    },
                    success: function(response) {
                        $('.loader').hide();
                        
                        if (response.success) {
                            $('#municipalidad_tramite').val(response.municipalidad_tramite);
                            $('#fecha_entrevista').val(response.fecha_entrevista);
                            
                            // Seleccionar valores en los combos
                            if (response.presidente_comision) {
                                $('#presidente_comision').val(response.presidente_comision);
                            }
                            
                            // Mostrar mensaje de éxito
                            toastr.success('Expediente encontrado y datos cargados');
                        } else {
                            toastr.error('Expediente no encontrado');
                        }
                    },
                    error: function() {
                        $('.loader').hide();
                        toastr.error('Error al buscar el expediente');
                    }
                });
            } else {
                toastr.warning('Por favor ingrese un número de expediente');
            }
        });
        
        // Validación del formulario
        $('#frmEncuesta').validate({
            rules: {
                numero_expediente: "required",
                municipalidad_tramite: "required",
                fecha_entrevista: "required",
                presidente_comision: "required"
                // Agregar más reglas de validación según sea necesario
            },
            messages: {
                numero_expediente: "Este campo es obligatorio",
                municipalidad_tramite: "Este campo es obligatorio",
                fecha_entrevista: "Este campo es obligatorio",
                presidente_comision: "Debe seleccionar un presidente"
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    });
</script>
@endpush