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
      <div>
        <a class="m-md-3" href="{{ route( 'starwars.about' ) }}">About</a>
        <a class="m-md-3" href="{{ route( 'starwars.character' ) }}">Character</a>
        <a class="m-md-3" href="{{ route( 'starwars.characters' ) }}">Characters</a>
        <a class="m-md-3" href="{{ route( 'starwars.charactersAlt' ) }}">Characters Alt</a>
        <a class="m-md-3" href="{{ route( 'starwars.planetResidents' ) }}">Planet Residents</a>
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
