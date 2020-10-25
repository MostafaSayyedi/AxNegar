@extends('front.layout')
@section('pageTitle', 'صفحه کپی رایت')
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
    <section class="container" ئ>
        <div class="row">
            <div class="col-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title pull-right">پیگیری حق نشر </h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-8 col-md-offset-2">
                                <div class="best-seller-home-6-area-small cart-page">
                                    <div class="container">
                                        <form action="{{ route('user.copyright.search') }}" method="post">
                                            @csrf
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon3">copy right</span>
                                                        </div>
                                                        <input placeholder="هش مورد نظر را وارد کنید" type="text" value="{{ old('title') }}" name="hash" class="@error('title') is-invalid @enderror form-control" id="basic-url" aria-describedby="basic-addon3">
                                                        <button class="btn btn-outline-secondary" type="submit">جستجو</button>
                                                    </div>
                                                    @if($errors->has('hash'))
                                                        <span class="help-block" style="color: red">
                                <strong>{{ $errors->first('hash') }}</strong>
                                    </span>
                                                    @endif
                                                </div>
                                                <div style="clear: both"></div>
                                            </div>
                                        </form>
                                    </div>
                                </div>


                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
<div class="row">
    <style>
        #exif input {
            background: transparent;
            border: 0px solid #EEE;
            color: #08F;
            display: inline-table;
            margin: 5px auto;
            padding-left: 80px;
            outline-width: 0;
            outline-color: #08F;
            *width: calc(50% - 22px);
        }
    </style>
    @if($exifs ?? '')
        <div class="col-xs-12 col-md-6">
            <ul class="list-group list-group-flush" style="position: relative;z-index: -2;" id="exif">
                <li class="list-group-item">
                    <label>نام</label>
                    <input type="text"
                           value="{{ isset($exifs->info->firstName) ? $exifs->info->firstName : '_'}}"/>
                </li>
                <li class="list-group-item">
                    <label>نام خانوادگی</label>
                    <input type="text"
                           value="{{ isset($exifs->info->lastName) ? $exifs->info->lastName : '' }}"/>
                </li>
                <li class="list-group-item">
                    <label>موقعیت</label>
                    <?php
                    if (isset($exifs->GPS->GPSLatitude['2'])) {
                        $lat = explode('/', $exifs->GPS->GPSLatitude['2']);
                        $lat = $lat[0] / $lat[1];
                        $long = explode('/', $exifs->GPS->GPSLongitude['2']);
                        $long = $long[0] / $long[1];
                    }
                    ?>
                    <input type="text"
                           value="{{ isset($exifs->GPS->GPSLatitude['2']) ? $lat.'/'.$long : '' }}"/>
                </li>
                <li class="list-group-item">
                    <label>مدل دوربین</label>
                    <input type="text" value="{{isset($exifs->IFD0->Model) ? $exifs->IFD0->Model : '_'}}"
                           name="cameraModel" id="cameraModel"/>
                </li>
                <li class="list-group-item">
                    <label>سازنده دوربین</label>
                    <input type="text" value="{{isset($exifs->IFD0->Make) ? $exifs->IFD0->Make : '_'}}"
                           name="cameraMake" id="cameraMake"/>
                </li>
                <li class="list-group-item">
                    <label>زمان</label>
                    <input type="text"
                           value="{{isset($exifs->IFD0->DateTime) ? $exifs->IFD0->DateTime : '_'}}"
                           name="DateTime" id="DateTime"/>
                </li>
                <li class="list-group-item">
                    <label>ISO/Pelicula دوربین</label>
                    <input type="text"
                           value="{{isset($exifs->EXIF->ISOSpeedRatings) ? $exifs->EXIF->ISOSpeedRatings : '_'}}"
                           name="iso" id="ISO"/>
                </li>

            </ul>
        </div>

        <div class="col-xs-12 col-md-6">
            <img style="z-index:-2;position:relative;width: 100%;height: 100%" src="{{url($pic)}}" alt="">
        </div>
    @endif
</div>
    </section>

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
