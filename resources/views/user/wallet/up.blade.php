@extends('user.layout.master')

@section('pageTitle', 'صفحه کیف پول')
@section('content')
    <section class="content">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title pull-right">شارژ کیف پول</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <form id="myForm" method="post" action="{{ route('user.wallet.charge-it') }}">
                            @csrf
                            <div class="form-group">
                                <label for="title">نام کیف پول</label>
                                <select class="form-control" id="title" name="title">
                                    @foreach($wallets as $wallet)
{{--                                        <input type="hidden" name="parent_id" value="{{ $wallet->id }}">--}}
                                    <option value="{{ $wallet->id }}">{{ $wallet->title }}</option>
                                        @endforeach
                                </select>
                                @error('title')
                                <span class="invalid-feedback"
                                      role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>قیمت</label>
                                <input type="text" name="price" value="{{ old('price') }}" class="form-control"
                                       placeholder=" قیمت را به ریال وارد کنید...">
                                @error('price')
                                <span class="invalid-feedback"
                                      role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                {{--            <div class="form-group">
                                <label>قیمت</label>
                                <input type="number" name="price" value="{{ old('price') }}" class="form-control" placeholder=" قیمت را وارد کنید...">
                                @error('price')
                                <span class="invalid-feedback"
                                      role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>--}}

                            <button type="submit" class="btn btn-success pull-left">ذخیره</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection
