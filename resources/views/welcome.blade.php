<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>
    <body>
        <div class="container py-5">
            <div class="jumbotron text-center">
                <h1 class="display-4">WELCOME TO LISA ENTERPRISE</h1>
                <p class="lead"><i>a concern of M/S Aman & Brothers</i></p>
                <hr class="my-4">
                <h2 class="pb-3">Please Login to use the System</h2>
                <p class="lead">
                  <a class="btn btn-dark btn-lg" href="{{ route('admin.login') }}" role="button">Admin Login</a>
                  <a class="btn btn-primary btn-lg" href="{{ route('login') }}" role="button">Employee Login</a>
                </p>
            </div>
        </div>
    </body>
</html>
