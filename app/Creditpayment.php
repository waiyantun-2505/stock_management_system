<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class creditpayment extends Model
{
    protected $fillable = ['voucher_no','creditsale_id','amount'];

    public function creditsale($value='')
    {
    	return $this->belongsto('App\Creditsale');
    }
}
