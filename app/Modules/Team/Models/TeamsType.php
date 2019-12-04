<?php

namespace App\Modules\Team\Models;

use Illuminate\Database\Eloquent\Model;


class TeamsType extends Model {
   public $table = 'team_type';
   public $primaryKey = 'id';

   protected $fillable = ['name', 'status'];

}
