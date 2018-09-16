<?php

namespace App;


class Company extends BaseModel
{
    protected $fillable = ['airport','short_code','long_code','user_id','category_id','about','commercial_registration_no','commercial_registration_expire_date',
        'commercial_registration_img','points','company_type','qr_code','rate','opining_times','instagram',
        'facebook','twitter','snapshat','site','special'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function category()
    {
        return $this->belongsTo('App\Category');
    }
}
