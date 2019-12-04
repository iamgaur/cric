<?php

namespace App\Modules\Gallery\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryPhotos extends Model {
    public $table = 'gallery_images';
    public $primaryKey = 'id';

    protected $fillable = [ 'g_id', 'image', 'image_title','alt_tag','image_description','profile_pic','embeded'];

}
