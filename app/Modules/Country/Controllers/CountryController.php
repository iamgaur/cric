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
            return collect($item)->only(['id', 'name', 'slug'])->all();
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
    public function edit($slug) {

        $country = Country::whereSlug($slug)->first();
        if (!$country) {
            return abort(404);
        }
        $title = __('Edit Country: ' . $country->name);
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
            if ($slug = $request->route('slug')) {
                $country = Country::whereSlug($slug)->first();
                $slug = $country->slug = createSlug($request->get('name'));
                $country->fill(array_map('trim', $request->except(['slug'])));
            } else {
                $insertValues = array_map('trim', $request->except(['slug']));
                $insertValues['slug'] = createSlug($insertValues['name']);
                $country = new Country($insertValues);
            }
            if ($country->save()) {
                DB::commit();
                return ($slug) ? redirect()->to(route('editCountry', ['slug' => $slug]))->with(['success' => __('Saved successfully')]) :
                    redirect()->back()->with(['success' => __('Saved successfully')]);
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
     * @param int $slug
     * @return Illuminate\View\View;
     */
    public function delete($slug) {
        try {
            DB::beginTransaction();
            $country = Country::whereSlug($slug)->first();
            if (!$country) {
                return redirect()->back()->withErrors(['message' => __('Country does not exist on our records')]);
            }
            if ($country->delete()) {
                DB::commit();
                return redirect()->back()->with(['success' => __('Deleted successfully')]);
            }
        } catch (\Exception $ex) {
            DB::rollBack();
            Log::error($ex->getMessage());
        }

        return redirect()->back()->withErrors(['message' => __('Some error occured during saving')]);
    }
}