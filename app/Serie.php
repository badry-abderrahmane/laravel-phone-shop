<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Serie extends Model
{

    protected $fillable = [
        'name', 'code','desc','tags','order','state'
    ];

    public function products(){
        return $this->hasMany('App\Product');
    }

}
