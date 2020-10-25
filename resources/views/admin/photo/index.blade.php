@extends('admin.layout.master')

@section('content')
    <section class="content">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title pull-right">عکس ها</h3>

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
                            <th class="text-center">دسته بندی</th>
                            <th class="text-center">امتیاز</th>
                            <th class="text-center">تصویر</th>
                            {{--                            <th class="text-center">تصویر جدید</th>--}}
                            <th class="text-center">کاربر</th>
                            <th class="text-center">هش عمومی</th>
                            <th class="text-center">هش خصوصی</th>
                            <th class="text-center">وضعیت</th>
                            {{--                            <th class="text-center">عملیات</th>--}}
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($photos as $photo)
                            <tr>
                                <td class="text-center">{{$loop->iteration}}</td>
                                <td class="text-center">{{$photo->title}}</td>
                                <td class="text-center">{{$photo->category->title}}</td>
                                <td class="text-center">{{$photo->rate}}</td>
                                <td class="text-center">
                                    <a href="{{ route('user.photo.preview', ['username'=>$photo->user->user_name, 'p_hash'=>$photo->p_hash])}}">
                                        <img style="width: 90px;height: 90px" src="{{url($photo->sources)}}" alt="">
                                    </a>
                                </td>
                                {{-- <td class="text-center">
                                     <a href="{{ route('user.photo.preview', ['name'=>$photo->user->f_name, 'p_hash'=>$photo->p_hash])}}">
                                         <img style="width: 90px;height: 90px"  src="{{url($photo->new_sources)}}" alt="">
                                     </a>
                                 </td>--}}
                                <td class="text-center">{{$photo->user->name}} {{$photo->user->f_name}}</td>
                                <td class="text-center">{{$photo->p_hash}}</td>
                                <td class="text-center">{{$photo->f_hash}}</td>

                                <td class="text-center"><a href="{{ route('admin.photo.status' , ['id'=>$photo->id,'status'=>$photo->status=='فعال' ? '1' : '0']) }}"><span class="label @if($photo->status == 'فعال') label-success @elseif($photo->status == 'غیر فعال') label-danger @endif">{{$photo->status}} </span></a></td>

                                {{-- <td class="text-center">
                                     <div class="display-inline-block">
                                         <form method="post" action="{{ route('admin.photo.status', $id = $photo->id) }}">
                                             @csrf
                                             <input type="hidden" name="_method" value="DELETE">
                                             <button type="submit" class="btn btn-danger">حذف</button>
                                         </form>
                                     </div>

                                 </td>--}}
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
