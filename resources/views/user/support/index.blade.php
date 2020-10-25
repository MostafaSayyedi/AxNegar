@extends('user.layout.master')
@section('pageTitle', 'صفحه پشتیبانی')
@section('body')

    <div class="container" style="margin-top:10px;">
        <div class="row">
            <div class="col-xs-12 col-md-2 ">
                <div class="list-group"  style="margin-bottom: 10px;">
                    <a href="{{ route('user.showInfo') }}" class="list-group-item list-group-item-action ">اطلاعات
                        من</a>
                    <a href="{{ route('user.showSecurity') }}" class="list-group-item list-group-item-action">امنیت</a>
                    <a href="{{ route('user.ticket') }}" class="list-group-item list-group-item-action active">تیکتها</a>
                </div>
            </div>
            <div class="col-xs-12 col-md-10 ">
                <a href="{{ route('user.ticket.create') }}" class="list-group-item btn btn-success list-group-item-action active">ثبت تیکت</a>
                <div id="info" style="overflow: auto">
                    <table class="table table-default">
                        <thead>
                        <tr style="background-color: #444;color: #fff;">
                            <th>شماره تیکت	</th>
                            <th>عنوان</th>
                            <th>دپارتمان</th>
                            <th>اولویت</th>
                            <th>وضعیت</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($tickets as $ticket)
                            <tr>
                                <td>
                                    <a target="_blank" href="{{ route('user.ticket.show',['id'=>$ticket->id]) }}">{{ $ticket->rnd_code }}#</a>
                                </td>
                                <td>
                                    <a target="_blank" href="{{ route('user.ticket.show',['id'=>$ticket->id]) }}">{{ $ticket->title }}</a>
                                </td>
                                <td>
                                    {{ $ticket->role->name }}
                                </td>
                                <td>
                                    <span class="label label-default"> {{ $ticket->advantage }}</span>
                                </td>
                                <td>
                                    <span style="color: #1e7e34" class="label label-default"> {{ $ticket->status }}</span>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>


@endsection

@section('script-vuejs')
    <script src="{{asset('admin/js/app.js')}}"></script>
@endsection
