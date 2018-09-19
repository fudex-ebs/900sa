<?php

namespace App;


class PointRequest extends BaseModel
{
    protected  $fillable =['company_id','points_number','status'];

    public function conpany(){
    	$this->belongsTo('App\Company')
    }
}
