<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Suspensione;

class SuspensionController extends Controller
{
    function consulta_suspension(){
        
        return view('frontend.suspension.all');

    }
}
