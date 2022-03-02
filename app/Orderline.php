<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orderline extends Model
{
    public function order() {
        return $this->belongsTo('App\Order')->withDefault(); // An orderline belongs to an order
    }
}
