<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = ['name','city_id','phone','address','way','marketer_id','delivery_gate','delivery_phone'];

    
    public function city($value='')
    
    {
    	return $this->belongsto('App\City');
    }

    public function sales($value='')
    
    {
    	return $this->hasMany('App\Sale');
    }

    public function waysales($value='')
    
    {
    	return $this->hasMany('App\Waysale');
    }

    public function marketer($value='')
    
    {
        return $this->belongsto('App\Marketer');
    }

}

