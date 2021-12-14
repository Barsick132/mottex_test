@extends('regulations.layout')

@section('content')
    @include('errors')

    @if(\Session::has('success'))
        <div class="alert alert-info">{{ \Session::get('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <form method="post" action="{{route('regulations.store')}}" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="inputFile1" class="form-label">Перечень нормативных документов</label>
                    <input class="form-control @error('file') is-invalid @enderror" type="file" id="inputFile1"
                           name="file" value="{{ old('file') }}" required>
                    @if($errors->has('file'))
                        @foreach($errors->get('file') as $message)
                            <div id="inputFileFeedback1" class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @endforeach
                    @else
                        <div id="fileHelp" class="form-text">Прикрепите файл с расширением .xml</div>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary">Загрузить</button>
            </form>
        </div>
    </div>
@endsection
