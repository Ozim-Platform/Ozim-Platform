@extends('layouts.main')
@section('title', '- Баннер')

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
                                    <li class="breadcrumb-item" aria-current="page">Баннер</li>
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
                        <label class="col-form-label col-md-2" for="language">Язык</label>
                        <select id="language" name="language" class=" col-md-10" required>
                            <option value="">Выберите язык</option>
                            @foreach($languages as $language)
                                <option @if($item->language && $item->language->sys_name == $language->sys_name) selected @endif
                                value="{{ $language->sys_name }}">{{ $language->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-md-2" for="type">Тип</label>
                        <select name="type" id="type" class=" col-md-10" required>
                            <option value="0">Выберите тип</option>
                            @foreach($category_types as $category)
                                <option @if($item->type && $item->type->sys_name == $category->sys_name) selected @endif
                                value="{{ $category->sys_name }}">{{ $category->name }} - {{ $category->sys_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-md-2" for="record">Запись</label>
                        <select name="record_id" id="record" class=" col-md-10" required>
                            <option value="0">Выберите запись</option>

                        </select>
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
            $('#type').change(function () {
                var id = $(this).children("option:selected").val();
                var type = $(this).children("option:selected").text();
                var language = $('#language').children("option:selected").val();

                if (id == 0) {
                    alert('Выберите подходящее значение из списка!');
                }

                $('#record').empty();
                $.ajax({
                    url: '{{ route('admin.banner.get_records_by_type') }}',
                    data: {
                        "type": id,
                        "language": language
                    },
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        $('#record').css('display', 'block');
                        $('#record').append($('<option>', {value: 0, text: 'Выберите '+type}));
                        if (data != null && data.length >= 1) {
                            $.each(data, function (k,v) {
                                console.log(v)
                                $('#record').append($('<option>', {
                                    value: v.id,
                                    text: v.name ?? '' + '-' + v.title,
                                }));
                            });
                        } else {
                            $('#type').val(0);

                            $('#record').css('display', 'none');
                            alert('Записей нет, добавьте ее');
                        }
                    },
                    error: function (error) {
                        $('#type').val(0);
                        $('#record').css('display', 'none');
                        alert('Что-то пошло не так, попробуйте позже');
                    }
                })
            });
        });
        $(document).ready(function(){

            var id = $('#type').children("option:selected").val();
            var language = $('#language').children("option:selected").val();
            $.ajax({
                url: '{{ route('admin.banner.get_records_by_type') }}',
                data: {
                    "type": id,
                    "language": language
                },
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    $('#record').css('display', 'block');

                    if (data != null && data.length >= 1) {
                        $.each(data, function (k,v) {
                            console.log(v)
                            $('#record').append($('<option>', {
                                value: v.id,
                                text: v.name ?? '' + '-' + v.title,
                            }));
                        });
                    } else {
                        $('#type').val(0);

                    }
                },
                error: function (error) {
                    $('#type').val(0);
                }
            });
        })
    </script>
@endpush