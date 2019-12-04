<?php

namespace App\Modules\Gallery\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\Gallery\Models\Gallery;
use App\Modules\Gallery\Models\GalleryPhotos;
use App\Modules\Gallery\Validator\GalleryValidator;
use App\Modules\Gallery\Validator\GalleryPhotoValidator;
use App\Modules\Team\Models\Teams;
use App\Modules\Series\Models\Series;
use App\Modules\Player\Models\Player;
use App\Modules\Match\Models\Match;
use Illuminate\Support\Facades\Input;
use Validator;
use App\Modules\Gallery\Models\AssociativeGallery;
use DB;
use Log;
use Auth;

class GalleryController extends Controller {

    public function __construct() {

    }

    /**
     * function index().
     *
     * @return Illuminate\View\View;
     */
    public function index() {
        $galleryTypes = array_flip(config('constants.gallery_type'));
        $fetchGallery = Gallery::get()->map(function($item) use ($galleryTypes) {
            $item->type_name = '';
            switch(strtolower($galleryTypes[$item->type])) {
               case 'team':
                   $item->type_name = Teams::find($item->item_id)->name;
                   break;
               case 'match':
                   $item->type_name = Match::find($item->item_id)->match_title;
                   break;
               case 'player':
                   $item->type_name = Player::find($item->item_id)->player_name;
                   break;
               case 'series':
                   $item->type_name = Series::find($item->item_id)->name;
                   break;

            }

            return $item;
        });
        return view('Gallery::index', compact('fetchGallery', 'galleryTypes'));
    }

    /**
     * function add().
     *
     * @description: Add a new Gallery.
     * @return Illuminate\View\View;
     */
    public function add() {
        $gallery = new Gallery();
        $title = __('Add New Gallery');
        $gallery_types = $this->getAllGalleryTypes();
        $opted = @reset(config('constants.gallery_type'));
        return view('Gallery::add', compact('gallery', 'title', 'gallery_types', 'opted'));
    }


    /**
     * function getPhoto().
     *
     * @description: get Photo Gallery.
     * @return Illuminate\View\View;
     */
    public function getPhoto($id = '') {
      try{
        if($id != ''){
          $allGallery = Gallery::pluck('gallery_title', 'id');        
          $gallery = GalleryPhotos::wheregId($id)->get();
          $parentGallery = Gallery::whereId($id)->count();
          if(count($gallery) && $parentGallery){
            $parentGallery = Gallery::whereId($id)->first(['gallery_title', 'id'])->toArray();
            if(count($parentGallery)) {
              $title = $parentGallery['gallery_title'];
              $gallery = $gallery->toArray();
              $associativeGalleryPhotos = [];
              if (AssociativeGallery::where(['associative_id' => $id])->count()) {
                    $associativeGallery = AssociativeGallery::where(['associative_id' => $id])->get();
                    foreach ($associativeGallery as $row) {
                        if (GalleryPhotos::where(['g_id' => $row->g_id])->where(['id' => $row->photo_id])->count()) {
                            $associativeGalleryPhotos[] = GalleryPhotos::where(['g_id' => $row->g_id])
                                ->where(['id' => $row->photo_id])->first()->toArray();
                       }
                    }
              }
              return view('Gallery::getPhotos', compact('gallery','title', 'allGallery', 'associativeGalleryPhotos', 'parentGallery'));
            }

          }else {
            return redirect()->back()->withErrors(['message' => __('There is no photos in gallery!!! first add it....')]);
          }
        }
      } catch (\Exception $e) {
        return redirect()->back()->withErrors(['message' => __('Some error occured....')]);
      }
      return redirect()->back()->withErrors(['message' => __('Some error occured.....')]);
    }


    /**
     * function add().
     *
     * @description: Add a new Gallery.
     * @return Illuminate\View\View;
     */
    public function addGalleryPhoto($id ='') {

        if($id != '') {
          $gallery = Gallery::pluck('gallery_title', 'id');
          $galleryPhoto = GalleryPhotos::whereId($id)->first();
          DB::table('gallery_images')->wheregId($galleryPhoto->g_id)->update(['profile_pic' => 0]);
          DB::table('gallery_images')->wheregId($galleryPhoto->g_id)->whereId($id)->update(['profile_pic' => 1]);
          return redirect()->back()->with(['success' => __('Saved successfully')]);
        } else {
          $gallery = Gallery::pluck('gallery_title', 'id');
          $galleryPhoto = new GalleryPhotos();
        }
        if(count($gallery) == 0){
          return redirect()->back()->withInput()->withErrors(['message' => __('Please first add gallery to add photos')]);
        } else {
          $gallery = $gallery->toArray();
          return view('Gallery::addphoto', compact('gallery','galleryPhoto'));
        }
    }


    public function addPhoto(GalleryPhotoValidator $request, $id = '') {
      try{
        $inputValues = $request->all();
        $files = $request->file('image');
        if(isset($inputValues['image']) && !empty($inputValues['image'])){
          foreach ($inputValues['image'] as $key => $value) {
            $dataArray = array();
            $dataArray['g_id'] = $inputValues['g_id'];
            $dataArray['alt_tag'] = isset($inputValues['alt_tag'][$key]) && !empty($inputValues['alt_tag'][$key]) ? $inputValues['alt_tag'][$key] : '';
            $dataArray['image_title'] = isset($inputValues['image_title'][$key]) && !empty($inputValues['image_title'][$key]) ? $inputValues['image_title'][$key] : '';
            $dataArray['image_description'] = isset($inputValues['image_description'][$key]) && !empty($inputValues['image_description'][$key]) ? $inputValues['image_description'][$key] : '';
            
            $dataArray['image'] = $this->_upload_image($files[$key]);
            $dataArray['created_at'] = date('Y-m-d H:i:s');
            $dataArray['updated_at'] = date('Y-m-d H:i:s');
            GalleryPhotos::insert($dataArray);
          }
        } else {
          return redirect()->back()->withInput()->withErrors(['message' => __('Some error occured during image upload')]);
        }
      } catch (\Exception $e) {
        return redirect()->back()->withInput()->withErrors(['message' => __('Some error occured during image upload')]);
      }
      return redirect()->back()->with(['success' => __('Saved successfully')]);
    }




    /**
     * function edit().
     *
     * @description: edit existing Gallery.
     * @return Illuminate\View\View;
     */
    public function edit($id) {
        $gallery = Gallery::find($id);
        if (!$gallery) {
            return abort(404);
        }
        $title = __('Edit Gallery: ' . $gallery->id);
        $gallery_types = $this->getAllGalleryTypes();
        $opted = $gallery->type;
        return view('Gallery::add', compact('gallery', 'title', 'gallery_types', 'opted'));
    }

    /**
     * function save().
     *
     * @description: Save existing or new Gallery.
     * @return Illuminate\View\View;
     */
    public function save(GalleryValidator $request) {
        try {
            $inputValues = $request->all();
            DB::beginTransaction();

            if(!$this->validateItemId($request))
                return redirect()->back()->withInput()->withErrors(['message' => __('Item id does not have a value')]);

            if ($id = $request->route('id')) {
                $gallery = Gallery::find($id);
                $insertValues = $request->except('item_id');
                $insertValues['item_id'] =  $request->get('item_id')[$request->get('type')];
                $gallery->fill(array_map('trim', $insertValues));
            } else {

                $insertValues = $request->except('item_id');
                $insertValues['item_id'] =  $request->get('item_id')[$request->get('type')];

                $count = Gallery::whereType($insertValues['type'])->whereItemId($insertValues['item_id'])->count();
                if ($count)
                    return redirect()->back()->withInput()->withErrors(['message' => __('Data Already Exist')]);
                $gallery = new Gallery($insertValues);
            }
            if ($gallery->save()) {
                DB::commit();
                return ($id) ? redirect()->to(route('editGallery', ['id' => $id]))->with(['success' => __('Saved successfully')]) :
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
            $gallery = Gallery::find($id);
            if (!$gallery) {
                return redirect()->back()->withErrors(['message' => __('Gallery does not exist on our records')]);
            }
            if ($gallery->delete()) {
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
     * function getAllGalleryTypes()
     */
    public function getAllGalleryTypes() {
        $options['team'] = Teams::pluck('name', 'id');
        $options['series'] = Series::pluck('name', 'id');
        $options['match'] = Match::pluck('match_title', 'id');
        $options['player'] = Player::pluck('player_name', 'pid');
        return $options;
    }

    /**
     *
     * @return boolean|string
     */
    public function _upload_image($file) {
        $rules = array('image' => 'mimes:jpeg,jpg,png,gif|max:2048');
        if (0 && $validator->fails()) {
            return false;
        } else {
            if (1 || $file->isValid()) {

                $destinationPath = 'images/gallery';
                $extension = $file->getClientOriginalExtension();
                $fileName = rand(11111, 99999) . '.' . $extension;
                $file->move(public_path($destinationPath), $fileName);
                return $fileName;
            } else {
                return false;
            }
        }
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
        $type = $request->get('type');
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
     * function associatePhoto().
     */
    public function asssociatePhoto(Request $request) {
        try {
            $rules = [
                'g_id' => 'required',
                'photo_id' => 'required',
                'associative_id' => 'required'
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator);
            }
            $associationExist = AssociativeGallery::where($request->except(['_token']))->count();
            if ($associationExist) {
                return redirect()->back()->withErrors(['message' => __('Association already Exist')]);
            }
            DB::beginTransaction();
            $associativeGallery = new AssociativeGallery();
            $associativeGallery->fill($request->all());
            if ($associativeGallery->save()) {
                DB::commit();
                return redirect()->route('getPhoto', ['id' => $request->get('g_id') ])->with(['success' => __('Data Saved Successfully')]);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
        }
        return redirect()->back()->withErrors(['message' => __('Opps! Something went wrong')]);
    }
    
    /**
     * function deAsssociatePhoto().
     */
    public function deAsssociatePhoto($associativeId, $photoId) {
        try {
            $request['photo_id'] = $photoId;
            $request['associative_id'] = $associativeId;
            $rules = [
                'photo_id' => 'required',
                'associative_id' => 'required'
            ];

            $validator = Validator::make($request, $rules);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator);
            }

            $associationExist = AssociativeGallery::where($request)->count();

            if (!$associationExist) {
                return redirect()->back()->withErrors(['message' => __('Association not Exist')]);
            }
            DB::beginTransaction();
            AssociativeGallery::where($request)->delete();
            DB::commit();
            return redirect()->route('getPhoto', ['id' => $request['associative_id'] ])->with(['success' => __('Data Deleted Successfully')]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
        }
        return redirect()->back()->withErrors(['message' => __('Opps! Something went wrong')]);
    }
}
