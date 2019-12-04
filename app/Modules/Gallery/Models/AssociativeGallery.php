<?php

namespace App\Modules\Gallery\Models;

use Illuminate\Database\Eloquent\Model;

class AssociativeGallery extends Model {
    public $table = 'associative_gallery';
    public $primaryKey = 'id';

    //here g_id is parent and associative_id act as child id.
    protected $fillable = [ 'g_id', 'photo_id', 'associative_id'];
}
