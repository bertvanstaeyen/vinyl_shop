<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    public function genre() {
        return $this->belongsTo('App\Genre')->withDefault(); // A record belongs to a genre
    }
}
