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
            background-color: #f1f3f1; /* Light grey background from login.png */
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
        }
        .login-card {
            background: white;
            padding: 3rem;
            border-radius: 24px; /* More rounded as in login.png */
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
            width: 100%;
            max-width: 450px;
            text-align: center;
            animation: fadeIn 0.5s ease-out;
        }
    </style>
</head>
<body>
    @yield('content')
    <script>
        lucide.createIcons();
    </script>
</body>
</html>
