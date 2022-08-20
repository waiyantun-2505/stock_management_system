<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wayoutdetail extends Model
{
    protected $fillable = ['wayout_id','product_id','quantity'];

    public function wayout($value='')
    {
    	return $this->belongsto('App\Wayout');
    }

    public function product($value='')
    {
    	return $this->belongsto('App\Product');
    }
}
