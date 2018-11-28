<?php

namespace App\Http\Controllers;

use function _\flatten;
use function _\internal\baseFlatten;
use function _\map;
use App\Helper;
use App\Models\Character;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class StarWarsController extends Controller {

  /**
   * Display a listing of the resource.
   *
   * @return View
   */
  public function index(): View {
    $characterNames = [];

    try {
      $nextUrl = env( 'SWAPI_BASE_URL', 'https://swapi.co/api/' ) . 'people';

      do {
        $data = json_decode( Helper::requestData( $nextUrl )[ 0 ] );
        $nextUrl = $data->next ?? '';
        $results = $data->results;
        $characterNames[] = map($results, function($result) {
          return $result->name;
        });
      } while ( $nextUrl !== null && $nextUrl !== '' );

      $characterNames = flatten( $characterNames );
    } catch (\Exception $ex) {
      dd($ex);
    }

    return view( 'layouts.character', [ 'characterNames' => $characterNames, 'character' => null ] );
  }

  /**
   * @param string $name
   *
   * @return View
   */
  public function character( string $name ): View {
    $character = null;

    try {
      $data = Helper::requestData( URL_PEOPLE . "?search=$name" );
      $characters = Helper::hydrateData( $data, Character::class );

      if ( $characters !== null && \count( $characters ) > 0 ) {
        $character = $characters[ 0 ];
        $character->hydrate();
      }
    } catch ( Exception $ex ) {
      logger( $ex->getMessage() );
    }

    return view( 'layouts.character', [
      'characterNames' => null,
      'character' => $character
    ] );
  }

  /**
   * @return View
   */
  public function characters(): View {
    $characterList = [];

    $time_start = microtime(true); // TODO: REMOVE ME --> DEBUGGING

    $nextUrl = env( 'SWAPI_BASE_URL', 'https://swapi.co/api/' ) . 'people';
    do {
      $data = Helper::requestData( $nextUrl );
      $nextUrl = json_decode( $data[ 0 ] )->next ?? '';
      $characters = Helper::hydrateData( $data, Character::class, true );
      $characterList[] = $characters;
    } while ( $nextUrl !== null && $nextUrl !== '' );

    $time_end = microtime(true); // TODO: REMOVE ME --> DEBUGGING
    echo $time_end - $time_start; // TODO: REMOVE ME --> DEBUGGING

    return view( 'layouts.characters', [ 'characters' => baseFlatten( $characterList, 2 ) ] );
  }

  /**
   * Return the raw JSON of [ PlanetName: [ planetResidentName ] ]
   *
   * Lack of any Auth or security due to the nature of this being a code test...
   */
  public function planetResidents(): void {
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
        return [
          $result->name => ( new Collection( $result->residents ) )->map( function ( $resident ) {
            return json_decode( collect( file_get_contents( $resident ) )[ 0 ] )->name;
          } )
        ];
      } );

      $planetResidents = json_encode( $data, $options );
    } catch ( Exception $ex ) {
      logger( $ex->getMessage() );
    }

    header( 'Content-type: application/json' );
    echo $planetResidents;
  }

}
