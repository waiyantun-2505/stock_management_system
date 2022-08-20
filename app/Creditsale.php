<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Creditsale extends Model
{
    protected $fillable = ['b_short' ,'voucher_no','customer_id','saledate','branch_id','total_amount','discount', 'bonus' ,'balance','payamount', 'status'];

    public function customer($value='')
    {
    	return $this->belongsto('App\Customer');
    }

    public function creditsaledetails($value='')
    {
    	return $this->hasMany('App\Creditsaledetail');
    }

    public function branch($value='')
    {
    	return $this->belongsto('App\Branch');
    }

    public function creditpayments($value='')
    {
        return $this->hasMany('App\Creditpayment');
    }

    public function promotiondetail($value='')
    {
        return $this->hasMany('App\Promotiondetail');
    }
}
