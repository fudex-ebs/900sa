<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Request_point extends Model
{
    protected  $fillable =['user_id','points','status','notes'];
}
