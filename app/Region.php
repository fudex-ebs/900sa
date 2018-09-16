<?php

namespace App;


class Region extends BaseModel
{
    protected $fillable = ['lat','lng','country','airport_type','name','position','code','sort','active'];
}
