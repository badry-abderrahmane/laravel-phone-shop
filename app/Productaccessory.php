<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Productaccessory extends Model
{


  public function accessory(){
      return $this->belongsTo('App\Accessory');
  }

  public function product(){
      return $this->belongsTo('App\Product');
  }
  
}
