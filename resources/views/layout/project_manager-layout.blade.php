<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title') - Project Manager</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/base.css') }}">

    @yield('head')

    {{-- Navbar --}}
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }

        /* Navbar */
        nav {
            background: #222;
            padding: 0 15px;
            max-width: 900px;
            margin: 0px auto;
            font-family: Arial, sans-serif;
            z-index: 9999;
        }

        nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
            z-index: 9999;
        }

        nav > ul > li {
            display: inline-block;
            position: relative;
            z-index: 9999;
        }

        nav a {
            display: block;
            padding: 12px 15px;
            color: #fff;
            text-decoration: none;
            white-space: nowrap;
            z-index: 9999;
        }

        nav a:hover {
            background: #444;
            z-index: 9999;
        }

        /* Dropdowns */
        nav ul ul {
            display: none;
            position: absolute;
            background: #333;
            min-width: 180px;
            top: 100%;
            left: 0;
            z-index: 9999;
        }

        nav ul ul li {
            position: relative;
            z-index: 9999;
        }

        nav ul li:hover > ul {
            display: block;
            z-index: 9999;
        }

        /* Nested dropdowns (right side) */
        nav ul ul ul {
            top: 0;
            left: 100%;
            z-index: 9999;
        }

    </style>

    {{-- Main --}}
    <style>
        .main {
            max-width: 900px;
            margin: 0px auto;
            font-family: Arial, sans-serif;
            padding: 10px;
        }
    </style>

    {{-- Message --}}
    <style>
        .message { 
            max-width: 900px;
            margin: 0px auto;
            font-family: Arial, sans-serif;
            padding: 5px 15px;
            font-weight: bold;
            background-color: rgb(235, 255, 122);
            text-align: center;
        }
    </style>
</head>
<body>

<nav>
    <ul>
        <!-- Dashboard -->
        <li>
            <a href="{{route('pm.dashboard')}}">Dashboard</a>
        </li>
        <!-- Team -->
        <li>
            <a href="#">Team</a>
            <ul>
                <!-- Project Managers -->
                <li>
                    <a href="{{route('pm.developers')}}">Developers</a>
                    <a href="{{route('pm.testers')}}">Testers</a>
                </li>
            </ul>
        </li>
        <!-- Project -->
        <li>
            <a href="{{route('pm.projects')}}">Projects</a>
        </li>
        <!-- Logout -->
        <li>
            <form action="/logout" method="post">
                @csrf
                <button type="submit">Logout</button>
            </form>
        </li>

    </ul>
</nav>

@if(session('success'))
<p class="message">{{session('success')}}</p>
@endif

<div class="main">
    @yield('main')
</div>

<script src="{{asset('js/base.js')}}"></script>
@yield('script')
</body>
</html>
