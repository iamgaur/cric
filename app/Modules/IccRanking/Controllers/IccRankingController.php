<?php

namespace App\Modules\IccRanking\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\IccRanking\Models\IccRanking;
use App\Modules\Player\Models\Player;
use App\Modules\Team\Models\Teams;
use App\Modules\IccRanking\Validator\IccRankingValidator;
use DB;
use Log;
use Auth;

class IccRankingController extends Controller {

    public function __construct() {

    }

    /**
     * function index().
     *
     * @return Illuminate\View\View;
     */
    public function index() {

        $rankingTypes = array_flip(config('constants.ranking_type'));
        $allTeam = Teams::pluck('name', 'id');
        $allPlayer = Player::pluck('player_name', 'pid');
        $fetchIccRankings['man'] = $this->getRankingsResultByCategory(array_search('man', config('constants.gender')));
        $fetchIccRankings['woman'] = $this->getRankingsResultByCategory(array_search('woman', config('constants.gender')));
        
        return view('IccRanking::index', compact('rankingTypes', 'fetchIccRankings', 'allTeam', 'allPlayer'));
    }

    /**
     * function add().
     *
     * @description: Add a new Country.
     * @return Illuminate\View\View;
     */
    public function add() {
        $iccRanking = new IccRanking();
        $title = __('Add New ICC Ranking');
        $rankingTypes = $this->getAllRankingTypes();
        $opted = @reset(config('constants.ranking_type'));
        $optedGender = array_key_first(config('constants.gender'));

        return view('IccRanking::add', compact('iccRanking', 'title', 'opted', 'rankingTypes', 'optedGender'));
    }

    /**
     * function edit().
     *
     * @description: edit existing Country.
     * @return Illuminate\View\View;
     */
    public function edit($id) {

        $iccRanking = IccRanking::find($id);
        if (!$iccRanking) {
            return abort(404);
        }
        $title = __('Edit ICC Ranking: ' . $iccRanking->id);
        $rankingTypes = $this->getAllRankingTypes();
        $opted = $iccRanking->ranking_type;
        $optedGender = $iccRanking->gender;
        return view('IccRanking::add', compact('iccRanking', 'title', 'rankingTypes', 'opted', 'optedGender'));
    }

    /**
     * function save().
     *
     * @description: Save existing or new Country.
     * @return Illuminate\View\View;
     */
    public function save(IccRankingValidator $request) {
       try {
            DB::beginTransaction();
            if(!$this->validateItemId($request))
                return redirect()->back()->withInput()->withErrors(['message' => __('Item id does not have a value')]);

            if ($id = $request->route('id')) {
                $iccRanking = IccRanking::find($id);
                $insertValues =  $request->except('_token', 'item_id');
                $insertValues = $this->assgnDefaultValue($insertValues);
                $insertValues['item_id'] =  $request->get('item_id')[$request->get('ranking_type')];
                $iccRanking->fill(array_map('trim', $insertValues));
            } else {
                $insertValues = $request->except('_token', 'item_id');
                $insertValues = $this->assgnDefaultValue($insertValues);
                $insertValues['item_id'] =  $request->get('item_id')[$request->get('ranking_type')];
                $count = IccRanking::whereRankingType($insertValues['ranking_type'])->whereItemId($insertValues['item_id'])->count();
                if ($count)
                    return redirect()->back()->withInput()->withErrors(['message' => __('Data Already Exist')]);
                $iccRanking = new IccRanking($insertValues);
            }
            if ($iccRanking->save()) {
                DB::commit();
                return ($id) ? redirect()->to(route('editIccRanking', ['id' => $id]))->with(['success' => __('Saved successfully')]) :
                    redirect()->back()->with(['success' => __('Saved successfully')]);
            }
        } catch (\Exception $ex) {
            DB::rollBack();
            Log::error($ex->getMessage(). "\n[Line No.]" . $ex->getLine());
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
            $iccRanking = IccRanking::find($id);
            if (!$iccRanking) {
                return redirect()->back()->withErrors(['message' => __('ICC Ranking does not exist on our records')]);
            }
            if ($iccRanking->delete()) {
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
     * function getAllRankingTypes()
     */
    public function getAllRankingTypes() {
        $options['team'] = Teams::pluck('name', 'id');
        $options['player'] = Player::pluck('player_name', 'pid');
        return $options;
    }
    
    /**
     * function validateItemId().
     *
     * @param Request $request
     */
    public function validateItemId($request) {
        if (empty($request->get('item_id')))
            return false;
        $item_id = $request->get('item_id');
        $type = $request->get('ranking_type');
        if (!isset($item_id[$type])) {
            return false;
        }
        if (isset($item_id[$type]) && empty($item_id[$type])) {
            return false;
        }
        if (isset($item_id[$type]) && !empty($item_id[$type])) {
            return true;
        }
        return false;
    }

    /**
     * function getRankingsResultByCategory().
     */
    public function getRankingsResultByCategory($gender){
        $ranking_type = config('constants.ranking_type');
        $fetchIccRankings = array('team' => array(), 'player' => array(), 'count' => array());

        //Teams
        $fetchIccRankings['count']['team'] = IccRanking::whereRankingType($ranking_type['team'])->where(['gender' => $gender])->count();
        $fetchIccRankings['team']['t20_rating'] = IccRanking::whereRankingType($ranking_type['team'])->where(['gender' => $gender])->orderBy('t20_rating', 'desc')->get();
        $fetchIccRankings['team']['odi_rating'] = IccRanking::whereRankingType($ranking_type['team'])->where(['gender' => $gender])->orderBy('odi_rating', 'desc')->get();
        $fetchIccRankings['team']['test_rating'] = IccRanking::whereRankingType($ranking_type['team'])->where(['gender' => $gender])->orderBy('test_rating', 'desc')->get();
        
        // Player
        $fetchIccRankings['count']['player'] = IccRanking::whereRankingType($ranking_type['player'])->where(['gender' => $gender])->count();

        $fetchIccRankings['player']['t20_player']['batting_rating'] = IccRanking::whereRankingType($ranking_type['player'])->where(['gender' => $gender])->orderBy('t20_batting_rating', 'desc')->get();
        $fetchIccRankings['player']['t20_player']['bowling_rating'] = IccRanking::whereRankingType($ranking_type['player'])->where(['gender' => $gender])->orderBy('t20_bowling_rating', 'desc')->get();
        $fetchIccRankings['player']['t20_player']['all_rounder_rating'] = IccRanking::whereRankingType($ranking_type['player'])->where(['gender' => $gender])->orderBy('t20_all_rounder_rating', 'desc')->get();
 
        $fetchIccRankings['player']['odi_player']['batting_rating'] = IccRanking::whereRankingType($ranking_type['player'])->where(['gender' => $gender])->orderBy('odi_batting_rating', 'desc')->get();
        $fetchIccRankings['player']['odi_player']['bowling_rating'] = IccRanking::whereRankingType($ranking_type['player'])->where(['gender' => $gender])->orderBy('odi_bowling_rating', 'desc')->get();
        $fetchIccRankings['player']['odi_player']['all_rounder_rating'] = IccRanking::whereRankingType($ranking_type['player'])->where(['gender' => $gender])->orderBy('odi_all_rounder_rating', 'desc')->get();

        $fetchIccRankings['player']['test_player']['batting_rating'] = IccRanking::whereRankingType($ranking_type['player'])->where(['gender' => $gender])->orderBy('test_batting_rating', 'desc')->get();
        $fetchIccRankings['player']['test_player']['bowling_rating'] = IccRanking::whereRankingType($ranking_type['player'])->where(['gender' => $gender])->orderBy('test_bowling_rating', 'desc')->get();
        $fetchIccRankings['player']['test_player']['all_rounder_rating'] = IccRanking::whereRankingType($ranking_type['player'])->where(['gender' => $gender])->orderBy('test_all_rounder_rating', 'desc')->get();

        return $fetchIccRankings;
    }

    /*
     * function assgnDefaultValue();
     */
    public function assgnDefaultValue($array) {
        $new_array = array();
        foreach($array as $key => $default) {
            $new_array[$key] = $default;
            if (empty($default)) {
                $new_array[$key] = 0;
            }
        }
        return $new_array;
    }
}