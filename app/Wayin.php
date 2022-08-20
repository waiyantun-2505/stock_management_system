<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wayin extends Model
{
    protected $fillable = [ 'wayout_id' , 'branch_id' , 'wayin_date' ];

    public function wayout($value='')
    {
    	return $this->belongsto('App\Wayout');
    }

    public function branch($value='')
    {
    	return $this->belongsto('App\Branch');
    }

    public function wayindetails($value='')
    {
    	return $this->hasMany('App\Wayindetail');
    }
}
