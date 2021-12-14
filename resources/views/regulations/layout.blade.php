@extends('app')

@section('body')
    <nav class="navbar navbar-expand-lg navbar-light navbar-dark bg-dark mb-4">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Нормативные документы</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('regulations') ? 'active' : null }}" href="{{route('regulations.index')}}">Главная</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('regulations/create') ? 'active' : null }}" href="{{route('regulations.create')}}">Загрузка</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">

        @yield('content')
    </div>
@endsection
