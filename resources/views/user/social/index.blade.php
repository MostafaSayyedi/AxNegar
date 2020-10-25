@extends('user.layout.master')
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
@section('content')
    <section class="content">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title pull-right">شبکه های اجتماعی </h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="best-seller-home-6-area-small cart-page">
                            <div class="container">
                                <div class="row">
                                    <div class="col-lg-7">
                                        <div class="best-seller-home-6-filter-menu-small">
                                            <!-- best seller home 6 filter menu small -->
                                            <a target="_blank" href="{{ route('user.social.add') }}">
                                                <span class="glyphicon glyphicon-plus-sign"></span>
                                            </a>
                                            @foreach($socials as $social)
                                                <div style="display:inline-block;width: 75px;">
                                                    <a target="_blank" href="{{ $social->src }}">
                                                <span style="width: 75px;height: 75px;border-radius: 50%">
                                                <img style="width: 75px;height: 75px;border-radius: 50%"
                                                     src="{{ $social->icon }}" alt="{{ $social->name }}">
                                                </span>
                                                    </a>
                                                    <form method="post"
                                                          action="{{ route('user.social.delete',[$social->id]) }}">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="submit" style="margin: 2px 12px;"
                                                                class="btn btn-danger">حذف
                                                        </button>
                                                    </form>
                                                </div>

                                            @endforeach
                                        </div><!-- //.best seller home 6 filter menu -->
                                    </div>
                                    <div style="clear: both"></div>
                                </div>
                            </div>
                        </div>
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
