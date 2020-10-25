@extends('user.layout.master')
@section('pageTitle', 'صفحه کیف پول')

@section('content')
    <section class="content">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title pull-right">ایجاد کیف پول جدید</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <form id="myForm" method="post" action="{{ route('user.wallet.store') }}">
                            @csrf
                            <div class="form-group">
                                <label for="title">نام کیف پول</label>
                                <input type="text" name="title" value="{{ old('title') }}" class="@error('title') is-invalid @enderror form-control" placeholder="نام را وارد کنید...">
                                @if($errors->has('title'))
                                    <span class="help-block" style="color: red">
                                <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="description">توضیحات</label>
                                <textarea class="form-control" name="description" id="" cols="30" rows="10">{{ old('description') }}</textarea>
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
