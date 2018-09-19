<?php

namespace App;


class Offer extends BaseModel
{
    protected $fillable = ['title','img','category_id','description','company_id','views','active'];

    public function category()
    {
        return $this->belongsTo('App\Category');
    }
    public function company()
    {
        return $this->belongsTo('App\Company');
    }
}
