@extends('admin.layout.master')

@section('content')
    <section class="content">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title pull-right">پیام های ارسالی</h3>

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
                            <th class="text-center">ایمیل</th>
                            <th class="text-center">عنوان</th>
                            <th class="text-center">توضیحات</th>
                            <th class="text-center">عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($contacts as $contact)
                            <tr>
                                <td class="text-center">{{$loop->iteration}}</td>
                                <td class="text-center">{{$contact->name}}</td>
                                <td class="text-center">{{$contact->email}}</td>
                                <td class="text-center">{{$contact->subject}}</td>
                                <td class="text-center">{{$contact->message}}</td>

                                <td class="text-center">
                                    <div class="display-inline-block">
                                        <form method="post" action="{{ route('admin.contactUs.destroy', $id = $contact->id) }}">
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
