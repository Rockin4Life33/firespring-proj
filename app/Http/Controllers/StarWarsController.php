<?php

namespace App\Http\Controllers;

use App\Helper;
use App\Models\Character;
use App\Models\Planet;
use Exception;
use Illuminate\View\View;

class StarWarsController extends Controller {

  /**
   * Display a listing of the resource.
   *
   * @return View
   */
  public function index(): View {
    $data = Helper::requestData( URL_PEOPLE );
    $characters = Helper::hydrateData( $data, Character::class );

    foreach ( $characters as $character ) {
      $character->hydrate();
    }

    return view( 'layouts.characters', [ 'characters' => $characters ] );
  }

  /**
   * @param string $name
   *
   * @return View
   */
  public function character( string $name ): View {
    /** @var Character $character */
    $character = null;

    try {
      $data = Helper::requestData( URL_PEOPLE, "search=$name" );
      $characters = Helper::hydrateData( $data, Character::class );

      if ( $characters !== null && \count( $characters ) > 0 ) {
        $character = $characters[ 0 ];
        $character->hydrate();
      }
    } catch ( Exception $ex ) {
      logger( $ex->getMessage() );
    }

    return view( 'layouts.character', [ 'character' => $character ] );
  }

  /**
   * @return View
   */
  public function characters(): View {
    return $this->index();
  }

  /**
   * @return View
   */
  public function planetResidents(): View {
    /** @var Planet[] $planetResidents */
    $planetResidents = [];

    try {
      $allResults = Helper::getDataCollection( URL_PLANET, '', true );

      $data = Helper::requestData( URL_PLANET );
      //$planets = Helper::hydrateData( $data, Planet::class );
      //dd( json_decode($data[0])->results );

      $planets = json_decode( $data[0] );
      foreach ( $planets->results as $item ) {
        $planetResidents[] = $item;
      }

      //foreach ( $planets as $planet ) {
      //  //$planet->hydrate();
      //  $planetResidents[] = $planet;
      //}

      ////////////////////////////////////////////////////////////////////////////////////////////////////
      // TODO: ---------------------------------------------------------------------------------------
      // TODO: Update so $planetResidents is KVP of [ string $planet->name => array $planet->residents ]
      // TODO: ---------------------------------------------------------------------------------------
      ////////////////////////////////////////////////////////////////////////////////////////////////////
      //$planetResidents = $planets;
    } catch ( Exception $ex ) {
      logger( $ex->getMessage() );
    }
//dd($planetResidents);
    return view( 'layouts.planet-residents', [ 'planetResidents' => $planetResidents ] );
  }

}
