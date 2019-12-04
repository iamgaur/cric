<?php

namespace App\Modules\IccRanking\Models;

use Illuminate\Database\Eloquent\Model;

class IccRanking extends Model {
   public $table = 'icc_ranking';
   public $primaryKey = 'id';

   protected $fillable = ['item_id', 'ranking_type',
       't20_rating', 'odi_rating', 'test_rating', 't20_batting_rating', 't20_bowling_rating',
       't20_all_rounder_rating', 'odi_batting_rating', 'odi_bowling_rating', 'odi_all_rounder_rating',
       'test_batting_rating', 'test_bowling_rating', 'test_all_rounder_rating', 'gender'];
}
