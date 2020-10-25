@extends('user.layout.master')
{{--@extends('front.layout')--}}
@section('pageTitle', 'صفحه اصلی')
@section('body')
    <div class="profile_header" data-i18n-sharelizers="">
        <div class="cover_photo" style="background-image: url({{ $user->cover_img }}) ;background-repeat: no-repeat;
            background-size: cover;">
            <div class="cover_wrap">
                <div class="image"></div>
            </div>
        </div>
        @include('user.form-error')
        <div class="profile_header__user_avatar_region">
            <div class="user_avatar">
                <div class="user_avatar__avatar_wrapper">

                    <img class="user_avatar__avatar_image"
                         src="{{ $user->photo }}"
                         title="">

                </div>
                {{--<h2>{{$user->name}} {{$user->f_name}}</h2>--}}

                <div class="user_avatar__badge_wrapper">

                </div>

            </div>
        </div>
        <div class="profile_buttons">
            @if(auth()->check())
                <div class="wrapper">

                    <a data-toggle="modal"
                       data-target="#exampleModal2"
                       data-whatever="@mdo"
                       class="edit_profile_button button">ویرایش پروفایل</a>

                </div>
            @endif
        </div>
        <h2>{{$user->name}} {{$user->f_name}}</h2>
        <div class="user_links">
            <section class="about_tab__links">
            </section>
        </div>
    </div>
    <div class="container-fluid">

        <style>
            .nav-item nav-link{
                font-size: 0.9rem!important;
            }
            .profile_header {
                margin-bottom: 20px;
            }

            .cover_photo {
                position: relative;
                min-height: 130px;
                border-bottom: 1px solid #eeeff2;
                background: #fff;
                margin-bottom: -104px;
            }

            .profile_header * {
                text-align: center;
            }

            .user_avatar {
                margin: 0 auto;
                width: 104px;
                height: 104px;
                position: relative;
                z-index: 100;
                top: 52px;
            }

            .user_avatar__avatar_wrapper {
                background-color: #fff;
                -webkit-border-radius: 50%;
                border-radius: 50%;
                border: 2px solid #fff;
                width: 104px;
                height: 104px;
                overflow: hidden;
                margin: 0 auto;
                position: relative;
            }

            .user_avatar__avatar_image {
                width: 100%;
                height: 100%;
            }

            img {
                border: 0;
            }

            .user_avatar__badge_wrapper {
                position: absolute;
                width: 100%;
                height: 20px;
                bottom: 0;
                text-align: center;
                z-index: 30;
            }

            .user_avatar .pill {
                border: 1px solid #fff;
                -webkit-border-radius: 3px;
                border-radius: 3px;
                min-width: 65px;
            }

            .user_avatar .pill--pro {
                background: #111111;
            }

            .pill {
                display: inline-block;
                background-color: #b9c1c7;
                line-height: 18px;
                font-size: 11px;
                font-weight: bold;
                text-transform: uppercase;
                text-align: center;
                padding: 0 5px;
                -webkit-border-radius: 2px;
                border-radius: 2px;
                color: #fff;
                cursor: pointer;
                -webkit-transition: background-color 0.1s ease-in-out;
                -moz-transition: background-color 0.1s ease-in-out;
                transition: background-color 0.1s ease-in-out;
            }

            .profile_header .profile_buttons {
                position: relative;
                overflow: hidden;
                padding: 25px 0px 0 0;
                margin-bottom: 30px;
                text-align: right;
            }

            .profile_header .profile_buttons .wrapper {
                display: inline-block;
                font-size: 0;
            }

            .profile_header .profile_buttons .button.more {
                width: 40px;
                background-image: url(https://assetcdn.500px.org/assets/photos/more-903f3680b0b2dd8cd70add3c9b5cadbe.svg);
                background-repeat: no-repeat;
                background-position: center center;
                vertical-align: top;
            }

            .profile_header .profile_buttons .button {
                font-size: 14px;
            }

            .button.tertiary {
                background-color: #f7f8fa;
                border-color: rgba(185, 193, 199, 0.5);
                text-shadow: none;
                color: #71767a;
            }

            .button {
                cursor: pointer;
                display: inline-block;
                padding: 0 10px;
                height: 30px;
                line-height: 28px;
                -webkit-border-radius: 3px;
                border-radius: 3px;
                font-weight: bold;
                color: #fff;
                text-decoration: none;
                outline: none;
                background-color: #0099e5;
                border: 1px solid #0099e5;
                -webkit-transition: background-color 0.1s ease-in-out;
                -moz-transition: background-color 0.1s ease-in-out;
                transition: background-color 0.1s ease-in-out;
            }

            .profile_header .profile_buttons .button.more::after {
                position: absolute;
                width: 0;
                height: 0;
                overflow: hidden;
                content: url(//assetcdn.500px.org/assets/unity/img/spinners/loader-small-9667a00….gif);
            }

            .profile_buttons .profile_buttons__sharelizers, .sticky_ui .profile_buttons__sharelizers {
                vertical-align: top;
                display: inline-block;
                line-height: 0px;
                margin: 0 10px;
            }

            .profile_header .profile_buttons .button.share {
                padding-left: 26px;
                padding-right: 10px;
                /*background-image: url(https://assetcdn.500px.org/assets/share-3ff218d2fd7110582123fdd0e1504237.svg);*/
                background-position: 10px center;
                background-repeat: no-repeat;
                background-size: 16px;
            }

            .extra-actions-widget .extra-actions-button {
                width: 100%;
            }

            .button.tertiary {
                background-color: #f7f8fa;
                border-color: rgba(185, 193, 199, 0.5);
                text-shadow: none;
                color: #71767a;
            }

            .popover {
                width: 350px;
            }

            .popover {
                position: relative;
                width: 276px;
                z-index: 2010;
            }

            .popover .contain {
                background: #f7f8fa;
                -webkit-border-radius: 3px;
                border-radius: 3px;
                -webkit-box-shadow: 0 2px 25px rgba(0, 0, 0, 0.2);
                box-shadow: 0 2px 25px rgba(0, 0, 0, 0.2);
            }

            .popover .inside {
                height: 100%;
                color: #525558;
                border-right-color: #eeeff2;
                background-color: #fff;
                -webkit-border-radius: 3px;
                border-radius: 3px;
                border: 2px solid #c7ced2;
                z-index: 2105;
                position: relative;
                width: 100%;
                overflow: hidden;
            }

            .clearfix {
                display: block;
            }

            .popover .list li:first-child {
                border-top: 0;
            }

            .popover .list li {
                font-size: 14px;
                font-weight: normal;
                color: #71767a;
                line-height: 48px;
                background-color: #f7f8fa;
                border-top: 1px solid #eeeff2;
                height: 50px;
                -webkit-tap-highlight-color: transparent;
                -webkit-transition: background-color 0.1s;
                -moz-transition: background-color 0.1s;
                transition: background-color 0.1s;
            }

            .extra-actions-dropdown-composite .extra-action {
                background-color: #fff !important;
                border-top: 1px solid #eeeff2 !important;
            }

            .extra-actions-dropdown-composite.list ul.sharelizers li.sharelizer a:not(:hover) {
                background-color: #fff;
            }

            .popover .list li a:not(.button):not(.add_to_galleries_popover_item__view_gallery_button) {
                display: block;
                color: #71767a;
                padding: 0 10px 0 10px;
                height: 100%;
            }

            .extra-actions-dropdown-composite.list a {
                font-size: 14px;
                cursor: pointer;
            }

            .extra-actions-dropdown-composite.list ul.sharelizers li.sharelizer.facebook:not(:hover) .icon {
                color: #3b5998;
            }

            .extra-actions-dropdown-composite.list ul.sharelizers li.sharelizer .icon {
                position: relative;
                top: 3px;
                font-size: 16px;
                padding-right: 5px;
            }

            [class*="icon-"] {
                font-family: "px";
                speak: none;
                font-style: normal;
                font-weight: normal;
                font-variant: normal;
                text-transform: none;
                line-height: 1;
                font-size: 32px;
                -webkit-font-smoothing: antialiased;
                -moz-osx-font-smoothing: grayscale;
            }

            .popover .list li a:not(.button):not(.add_to_galleries_popover_item__view_gallery_button) span {
                font-weight: normal;
            }

            .button.tertiary {
                background-color: #f7f8fa;
                border-color: rgba(185, 193, 199, 0.5);
                text-shadow: none;
                color: #71767a;
            }

            .button + .button {
                margin-left: 10px;
            }
        </style>
        <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-bodyy">
                        <button style="position: absolute;top: 1px;right: 1px;z-index: 99" type="button" class="close"
                                data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <form action="{{ route('user.saveInfo') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="edit_profile_modal">
                                <div class="header">
                                    <div class="cover_photo">
                                        <div class="cover_wrapper">
                                            <a class="overlay cover_button" for="cover_file_picker" data-hasqtip="3">
                                                {{--                                                <span class="icon">Change your cover photo</span>--}}
                                            </a>
                                            <input accept="image/jpeg"
                                                   data-i18n-error="An error occurred while uploading your cover photo. Please try again."
                                                   data-i18n-too-small="Cover photos must be in landscape orientation and at least 2000x1000 pixels"
                                                   id="cover_file_picker" style="display:none" type="file">
                                        </div>
                                        <div class="popover cover_photo_options extra-actions-dropdown-composite"
                                             style="display:none">
                                            <div class="arrow">
                                                <div class="fill"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="edit_profile_modal__user_avatar">
                                        <div class="user_avatar">
                                            <div class="user_avatar__avatar_wrapper">

                                                <img class="user_avatar__avatar_image"
                                                     src="{{ $user->photo }}"
                                                     title="">


                                                <label class="user_avatar__editing_overlay"
                                                       for="avatar_file_picker"></label>

                                            </div>
                                            <input name="avatar" accept="image/jpeg"
                                                   data-i18n-error="خطا! لطفا مجددا تلاش کنید"
                                                   data-i18n-too-big="خطا! اندازه عکس ارسال بزرگ میباشد"
                                                   id="avatar_file_picker" type="file">
                                            @if($errors->has('avatar'))
                                                <span class="help-block" style="color: red">
                                <strong>{{ $errors->first('avatar') }}</strong>
                                    </span>
                                            @endif
                                            <div class="user_avatar__badge_wrapper"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="edit_user_form">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-sm-12 col-md-6">
                                                <div class="form-group">
                                                    <label for="name">نام</label>
                                                    <input value="{{ $user->name }}" @error('name') is-invalid @enderror  class="form-control" width="100%" type="text" name="name"
                                                           id="name" placeholder="نام">
                                                    @if($errors->has('name'))
                                                        <span class="help-block" style="color: red">
                                <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-6">
                                                <div class="form-group">
                                                    <label for="family_name">نام خانوادگی</label>
                                                    <input value="{{ $user->f_name }}" @error('family_name') is-invalid @enderror class="form-control" width="100%" type="text"
                                                           name="family_name" id="family_name"
                                                           placeholder="نام خانوادگی">
                                                    @if($errors->has('family_name'))
                                                        <span class="help-block" style="color: red">
                                <strong>{{ $errors->first('family_name') }}</strong>
                                    </span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-sm-12 col-md-6">
                                                <div class="form-group">
                                                    <label for="instagram">اینستاگرام</label>
                                                    <input value="{{ $user->instagram }}" @error('instagram') is-invalid @enderror class="form-control" width="100%" type="text"
                                                           name="instagram" id="instagram" placeholder="اینستاگرام">
                                                    @if($errors->has('instagram'))
                                                        <span class="help-block" style="color: red">
                                <strong>{{ $errors->first('instagram') }}</strong>
                                    </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-6">
                                                <div class="form-group">
                                                    <label for="twitter">توییتر</label>
                                                    <input value="{{ $user->twitter }}" @error('twitter') is-invalid @enderror class="form-control" width="100%" type="text" name="twitter"
                                                           id="twitter" placeholder="توییتر">
                                                    @if($errors->has('twitter'))
                                                        <span class="help-block" style="color: red">
                                <strong>{{ $errors->first('twitter') }}</strong>
                                    </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-6">
                                                <div class="form-group">
                                                    <label for="cover_img">عکس کاور</label>
                                                    <input  @error('cover_img') is-invalid @enderror class="form-control" width="100%" type="file" name="cover_img"
                                                            id="twitter" placeholder="توییتر">
                                                    @if($errors->has('cover_img'))
                                                        <span class="help-block" style="color: red">
                                <strong>{{ $errors->first('cover_img') }}</strong>
                                    </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-6">
                                                <div class="form-group">
                                                    <label for="facebook">فیسبوک</label>
                                                    <input value="{{ $user->facebook }}" @error('facebook') is-invalid @enderror  class="form-control" width="100%" type="text" name="facebook"
                                                           id="facebook" placeholder="فیسبوک">
                                                    @if($errors->has('facebook'))
                                                        <span class="help-block" style="color: red">
                                <strong>{{ $errors->first('facebook') }}</strong>
                                    </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" style="margin-bottom: 5px"
                                                class="btn btn-success">ذخیره
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
        <style>
            .user_avatar input {
                display: none;
            }

            .user_avatar__editing_overlay:after {
                content: '';
                display: block;
                width: 16px;
                height: 13px;
                position: relative;
                top: 50%;
                -webkit-transform: translateY(-50%);
                -moz-transform: translateY(-50%);
                -ms-transform: translateY(-50%);
                transform: translateY(-50%);
                margin: 0 auto;
                /*background-image: url(https://assetcdn.500px.org/assets/profiles/camera-dc7f07d50e39b28b9cb3f3427f4fc426.svg);*/
                z-index: 20;
            }

            .user_avatar__editing_overlay {
                position: absolute;
                -webkit-border-radius: 50%;
                border-radius: 50%;
                top: 0;
                left: 0;
                background-color: rgba(0, 0, 0, 0.7);
                display: block;
                width: 100%;
                height: 100%;
                cursor: pointer;
                -webkit-transition: all 0.2s;
                -moz-transition: all 0.2s;
                transition: all 0.2s;
                z-index: 10;
            }

            .edit_profile_modal .edit_user_form {
                margin-top: 0;
                padding-top: 70px;
                background-color: #f7f8fa;
                -webkit-border-radius: 0 0 3px 3px;
                border-radius: 0 0 3px 3px;
            }

            .edit_profile_modal {
                width: 100%;
                background-color: transparent;
            }

            .edit_profile_modal {
                width: 100%;
                background-color: transparent;
            }

            .edit_profile_modal .cover_photo {
                -webkit-border-radius: 3px 3px 0 0;
                border-radius: 3px 3px 0 0;
                overflow: hidden;
                background-position: center center;
                background-size: cover;
            }

            .cover_photo {
                position: relative;
                min-height: 130px;
                border-bottom: 1px solid #eeeff2;
                background: #fff;
                margin-bottom: -104px;
            }

            .edit_profile_modal .cover_wrapper {
                text-align: center;
            }

            .edit_profile_modal .overlay {
                position: absolute;
                top: 0;
                left: 0;
                background-color: rgba(0, 0, 0, 0.7);
                display: block;
                width: 100%;
                height: 100%;
                cursor: pointer;
                -webkit-transition: all 0.2s;
                -moz-transition: all 0.2s;
                transition: all 0.2s;
            }

            .overlay {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                z-index: 10;
                -webkit-transition: opacity 0.2s;
                -moz-transition: opacity 0.2s;
                transition: opacity 0.2s;
            }

            .edit_profile_modal .cover_wrapper .icon {
                width: auto;
                color: #fff;
                padding-left: 20px;
                display: inline-block;
                background-size: 16px 16px;
                background-repeat: no-repeat;
                text-align: center;
                margin: 0 auto;
            }

            .edit_profile_modal .overlay .icon {
                display: block;
                width: 16px;
                height: 13px;
                position: relative;
                top: 50%;
                -webkit-transform: translateY(-50%);
                -moz-transform: translateY(-50%);
                -ms-transform: translateY(-50%);
                transform: translateY(-50%);
                margin: 0 auto;
                /*background-image: url(//assetcdn.500px.org/assets/profiles/camera-dc7f07d….svg);*/
            }

            .edit_profile_modal .overlay {
                position: absolute;
                top: 0;
                left: 0;
                background-color: rgba(0, 0, 0, 0.7);
                display: block;
                width: 100%;
                height: 100%;
                cursor: pointer;
                -webkit-transition: all 0.2s;
                -moz-transition: all 0.2s;
                transition: all 0.2s;
            }

        </style>
        <!-- Nav pills -->
        <div class="row">
            <div class="col-md-12">
                <hr>
                <ul class="nav nav-pills">
                    <li class="nav-item">
                        <a onclick="toggleImg()" class="nav-link active" data-toggle="pill" href="#exampleModal2">عکس ها</a>
                    </li>
                    <li class="nav-item">
                        <a onclick="toggleBio()" class="nav-link" data-toggle="pill" href="#menu1">درباره</a>
                    </li>
                </ul>
                <hr>
            </div>
        </div>

        <div id="images" class="">
            @foreach($photos as $photo)
                <a href="{{ url($photo->user->user_name.'/photo/'.$photo->p_hash) }}" id="{{ $photo->id }}">
                    <img commentCount="{{ count($photo->comments) }}" count="{{ $photo->rate }}" id="{{ $photo->id }}" alt="caption for image 1" src="{{ url($photo->sources) }}"/>
                </a>
            @endforeach
        </div>
        <div id="bio" class="" style="display: none">
            <div class="col-sm-6" style="margin: 0 auto">
                <section>
                    <h5 style="color :blue;">بیوگرافی</h5>
                    <p>
                        {{$user->portfolio}}
                    </p>
                </section>
                <section>
                    <h5 style="color :blue;">اطلاعات شخصی</h5>
                    <p>
                        <span>تاریخ تولد:</span>
                        {{$user->birthday}}
                    </p>
                    <p>
                        <span>محل تولد:</span>
                        {{$user->state}}/{{$user->city}}
                    </p>
                    <p>
                        <span>جنسیت:</span>
                        {{$user->gender}}
                    </p>
                </section>
                <section>
                    <h5 style="color :blue;">شبکه های اجتماعی</h5>
                    <p>
                        <a href="{{$user->instagram}}">اینستاگرام</a>
                    </p>
                    <p>
                        <a href="{{$user->facebook}}">فیسبوک</a>
                    </p>
                    <p>
                        <a href="{{$user->twitter}}">توییتر</a>
                    </p>
                </section>
                <section>
                    <h5 style="color :blue;">وضعیت</h5>
                    <p>
                        <span>تعداد کامنت ها:</span>
                        {{$totalComment}}
                    </p>
                </section>

            </div>
        </div>
    </div>

    <style>
        @media (max-width: 768px){
            .profile_header .profile_buttons {
                position: relative;
                overflow: hidden;
                padding: 58px 0 0 0;
                margin-bottom: 30px;
                text-align: center;
            }
        }
    </style>
@endsection
<!-- Grid row -->
@section('js')
    <script>
        $(document).ready(function () {

        });
        function toggleImg() {
            $('#bio').css('display','none');
            $('#images').css('display','block');

        }
        function toggleBio() {
            $('#images').css('display','none');
            $('#bio').css('display','block');

        }
        $('.cap'+19+' #count').text('data');
        function rate(event,id,val){
            event.preventDefault();
            $.ajax({
                type: 'POST',
                url: '{{ route('rate.add') }}',
                data: {'_token': '<?php echo csrf_token()?>', 'id': id, 'val':val},
                success: function (data) {
                    $('.cap'+id+' #count').text(data);
                    if( val == 0){
                        $('.cap'+id+' #like i').removeAttr('hidden');
                        $('.cap'+id+' #like').removeAttr('hidden');
                        $('.cap'+id+' #dis_like i').attr('hidden', 'hidden');
                        $('.cap'+id+' #dis_like').attr('hidden','hidden');
                    }else{
                        $('.cap'+id+' #dis_like i').removeAttr('hidden');
                        $('.cap'+id+' #dis_like').removeAttr('hidden');
                        $('.cap'+id+' #like i').attr('hidden', 'hidden');
                        $('.cap'+id+' #like').attr('hidden','hidden');
                    }
                }
            })
        }
        $('#gal1').galereya();
        $("#images").justifiedGallery({
            'rowHeight': 230,
            'rowWidth': 500,
            'maxRowHeight': 230,
            /*'sizeRangeSuffixes':{'lt100':'_t',
                'lt240':'_m',
                'lt320':'_n',
                'lt500':'',
                'lt640':'_z',
                'lt1024':'_b'}*/
            'lastRow': 'nojustify',
            'captions': true,
            'margins': 3,
            // 'waitThumbnailsLoad': false,
            'randomize': true,
            // 'filter': false,
            'rtl': true,
            'refreshTime': 100,
            // 'target': '_blank',
            'cssAnimation': true,
            'captionSettings': { animationDuration: 800,
                visibleOpacity: 0.7,
                nonVisibleOpacity: 0.0 }


        });
        // $('#basicExample2').justifiedGallery({
        //     rowHeight : 70,
        //     lastRow : 'nojustify',
        //     margins : 3
        // });
    </script>
@endsection


