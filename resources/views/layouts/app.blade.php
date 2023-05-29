<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'multitubeMP3') }} | @yield('title')</title>

    <meta name="viewport"           content="user-scalable=no, width=device-width,initial-scale=1">
    <meta name="description"        content="@yield('descripcion')">
    <meta name="keywords"           content="descargar gratis, @yield('title') descargar gratis, descargar mega,angular,aplicacion,aplicacion web,desarrollo web, descargas, Descarga múltiple de videos de youtube,Descarga múltiple de videos de youtube en formato MP3, mp3, musica de youtube">
    <!--Facebook-->
    <meta property="og:url"         content="{{ __(url()->full()) }}">
    <meta property="og:type"        content="website">
    <meta property="og:title"       content="multitubeMP3 | @yield('title')">
    <meta property="og:description" content="@yield('descripcion') ">
    <meta property="og:image"       content="{{ asset('images/banner/logo-original.png') }}">
    <!--twitter-->
    <meta property="twitter:url"    content="{{ __(url()->full()) }}">
    <meta name="twitter:card"       content="summary" />
    <meta name="twitter:site"       content="multitubeMP3" />
    <meta name="twitter:title"      content="multitubeMP3 |  @yield('title')">
    <meta name="twitter:description"content="@yield('descripcion') ">
    <meta name="twitter:image"      content="{{ asset('images/banner/logo-original.png') }}">
    <!--Iconos-->
    <link rel="img_scr"             href="{{ asset('images/banner/logo-original.png') }}">
    <link rel="image_src"           href="{{ asset('images/banner/logo-original.png') }}">
    <link rel="shortcut icon"       href="{{ asset('images/favicon/favicon.ico')      }}">
    <!--Estilos-->
    <link href="{{ asset('css/bootstrap.min.css')     }}" rel="stylesheet">
    <link href="{{ asset('css/app.css')               }}" rel="stylesheet">
    <link href="{{ asset('css/main.css')              }}" rel="stylesheet">
    <link rel="stylesheet"          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet"          href="https://fonts.googleapis.com/icon?family=Material+Icons" >
    <!--JavaScript-->
    <script src="{{ asset('js/jquery-3.3.1.slim.js')    }}" defer></script>
    <script src="{{ asset('js/popper.min.js')           }}" defer></script>
    <script src="{{ asset('js/bootstrap.min.js')        }}" defer></script>
    <script src="{{ asset('js/smooth-scroll.polyfills.min.js') }}" defer></script>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
</head>

@include('layouts/header')

<body id="body" class="bg-blue-50 container-full-page row p-0 m-0 justify-content-center">
<div class="row container justify-content-center">
    @if( in_array(Request::path(),['login','register']))
        <main id="main" class="col-12 col-sm-8 col-md-8 col-lg-5 justify-content-center my-4">
            <div class="rounded-xl sm:rounded shadow-xl bg-white py-4">
                @yield('content')
            </div>
        </main>
    @else
        <main id="main" class="col-12 col-md-8 justify-content-center my-4">
            <div class="rounded-xl sm:rounded shadow-xl bg-white py-4">
                @yield('content')
            </div>
        </main>
        <aside class="col-12 col-md-4 aside  align-self-start">
            @include('layouts/aside')
        </aside>
    @endif
</div>
</body>
<script src="{{ asset('js/devbrary.js')             }}" defer></script>
<script src="{{ asset('js/mdtoast.min.js')          }}" defer></script>
<script src="{{ asset('js/plugin-min.js')           }}" defer></script>
<script src="{{ asset('js/custom-min.js')           }}" defer></script>

@include('layouts/scripts')

@include('layouts/footer')

</html>
