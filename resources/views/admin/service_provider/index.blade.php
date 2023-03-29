@extends('layouts.main')
@section('title', '- Поставщики услуг')

@section('content')

    <div class="col-12">
        @include('partials.messages')

        <div class="box">
            <div class="box-header with-border">
                <div class="mr-auto">
                    <div class="d-inline-block align-items-center">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route($controller_name) }}"><i class="mdi mdi-home-outline"></i></a></li>
                                <li class="breadcrumb-item" aria-current="page">Поставщики услуг</li>
                                <li class="breadcrumb-item active" aria-current="page">Просмотр</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Тема</th>
                                <th>Название</th>
                                <th>Платная</th>
                                <th style="width: 200px;">Описание</th>
                                <th>Телефон</th>
                                <th>Почта</th>
                                <th>Ссылка</th>
                                <th>Язык</th>
                                <th>Категория</th>
                                <th>Фото</th>
                                <th>Обложка</th>
                                <th>Рейтинг</th>
                                <th>Автор</th>
                                <th>Специальность автора</th>
                                <th>Фото автора</th>
                                <th>Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($items as $item)
                                <tr>
                                    <td>{{ $item->title }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->is_paid ? 'Да' : "Нет" }}</td>
                                    <td style="max-height: 200px;">{!! $item->description !!}</td>
                                    <td>{{ $item->phone }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ $item->link }}</td>
                                    <td>{{ $item->language->name ?? 'не указан' }}</td>
                                    <td>{{ $item->category->name ?? 'не указан' }}</td>
                                    <td>
                                        @if($item->image)
                                            <img src="/{{ $item->image['path'] ?? 'не указан' }}" style="width: 100px; height: 100px;" alt="">
                                        @endif
                                    </td>
                                    <td>
                                        @if($item->preview)
                                            <img src="/{{ $item->preview['path'] ?? 'не указан' }}" style="width: 100px; height: 100px;" alt="">
                                        @endif
                                    </td>
                                    <td>
                                        {{ \App\Models\ServiceProvider::rating($item->id) }}
                                    </td>
                                    <td>{{ $item->author }}</td>
                                    <td>{{ $item->author_position }}</td>
                                    <td>
                                        @if($item->author_photo)
                                            <img src="/{{ $item->author_photo['path'] ?? 'не указан' }}" style="width: 100px; height: 100px;" alt="">
                                        @endif
                                    </td>
                                    <td>
                                        <a class="btn btn-rounded" href="{{ route($namespace_edit, $item->_id) }}"><span class="fa fa-pencil"></span></a>
                                        @include('partials.delete')
                                    </td>
                                </tr>
                            @empty
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Тема</th>
                                <th>Название</th>
                                <th>Платная</th>
                                <th>Описание</th>
                                <th>Телефон</th>
                                <th>Почта</th>
                                <th>Ссылка</th>
                                <th>Язык</th>
                                <th>Категория</th>
                                <th>Фото</th>
                                <th>Обложка</th>
                                <th>Рейтинг</th>
                                <th>Автор</th>
                                <th>Специальность автора</th>
                                <th>Фото автора</th>
                                <th>Действия</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="dt-buttons btn-group">
                    <a href="{{ route($namespace_create) }}" class="btn btn-secondary buttons-copy buttons-html5" tabindex="0">
                        <span>Добавить поставщика</span>
                    </a>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>


@endsection