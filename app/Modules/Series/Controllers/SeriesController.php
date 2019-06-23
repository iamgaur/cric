<?php

namespace App\Modules\Series\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Series\Models\Series;
use App\Http\Requests\SeriesValidator;
use DB;
use Log;

class SeriesController extends Controller {

    public function __construct() {
        
    }

    /**
     * function index().
     */
    public function index() {
        $fetchSeries = Series::get()->map(function($item) {
            return collect($item)->only(['id', 'name', 'series_start_date', 'series_end_date', 'slug', 'posted', 'status', 'meta_title', 'meta_description', 'meta_keywords'])->all();
        });

        return view('Series::index', compact('fetchSeries'));
    }

    /**
     * function add.
     *
     * @return Illuminate\View\View
     */
    public function add() {
        $series = new Series();
        $title = __('Add New Series');
        return view('Series::add', compact('series', 'title'));
    }

    /**
     * function edit().
     *
     * @description: edit existing Series.
     * @return Illuminate\View\View
     */
    public function edit($slug) {

        $series = Series::whereSlug($slug)->first();
        if (!$series) {
            return abort(404);
        }
        $title = __('Edit Series: ' . $series->name);
        return view('Series::add', compact('series', 'title'));
    }
 
    /**
     * function save().
     *
     * @description: Save existing or new Series.
     * @return Illuminate\View\View;
     */
    public function save(SeriesValidator $request) {
        try {
            DB::beginTransaction();
            if ($slug = $request->route('slug')) {
                $series = Series::whereSlug($slug)->first();
                $slug = $series->slug = createSlug($request->get('name'));
                $series->fill(array_map('trim', $request->except(['slug'])));
            } else {
                $insertValues = array_map('trim', $request->except(['slug']));
                $insertValues['slug'] = createSlug($insertValues['name']);

                $series = new Series($insertValues);
            }
            if ($series->save()) {
                DB::commit();
                return ($slug) ? redirect()->to(route('editSeries', ['slug' => $slug]))->with(['success' => __('Saved successfully')]) :
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
            $series = Series::whereSlug($slug)->first();
            if (!$series) {
                return redirect()->back()->withErrors(['message' => __('Series does not exist on our records')]);
            }
            if ($series->delete()) {
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