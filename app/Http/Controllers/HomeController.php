<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Modules\Country\Models\Country;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $country = Country::whereId(1)->get()->toArray();
        
        return view('frontend.index', ['data'=>$country]);
    }
}
