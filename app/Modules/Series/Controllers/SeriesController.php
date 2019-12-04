<?php

namespace App\Modules\Series\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Series\Models\Series;
use App\Modules\Series\Validator\SeriesValidator;
use App\Modules\Team\Models\TeamsType;
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

        $formatType = config('constants.format_type');
        return view('Series::add', compact('series', 'title', 'formatType'));
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
        $formatType = config('constants.format_type');

        return view('Series::add', compact('series', 'title', 'formatType'));
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
                $series->fill(array_map('trim', $request->except(['slug', 'format_type'])));
            } else {
                $insertValues = array_map('trim', $request->except(['slug', 'format_type']));
                $insertValues['slug'] = createSlug($insertValues['name']);

                $series = new Series($insertValues);
            }
            $series->about_series_html = $this->postEditor($request);
            $series->format_type = !empty($request->get('format_type')) ? implode(',', $request->get('format_type')) : $request->get('format_type');
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

    /**
    * function postSummernoteeditor().
    */
    public function postEditor($request) {

        try {
          $detail = $request->about_series_html;
          if (empty($detail)) {
            return $detail;
          }
          $dom = new \DomDocument();
          $dom->loadHtml($detail, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
          $images = $dom->getElementsByTagName('img');

          foreach($images as $k => $img) {

              $data = $img->getAttribute('src');
              list($type, $data) = explode(';', $data);
              list(, $data)      = explode(',', $data);
              $data = base64_decode($data);
              $image_name = time().$k.'.png';
              $folder_path = "/images/series/";
              $public_path = public_path($folder_path);
              $path = $public_path . $image_name;
              file_put_contents($path, $data);
              $img->removeAttribute('src');
              $img->setAttribute('src', $folder_path .  $image_name);
          }
          $detail = $dom->saveHTML();
        } catch (\Exception $e) {
          Log::info($e->getMessage());
        }

        return $detail;
    }
}
