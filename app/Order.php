<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function user() {
        return $this->belongsTo('App\User')->withDefault(); // An order belongs to a user
    }

    public function orderlines() {
        return $this->hasMany('App\Orderline'); // An order has many orderlines
    }
}
