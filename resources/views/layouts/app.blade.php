<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/jquery-3.1.1.min.js') }}" defer></script>
    <script src="{{ asset('js/bootstrap.min.js') }}" defer></script>
    <script src="{{ asset('js/popper.min.js') }}" defer></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}" defer></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}" defer></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}" defer></script>
    <script src="{{ asset('js/inspinia.js') }}" defer></script>


    <!-- Fonts -->

    <!-- Styles -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
    <div id="wrapper">
       @include('layouts.navbars.sidebar')
        <div id="page-wrapper" class="gray-bg">
            <div class="row border-bottom">
                <nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
                    <div class="navbar-header">
                    </div>
                    <ul class="nav navbar-top-links navbar-right">
                        <li>
                            <a href="{{ $userShop  }}">
                                <i class="fa fa-sign-out"></i> Back To Shopify
                            </a>
                        </li>
                    </ul>

                </nav>
            </div>
            <div style="min-height: 100%">
            @yield('content')
            </div>
            <div class="footer">
                <div>
                    <strong>Copyright</strong> Simplepost &copy; <?php echo date("Y") ?>
                </div>
            </div>
        </div>
    </div>
@stack('js')
</body>
</html>
