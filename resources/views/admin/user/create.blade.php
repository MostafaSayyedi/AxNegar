@extends('admin.layout.master')

@include('sessions.session')
@section('content')
    <section class="content">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title pull-right">ایجاد فروشگاه</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <form id="myForm" method="post" action="{{ route('admin.shop.store') }}">
                            @csrf
                            <div class="form-group">
                                <label for="name">نام فروشگاه</label>
                                <input @error('name') is-invalid @enderror  type="text" name="name" value="{{ old('name') }}" class="form-control" placeholder="نام فروشگاه را وارد کنید...">
                            @if($errors->has('name'))
                                    <span class="help-block" style="color: red">
                                <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="seller_id">نام صاحب فروشگاه</label>
                                <select id="seller_id" class="form-control @error('seller_id') is-invalid @enderror"
                                        name="seller_id">
                                    @foreach($sellers as $seller)
                                        <option value="{{$seller->id}}" <?php if(old('seller_id') == $seller->id) {echo 'selected';} ?> >{{$seller->user->name}}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('seller_id'))
                                    <span class="help-block" style="color: red">
                                <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="site_address">آدرس سایت</label>
                                <input type="text" @error('site_address') is-invalid @enderror value="{{ old('site_address') }}" name="site_address" class="form-control" placeholder="آدرس سایت را وارد کنید...">
                                @if($errors->has('site_address'))
                                    <span class="help-block" style="color: red">
                                <strong>{{ $errors->first('site_address') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label>وضعیت</label>
                                <div>
                                    <input type="radio" name="status" value="1" <?php if(old('status') == '1') {echo 'checked';} ?>> <span>فعال شود</span>
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
