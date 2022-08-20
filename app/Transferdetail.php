<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transferdetail extends Model
{
    protected $fillable = [ 'transfer_id' , 'product_id' , 'quantity' ];

    public function transfer($value='')
    {
    	return $this->belongsto('App\Transfer');
    }

    public function product($value='')
    {
    	return $this->belongsto('App\Product');
    }
}
