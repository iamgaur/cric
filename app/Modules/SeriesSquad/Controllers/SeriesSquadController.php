<?php

namespace App\Modules\SeriesSquad\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\Series\Models\Series;
use App\Modules\SeriesSquad\Models\SeriesSquad;
use App\Modules\Team\Models\Teams;
use App\Modules\Player\Models\Player;
use DB;
use Log;
use Auth;

class SeriesSquadController extends Controller {

    public function __construct() {

    }

    /**
     * function index().
     *
     * @return Illuminate\View\View;
     */
    public function index() {

        $listings = [];
        $fetchSeries = Series::whereNotNull('format_type')->get();

        foreach ($fetchSeries as $series) {
            if (empty(trim($series->format_type))) {
                continue;
            }
            $format_types = explode(',', $series->format_type);

            foreach ($format_types as $format) {
                $listings[$series->name. '_' . $format] = [
                  'type' => config('constants.format_type.' . $format),
                  'name' => $series->name,
                  'slug' => createSlug($series->name. '_' . $format)
                ];
            }
        }

        return view('SeriesSquad::index', compact('listings'));
    }

    /**
     * function edit().
     *
     * @description: edit existing Match.
     * @return Illuminate\View\View;
     */
    public function edit($slug) {

        $seriesSquadExist = SeriesSquad::whereSlug($slug)->count();
        if (!$seriesSquadExist) {
            $seriesSquad = new SeriesSquad();
        } else {
            $seriesSquad = SeriesSquad::whereSlug($slug)->get()->map(function($item) {
                $item->entries = trim($item->json) ? json_decode($item->json, 1) : [];
                return $item;
            })->first()->toArray();
        }
        $fetchTeam = Teams::get()->map(function($item) {
            return collect($item)->only(['id', 'name'])->all();
        });

        $fetchPlayers = Player::pluck('player_name', 'pid');

        $title = __('Edit Series Squad: ' . $slug);
        return view('SeriesSquad::add', compact('seriesSquad', 'title', 'fetchTeam', 'fetchPlayers'));
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
            $slug = $request->route('slug');
            if (SeriesSquad::whereSlug($slug)->count()) {
                $seriesSquad = SeriesSquad::whereSlug($slug)->first();
                $seriesSquad->json = !empty($request->get('series_squad')) ? json_encode($request->get('series_squad')) : NULL;
            } else {
                $seriesSquad = new SeriesSquad();
                $fill['slug'] = $request->route('slug');
                $fill['json'] = json_encode($request->get('series_squad'));

                $seriesSquad->fill($fill);
            }
            if ($seriesSquad->save()) {
                DB::commit();
                return ($slug) ? redirect()->to(route('editSeriesSquad', ['slug' => $slug]))->with(['success' => __('Saved successfully')]) :
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