@extends('layouts.main')
@section('title', '- Языки')

@section('content')

    <div class="col-12">
        @include('partials.messages')

        <div class="box">
            <form action="{{ route($namespace_store) }}" method="POST" enctype="multipart/form-data">
                <div class="box-header with-border">
                    <div class="mr-auto">
                        <div class="d-inline-block align-items-center">
                            <nav>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route($controller_name) }}"><i class="mdi mdi-home-outline"></i></a></li>
                                    <li class="breadcrumb-item" aria-current="page">Языки</li>
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
                        @csrf
                        <label class="col-form-label col-md-2">Название</label>
                        <div class="col-md-10">
                            <input class="form-control" type="text" name="name">
                        </div>
                    </div>
                </div>
            </form>

        </div>

        <!-- /.box -->
    </div>


@endsection