<div class="card">
  <div id="li-{{ $character->name }}" datasrc="{{ $character->url }}" class="card-body">
    <h3 class="card-header"><i>{{ $character->name }}</i></h3>

    <ul class="card-body">
      <li>Birth Year: &nbsp; {{ $character->birth_year }}</li>
      <li>Eye Color: &nbsp; {{ $character->eye_color }}</li>
      <li>Gender: &nbsp; {{ $character->gender }}</li>
      <li>Hair Color: &nbsp; {{ $character->hair_color }}</li>
      <li>Height: &nbsp; {{ $character->height }}</li>
      <li>Mass: &nbsp; {{ $character->mass }}</li>
      <li>Skin Color: &nbsp; {{ $character->skin_color }}</li>
      <li>Home World: &nbsp; {{ $character->homeworld->name }}</li>

      @if(count($character->films) > 0)
        <li>Films:
          <ul>
            @foreach($character->films as $film)
              <li>{{ $film->title }}</li>
            @endforeach
          </ul>
        </li>
      @endif

      @if(count($character->species) > 0)
        <li>Species:
          @foreach($character->species as $s)
            <ul>
              <li>Name: &nbsp; {{ $s->name }}</li>
              <li>Classification: &nbsp; {{ $s->classification }}</li>
              <li>Designation: &nbsp; {{ $s->designation }}</li>
              <li>Language: &nbsp; {{ $s->language }}</li>
            </ul>
          @endforeach
        </li>
      @endif

      @if(count($character->starships) > 0)
        <li>Starships:
          @foreach($character->starships as $s)
            <ul>
              <li>Name: &nbsp; {{ $s->name }}</li>
              <li>Model: &nbsp; {{ $s->model }}</li>
              <li>Manufacturer: &nbsp; {{ $s->manufacturer }}</li>
              <li>Crew: &nbsp; {{ $s->crew }}</li>
              <li>Passengers: &nbsp; {{ $s->passengers }}</li>
              <li>Starship Class: &nbsp; {{ $s->starship_class }}</li>
            </ul>
          @endforeach
        </li>
      @endif

      @if(count($character->vehicles) > 0)
        <li>Vehicles:
          @foreach($character->vehicles as $v)
            <ul>
              <li>Name: &nbsp; {{ $v->name }}</li>
              <li>Model: &nbsp; {{ $v->model }}</li>
              <li>Manufacturer: &nbsp; {{ $v->manufacturer }}</li>
              <li>Crew: &nbsp; {{ $v->crew }}</li>
              <li>Passengers: &nbsp; {{ $v->passengers }}</li>
              <li>Cargo Capacity: &nbsp; {{ $v->cargo_capacity }}</li>
              <li>Vehicle Class: &nbsp; {{ $v->vehicle_class }}</li>
            </ul>
          @endforeach
        </li>
      @endif
    </ul>
  </div>
</div>
