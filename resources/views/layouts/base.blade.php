<!--
=========================================================
* Argon Dashboard - v1.2.0
=========================================================
* Product Page: https://www.creative-tim.com/product/argon-dashboard


* Copyright  Creative Tim (http://www.creative-tim.com)
* Coded by www.creative-tim.com



=========================================================
* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
    <link rel="icon" href="{{ asset('icon.png') }}">


    <title>
        @yield('title')
    </title>

    @vite(['resources/css/app.css', 'resources/scss/app.scss'])


    <!-- Specific CSS goes HERE -->

    
</head>

<body class="">

    @include("layouts.sidenav")

    <div class="main-content" id="panel">

        @include("layouts.navbar")

        @yield('main')

    </div>

    <!-- Specific JS goes HERE -->
    @vite(['resources/js/app.js'])

    @yield('scripts')

</body>

</html>
