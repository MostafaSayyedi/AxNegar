<?php

namespace App;

use App\Notifications\ResetPassword;
use Hekmatinasser\Verta\Verta;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\URL;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use HasRoles;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'cover_img', 'city','is_verified', 'state','gender','portfolio','bio','name','f_name', 'provider', 'provider_id','instagram','twitter','facebook','user_name','birthday'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    // send reset email
//   public function sendPasswordResetNotification($token)
//     {
//         $this->notify(new ResetPassword(app('auth.password.broker')->createToken($this)));
//     }
    public function getPhotoAttribute($value)
    {
        $value = URL::to('/avatar').'/'.$value;
        return $value;
    }
    public function getCoverImgAttribute($value)
    {
        $value = URL::to('/cover').'/'.$value;
        return $value;
    }

    public function toPersianNum($number)
    {
        $number = str_replace("1","۱",$number);
        $number = str_replace("2","۲",$number);
        $number = str_replace("3","۳",$number);
        $number = str_replace("4","۴",$number);
        $number = str_replace("5","۵",$number);
        $number = str_replace("6","۶",$number);
        $number = str_replace("7","۷",$number);
        $number = str_replace("8","۸",$number);
        $number = str_replace("9","۹",$number);
        $number = str_replace("0","۰",$number);
        return $number;
    }

    public function getBirthdayAttribute($value)
    {
        $val= verta($value);

        return $this->toPersianNum($val->format('%Y,%m,%d'));

        $value = Verta::getJalali($value);
        return $value;
    }

    public function isUser()
    {
        return $this->type == '1' ? true : false;
    }

    public function isAdmin()
    {
        return $this->type == '2' ? true : false;
    }

    public function images()
    {
        $this->hasMany(Image::class);
    }

    public function comments()
    {
        $this->hasMany(Comment::class);
    }

    public function getActiveAttribute($value)
    {
        if ($value == 0){
            return 'غیر فعال';
        }
        else if ($value == 1) {
            return 'فعال';
        }
    }
    public function getGenderAttribute($value)
    {
        if ($value == 1){
            return 'مرد';
        }
        else if ($value == 2) {
            return 'زن';
        }
    }

    public function socialAccounts()
    {
        return $this->hasMany(SocialAccount::class);
    }
    public function wallets()
    {
        return $this->hasMany(Wallet::class);
    }
    public function rates()
    {
        return $this->hasMany(Rate::class);
    }
    public function reports()
    {
        return $this->hasMany(Rate::class);
    }

}
