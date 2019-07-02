<?php

namespace App\Modules\MatchSquad\Models;

use Illuminate\Database\Eloquent\Model;

class MatchSquad extends Model {
    public $table = 'match_squad';
    public $primaryKey = 'id';

    protected $fillable = ['match_id', 'first_team', 'second_team', 'first_players_json', 'second_players_json'];

}
