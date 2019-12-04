<?php

namespace App\Modules\Series\Models;

use Illuminate\Database\Eloquent\Model;

class PointTable extends Model {
   public $table = 'point_table';
   public $primaryKey = 'id';

   protected $fillable = ['team_id', 'series_start_date', 'series_id', 'meta_points'];

}
