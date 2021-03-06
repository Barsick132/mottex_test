@extends('app')

@section('body')
    <!-- Навигационная панель -->
    <nav class="navbar navbar-expand-lg navbar-light navbar-dark bg-dark mb-4">
        <div class="container-fluid">

            <!-- Лого -->
            <a class="navbar-brand" href="{{ route('regulations.index') }}">Нормативные документы</a>

            <!-- Кнопка меню для мобильных устройств -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Список элементов навигации -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('regulations') ? 'active' : null }}"
                           href="{{route('regulations.index')}}">Главная</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('regulations/create') ? 'active' : null }}"
                           href="{{route('regulations.create')}}">Загрузка</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Контентная часть -->
    <div class="container">
        @yield('content')
    </div>
@endsection
