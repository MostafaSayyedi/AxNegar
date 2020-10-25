@extends('front.layout')
@section('pageTitle', 'صفحه درباره ما')
@section('body')
    <div class="container" style="margin-top: 50px;">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('ثبت نام') }}</div>
                    <div class="card-body">
<p>{{ $about->description }}</p>
            </div>
        </div>
    </div>
@endsection
