<nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    @auth
        <div class="collapse navbar-collapse justify-content-center mr-5" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item @yield('home-active')">
                    <a class="nav-link" href="{{ url('/') }}">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item @yield('deposit-active')">
                    <a class="nav-link" href="{{ url('/deposit') }}">Deposit</a>
                </li>
                <li class="nav-item @yield('draft-active')">
                    <a class="nav-link " href="{{ url('/draft') }}">Draft</a>
                </li>
                <li class="nav-item @yield('transfer-active')">
                    <a class="nav-link" href="{{ url('/transfer') }}">Transfer</a>
                </li>
                <li class="nav-item @yield('report-active')">
                    <a class="nav-link" href="{{ url('/report') }}">Account statement</a>
                </li>
                <li class="nav-item @yield('backup-active')">
                    <a class="nav-link" href="{{ url('/backup') }}">Backup/Restore your data</a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ \Illuminate\Support\Facades\Auth::user()->name }}
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ url('/logout') }}">Logout</a>
                    </div>
                </li>
            </ul>
        </div>
    @endauth

    @guest
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item text-right">
                    <a class="nav-link" href="{{ url('/login') }}">Login</a>
                </li>
            </ul>
        </div>
    @endguest
</nav>
