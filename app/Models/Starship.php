<?php

namespace App\Models;

use App\Helper;
use App\Interfaces\SwapiModel;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Starship
 * @package App
 *
 * @property string      $name
 * @property string      $model
 * @property string      $starship_class
 * @property string      $manufacturer
 * @property int         $cost_in_credits
 * @property int         $length
 * @property string      $crew
 * @property string      $passengers
 * @property string      $max_atmosphering_speed
 * @property float       $hyperdrive_rating
 * @property string      $MGLT
 * @property string      $cargo_capacity
 * @property string      $consumables
 * @property Film[]      $films
 * @property Character[] $pilots
 * @property \DateTime   $created
 * @property \DateTime   $edited
 * @property string      $url
 */
class Starship extends Model implements SwapiModel {

  /** @var string */
  public $name;
  /** @var string */
  public $model;
  /** @var string */
  public $starship_class;
  /** @var string */
  public $manufacturer;
  /** @var string */
  public $cost_in_credits;
  /** @var int m */
  public $length;
  /** @var int */
  public $crew;
  /** @var string */
  public $passengers;
  /** @var string */
  public $max_atmosphering_speed;
  /** @var float */
  public $hyperdrive_rating;
  /** @var string */
  public $MGLT;
  /** @var string */
  public $cargo_capacity;
  /** @var string */
  public $consumables;
  /** @var \App\Models\Film[] */
  public $films;
  /** @var \App\Models\Character[] */
  public $pilots;
  /** @var \DateTime */
  public $created;
  /** @var \DateTime */
  public $edited;
  /** @var string */
  public $url;

  //#region  Helper Functions

  public function hydrate(): void {
    $this->films = Helper::hydrateModel( $this->films, Film::class );
    $this->pilots = Helper::hydrateModel( $this->pilots, Character::class );
  }

  //#endregion  Helper Functions

}
