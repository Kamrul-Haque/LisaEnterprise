<style>
    .sidebar {
        position: fixed;
        top: 60px;
        bottom: 0;
        left: 0;
        width: 230px;
        z-index: 50; /* Behind the navbar */
        padding: 0 0 0; /* Height of navbar */
    }

    .feather{
        vertical-align: text-bottom;
        padding: 3px;
    }

    .sidebar-sticky {
        background-color: #23272c;
        position: relative;
        height: 100vh;
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
        color:  lightseagreen;
        font-size: medium;
        font-weight: bold;
        transition: 0.35s;
    }

    .sidebar .nav-link:hover .feather,
    .sidebar .nav-link.active .feather {
        color: inherit;
    }

    hr.line {
        border: 1px solid darkgray;
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
                            <a class="nav-link {{ Request::is('admin') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                                <span data-feather="layers"></span>
                                Dashboard
                            </a>
                        </li>
                        @else
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                                <span data-feather="layers"></span>
                                Dashboard
                            </a>
                        </li>
                        @endif
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('products*') ? 'active' : '' }}" href="{{ route('products.index') }}">
                                <span data-feather="package"></span>
                                Products
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('godowns*') ? 'active' : '' }}" href="{{ route('godowns.index') }}">
                                <span data-feather="archive"></span>
                                Godowns
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('product-transfers*') ? 'active' : '' }}" href="{{ route('product-transfers.index') }}">
                                <span data-feather="log-out"></span>
                                Transfers
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('clients*') ? 'active' : '' }}" href="{{ route('clients.index') }}">
                                <span data-feather="briefcase"></span>
                                Clients
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('suppliers*') ? 'active' : '' }}" href="{{ route('suppliers.index') }}">
                                <span data-feather="truck"></span>
                                Suppliers
                            </a>
                        </li>
                        @if(Auth::guard('admin')->check())
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('entries*') ? 'active' : '' }}" href="{{ route('entries.index') }}">
                                <span data-feather="file-plus"></span>
                                Entries
                            </a>
                        </li>
                        @endif
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('sale*') ? 'active' : '' }}" href="{{ route('product.sales') }}">
                                <span data-feather="dollar-sign"></span>
                                Sales
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('invoices*') ? 'active' : '' }}" href="{{ route('invoices.index') }}">
                                <span data-feather="file-text"></span>
                                Invoices
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('client-payment*') ? 'active' : '' }}" href="{{ route('client-payment.index') }}">
                                <span data-feather="plus-square"></span>
                                Client Payments
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('supplier-payment*') ? 'active' : '' }}" href="{{ route('supplier-payment.index') }}">
                                <span data-feather="minus-square"></span>
                                Supplier Payments
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('cash-register*') ? 'active' : '' }}" href="{{ route('cash-register.index') }}">
                                <span data-feather="inbox"></span>
                                Cash Register
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('bank-account*') ? 'active' : '' }}" href="{{ route('bank-account.index') }}">
                                <span data-feather="home"></span>
                                Bank Accounts
                            </a>
                        </li>
                        @if(Auth::guard('admin')->check())
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('admin/users*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                                    <span data-feather="users"></span>
                                    Employees
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('admin/accounts*') ? 'active' : '' }}" href="{{ route('admin.accounts.index') }}">
                                    <span data-feather="user"></span>
                                    Admins
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('admin/trash*') ? 'active' : '' }}" href="{{ route('admin.trash') }}">
                                    <span data-feather="trash"></span>
                                    Trash
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
            </nav>
        </div>
    </div>
</div>
