<!DOCTYPE html>
<html>
<head>
  <title>Home</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container">
    <h1>Selamat Datang, {{ auth()->user()->name }}</h1>
    <p>Email: {{ auth()->user()->email }}</p>
    <form action="{{ route('logout') }}" method="POST">
      @csrf
      <button type="submit" class="btn btn-danger">Logout</button>
    </form>
  </div>
</body>
</html>
