<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Saledetail extends Model
{
    protected $fillable = ['sale_id','product_id','quantity','sale_return','return_date','amount'];

    public function sale($value='')
    {
    	return $this->belongsto('App\Sale');
    }

    public function product($value='')
    {
    	return $this->belongsto('App\Product');
    }
}
