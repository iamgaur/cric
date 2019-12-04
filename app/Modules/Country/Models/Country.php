<?php

namespace App\Modules\Country\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model {
   public $table = 'country';
   public $primaryKey = 'id';

   protected $fillable = ['name', 'slug', 'meta_title', 'meta_description', 'meta_keywords','image','alt_tag','image_title'];
}
