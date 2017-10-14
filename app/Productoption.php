<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Productoption extends Model
{
    
    protected $fillable = [
        'value', 'desc','tags','product_id','option_id'
    ];

    public function product(){
        return $this->belongsTo('App\Product');
    }

    public function option(){
        return $this->belongsTo('App\Option');
    }

}   
