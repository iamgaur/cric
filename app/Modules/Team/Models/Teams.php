<?php

namespace App\Modules\Team\Models;

use Illuminate\Database\Eloquent\Model;
use App\Modules\Country\Models\Country;

class Teams extends Model {
   public $table = 'team';
   public $primaryKey = 'id';

   protected $fillable = ['name', 'short_name', 'country_id', 'team_type', 'meta_title', 'meta_description', 'meta_keywords'];
   
   
   public function Country () {
       return $this->belongsTo(new Country());
   }
}
