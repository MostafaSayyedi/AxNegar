<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
//protected $with=['childrens'];

    public function childrens()
    {
        return $this->hasMany(Comment::class, 'parent_id')->with('childrens')->with('user')->with('image')->orderBy('created_at', "desc");
//        return $this->hasMany(Comment::class, 'parent_id')->without('childrens');
    }
    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function image()
    {
        return $this->belongsTo(Image::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
