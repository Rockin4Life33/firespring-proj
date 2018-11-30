<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
  @include('partials._header')
</head>
<body>
<div id="wrapper">
  <nav id="nav" class="navbar card-header navbar-light">
    <div class="mr-auto breadcrumb-dn">
      The Firespring SWAPI Project
    </div>
  </nav>

  <div class="container" style="padding:50px 5px;">
    @yield('content')
  </div>

  @include('partials._footer')
</div>
</body>
@yield('scripts')
</html>
