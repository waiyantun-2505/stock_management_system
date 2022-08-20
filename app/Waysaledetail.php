<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Waysaledetail extends Model
{
    protected $fillable = ['waysale_id','product_id','quantity','amount'];

    public function waysale($value='')
    {
    	return $this->belongsto('App\Waysale');
    }

    public function product($value='')
    {
    	return $this->belongsto('App\Product');
    }
}
