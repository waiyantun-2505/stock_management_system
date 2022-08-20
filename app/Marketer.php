<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Marketer extends Model
{	

    protected $fillable = ['name'];

    public function customers($value='')
    {
    	return $this->hasMany('App\Customer');
    }

}
