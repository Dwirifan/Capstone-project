<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Daftar dengan Google</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body { font-family: sans-serif; padding: 2rem; background-color: #f9f9f9; }
        .container { max-width: 600px; margin: auto; text-align: center; padding: 2rem; background: white; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        a.button {
            display: inline-block;
            background-color: #4285F4;
            color: white;
            padding: 12px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
        }
        a.button:hover { background-color: #357ae8; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Registrasi dengan Google</h2>
        <p>Silakan daftar menggunakan akun Google Anda</p>
        <a class="button" href="{{ url('/register/google') }}">Login dengan Google</a>
    </div>
</body>
</html>
