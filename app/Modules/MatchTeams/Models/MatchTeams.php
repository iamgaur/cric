<?php

namespace App\Modules\MatchTeams\Models;

use Illuminate\Database\Eloquent\Model;
use App\Modules\Match\Models\Match;

class MatchTeams extends Model {
    public $table = 'match_teams';
    public $primaryKey = 'id';

    protected $fillable = ['match_id', 'first_team', 'second_team'];

}
