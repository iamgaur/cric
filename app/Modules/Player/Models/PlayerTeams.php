<?php

namespace App\Modules\Player\Models;

use Illuminate\Database\Eloquent\Model;

class PlayerTeams extends Model {
   public $table = 'player_teams';
   public $primaryKey = 'id';

   protected $fillable = ['pid', 'team_id', 'team_type', 'time_from', 'time_to'];
}
