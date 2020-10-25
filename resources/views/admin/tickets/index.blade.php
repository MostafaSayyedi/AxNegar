@extends('admin.layout.master')

@section('content')
    <section class="content">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title pull-right">تیکت ها</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                @include('admin.partials.form-errors')
                <div class="table-responsive">
                    <table class="table no-margin">
                        <thead>
                        <tr>
                            <th class="text-center">ردیف</th>
                            <th class="text-center">کاربر</th>
                            <th class="text-center">شناسه</th>
                            <th class="text-center">عنوان</th>
                            <th class="text-center">اولویت</th>
                            <th class="text-center">وضعیت</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($tickets as $ticket)
                            <tr @if ($ticket->status == 'در حال بررسی')
                                style="background:#d1fdd1"
                            @endif>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-center">{{$ticket->user->name}}</td>
                                <td class="text-center"><span class="label label-warning"><a target="_blank" href="{{route('admin.tickets.response', ['rnd_code'=>$ticket->rnd_code])}}">{{$ticket->rnd_code}}</a></span></td>
                                <td class="text-center">{{$ticket->title}}</td>
                                <td class="text-center">{{$ticket->advantage}}</td>
                                <td style="color: indianred" class="text-center">{{$ticket->status}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>
        </div>
    </section>
@endsection
