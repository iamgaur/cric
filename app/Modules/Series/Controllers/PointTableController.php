<?php
namespace App\Modules\Series\Controllers;
use App\Http\Controllers\Controller;
use App\Modules\Series\Models\Series;
use App\Modules\Series\Models\PointTable;
use App\Modules\Match\Models\Match;
use App\Modules\Series\Validator\SeriesValidator;
use App\Modules\Team\Models\TeamsType;
use App\Modules\MatchTeams\Models\MatchTeams;
use App\Modules\Team\Models\Teams;
use Illuminate\Http\Request;
use DB;
use Log;
class PointTableController extends Controller {
    public function __construct() {

    }
    /**
     * function index().
     */
    public function index($slug = '') {

      $seriesC = Series::select(['id','name'])->whereSlug($slug)->count();
      if($seriesC){
        $series = Series::select(['id','name'])->whereSlug($slug)->first();
        $mathches = Match::whereSeriesId($series->id)->pluck('id');
        if(count($mathches)){
          $teams_matches = MatchTeams::whereIn('match_id',$mathches)->pluck('first_team','second_team');
          if(count($teams_matches)){
            $teams_matches = $teams_matches->toArray();
            $team = array_flip(array_merge(array_keys($teams_matches), array_values($teams_matches)));
            $match_teams = Teams::whereIn('id',array_keys($team))->pluck('name','id');
            if(count($match_teams)){
              $dataArray['series_id'] = $series->id;
              $dataArray['series_name'] = $series->name;
              $dataArray['teams'] = $match_teams->toArray();

              $getPoints = PointTable::whereSeriesId($series->id)->pluck('meta_points','team_id');
              if(count($getPoints)){
                $dataArray['points'] = $getPoints->toArray();
              } else {
                $dataArray['points'] = array();
              }

              return view('Series::point_table', compact('dataArray'));
            } else {
              return redirect()->back()->withErrors(['message' => __('Either match or match team not available')]);
            }
          } else {
            return redirect()->back()->withErrors(['message' => __('Either match or match team not available')]);
          }
        } else {
          return redirect()->back()->withErrors(['message' => __('Either match or match team not available3')]);
        }
      } else {
        return redirect()->back()->withErrors(['message' => __('Either match or match team not available')]);
      }
        return view('Series::index', compact('fetchSeries'));
    }

/**
function to save point table
**/
    public function addPoints(Request $request){
      try{
        $inputValues = $request->all();
        // p($inputValues,1);
        if(isset($inputValues['teams']) && !empty($inputValues['teams'])){
          $team = explode(',',$inputValues['teams']);
          foreach ($team as $key => $team_id) {
            $points = array(
              'tp' => $inputValues['tp'][$team_id],
              'won' => $inputValues['won'][$team_id],
              'lost' => $inputValues['lost'][$team_id],
              'tied' => $inputValues['tied'][$team_id],
              'nr' => $inputValues['nr'][$team_id],
              'pts' => $inputValues['pts'][$team_id],
              'nrr' => $inputValues['nrr'][$team_id]
            );
            $checkPoint = PointTable::whereTeamId($team_id)->whereSeriesId($inputValues['series_id'])->count();
            if(($checkPoint)){
              PointTable::whereTeamId($team_id)->whereSeriesId($inputValues['series_id'])->update(['team_id' => $team_id,
              'series_id' => $inputValues['series_id'],
              'meta_points' => json_encode($points),
              'updated_at' => date('Y-m-d H:i:s')
            ]);
          } else {
            PointTable::insert(['team_id' => $team_id,
            'series_id' => $inputValues['series_id'],
            'meta_points' => json_encode($points),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')]);
            }
          }
        } else {
          return redirect()->back()->withErrors(['message' => __('Some error occured....')]);
        }
      } catch (\Exception $e) {
        return redirect()->back()->withErrors(['message' => __('Some error occured....')]);
      }
      return redirect()->back()->with(['success' => __('Saved successfully')]);

    }

}
