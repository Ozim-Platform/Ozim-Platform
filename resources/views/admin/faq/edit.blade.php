@extends('layouts.main')
@section('title', '- FAQ')

@section('content')

    <div class="col-12">
        @include('partials.messages')

        <div class="box">
            @include('partials.messages')
            <form action="{{ route($namespace_update, $item->_id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="box-header with-border">
                    <div class="mr-auto">
                        <div class="d-inline-block align-items-center">
                            <nav>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route($namespace_update, $item->_id) }}"><i class="mdi mdi-home-outline"></i></a></li>
                                    <li class="breadcrumb-item" aria-current="page">FAQ</li>
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
                            <label class="col-form-label col-md-2">Тема</label>
                            <div class="col-md-10">
                                <input value="{{ $item->title }}" class="form-control" type="text" name="title">
                            </div>
                    </div>

                    <div class="form-group row">
                            <label class="col-form-label col-md-2">Описание</label>
                            <div class="col-md-10">
                                <textarea id="tiny" class="textarea" placeholder="Описание"
                                          style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" name="description">{{ $item->description }}</textarea>


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
                        <h5 class="col-form-label col-md-2">Фото <span class="text-danger">*</span></h5>
                        <div class="controls col-form-label col-md-10">
                            <input type="file" name="image" class="form-control">
                        </div>
                    </div>

                </div>
            </form>

        </div>

        <!-- /.box -->
    </div>


@endsection