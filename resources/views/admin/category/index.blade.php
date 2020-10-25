@extends('admin.layout.master')

@section('content')
    <section class="content">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title pull-right">دسته بندی ها</h3>
                <div class="text-left">
                    <a class="btn btn-app" href="{{ route('admin.category.create') }}">
                        <i class="fa fa-plus"></i> جدید
                    </a>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                @include('admin.partials.form-errors')
                <div class="table-responsive">
                    <table class="table no-margin">
                        <thead>
                        <tr>
                            <th class="text-center">ردیف</th>
                            <th class="text-center">عنوان</th>
                            <th class="text-center">توضیحات</th>
                            <th class="text-center">وضعیت</th>
                            <th class="text-center">عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($categories as $category)
                            <tr>
                                <td class="text-center">{{$loop->iteration}}</td>
                                <td class="text-center">{{$category->title}}</td>
                                <td class="text-center">{{$category->description}}</td>
                                @if($category->status == 0)
                                    <td class="text-center"><span class="tag tag-pill tag-danger">غیر فعال</span></td>
                                @else
                                    <td class="text-center"><span class="tag tag-pill tag-success">فعال</span></td>
                                @endif
                                <td class="text-center">
                                    <a class="btn btn-warning" href="{{route('admin.category.edit', $id = $category->id)}}">ویرایش</a>
                                    <div class="display-inline-block">
                                        <form method="post" action="{{ route('admin.category.destroy', $id = $category->id) }}">
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
