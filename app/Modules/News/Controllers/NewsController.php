<?php

namespace App\Modules\News\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\News\Validator\NewsValidator;
use App\Modules\News\Models\News;
use Illuminate\Support\Facades\Input;
use Validator;
use DB;
use Log;
use Auth;

class NewsController extends Controller {

    public function __construct() {

    }

    /**
     * function index().
     *
     * @return Illuminate\View\View;
     */
    public function index() {

        $fetchNews = News::get()->map(function($item) {
            return collect($item)->only(['id', 'title', 'slug'])->all();
        });
        return view('News::index', compact('fetchNews'));
    }

    /**
     * function add().
     *
     * @description: Add a new MatchTeams.
     * @return Illuminate\View\View;
     */
    public function add() {
        $news = new News();
        $title = __('Add new news');
        return view('News::add', compact('news', 'title'));
    }

    /**
     * function edit().
     *
     * @description: edit existing MatchTeams.
     * @return Illuminate\View\View;
     */
    public function edit($slug) {

        $news = News::whereSlug($slug)->first();
        if (!$news) {
            return abort(404);
        }
        $title = __('Edit News: ' . $news->title);
        return view('News::add', compact('news', 'title'));
    }

    /**
     * function save().
     *
     * @description: Save existing or new News.
     * @return Illuminate\View\View;
     */
    public function save(NewsValidator $request) {
        try {
            DB::beginTransaction();
            if ($slug = $request->route('slug')) {
                $news = News::whereSlug($slug)->first();
                $slug = $news->slug = createSlug($request->get('title'));
                $news->fill(array_map('trim', $request->except(['slug'])));
                $image = Input::file('image');
                if(!empty($image)){
                  $news->image = $this->_upload_image();
                  if (!empty($image) && !($news->image))
                      return redirect()->back()->withInput()->withErrors(['message' => __('Some error occured during image upload')]);
                }
            } else {
                $insertValues = array_map('trim', $request->except(['slug']));
                $insertValues['slug'] = createSlug($insertValues['title']);

                if(isset($insertValues['image']) && !empty($insertValues['image']) ){
                  $image = $this->_upload_image();
                  if (isset($insertValues['image']) && !empty($insertValues['image']) && !($image))
                      return redirect()->back()->withInput()->withErrors(['message' => __('Some error occured during image upload')]);
                  $insertValues['image'] = $image;
                }

                $news = new News($insertValues);
            }
            $news->description =  $this->postEditor($request);
            if ($news->save()) {
                DB::commit();
                return ($slug) ? redirect()->to(route('editNews', ['slug' => $slug]))->with(['success' => __('Saved successfully')]) :
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

                $destinationPath = 'images/news';
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
            $news = News::whereSlug($slug)->first();
            if (!$news) {
                return redirect()->back()->withErrors(['message' => __('News does not exist on our records')]);
            }
            if ($news->delete()) {
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
          $detail = $request->description;
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
              $folder_path = "/images/news/";
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
}
