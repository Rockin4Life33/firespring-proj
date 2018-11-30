@if ($next !== null || $previous !== null)
  <br />
  <div class="text-center">
    @if ($previous !== null)
      <a href="{{ route('starwars.planetResidents', $previous) }}">&laquo; &nbsp; Previous &nbsp;</a>
    @endif
    &nbsp;
    @if ($next !== null)
      <a href="{{ route('starwars.planetResidents', $next) }}">&nbsp; Next &nbsp; &raquo;</a>
    @endif
  </div>
@endif
