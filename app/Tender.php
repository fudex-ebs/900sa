<?php

namespace App;


class Tender extends BaseModel
{
    protected $fillable = ['title','category_id','sub_category','description','file','user_id','address'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

}
