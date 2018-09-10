<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Social_links extends Model
{
    protected  $fillable = ['title','value','sort','active'];
}
