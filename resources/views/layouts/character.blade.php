@extends('master')

@section('content')
  @if($character !== null)
    @foreach($character as $key => $value)
      {!! json_encode($key) . ': ' . json_encode($value) . '<br/>' !!}
    @endforeach
  @else
    @includeIf('partials._empty-data-set')
  @endif
@endsection

@section('scripts')

@endsection
