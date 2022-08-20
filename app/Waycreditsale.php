<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class waycreditsale extends Model
{
    protected $fillable = ['b_short' ,'voucher_no','wayout_id','customer_id','waysale_date','credit_method','total_amount','discount', 'bonus' ,'balance','payamount', 'status'];
    

    public function customer($value='')
    {
    	return $this->belongsto('App\Customer');
    }

    public function waycreditsaledetails($value='')
    {
    	return $this->hasMany('App\Waycreditsaledetail');
    }

    public function creditpayments($value='')
    {
        return $this->hasMany('App\Creditpayment');
    }

    public function promotiondetail($value='')
    {
        return $this->hasMany('App\Promotiondetail');
    }

    public function wayout($value='')
    {
        return $this->belongsto('App\Wayout');
    }
}
