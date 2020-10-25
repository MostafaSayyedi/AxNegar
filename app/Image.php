<?php

namespace App;

use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{

    protected $fillable= ['status','rndkey'];

 public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getSourcesAttribute($value)
    {
//        return 'storage/photo/'.$value;
        return 'storage/public/photo/'.$value;
    }
    public function getNewSourcesAttribute($value)
    {
//        return 'storage/photo/'.$value;
        return 'storage/public/photo/'.$value;
    }
    public function getGallerySourcesAttribute($value)
    {
//        return 'storage/photo/'.$value;
        return 'storage/public/photo/'.$value;
    }
    public function getSliderSourcesAttribute($value)
    {
//        return 'storage/photo/'.$value;
        return 'storage/public/photo/'.$value;
    }

    public function rates()
    {
        return $this->hasMany(Rate::class);
    }
    public function reports()
    {
        return $this->hasMany(Report::class);
    }
    public function getStatusAttribute($value)
    {
        if ($value == 0){
            return 'غیر فعال';
        }
        else if ($value == 1) {
            return 'فعال';
        }
    }
//convert persian number
    public function convert2english($string) {
        $newNumbers = range(0, 9);
        // 1. Persian HTML decimal
        $persianDecimal = array('&#1776;', '&#1777;', '&#1778;', '&#1779;', '&#1780;', '&#1781;', '&#1782;', '&#1783;', '&#1784;', '&#1785;');
        // 2. Arabic HTML decimal
        $arabicDecimal = array('&#1632;', '&#1633;', '&#1634;', '&#1635;', '&#1636;', '&#1637;', '&#1638;', '&#1639;', '&#1640;', '&#1641;');
        // 3. Arabic Numeric
        $arabic = array('٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩');
        // 4. Persian Numeric
        $persian = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');

        $string =  str_replace($persianDecimal, $newNumbers, $string);
        $string =  str_replace($arabicDecimal, $newNumbers, $string);
        $string =  str_replace($arabic, $newNumbers, $string);
        return str_replace($persian, $newNumbers, $string);
    }


// for search orders
    public function scopeSearch($query, $search)
    {
//        dd($search);
        $qu = '';
        foreach ($search as $key => $val) {
            if (isset($key) && !is_null($val)) {
                if ($key == 'title') {
                    $qu = $query->where("title",'like', '%'.$val.'%');
                }
                if ($key == 'category_id') {
                    $qu = $query->whereHas("category", function ($q) use ($val) {
                        $q->where("id", $val);
                    });
                }
                if ($key == 'time_start') {
                    $val= $this->convert2english($val);
                    $val=explode(',', $val);
                    $val= join('-', Verta::getGregorian($val[0],$val[1],$val[2]));

                    $qu = $query->whereDate("created_at", '>=', $val);
                }
                if ($key == 'time_end') {
                    $val= $this->convert2english($val);
                    $val=explode(',', $val);
                    $val= join('-', Verta::getGregorian($val[0],$val[1],$val[2]));

                    $qu = $query->whereDate("created_at", '<=', $val);
                }
            }else{
//                get all orders rows if all parameters in empty
                $qu = $query;
            }
        }
        $result = $qu->whereStatus('1')->get();

        return $result;
    }
}
