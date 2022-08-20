<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class waystockadd extends Model
{
    protected $fillable = ['wayout_id','branch_id' ,'wayadd_date','send_status','send_date','status'];

    public function wayout($value='')
    {
    	return $this->belongsto('App\Wayout');
    }

    public function branch($value='')
    {
    	return $this->belongsto('App\Branch');
    }

    public function waystockadddetails($value='')
    {
    	return $this->hasMany('App\Waystockadddetail');
    }
}
