<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ asset('js/feather.min.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @toastr_css
    <style>
        .content-wrapper{
            padding-left: 230px;
            padding-top: 60px;
            /* Space for fixed navbar */
        }
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            background-color:  transparent;
            text-align: center;
            padding-left: 230px;
        }
        .table-responsive-lg{
            overflow-x: scroll;
        }

        @media print {
            body div.container{
                margin-left: 0.5cm;
                margin-top: 0.5cm;
            }
            .btn{
                display: none !important;
            }
            .sidebar{
                display: none !important;
            }
            .card{
                border: transparent !important;
            }
            @media print {
                input{
                    border: 0;
                    text-align: right;
                }
                select{
                    border: 0;
                    appearance: none;
                }
                .btn{
                    display: none;
                }
                hr{
                    display: none;
                }
            }
        }
    </style>
    @yield('style')
</head>
<body>
    <div id="app">
        <header>
            <div>
                @include('layouts.navbar')
            </div>
            @auth
            <div>
                @include('layouts.sidebar')
            </div>
            @endauth
        </header>

        <main class="py-4">
            <div class="content-wrapper">
                @yield('content')
            </div>
        </main>

        <footer class="footer">
            <div class="container">
                <div class="col-sm">
                    <span class="text-muted">Copyright&copy;Kamrul Haque</span>
                </div>
            </div>
        </footer>
    </div>
</body>
<script>
    feather.replace();
</script>
<script type="text/javascript">
    $(function () {
        $(document).on('input','#search',function () {
            var value = $(this).val();
            if (value)
            {
                $('#date').attr('disabled',true);
            }
            else
            {
                $('#date').attr('disabled',false);
            }
        });
        $(document).on('input','#date',function () {
            var value = $(this).val();
            if (value)
            {
                $('#search').attr('disabled',true);
            }
            else
            {
                $('#search').attr('disabled',false);
            }
        });
    });
</script>
@jquery
@toastr_js
@toastr_render
@yield('script')
</html>
