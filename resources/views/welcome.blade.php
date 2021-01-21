<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="theme-color" content="#009688" />

        <title>Tectro</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700" rel="stylesheet"> 

        <!-- Styles -->
        <link href="{{ asset('css/materialize.css') }}" rel="stylesheet">
        <link href="{{ asset('css/extra.css') }}" rel="stylesheet">
    </head>
    <body class="blue darken-3">
        <div class="container full-height valign-wrapper">
            <div class="row no-margin">
                <div class="col m6 offset-m3 s12">
                    <div class="row">
                        <form class="col s12" method="POST" action="{{ route('login') }}">
                            <h5 class="white-text center">Inicio de sesión</h5>
                            @csrf
                            <div class="row">
                                <div class="input-field col s12">
                                    <input id="email" type="email" class="validate" name="email" value="{{ old('email') }}" maxlength="35" required>
                                    <label class="white-text" for="email" data-error="Verifique este campo." data-success="Campo validado.">Email</label>
                                </div>
                                <div class="input-field col s12">
                                    <input id="password" type="password" class="validate" name="password" pattern=".{6,}" required>
                                    <label class="white-text" for="password" data-error="Verifique este campo." data-success="Campo validado.">Contraseña</label>
                                </div>
                                <div class="col s12 center">
                                    <button type="submit" class="btn btn-primary">
                                            <b>{{ __('Iniciar Sesión') }}</b>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
        <script src="{{ asset('js/materialize.min.js') }}"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                M.AutoInit();
            });
        </script>
    </body>
</html>