<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>
        @yield('title')
    </title>

    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/scss/app.scss'])

</head>

<body class="">
    <nav class="navbar-main">
        <div class="nav-title">
            <h1>Banco De Grado</h1>
        </div>
    </nav>
    <div class="login-main-content">
        <form class="login-form" action="{{ route('login') }}" method="POST">
            @csrf
            <div class="login-title">
                <h1>LOG IN</h1>
            </div>
            <div class="form-field">
                <label for="username">Username:</label>
                <input type="text" name="username" required class="form-control" placeholder="Enter your username">
            </div>
            <div class="form-field">
                <label for="password">Password:</label>
                <input type="password" name="password" required class="form-control" placeholder="Enter your password">
            </div>
            <button type="submit" class="form-control form-submit">
                <span>LOG IN</span>
            </button>
        </form>
    </div>
    <script>
    </script>
</body>

</html>
