<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Creditsaledetail extends Model
{
    protected $fillable = ['creditsale_id','product_id','quantity','sale_return','return_date','amount'];

    public function creditsale($value='')
    {
    	return $this->belongsto('App\Creditsale');
    }

    public function product($value='')
    {
    	return $this->belongsto('App\Product');
    }
}
