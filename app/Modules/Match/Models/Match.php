<?php

namespace App\Modules\Match\Models;

use Illuminate\Database\Eloquent\Model;
use App\Modules\Series\Models\Series;

class Match extends Model {
    public $table = 'matches';
    public $primaryKey = 'id';

    protected $fillable = ['series_id', 'match_title', 'result', 'match_date', 'player_of_match',
       'location', 'stadium', 'match_type', 'posted', 'slug', 'meta_title', 'meta_description', 'meta_keywords'];

    public function Series() {
        return $this->belongsTo(Series::class);
    }
}
