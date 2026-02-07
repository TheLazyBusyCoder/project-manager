<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title') - Project Manager</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Bootstrap --}}
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">

    {{-- Base Theme --}}
    <link rel="stylesheet" href="{{ asset('css/base.css') }}">

    @yield('head')

</head>
<body>

    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg border-bottom">
        <div class="container-fluid px-4">

            <a class="navbar-brand" href="{{ route('developer.dashboard') }}">
                Project Manager
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#pmNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="pmNavbar">
                <ul class="navbar-nav me-auto">

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('developer.dashboard') }}">
                            Dashboard
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('developer.tasks') }}">
                            Tasks
                        </a>
                    </li>
                </ul>

                <form action="/logout" method="post">
                    @csrf
                    <button class="btn btn-outline-secondary btn-sm">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    {{-- Success Toast --}}
    @if(session('success'))
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="successToast"
            class="toast text-bg-success border-0"
            role="alert"
            aria-live="assertive"
            aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    {{ session('success') }}
                </div>
                <button type="button"
                        class="btn-close btn-close-white me-2 m-auto"
                        data-bs-dismiss="toast">
                </button>
            </div>
        </div>
    </div>
    @endif


    {{-- Main Layout --}}
    <div class="container-fluid px-4 my-4">
        <div class="row g-3">
            {{-- Main Content --}}
            <main class="col">
                @yield('main')
            </main>
        </div>
    </div>

    <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{asset('js/base.js')}}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toastEl = document.getElementById('successToast');
            if (toastEl) {
                new bootstrap.Toast(toastEl, { delay: 3000 }).show();
            }
        });
    </script>
    
    @yield('script')
</body>

</html>
