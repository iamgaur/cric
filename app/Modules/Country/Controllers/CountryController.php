<?php

namespace App\Modules\Country\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\Country\Models\Country;
use App\Modules\Country\Validator\CountryValidator;
use Illuminate\Support\Facades\Input;
use Validator;
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
                $image = Input::file('image');
                if(!empty($image)){
                  $country->image = $this->_upload_image();
                  if (!empty($image) && !($country->image))
                      return redirect()->back()->withInput()->withErrors(['message' => __('Some error occured during image upload')]);
                }
            } else {
                $insertValues = array_map('trim', $request->except(['slug']));
                $insertValues['slug'] = createSlug($insertValues['name']);
                if(isset($insertValues['image']) && !empty($insertValues['image']) ){
                  $image = $this->_upload_image();
                  if (isset($insertValues['image']) && !empty($insertValues['image']) && !($image))
                      return redirect()->back()->withInput()->withErrors(['message' => __('Some error occured during image upload')]);
                  $insertValues['image'] = $image;
                }
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
     *
     * @return boolean|string
     */
    public function _upload_image() {

        $fileupdate = '';
        $file = array('image' => Input::file('image'));
        $rules = array('image' => 'mimes:jpeg,jpg,png,gif|max:2048'); //mimes:jpeg,bmp,png and for max size max:2048
        $validator = Validator::make($file, $rules);
        if ($validator->fails()) {
            return false;

        } else {
            if (Input::file('image')->isValid()) {

                $destinationPath = 'images/country';
                $extension = Input::file('image')->getClientOriginalExtension();
                $fileName = rand(11111, 99999) . '.' . $extension;
                Input::file('image')->move(public_path($destinationPath), $fileName);
                return $fileName;
            } else {

                return false;
            }
        }
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
