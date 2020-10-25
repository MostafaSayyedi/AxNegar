@extends('user.layout.master')
@section('pageTitle', 'صفحه پشتیبانی')
@section('body')
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md-2 ">
                <div class="list-group" style="margin-bottom: 10px;">
                    <a href="{{ route('user.showInfo') }}" class="list-group-item list-group-item-action ">اطلاعات
                        من</a>
                    <a href="{{ route('user.showSecurity') }}" class="list-group-item list-group-item-action">امنیت</a>
                    <a href="{{ route('user.ticket') }}" class="list-group-item list-group-item-action active">تیکتها</a>

                </div>
            </div>
            <div class="col-xs-12 col-md-10 ">
                <div id="info">
                    <form action="{{ route('user.ticket.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">

                            <input type="hidden" name="general" value="general">
                            <div class="col-sm-12 col-md-6">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-default">انتخاب بخش</span>
                                    </div>
                                    <select class="form-control @error('role') is-invalid @enderror"
                                            name="role">
                                        @foreach($roles as $role)
                                            <option <?php if (old('role') == $role->id) {
                                                echo 'selected';
                                            } else {
                                                echo '';
                                            } ?> value=" {{ $role->id }}" id="role">
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
                            <div class="col-sm-12 col-md-6">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-default">اولویت</span>
                                    </div>
                                    <select class="form-control @error('advantage') is-invalid @enderror"
                                            name="advantage">
                                        <option <?php if (old('advantage') == 0) {
                                            echo 'selected';
                                        } else {
                                            echo '';
                                        } ?> value="0">
                                            فوری
                                        </option>
                                        <option <?php if (old('advantage') == 1) {
                                            echo 'selected';
                                        } else {
                                            echo '';
                                        } ?> value="1">
                                            مهم
                                        </option>
                                        <option <?php if (old('advantage') == 2) {
                                            echo 'selected';
                                        } else {
                                            echo '';
                                        } ?> value="2">
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
                            <div class="col-sm-12 col-md-6">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-default">موضوع</span>
                                    </div>
                                    <input type="text"
                                           class="form-control @error('title') is-invalid @enderror"
                                           id="input-title"
                                           placeholder="" value="{{ old('title') }}"
                                           name="title" autocomplete="on">
                                    @if($errors->has('title'))
                                        <span class="help-block" style="color: red">
                                <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-default">متن تیکت</span>
                                    </div>
                                    <textarea
                                        class="form-control @error('message') is-invalid @enderror"
                                        id="input-message"
                                        placeholder=""
                                        name="message" autocomplete="on">{{ old('message') }}</textarea>

                                    @if($errors->has('message'))
                                        <span class="help-block" style="color: red">
                                <strong>{{ $errors->first('message') }}</strong>
                                    </span>
                                    @endif
                                </div>

                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-default">فایل</span>
                                    </div>
                                    <div
                                        class="form-element margin-bottom-20 @error('file') is-invalid @enderror">
                                        <input type="file" id="file" name="file"
                                               class="dropify">
                                        @if($errors->has('file'))
                                            <span class="help-block" style="color: red">
                                <strong>{{ $errors->first('file') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="buttons">
                                    <div class="pull-right">
                                        <input type="submit"
                                               class="btn btn-primary"
                                               value="ارسال">
                                    </div>
                                </div>
                            </div>


                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>





@endsection

@section('script-vuejs')
    <script src="{{asset('admin/js/app.js')}}"></script>
@endsection
