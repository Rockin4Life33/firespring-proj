@extends('master')

@section('content')
  @if($character !== null)
    @includeIf('partials._character')
  @else
    @includeIf('partials._empty-data-set')
  @endif
@endsection

@section('scripts')
<style type="text/css" rel="stylesheet">
  ul {
    list-style: none;
  }

  li > ul:not(:first-child) {
    margin-top: 1em;
  }
</style>
@endsection
