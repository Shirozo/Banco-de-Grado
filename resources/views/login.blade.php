<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>
        @yield('title')
    </title>

    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/scss/app.scss'])
    <script src="{{ asset('assets/js/sweetalert.min.js') }}"></script>

</head>

<body class="">
    <nav class="navbar-main">
        <div class="nav-title">
            <h1>Banco De Grado</h1>
        </div>
    </nav>
    <div class="login-main-content">
        <form class="login-form" action="{{ route('login') }}" method="POST" id="login-form">
            @csrf
            <div class="login-title">
                <h1>LOG IN</h1>
            </div>
            <div class="form-field">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" required class="form-control" placeholder="Enter your username">
            </div>
            <div class="form-field">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required class="form-control" placeholder="Enter your password">
            </div>
            <button type="submit" class="form-control form-submit">
                <span>LOG IN</span>
            </button>
        </form>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            $("#login-form").on("submit", function(e){
                e.preventDefault();
                $.ajax({
                    type: "POST",
                    url: "{{ route('login') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        username: $("#username").val(),
                        password: $("#password").val()
                    },
                    success: function(response) {
                        window.location.reload()
                    },
                    error: function(errr) {
                        swal({
                            title: "Error",
                            text: "Invalid Credentials!",
                            icon: "error",
                            button: "Close"
                        })

                    }
                })
                
            })
        })
    </script>
</body>

</html>
