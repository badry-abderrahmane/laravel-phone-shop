<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{

    protected $fillable = [
        'value', 'desc','tags','suboptiongroup_id'
    ];

    public function optiongroup(){
        return $this->belongsTo('App\Optiongroup');
    }

    public function productoptions(){
        return $this->hasMany('App\Productoption');
    }
}
