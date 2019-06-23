<?php

namespace App\Modules\Match\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\Match\Models\Match;
use App\Modules\Match\Validator\MatchValidator;
use App\Modules\Series\Models\Series;
use DB;
use Log;
use Auth;

class MatchController extends Controller {

    public function __construct() {

    }

    /**
     * function index().
     *
     * @return Illuminate\View\View;
     */
    public function index() {

        $fetchMatches = Match::with(['series'])->get()->map(function($item) {
            return collect($item)->only(['id', 'series', 'match_title', 'slug', 'match_date'])->all();
        });
        return view('Match::index', compact('fetchMatches'));
    }

    /**
     * function add().
     *
     * @description: Add a new Match.
     * @return Illuminate\View\View;
     */
    public function add() {
        $match = new Match();
        $title = __('Add New Match');
        $fetchSeries = Series::pluck('name', 'id');
        return view('Match::add', compact('fetchSeries', 'match', 'title'));
    }

    /**
     * function edit().
     *
     * @description: edit existing Match.
     * @return Illuminate\View\View;
     */
    public function edit($slug) {

        $match = Match::whereSlug($slug)->first();
        $fetchSeries = Series::pluck('name', 'id');
        if (!$match) {
            return abort(404);
        }
        $title = __('Edit Match: ' . $match->match_title);
        return view('Match::add', compact('fetchSeries', 'match', 'title'));
    }

    /**
     * function save().
     *
     * @description: Save existing or new Match.
     * @return Illuminate\View\View;
     */
    public function save(MatchValidator $request) {
        try {
            DB::beginTransaction();
            if ($slug = $request->route('slug')) {
                $match = Match::whereSlug($slug)->first();
                $slug = $match->slug = createSlug($request->get('match_title'));
                $match->fill(array_map('trim', $request->except(['slug'])));
            } else {
                $insertValues = array_map('trim', $request->except(['slug']));
                $insertValues['slug'] = createSlug($insertValues['match_title']);
                $match = new Match($insertValues);
            }
            if ($match->save()) {
                DB::commit();
                return ($slug) ? redirect()->to(route('editMatch', ['slug' => $slug]))->with(['success' => __('Saved successfully')]) :
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
            $match = Match::whereSlug($slug)->first();
            if (!$match) {
                return redirect()->back()->withErrors(['message' => __('Match does not exist on our records')]);
            }
            if ($match->delete()) {
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