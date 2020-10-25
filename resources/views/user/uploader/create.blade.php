@extends('user.layout.master')
@section('pageTitle', 'صفحه بارگذاری')
@section('styles')
    <style>

        {{--   upload for multiple photo--}}
        #formdiv {
            text-align: center;
        }
        #file {
            color: green;
            padding: 5px;
            border: 1px dashed #123456;
            background-color: #f9ffe5;
        }
        #img {
            width: 17px;
            border: none;
            height: 17px;
            margin-left: -20px;
            margin-bottom: 191px;
        }
        .upload {
            width: 100%;
            height: 30px;
        }
        .previewBox {
            text-align: center;
            position: relative;
            width: 150px;
            height: 150px;
            margin-right: 10px;
            margin-bottom: 20px;
            float: left;
        }
        .previewBox img {
            height: 150px;
            width: 150px;
            padding: 5px;
            border: 1px solid rgb(232, 222, 189);
        }
        .delete {
            color: red;
            font-weight: bold;
            position: absolute;
            top: 0;
            cursor: pointer;
            width: 20px;
            height:  20px;
            border-radius: 50%;
            background: #ccc;
        }
    </style>
@endsection

@section('body')
    <section class="container">
        <div class="row">
            <div class="col-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title pull-right">آپلود تصاویر </h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="">
                            <div class="">
                                <div class="best-seller-home-6-area-small cart-page">
                                    <div class="">
                                       <form action="{{ route('upload.store') }}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <div style="margin-bottom: 10px;overflow: hidden" class="">
                                                <div class="row">
                                                        <div class="col-xs-12 col-md-5 imgUp">
                                                            <input name="title" id="title" class="form-control" type="text" placeholder="عنوان" value="{{old('name')}}">
                                                            <div class="form-group">
                                                                <select required class="form-control" id="category" name="category">
                                                                    <option selected disabled>دسته بندی</option>
                                                                    @foreach($categories as $category)
                                                                    <option value="{{ $category->id }}">{{ $category->title }}</option>
                                                                        @endforeach
                                                                </select>
                                                            </div>

                                                            <div class="imagePreview" id="imagePreview"></div>
                                                            <label class="btn btn-primary">
                                                                بارگزاری عکس<input id="images" name="images[]" type="file" class="uploadFile img " value="Upload Photo" style="width: 0px;height: 0px;overflow: hidden;">
                                                            </label>
                                                            <label style="margin-right: 5px;color: white;">
                                                                <input class="btn btn-primary" style="color: white;" type="submit"  name='submit_image' value="آپلود"/>
                                                            </label>
                                                        </div>
                                                    <div class="col-xs-12 col-md-7">
                                                        <ul class="list-group list-group-flush" id="exif" hidden>
                                                            <li class="list-group-item">
                                                                <label>نام</label>
                                                                <input type="text" value="{{ $user->name }}" />
                                                            </li>
                                                            <li class="list-group-item">
                                                                <label>نام خانوادگی</label>
                                                                <input type="text" value="{{ $user->f_name }}" />
                                                            </li>
                                                            <li class="list-group-item">
                                                                <label>مدل دوربین</label>
                                                                <input type="text" name="cameraModel" id="cameraModel" />
                                                            </li>
                                                            <li class="list-group-item">
                                                                <label>سازنده دوربین</label>
                                                                <input type="text" name="cameraMake" id="cameraMake" />
                                                            </li>
                                                            <li class="list-group-item">
                                                                <label>زمان</label>
                                                                <input type="text" name="DateTime" id="DateTime" />
                                                            </li>
                                                            <li class="list-group-item">
                                                                <label>موقعیت</label>
                                                                <input type="text" name="Location" id="Location" />
                                                            </li>
                                                            <li class="list-group-item">
                                                                <label> دوربین ISO/Pelicula</label>
                                                                <input type="text" name="iso" id="ISO" />
                                                            </li>
                                                            <li class="list-group-item">
                                                                <label>فلش دوربین</label>
                                                                <input type="text" name="flash" id="flash" />
                                                            </li>
                                                            <li class="list-group-item">
                                                                <label>فاصله کانونی</label>
                                                                <input type="text" name="focalDistance" id="focalDistance" />
                                                            </li>

                                                        </ul>
                                                    </div>
                                                    <style>
                                                        form input {
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
                                                        form label {
                                                            color: #000;
                                                            display: inline-block;
                                                            padding: 5px 0;
                                                            width: 120px;
                                                        }
                                                    </style>
                                                    <!-- col-2 -->
{{--                                                    <i class="fa fa-plus imgAdd"></i>--}}
                                                </div>
{{--                                                <input name="title" id="title" class="form-control" type="text" placeholder="عنوان">--}}
{{--                                            <input required id="images" name="images[]" type="file" class="file" --}}
{{--                                            data-show-upload="false" data-show-caption="true" data-msg-placeholder="انتخاب فایل ها">--}}
                                            </div>
<style>
    .imagePreview {
        width: 100%;
        height: 500px;
        background-position: center center;
        background:url(http://cliquecities.com/assets/no-image-e3699ae23f866f6cbdf8ba2443ee5c4e.jpg);
        background-color:#fff;
        background-size: cover;
        background-repeat:no-repeat;
        display: inline-block;
        box-shadow:0px -3px 6px 2px rgba(0,0,0,0.2);
    }
    .btn-primary
    {
        display:inline;
        border-radius:0px;
        box-shadow:0px 4px 6px 2px rgba(0,0,0,0.2);
        /*margin-top:-5px;*/
    }
    .imgUp
    {
        margin-bottom:15px;
    }
    .del
    {
        position:absolute;
        top:0px;
        right:15px;
        width:30px;
        height:30px;
        text-align:center;
        line-height:30px;
        background-color:rgba(255,255,255,0.6);
        cursor:pointer;
    }
    .imgAdd
    {
        width:30px;
        height:30px;
        border-radius:50%;
        background-color:#4bd7ef;
        color:#fff;
        box-shadow:0px 0px 2px 1px rgba(0,0,0,0.2);
        text-align:center;
        line-height:30px;
        margin-top:0px;
        cursor:pointer;
        font-size:15px;
    }
</style>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </section>
    {{--   upload for multiple photo--}}
    <div class="row" id="image_preview"></div>
@endsection

@section('script-vuejs')
{{--    <script src="https://unpkg.com/file-upload-with-preview@4.0.2/dist/file-upload-with-preview.min.js"></script>--}}
    <script >
        $(document).ready(function () {

            // initialize with defaults
            $("#input-id").fileinput();

// with plugin options
            $("#input-id").fileinput({'showUpload':false, 'previewFileType':'any'});
            $("#input-b8").fileinput({
                rtl: true,
                dropZoneEnabled: false,
                allowedFileExtensions: ["jpg", "png", "gif"]
            });
        });
        var upload = new FileUploadWithPreview('myUniqueUploadId');

    </script>
    <script src="{{asset('admin/js/app.js')}}"></script>
@endsection
