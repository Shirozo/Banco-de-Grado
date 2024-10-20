<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>
        @yield('title')
    </title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="">
    <nav class="navbar-main">
        <div class="nav-title">
            <h1>Banco De Grado</h1>
        </div>
        <div class="log-in">
            <a href="#">Log In</a>
        </div>
    </nav>
    <div class="main-content">
        <div class="main-left">
            <h1>Where Every Grade Tells Your Story</h1>
        </div>
        <div class="main-right">
            <div class="card-container">
                <div class="card">
                    <div class="card-title">
                        <h1>2000</h1>
                    </div>
                    <div class="count">
                        <h3>Story Happening</h3>
                    </div>
                </div>
                <div class="card">
                    <div class="card-title">
                        <h1>140</h1>
                    </div>
                    <div class="count">
                        <h3>Destroyed Story</h3>
                    </div>
                </div>
                <div class="card">
                    <div class="card-title">
                        <h1>40</h1>
                    </div>
                    <div class="count">
                        <h3>Story Saved</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            console.log($("#here"));
        })
    </script>
</body>

</html>
