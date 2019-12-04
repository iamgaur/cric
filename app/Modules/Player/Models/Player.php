<?php

namespace App\Modules\Player\Models;

use Illuminate\Database\Eloquent\Model;

class Player extends Model {
   public $table = 'players';
   public $primaryKey = 'pid';

   protected $fillable = ['player_name', 'player_bio', 'player_born', 'player_nickname',
       'player_playing_role', 'player_playing_batting', 'player_playing_bowling', 'player_fielding_position',
       'meta_title', 'meta_description', 'meta_keywords', 'p_slug', 'c_slug', 'dynamic_group'];
}
