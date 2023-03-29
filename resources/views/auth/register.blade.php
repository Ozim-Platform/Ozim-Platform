@extends('layouts.app')
@section('title', '- Регистрация')

@section('content')
    <div class="row justify-content-center no-gutters">
        <div class="col-lg-4 col-md-5 col-12">
            <div class="content-top-agile p-10">
                <h2 class="text-white">Ozim Register</h2>
            </div>
            <div class="p-30 rounded30 box-shadowed b-2 b-dashed">
                @include('partials.messages')
                <form action="{{ route('register') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-transparent text-white"><i class="ti-user"></i></span>
                            </div>
                            <input type="text" class="form-control pl-15 bg-transparent text-white plc-white" placeholder="Имя">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-transparent text-white"><i class="ti-notepad"></i></span>
                            </div>
                            <input id="phone" type="text" class="form-control pl-15 bg-transparent text-white plc-white simple-field-data-mask-selectonfocus {{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" value="{{ old('phone') ?? 7 }}" required autofocus placeholder="Телефон" data-mask="+0-000-000-00-00" data-mask-selectonfocus="false" />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-transparent text-white"><i class="ti-lock"></i></span>
                            </div>
                            <input type="password" class="form-control pl-15 bg-transparent text-white plc-white" placeholder="Пароль">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-transparent text-white"><i class="ti-lock"></i></span>
                            </div>
                            <input type="password" class="form-control pl-15 bg-transparent text-white plc-white" placeholder="Повторите пароль">
                        </div>
                    </div>
                    <div class="row">

                        <!-- /.col -->
                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-info btn-rounded margin-top-10">Регистрация</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>


                <div class="text-center">
                    <p class="mt-15 mb-0 text-white">Уже есть аккаунт?<a href="/login" class="text-danger ml-5"> Войти</a></p>
                </div>
            </div>
        </div>
    </div>
@endsection
