<?php

namespace App;


class UserRole extends BaseModel
{
    protected $fillable = ['title','active'];
    public function user()
    {
        return $this->hasMany('App\User');
    }
}
