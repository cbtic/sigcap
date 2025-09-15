<div class="form-group mb-4">
    <label class="{{ $requerido ? 'font-weight-bold' : '' }}">{{ $pregunta }}</label>
    <div class="d-flex">
        <div class="form-check mr-3">
            <input class="form-check-input" type="radio" 
                   name="{{ $nombre }}" 
                   id="{{ $nombre }}_si" 
                   value="1"
                   {{ $requerido ? 'required' : '' }}>
            <label class="form-check-label" for="{{ $nombre }}_si">Sí</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" 
                   name="{{ $nombre }}" 
                   id="{{ $nombre }}_no" 
                   value="0">
            <label class="form-check-label" for="{{ $nombre }}_no">No</label>
        </div>
    </div>
</div>