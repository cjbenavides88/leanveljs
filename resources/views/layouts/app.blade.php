<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('includes.head')
</head>
    <body class="h-100 animated">
    @yield('content')
        @include('includes.scripts')
        @yield('js')
    </body>
</html>
