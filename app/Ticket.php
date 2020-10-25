<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
use Spatie\Permission\Models\Role;

class Ticket extends Model
{

    protected $fillable=['status'];

    public function childs()
    {
        return $this->hasMany(Ticket::class, 'parent_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function role()
    {
        return $this->belongsTo( Role::class);
    }

    public function getStatusAttribute($value)
    {
        if ($value == 0) {
            return 'در حال بررسی';
        }
        if ($value == 1) {
            return 'جواب داده شد';
        }
        if ($value == 2) {
            return 'پاسخ مشتری';
        }
    }
    public function getAdvantageAttribute($value)
    {
        if ($value == 0) {
            return 'فوری';
        }
        if ($value == 1) {
            return 'مهم';
        }
        if ($value == 2) {
            return 'عادی';
        }
    }

    public function getCreatedAtAttribute($value)
    {
        return verta()->formatDate($value);
    }

    public function getImageAttribute($value)
    {
        $value = URL::to('/avatar').'/'.$value;
        return $value;
    }
}
