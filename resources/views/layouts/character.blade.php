@extends('master')

@section('content')
  @if($character !== null)
    @foreach($character as $key => $value)
      @if(is_array($value))
        {!! "$key:<br/>" !!}
        @foreach($value as $k => $val)
          {!! "<span> &nbsp; &dash; &nbsp; </span> $k" . ': ' . $val . '<br/>' !!}
        @endforeach
      @else
        {!! "$key: " . $value . '<br/>' !!}
      @endif
    @endforeach
  @else
    @includeIf('partials._empty-data-set')
  @endif
@endsection

@section('scripts')

@endsection
