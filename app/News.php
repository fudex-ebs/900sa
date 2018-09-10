<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $fillable = ['title_ar','body','img','body','created_by','sort','publish'];
}
