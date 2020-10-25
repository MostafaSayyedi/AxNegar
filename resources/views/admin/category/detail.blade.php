@extends('admin.layout.master')

@section('content')
    <section class="content">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title pull-right">اطلاعات مربوط به {{ $customer->user->name }}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table no-margin">
                        <thead>
                        <tr>
                            <th class="text-center">نام</th>
                            <th class="text-center">شماره تماس</th>
                            <th class="text-center">فکس</th>
                            <th class="text-center">تصویر</th>
                            <th class="text-center">جنسیت</th>
                            <th class="text-center">ایمیل</th>
                            <th class="text-center">کد ملی</th>
                            <th class="text-center">وضعیت</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center">{{$customer->user->name}}</td>
                                <td class="text-center">{{$customer->phone}}</td>
                                <td class="text-center">{{$customer->fax}}</td>
                                <td class="text-center">{{$customer->photo}}</td>
                                <td class="text-center">{{$customer->user->gender}}</td>
                                <td class="text-center">{{$customer->user->email}}</td>
                                <td class="text-center">{{$customer->user->national_code}}</td>
                                <td class="text-center"><a href="{{ route('admin.users.status' , ['id'=>$customer->id,'status'=>$customer->user->active]) }}"><span class="label @if($customer->user->active == 1) label-success @elseif($customer->user->active == 0) label-danger @endif">{{$customer->user->active}}</span></a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>
        </div>
    </section>

@endsection
