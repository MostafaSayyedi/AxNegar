<!DOCTYPE html>
<!--[if lt IE 7 ]> <html class="ie ie6 no-js" lang="{{ str_replace('_', '-', app()->getLocale()) }}"> <![endif]-->
<!--[if IE 7 ]>    <html class="ie ie7 no-js" lang="{{ str_replace('_', '-', app()->getLocale()) }}"> <![endif]-->
<!--[if IE 8 ]>    <html class="ie ie8 no-js" lang="{{ str_replace('_', '-', app()->getLocale()) }}"> <![endif]-->
<!--[if IE 9 ]>    <html class="ie ie9 no-js" lang="{{ str_replace('_', '-', app()->getLocale()) }}"> <![endif]-->
<!--[if gt IE 9]><!-->
<html class="no-js" lang="{{ str_replace('_', '-', app()->getLocale()) }}"><!--<![endif]-->
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>@yield('pageTitle')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
          content="Fullscreen Background Image Slideshow with CSS3 - A Css-only fullscreen background image slideshow"/>
    <meta name="keywords" content="css3, css-only, fullscreen, background, slideshow, images, content"/>
    <meta name="author" content="Codrops"/>

    {{--    <link rel="shortcut icon" href="../favicon.ico">--}}


    {{--    <link rel="stylesheet" type="text/css" href="{{ asset('usr/css/demo.css') }}"/>--}}
    <link rel="stylesheet" type="text/css" href="{{ asset('usr/css/style1.css') }}"/>

    <link rel="stylesheet" href="{{asset('/css/persian-datepicker.min.css') }}">
    {{--    <link href="https://cdn.rawgit.com/rastikerdar/sahel-font/v1.0.0-alpha23/dist/font-face.css" rel="stylesheet" type="text/css"/>--}}
    <script type="text/javascript" src="{{ asset('usr/js/modernizr.custom.86080.js') }}"></script>
    <!-- Bootstrap CSS file -->
    <link rel="stylesheet" href="{{ asset('usr/css/bootstrap-rtl.min.css') }}" media="screen">
    <link href="{{ asset('css/thumbnail-slider.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('css/ninja-slider.css') }}" rel="stylesheet" type="text/css"/>
    <!-- Fonts -->
    <link href="{{ asset('css/font.css') }}" rel="stylesheet">
    <script src="{{asset('js/fontawesome.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/sweetalert.js')}}" type="text/javascript"></script>
    {{--    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>--}}
    <script src="{{asset('js/thumbnail-slider.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/ninja-slider.js')}}" type="text/javascript"></script>
</head>
@yield('css')
{{--@include('errors')--}}
<style>
    .navbar-nav a {
        font-size: 0.8rem!important;
    }
    .fixed-top {
        position: static;
    }
    .carousel-inner{
        position: fixed;z-index: -2;
    }
    #footer{
        z-index: -1 !important;
    }
</style>

<body id="page">
@include('sweet::alert')
@if(Session::has('fail'))
    <script type="text/javascript">
        swal({
            title: 'Oops!',
            text: "{{Session::get('fail')}}",
            type: 'error',
            timer: 5000
        }).then((value) => {
            //location.reload();
        }).catch(swal.noop);
    </script>
@endif
@if(Session::has('success'))
    <script type="text/javascript">
        swal({
            title: 'تبریک',
            text: "{{Session::get('success')}}",
            type: 'success',
            timer: 6000
        }).then((value) => {
            //location.reload();
        }).catch(swal.noop);
    </script>
@endif
<!-- Carousel 100% Fullscreen -->
<!-- Navigation -->
<nav style="background-color:rgba(0, 0, 0, 0.75) !important" class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
    <a href="{{route('welcome')}}" class="navbar-brand">Brand</a>
    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>
    <form style="width:100%;" class="form" action="{{ route('images.search.index') }}" method="get">
        <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">

            <div class="navbar-nav">
                @if (\Auth::check() and \Auth::user()->isUser() )
                    <a href="{{ route('user.showInfo') }}" class="nav-item nav-link">تنظیمات</a>
                    <a href="{{ route('upload.create') }}" class="nav-item nav-link">آپلود عکس</a>
                    <a href="{{ route('welcomeaccount',['username'=>auth()->user()->user_name]) }}" class="nav-item nav-link">پروفایل</a>
                @endif
                <a href="{{ route('explore') }}" class="nav-item nav-link">کاوش</a>
                <a href="{{ route('contactus') }}" class="nav-item nav-link">تماس با ما</a>
                <a href="{{ route('aboutus') }}" class="nav-item nav-link">درباره ما</a>
                <a href="{{ route('user.copyright.index') }}" class="nav-item nav-link">پیگیری حق نشر</a>


            </div>
            <div @if(auth()->check()) class="col-md-1"
                 @else
                 class="col-md-2"
                @endif
            >
                <div class="nav-item dropdown">
                    <select name="category_id" class=" browser-default custom-select">
                        <option disabled selected>دسته بندی</option>
                        @foreach(\App\Category::all() as $category)
                            <option class="" value="{{$category->id}}">{{ $category->title }}</option>
                        @endforeach
                    </select>

                </div>
            </div>
            <div class="col-md-1">
                <div class="form-groupp">
                    <input name="time_start" placeholder="از تاریخ" type="text" class="time-start form-control">
                </div>
            </div>
            <div class="col-md-1">
                <div class="form-groupp">
                    <input name="time_end" placeholder="تا تاریخ" type="text" class="time-end form-control">
                </div>
            </div>
            <div @if(auth()->check()) class="col-md-3"
                 @else
                 class="col-md-4"
                @endif
            >
                <div class="input-group">
                    <input type="text" name="title" class="form-control" placeholder="جستجو">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-secondary"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </div>

            @if (Route::has('login'))
                <div class="navbar-nav">
                    @auth
                        @if(Auth::user()->isAdmin())
                        <a class="nav-item nav-link" href="{{ url('/home') }}">پنل مدیریت</a>
                        @else
                            <a class="nav-item nav-link" href="{{ url('/home') }}">خانه</a>
                        @endif
                            <a class="nav-item nav-link" href="{{ url('/logout') }}">خروج</a>
                    @else
                        <a href="{{ route('login') }}" class="nav-item nav-link">ورود</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="nav-item nav-link">ثبت نام</a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>
    </form>
</nav>
@if(! \Request::is('/'))
{{--    <div style="margin-top: 70px;"></div>--}}
    @endif
@yield('body')

<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->

{{--    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>--}}
<script src="{{ asset('js/jquery-3-4-1.js') }}"></script>
<script src="{{ asset('js/persian-date.min.js') }}"></script>
<script src="{{ asset('js/persian-datepicker.min.js') }}"></script>
{{--    <script src="https://cdn.jsdelivr.net/npm/exif-js"></script>--}}
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"
        crossorigin="anonymous"></script>--}}
{{--<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>--}}
<script src="{{ asset('usr/js/bootstrap.min.js') }}"></script>
{{--for explore --}}
<script type='text/javascript' src='{{ asset('js/jquery.galereya.js') }}'></script>
<script type='text/javascript' src='{{ asset('js/js/jquery.justifiedGallery.min.js') }}'></script>

<link rel='stylesheet' href='{{ asset('css/jquery.galereya.css') }}' type='text/css'/>
<link rel='stylesheet' href='{{ asset('css/justifiedGallery.min.css') }}' type='text/css'/>


@if (\Request::is('login') || \Request::is('password/reset') || \Request::is('password/reset/*') || \Request::is('contact-us') || \Request::is('register') /*|| \Request::is('photo/*')*/ || \Request::is('photos/*') )
@else
    @include('front.footer')
@endif

<!-- END OF FOOTER -->
</body>
@yield('js')
<script type="text/javascript">/*


    window.onload=getExif;

    function getExif() {
        var img1 = document.getElementById("img1");
        EXIF.getData(img1, function() {
            var make = EXIF.getTag(this, "Make");
            var model = EXIF.getTag(this, "Model");
            var makeAndModel = document.getElementById("makeAndModel");
            makeAndModel.innerHTML = `${make} ${model}`;
        });

        var img2 = document.getElementById("img2");
        EXIF.getData(img2, function() {
            var allMetaData = EXIF.getAllTags(this);
            var allMetaDataSpan = document.getElementById("allMetaDataSpan");
            allMetaDataSpan.innerHTML = JSON.stringify(allMetaData, null, "\t");
        });
    }*/
    $(document).ready(function () {
        $(".time-start").pDatepicker(
            {
                initialValue: false,
                format: 'YYYY,MM,DD',
                'persian': {
                    'locale': 'fa',
                    'showHint': false,
                    'leapYearMode': 'algorithmic' // "astronomical"
                },
                'autoClose': true,
            }
        );
        $(".time-end").pDatepicker(
            {
                initialValue: false,
                format: 'YYYY,MM,DD',
                'persian': {
                    'locale': 'fa',
                    'showHint': false,
                    'leapYearMode': 'algorithmic' // "astronomical"
                },
                'autoClose': true,
            }
        );

    });
    function formValidate(form){
        var result = confirm("آیا میخواهید تغییر وضعیت دهید؟");
        if(result ==false){
            return false;
        }
    }
</script>

</html>

