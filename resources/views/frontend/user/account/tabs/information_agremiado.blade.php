<x-forms.patch :action="route('frontend.user.perfil.update')">
    <div class="form-group row">
        <label for="numero_ruc" class="col-md-3 col-form-label text-md-right">@lang('N° RUC')</label>

        <div class="col-md-9">
            <input type="text" name="numero_ruc" class="form-control" placeholder="{{ __('N° RUC') }}" value="{{ old('numero_ruc') ?? $logged_in_user->persona->numero_ruc }}" required autofocus autocomplete="numero_ruc" />
        </div>
    </div><!--form-group-->

    <div class="form-group row">
        <label for="telefono_fijo" class="col-md-3 col-form-label text-md-right">@lang('Telefono Fijo')</label>

        <div class="col-md-9">
            <input type="text" name="telefono_fijo" class="form-control" placeholder="{{ __('Telefono Fijo') }}" value="{{ old('telefono_fijo') ?? $logged_in_user->persona->telefono_fijo }}" required autofocus autocomplete="telefono_fijo" />
        </div>
    </div><!--form-group-->

    <div class="form-group row">
        <label for="numero_celular" class="col-md-3 col-form-label text-md-right">@lang('Celular')</label>

        <div class="col-md-9">
            <input type="text" name="numero_celular" class="form-control" placeholder="{{ __('Celular') }}" value="{{ old('numero_celular') ?? $logged_in_user->persona->numero_celular }}" required autofocus autocomplete="numero_celular" />
        </div>
    </div><!--form-group-->

    <div class="form-group row">
        <label for="correo" class="col-md-3 col-form-label text-md-right">@lang('Correo')</label>

        <div class="col-md-9">
            <input type="text" name="correo" class="form-control" placeholder="{{ __('Correo') }}" value="{{ old('correo') ?? $logged_in_user->persona->correo }}" required autofocus autocomplete="correo" />
        </div>
    </div><!--form-group-->

    <div class="form-group row">
        <label for="direccion" class="col-md-3 col-form-label text-md-right">@lang('Direccion')</label>

        <div class="col-md-9">
            <input type="text" name="direccion" class="form-control" placeholder="{{ __('Direccion') }}" value="{{ old('direccion') ?? $logged_in_user->persona->direccion }}" required autofocus autocomplete="direccion" />
        </div>
    </div><!--form-group-->
   
    <div class="form-group row mb-0">
        <div class="col-md-12 text-right">
            <button class="btn btn-sm btn-primary float-right" type="submit">@lang('Update')</button>
        </div>
    </div><!--form-group-->
</x-forms.patch>
