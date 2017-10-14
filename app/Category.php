<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'desc', 'tags','order','state'
    ];

    public function products(){
        return $this->hasMany('App\Product');
    }

    public function accessories(){
        return $this->hasMany('App\Accessory');
    }

    public function optiongroups(){
        return $this->hasMany('App\Optiongroup');
    }

}
