<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['suppliername','orderdate','return_date', 'status'];

    public function orderdetails($value='')
    {
    	return $this->hasMany('App\Orderdetail');
    }

    public function branch($value='')
    {
    	return $this->belongsto('App\Branch');
    }
}
