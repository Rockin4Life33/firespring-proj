@extends('master')

@section('content')
  @if($planetResidents !== null)
    {!! $planetResidents !!}
  @else
    @includeIf('partials._empty-data-set')
  @endif
@endsection

@section('scripts')

@endsection
