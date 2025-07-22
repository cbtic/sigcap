@php
    $opciones = json_decode($pregunta->opciones, true);
    $niveles = $opciones['niveles'] ?? ['Presenta dificultad', 'Estado promedio', 'Logra excelencia'];
@endphp

<div class="niveles-desempeno">
    <div class="d-flex justify-content-between mb-2">
        @foreach($niveles as $index => $nivel)
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" 
                       name="{{ $nombreCampo }}" 
                       id="{{ $nombreCampo }}_{{ $index }}" 
                       value="{{ $index + 1 }}"
                       {{ $pregunta->requerida ? 'required' : '' }}>
                <label class="form-check-label" for="{{ $nombreCampo }}_{{ $index }}">
                    {{ $nivel }}
                </label>
            </div>
        @endforeach
    </div>
</div>

<style>
    .niveles-desempeno {
        background-color: #f8f9fa;
        padding: 1rem;
        border-radius: 0.25rem;
    }
    .form-check-inline {
        margin-right: 0;
        flex: 1;
        text-align: center;
    }
    .form-check-input {
        margin-right: 0.5rem;
    }
</style>