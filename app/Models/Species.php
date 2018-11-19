<?php

namespace App\Models;

use App\Helper;
use App\Interfaces\SwapiModel;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Species
 * @package App
 *
 * @property string      $name
 * @property string      $classification
 * @property string      $designation
 * @property string      $average_height
 * @property string      $average_lifespan
 * @property string      $eye_colors
 * @property string      $hair_colors
 * @property string      $skin_colors
 * @property string      $language
 * @property Planet      $homeworld
 * @property Character[] $people
 * @property Film[]      $films
 * @property \DateTime   $created
 * @property \DateTime   $edited
 * @property string      $url
 */
class Species extends Model implements SwapiModel {

  /** @var string */
  public $name;
  /** @var string */
  public $classification;
  /** @var string */
  public $designation;
  /** @var string */
  public $average_height;
  /** @var string */
  public $average_lifespan;
  /** @var string */
  public $eye_colors;
  /** @var string */
  public $hair_colors;
  /** @var string */
  public $skin_colors;
  /** @var string */
  public $language;
  /** @var \App\Models\Planet */
  public $homeworld;
  /** @var \App\Models\Character[] */
  public $people;
  /** @var \App\Models\Film[] */
  public $films;
  /** @var \DateTime */
  public $created;
  /** @var \DateTime */
  public $edited;
  /** @var string */
  public $url;

  //#region  Helper Functions

  public function hydrate(): void {
    $this->homeworld = Helper::hydrateModel( [ $this->homeworld ], Planet::class, true );
    $this->people = Helper::hydrateModel( $this->people, Character::class );
    $this->films = Helper::hydrateModel( $this->films, Film::class );
  }

  //#endregion  Helper Functions

}
