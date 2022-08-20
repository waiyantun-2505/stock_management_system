<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class branch extends Model
{
    protected $fillable	=	[ 'name' , 'address' , 'phone'];

    public function orders($value='')
    {
    	return $this->hasMany('App\Order');
    }

    public function sales($value='')
    {
    	return $this->hasMany('App\Sale');
    }

    public function stocks($value='')
    {
    	return $this->hasMany('App\Stock');
    }

    public function transfers($value='')
    {
        return $this->hasMany('App\Transfer');
    }

    public function ordersdetails($value='')
    {
        return $this->hasMany('App\Orderdetail');
    }

    public function wayins($value='')
    {
        return $this->hasMany('App\Wayin');
    }

    public function wayouts($value='')
    {
        return $this->hasMany('App\Wayout');
    }

    public function waystockadds($value='')
    {
        return $this->hasMany('App\Waystockadd');
    }
}
