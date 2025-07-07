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
<div class="container">
    <h2 class="text-center mb-4">ENCUESTA DE CALIDAD DE EVALUADORES</h2>
    
    <form method="POST" action="{{ route('frontend.encuesta.guardar') }}">
        @csrf
        
        <!-- Sección 1: Datos Generales -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h4>Datos Generales</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Municipalidad de Trámite</label>
                            <input type="text" class="form-control" name="municipalidad" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Fecha de Entrevista</label>
                            <input type="date" class="form-control" name="fecha_entrevista" required>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Número de Expediente</label>
                    <input type="text" class="form-control" name="numero_expediente" required>
                </div>
            </div>
        </div>

        <!-- Sección 2: Conocimiento Técnico -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h4>OPINIÓN DEL CONOCIMIENTO TÉCNICO Y NORMATIVO</h4>
                <p>Califique cada ítem del 1 al 5, siendo 1 que el servicio fue insatisfactorio y 5 que el servicio fue muy satisfactorio</p>
            </div>
            <div class="card-body">
                @include('frontend.encuesta.pregunta-radio', [
                    'pregunta' => 'Las observaciones tenían sustento normativo específico',
                    'nombre' => 'sustento_normativo',
                    'requerido' => true
                ])
                
                @include('frontend.encuesta.pregunta-radio', [
                    'pregunta' => 'Además del artículo normativo, le especificaron la falta cometida en el proyecto',
                    'nombre' => 'especificacion_falta',
                    'requerido' => true
                ])
                
                <!-- Más preguntas de esta sección -->
            </div>
        </div>

        <!-- Sección 3: Calidad del Servicio -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h4>OPINIÓN DE LA CALIDAD DEL SERVICIO</h4>
            </div>
            <div class="card-body">
                @include('frontend.encuesta.pregunta-radio-sino', [
                    'pregunta' => '¿Le aclararon sus dudas en la entrevista?',
                    'nombre' => 'aclararon_dudas',
                    'requerido' => true
                ])
                
                <!-- Más preguntas de esta sección -->
            </div>
        </div>

        <!-- Sección 4: Evaluación del Presidente -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h4>OPINIÓN SOBRE EL DESEMPEÑO DEL PRESIDENTE DE LA COMISIÓN TÉCNICA</h4>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label>Nombre o colegiatura del Presidente de la Comisión Técnica</label>
                    <select class="form-control" name="presidente_id" required>
                        <option value="">Seleccione...</option>
                        @foreach($presidentes as $presidente)
                            <option value="{{ $presidente->id }}">{{ $presidente->nombre }} ({{ $presidente->numero_cap }})</option>
                        @endforeach
                    </select>
                </div>
                
                @include('frontend.encuesta.pregunta-radio', [
                    'pregunta' => 'Conocimiento Técnico y Normativo',
                    'nombre' => 'presidente_conocimiento',
                    'requerido' => true
                ])
                
                <!-- Más preguntas sobre el presidente -->
            </div>
        </div>

        <!-- Otras secciones (Delegados, Especialistas, etc.) -->

        <div class="text-center">
            <button type="submit" class="btn btn-primary btn-lg">Enviar Encuesta</button>
        </div>
    </form>
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