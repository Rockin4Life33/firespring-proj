@extends('master')

@section('content')
  @if($planetResidents !== null)
    @foreach($planetResidents as $key => $value)
      {!! json_encode($key) . ': ' . json_encode($value) . '<br/>' !!}
    @endforeach
  @else
    @includeIf('partials._empty-data-set')
  @endif
@endsection

@section('scripts')

@endsection
