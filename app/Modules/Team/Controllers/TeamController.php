<?php

namespace App\Modules\Team\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Team\Models\Teams;
use App\Modules\Country\Models\Country;
use App\Http\Requests\TeamValidator;
use DB;
use Log;

class TeamController extends Controller {

    public function __construct() {
        
    }

    /**
     * function index().
     */
    public function index() {
        $fetchTeam = Teams::with(['country'])->get()->map(function($item) {
            return collect($item)->only(['id', 'name', 'slug', 'short_name', 'country_id', 'team_type', 'country'])->all();
        });

        return view('Team::index', compact('fetchTeam'));
    }

    /**
     * function add.
     *
     * @return Illuminate\View\View
     */
    public function add() {
        $team = new Teams();
        $countries = Country::pluck('name', 'id');
        $title = __('Add New Team');
        return view('Team::add', compact('countries', 'team', 'title'));
    }

    /**
     * function edit().
     *
     * @description: edit existing Team.
     * @return Illuminate\View\View
     */
    public function edit($slug) {

        $team = Teams::whereSlug($slug)->first();
        $countries = Country::pluck('name', 'id');
        if (!$team) {
            return abort(404);
        }
        $title = __('Edit Team: ' . $team->name);
        return view('Team::add', compact('countries', 'team', 'title'));
    }
 
    /**
     * function save().
     *
     * @description: Save existing or new Team.
     * @return Illuminate\View\View;
     */
    public function save(TeamValidator $request) {
        try {
            DB::beginTransaction();
            if ($slug = $request->route('slug')) {
                $team = Teams::whereSlug($slug)->first();
                $team->fill(array_map('trim', $request->except(['slug'])));
            } else {
                $insertValues = array_map('trim', $request->except(['slug']));
                $insertValues['slug'] = createSlug($insertValues['name']);

                $team = new Teams($insertValues);
            }
            if ($team->save()) {
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
     * @param int $slug
     * @return Illuminate\View\View;
     */
    public function delete($slug) {
        try {
            DB::beginTransaction();
            $team = Teams::whereSlug($slug)->first();
            if (!$team) {
                return redirect()->back()->withErrors(['message' => __('Team does not exist on our records')]);
            }
            if ($team->delete()) {
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