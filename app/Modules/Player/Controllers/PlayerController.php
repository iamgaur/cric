<?php

namespace App\Modules\Player\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\Player\Models\Player;
use App\Modules\Player\Models\PlayerTeams;
use App\Modules\Team\Models\Teams;
use DB;
use Log;
use Auth;

class PlayerController extends Controller {

    public function __construct() {

    }

    /**
     * function index().
     *
     * @return Illuminate\View\View;
     */
    public function index() {

        $fetchPlayer = Player::get()->map(function($item) {
            return collect($item)->only(['pid', 'player_name', 'p_slug', 'c_slug'])->all();
        });
        return view('Player::index', compact('fetchPlayer'));
    }

    /**
     * function add().
     *
     * @description: Add a new Country.
     * @return Illuminate\View\View;
     */
    public function add() {
        $player = new Player();
        $title = __('Add New Player');
        $playerTeams = array();
        $team_type = array_flip(config('constants.team_type'));
        $nationalTeamList = Teams::whereTeamType($team_type['National'])->get(['name', 'id', 'team_type']);
        $clubTeamList = Teams::whereTeamType($team_type['IPL'])->get(['name', 'id', 'team_type']);
        return view('Player::add', compact('playerTeams', 'clubTeamList', 'nationalTeamList', 'player', 'title'));
    }

    /**
     * function edit().
     *
     * @description: edit existing Country.
     * @return Illuminate\View\View;
     */
    public function edit($p_slug, $c_slug) {

        $player = Player::wherePSlug($p_slug)->whereCSlug($c_slug)->first();
        $team_type = array_flip(config('constants.team_type'));
        $nationalTeamList = Teams::whereTeamType($team_type['National'])->get(['name', 'id', 'team_type']);
        $clubTeamList = Teams::whereTeamType($team_type['IPL'])->get(['name', 'id', 'team_type']);
        $playerTeams = array();
        if (PlayerTeams::wherePid($player->pid)->count()) {
            $playerTeams = PlayerTeams::wherePid($player->pid)->get()->toArray();
        }
        if (!$player) {
            return abort(404);
        }
        $title = __('Edit Player: ' . $player->name);
        return view('Player::add', compact('playerTeams', 'clubTeamList', 'nationalTeamList','player', 'title'));
    }

    /**
     * function save().
     *
     * @description: Save existing or new Country.
     * @return Illuminate\View\View;
     */
    public function save(Request $request) {
        try {
            DB::beginTransaction();
            if (($p_slug = $request->route('p_slug')) && ($c_slug = $request->route('c_slug')) ) {
                $validator = self::validatePlayer($request, 'edit');
                if (!$validator['success']) {
                    return redirect()->back()->withInput()->withErrors(['message' => __($validator['error'])]);
                }
                $player = Player::wherePSlug($p_slug)->whereCSlug($c_slug)->first();
                $p_slug = $player->p_slug = createSlug($request->get('player_name'));
                if ($response = $this->__getTeamCountrySlug($request)) {
                    if (!$response['success'])
                        throw new \Exception($response['error']);
                    $player->c_slug = $response['slug'];
                }
                $player->fill(array_map('trim', $request->except(['team_country', 'p_slug', 'c_slug'])));
                PlayerTeams::wherePid($player->pid)->delete();
                $team_country =  $request->get('team_country');
            } else {
                $validator = self::validatePlayer($request, 'add');
                if (!$validator['success']) {
                    return redirect()->back()->withInput()->withErrors(['message' => __($validator['error'])]);
                }
                $insertValues = array_map('trim', $request->except(['team_country', 'p_slug', 'c_slug']));
                $insertValues['p_slug'] = createSlug($insertValues['player_name']);
                $team_country =  $request->get('team_country');
                $team = Teams::find($team_country['team'][0]['team_id']);
                $insertValues['c_slug'] = $team->slug;

                $player = new Player($insertValues);
            }
            if ($player->save()) {
                $teams = $team_country['team'];
                $player_teams = array();
                $j = 0;
                foreach ($teams as $key => $teamCountry) {
                    $player_teams[$j]['team_type'] =  ($key == 0) ? 1 : 2;
                    $player_teams[$j]['pid'] = $player->pid;
                    $player_teams[$j]['time_from'] = $teamCountry['start_date'];
                    $player_teams[$j]['time_to'] = $teamCountry['end_date'];
                    $player_teams[$j]['team_id'] = $teamCountry['team_id'];
                    $j++;
                }
                PlayerTeams::insert($player_teams);
                DB::commit();
                return ($p_slug && $c_slug) ? redirect()->to(route('editPlayer', ['p_slug' => $p_slug, 'c_slug' => $c_slug]))->with(['success' => __('Saved successfully')]) :
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
     * @param int $id
     * @return Illuminate\View\View;
     */
    public function delete($id) {
        try {
            DB::beginTransaction();
            $player = Player::find($id);
            $pid = $player->pid;
            if (!$player) {
                return redirect()->back()->withErrors(['message' => __('Player does not exist on our records')]);
            }
            if ($player->delete()) {
                PlayerTeams::wherePid($pid)->delete();
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
     * functionvalidatePlayer().
     *
     * @param string $mode
     */
    protected function validatePlayer($request, $mode = 'add') {
        try {
            $validator = ['success' => false, 'error' => null];
            $post = $request->all();
           
            $response = $this->__getTeamCountrySlug($request);
            if (!$response['success']) {
                $validator['error'] = $response['error'];
                return $validator;
            }
            if (empty(trim($post['player_name']))) {
                $validator['error'] = 'Player name is required';
                return $validator;
            }
            $p_slug = createSlug($post['player_name']);
            $c_slug = $response['slug'];
            $dataExist = true;
            switch ($mode) {
                case 'add':
                    $dataExist = Player::wherePlayerName($post['player_name'])->wherePSlug($p_slug)->whereCSlug($c_slug)
                            ->count();
                    break;
                case 'edit':
                    $dataExist = Player::wherePlayerName($post['player_name'])->where('p_slug' ,'<>', $p_slug)->where('c_slug' ,'<>', $c_slug)
                            ->count();
                    break;
            }
            if (!$dataExist)
                $validator['success'] = true;
            else
                $validator['error'] = 'Data already exist in our record';
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
            $validator['error'] = __('Some error occured');
        }

        return $validator;
        
    }

    /**
     * function __getTeamCountrySlug().
     *
     * @param Request $request
     * @throws \Exception
     */
    private function __getTeamCountrySlug($request) {
        try {
            $response = ['success' => false, 'erorr' => null, 'slug' => null];
            $team_country = $request->get('team_country');
            if (isset($team_country['team'][1]) &&  empty($team_country['team'][1]['team_id']) ) {
                $response['error'] = 'Club does not exist';
                return $response;
            }
            if (isset($team_country['team'][0]) && isset($team_country['team'][0]['team_id']) && !empty($team_country['team'][0]['team_id'])) {
               
                $team = Teams::find($team_country['team'][0]['team_id']);
                if ($team) {
                    $response['success'] = true;
                    $response['slug'] = $team->slug;
                } else {
                    throw new \Exception('Selected National Team does not match our records');
                }
            } else {
                throw new \Exception('National Team does not exist');
            }
        } catch (\Exception $ex) {
            $response ['error'] = $ex->getMessage();
        }

        return $response;
    }

}