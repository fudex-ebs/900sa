<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = ['airport','company_id','short_code','long_code','user_id','category','about','commercial_registration_no','commercial_registration_expire_date',
        'commercial_registration_img','points','company_type','qr_code','rate','opining_times','instagram',
        'facebook','twitter','snapshat','site','special'];
}
