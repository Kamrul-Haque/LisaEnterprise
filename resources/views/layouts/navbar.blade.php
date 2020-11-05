<style>
    nav.navbar{
        background-color:  #23272b;
        position: fixed;
        width: 100%;
        z-index: 100;
    }
    .navbar-collapse a{
        text-align: right;
    }
</style>
<nav class="navbar navbar-expand-md navbar-dark shadow-md">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ url('/') }}">{{ config('app.name') }}</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            @auth
                <ul class="navbar-nav mr-auto">
                    @if(Auth::guard('admin')->check())
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Dashboard
                                <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-left" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="#">
                                    Cash Withdrawal
                                </a>
                                <a class="dropdown-item" href="#">
                                    Cash Deposit
                                </a>
                                <a class="dropdown-item" href="{{route('invoices.create')}}">
                                    Sell Product
                                </a>
                                <a class="dropdown-item" href="{{route('admin.entries.create')}}">
                                    Entry Product
                                </a>
                                <a class="dropdown-item" href="{{route('clients.create')}}">
                                    Add Client
                                </a>
                                <a class="dropdown-item" href=" {{route('godowns.create')}}">
                                    Add Godown
                                </a>
                                <a class="dropdown-item" href="{{route('admin.accounts.create')}}">
                                    Create Admin
                                </a>
                                <a class="dropdown-item" href="{{route('admin.users.create')}}">
                                    Add Employee
                                </a>
                                <a class="dropdown-item" href="{{route('payments.create')}}">
                                    Add Payment
                                </a>
                                <a class="dropdown-item" href="{{route('quotation.print')}}">
                                    Print Quotation
                                </a>
                            </div>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#">
                                Dashboard
                                <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-left" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{route('invoices.create')}}">
                                    Sell Product
                                </a>
                                <a class="dropdown-item" href="{{route('quotation.print')}}">
                                    Print Quotation
                                </a>
                                <a class="dropdown-item" href="{{route('payments.create')}}">
                                    Add Payment
                                </a>
                                <a class="dropdown-item" href="{{route('clients.create')}}">
                                    Add Client
                                </a>
                            </div>
                        </li>
                    @endif
                </ul>
            @endauth
            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.login') }}">Admin Login</a>
                    </li>
                @else
                    <form class="mr-3" action="{{route('search')}}" method="post">
                        @csrf
                        <div class="input-group pt-1">
                            <input id="search" type="text" name="search" class="form-control" placeholder="Search" style="height: 30px">
                            <input id="date" type="date" name="date" class="form-control" style="height: 30px">
                            <div class="input-group-append">
                                <button class="btn btn-outline-dark" type="submit" style="line-height: 15px; font-size: small; color: white">
                                    <span data-feather="search" style="padding: 0; height: 15px; width: 15px; vertical-align: text-top"></span>
                                </button>
                            </div>
                        </div>
                    </form>
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{route('my.account')}}">
                                My Account
                            </a>
                            @if(Auth::guard('admin')->check())
                            <a class="dropdown-item" href="{{ route('admin.logout') }}"
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                            @else
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                            @endif
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
