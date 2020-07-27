<!DOCTYPE html>
<html>
    <head>

        <meta charset="UTF-8">
        <title>{{ config('app.name') }}</title> 

        <link rel='icon' href="{{ asset('imgs/favicon.png') }}">
        <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.6.3/css/all.css' 
            integrity='sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/' 
            crossorigin='anonymous'>
        
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('css/padrao.css') }}">


        <script src="{{ asset('js/app.js') }}" defer></script>
        <script src="{{ asset('js/custom/custom.js') }}"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>


        <style>
            html, body {

                padding-bottom: 0rem;
                background-image: url("imgs/telafundo.png");
                -webkit-background-size: cover;
                -moz-background-size: cover;
                -o-background-size: cover;

                background-size: cover;
                background-repeat: no-repeat;
                background-position: center;
                background-attachment: fixed;
            }

        </style>   
    </head>

    <body>
    <div id="app">

        @include('layouts.menu')
        @include('layouts.infoone')

        
        @yield('header')
        @yield('content')

        <footer>
        <div class="col-md-12 offset-md-0" style="padding-left:0; padding-right:0;">    
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="height:33px">

            </nav>
        </div>
        </footer>
    </div>
</body>
</html>
