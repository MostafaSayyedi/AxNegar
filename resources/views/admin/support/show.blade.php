@extends('user.layout.master')
@section('content')
    <!-- privacy page content area start-->
    <section class="content">
        <div class="invoice-page-content-area">
            <section class="">
                <div class="box box-success">
                    <div class="box-header">
                        <h3 class="box-title"> تیکت پشتیبانی #{{ $ticket->rnd_code }}</h3>
                        <i class="fa fa-comments-o"></i>

                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-9">
                        <div class="privacy-inner-content"><!-- privacy inner conent -->
                            <div class="single-text-block"><!-- single text block -->
                                <h4 class="title">{{ $ticket->title }}</h4>
                                <p>
                                    {{ $ticket->message }}
                                </p>
                            </div><!-- //. single text block -->
                            <span class="line-separator"></span>
                        </div><!-- //. privacy inner content -->
                        <div class="box box-info">
                            <div class="box-header">
                                <h3 class="box-title">متن پاسخ</h3>
                                <i class="fa fa-envelope"></i>
                            </div>
                            <div class="box-body">
                                <form method="post" action="{{ route('user.ticket.response',['id'=>$ticket->id]) }}">
                                    @csrf
                                    <div>
                                        <textarea name="message" id="message" class="textarea" placeholder="پیام" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>

                                        @if($errors->has('message'))
                                            <span class="help-block" style="color: red">
                                <strong>{{ $errors->first('message') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                    <div class="box-footer clearfix">
                                        <button type="submit" class="pull-left btn btn-default" id="sendEmail">ارسال
                                            <i class="fa fa-arrow-circle-left"></i></button>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-3">
                        <a href="">file</a>
                    </div>
                </div>
            </section>
        </div>
    </section>
@endsection

@section('script-vuejs')
    <script src="{{asset('admin/js/app.js')}}"></script>
@endsection
