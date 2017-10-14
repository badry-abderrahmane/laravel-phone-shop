<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Accessory extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $fillable = [
        'name', 'link', 'imgs','desc','tags','product_id','category_id',
    ];

   
    public function category(){
        return $this->belongsTo('App\Category');
    }

    public function product(){
        return $this->belongsTo('App\Product');
    }
}
