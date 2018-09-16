<?php

namespace App;


class Contact extends BaseModel
{
    protected $fillable = ['name','email','mobile','body','read'];
}
