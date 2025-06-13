<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-lg-5">
      <div class="card shadow">
        <div class="card-body">

          <h3 class="mb-4">Login</h3>

          @auth
            <p>Halo, {{ auth()->user()->name }}</p>
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit" class="btn btn-danger w-100">Logout</button>
            </form>
          @else
            <a href="{{ route('login.google') }}" class="btn btn-danger w-100">Login with Google</a>
          @endauth

        </div>
      </div>
    </div>
  </div>
</div>

</body>
</html>
