@extends('front.layout')
@section('pageTitle', 'صفحه اصلی')
@section('body')

<header>
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
{{--            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>--}}
{{--            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>--}}
{{--            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>--}}
        </ol>
        <div class="carousel-inner" role="listbox">
@foreach($images as $image)
            <!-- Slide Two - Set the background image for this slide in the line below -->

                {{--<div class="carousel-item @if($loop->first) active @endif" style="background: url('{{ url($image->slider_sources) }}'); background-repeat: no-repeat;
                    background-size: 100% 100%; ">--}}
            <div class="carousel-item @if($loop->first) active @endif" style="background-image: url('{{ url($image->slider_sources) }}') ">
                <div class="carousel-caption d-none d-md-block">
                    <h2 class="display-4">{{ $image->title }}</h2>
{{--                    <p class="lead">This is a description for the second slide.</p>--}}
                </div>
            </div>
            @endforeach
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
</header>
@endsection
