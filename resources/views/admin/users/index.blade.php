@extends('layouts.main')
@section('title', '- Пользователи')

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
                                <li class="breadcrumb-item" aria-current="page">Пользователи</li>
                                <li class="breadcrumb-item active" aria-current="page">Просмотр</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Имя</th>
                            <th>Телефон</th>
                            <th>Почта</th>
                            <th>Аватар</th>
                            <th>Баллы</th>
                            <th>Язык</th>
                            <th>Тип</th>
                            <th>Роль</th>
                            <th>Действия</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($items as $item)
                            <tr>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->phone }}</td>
                                <td>{{ $item->email }}</td>
                                <td>
                                    @if($item->avatar)
                                        <img src="/{{ $item->avatar }}" style="width: 100px; height: 100px;" alt="avatar">
                                    @endif
                                </td>
                                <td>{{ $item->points ?? 0 }}</td>
                                <td>{{ $item->language->name ?? 'не указан' }}</td>
                                <td>{{ $item->type->name ?? 'не указан' }}</td>
                                <td>{{ $item->role->name ?? 'не указан' }}</td>
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
                            <th>Имя</th>
                            <th>Телефон</th>
                            <th>Почта</th>
                            <th>Аватар</th>
                            <th>Баллы</th>
                            <th>Язык</th>
                            <th>Тип</th>
                            <th>Роль</th>
                            <th>Действия</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
                @include('partials.pagination')
                <div class="dt-buttons btn-group">
                    <a href="{{ route($namespace_create) }}" class="btn btn-secondary buttons-copy buttons-html5" tabindex="0">
                        <span>Добавить пользователя</span>
                    </a>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>


@endsection