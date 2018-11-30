@extends('master')

@section('content')
  @if($characters !== null && count($characters) > 0)
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" />
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

    <table id="characters" class="table table-striped table-bordered table-responsive" cellspacing="0" width="100%">
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

      <tfoot>
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
      </tfoot>
    </table>
  @else
    @includeIf('partials._empty-data-set')
  @endif
@endsection

@section('scripts')
  @if($characters !== null && count($characters) > 0)
    <script>
      $( document ).ready( () => {
        $( '#characters' ).DataTable( {} );
        $('.dataTables_length').addClass('bs-select');
      } );
    </script>
  @endif
@endsection
