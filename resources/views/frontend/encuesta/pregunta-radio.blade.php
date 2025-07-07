<div class="form-group mb-4">
    <label class="{{ $requerido ? 'font-weight-bold' : '' }}">{{ $pregunta }}</label>
    <div class="d-flex justify-content-between">
        @for($i = 1; $i <= 5; $i++)
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" 
                       name="{{ $nombre }}" 
                       id="{{ $nombre }}_{{ $i }}" 
                       value="{{ $i }}"
                       {{ $requerido ? 'required' : '' }}>
                <label class="form-check-label" for="{{ $nombre }}_{{ $i }}">{{ $i }}</label>
            </div>
        @endfor
    </div>
</div>