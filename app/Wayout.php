<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wayout extends Model
{
    protected $fillable = ['branch_id' ,'wayout_date','way_cities','wayin_status','status'];

    public function wayins($value='')
    {
    	return $this->hasOne('App\Wayin');
    }

    public function branch($value='')
    {
    	return $this->belongsto('App\Branch');
    }

    public function wayoutdetails($value='')
    {
    	return $this->hasMany('App\Wayoutdetail');
    }

    public function waysales($value='')
    {
    	return $this->hasMany('App\Waysale');
    }

    public function waycreditsales($value='')
    {
        return $this->hasMany('App\Waysale');
    }

    public function waystockadds($value='')
    {
        return $this->hasMany('App\Waystockadd');
    }

}
