<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class region extends Model
{
    protected $fillable = ['name'];

    public function cities($value='')
    {
    	return $this->hasMany('App\City');
    }
}
