@extends('admin.layout.master')

@section('content')
    <section class="content">
        <div class="box box-info">
            <div class="box-header">

                <h3 class="box-title">گزارش</h3>

            </div>

            <div class="box-body">
                <form id="search-form" action="{{route('admin.search.index')}}" method="get">
                    <div class="form-group">
                        <div class="col-xs-2">
                            <label for="category_id">دسته بندی</label>
                            <select class="form-control" name="category_id" id="category_id">
                                <option value="">انتخاب کنید</option>
                                @foreach($categories as $category)
                                    <option @if(isset($_GET['category_id']) && $_GET['category_id'] == $category->id) selected @endif value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-2">
                            <label for="store_id">فروشگاه</label>
                            <select class="form-control" name="store_id" id="store_id">
                                <option value="">انتخاب کنید</option>
                                @foreach($stores as $store)
                                    <option @if(isset($_GET['store_id']) && $_GET['store_id'] == $store->id) selected @endif value="{{$store->id}}">{{$store->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-2">
                            <label for="start_date">از تاریخ</label>
                            <input autocomplete="off" @if(isset($_GET['start_date'])) value="{{$_GET['start_date']}}" @endif type="text" class="form-control" name="start_date" id="start_date"
                                   placeholder="از تاریخ">
                        </div>
                        <div class="col-xs-2">
                            <label for="end_date">تا تاریخ</label>
                            <input autocomplete="off" @if(isset($_GET['end_date'])) value="{{$_GET['end_date']}}" @endif type="text" class="form-control" name="end_date" id="end_date"
                                   placeholder="تا تاریخ">
                        </div>
                    </div>
                    <div class="box-footer clearfix">
                        <button type="submit" class="pull-left btn btn-default" id="sendEmail">جستجو
                            <i class="fa fa-arrow-circle-left"></i></button>
                    </div>
                </form>
            </div>

        </div>
        @if(isset($orders))
        <div class="table-responsive-sm">
            <table class="table table-info table-striped dailyTable">
                <tbody>
                <tr>
                    <td>ردیف</td>
                    <td>کد سفارش</td>
                    <td>مقدار</td>
                    <td>مقصد</td>
                    <td>تاریخ ثبت</td>
                    <td>وضعیت</td>
                </tr>
                   @foreach($orders as $order)
                       <tr>
                       <td>{{ $loop->iteration }}</td>
                       <td>{{ $order->order_code }}</td>
                       <td>{{ $order->amount }}</td>
                       <td>{{ $order->destination }}</td>
                       <td>{{ $order->created_at }}</td>
                       <td>{{ $order->status }}</td>
                       </tr>
                           @endforeach

                </tbody>
            </table>
        </div>

            <div class="box-footer clearfix">
                <button type="button" class="pull-left btn btn-default" id="export-excel">خروجی
                    <i class="fa fa-arrow-circle-left"></i></button>
            </div>
            @endif
    </section>

    <script>
        $(document).ready(function () {
            $("#sendEmail").on("click", function (e) {
                $('#search-form').attr('action', '/administrator/orders/search').submit();
            });
            $("#export-excel").on("click", function (e) {
                 var url = document.location.href+"&export=yes";
                document.location = url;
            });
        });
    </script>
@endsection
