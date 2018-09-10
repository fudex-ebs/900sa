<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Requests_order extends Model
{
        protected $fillable = ['title','category','sub_category','description','file','created_by','address','lat','lng'];

}
