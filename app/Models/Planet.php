<?php

namespace App\Models;

use App\Helper;
use App\Interfaces\SwapiModel;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Planet
 * @package App
 *
 * @property string      $name
 * @property string      $diameter
 * @property string      $rotation_period
 * @property string      $orbital_period
 * @property string      $gravity
 * @property string      $population
 * @property string      $climate
 * @property string      $terrain
 * @property string      $surface_water
 * @property Character[] $residents
 * @property Film[]      $films
 * @property \DateTime   $created
 * @property \DateTime   $edited
 * @property string      $url
 */
class Planet extends Model implements SwapiModel {

  public function hydrate(): void {
    $this->residents = Helper::hydrateModel( $this->residents, Character::class );
    $this->films = Helper::hydrateModel( $this->films, Film::class );
  }

}
