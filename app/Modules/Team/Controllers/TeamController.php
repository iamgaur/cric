<?php

namespace App\Modules\Team\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Team\Models\Teams;
use App\Modules\Country\Models\Country;
use App\Http\Requests\TeamValidator;

class TeamController extends Controller {

    public function __construct() {
        
    }

    /**
     * function index().
     */
    public function index() {
        $fetchTeam = Teams::with(['country'])->get()->map(function($item) {
            return collect($item)->only(['id', 'name', 'short_name', 'country_id', 'team_type', 'country'])->all();
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
    public function edit($name, $id) {

        $team = Team::find($id);
        if (!$team) {
            return abort(404);
        }
        $title = __('Edit Team: ' . $name);
        return view('Team::add', compact('team', 'title'));
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
            if ($id = $request->route('id')) {
                $team = Team::find($id);
                $team->fill(array_map('trim', $request->all()));
            } else {
                $team = new Team(array_map('trim', $request->all()));
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
}