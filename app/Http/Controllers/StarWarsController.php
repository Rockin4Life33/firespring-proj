<?php

namespace App\Http\Controllers;

use function _\flatten;
use function _\map;
use function _\split;
use App\Helper;
use App\Models\Character;
use Exception;
use Illuminate\View\View;
use PHPUnit\Util\Printer;

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
          throw new \Exception( 'Character not found' );
        }
      } catch ( \Exception $ex ) {
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
    $maxCharacters = 50;

    set_time_limit( 60 );
    $time_start = microtime( true ); // TODO: REMOVE ME --> DEBUGGING

    try {
      $nextUrl = env( 'SWAPI_BASE_URL', 'https://swapi.co/api/' ) . 'people';

      do {
        $data = Helper::requestData( $nextUrl );
        $nextUrl = json_decode( $data )->next ?? '';
        $characters = Helper::hydrateData( $data, Character::class, true );
        $characterList[] = flatten( $characters );
        $maxCharacters -= 10; // To stop at 50 results
      } while ( $maxCharacters > 0 && ( $nextUrl !== null && $nextUrl !== '' ) );
    } catch ( \Exception $ex ) {
      $emptySetInfo = null;
      dd( $data );
    }

    $time_end = microtime( true ); // TODO: REMOVE ME --> DEBUGGING
    echo $time_end - $time_start; // TODO: REMOVE ME --> DEBUGGING

    return view( 'layouts.characters', [
      'characters'         => flatten( $characterList ),
      'emptySetInfo'       => $emptySetInfo,
      'emptySetHeaderShow' => true
    ] );
  }

  /**
   * Return the raw JSON of [ PlanetName: [ planetResidentName ] ]
   * Lack of any Auth or security due to the nature of this being a code test...
   *
   * @return \Illuminate\Contracts\View\Factory|View
   */
  public function planetResidents() {
    $options = JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE;

    try {
      $queryString = request()->getQueryString();
      $results = $queryString
        ? json_decode( Helper::requestData( URL_PLANET . "?$queryString" ) )
        : json_decode( Helper::requestData( URL_PLANET ) );
      $planetResidents = map( $results->results, function ( $result ) {
        return [
          $result->name => map( $result->residents, function ( $resident ) {
            return json_decode( file_get_contents( $resident ) )->name;
          } )
        ];
      } );

      return view( 'layouts.planet-residents', [
        'next'            => $results->next ? parse_url( $results->next, PHP_URL_QUERY ) : null,
        'previous'        => $results->previous ? parse_url( $results->previous, PHP_URL_QUERY ) : null,
        'planetResidents' => json_encode( $planetResidents, $options )
      ] );
    } catch ( \Exception $ex ) {
      dd( $ex );
    }
  }

}
