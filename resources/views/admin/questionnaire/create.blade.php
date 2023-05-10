@extends('layouts.main')
@section('title', '- Опросник')

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
                                    <li class="breadcrumb-item" aria-current="page">Опросник</li>
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
                        <label class="col-form-label col-md-2">Возраст</label>
                        <select name="age" class="selectpicker col-md-10" required>
                            @foreach(range(1, 25) as $age)
                                <option
                                        value="{{ $age }}">{{ $age }} месяцев</option>
                            @endforeach
                        </select>
                    </div>

                    @foreach(range(0,5) as $questionnaire_index => $questionnaire)
                            <div class="form-group row">
                                <label class="col-form-label col-md-2 font-weight-bolder bg-secondary-light">Тема {{ $questionnaire_index+1 }}</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" name="themes[]">
                                </div>
                            </div>
                        @if(!$loop->last)
                            <div class="form-group row">
                                <label class="col-form-label col-md-2">Ширина</label>
                                <div class="col-md-10">
                                    <input style="background-color: #6CBBD9" class=" col-3" min="0" max="60"  type="number" {{ 'name=ranges[' . $questionnaire . '][#6CBBD9]' }}>
                                    <input style="background-color: #F2C477" class=" col-3" min="0" max="60"  type="number" {{ 'name=ranges[' . $questionnaire . '][#F2C477]' }}>
                                    <input style="background-color: #79BCB7" class=" col-3" min="0" max="60"  type="number" {{ 'name=ranges[' . $questionnaire . '][#79BCB7]' }}>
                                </div>
                            </div>
                        @endif

                        @foreach(range(0, 5) as $question_category)
                            <div class="form-group row">
                                <label class="col-form-label col-md-2">Вопрос {{ $question_category+1 }}</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" {{ 'name=questions[' . $questionnaire .'][]' }} >
                                </div>
                            </div>
                        @endforeach
                    @endforeach

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
                        <label class="col-form-label col-md-2">Категория</label>
                        <select name="category" class="selectpicker col-md-10" required>
                            <option value="">Выберите категорию</option>
                            @foreach($categories as $category)
                                <option
                                        value="{{ $category->sys_name }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group row">
                        <h5 class="col-form-label col-md-2">Фото <span class="text-danger">*</span></h5>
                        <div class="controls col-form-label col-md-10">
                            <input type="file" name="image" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <h5 class="col-form-label col-md-2">Обложка <span class="text-danger">*</span></h5>
                        <div class="controls col-form-label col-md-10">
                            <input type="file" name="preview" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-md-2">Автор</label>
                        <div class="col-md-10">
                            <input class="form-control" type="text" name="author">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-md-2">Должность автора</label>
                        <div class="col-md-10">
                            <input class="form-control" type="text" name="author_position">
                        </div>
                    </div>
                    <div class="form-group row">
                        <h5 class="col-form-label col-md-2">Фото автора <span class="text-danger">*</span></h5>
                        <div class="controls col-form-label col-md-10">
                            <input type="file" name="author_photo" class="form-control">
                        </div>
                    </div>

                </div>
            </form>

        </div>

        <!-- /.box -->
    </div>


@endsection