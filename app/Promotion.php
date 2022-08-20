<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    protected $fillalbe = ['name','from','to'];

    public function promotiondetail($value='')
    {
    	return $this->hasMany('App\Promotiondetail');
    }

    public function waypromotion($value='')
    {
    	return $this->hasMany('App\Waypromotion');
    }
}
