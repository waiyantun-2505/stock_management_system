<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Waysale extends Model
{
    protected $fillable = ['wayout_id','b_short','voucher_no','waysale_date','customer_id','total_amount','discount','bonus','balance','status'];

    public function wayout($value='')
    {
    	return $this->belongsto('App\Wayout');
    }

    public function customer($value='')
    {
    	return $this->belongsto('App\Customer');
    }

    public function waysaledetails($value='')
    {
    	return $this->hasMany('App\Waysaledetail');
    }
}
