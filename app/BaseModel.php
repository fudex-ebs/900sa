<?php

namespace App;
use Auth;
use Validator;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    public $timestamps = true;
    protected $softDelete = true;
    protected $rules = [];
    protected $messages = [];
    protected $errors;
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
    public function errors($returnArray = true)
    {
        return $returnArray ? $this->errors->toArray() : $this->errors;
    }
}
