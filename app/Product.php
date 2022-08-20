<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['code_no','name','subcategory_id','order_price','sale_price'];

    public function subcategory($value='')
    {
    	return $this->belongsto('App\Subcategory');
    }

    public function waydetails($value='')
    {
    	return $this->hasMany('App\Waydetail');
    }

    public function orderdetails($value='')
    {
    	return $this->hasMany('App\Orderdetail');
    }
                       
    public function saledetails($value='')
    {
    	return $this->hasMany('App\Saledetail');
    }

    public function stocks($value='')
    {
    	return $this->hasMany('App\Stock');
    }

    public function transferdetails($value='')
    {
        return $this->hasMany('App\Transferdetail');
    }

    public function wayindetails($value='')
    {
        return $this->hasMany('App\Wayindetail');
    }

    public function wayoutdetails($value='')
    {
        return $this->hasMany('App\Wayoutdetail');
    }

    public function waysaledetails($value='')
    {
        return $this->hasMany('App\Waysaledetail');
    }

    public function promotiondetail($value='')
    {
        return $this->hasMany('App\Promotiondetail');
    }
}
