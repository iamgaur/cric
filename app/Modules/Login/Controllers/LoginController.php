<?php

namespace App\Modules\Login\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Log;
use App\Modules\Login\Validator\LoginValidator;

class LoginController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        
    }

    /**
     * function index()
     *
     * @return Illuminate\View\View
     */
    public function index() {

        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('Login::login.index');
    }

    /**
     * function postIndex()
     * @param LoginValidator $request
     *
     * @return Illuminate\View\View
     */
    public function postIndex(LoginValidator $request) {

        try {

            if (Auth::attempt($request->except(['_token']))) {
                return redirect()->route('dashboard');
            }

            return redirect()->back()->withErrors(['invalid_attempt' => __('Incorrect username or password')]);

        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
        }
    }

    /**
     * function logout()
     *
     * @return Illuminate\Support\Facades\Redirect
     */
    public function logout() {
        Auth::logout();
        return redirect()->route('login');
    }
}
