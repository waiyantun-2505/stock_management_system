<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    protected $fillable = [ 'transfer_date' , 'from_branch' , 'to_branch' ];

    public function branch($value='')
    {
    	return $this->belongsto('App\Branch');
    }

    public function transferdetails($value='')
    {
    	return $this->hasMany('App\Transferdetail');
    }
}
