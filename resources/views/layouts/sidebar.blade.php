<style>
    .sidebar {
        position: fixed;
        top: 55px;
        bottom: 0;
        left: 0;
        width: 200px;
        z-index: 50; /* Behind the navbar */
        padding: 0px 0 0; /* Height of navbar */
        box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
    }

    .feather{
        vertical-align: text-bottom;
        padding: 3px;
    }

    .sidebar-sticky {
        background-color: #3490dc;
        position: relative;
        top: 0;
        height: calc(100vh - 55px);
        padding-top: .5rem;
        overflow-x: hidden;
        overflow-y: auto; /* Scrollable contents if viewport is shorter than content. */
    }

    .sidebar .nav-link {
        font-weight: 500;
        color: whitesmoke;
        font-size: medium;
        text-transform: uppercase;
    }

    .sidebar .navbar-text
    {
        font-weight: bold;
        color: black;
        font-size: large;
        text-transform: uppercase;
        text-align: center;
        padding-left: 50px;
    }

    .sidebar .nav-link .feather {
        margin-right: 4px;
        color: lightgray;
    }

    .sidebar .nav-link.active {
        color:  #23272b;
        font-size: medium;
        font-weight: bold;
        transition: 0.35s;
    }

    .sidebar .nav-link:hover .feather,
    .sidebar .nav-link.active .feather {
        color: inherit;
    }

    hr.line {
        border: 1px solid whitesmoke;
    }
</style>
<div class="sidebar-wrapper">
    <div class="container-fluid">
        <div class="row">
            <nav class="sidebar">
                <div class="sidebar-sticky">
                    <ul class="nav flex-column pt-1 pb-1">
                        @if(Auth::guard('admin')->check())
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                                <span data-feather="layers"></span>
                                Dashboard
                            </a>
                        </li>
                        @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dashboard') }}">
                                <span data-feather="layers"></span>
                                Dashboard
                            </a>
                        </li>
                        @endif
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('products.index') }}">
                                <span data-feather="package"></span>
                                Products
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('godowns.index') }}">
                                <span data-feather="home"></span>
                                Godowns
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('clients.index') }}">
                                <span data-feather="briefcase"></span>
                                Clients
                            </a>
                        </li>
                        @if(Auth::guard('admin')->check())
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.entries.index') }}">
                                <span data-feather="file-plus"></span>
                                Entries
                            </a>
                        </li>
                        @endif
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('invoices.index') }}">
                                <span data-feather="file-text"></span>
                                Invoices
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('payments.index') }}">
                                <span data-feather="dollar-sign"></span>
                                Payments
                            </a>
                        </li>
                        @if(Auth::guard('admin')->check())
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.users.index') }}">
                                <span data-feather="users"></span>
                                Employees
                            </a>
                        </li>
                        @endif
                        @if(Auth::guard('admin')->check())
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.accounts.index') }}">
                                <span data-feather="user"></span>
                                Admins
                            </a>
                        </li>
                        @endif
                        @if(Auth::guard('admin')->check())
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.cash-register.index') }}">
                                <span data-feather="inbox"></span>
                                Cash Register
                            </a>
                        </li>
                        @endif
                    </ul>
                    <hr class="line">
                    <ul class="nav flex-column pt-1 pb-1">
                        <li class="nav-item">
                            <h4 id="balance" class="navbar-text" href="#"></h4>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('.nav-link').filter(function(){return this.href===location.href}).addClass('active');
        $('.nav-link').click(function () {
            $(this).addClass('active');
        });

        var _token = $('input[name="_token"]').val();

        $.ajax({
            url:"{{route('sidebar.balance')}}",
            method:"POST",
            data:{ _token:_token },
            success:function (response) {
                $('#balance').html('Balance: <br>'+response);
            }
        });
    });
</script>
