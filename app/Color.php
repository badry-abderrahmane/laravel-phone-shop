<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    protected $fillable = [
        'name', 'code', 'desc','tags'
    ];

    public function productcolors(){
        return $this->hasMany('App\Productcolor');
    }
}
