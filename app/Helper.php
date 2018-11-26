<?php

namespace App;

use Illuminate\Support\Collection;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

abstract class Helper {

  /**
   * @param        $url
   * @param string $queryStr
   *
   * @return Collection
   */
  public static function requestData( $url, $queryStr = '' ): Collection {
    if ( $queryStr !== '' ) {
      $url .= "?$queryStr";
    }

    return collect( file_get_contents( $url, false ) );
  }

  /**
   * @param        $url
   * @param string $queryStr
   * @param bool   $isCollectAll
   *
   * @return array
   */
//  public static function getDataCollection( $url, $queryStr = '', bool $isCollectAll = false ) {
//    $results = [];
//    $collection = json_decode( self::requestData( $url )[0] );
//
//    if ( $isCollectAll ) {
//      $results[] = $collection->results;
//
//      while ( $collection->next !== null && $collection->next !== '' ) {
//        $url = $collection->next;
//        $collection = json_decode( self::requestData( $url )[0] );
//
//        $results[] = $collection->results;
//      }
//    }
//
//    return $results;
//  }

  /**
   * @param Collection $data
   * @param            $modelClass
   *
   * @param bool       $hasResults
   *
   * @return array
   */
  public static function hydrateData( Collection $data, $modelClass, bool $hasResults = true ): array {
    $obj = [];

    try {
      $dataArr = self::getJsonResultsAsArray( $data, $hasResults );

      foreach ( $dataArr as $i => $iValue ) {
        $obj[] = self::deserializeObj( $dataArr[ $i ], $modelClass );
      }
    } catch ( \Exception $ex ) {
      // TODO: Log exception and/or attempt to recover, else, return false

      return [];
    }

    return $obj;
  }

  /**
   * @param Collection $data
   * @param bool       $hasResults
   *
   * @return array
   */
  public static function getJsonResultsAsArray( Collection $data, bool $hasResults = true ): array {
    $result = json_decode( json_decode( $data, true )[ 0 ], true );

    return $hasResults ? $result[ 'results' ] : $result;
  }

  /**
   * @param array $data
   * @param       $modelClass
   *
   * @return object
   */
  public static function deserializeObj( array $data, $modelClass ) {
    $encoders = [ new JsonEncoder() ];
    $normalizers = [ new ObjectNormalizer() ];
    $serializer = new Serializer( $normalizers, $encoders );

    return $serializer->deserialize( json_encode( $data, JSON_UNESCAPED_SLASHES ), $modelClass, 'json' );
  }

  /**
   * @param array $urls
   * @param       $modelClass
   * @param bool  $isSingleResult
   *
   * @return mixed
   */
  public static function hydrateModel( array $urls, $modelClass, bool $isSingleResult = false ) {
    $results = [];

    foreach ( $urls as $url ) {
      $data = self::requestData( $url );
      $arr = self::getJsonResultsAsArray( $data, false );
      $results[] = self::deserializeObj( $arr, $modelClass );
    }

    if ( $isSingleResult && \count( $results ) > 0 ) {
      return $results[ 0 ];
    }

    return $results;
  }

}

//#region  CONSTANTS

// TODO: Use port# because using xampp/wamp vs. `php artisan serve` will need different endpoints
//$_SERVER['REMOTE_PORT'] = '';
//$_SERVER['SERVER_PORT'] = '80';
// TODO: ........................................................................................

//$isLocal = $_SERVER['HTTP_HOST'] === 'localhost' ||
//           $_SERVER['REMOTE_ADDR'] === '127.0.0.1' ||
//           $_SERVER['REMOTE_ADDR'] === '::1';

//\define( 'BASE_ASSETS_HOST', $isLocal ? '/firespring-proj/public/' : '/' );
\define( 'BASE_ASSETS_HOST', '/' );
\define( 'BASE_URL', 'https://swapi.co/api/' );
\define( 'URL_PEOPLE', BASE_URL . 'people' );
\define( 'URL_PLANET', BASE_URL . 'planets' );
\define( 'URL_FILM', BASE_URL . 'films' );
\define( 'URL_SPECIES', BASE_URL . 'species' );
\define( 'URL_STARSHIP', BASE_URL . 'starships' );
\define( 'URL_VEHICLES', BASE_URL . 'vehicles' );

//#endregion  CONSTANTS
