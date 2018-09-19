<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TenderBid extends BaseModel
{
    protected $fillable = ['bid_number','user_id','tender_id'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function user()
    {
        return $this->belongsTo('App\Tender');
    }
}
