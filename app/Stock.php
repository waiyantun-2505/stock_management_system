<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $fillable = [ 'product_id' , 'branch_id' , 'quantity' ];

    public function product($value='')
    {
    	return $this->belongsto('App\Product');
    }

    public function branch($value='')
    {
    	return $this->belongsto('App\Branch');
    }
}
