<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = ['b_short','voucher_no','customer_id','saledate','branch_id','total_amount','discount', 'bonus' ,'balance', 'status'];

    public function customer($value='')
    {
    	return $this->belongsto('App\Customer');
    }

    public function saledetails($value='')
    {
    	return $this->hasMany('App\Saledetail');
    }

    public function branch($value='')
    {
    	return $this->belongsto('App\Branch');
    }

    public function promotiondetail($value='')
    {
        return $this->hasMany('App\Promotiondetail');
    }
}
