<?php

namespace App\Http\Controllers\Frontend;
use Auth;
/**
 * Class HomeController.
 */
class HomeController
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
		
        //return view('frontend.index');
		//return redirect("/login"); 
		
		if(!Auth::check()) {
			return redirect('login');
		}else{
			return redirect('account');
		}
		
    }
}
