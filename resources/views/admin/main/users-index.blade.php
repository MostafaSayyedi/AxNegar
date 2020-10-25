@extends('admin.layout.master')
@section('content')
    <section class="content">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title pull-right">کاربران</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                @include('admin.partials.form-errors')
                <div class="table-responsive">
                    <table class="table no-margin">
                        <thead>
                        <tr>
                            <th class="text-center">ردیف</th>
                            <th class="text-center">نام</th>
                            <th class="text-center">کد ملی</th>
                            <th class="text-center">تاریخ تولد</th>
                            <th class="text-center">جنسیت</th>
                            <th class="text-center">ایمیل</th>
                            <th class="text-center">شماره حساب</th>
{{--                            <th class="text-center">شبکه اجتماعی</th>--}}
                            <th class="text-center">وضعیت</th>
                            <th class="text-center">عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($customers as $customer)
                            <tr>
                                <td class="text-center">{{$loop->iteration}}</td>
                                <td class="text-center">{{$customer->user->name}}</td>
                                <td class="text-center">{{$customer->user->national_code}}</td>
                                <td class="text-center">{{$customer->user->birthday_date}}</td>
                                <td class="text-center">{{$customer->user->gender}}</td>
                                <td class="text-center">{{$customer->user->email}}</td>
                                <td class="text-center">{{$customer->bank_number}}</td>
{{--                                <td class="text-center">{{$customer->social_address}}</td>--}}
                                @if($customer->status == 0)
                                    <td class="text-center"><span class="tag tag-pill tag-danger">غیر فعال</span></td>
                                @else
                                    <td class="text-center"><span class="tag tag-pill tag-success">فعال</span></td>
                                @endif
                                <td class="text-center">
                                    <a class="btn btn-warning" href="{{route('admin.users.edit', $id = $customer->id)}}">ویرایش</a>
                                    <div class="display-inline-block">
                                        <form method="post" action="{{ route('admin.users.destroy', $id = $customer->id) }}">
                                            @csrf
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="btn btn-danger">حذف</button>
                                        </form>
                                    </div>
                                </td>
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
