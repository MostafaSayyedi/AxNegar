@extends('user.layout.master')
@section('content')
    <section class="content">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title pull-right">ایجاد تیکت </h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="content">
                            <form class="form-horizontal" method="post"
                                  action="{{ route('user.ticket.store') }}">
                                @csrf
                                <input type="hidden" name="general" value="general">
                                <fieldset id="account">
                                    <legend>ایجاد درخواست</legend>
                                    <div class="form-group ">
                                        <label for="input-role"
                                               class="col-sm-2 control-label">دپارتمان</label>
                                        <div class="col-sm-10">
                                            <select class="form-control @error('role') is-invalid @enderror"
                                                    name="role">
                                                @foreach($roles as $role)
                                                <option <?php if(old('role') == $role->id){echo 'selected';}else{echo '';} ?> value=" {{ $role->id }}" id="role" >
                                                    {{ $role->name }}
                                                </option>
                                                    @endforeach()

                                            </select>

                                            @if($errors->has('role'))
                                                <span class="help-block" style="color: red">
                                <strong>{{ $errors->first('role') }}</strong>
                                    </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="input-advantage"
                                               class="col-sm-2 control-label">اولویت</label>
                                        <div class="col-sm-10">
                                            <select class="form-control @error('advantage') is-invalid @enderror"
                                                    name="advantage">
                                                <option <?php if(old('advantage') == 0){echo 'selected';}else{echo '';} ?> value="0" >
                                                    فوری
                                                </option>
                                                <option <?php if(old('advantage') == 1){echo 'selected';}else{echo '';} ?> value="1" >
                                                    مهم
                                                </option>
                                                <option <?php if(old('advantage') == 2){echo 'selected';}else{echo '';} ?> value="2"  >
                                                    عادی
                                                </option>
                                            </select>
                                            @if($errors->has('advantage'))
                                                <span class="help-block" style="color: red">
                                <strong>{{ $errors->first('advantage') }}</strong>
                                    </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="input-title"
                                               class="col-sm-2 control-label">موضوع</label>
                                        <div class="col-sm-10">
                                            <input type="text"
                                                   class="form-control @error('title') is-invalid @enderror"
                                                   id="input-title"
                                                   placeholder="" value="{{ old('title') }}"
                                                   name="title"  autocomplete="on" >
                                            @if($errors->has('title'))
                                                <span class="help-block" style="color: red">
                                <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="input-message" class="col-sm-2 control-label">توضیحات </label>
                                        <div class="col-sm-10">
                                            <textarea
                                                   class="form-control @error('message') is-invalid @enderror"
                                                   id="input-message"
                                                   placeholder=""
                                                   name="message"  autocomplete="on">{{ old('message') }}</textarea>

                                            @if($errors->has('message'))
                                                <span class="help-block" style="color: red">
                                <strong>{{ $errors->first('message') }}</strong>
                                    </span>
                                            @endif
                                        </div>

                                    </div>
                                    <div class="form-group ">
                                        <label for="input-file"
                                               class="col-sm-2 control-label">فایل پیوست</label>
                                        <div class="col-sm-10">
                                            <div
                                                class="form-element margin-bottom-20 @error('file') is-invalid @enderror">
                                                <input type="file" name="file"
                                                       class="dropify">
                                                @if($errors->has('file'))
                                                    <span class="help-block" style="color: red">
                                <strong>{{ $errors->first('file') }}</strong>
                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                                <div class="buttons">
                                    <div class="pull-right">
                                        <input type="submit"
                                               class="btn btn-primary"
                                               value="ارسال">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection

@section('script-vuejs')
    <script src="{{asset('admin/js/app.js')}}"></script>
@endsection
