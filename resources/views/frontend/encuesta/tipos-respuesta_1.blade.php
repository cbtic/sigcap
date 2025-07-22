<style>
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
@switch($pregunta->tipo_respuesta)

        
    @case('radio_1')
    <div class="opciones-respuesta d-flex flex-wrap gap-3">
        @foreach($pregunta->opciones as $valor => $texto)
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" 
                       name="respuestas[{{ $pregunta->id }}]" 
                       id="pregunta_{{ $pregunta->id }}_{{ $loop->index }}" 
                       value="{{ $valor }}"
                       {{ $pregunta->requerida ? 'required' : '' }}>
                <label class="form-check-label" for="pregunta_{{ $pregunta->id }}_{{ $loop->index }}">
                    {{ $texto }}
                </label>
            </div>
        @endforeach
    </div>
    @break

    @case('radio_2')
    <div class="btn-group btn-group-toggle" data-toggle="buttons">
        @foreach($pregunta->opciones as $valor => $texto)
            <label class="btn btn-outline-primary">
                <input type="radio" name="respuestas[{{ $pregunta->id }}]" 
                       value="{{ $valor }}" autocomplete="off"
                       {{ $pregunta->requerida ? 'required' : '' }}> 
                {{ $texto }}
            </label>
        @endforeach
    </div>
    @break

    @case('radio')
    <div class="row g-2">
        @foreach($pregunta->opciones as $valor => $texto)
            <div class="col-auto">
                <div class="form-check">
                    <input class="form-check-input" type="radio" 
                           name="respuestas[{{ $pregunta->id }}]" 
                           id="pregunta_{{ $pregunta->id }}_{{ $loop->index }}" 
                           value="{{ $valor }}"
                           {{ $pregunta->requerida ? 'required' : '' }}>
                    <label class="form-check-label" for="pregunta_{{ $pregunta->id }}_{{ $loop->index }}">
                        {{ $texto }}
                    </label>
                </div>
            </div>
        @endforeach
    </div>
    @break

    @case('radio_4')
    <ul class="list-inline">
        @foreach($pregunta->opciones as $valor => $texto)
            <li class="list-inline-item">
                <div class="form-check">
                    <input class="form-check-input" type="radio" 
                           name="respuestas[{{ $pregunta->id }}]" 
                           id="pregunta_{{ $pregunta->id }}_{{ $loop->index }}" 
                           value="{{ $valor }}"
                           {{ $pregunta->requerida ? 'required' : '' }}>
                    <label class="form-check-label" for="pregunta_{{ $pregunta->id }}_{{ $loop->index }}">
                        {{ $texto }}
                    </label>
                </div>
            </li>
        @endforeach
    </ul>
    @break

    @case('radio_5')
    <div class="d-flex flex-wrap gap-2">
        @foreach($pregunta->opciones as $valor => $texto)
            <div class="form-check">
                <input class="form-check-input" type="radio" 
                       name="respuestas[{{ $pregunta->id }}]" 
                       id="pregunta_{{ $pregunta->id }}_{{ $loop->index }}" 
                       value="{{ $valor }}"
                       {{ $pregunta->requerida ? 'required' : '' }}>
                <label class="form-check-label d-flex align-items-center" 
                       for="pregunta_{{ $pregunta->id }}_{{ $loop->index }}">
                    <i class="fas fa-{{ $valor }} me-2"></i> <!-- Ejemplo con Font Awesome -->
                    {{ $texto }}
                </label>
            </div>
        @endforeach
    </div>
    @break

    @case('checkbox')
        <div class="opciones-respuesta">
            @foreach($pregunta->opciones as $valor => $texto)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" 
                           name="respuestas[{{ $pregunta->id }}][]" 
                           id="pregunta_{{ $pregunta->id }}_{{ $loop->index }}" 
                           value="{{ $valor }}">
                    <label class="form-check-label" for="pregunta_{{ $pregunta->id }}_{{ $loop->index }}">
                        {{ $texto }}
                    </label>
                </div>
            @endforeach
        </div>
        @break

    @case('select')
        <select class="form-control" 
                name="respuestas[{{ $pregunta->id }}]" 
                id="pregunta_{{ $pregunta->id }}"
                {{ $pregunta->requerida ? 'required' : '' }}>
            <option value="">Seleccione una opción</option>
            @foreach($pregunta->opciones as $valor => $texto)
                <option value="{{ $valor }}">{{ $texto }}</option>
            @endforeach
        </select>
        @break

    @case('rango')
        <div class="d-flex align-items-center">
            <span class="me-2">{{ $pregunta->opciones['min'] ?? 1 }}</span>
            <input type="range" class="form-range mx-2" 
                   name="respuestas[{{ $pregunta->id }}]" 
                   id="pregunta_{{ $pregunta->id }}"
                   min="{{ $pregunta->opciones['min'] ?? 1 }}" 
                   max="{{ $pregunta->opciones['max'] ?? 5 }}"
                   value="{{ $pregunta->opciones['default'] ?? 3 }}"
                   {{ $pregunta->requerida ? 'required' : '' }}>
            <span class="ms-2">{{ $pregunta->opciones['max'] ?? 5 }}</span>
            <output class="ms-3" id="valor_{{ $pregunta->id }}">{{ $pregunta->opciones['default'] ?? 3 }}</output>
        </div>
        <script>
            document.getElementById('pregunta_{{ $pregunta->id }}').addEventListener('input', function() {
                document.getElementById('valor_{{ $pregunta->id }}').value = this.value;
            });
        </script>
        @break

    @case('numero')
        <input type="number" class="form-control" 
               name="respuestas[{{ $pregunta->id }}]" 
               id="pregunta_{{ $pregunta->id }}"
               min="{{ $pregunta->opciones['min'] ?? '' }}" 
               max="{{ $pregunta->opciones['max'] ?? '' }}"
               step="{{ $pregunta->opciones['step'] ?? '1' }}"
               {{ $pregunta->requerida ? 'required' : '' }}>
        @break

    @case('fecha')
        <input type="date" class="form-control" 
               name="respuestas[{{ $pregunta->id }}]" 
               id="pregunta_{{ $pregunta->id }}"
               min="{{ $pregunta->opciones['min'] ?? '' }}" 
               max="{{ $pregunta->opciones['max'] ?? '' }}"
               {{ $pregunta->requerida ? 'required' : '' }}>
        @break

    @default
        <input type="text" class="form-control" 
               name="respuestas[{{ $pregunta->id }}]" 
               id="pregunta_{{ $pregunta->id }}"
               {{ $pregunta->requerida ? 'required' : '' }}>               
@endswitch