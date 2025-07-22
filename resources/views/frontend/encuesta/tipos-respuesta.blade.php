@php
    $opciones = json_decode($pregunta->opciones, true) ?? [];
    $nombreCampo = "respuestas[{$pregunta->id}]";
@endphp

@switch($pregunta->tipo_respuesta)
    @case('radio_')
        <!-- Escala del 1 al 5 -->
        <div class="rating-options">
            @for($i = 1; $i <= 5; $i++)
                <div class="rating-option">
                    <input type="radio" 
                           name="{{ $nombreCampo }}" 
                           id="{{ $nombreCampo }}_{{ $i }}" 
                           value="{{ $i }}"
                           {{ $pregunta->requerida ? 'required' : '' }}>
                    <label for="{{ $nombreCampo }}_{{ $i }}">{{ $i }}</label>
                </div>
            @endfor
        </div>
        @break

    @case('radio')
    <div class="d-flex flex-wrap gap-3">
        @foreach(json_decode($pregunta->opciones, true)['custom_options'] ?? range(1, 5) as $valor => $texto)
            <div class="form-check">
                <input class="form-check-input" type="radio" 
                       name="{{ $nombreCampo }}" 
                       id="{{ $nombreCampo }}_{{ is_string($valor) ? $valor : $loop->index }}" 
                       value="{{ $valor }}"
                       {{ $pregunta->requerida ? 'required' : '' }}>
                <label class="form-check-label" for="{{ $nombreCampo }}_{{ is_string($valor) ? $valor : $loop->index }}">
                    {{ is_string($texto) ? $texto : $valor }}
                </label>
            </div>
        @endforeach
    </div>
    @break        

    @case('si_no')
        <!-- Preguntas Sí/No -->
        <div class="d-flex">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" 
                       name="{{ $nombreCampo }}" 
                       id="{{ $nombreCampo }}_si" 
                       value="1"
                       {{ $pregunta->requerida ? 'required' : '' }}>
                <label class="form-check-label" for="{{ $nombreCampo }}_si">Sí</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" 
                       name="{{ $nombreCampo }}" 
                       id="{{ $nombreCampo }}_no" 
                       value="0">
                <label class="form-check-label" for="{{ $nombreCampo }}_no">No</label>
            </div>
        </div>
        @break

    @case('select')
        @php
            $opciones = json_decode($pregunta->opciones, true) ?? [];
            $tipoEvaluador = $opciones['tipo_evaluador'] ?? null;
        @endphp

        @if($tipoEvaluador)
            <!-- Select para evaluadores filtrados por tipo -->
            <select class="form-control select2" 
                    name="{{ $nombreCampo }}"
                    {{ $pregunta->requerida ? 'required' : '' }}>
                <option value="">Seleccione evaluador...</option>
                @foreach(${$tipoEvaluador} as $evaluador)
                    <option value="{{ $evaluador->id }}">
                        {{ $evaluador->nombre }} ({{ $evaluador->numero_cap }})
                        @if($evaluador->especialidad)
                            - {{ $evaluador->especialidad }}
                        @endif
                    </option>
                @endforeach
            </select>
        @else
            <!-- Select genérico para opciones normales -->
            <select class="form-control" 
                    name="{{ $nombreCampo }}"
                    {{ $pregunta->requerida ? 'required' : '' }}>
                <option value="">Seleccione...</option>
                @foreach($opciones as $valor => $texto)
                    <option value="{{ $valor }}">{{ $texto }}</option>
                @endforeach
            </select>
        @endif
    @break

    @case('checkbox')
        <!-- Múltiple selección -->
        <div class="row">
            @foreach($opciones as $valor => $texto)
                <div class="col-md-4 mb-2">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" 
                               name="{{ $nombreCampo }}[]" 
                               id="{{ $nombreCampo }}_{{ $loop->index }}" 
                               value="{{ $valor }}">
                        <label class="form-check-label" for="{{ $nombreCampo }}_{{ $loop->index }}">
                            {{ $texto }}
                        </label>
                    </div>
                </div>
            @endforeach
        </div>
        @break

    @case('rango')
        <!-- Slider con valores -->
        <div class="d-flex align-items-center">
            <span>{{ $opciones['min'] ?? 1 }}</span>
            <input type="range" class="form-range mx-3" 
                   name="{{ $nombreCampo }}"
                   min="{{ $opciones['min'] ?? 1 }}" 
                   max="{{ $opciones['max'] ?? 5 }}"
                   value="{{ $opciones['default'] ?? 3 }}"
                   oninput="document.getElementById('rangeValue{{ $pregunta->id }}').innerText = this.value"
                   {{ $pregunta->requerida ? 'required' : '' }}>
            <span>{{ $opciones['max'] ?? 5 }}</span>
            <span class="badge bg-primary ms-2" id="rangeValue{{ $pregunta->id }}">
                {{ $opciones['default'] ?? 3 }}
            </span>
        </div>
        @break

    @case('numero')
        <!-- Input numérico -->
        <input type="number" class="form-control" 
               name="{{ $nombreCampo }}"
               min="{{ $opciones['min'] ?? '' }}" 
               max="{{ $opciones['max'] ?? '' }}"
               step="{{ $opciones['step'] ?? 1 }}"
               {{ $pregunta->requerida ? 'required' : '' }}>
        @break

    @case('fecha')
        <!-- Selector de fecha -->
        <input type="date" class="form-control" 
               name="{{ $nombreCampo }}"
               min="{{ $opciones['min'] ?? '' }}" 
               max="{{ $opciones['max'] ?? '' }}"
               {{ $pregunta->requerida ? 'required' : '' }}>
        @break

    @case('texto')
        @php
            $opciones = json_decode($pregunta->opciones, true) ?? [];
            $multilinea = $opciones['multilinea'] ?? false;
            $filas = $opciones['filas'] ?? 3;
            $maxlength = $opciones['maxlength'] ?? null;
            $placeholder = $opciones['placeholder'] ?? '';
        @endphp

        @if($multilinea)
            <!-- Textarea para respuestas largas -->
            <textarea class="form-control" 
                    name="{{ $nombreCampo }}"
                    rows="{{ $filas }}"
                    placeholder="{{ $placeholder }}"
                    @if($maxlength) maxlength="{{ $maxlength }}" @endif
                    {{ $pregunta->requerida ? 'required' : '' }}></textarea>
        @else
            <!-- Input para texto simple -->
            <input type="text" class="form-control" 
                name="{{ $nombreCampo }}"
                placeholder="{{ $placeholder }}"
                @if($maxlength) maxlength="{{ $maxlength }}" @endif
                {{ $pregunta->requerida ? 'required' : '' }}>
        @endif

        @if($maxlength)
            <small class="text-muted d-block text-end">
                <span id="contador_{{ $pregunta->id }}">0</span>/{{ $maxlength }} caracteres
            </small>
            <script>
                document.querySelector('[name="{{ $nombreCampo }}"]').addEventListener('input', function() {
                    document.getElementById('contador_{{ $pregunta->id }}').textContent = this.value.length;
                });
            </script>
        @endif
    @break

    @default
        <!-- Texto libre -->
        @if(isset($opciones['multilinea']) && $opciones['multilinea'])
            <textarea class="form-control" 
                      name="{{ $nombreCampo }}"
                      rows="{{ $opciones['filas'] ?? 3 }}"
                      placeholder="{{ $opciones['placeholder'] ?? '' }}"
                      {{ $pregunta->requerida ? 'required' : '' }}></textarea>
        @else
            <input type="text" class="form-control" 
                   name="{{ $nombreCampo }}"
                   placeholder="{{ $opciones['placeholder'] ?? '' }}"
                   {{ $pregunta->requerida ? 'required' : '' }}>
        @endif
@endswitch