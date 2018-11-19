@extends('master')

@section('content')
  @if($planetResidents !== null)
    @foreach($planetResidents as $i => $planet)
      @foreach($planet as $key => $value)
        @if(is_array($value))
          {!! "$key<br/>" !!}
          @foreach($value as $k => $val)
            {!! "&nbsp; - $val<br/>" !!}
          @endforeach
        @else
          {!! $key . ': ' . $value . '<br/>' !!}
        @endif
      @endforeach
      {!! '<br/>' !!}
    @endforeach
  @else
    @includeIf('partials._empty-data-set')
  @endif
@endsection

@section('scripts')

@endsection
