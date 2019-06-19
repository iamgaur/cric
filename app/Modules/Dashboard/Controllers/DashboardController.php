<?php

namespace App\Modules\Dashboard\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class DashboardController extends Controller {

    public function __construct() {
        
    }

    /**
     * function index().
     *
     * @return Illuminate\View\View;
     */
    public function index() {

        return view('Dashboard::index');
    }

}
