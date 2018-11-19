<?php

namespace App\Models;

use App\Helper;
use App\Interfaces\SwapiModel;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Vehicle
 * @package App
 *
 * @property string    $name
 * @property string    $model
 * @property string    $manufacturer
 * @property int       $cost_in_credits
 * @property float     $length
 * @property float     $max_atmosphering_speed
 * @property string    $crew
 * @property string    $passengers
 * @property string    $cargo_capacity
 * @property string    $consumables
 * @property string    $vehicle_class
 * @property string[]  $pilots
 * @property Film[]    $films
 * @property \DateTime $created
 * @property \DateTime $edited
 * @property string    $url
 */
class Vehicle extends Model implements SwapiModel {

  /** @var string */
  public $name;
  /** @var string */
  public $model;
  /** @var string */
  public $manufacturer;
  /** @var int */
  public $cost_in_credits;
  /** @var float */
  public $length;
  /** @var float */
  public $max_atmosphering_speed;
  /** @var string */
  public $crew;
  /** @var string */
  public $passengers;
  /** @var string */
  public $cargo_capacity;
  /** @var string */
  public $consumables;
  /** @var string */
  public $vehicle_class;
  /** @var string[] */
  public $pilots;
  /** @var \App\Models\Film[] */
  public $films = [];
  /** @var \DateTime */
  public $created;
  /** @var \DateTime */
  public $edited;
  /** @var string */
  public $url;

  //#region  Helper Functions

  public function hydrate(): void {
    $this->films = Helper::hydrateModel( $this->films, Film::class );
  }

  //#endregion  Helper Functions

}
