@extends('admin.layout.master')

@section('content')
    <section class="content">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title pull-right">لیست محصولات سفارش {{ $store->code }}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table no-margin">
                        <thead>
                        <tr>
                            <th class="text-center">کد فروشگاه</th>
                            <th class="text-center">نام فروشگاه</th>
                            <th class="text-center">آدرس سایت</th>
                            <th class="text-center">تصویر</th>
                            <th class="text-center">صاحب فروشگاه</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center">{{$store->code}}</td>
                                <td class="text-center">{{$store->name}}</td>
                                <td class="text-center">{{$store->site_address}}</td>
                                <td class="text-center"><img width="25%" src="{{$store->photo}}"> </td>
                                <td class="text-center"><a target="_blank" href="{{route('admin.seller.list', ['id' => $store->seller->id])}}"><span class="label label-warning">{{$store->seller->user->name}}</span></a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>
        </div>
    </section>

@endsection
