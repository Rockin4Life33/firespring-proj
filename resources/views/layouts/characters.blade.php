@extends('master')

@section('content')
  @if($characters !== null && count($characters) > 0)
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css"/>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>

    @foreach($characters as $character)
{{--      {!! json_encode($character) !!}--}}
      @foreach($character as $key => $value)
        {!! json_encode($key) . ': ' . json_encode($value) . '<br/>' !!}
      @endforeach
      {!! '<br />' !!}
    @endforeach

    {{--<table id="characters" class="table table-striped table-bordered table-responsive" cellspacing="0" width="100%">--}}
      {{--<thead>--}}
      {{--<tr>--}}
        {{--<th>Tag Number</th>--}}
        {{--<th>Tag Color</th>--}}
        {{--<th>Date of Birth</th>--}}
        {{--<th>Gender</th>--}}
        {{--<th>Sire</th>--}}
        {{--<th>Pasture</th>--}}
        {{--<th>Comments</th>--}}
        {{--<th>Herd</th>--}}
      {{--</tr>--}}
      {{--</thead>--}}

      {{--<tbody>--}}
      {{--@foreach($characters as $character)--}}
        {{--<tr>--}}
          {{--<th><a href="{{ route('animal.edit', $character->id) }}">{{ $character->tag_number }}</a></th>--}}
          {{--<th>{{ $character->tag_color }}</th>--}}
          {{--<th>{{ date( 'm/d/y h:m A', strtotime( $character->date_of_birth ) ) }}</th>--}}
          {{--<th>{{ $character->gender }}</th>--}}
          {{--<th>{{ $character->sire }}</th>--}}
          {{--<th>{{ $character->pasture }}</th>--}}
          {{--<th>{{ $character->comments }}</th>--}}
          {{--<th>{{ $character->herd_id }}</th>--}}{{-- TODO: Updated this to display the herd.name for the given animal.herd_id --}}
        {{--</tr>--}}
      {{--@endforeach--}}
      {{--</tbody>--}}

      {{--<tfoot>--}}
      {{--<tr>--}}
        {{--<th>Tag Number</th>--}}
        {{--<th>Tag Color</th>--}}
        {{--<th>Date of Birth</th>--}}
        {{--<th>Gender</th>--}}
        {{--<th>Sire</th>--}}
        {{--<th>Pasture</th>--}}
        {{--<th>Comments</th>--}}
        {{--<th>Herd</th>--}}
      {{--</tr>--}}
      {{--</tfoot>--}}
    {{--</table>--}}
  @else
    @includeIf('partials._empty-data-set')
  @endif
@endsection

@section('scripts')
  <script>
    $( document ).ready( () => {
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
      $( 'select' ).addClass( 'mdb-select' );
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
