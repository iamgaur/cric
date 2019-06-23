<?php

namespace App\Modules\News\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\News\Validator\NewsValidator;
use App\Modules\News\Models\News;
use DB;
use Log;
use Auth;

class NewsController extends Controller {

    public function __construct() {

    }

    /**
     * function index().
     *
     * @return Illuminate\View\View;
     */
    public function index() {

        $fetchNews = News::get()->map(function($item) {
            return collect($item)->only(['id', 'title', 'slug'])->all();
        });
        return view('News::index', compact('fetchNews'));
    }

    /**
     * function add().
     *
     * @description: Add a new MatchTeams.
     * @return Illuminate\View\View;
     */
    public function add() {
        $news = new News();
        $title = __('Add new news');
        return view('News::add', compact('news', 'title'));
    }

    /**
     * function edit().
     *
     * @description: edit existing MatchTeams.
     * @return Illuminate\View\View;
     */
    public function edit($slug) {

        $news = News::whereSlug($slug)->first();
        if (!$news) {
            return abort(404);
        }
        $title = __('Edit News: ' . $news->title);
        return view('News::add', compact('news', 'title'));
    }

    /**
     * function save().
     *
     * @description: Save existing or new News.
     * @return Illuminate\View\View;
     */
    public function save(NewsValidator $request) {
        try {
            DB::beginTransaction();
            if ($slug = $request->route('slug')) {
                $news = News::whereSlug($slug)->first();
                $slug = $news->slug = createSlug($request->get('title'));
                $news->fill(array_map('trim', $request->except(['slug'])));
            } else {
                $insertValues = array_map('trim', $request->except(['slug']));
                $insertValues['slug'] = createSlug($insertValues['title']);
                $news = new News($insertValues);
            }
            if ($news->save()) {
                DB::commit();
                return ($slug) ? redirect()->to(route('editNews', ['slug' => $slug]))->with(['success' => __('Saved successfully')]) :
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
            $news = News::whereSlug($slug)->first();
            if (!$news) {
                return redirect()->back()->withErrors(['message' => __('News does not exist on our records')]);
            }
            if ($news->delete()) {
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