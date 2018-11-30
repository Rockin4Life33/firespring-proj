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

  /** @var string */
  public $name;
  /** @var string */
  public $birth_year;
  /** @var string */
  public $eye_color;
  /** @var string */
  public $gender;
  /** @var string */
  public $hair_color;
  /** @var int cm */
  public $height;
  /** @var int kg */
  public $mass;
  /** @var string */
  public $skin_color;
  /** @var \App\Models\Planet */
  public $homeworld;
  /** @var \App\Models\Film[] */
  public $films = [];
  /** @var \App\Models\Species[] */
  public $species = [];
  /** @var \App\Models\Starship[] */
  public $starships = [];
  /** @var \App\Models\Vehicle[] */
  public $vehicles = [];
  /** @var \DateTime */
  public $created;
  /** @var \DateTime */
  public $edited;
  /** @var string */
  public $url;

  //#region  Helper Functions

  public function hydrate(): void {
    $this->homeworld = Helper::hydrateModel( [ $this->homeworld ], Planet::class, true );
    $this->films = Helper::hydrateModel( $this->films, Film::class );
    $this->species = Helper::hydrateModel( $this->species, Species::class );
    $this->starships = Helper::hydrateModel( $this->starships, Starship::class );
    $this->vehicles = Helper::hydrateModel( $this->vehicles, Vehicle::class );
  }

  //#endregion  Helper Functions

}
