<?php

namespace App;

class Categories extends BaseModel
{
	public $timestamps = true;
	protected $fillable = ['name','active'];
    
    public function companies()
    {
        return $this->hasMany('App\Company');
    }
    public function offers()
    {
        return $this->hasMany('App\Offer');
    }
    public function tenders()
    {
        return $this->hasMany('App\Offer');
    }
    protected $rules = [
        
    ];

    protected $messages = [
	public function validate($data)
    {
        $v = Validator::make($data, $this->rules, $this->messages);

        if ($v->fails()) {
            $this->errors = $v->messages();

            return false;
        }

        // validation pass
        return true;
    }
    
    
    
}
