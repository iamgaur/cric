<?php

namespace App\Modules\Series\Models;

use Illuminate\Database\Eloquent\Model;

class Series extends Model {
   public $table = 'series';
   public $primaryKey = 'id';

   protected $fillable = ['name', 'series_start_date', 'series_end_date', 'slug', 'posted', 'status', 'meta_title', 'meta_description', 'meta_keywords'];

}
