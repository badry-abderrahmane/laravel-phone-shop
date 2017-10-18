<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $fillable = [
        'name', 'shortDesc','longDesc','imgs','links','tags','state','category_id','serie_id'
    ];

    public function category(){
        return $this->belongsTo('App\Category');
    }

    public function serie(){
        return $this->belongsTo('App\Serie');
    }

    public function galleries(){
        return $this->hasMany('App\Gallery');
    }

    public function productoptions(){
        return $this->hasMany('App\Productoption');
    }

    public function productcolors(){
        return $this->hasMany('App\Productcolor');
    }

    public function productaccessories(){
        return $this->hasMany('App\Productaccessory');
    }
}
