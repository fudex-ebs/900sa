<?php

namespace App;


class Favourite extends BaseModel
{
    protected $fillable = ['item_id','user_id','item_type'];
}
