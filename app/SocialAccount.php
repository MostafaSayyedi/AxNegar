<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

class SocialAccount extends Model
{




    public function getIconAttribute($value)
    {
        $value = URL::to('/social/icon').'/'.$value;
        return $value;
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
