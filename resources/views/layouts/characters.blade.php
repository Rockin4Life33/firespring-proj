@extends('master')

@section('content')
  @if($characters !== null && count($characters) > 0)
    <table id="characters" class="table table-striped table-bordered" cellspacing="0" width="100%">
      <thead>
        <tr>
          <th>Name</th>
          <th>Birth Year</th>
          <th>Gender</th>
          <th>Hair Color</th>
          <th>Height</th>
          <th>Mass</th>
          <th>Skin Color</th>
          <th>Home World</th>
          <th>Species</th>
          <th>Film Count</th>
          <th>Starship Count</th>
          <th>Vehicle Count</th>
        </tr>
      </thead>

      <tbody>
        @foreach($characters as $character)
          <tr>
            <th>
              <a href="{{ route('starwars.character', \_\split($character->name, ' ', 1)) }}">
                {{ $character->name }}
              </a>
            </th>
            <th>{{ $character->birth_year }}</th>
            <th>{{ $character->gender }}</th>
            <th>{{ $character->hair_color }}</th>
            <th>{{ $character->height }}</th>
            <th>{{ $character->mass }}</th>
            <th>{{ $character->skin_color }}</th>
            <th>{{ $character->homeworld ?? '' }}</th>
            <th>{{ $character->species }}</th>
            <th>{{ \count($character->films) }}</th>
            <th>{{ \count($character->starships) }}</th>
            <th>{{ \count($character->vehicles) }}</th>
          </tr>
        @endforeach
      </tbody>
    </table>
    <br />
    @if ($next !== null || $previous !== null)
      <br />
      <div class="text-center">
        @if ($previous !== null)
          <a href="{{ route('starwars.characters', $previous) }}">&laquo; &nbsp; Previous &nbsp;</a>
        @endif
        &nbsp;
        @if ($next !== null)
          <a href="{{ route('starwars.characters', $next) }}">&nbsp; Next &nbsp; &raquo;</a>
        @endif
      </div>
    @endif
  @else
    @includeIf('partials._empty-data-set')
  @endif
@endsection

@section('scripts')
  @if($characters !== null && count($characters) > 0)
    <script>
      $( document ).ready( () => {
        $( '#characters' ).DataTable( {
          'searching': false
        } );
        $( '#characters_wrapper' ).children( 0 )[ 0 ].remove();
      } );
    </script>
  @endif
@endsection
