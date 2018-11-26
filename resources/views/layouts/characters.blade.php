@extends('master')

@section('content')
  @if($characters !== null && count($characters) > 0)
    <link rel="stylesheet"
          type="text/css"
          href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" />
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
          {{--<th>Films</th>--}}
          {{--<th>Species</th>--}}
          {{--<th>Starships</th>--}}
          {{--<th>Vehicles</th>--}}
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
            <th>{{ $character->homeworld->name ?? '' }}</th>
            {{--<th>{{ array_reduce($character->films, function($film) { return "<pre>$film->title</pre>"; }) }}</th>--}}
            {{--<th>{{ $character->species }}</th>--}}
            {{--<th>{{ $character->starships }}</th>--}}
            {{--<th>{{ $character->vehicles }}</th>--}}
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
          {{--<th>Films</th>--}}
          {{--<th>Species</th>--}}
          {{--<th>Starships</th>--}}
          {{--<th>Vehicles</th>--}}
        </tr>
      </tfoot>
    </table>
  @else
    @includeIf('partials._empty-data-set')
  @endif
@endsection

@section('scripts')
  <script>
    $( document ).ready( () => {
      // $( '#characters' ).DataTable( {} );
      $( '#characters' ).DataTable( {
        'columnDefs': [
          {
            'targets': 'nosort',
            'sortable': false,
            'orderable': false,
            'searchable': false
          }
        ]
      } ).column( 1 ).order( 'asc' ).draw();
      // $( 'select' ).addClass( 'mdb-select' );
      // $('.mdb-select').material_select();
    } );
  </script>

  <style>
    table.dataTable thead .sorting:before,
    table.dataTable thead .sorting:after,
    table.dataTable thead .sorting_asc:before,
    table.dataTable thead .sorting_asc:after,
    table.dataTable thead .sorting_desc:before,
    table.dataTable thead .sorting_desc:after {
      padding: 5px;
    }

    .dataTables_wrapper .mdb-select {
      border: none;
    }

    .dataTables_wrapper .mdb-select.form-control {
      padding-top: 0;
      margin-top: -1rem;
      margin-left: 0.7rem;
      margin-right: 0.7rem;
      width: 100px;
    }

    .dataTables_length label {
      display: flex;
      justify-content: left;
    }

    .dataTables_filter label {
      margin-bottom: 0;
    }

    .dataTables_filter label input.form-control {
      margin-top: -0.6rem;
      padding-bottom: 0;
    }

    table.dataTable {
      margin-bottom: 3rem !important;
    }

    div.dataTables_wrapper div.dataTables_info {
      padding-top: 0;
    }
  </style>
@endsection
