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

    .opciones-radio-horizontal {
        display: flex;
        gap: 1rem; /* Espacio entre opciones */
        flex-wrap: wrap; /* Permite que las opciones pasen a siguiente línea si no caben */
    }
    
    .opcion-radio {
        display: flex;
        align-items: center;
        margin-right: 15px;
    }
    
    /* Para el diseño tipo botones */
    .radio-btn-group .btn {
        margin-right: 5px;
        margin-bottom: 5px;
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

@section('title', 'Encuesta Dinámica')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">{{ $encuesta->titulo }}</h4>
                </div>

                <div class="card-body">
                    <form id="formEncuesta" method="POST" action="{{ route('frontend.encuesta.guardar', $encuesta->id) }}">
                        @csrf

                        <!-- Búsqueda de Expediente -->
                        <div class="row mb-4">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="numero_expediente" class="required">Número de Expediente</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="numero_expediente" name="numero_expediente" required>
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="button" id="btnBuscarExpediente">
                                                <i class="fas fa-search"></i> Buscar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Después del campo de expediente -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="evaluador_id">Evaluador (opcional)</label>
                                        <select class="form-control" id="evaluador_id" name="evaluador_id">
                                            <option value="">Seleccione un evaluador...</option>
                                            @foreach($evaluadores as $evaluador)
                                                <option value="{{ $evaluador->id }}">
                                                    {{ $evaluador->nombre }} ({{ $evaluador->numero_cap }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Fecha de Entrevista</label>
                                    <input type="date" class="form-control" id="fecha_entrevista" readonly>
                                </div>
                            </div>
                        </div>

                        <!-- Secciones dinámicas -->
                        @foreach($encuesta->secciones as $seccion)
                            <div class="card mb-4">
                                <div class="card-header bg-secondary text-white">
                                    <h5 class="mb-0">{{ $seccion->titulo }}</h5>
                                    @if($seccion->descripcion)
                                        <p class="mb-0 small">{{ $seccion->descripcion }}</p>
                                    @endif
                                </div>

                                <div class="card-body">
                                    @foreach($seccion->preguntas as $pregunta)
                                        <div class="form-group mb-4">
                                            <label for="pregunta_{{ $pregunta->id }}" class="{{ $pregunta->requerida ? 'required' : '' }}">
                                                {{ $pregunta->pregunta }}
                                            </label>
                                            
                                            @include('frontend.encuesta.tipos-respuesta', ['pregunta' => $pregunta])
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach

                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-paper-plane"></i> Enviar Encuesta
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Buscar expediente
    $('#btnBuscarExpediente').click(function() {
        const numExpediente = $('#numero_expediente').val();
        
        if (!numExpediente) {
            alert('Por favor ingrese un número de expediente');
            return;
        }

        $.ajax({
            url: "{{ route('frontend.encuesta.buscar-expediente') }}",
            method: 'POST',
            data: {
                _token: "{{ csrf_token() }}",
                numero_expediente: numExpediente
            },
            success: function(response) {
                if (response.success) {
                    const expediente = response.data;
                    $('#fecha_entrevista').val(expediente.fecha_entrevista);
                    // Puedes llenar más campos según sea necesario
                } else {
                    alert('Expediente no encontrado');
                }
            },
            error: function() {
                alert('Error al buscar el expediente');
            }
        });
    });

    // Validación del formulario
    $('#formEncuesta').validate({
        rules: {
            numero_expediente: "required"
            // Otras reglas de validación pueden ir aquí
        },
        messages: {
            numero_expediente: "Este campo es obligatorio"
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