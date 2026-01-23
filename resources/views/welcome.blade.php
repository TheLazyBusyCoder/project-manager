<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Project Manager Tool</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background: #f7f7f7;
            color: #333;
        }

        header {
            background: #222;
            color: #fff;
            padding: 12px 20px;
        }

        main {
            padding: 20px;
        }

        h1, h2 {
            margin-top: 0;
        }

        .card {
            background: #fff;
            padding: 15px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
        }

        ul {
            padding-left: 18px;
        }

        footer {
            text-align: center;
            padding: 10px;
            font-size: 12px;
            color: #777;
        }
    </style>
    {{-- Form CSS --}}
    <style>
        input, select, button {
            padding: 6px;
            margin-bottom: 8px;
            font-size: 14px;
        }
        .form {
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>
<body>

<header>
    <h1>Project Manager Tool</h1>
    <p>Simple. Structured. Scalable.</p>
</header>

<main>
    <div class="card">
        <div class="form">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <h2>Login</h2>

                @error('email')
                    <p style="color:red">{{ $message }}</p>
                @enderror

                <input 
                    type="email" 
                    name="email" 
                    placeholder="Email"
                    value="{{ old('email') }}"
                    required
                >
                <br>

                <input 
                    type="password" 
                    name="password" 
                    placeholder="Password"
                    required
                >
                <br>

                <button type="submit">Login</button>
            </form>
        </div>
    </div>
</main>

<footer>
    © 2026 Project Manager Tool
</footer>

</body>
</html>
