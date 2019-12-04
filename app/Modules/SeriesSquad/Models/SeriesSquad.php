<?php

namespace App\Modules\SeriesSquad\Models;

use Illuminate\Database\Eloquent\Model;

class SeriesSquad extends Model {
    public $table = 'series_squad';
    public $primaryKey = 'id';

    protected $fillable = ['slug', 'json'];

}
