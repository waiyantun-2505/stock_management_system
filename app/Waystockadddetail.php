<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Waystockadddetail extends Model
{
    protected $fillable = ['waystockadd_id','product_id' ,'quantity'];

    public function waystockadd($value='')
    {
    	return $this->belongsto('App\Waystockadd');
    }

    public function product($value='')
    {
        return $this->belongsto('App\Product');
    }

    
}
