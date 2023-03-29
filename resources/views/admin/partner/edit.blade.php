@extends('layouts.main')
@section('title', '- Партнеры')

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
                                    <li class="breadcrumb-item" aria-current="page">Партнеры</li>
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
                        <label class="col-form-label col-md-2">Название</label>
                        <div class="col-md-10">
                            <input class="form-control" value="{{ old('name') ?? $item->name }}" type="text" name="name">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-md-2">Действует(мес)</label>
                        <div class="col-md-10">
                            <input class="form-control" value="{{ old('expires') ?? $item->expires }}" type="number" name="expires">
                        </div>
                    </div>
{{--                    <div class="form-group row">--}}
{{--                        <label class="col-form-label col-md-2">Платная</label>--}}
{{--                        <div class="col-md-10">--}}
{{--                            <input id="basic_checkbox_1" type="checkbox" @if($item->is_paid) checked @endif name="is_paid">--}}
{{--                        </div>--}}
{{--                    </div>--}}
                    <div class="form-group row">
                        <label class="col-form-label col-md-2">Тема(-15% на первый сеанс)</label>
                        <div class="col-md-10">
                            <input class="form-control" value="{{ old('title') ?? $item->title }}" type="text" name="title">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-md-2">Цена(баллы)</label>
                        <div class="col-md-10">
                            <input class="form-control" value="{{ old('price')  ?? $item->price }}" type="number" min="0" name="price">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-md-2">Описание</label>
                        <div class="col-md-10">
                                <textarea id="tiny" class="textarea" placeholder="Описание"
                                          style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" name="description">{{ old('description') ?? $item->description }}</textarea>


                        </div>
                    </div>

                    <div class="form-group row">
                        <h5 class="col-form-label col-md-2">Фото <span class="text-danger">*</span></h5>
                        <div class="controls col-form-label col-md-10">
                            <input type="file" name="image" class="form-control">
                        </div>
                    </div>

                    <div class="form-group row">
                        <h5 class="col-form-label col-md-2">Изображения <span class="text-danger">*</span></h5>
                        <div class="controls col-form-label col-md-10">
                            <input type="file" name="images[]" class="form-control" multiple>
                        </div>
                    </div>

                </div>
            </form>

        </div>

        <!-- /.box -->
    </div>


@endsection