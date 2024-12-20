<nav class="navbar-main">
    <div class="nav-title nav-nav">
        @yield('back')
        <h1>Banco De Grado</h1>
    </div>
    <div class="middle-nav">
        <p>Simplifying grade tracking for educators and students</p>
    </div>
    <div class="nav-right">
        <a href="{{ route('loginPage') }}">
            @if (Auth::user())
                <button class="login-index">Dashboard</button>
            @else
                <button class="login-index">Log In</button>
            @endif
        </a>
    </div>
</nav>
