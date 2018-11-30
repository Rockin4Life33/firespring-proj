@extends('master')

@section('content')
  @if($characterNames !== null)
    <label>
      <select id="character-dropdown" class="custom-select-lg">
        <option disabled selected value="#">- - - - - - - - - - -</option>
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
    $(document).ready(() => {
      const dropdown = document.getElementById('character-dropdown');
      dropdown.addEventListener('change', (e) => {
        // const url = window.location.origin + '/character/'; // TODO: Use with root as '/'
        const url = window.location.origin + '{{ BASE_ASSETS_HOST }}character/'; // TODO: Use when root is not '/'. Tweak BASE_ASSETS_HOST as needed
        window.location.assign(url + e.target.selectedOptions[0].value);
      });
    });
  </script>

  <style type="text/css" rel="stylesheet">
    label {
      display: block;
      margin: -1em 0 2em;
      text-align: center;
    }

    ul {
      list-style: none;
    }

    li > ul:not(:first-child) {
      margin-top: 1em;
    }
  </style>
@endsection
