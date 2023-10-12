<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TipoConcepto;

class TipoConceptoController extends Controller
{
    function consulta_tipoConcepto(){
        
        return view('frontend.tipoConcepto.all');

    }
}
