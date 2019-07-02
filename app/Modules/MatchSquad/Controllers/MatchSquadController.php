<?php

namespace App\Modules\MatchSquad\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\MatchSquad\Models\MatchSquad;
use App\Modules\Team\Models\Teams;
use App\Modules\Player\Models\PlayerTeams;
use App\Modules\Player\Models\Player;
use DB;
use Log;
use Auth;

class MatchSquadController extends Controller {

    public function __construct() {

    }

    /**
     * function index().
     *
     * @return Illuminate\View\View;
     */
    public function index() {

        $fetchMatchSquads = MatchSquad::get()->map(function($item) {
            $item->firstTeam_name = Teams::whereId($item->first_team)->first()->name;
            $item->secondTeam_name = Teams::whereId($item->second_team)->first()->name;

            return collect($item)->only(['match_id', 'slug', 'first_team', 'second_team', 'firstTeam_name', 'secondTeam_name'])->all();
        });

        return view('MatchSquad::index', compact('fetchMatchSquads'));
    }

    /**
     * function edit().
     *
     * @description: edit existing Match.
     * @return Illuminate\View\View;
     */
    public function edit($slug) {

        $matchSquad = MatchSquad::whereSlug($slug)->get()->map(function($item) {
            $item->first_team_name = Teams::whereId($item->first_team)->first()->name;
            $item->second_team_name = Teams::whereId($item->second_team)->first()->name;
            return $item;
        })->first();
        if (!$matchSquad) {
            return abort(404);
        }
        $firstTeamPlayers = PlayerTeams::whereTeamId($matchSquad->first_team)->get()->map(function($item) {
            $item->player_name = Player::wherePid($item->pid)->first()->player_name;
            return $item;
        });
        $secondTeamPlayers = PlayerTeams::whereTeamId($matchSquad->second_team)->get()->map(function($item) {
            $item->player_name = Player::wherePid($item->pid)->first()->player_name;
            return $item;
        });
        $firstTeamSelectedPlayers = !empty($matchSquad->first_players_json) ? json_decode($matchSquad->first_players_json, 1) : array();
        $secondTeamSelectedPlayers = !empty($matchSquad->second_players_json) ? json_decode($matchSquad->second_players_json, 1) : array();
        $title = __('Edit Match: ' . $matchSquad->slug);
        return view('MatchSquad::add', compact('matchSquad', 'firstTeamPlayers', 'secondTeamPlayers', 'title', 'firstTeamSelectedPlayers', 'secondTeamSelectedPlayers'));
    }

    /**
     * function save().
     *
     * @description: Save existing or new Match.
     * @return Illuminate\View\View;
     */
    public function save(Request $request) {
        try {
            DB::beginTransaction();
            if ($slug = $request->route('slug')) {
                $matchSquad = MatchSquad::whereSlug($slug)->first();
                if (!$matchSquad)
                    redirect()->back()->withErrors(['message' => __('slug is not valid')]);
                $firstTeam = empty($request->get('teamA')) ? array() : $request->get('teamA');
                $secondTeam = empty($request->get('teamB')) ? array() : $request->get('teamB');

                $jsonTeamA = $jsonTeamB = array();
                foreach ($firstTeam as $teamA) {
                    $jsonTeamA[$teamA] = $teamA;
                }
                foreach ($secondTeam as $teamB) {
                    $jsonTeamB[$teamB] = $teamB;
                }
                $insetValues = $request->except(['slug', 'teamA', 'teamB']);
                $insetValues['first_players_json'] = json_encode($jsonTeamA);
                $insetValues['second_players_json'] = json_encode($jsonTeamB);
                $matchSquad->fill(array_map('trim', $insetValues));
            }
            if ($matchSquad->save()) {
                DB::commit();
                return ($slug) ? redirect()->to(route('editMatchSquad', ['slug' => $slug]))->with(['success' => __('Saved successfully')]) :
                    redirect()->back()->withErrors(['message' => __('No slug found')]);
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
            $matchSquad = MatchSquad::whereSlug($slug)->first();
            if (!$matchSquad) {
                return redirect()->back()->withErrors(['message' => __('Match squad does not exist on our records')]);
            }
            if ($matchSquad->delete()) {
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