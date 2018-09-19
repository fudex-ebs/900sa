<?php

namespace App;


class Company extends BaseModel
{
    protected $fillable = ['company_code','user_id','category_id','about','commercial_registration_no','commercial_registration_expire_date',
        'commercial_registration_img','points','qr_code','word_hours ','instagram',
        'facebook','twitter','snapshat','website','special'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function category()
    {
        return $this->belongsTo('App\Category');
    }
    public function rates()
    {
        return $this->hasMany('App\Rate','company_id');
    }
}
