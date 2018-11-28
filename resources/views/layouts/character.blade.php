@extends('master')

@section('content')
  @if($characterNames !== null)
    <label>
      <select class="custom-select-lg center-block">
        <option disabled value="#">- - - - - - - - - - -</option>
        @foreach($characterNames as $key => $val)
          <option id="{{ $key }}" value="{{ \_\split($val, ' ', 1)[ 0 ] }}">{{ $val }}</option>
        @endforeach
      </select>
    </label>
  @endif

  @if($character !== null)
    @includeIf('partials._character')
  @else
    @includeIf('partials._empty-data-set')
  @endif
@endsection

@section('scripts')
  <script>
    // TODO: Add in logic to handle dropdown onClick event
  </script>
  <style type="text/css" rel="stylesheet">
    ul {
      list-style: none;
    }

    li > ul:not(:first-child) {
      margin-top: 1em;
    }
  </style>
@endsection
