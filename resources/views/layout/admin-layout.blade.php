<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <title>@yield('title') - Project Manager</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Bootstrap --}}
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">

    {{-- Base Theme --}}
    <link rel="stylesheet" href="{{ asset('css/base.css') }}">
</head>
<body>

{{-- Navbar --}}
<nav class="navbar navbar-expand-lg border-bottom">
    <div class="container">

        <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
            Project Manager
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="adminNavbar">
            <ul class="navbar-nav me-auto">

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.dashboard') }}">
                        Dashboard
                    </a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        Users
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="{{ route('admin.project-managers') }}">
                                Project Managers
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>

            {{-- Logout --}}
            <form action="/logout" method="post" class="d-flex">
                @csrf
                <button class="btn btn-outline-secondary btn-sm" type="submit">
                    Logout
                </button>
            </form>
        </div>
    </div>
</nav>

@if(session('success'))
<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="successToast"
         class="toast align-items-center text-bg-success border-0"
         role="alert"
         aria-live="assertive"
         aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                {{ session('success') }}
            </div>
            <button type="button"
                    class="btn-close btn-close-white me-2 m-auto"
                    data-bs-dismiss="toast"
                    aria-label="Close">
            </button>
        </div>
    </div>
</div>
@endif


{{-- Main --}}
<main class="container my-4">
    @yield('main')
</main>
<script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toastEl = document.getElementById('successToast');
        if (toastEl) {
            const toast = new bootstrap.Toast(toastEl, {
                delay: 3000
            });
            toast.show();
        }
    });
</script>
</body>
</html>
