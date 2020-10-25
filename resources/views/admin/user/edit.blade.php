@extends('admin.layout.master')

@section('content')
    <section class="content">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title pull-right">ویرایش کاربران</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <form id="myForm" method="post" action="{{ route('admin.users.update', $id=$user->id) }}">
                            @csrf
                            <input type="hidden" name="_method" value="PATCH">
                            <div class="form-group">
                                <label for="name">نام</label>
                                <input class="form-control @error('name') is-invalid @enderror" type="text" name="name"
                                       value="{{ $user->name }}">
                                @if($errors->has('name'))
                                    <span class="help-block" style="color: red">
                                <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="f_name">نام خانوادگی</label>
                                <input class="form-control @error('f_name') is-invalid @enderror" type="text"
                                       name="f_name" value="{{ $user->f_name }}">
                                @if($errors->has('f_name'))
                                    <span class="help-block" style="color: red">
                                <strong>{{ $errors->first('f_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="email">ایمیل</label>
                                <input class="form-control @error('email') is-invalid @enderror" type="text"
                                       name="email" value="{{ $user->email }}">
                                @if($errors->has('email'))
                                    <span class="help-block" style="color: red">
                                <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="gender">جنسیت</label>
                                <select  class="form-control @error('gender') is-invalid @enderror" name="gender" id="">
                                    <option {{ $user->email=='مرد' ? 'selected' : '' }} value="1">مرد</option>
                                    <option {{ $user->email=='زن' ? 'selected' : '' }}  value="0">زن</option>
                                </select>
                                @if($errors->has('gender'))
                                    <span class="help-block" style="color: red">
                                <strong>{{ $errors->first('gender') }}</strong>
                                    </span>
                                @endif
                            </div>
                            {{--   <div class="form-group ">
                                   <label for="description" class="col-sm-2 control-label">توضیحات </label>
                                   <textarea
                                       class="form-control @error('description') is-invalid @enderror"
                                       id="description"
                                       placeholder=""
                                       name="description" autocomplete="on">{{ $category->description }}</textarea>
                                   @if($errors->has('description'))
                                       <span class="help-block" style="color: red">
                                   <strong>{{ $errors->first('description') }}</strong>
                                       </span>
                                   @endif
                               </div>--}}


                            <button type="submit" class="btn btn-success pull-left">ذخیره</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection
