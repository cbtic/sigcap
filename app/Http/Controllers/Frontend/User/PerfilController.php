<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Persona;

class PerfilController extends Controller
{
    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'numero_ruc'           => 'nullable|max:20',
            'telefono_fijo' => 'nullable|string|max:20',
            'numero_celular'       => 'required|string|max:20',
            'correo'        => 'required|email|max:255',
            'direccion'     => 'required|string|max:255',
        ]);

        //dd($user->persona);

        $user->persona->update($request->only([
            'numero_ruc','telefono_fijo','numero_celular','correo','direccion'
        ]));

        return redirect()
            ->route('frontend.user.account')
            ->withFlashSuccess(__('Los datos de la persona se actualizaron correctamente.'));
    }
}
