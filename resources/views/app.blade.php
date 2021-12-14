<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8"/>
    <link rel="shortcut icon" href="{{asset('/favicon.ico')}}" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"/>
    <title>{{env('APP_NAME')}}</title>
</head>
<body>
@yield('body')

<script type="application/javascript" src="{{ mix('js/app.js') }}"></script>
</body>
</html>
