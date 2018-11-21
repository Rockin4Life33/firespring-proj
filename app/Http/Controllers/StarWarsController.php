<?php

namespace App\Http\Controllers;

use function _\flatten;
use App\Helper;
use App\Models\Character;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\View\View;


class StarWarsController extends Controller
{

  /**
   * Display a listing of the resource.
   *
   * @return View
   */
  public function index(): View
  {
    $data = Helper::requestData( URL_PEOPLE );
    $characters = Helper::hydrateData( $data, Character::class );

    foreach ( $characters as $character ) {
      $character->hydrate();
    }

    return view( 'layouts.characters', ['characters' => $characters] );
  }

  /**
   * @param string $name
   *
   * @return View
   */
  public function character( string $name ): View
  {
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

    return view( 'layouts.character', ['character' => $character] );

//    header( 'Content-type: application/json' );
//    echo var_dump(get_object_vars($character));
  }

  /**
   * @return View
   */
  public function characters(): View
  {
    return $this->index();
  }

  /**
   * Return the raw JSON of [ PlanetName: [ planetResidentName ] ]
   *
   * Lack of any Auth or security due to the nature of this being a code test...
   */
  public function planetResidents(): void
  {
    $planetResidents = null;
    $results = [];
    $options = JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE;

    try {
      $collection = json_decode( Helper::requestData( URL_PLANET )[ 0 ] );
      $results[] = $collection->results;

      while ( $collection->next !== null && $collection->next !== '' ) {
        $url = $collection->next;
        $collection = json_decode( Helper::requestData( $url )[ 0 ] );
        $results[] = $collection->results;
      }

      $data = ( new Collection( flatten( $results ) ) )->map( function ( $result ) {
        return [$result->name => ( new Collection( $result->residents ) )->map( function ( $resident ) {
          return json_decode( collect( file_get_contents( $resident ) )[ 0 ] )->name;
        } )];
      } );

      $planetResidents = json_encode( $data, $options );
    } catch ( Exception $ex ) {
      logger( $ex->getMessage() );
    }

    header( 'Content-type: application/json' );
    echo $planetResidents;
  }

}
