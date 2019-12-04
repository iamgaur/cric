<?php

namespace App\Modules\Team\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Team\Models\Teams;
use App\Modules\Country\Models\Country;
use App\Modules\Team\Models\TeamsType;
use App\Modules\Team\Validator\TeamValidator;
use Illuminate\Support\Facades\Input;
use Validator;
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
        $teamType = TeamsType::pluck('name', 'id');
        if(count($teamType))
          $teamType = $teamType->toArray();

        return view('Team::index', compact('fetchTeam','teamType'));
    }

    /**
     * function add.
     *
     * @return Illuminate\View\View
     */
    public function add() {
        $team = new Teams();
        $countries = Country::pluck('name', 'id');
        $teamType = TeamsType::pluck('name', 'id');
        $title = __('Add New Team');
        return view('Team::add', compact('countries', 'team', 'title','teamType'));
    }

    /**
     * function edit().
     *
     * @description: edit existing Team.
     * @return Illuminate\View\View
     */
    public function edit($slug) {

        $team = Teams::whereSlug($slug)->first();
        $teamType = TeamsType::pluck('name', 'id');
        $countries = Country::pluck('name', 'id');
        if (!$team) {
            return abort(404);
        }
        $title = __('Edit Team: ' . $team->name);
        return view('Team::add', compact('countries', 'team', 'title','teamType'));
    }


    /**
     * function teamType().
     *
     * @description:add new teamType.
     * @return Illuminate\View\View
    */
    public function teamType(){

      try{
        $teamType = TeamsType::pluck('name', 'id');
        return view('Team::teamType', compact('teamType'));
      } catch (\Exception $ex) {
          Log::error($ex->getMessage());
      }
      return view('Team::teamType', compact('teamType'));
    }


    /**
     * function addType().
     *
     * @description:add new teamType.
     * @return Illuminate\View\View
    */
    public function saveTeamType(){
      try{
        $typeName = Input::get('name');
        $check = TeamsType::whereRaw('LOWER(name)="' . $typeName . '"')->get();
        if ($check->isEmpty()) {
          $save = TeamsType::insert(['name' => $typeName, 'updated_at' => date('Y-m-d H:i:s'), 'created_at' => date('Y-m-d H:i:s')]);
          if($save){
            return redirect()->to(route('getType'))->with(['success' => __('Saved successfully')]);
          }
        } else {
          return redirect()->back()->withInput()->withErrors(['message' => __('Type name already exists!!!')]);
        }
      } catch (\Exception $ex) {
          Log::error($ex->getMessage());
      }
      return redirect()->back()->withInput()->withErrors(['message' => __('Some error occured during image upload')]);
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
                $slug = $team->slug = createSlug($request->get('name'));
                $team->fill(array_map('trim', $request->except(['slug'])));
                $image = Input::file('image');
                if(!empty($image)){
                  $team->image = $this->_upload_image();
                  if (!empty($image) && !($team->image))
                      return redirect()->back()->withInput()->withErrors(['message' => __('Some error occured during image upload')]);
                }
            } else {
                $insertValues = array_map('trim', $request->except(['slug']));
                $insertValues['slug'] = createSlug($insertValues['name']);
                if(isset($insertValues['image']) && !empty($insertValues['image']) ){
                  $image = $this->_upload_image();
                  if (isset($insertValues['image']) && !empty($insertValues['image']) && !($image))
                      return redirect()->back()->withInput()->withErrors(['message' => __('Some error occured during image upload')]);
                  $insertValues['image'] = $image;
                }

                $team = new Teams($insertValues);
            }

            if ($team->save()) {
                DB::commit();
                return ($slug) ? redirect()->to(route('editTeam', ['slug' => $slug]))->with(['success' => __('Saved successfully')]) :
                    redirect()->back()->with(['success' => __('Saved successfully')]);
            }
        } catch (\Exception $ex) {
            DB::rollBack();
            Log::error($ex->getMessage());
        }

        return redirect()->back()->withInput()->withErrors(['message' => __('Some error occured during saving')]);
    }

    /**
     *
     * @return boolean|string
     */
    public function _upload_image() {

        $fileupdate = '';
        $file = array('image' => Input::file('image'));
        $rules = array('image' => 'mimes:jpeg,jpg,png,gif|max:2048'); //mimes:jpeg,bmp,png and for max size max:2048
        $validator = Validator::make($file, $rules);
        if ($validator->fails()) {
            return false;

        } else {
            if (Input::file('image')->isValid()) {

                $destinationPath = 'images/team';
                $extension = Input::file('image')->getClientOriginalExtension();
                $fileName = rand(11111, 99999) . '.' . $extension;
                Input::file('image')->move(public_path($destinationPath), $fileName);
                return $fileName;
            } else {

                return false;
            }
        }
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
