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

    .gap-3 {
    gap: 1rem;
}

.form-check {
    padding-left: 0;
    margin-right: 1.5rem;
}

.form-check-input {
    margin-left: 0;
    margin-right: 0.5rem;
    margin-top: 0.2rem;
}

.d-flex {
    display: flex;
}

.flex-wrap {
    flex-wrap: wrap;
}

/* Estilo para campos de texto */
.form-control {
    transition: all 0.3s ease;
    border: 1px solid #ced4da;
}

.form-control:focus {
    border-color: #80bdff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

/* Contador de caracteres */
.text-muted {
    font-size: 0.8rem;
    color: #6c757d;
}

/* Para campos requeridos */
label.required:after {
    content: " *";
    color: #dc3545;
}

/* Estilo para selects */
.select2-container--default .select2-selection--single {
    height: 38px;
    border: 1px solid #ced4da;
    border-radius: 0.25rem;
}

.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 36px;
}

/* Para selects requeridos */
select[required] {
    background-color: #fff;
    background-image: none;
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
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h2 class="mb-0">{{ $encuesta->titulo }}</h2>
            @if($encuesta->descripcion)
                <p class="mb-0">{{ $encuesta->descripcion }}</p>
            @endif
        </div>

        <form method="POST" action="{{ route('frontend.encuesta.dinamica.guardar', $encuesta->id) }}">
            @csrf
            
            <div class="card-body">
                <!-- Búsqueda de Expediente -->
                <div class="row mb-4">
                    <div class="col-md-8">
                        <div class="form-group">
                          <label class="font-weight-bold">Municipalidad de Trámite:</label>
                            <select class="form-control select2" name="municipalidad_tramite" required>
                                <option value="">Seleccione Municipalidad...</option>
                                @foreach($expedientes as $expediente)
                                    <option value="{{ $expediente->numero_expediente }}">
                                        {{ $expediente->numero_expediente }} - {{ $expediente->municipalidad_tramite }}
                                    </option>
                                @endforeach
                            </select>                       
                         </div>
                    </div>

                </div>

                <!-- Búsqueda de Expediente -->
                <div class="row mb-4">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label class="font-weight-bold">Número de Expediente</label>
                            <select class="form-control select2" name="numero_expediente" required>
                                <option value="">Seleccione un expediente...</option>
                                @foreach($expedientes as $expediente)
                                    <option value="{{ $expediente->numero_expediente }}">
                                        {{ $expediente->numero_expediente }} - {{ $expediente->municipalidad_tramite }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Fecha de Entrevista</label>
                            <input type="date" class="form-control" name="fecha_entrevista" required>
                        </div>
                    </div>
                </div>

                <!-- Secciones Dinámicas -->
                @foreach($encuesta->secciones as $seccion)
                    <div class="card mb-4">
                        <div class="card-header bg-secondary text-white">
                            <h4 class="mb-0">{{ $seccion->titulo }}</h4>
                            @if($seccion->descripcion)
                                <p class="mb-0 small">{{ $seccion->descripcion }}</p>
                            @endif
                        </div>
                        
                        <div class="card-body">
                            @foreach($seccion->preguntas as $pregunta)
                                <div class="form-group mb-4">
                                    <label class="{{ $pregunta->requerida ? 'font-weight-bold required' : '' }}">
                                        {{ $pregunta->pregunta }}
                                    </label>

                                     @include('frontend.encuesta.tipos-respuesta', ['pregunta' => $pregunta])
                                    

                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
                
                <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-paper-plane"></i> Enviar Encuesta
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .required:after {
        content: " *";
        color: red;
    }
    .rating-options {
        display: flex;
        justify-content: space-between;
    }
    .rating-option {
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .form-check-inline {
        margin-right: 1.5rem;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    $('.select2').select2({
        placeholder: 'Seleccione una opción',
        allowClear: true
    });
    
    // Actualizar fecha al seleccionar expediente
    $('select[name="numero_expediente"]').change(function() {
        var expedienteNumero = $(this).val();
        if (expedienteNumero) {
            $.get('/expediente/' + expedienteNumero + '/fecha', function(data) {
                $('input[name="fecha_entrevista"]').val(data.fecha);
            });
        }
    });

    $('.select2').select2({
        placeholder: 'Seleccione una opción',
        allowClear: true,
        width: '100%'
    });

});
</script>
@endpush