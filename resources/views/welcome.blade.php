<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Project Manager Tool</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Bootstrap --}}
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">

    {{-- Base Theme --}}
    <link rel="stylesheet" href="{{ asset('css/base.css') }}">
</head>
<body>

<div class="min-vh-100 d-flex align-items-center justify-content-center">

    <div class="col-11 col-sm-8 col-md-5 col-lg-4">

        <div class="card">
            <div class="card-body p-4">

                <div class="text-center mb-4">
                    <h1 class="h4 fw-bold mb-1">Project Manager</h1>
                    <p class="text-muted mb-0">
                        Simple. Structured. Scalable.
                    </p>
                </div>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    {{-- Email --}}
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input
                            type="email"
                            name="email"
                            class="form-control"
                            placeholder="you@example.com"
                            value="{{ old('email') }}"
                            required
                        >
                        @error('email')
                            <div class="text-danger small mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input
                            type="password"
                            name="password"
                            class="form-control"
                            placeholder="••••••••"
                            required
                        >
                    </div>

                    {{-- Submit --}}
                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary">
                            Login
                        </button>
                    </div>
                </form>

            </div>
        </div>

        <p class="text-center text-muted small mt-3">
            © 2026 Project Manager Tool
        </p>

    </div>
</div>

<script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
