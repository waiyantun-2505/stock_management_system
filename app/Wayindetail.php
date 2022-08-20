<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wayindetail extends Model
{
    protected $fillable = ['wayin_id' , 'product_id', 'quantity'];

    public function wayin($value='')
    {
    	return $this->belongsto('App\Wayin');
    }

    public function product($value='')
    {
    	return $this->belongsto('App\Product');
    }
}
