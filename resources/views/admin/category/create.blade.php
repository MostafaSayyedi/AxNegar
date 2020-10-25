@extends('admin.layout.master')
@section('content')
    <section class="content">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title pull-right">ایجاد دسته بندی</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <form id="myForm" method="post" action="{{ route('admin.category.store') }}">
                            @csrf
                            <div class="form-group">
                                <label for="title">نام دسته بندی</label>
                                <input required @error('title') is-invalid @enderror  type="text" name="title" value="{{ old('title') }}" class="form-control" placeholder="نام دسته بندی را وارد کنید...">
                            @if($errors->has('title'))
                                    <span class="help-block" style="color: red">
                                <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group ">
                                <label for="input-message" class="col-sm-2 control-label">توضیحات </label>
                                            <textarea
                                                class="form-control @error('message') is-invalid @enderror"
                                                id="input-message"
                                                placeholder=""
                                                name="message" autocomplete="on">{{ old('message') }}</textarea>

                                    @if($errors->has('message'))
                                        <span class="help-block" style="color: red">
                                <strong>{{ $errors->first('message') }}</strong>
                                    </span>
                                    @endif
                            </div>
                            <div class="form-group">
                                <label>وضعیت</label>
                                <div>
                                    <input type="radio" checked name="status" value="1" <?php if(old('status') == '1') {echo 'checked';} ?>> <span>فعال شود</span>
                                    <input type="radio" name="status" value="0" <?php if(old('status') == '0') {echo 'checked';} ?> <span class="margin-l-10">فعال نشود</span>
                                    @if($errors->has('status'))
                                        <span class="help-block" style="color: red">
                                <strong>{{ $errors->first('status') }}</strong>
                                    </span>
                                    @endif
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
