@extends('user.layout.master')
@section('pageTitle', 'صفحه اطلاعات کاربر')
@section('styles')
    <style>
        body {
            width: 100%;
            margin: 0 auto;
            padding: 0px;
            font-family: helvetica;
            /*background-color:#0B3861;*/
        }

        #wrapper {
            text-align: center;
            margin: 0 auto;
            padding: 0px;
            width: 995px;
        }

        #output_image {
            max-width: 300px;
        }
    </style>
@endsection
@section('body')

    <div class="container" style="margin-top: 10px">
        <div class="row">
            <div class="col-xs-12 col-md-2 ">
                <div class="list-group" style="margin-bottom: 10px;">
                    <a href="{{ route('user.showInfo') }}" class="list-group-item list-group-item-action active">اطلاعات من</a>
                    <a href="{{ route('user.showSecurity') }}" class="list-group-item list-group-item-action">امنیت</a>
                    <a href="{{ route('user.ticket') }}" class="list-group-item list-group-item-action">تیکتها</a>

                </div>
            </div>
            <div class="col-xs-12 col-md-10 ">
                <div id="info">
                    <form action="{{ route('user.saveSetting') }}" method="POST">
                        @csrf
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-default">نام</span>
                                    </div>
                                    <input value="{{ $user->name }}" name="name" type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-default">نام خانوادگی</span>
                                    </div>
                                    <input value="{{ $user->f_name }}" name="family_name" type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-default">تاریخ تولد</span>
                                    </div>
                                    <input value="{{ $user->birthday }}" name="birthday" type="text" class="birthday form-control">
                                </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-default">نام کاربری</span>
                                </div>
                                <input value="{{ $user->user_name }}" name="user_name" type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 ">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">بیوگرافی</span>
                                </div>
                                <textarea  name="portfolio" class="form-control" aria-label="With textarea">{{ $user->portfolio }}</textarea>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">جنسیت</span>
                                </div>
{{--                                <div class="col-sm-12 mt-2">--}}
                                    <label class="mb-0 mr-3">
                                        <input {{$user->gender == 'مرد' ? "checked" : ''}} type="radio" value="1" class="form-control" name="gender"> مرد
                                    </label>
                                    <label class="mb-0 mr-3">
                                        <input {{$user->gender == 'زن' ? 'checked' : ''}} type="radio" value="2" class="form-control" name="gender"> زن
                                    </label>
{{--                                </div>--}}
                            </div>

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-default">شهر</span>
                                </div>
                                <input value="{{$user->city}}" name="city" type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-default">استان</span>
                                </div>
                                <input value="{{$user->state}}" name="state" type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                            </div>
                            <button type="submit" class="btn btn-primary">ثبت</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>

        </div>

    </div>

@endsection

@section('script-vuejs')
    <script src="{{asset('admin/js/app.js')}}"></script>
    <script src="{{asset('admin/js/app.js')}}"></script>
    <script type='text/javascript'>
        function preview_image(event) {
            $('#portImg').css('display', 'none');
            var reader = new FileReader();
            reader.onload = function () {
                var output = document.getElementById('output_image');
                output.src = reader.result;
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
@endsection
