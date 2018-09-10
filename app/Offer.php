<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $fillable = ['title','img','category','description','created_by','views','expire_date','active','file','link'];
}
