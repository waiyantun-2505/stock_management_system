<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orderdetail extends Model
{
   protected $fillable = ['order_id','product_id','branch_id','quantity','order_return'];

   public function order($value='')
   {
   		return $this->belongsto('App\Order');
   }

   public function product($value='')
   {
   		return $this->belongsto('App\Product');
   }

   public function branch($value='')
   {
   		return $this->belongsto('App\Branch');
   }
}
