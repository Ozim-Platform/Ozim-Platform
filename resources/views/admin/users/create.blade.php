@extends('layouts.main')
@section('title', '- Пользователи')

@section('content')

    <div class="col-12">
        @include('partials.messages')
        <div class="box">
            <form action="{{ route($namespace_store) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="box-header with-border">
                    <div class="mr-auto">
                        <div class="d-inline-block align-items-center">
                            <nav>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route($namespace_store) }}"><i class="mdi mdi-home-outline"></i></a></li>
                                    <li class="breadcrumb-item" aria-current="page">Пользователи</li>
                                    <li class="breadcrumb-item active" aria-current="page">Добавление</li>
                                </ol>
                            </nav>
                            <a type="button" href="{{ route($namespace_index) }}" class="btn btn-info mb-5">Назад</a>
                            <button type="submit" class="btn btn-success mb-5">Сохранить и выйти</button>
                        </div>
                    </div>
                </div>
                <div class="box-body">

                    <div class="form-group row">
                        <label class="col-form-label col-md-2">ФИО</label>
                        <div class="col-md-10">
                            <input  class="form-control" type="text" name="name">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-md-2">Язык</label>
                        <select name="language" class="selectpicker col-md-10" required>
                            <option value="">Выберите язык</option>
                            @foreach($languages as $language)
                                <option
                                        value="{{ $language->sys_name }}">{{ $language->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-md-2">Тип пользователя</label>
                        <select name="type" class="selectpicker col-md-10" required>
                            <option value="0">Выберите тип</option>
                            @foreach($types as $type)
                                <option
                                        value="{{ $type->sys_name }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-md-2">Роль пользователя</label>
                        <select name="role" class="selectpicker col-md-10" required>
                            <option value="0">Выберите тип</option>
                            @foreach($roles as $role)
                                <option
                                        value="{{ $role->sys_name }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-md-2">Телефон</label>
                        <div class="col-md-10">
                            <input id="phone" type="text" class="form-control simple-field-data-mask-selectonfocus {{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" value="{{ old('phone') ?? 7 }}" required autofocus placeholder="Телефон" data-mask="+0-000-000-00-00" data-mask-selectonfocus="false" />

                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-md-2">Аватар</label>
                        <div class="col-md-10">
                            <input  class="form-control" type="file" name="avatar">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-md-2">Почта</label>
                        <div class="col-md-10">
                            <input  class="form-control" value="{{ old('email' ?? '') }}" type="email" name="email">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-md-2">Баллы</label>
                        <div class="col-md-10">
                            <input  class="form-control" value="{{ old('points' ?? 0) }}" type="number" name="points" step="10">
                        </div>
                    </div>


                </div>
            </form>

        </div>

        <!-- /.box -->
    </div>


@endsection
@push('footer_scripts')
    <script type="text/javascript" src="/js/jquery.mask.js"></script>
@endpush