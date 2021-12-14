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
            <form method="post" action="{{route('regulations.store')}}" enctype="multipart/form-data" >
                @csrf
                <div class="mb-3">
                    <label for="inputFile1" class="form-label">Перечень нормативных документов</label>
                    <input class="form-control" type="file" id="inputFile1" name="file">
                    <div id="fileHelp" class="form-text">Прикрепите файл с расширением .xml</div>
                </div>
                <button type="submit" class="btn btn-primary">Загрузить</button>
            </form>
        </div>
    </div>
@endsection
