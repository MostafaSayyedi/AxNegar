@extends('user.layout.master')
@section('pageTitle', 'صفحه پشتیبانی')
@section('body')
    <style>
        .request{
            border: 1px solid;
            padding: 10px;
            margin-bottom: 25px;
            background: #ececec9e;
        }
        .request-admin{
            border: 1px solid;
            padding: 10px;
            margin-bottom: 25px;
            background: #c3e4e69e;
        }
        .request-head{
            display: block;
            padding: 10px;
            background: #e6e6e6;
        }
        .request-admin-head{
            display: block;
            padding: 10px;
            background: #b4d9df;
        }
    </style>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md-2 ">
                <div class="list-group">
                    <a href="{{ route('user.showInfo') }}" class="list-group-item list-group-item-action ">اطلاعات
                        من</a>
                    <a href="{{ route('user.showSecurity') }}" class="list-group-item list-group-item-action">امنیت</a>
                    <a href="{{ route('user.ticket') }}" class="list-group-item list-group-item-action active">تیکتها</a>
                </div>
            </div>
            <div class="col-xs-12 col-md-10 ">
                <a href="{{ route('user.ticket.create') }}" class="list-group-item btn btn-success list-group-item-action active">ثبت
                    تیکت</a>
                <div id="info">
                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <section class="">
                                <div class="box box-success">
                                    <div class="box-header">
                                        <h5 class="box-title"> تیکت پشتیبانی #{{ $ticket->rnd_code }}</h5>
                                        <i class="fa fa-comments-o"></i>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="privacy-inner-content"><!-- privacy inner conent -->
                                            <div class="request single-text-block"><!-- single text block -->
                                                <h4 class="title">{{ $ticket->title }}</h4>
                                                <p>
                                                    {{ $ticket->message }}
                                                </p>
                                                    @if( $ticket->image !== 'https://axnegar.com/avatar/')
                             <a href="{{ $ticket->image }}">فایل</a>
                        @endif
                                             
                                            </div><!-- //. single text block -->
                                            <span class="line-separator"></span>
                                        </div><!-- //. privacy inner content -->
                                    </div>
                                    <div class="col-lg-3">
                                        {{--                                                <a href="">file</a>--}}
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="box box-info" style="padding-right:50px;">
                                            <div class="box-header">
                                                <h3 class="box-title">متن پاسخ</h3>
                                                <i class="fa fa-envelope"></i>
                                            </div>
                                            <div class="box-body">
                                                <div>
                                                    @foreach($ticket->childs as $child)
                                                        <div class="@if ($child->user->isUser())
                                                        request
                                                        @else
                                                            request-admin

@endif">
                                                            <span class="@if ($child->user->isUser())
                                                            request-head
 @else
request-admin-head
@endif">
                                                                {{ $child->user->name }}
                                                            </span>
                                                            <p>
                                                                {{ $child->message }}
                                                            </p>
                                                              <!-- @if( $child->image !== 'https://axnegar.com/avatar/') -->
                             <a href="{{ $child->image }}">فایل</a>
                        <!-- @endif -->
                                                        </div>
                                                    @if($loop->last)
                                                        <div class="col-xs-12 col-md-12 ">
                                                            <div id="info">
                                                                <form action="{{ route('user.ticket.sendResponse') }}" method="POST"  enctype="multipart/form-data">
                                                                    @csrf
                                                                    <div class="row">

                                                                        <input type="hidden" name="general" value="general">
                                                                        <input type="hidden" name="role" value="{{$child->role_id}}">
                                                                        <input type="hidden" name="child_id" value="{{$ticket->id}}">
                                                                        <input type="hidden" name="title" value="{{$ticket->title}}">
                                                                        <div class="col-sm-12 col-md-6">
                                                                            <div class="input-group mb-3">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text" id="inputGroup-sizing-default">متن جواب</span>
                                                                                </div>
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

                                                                        </div>
                                                                        <div class="col-sm-12 col-md-6">
                                                                              <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-default">فایل</span>
                                    </div>
                                    <div
                                        class="form-element margin-bottom-20 @error('file') is-invalid @enderror">
                                        <input type="file" id="file" name="file"
                                               class="dropify">
                                        @if($errors->has('file'))
                                            <span class="help-block" style="color: red">
                                <strong>{{ $errors->first('file') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>
                                                                            <div class="input-group mb-3">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text" id="inputGroup-sizing-default">اولویت</span>
                                                                                </div>
                                                                                <select class="form-control @error('advantage') is-invalid @enderror"
                                                                                        name="advantage">
                                                                                    <option <?php if (old('advantage') == 0) {
                                                                                        echo 'selected';
                                                                                    } else {
                                                                                        echo '';
                                                                                    } ?> value="0">
                                                                                        فوری
                                                                                    </option>
                                                                                    <option <?php if (old('advantage') == 1) {
                                                                                        echo 'selected';
                                                                                    } else {
                                                                                        echo '';
                                                                                    } ?> value="1">
                                                                                        مهم
                                                                                    </option>
                                                                                    <option <?php if (old('advantage') == 2) {
                                                                                        echo 'selected';
                                                                                    } else {
                                                                                        echo '';
                                                                                    } ?> value="2">
                                                                                        عادی
                                                                                    </option>
                                                                                </select>
                                                                                @if($errors->has('advantage'))
                                                                                    <span class="help-block" style="color: red">
                                
                                <strong>{{ $errors->first('advantage') }}</strong>
                                    </span>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                        <div class="buttons">
                                                                            <div class="pull-right">
                                                                                <input type="submit"
                                                                                       class="btn btn-primary"
                                                                                       value="ارسال">
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('script-vuejs')
    <script src="{{asset('admin/js/app.js')}}"></script>
@endsection
