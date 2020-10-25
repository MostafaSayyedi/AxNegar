@extends('admin.layout.master')
@section('content')
    <style>
        .request {
            border: 1px solid;
            padding: 10px;
            margin-bottom: 25px;
            background: #ececec9e;
        }

        .request-admin {
            border: 1px solid;
            padding: 10px;
            margin-bottom: 25px;
            background: #c3e4e69e;
        }

        .request-head {
            display: block;
            padding: 10px;
            background: #e6e6e6;
        }

        .request-admin-head {
            display: block;
            padding: 10px;
            background: #b4d9df;
        }
    </style>
    <section class="content">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title pull-right">پاسخ تیکت {{ $ticket->rnd_code }} </h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table no-margin">
                        <thead>
                        <tr>
                            {{--                            <th class="text-center">تصویر</th>--}}
                            <th class="text-center">عنوان</th>
                            <th class="text-center">کد</th>
                            <th class="text-center">اولویت</th>
                            <th class="text-center">کاربر</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            {{--                                <td class="text-center"><img width="25%" src="{{$ticket->file}}"> </td>--}}
                            <td class="text-center">{{$ticket->title}}</td>
                            <td class="text-center">{{$ticket->rnd_code}}</td>
                            <td class="text-center">{{$ticket->advantage}}</td>
                            {{--                                <td class="text-center"><a target="_blank" href="{{route('admin.user.list', ['id'=>$ticket->user->id])}}">{{$ticket->user->name}}</a></td>--}}
                            <td class="text-center">{{$ticket->user->name}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <br>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="privacy-inner-content"><!-- privacy inner conent -->
                            <div class="request single-text-block"><!-- single text block -->
                                <h4 class="title">{{ $ticket->title }}</h4>
                                <p>
                                    {{ $ticket->message }}
                                </p>
                                <span>
                                                    <a href="{{ $ticket->image }}">فایل</a>


                                                </span>
                            </div><!-- //. single text block -->
                            <span class="line-separator"></span>
                        </div><!-- //. privacy inner content -->
                    </div>
                    <div class="col-lg-3">
                        {{--                                                <a href="">file</a>--}}
                    </div>
                </div>
                <hr>
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
                        @if($child->image !== 'https://axnegar.com/avatar/')
                            <span><a href="{{ $child->image }}">فایل</a></span>
                        @endif
                    </div>

                @endforeach
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="content">
                            <form class="form-horizontal" method="post" enctype="multipart/form-data"
                                  action="{{ route('admin.tickets.sendResponse') }}">
                                @csrf
                                <input type="hidden" name="general" value="general">
                                <input type="hidden" name="child_id" value="{{$ticket->id}}">
                                <fieldset id="account">
                                    <legend>جواب درخواست</legend>
                                    <div class="form-group ">
                                        <label for="input-message" class="col-sm-2 control-label">جواب تیکت </label>
                                        <div class="col-sm-10">
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
                                    <div class="form-group ">
                                        <label for="input-file"
                                               class="col-sm-2 control-label">فایل پیوست</label>
                                        <div class="col-sm-10">
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
                                    </div>
                                </fieldset>
                                <div class="buttons">
                                    <div class="pull-right">
                                        <input type="submit"
                                               class="btn btn-primary"
                                               value="ارسال">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>

@endsection

@section('script-vuejs')
    <script src="{{asset('admin/js/app.js')}}"></script>
@endsection
