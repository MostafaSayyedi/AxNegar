@extends('user.layout.master')


@section('content')
    <section class="content">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title pull-right">ایجاد لینک شبکه اجتماعی</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <form id="myForm" method="post" action="{{ route('user.social.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="name">نام</label>
                                <input type="text" name="name" value="{{ old('name') }}" class="form-control"
                                       placeholder="نام را وارد کنید...">
                                @if($errors->has('name'))
                                    <span class="help-block" style="color: red">
                                <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="src">لینک</label>
                                <input type="text" name="src" value="{{ old('src') }}" class="form-control"
                                       placeholder="لینک را وارد کنید...">
                                @if($errors->has('src'))
                                    <span class="help-block" style="color: red">
                                <strong>{{ $errors->first('src') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group row">
                                <label for="photo" class="col-md-4 col-form-label text-md-right">تصویر </label>
                                <div class="col-md-6">
                                    <input style="margin-bottom: 10px" id="photo" type="file" class="form-control"
                                           name="photo" accept="image/*" onchange="preview_image(event)">
                                    @if($errors->has('photo'))
                                        <span class="help-block" style="color: red">
                                <strong>{{ $errors->first('photo') }}</strong>
                                    </span>
                                    @endif
                                    <img width="75" id="output_image"/>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success pull-left">ذخیره</button>
                        </form>
                    </div>
                </div>

            </div>
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
