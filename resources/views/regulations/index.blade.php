@extends('regulations.layout')

@section('content')
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Полный перечень нормативных документов</h5>

            <div class="table-responsive">
                <table class="table table-sm">
                    <thead>
                    <tr class="">
                        <th scope="col">GUID</th>
                        <th scope="col">Email автора</th>
                        <th scope="col">Название</th>
                        <th scope="col">ID проекта</th>
                        <th scope="col">Дата создания</th>
                        <th scope="col">Разработчик</th>
                        <th scope="col">Процедура</th>
                        <th scope="col">Вид</th>
                        <th scope="col">Действие</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($regulations as $reg)
                        <tr>
                            <td>{{ $reg->guid }}</td>
                            <td><a href="mailto:{{ $reg->author }}">{{ $reg->author }}</a></td>
                            <td title="{{$reg->title}}">
                                {{ \Str::limit($reg->title, 200) }}
                            </td>
                            <td>{{ $reg->project_id }}</td>
                            <td>{{ \Carbon\Carbon::create($reg->project_created)->format('d.m.Y') }}</td>
                            <td>{{ $reg->project_developer }}</td>
                            <td>{{ $reg->procedure }}</td>
                            <td>{{ $reg->kind }}</td>
                            <td><a class="btn btn-primary btn-sm" href="{{ $reg->link }}">Перейти</a></td>
                        </tr>
                    @endforeach
                    @if(count($regulations) === 0)
                        <tr>
                            <td colspan="11">Нет данных</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>

        @if(count($regulations))
            <div class="card-footer">{{ $regulations->links('vendor.pagination.bootstrap-4') }}</div>
        @endif
    </div>
@endsection
