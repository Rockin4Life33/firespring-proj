<?php

namespace App\Models;

use App\Helper;
use App\Interfaces\SwapiModel;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Character
 * @package App
 *
 * @property string     $name
 * @property string     $birth_year
 * @property string     $eye_color
 * @property string     $gender
 * @property string     $hair_color
 * @property int        $height
 * @property int        $mass
 * @property string     $skin_color
 * @property Planet     $homeworld
 * @property Film[]     $films
 * @property Species[]  $species
 * @property Starship[] $starships
 * @property Vehicle[]  $vehicles
 * @property \DateTime  $created
 * @property \DateTime  $edited
 * @property string     $url
 */
class Character extends Model implements SwapiModel {

  public function hydrate(): void {
    $this->homeworld = Helper::hydrateModel( [ $this->homeworld ], Planet::class, true );
    $this->films = Helper::hydrateModel( $this->films, Film::class );
    $this->species = Helper::hydrateModel( $this->species, Species::class );
    $this->starships = Helper::hydrateModel( $this->starships, Starship::class );
    $this->vehicles = Helper::hydrateModel( $this->vehicles, Vehicle::class );
  }

}
