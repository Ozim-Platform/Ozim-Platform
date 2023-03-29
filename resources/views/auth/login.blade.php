@extends('layouts.app')
@section('title', '- Вход')
@section('content')
    <div class="row justify-content-center no-gutters">
        <div class="col-lg-4 col-md-5 col-12">
            <div class="content-top-agile p-10">
                <h2 class="text-white">Ozim Admin</h2>
                <p class="text-white-50">Войдите чтобы начать сессию</p>
            </div>
            <div class="p-30 rounded30 box-shadowed b-2 b-dashed">
                <form action="{{ route('login') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-transparent text-white"><i class="ti-user"></i></span>
                            </div>
                            <input id="phone" type="text" class="form-control pl-15 bg-transparent text-white plc-white simple-field-data-mask-selectonfocus {{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" value="{{ old('phone') ?? 7 }}" required autofocus placeholder="Телефон" data-mask="+0-000-000-00-00" data-mask-selectonfocus="false" />
                            @error('phone')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>
                    @include('partials.messages')

                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text  bg-transparent text-white"><i class="ti-lock"></i></span>
                            </div>
                            <input name="password" type="password" class="form-control pl-15 bg-transparent text-white plc-white" required placeholder="Пароль">
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="checkbox text-white">
                                <input {{ old('remember') ? 'checked' : '' }} type="checkbox" id="basic_checkbox_1" >
                                <label for="basic_checkbox_1">Запомнить</label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-6">
                            <div class="fog-pwd text-right">
                                <a href="javascript:void(0)" class="text-white hover-info"><i class="ion ion-locked"></i> Забыли пароль?</a><br>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-info btn-rounded mt-10">Войти</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
