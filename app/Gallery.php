<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    
    protected $fillable = [
        'name', 'link', 'desc','tags','order','product_id'
    ];
    
    public function product(){
        return $this->belongsTo('App\Product');
    }

}
