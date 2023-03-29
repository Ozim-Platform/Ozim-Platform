@extends('layouts.main')
@section('title', '- Баннер')

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
                                <li class="breadcrumb-item" aria-current="page">Баннер</li>
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
                                <th>Фото</th>
                                {{--<th>Обложка</th>--}}
                                <th>Язык</th>
                                <th>Тип</th>
                                <th>Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($items as $item)
                                <tr>
                                    <td>
                                        @if($item->image)
                                            <img src="/{{ $item->image['path'] ?? 'не указан' }}" style="width: 100px; height: 100px;" alt="">
                                        @endif
                                    </td>
                                    {{--<td>--}}
                                        {{--@if($item->preview)--}}
                                            {{--<img src="/{{ $item->preview['path'] ?? 'не указан' }}" style="width: 100px; height: 100px;" alt="">--}}
                                        {{--@endif--}}
                                    {{--</td>--}}
                                    <td>{{ $item->language->name ?? 'не указан' }}</td>
                                    <td>{{ $item->type->name ?? 'не указан' }}</td>

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
                                <th>Фото</th>
                                {{--<th>Обложка</th>--}}
                                <th>Язык</th>
                                <th>Тип</th>
                                <th>Действия</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="dt-buttons btn-group">
                    <a href="{{ route($namespace_create) }}" class="btn btn-secondary buttons-copy buttons-html5" tabindex="0">
                        <span>Добавить баннер</span>
                    </a>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>


@endsection