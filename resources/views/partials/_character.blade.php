<div class="card">
  {{--Card content--}}
  <div id="li-{{ $character->url }}" class="card-body">
    {{--Title--}}
    <h4 class="card-title">Name <i>{{ $character->name }}</i></h4>

    {{--Text--}}
    <ul class="card-text">
      <li>Birth Year: &nbsp; {{ $character->birth_year }}</li>
      <li>Eye Color: &nbsp; {{ $character->eye_color }}</li>
      <li>Gender: &nbsp; {{ $character->gender }}</li>
      <li>Hair Color: &nbsp; {{ $character->hair_color }}</li>
      <li>Height: &nbsp; {{ $character->height }}</li>
      <li>Mass: &nbsp; {{ $character->mass }}</li>
      <li>Skin Color: &nbsp; {{ $character->skin_color }}</li>

      <li>Home World: &nbsp; {{ $character->homeworld->name }}</li>
      {{--<li>Films: &nbsp; {{ $character-> }}</li>--}}
      {{--<li>Species: &nbsp; {{ $character-> }}</li>--}}
      {{--<li>Starships: &nbsp; {{ $character-> }}</li>--}}
      {{--<li>Vehicles: &nbsp; {{ $character-> }}</li>--}}
    </ul>
  </div>
</div>
