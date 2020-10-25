@extends('user.layout.master')
@section('content')
    <section class="content">
        <!-- invoice page content area start -->
        <div class="invoice-page-content-area">
            <div class="">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="invoice-inner"><!-- invoice inner -->
                            <div class="bottom-content">
                                <div class="body-content">
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
                                                <span class="label label-default"> {{ $ticket->status }}</span>
                                            </td>
                                        </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div><!-- //. invoice inner  -->
                    </div>
                </div>
            </div>
        </div>
        <!-- invoice page content area end -->
    </section>

@endsection

@section('script-vuejs')
    <script src="{{asset('admin/js/app.js')}}"></script>
@endsection
