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
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- <link href="{{ asset('css/extra.css') }}" rel="stylesheet"> -->
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
            <li><a class="subheader">MIS CATALOGOS</a></li>
            <li><a href="{{route('clients.index')}}"><i class="material-icons">person</i>Clientes</a></li>
            <li><a href="{{route('services.index')}}"><i class="material-icons">home_repair_service</i>Servicios</a></li>
            <li><a href="{{route('products.index')}}"><i class="material-icons">local_offer</i>Productos</a></li>
            <li><a class="subheader">PUNTO DE VENTA</a></li>
            <li><a href="{{route('sales.index')}}"><i class="material-icons">local_grocery_store</i>POS</a></li>
            <li><a href="{{route('reports.index')}}"><i class="material-icons">receipt</i>Reportes</a></li>
            <li><a class="subheader">INVENTARIO</a></li>
            <!-- <li><a href="#"><i class="material-icons">stores</i>Mis almacenes</a></li> -->
            <li><a href="{{route('inventory_entries.index')}}"><i class="material-icons">archive</i>Entradas</a></li>
            <li><a href="{{route('inventory_exits.index')}}"><i class="material-icons">unarchive</i>Salidas</a></li>
            <div class="divider"></div>
            <li><a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="material-icons">exit_to_app</i>Cerrar sesión</a></li>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </ul>
        <main>
            @yield('content')
        </main>
    </div>
    <!-- Scripts -->
    <!-- <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script> -->
    <script src="{{ asset('js/app.js') }}"></script>
    <!-- <script>
    $(function() {
        $.ajaxSetup({
            headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });
    </script> -->
</body>
</html>