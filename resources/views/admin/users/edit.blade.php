@extends('layouts.main')
@section('title', '- Навыки')

@section('content')

    <div class="col-12">
        @include('partials.messages')
        <div class="box">
            <form action="{{ route($namespace_update, $item->_id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="box-header with-border">
                    <div class="mr-auto">
                        <div class="d-inline-block align-items-center">
                            <nav>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route($namespace_update, $item->_id) }}"><i class="mdi mdi-home-outline"></i></a></li>
                                    <li class="breadcrumb-item" aria-current="page">Навыки</li>
                                    <li class="breadcrumb-item active" aria-current="page">Редактирование</li>
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
                            <input value="{{ old('name') ?? $item->name }}" class="form-control" type="text" name="name">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-md-2">Язык</label>
                        <select name="language" class="selectpicker col-md-10" required>
                            <option value="">Выберите язык</option>
                            @foreach($languages as $language)
                                <option @if($item->language && $item->language->sys_name == $language->sys_name) selected @endif
                                        value="{{ $language->sys_name }}">{{ $language->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-md-2">Тип пользователя</label>
                        <select name="type" class="selectpicker col-md-10" required>
                            <option value="0">Выберите тип</option>
                            @foreach($types as $type)
                                <option @if($item->type && $item->type->sys_name == $type->sys_name) selected @endif
                                        value="{{ $type->sys_name }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-md-2">Роль пользователя</label>
                        <select name="role" class="selectpicker col-md-10" required>
                            <option value="0">Выберите тип</option>
                            @foreach($roles as $role)
                                <option @if($item->role && $item->role->sys_name == $role->sys_name) selected @endif
                                        value="{{ $role->sys_name }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-md-2">Телефон</label>
                        <div class="col-md-10">
                            <input id="phone" type="text" class="form-control simple-field-data-mask-selectonfocus {{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" value="{{ old('phone') ?? $item->phone }}" required autofocus placeholder="Телефон" data-mask="+0-000-000-00-00" data-mask-selectonfocus="false" />

                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-md-2">Почта</label>
                        <div class="col-md-10">
                            <input  class="form-control" value="{{ old('email') ?? $item->email }}" type="email" name="email">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-md-2">Баллы</label>
                        <div class="col-md-10">
                            <input class="form-control" value="{{ old('points' ?? $item->points ?? 0) }}" type="number" name="points" step="10">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-md-2">Аватар (загрузите чтобы обновить/добавить)</label>
                        <div class="col-md-10">
                            <input  class="form-control" type="file" name="avatar">
                        </div>
                    </div>

                    @if($item->avatar)
                        <div class="form-group row">
                            <label class="col-form-label col-md-2"></label>
                            <div class="col-md-10">
                                <img src="/{{ $item->avatar }}" style="width: 100px; height: 100px;" alt="avatar">
                            </div>
                        </div>
                    @endif


                </div>
            </form>

        </div>

        <!-- /.box -->
    </div>


@endsection