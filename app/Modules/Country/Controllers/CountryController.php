<?php

namespace App\Modules\Country\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\Country\Models\Country;
use App\Http\Requests\CountryValidator;
use DB;
use Log;
use Auth;

class CountryController extends Controller {

    public function __construct() {

    }

    /**
     * function index().
     *
     * @return Illuminate\View\View;
     */
    public function index() {

        $fetchCountry = Country::get()->map(function($item) {
            return collect($item)->only(['id', 'name'])->all();
        });
        return view('Country::index', compact('fetchCountry'));
    }

    /**
     * function add().
     *
     * @description: Add a new Country.
     * @return Illuminate\View\View;
     */
    public function add() {
        $country = new Country();
        $title = __('Add New Country');
        return view('Country::add', compact('country', 'title'));
    }

    /**
     * function edit().
     *
     * @description: edit existing Country.
     * @return Illuminate\View\View;
     */
    public function edit($name, $id) {

        $country = Country::find($id);
        if (!$country) {
            return abort(404);
        }
        $title = __('Edit Country: ' . $name);
        return view('Country::add', compact('country', 'title'));
    }

    /**
     * function save().
     *
     * @description: Save existing or new Country.
     * @return Illuminate\View\View;
     */
    public function save(CountryValidator $request) {
        try {
            DB::beginTransaction();
            if ($id = $request->route('id')) {
                $country = Country::find($id);
                $country->fill(array_map('trim', $request->all()));
            } else {
                $country = new Country(array_map('trim', $request->all()));
            }
            if ($country->save()) {
                DB::commit();
                return redirect()->back()->with(['success' => __('Saved successfully')]);
            }
        } catch (\Exception $ex) {
            DB::rollBack();
            Log::error($ex->getMessage());
        }

        return redirect()->back()->withInput()->withErrors(['message' => __('Some error occured during saving')]);
    }

    /**
     * function delete().
     *
     * @param int $id
     * @return Illuminate\View\View;
     */
    public function delete($id) {
        try {
            DB::beginTransaction();
            $country = Country::find($id);
            if (!$country) {
                return redirect()->back()->withErrors(['message' => __('Country does not exist on our records')]);
            }
            if ($country->delete()) {
                DB::commit();
                return redirect()->back()->with(['success' => __('Saved successfully')]);
            }
        } catch (\Exception $ex) {
            DB::rollBack();
            Log::error($ex->getMessage());
        }

        return redirect()->back()->withErrors(['message' => __('Some error occured during saving')]);
    }
}