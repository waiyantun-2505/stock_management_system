<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class city extends Model
{
    protected $fillable = ['name','region_id'];

    public function ways($value='')
    {
    	return $this->hasMany('App\Way');
    }

    public function customers($value='')
    {
    	return $this->hasMany('App\Customer');
    }

    public function region($value='')
    {
        return $this->belongsto('App\Region');
    }

    
}
