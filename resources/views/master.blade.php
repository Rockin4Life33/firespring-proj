<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
  @include('partials._header')
</head>
<body>
<div id="wrapper">
  {{--@include('partials._nav', ['navItems' => session(SES_USER) ? NAV_ITEMS_AUTH : NAV_ITEMS])--}}

  <div class="container" style="margin:80px auto 0 auto;padding:50px 5px;">
    @if(session('info'))
      <div id='alert-container' class="alert alert-{{ session('alert') ?? 'info' }} alert-dismissible fade show"
           role="alert">
        <b>{{ session('info') }}</b>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    @endif

    @yield('content')
  </div>

  @include('partials._footer')
</div>
</body>
@yield('scripts')

<script>
  // Auto dismiss alerts if applicable
  const alertContainer = document.getElementById( 'alert-container' );
  if ( alertContainer )
    window.setTimeout( () => {
      if ( alertContainer )
        alertContainer.alert( 'close' );
    }, 5000 );
</script>
</html>
