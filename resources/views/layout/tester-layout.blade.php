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
            /* max-width: 900px; */
            display: flex;
            justify-content: center;
            align-items: center;
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

    <style>

        /* MESSAGE */
        .message {
            max-width: 900px;
            margin: 10px auto;
            background: #ffffff;
            text-align: center;
            font-weight: bold;
            color: black;
        }

        /* GRID LAYOUT */
        .layout {
            /* max-width: 900px; */
            margin: auto;
            display: grid;
            grid-template-columns:  1fr;
        }

        .tree {
            background: #fff;
            border-right: 1px solid #ddd;
            padding: 10px;
            overflow-y: auto;
        }

        /* HISTORY */
        .history {
            background: #fff;
            font-size: 14px;
            text-align: center;
        }

        .history h4 {
            margin-top: 0;
        }

        .history a {
            display: block;
            color: #555;
            text-decoration: none;
            margin-bottom: 5px;
        }

        .history a:hover {
            text-decoration: underline;
        }

    </style>
</head>
<body>

    <nav class="navbar">
        <ul>
            <li><a href="{{route('tester.dashboard')}}">Dashboard</a></li>
            <li><a href="{{route('tester.tasks')}}">Tasks</a></li>
            <li>
                <form action="/logout" method="post">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
            </li>
        </ul>
    </nav>

    @if(session('success'))
        <div class="message">{{ session('success') }}</div>
    @endif

<div class="layout">
    <main class="main">
        @yield('main')
    </main>
</div>


    <script src="{{asset('js/base.js')}}"></script>
    @yield('script')
</body>

</html>
