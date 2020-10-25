@extends('admin.layout.master')
@section('content')
    <section class="content">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title pull-right">ایجاد صفحه در باره ما</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <form id="myForm" method="post" action="{{ route('admin.aboutus.store') }}">
                            @csrf
                            <div class="form-group ">
                                <label for="input-message" class="col-sm-2 control-label">توضیحات </label>
                                            <textarea
                                                class="form-control @error('description') is-invalid @enderror"
                                                id="input-message"
                                                placeholder=""
                                                name="description" autocomplete="on">{{ $about->description }}</textarea>

                                    @if($errors->has('description'))
                                        <span class="help-block" style="color: red">
                                <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                    @endif
                            </div>
                            <button type="submit" class="btn btn-success pull-left">ذخیره</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection
