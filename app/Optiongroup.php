<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Optiongroup extends Model
{

    protected $fillable = [
        'name', 'desc','tags','order','category_id'
    ];

    public function category(){
        return $this->belongsTo('App\Category');
    }

    public function options(){
        return $this->hasMany('App\Options');
    }
}
