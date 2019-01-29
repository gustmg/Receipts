<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700" rel="stylesheet"> 
    <!-- Styles -->
    <link href="{{ asset('css/materialize.css') }}" rel="stylesheet">
    <link href="{{ asset('css/extra.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <div class="navbar-fixed">
            <nav>
                <div class="nav-wrapper valign-wrapper">
                    <a class="left btn-floating btn-small transparent sidenav-trigger" data-target="slide-out" style="margin-left: 24px;margin-right: 24px;box-shadow: none;display: inherit;"><i class="material-icons">menu</i></a>
                    <span class="brand-logo center">Tectro</span>
                </div>
            </nav>
        </div>
        <ul id="slide-out" class="sidenav">
            <li><a href="#!"><i class="material-icons">home</i>Inicio</a></li>
            <li><a href="{{route('receipts.index')}}"><i class="material-icons">assignment</i>Recepciones</a></li>
            <li><a href="{{route('clients.index')}}"><i class="material-icons">person</i>Clientes</a></li>
            <div class="divider"></div>
            <li><a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="material-icons">exit_to_app</i>Cerrar sesión</a></li>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </ul>
        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('js/materialize.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('.sidenav').sidenav();
            $('.modal').modal();
        });
    </script>
</body>
</html>