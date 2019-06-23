<?php

namespace App\Modules\News\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model {
    public $table = 'news';
    public $primaryKey = 'id';

    protected $fillable = ['title', 'description', 'tags', 'posted', 'slug', 'meta_title', 'meta_description', 'meta_keywords'];

}
