@extends('master')

@section('content')
  @if($planetResidents !== null)
    {!! '{<br/>' !!}
    @foreach($planetResidents as $planetKey => $planets)

      @foreach($planets as $planet => $residents)
        {!! "<span> &nbsp; &nbsp; '$planet': [ </span><br/>" !!}
        @if(is_array($residents))
          @foreach($residents as $key => $value)
            {!! "<span> &nbsp; &nbsp; &nbsp; &nbsp; '$value' </span><br/>" !!}
          @endforeach
        @else
          {!! $residents . '<br/>' !!}
        @endif
        {!! "<span> &nbsp; &nbsp; ] </span><br/>" !!}
      @endforeach

    @endforeach
    {!! '<br/>}' !!}
  @else
    @includeIf('partials._empty-data-set')
  @endif
@endsection

@section('scripts')

@endsection
