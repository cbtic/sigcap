
@extends('frontend.layouts.app')

@section('title', __('Dashboard'))

@if(
    !$logged_in_user->persona->numero_ruc ||
    !$logged_in_user->persona->telefono_fijo ||
    !$logged_in_user->persona->numero_celular ||
    !$logged_in_user->persona->correo ||
    !$logged_in_user->persona->direccion
)
    @push('after-scripts')
    <script>
        $(function(){

            let msg = "Falta Actualizar: <br>";

            @if (!$logged_in_user->persona->numero_ruc)msg+="Numero RUC <br>";
            @endif

            @if (!$logged_in_user->persona->telefono_fijo)msg+="Telefono Fijo <br>";
            @endif

            @if (!$logged_in_user->persona->numero_celular)msg+="Numero Celular <br>";
            @endif

            @if (!$logged_in_user->persona->correo)msg+="Correo <br>";
            @endif

            @if (!$logged_in_user->persona->direccion)msg+="Direccion <br>";
            @endif
            msg+="Para Actualizar sus datos dar ";
            msg+='<a href="{{route('frontend.user.account')}}">Clic aqui </a>';

            bootbox.alert(msg);
        })
    </script>
    @endpush

@endif

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <x-frontend.card>
                    <x-slot name="header">
                        @lang('Dashboard')
                    </x-slot>

                    <x-slot name="body">
                        @lang('You are logged in!')
                    </x-slot>
                </x-frontend.card>
            </div><!--col-md-10-->
        </div><!--row-->
    </div><!--container-->
@endsection
