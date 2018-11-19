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

  /** @var string */
  public $title;
  /** @var int */
  public $episode_id;
  /** @var string */
  public $opening_crawl;
  /** @var string */
  public $director;
  /** @var string */
  public $producer;
  /** @var \App\Models\Character[] */
  public $characters;
  /** @var \App\Models\Planet[] */
  public $planets;
  /** @var \App\Models\Species[] */
  public $species;
  /** @var \App\Models\Starship[] */
  public $starships;
  /** @var \App\Models\Vehicle[] */
  public $vehicles;
  /** @var \DateTime */
  public $created;
  /** @var \DateTime */
  public $edited;
  /** @var string */
  public $url;

  //#region  Helper Functions

  public function hydrate(): void {
    $this->characters = Helper::hydrateModel( $this->characters, Character::class );
    $this->planets = Helper::hydrateModel( $this->planets, Planet::class );
    $this->species = Helper::hydrateModel( $this->species, Species::class );
    $this->starships = Helper::hydrateModel( $this->starships, Starship::class );
    $this->vehicles = Helper::hydrateModel( $this->vehicles, Vehicle::class );
  }

  //#endregion  Helper Functions

}
