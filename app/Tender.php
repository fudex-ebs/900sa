<?php

namespace App;


class Tender extends BaseModel
{
    protected $fillable = ['title','category_id','description','image','user_id','status','lat','lng'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function category()
    {
        return $this->belongsTo('App\Category');
    }
    public function bids()
    {
        return $this->hasMany('App\TenderBid');
    }

}
