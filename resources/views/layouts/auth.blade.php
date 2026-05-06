<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Login - PT WAGS')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            background-color: var(--bg);
        }

        .login-container {
            width: 100%;
            max-width: 480px;
            padding: 1.5rem;
            animation: fadeIn 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .login-card {
            background: var(--card-bg);
            padding: 2rem;
            border-radius: var(--radius);
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--border);
            text-align: center;
        }

        @media (max-width: 480px) { 
            .login-card {
                padding: 1.5rem;
            } 
        } 
    </style>
</head>
<body>
    <div class="login-container">
        @yield('content')
    </div>
    <script>
        lucide.createIcons();
    </script>
</body>
</html>
