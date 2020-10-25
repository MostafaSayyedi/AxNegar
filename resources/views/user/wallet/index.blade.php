@extends('user.layout.master')
@section('pageTitle', 'صفحه کیف پول')
@section('content')
    @foreach($wallets as $wallet)
    <section class="col-lg-12 connectedSortable">
        <!-- Calendar -->
        <div class="box box-solid bg-green-gradient">
            <div class="box-header">
                <h3 class="box-title"> آخرین تراکنش کیف پول {{$wallet->title}}</h3>
                <!-- tools box -->
                <div class="pull-right box-tools">
                    <!-- button with a dropdown -->
                    <button type="button" class="btn btn-success btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
                <!-- /. tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding" style="display: block;">
                <!--The calendar -->
                <div id="calendar" style="width: 100%"></div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer text-black" style="display: block;">
                <div class="row">

                        <div class="card-body">
                            <table class="table table-responsive seller-dashboard-table">
                                <thead>
                                <tr>
                                    <th>ردیف</th>
                                    <th>تاریخ</th>
                                    <th>عملیات</th>
                                    <th>توضیحات</th>
                                    <th>وضعیت</th>
                                    <th>مبلغ</th>
                                    <th>مجموع</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $total = 0;
                                ?>
                                @foreach($wallet->childrens as $child)
                                    <?php
                                    $total = $total + $child->price;
                                    ?>
                                <tr>
                                    <td>{{ $loop->iteration}}</td>
                                    <td>{{ $child->created_at }}</td>
                                    <td>شارژ</td>
                                    <td>{{ $wallet->description }}</td>
                                    <td>{{ $child->status }}</td>
                                    <td>{{ $child->price }} ریال</td>
                                    <td>{{ $total }} ریال</td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                </div>
                <!-- /.row -->
            </div>
        </div>
        <!-- /.box -->
    </section>
    @endforeach

@endsection
