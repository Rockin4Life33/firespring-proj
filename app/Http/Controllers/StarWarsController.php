<?php

namespace App\Http\Controllers;

use function _\flatten;
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
    $characterList = [];

    $nextUrl = env( 'SWAPI_BASE_URL', 'https://swapi.co/api/' ) . 'people';
    do {
      $data = Helper::requestData( $nextUrl );
      $nextUrl = json_decode( $data[ 0 ] )->next ?? '';
      $characters = Helper::hydrateData( $data, Character::class );
      $characterList[] = $characters;
    } while ( $nextUrl !== null && $nextUrl !== '' );

    set_time_limit( 75 ); // OPTIMIZE: Remove this after optimization so call does not take as long!!!

    $characterListFlat = flatten( $characterList );
    $characterList = map( $characterListFlat, function ( $character ) {
      $character->homeworld = json_decode( Helper::requestData( $character->homeworld )[ 0 ] )->name;
      $character->species = \count( $character->species ) > 0
        ? json_decode( Helper::requestData( $character->species[ 0 ] )[ 0 ] )->name
        : '';

      return $character;
    } );

    return view( 'layouts.characters', [ 'characters' => flatten( $characterList ) ] );
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

    return view( 'layouts.character', [ 'character' => $character ] );
  }

  /**
   * @return View
   */
  public function characters(): View {
    return $this->index();
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

    //header( 'Content-type: application/json' );
    echo $planetResidents;
  }

}
