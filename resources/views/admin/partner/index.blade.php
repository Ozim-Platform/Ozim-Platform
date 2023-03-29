@extends('layouts.main')
@section('title', '- Партнеры')

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
                                <li class="breadcrumb-item" aria-current="page">Партнеры</li>
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
                                <th>Название</th>
                                <th>Тема</th>
                                <th>Действуен(мес)</th>
{{--                                <th>Платная</th>--}}
                                <th>Описание</th>
                                <th>Цена</th>
                                <th>Фото</th>
                                <th>Изображения</th>
                                <th>Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($items as $item)
                                <tr>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->title }}</td>
                                    <td>{{ $item->expires }}</td>
{{--                                    <td>{{ $item->is_paid ? 'Да' : "Нет" }}</td>--}}
                                    <td style="max-height: 200px;">{!! $item->description !!}</td>
                                    <td>{{ $item->price }}</td>
                                    <td>
                                        @if($item->image)
                                            <a href="/{{ $item->image['path'] }}" target="_blank">
                                                <img src="/{{ $item->image['path'] }}" style="width: 100px; height: 100px;" alt="">
                                            </a>

                                        @endif
                                    </td>
                                    <td>
                                        @forelse($item->images ?? [] as $image)
                                            <a href="/{{ $image['path'] }}" target="_blank">
                                                <img src="/{{ $image['path'] }}" style="width: 100px; height: 100px;" alt="">
                                            </a>
                                        @empty
                                            не указан
                                        @endforelse
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
                                <th>Название</th>
                                <th>Тема</th>
                                <th>Действуен(мес)</th>
{{--                                <th>Платная</th>--}}
                                <th>Описание</th>
                                <th>Цена</th>
                                <th>Фото</th>
                                <th>Изображения</th>
                                <th>Действия</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="dt-buttons btn-group">
                    <a href="{{ route($namespace_create) }}" class="btn btn-secondary buttons-copy buttons-html5" tabindex="0">
                        <span>Добавить Партнера</span>
                    </a>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>


@endsection