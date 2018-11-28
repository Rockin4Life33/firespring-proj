<?php

namespace App\Http\Controllers;

use function _\flatten;
use function _\internal\baseFlatten;
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
    $characterNames = Helper::getCharacterNames();

    return view( 'layouts.character', [
      'characterNames' => $characterNames,
      'character'      => null,
      'emptySetInfo'   => 'Please select a character from the dropdown.'
    ] );
  }

  /**
   * @param string $name
   *
   * @return View
   */
  public function character( string $name = '' ): View {
    $characterNames = Helper::getCharacterNames();
    $character = null;
    $emptySetInfo = null;

    if ( $name !== '' ) {
      try {
        $data = Helper::requestData( URL_PEOPLE . "?search=$name" );
        $characters = Helper::hydrateData( $data, Character::class );

        if ( $characters !== null && \count( $characters ) > 0 ) {
          $character = (object) $characters[ 0 ];
          $character->hydrate();
        }

        if ( $character === null ) {
          throw( new Exception( 'Character not found' ) );
        }
      } catch ( Exception $ex ) {
        $emptySetInfo = "Sorry, no results were found for '$name'.";
      }
    } else {
      $emptySetInfo = 'Sorry, no results were found. You must search for a characters name.';
    }

    return view( 'layouts.character', [
      'characterNames'     => $characterNames,
      'character'          => $character,
      'emptySetInfo'       => $emptySetInfo,
      'emptySetHeaderShow' => true
    ] );
  }

  /**
   * @return View
   */
  public function characters(): View {
    $characterList = [];
    $emptySetInfo = null;

    try {
      $nextUrl = env( 'SWAPI_BASE_URL', 'https://swapi.co/api/' ) . 'people';
      do {
        $data = Helper::requestData( $nextUrl );
        $nextUrl = json_decode( $data[ 0 ] )->next ?? '';
        $characters = Helper::hydrateData( $data, Character::class, true );
        $characterList[] = $characters;
      } while ( $nextUrl !== null && $nextUrl !== '' );
    } catch ( \Exception $ex ) {
//      $emptySetInfo = null;
    }

    return view( 'layouts.characters', [
      'characters'         => baseFlatten( $characterList, 2 ),
      'emptySetInfo'       => $emptySetInfo,
      'emptySetHeaderShow' => true
    ] );
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
