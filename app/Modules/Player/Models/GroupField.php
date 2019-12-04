<?php

namespace App\Modules\Player\Models;

use Illuminate\Database\Eloquent\Model;

class GroupField extends Model {
   public $table = 'group_fields';
   public $primaryKey = 'id';

   protected $fillable = ['json_group'];
}