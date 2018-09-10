<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $fillable = ['lat','lng','country','airport_type','name','position','code','sort','active'];
}
