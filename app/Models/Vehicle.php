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

  public function hydrate(): void {
    $this->films = Helper::hydrateModel( $this->films, Film::class );
  }

}
