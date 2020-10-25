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
                            <th class="text-center">جنسیت</th>
                            <th class="text-center">ایمیل</th>
{{--                            <th class="text-center">شبکه اجتماعی</th>--}}
                            <th class="text-center">وضعیت</th>
                            <th class="text-center">عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td class="text-center">{{$loop->iteration}}</td>
                                <td class="text-center">{{$user->name}}</td>
                                <td class="text-center">{{$user->gender}}</td>
                                <td class="text-center">{{$user->email}}</td>
{{--                                <td class="text-center">{{$customer->social_address}}</td>--}}
                                <td class="text-center"><a href="{{ route('admin.users.status' , ['id'=>$user->id,'status'=>$user->active=='فعال' ? '1' : '0']) }}"><span class="label @if($user->active == 'فعال') label-success @elseif($user->active == 'غیر فعال') label-danger @endif">{{$user->active}} </span></a></td>

                                <td class="text-center">
{{--                                    <a class="btn btn-warning" href="{{route('admin.user.wallet.details', $id = $user->id)}}">مشاهده کیف پول</a>--}}
                                    <div class="display-inline-block">
                                        <form method="post" action="{{ route('admin.users.destroy', $id = $user->id) }}">
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
