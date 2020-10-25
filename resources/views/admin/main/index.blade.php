@extends('admin.layout.master')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            داشبورد
            <small>کنترل پنل</small>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">

            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3>{{$users}}</h3>

                        <p>کاربران ثبت شده</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="#" class="small-box-footer"><i class="fa fa-arrow-circle-left"></i> اطلاعات بیشتر </a>
                </div>
            </div>
            <!-- ./col -->

        </div>
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
            <!-- Left col -->

            <!-- right col -->
        </div>
        <!-- /.row (main row) -->

    </section>
    <!-- /.content -->
@endsection

@section('scripts')
    <script src="/admin/plugins/morris/morris.min.js"></script>
    <!-- Sparkline -->
    <script src="/admin/plugins/sparkline/jquery.sparkline.min.js"></script>
    <!-- jvectormap -->
    <script src="/admin/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="/admin/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="/admin/plugins/knob/jquery.knob.js"></script>
    <!-- daterangepicker -->
    <script src="/admin/plugins/daterangepicker/daterangepicker.js"></script>
    <!-- datepicker -->
    <script src="/admin/plugins/datepicker/bootstrap-datepicker.js"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
    <!-- Slimscroll -->
    <script src="/admin/plugins/slimScroll/jquery.slimscroll.min.js"></script>

@endsection
