<?php

namespace App\Models;

use App\Helper;
use App\Interfaces\SwapiModel;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Film
 * @package App
 *
 * @property string      $title
 * @property string      $episode_id
 * @property string      $opening_crawl
 * @property string      $director
 * @property string      $producer
 * @property Character[] $characters
 * @property Planet[]    $planets
 * @property Species[]   $species
 * @property Starship[]  $starships
 * @property Vehicle[]   $vehicles
 * @property \DateTime   $created
 * @property \DateTime   $edited
 * @property string      $url
 */
class Film extends Model implements SwapiModel {

  public function hydrate(): void {
    $this->characters = Helper::hydrateModel( $this->characters, Character::class );
    $this->planets = Helper::hydrateModel( $this->planets, Planet::class );
    $this->species = Helper::hydrateModel( $this->species, Species::class );
    $this->starships = Helper::hydrateModel( $this->starships, Starship::class );
    $this->vehicles = Helper::hydrateModel( $this->vehicles, Vehicle::class );
  }

}
