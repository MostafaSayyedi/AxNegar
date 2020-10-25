<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $appends = ['total'];

    protected $fillable = [
        'price', 'title', 'user_id', 'description', 'parent_id', 'status'
    ];

    public function getTotalAttribute()
    {
        return $this->price;
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parent()
    {
        return $this->belongsTo(Wallet::class, 'parent_id');
    }

    public function childrens()
    {
        return $this->hasMany(Wallet::class, 'parent_id');
    }

    public function getStatusAttribute($value)
    {
        if ($value == 0){
            return 'در حال بررسی';
        }elseif ($value == 1){
            return 'شارژ شد';
        }

    }

    public function getCreatedAtAttribute($value)
    {
        $date = verta()->formatDate($value);
        $date= explode('-', $date);
        return implode('/', $date);
    }

    public function getAddressAttribute()
    {
        return $this->price;
    }

    public function payment()
    {
        return $this->morphOne(Payment::class, 'paymentable');
    }
}
