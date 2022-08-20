<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Promotiondetail extends Model
{
    protected $fillable = ['voucher_no','promotion_id','product_id','quantity'];

    public function sale($value='')
   {
   		return $this->belongsto('App\Sale');
   }

   public function creditsale($value='')
   {
   		return $this->belongsto('App\Creditsale');
   }

   public function waysale($value='')
   {
      return $this->belongsto('App\Waysale');
   }

   public function waycreditsale($value='')
   {
      return $this->belongsto('App\Waycreditsale');
   }

   public function promotion($value='')
   {
   		return $this->belongsto('App\Promotion');
   }

   public function product($value='')
   {
   		return $this->belongsto('App\Product');
   }
   
}
