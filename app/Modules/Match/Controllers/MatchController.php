<?php

namespace App\Modules\Match\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\Match\Models\Match;
use App\Modules\Match\Validator\MatchValidator;
use App\Modules\Series\Models\Series;
use App\Modules\Player\Models\GroupField;
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
        $group_fields = $this->map_group_fields();
        return view('Match::add', compact('fetchSeries', 'match', 'title', 'group_fields'));
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
        $group_fields = $this->map_group_fields($match);
        return view('Match::add', compact('fetchSeries', 'match', 'title', 'group_fields'));
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
                $match->fill(array_map('trim', $request->except(['slug', 'group'])));
            } else {
                $insertValues = array_map('trim', $request->except(['slug', 'group']));
                $insertValues['slug'] = createSlug($insertValues['match_title']);
                $match = new Match($insertValues);
            }
            $match->about_match_html = $this->postEditor($request);
            $match->dynamic_group = json_encode($request->get('group'));
	    $match->match_date = empty($match->match_date) ? NULL : $match->match_date;
            $match->match_end_date = empty($match->match_end_date) ? NULL : $match->match_end_date;
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



    /**
    * function postSummernoteeditor().
    */
    public function postEditor($request) {

        try {
          $detail = $request->about_match_html;
          if (empty($detail)) {
            return $detail;
          }
          $dom = new \DomDocument();
          $dom->loadHtml($detail, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
          $images = $dom->getElementsByTagName('img');

          foreach($images as $k => $img) {

              $data = $img->getAttribute('src');
              list($type, $data) = explode(';', $data);
              list(, $data)      = explode(',', $data);
              $data = base64_decode($data);
              $image_name = time().$k.'.png';
              $folder_path = "/images/matches/";
              $public_path = public_path($folder_path);
              $path = $public_path . $image_name;
              file_put_contents($path, $data);
              $img->removeAttribute('src');
              $img->setAttribute('src', $folder_path .  $image_name);
          }
          $detail = $dom->saveHTML();
        } catch (\Exception $e) {
          Log::info($e->getMessage());
        }

        return $detail;
    }

    /**
     * function groupFields()
     */
    public function addGroupFields(Request $request) {
        try {
            $posts = $request->all();
            $jsonField = [];
            foreach($posts['groupField'] as $post) {
                if (!isset($post['heading']) || !isset($post['fields'])) {
                    continue;
                }
                foreach ($post['fields'] as $field) {
                    $jsonField[$post['heading']][] = $field;
                }
            }
            $groupField = new GroupField();
            if (GroupField::whereGroupType('match')->count()) {
                $groupField = GroupField::whereGroupType('match')->first();
            }
            $groupField->fill(['json_group' => json_encode($jsonField)]);
            $groupField->save();
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
        }
        return redirect()->route('matchGroupFields');
    }

    /**
     * function map_group_fields().
     *
     * @param Object $player
     * @return array
     */
    public function map_group_fields($match = null) {
        $json = GroupField::whereGroupType('match')->first(['json_group'])->toArray();

        $group_fields = [];
        if (!empty($json['json_group'])) {
            $global_fields = json_decode($json['json_group'], 1);
 
            $dynamicGroup = null;
            if (!empty($match)) {
                $dynamicGroup = $match->dynamic_group;
            }
            
            foreach($global_fields as $heading => $fields) {
                $group_fields[$heading] = [
                    'heading' => $heading,
                    'fields' => []
                ];
                foreach ($fields as $field) {
                    $group_fields[$heading]['fields'][$field] = '';
                }
            }

            if (!empty($dynamicGroup) && !empty(json_decode($dynamicGroup, 1))) {
 
                $dynamic = json_decode($dynamicGroup, 1);
                foreach ($dynamic as $fields) {
                    if (!isset($fields['heading']) || !isset($global_fields[$fields['heading']])) {
                        continue;
                    }
                    $group_fields[$fields['heading']]['heading'] = $fields['heading'];

                    foreach ($global_fields[$fields['heading']] as $field_title) {
                        if (!array_key_exists($field_title, $fields['fields'])) {
                            continue;
                        }
                        $group_fields[$fields['heading']]['fields'][$field_title] = $fields['fields'][$field_title];
                    }
                }
            }
        }

        return $group_fields;
    }
    
      /**
     * function groupFields()
     */
    public function groupFields() {
       $title = 'Group Fields';
       $json = GroupField::whereGroupType('match')->get();
       $field_group = [];
       if ($json->count()) {
           foreach ($json->toArray() as $json_group) {
               if ($json_group) {
                   if (!empty($json_group['json_group'])) {
                        $field_group[] = json_decode($json_group['json_group'], 1);
                   }
               }
            }
            $key_value = [];
            $i = 0;
            foreach($field_group as  $group) {
                foreach ($group as $groupKey => $groupValue) {
                    $key_value[$i]['heading'] = $groupKey;
                    $key_value[$i]['fields'] = $groupValue;
                    $i++;
                }
            }
       }
       $field_group = $key_value;
       return view('Match::groupField', compact('field_group', 'title'));
    }

}
