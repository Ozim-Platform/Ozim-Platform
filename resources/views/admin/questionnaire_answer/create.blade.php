@extends('layouts.main')
@section('title', '- Анкета')

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
                                    <li class="breadcrumb-item" aria-current="page">Анкета</li>
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
                        <label class="col-form-label col-md-2">Анкета</label>
                        <select name="questionnaire_id" class="selectpicker col-md-10" id="questionnaire_id" required>
                            <option value="">Выберите анкету</option>
                            @foreach($questionnaires as $questionnaire)
                                <option
                                        value="{{ $questionnaire->id }}">{{ $questionnaire->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="answers">

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
                        <label class="col-form-label col-md-2">Описание</label>
                        <div class="col-md-10">
                            <textarea id="tiny" class="textarea" placeholder="Описание"
                                      style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" name="description"></textarea>


                        </div>
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

@push('footer_scripts')
    <script>
        $(function () {
            $('#questionnaire_id').change(function () {
                $('#block_0').remove();
                $('#block_1').remove();
                $('#block_2').remove();
                $('#block_3').remove();
                $('#block_4').remove();
                $('#block_5').remove();
                $('#block_6').remove();
                $('#block_7').remove();

                var id = $(this).children("option:selected").val();

                if (id === '') {
                    alert('Выберите подходящее значение из списка!');
                }
                if (id !== '') {
                    $.ajax({
                        url: '{{ route('admin.questionnaire.select') }}',
                        data: {
                            "questionnaire_id": id
                        },
                        type: 'GET',
                        dataType: 'json',
                        success: function (data) {
                            if (data != null && data.length >= 1) {
                                $.each(data, function (k, v) {
                                    $('.answers:last').before(
                                        '<div id="block_'+k+'" class="form-group row">' +
                                            '<label class="col-form-label col-md-2">Ответы</label>' +
                                            '<div class="col-md-10">' +
                                                '<span>'+ v +'</span>' +
                                                '<input type="radio" id="yes_' + k + '" name="answers' + k + '" value="1">' +
                                                '<label for="yes_' + k + '">Да</label>' +
                                                '<input checked type="radio" id="no_' + k + '" name="answers' + k + '" value="0">' +
                                                '<label for="no_' + k + '">Нет</label>' +
                                            '</div>' +
                                        '</div>'
                                    );
                                });
                            } else {
                                alert('Данных нет!')
                            }
                        },
                        error: function (error) {
                            alert("Ошибка при поиске. Повторите позднее!");
                        }
                    })
                }
            });
        });
    </script>
@endpush