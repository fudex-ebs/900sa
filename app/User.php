<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password','mobile','active','address','lat','lng','region','UserRole_id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function getTableColumns() {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }

    public function company()
    {
        return $this->hasOne('App\Company');
    }
    public function user_role()
    {
        return $this->belongsTo('App\UserRole');
    }
    public function tender()
    {
        return $this->hasMany('App\Tender');
    }
}
