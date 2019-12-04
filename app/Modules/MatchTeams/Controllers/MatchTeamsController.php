<?php



namespace App\Modules\MatchTeams\Controllers;



use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Modules\MatchTeams\Validator\MatchTeamValidator;

use App\Modules\MatchTeams\Models\MatchTeams;

use App\Modules\Team\Models\Teams;

use App\Modules\MatchSquad\Models\MatchSquad;

use DB;

use Log;

use Auth;



class MatchTeamsController extends Controller {



    public function __construct() {



    }



    /**

     * function index().

     *

     * @return Illuminate\View\View;

     */

    public function index() {



        $fetchMatchTeams = MatchTeams::get()->map(function($item) {

            return collect($item)->only(['id', 'match_id', 'first_team', 'second_team'])->all();

        });

        $teamList = Teams::pluck('name', 'id');

        return view('MatchTeams::index', compact('teamList' ,'fetchMatchTeams'));

    }



    /**

     * function add().

     *

     * @description: Add a new MatchTeams.

     * @return Illuminate\View\View;

     */

    public function add() {

        $matchTeams = new MatchTeams();

        $teamList = Teams::pluck('name', 'id');

        $title = __('Add Teams for Match');

        return view('MatchTeams::add', compact('teamList', 'matchTeams', 'title'));

    }



    /**

     * function edit().

     *

     * @description: edit existing MatchTeams.

     * @return Illuminate\View\View;

     */

    public function edit($id) {



        $matchTeams = MatchTeams::find($id);

        $teamList = Teams::pluck('name', 'id');

        if (!$matchTeams) {

            return abort(404);

        }

        $title = __('Edit Teams for Match: ' . $id);

        return view('MatchTeams::add', compact('teamList', 'matchTeams', 'title'));

    }



    /**

     * function save().

     *

     * @description: Save existing or new MatchTeams.

     * @return Illuminate\View\View;

     */

    public function save(MatchTeamValidator $request) {

        try {

            DB::beginTransaction();

            if ($id = $request->route('id')) {

                $matchTeams = MatchTeams::find($id);

                $firstTeamName = Teams::whereId($matchTeams->first_team)->first()->name;

                $secondTeamName = Teams::whereId($matchTeams->second_team)->first()->name;

                $matchSquad = MatchSquad::whereSlug($firstTeamName . ' ' . $secondTeamName . ' ' . $matchTeams->match_id)->first();

                if (!$matchSquad) {

                    $matchSquad = new MatchSquad();

                }

                $firstTeamName = Teams::whereId($request->get('first_team'))->first()->name;

                $secondTeamName = Teams::whereId($request->get('second_team'))->first()->name;

                $matchSquad->first_team = $request->get('first_team');

                $matchSquad->second_team = $request->get('second_team');

                $matchSquad->match_id = $request->get('match_id');

                $matchSquad->slug = createSlug($firstTeamName . ' ' . $secondTeamName . ' ' . $request->get('match_id'));

                $matchSquad->save();



                $matchTeams->fill(array_map('trim', $request->except(['slug'])));

            } else {

                $insertValues = array_map('trim', $request->except(['slug', '_token']));

                $matchTeams = new MatchTeams($insertValues);

                $firstTeamName = Teams::whereId($request->get('first_team'))->first()->name;

                $secondTeamName = Teams::whereId($request->get('second_team'))->first()->name;

                $insertValues['slug'] = createSlug($firstTeamName . ' ' . $secondTeamName . ' ' . $request->get('match_id'));

                MatchSquad::insert($insertValues);

            }

            if ($matchTeams->save()) {

                DB::commit();

                return ($id) ? redirect()->to(route('editMatchTeams', ['id' => $id]))->with(['success' => __('Saved successfully')]) :

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

            $matchTeams = MatchTeams::find($id);

            if (!$matchTeams) {

                return redirect()->back()->withErrors(['message' => __('MatchTeams does not exist on our records')]);

            }

            $firstTeamName = Teams::whereId($matchTeams->first_team)->first()->name;

            $secondTeamName = Teams::whereId($matchTeams->second_team)->first()->name;

            $matchSquad = MatchSquad::whereSlug($firstTeamName . ' ' . $secondTeamName . ' ' . $matchTeams->match_id)->first();

            if ($matchTeams->delete()) {

                $matchSquad->delete();

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