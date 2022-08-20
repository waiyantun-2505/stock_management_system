<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class waycreditsaledetail extends Model
{
    protected $fillable = ['waysale_id','product_id','quantity','amount'];

    public function waycreditsale($value='')
    {
    	return $this->belongsto('App\Waycreditsale');
    }

    public function product($value='')
    {
    	return $this->belongsto('App\Product');
    }
}
