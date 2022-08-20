<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class waycreditpayment extends Model
{
    protected $fillable = ['voucher_no','creditsale_id','amount'];

    public function waycreditsale($value='')
    {
    	return $this->belongsto('App\Waycreditsale');
    }
}
