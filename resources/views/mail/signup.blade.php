سلام {{ $email_data['name'] }}
<br>
خوش آمدید
<br>
جهت فعال سازی روی <a href="{{env('APP_URL')}}/verify?code={{ $email_data['verification_code'] }}">لینک</a> کلیک کنید
<br>
{{--TODO--}}

<br>
سپاس
