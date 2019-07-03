<?php

namespace App\Modules\Gallery\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model {
    public $table = 'gallery';
    public $primaryKey = 'id';

    protected $fillable = [ 'type', 'item_id', 'image'];

}
