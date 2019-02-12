<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Star Soft-Business Cards</title>

  @include('frontend.layouts.css')

</head>

<body id="page-top">

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-light fixed-top py-3" id="mainNav">
    <div class="container">
      <a class="navbar-brand js-scroll-trigger" href="#page-top">Star Soft Cards</a>
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto my-2 my-lg-0">
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="#about">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="#services">Services</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="#portfolio">Portfolio</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="#contact">Contact</a>
          </li>
          <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Account
              </a>
              <div class="dropdown-menu bg-dark" aria-labelledby="navbarDropdown">
                  @auth
                    <a class="dropdown-item text-primary" href="{{ route('user.home') }}">Dashboard</a>
                    <form action="{{ route('logout') }}" method="POST" id="logout">
                      @csrf
                      <a class="dropdown-item btn btn-primary text-primary" onclick="event.preventDefault(); document.getElementById('logout').submit()" href="#">Logout</a>
                    </form>
                  @else
                    <a class="dropdown-item text-primary" href="{{ route('login') }}">Login</a>
                    <a class="dropdown-item text-primary" href="{{ route('register') }}">Register</a>
                  @endauth
              </div>
            </li>
        </ul>
      </div>
    </div>
  </nav>

  @yield('page')
  
  <!-- Footer -->
  <footer class="bg-light py-5">
    <div class="container">
      <div class="small text-center text-muted">Copyright &copy; 2019 - Star Soft Cards</div>
    </div>
  </footer>

  @include('frontend.layouts.js')

</body>

</html>
