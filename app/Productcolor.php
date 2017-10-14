<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Productcolor extends Model
{
    protected $fillable = [
        'value', 'desc','tags','suboptiongroup_id'
    ];

    public function product(){
        return $this->belongsTo('App\Product');
    }

    public function color(){
        return $this->belongsTo('App\Color');
    }
}
