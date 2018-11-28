<?php

namespace App;

use Illuminate\Support\Collection;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

abstract class Helper {

  /**
   * @param        $url
   *
   * @return Collection
   */
  public static function requestData( $url ): Collection {
    return collect( file_get_contents( $url ) );
  }

  /**
   * @param Collection $data
   * @param            $modelClass
   * @param bool       $isAddHomeworldSpecies
   *
   * @return array
   */
  public static function hydrateData( Collection $data,
                                      $modelClass,
                                      bool $isAddHomeworldSpecies = false ): array {
    $obj = [];
    $serializer = new Serializer( [ new ObjectNormalizer() ], [ new JsonEncoder() ] );

    try {
      $dataArr = json_decode( $data[ 0 ], true )[ 'results' ];

      foreach ( $dataArr as $key => $value ) {
        $newObj = self::deserializeObj( $serializer, $value, $modelClass );

        if ( $isAddHomeworldSpecies ) {
          $newObj->homeworld = json_decode( self::requestData( $newObj->homeworld )[ 0 ] )->name;
          $newObj->species = \count( $newObj->species ) > 0
            ? json_decode( self::requestData( $newObj->species[ 0 ] )[ 0 ] )->name
            : '';
        }

        $obj[] = $newObj;
      }
    } catch ( \Exception $ex ) {
      return [];
    }

    return $obj;
  }

  /**
   * @param Serializer $serializer
   * @param array      $data
   * @param            $modelClass
   *
   * @return object
   */
  public static function deserializeObj( Serializer $serializer, array $data, $modelClass ) {
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
    $serializer = new Serializer( [ new ObjectNormalizer() ], [ new JsonEncoder() ] );

    foreach ( $urls as $url ) {
      $data = self::requestData( $url );
      $arr = json_decode( $data[ 0 ], true );
      $results[] = self::deserializeObj( $serializer, $arr, $modelClass );
    }

    if ( $isSingleResult && \count( $results ) > 0 ) {
      return $results[ 0 ];
    }

    return $results;
  }

}

//#region  CONSTANTS

//$isLocal = $_SERVER['HTTP_HOST'] === 'localhost' ||
//           $_SERVER['REMOTE_ADDR'] === '127.0.0.1' ||
//           $_SERVER['REMOTE_ADDR'] === '::1';

//\define( 'BASE_ASSETS_HOST', $isLocal ? '/firespring-proj/public/' : '/' );
\define( 'BASE_ASSETS_HOST', '/' );
\define( 'BASE_URL', env( 'SWAPI_BASE_URL', 'https://swapi.co/api/' ) );
\define( 'URL_PEOPLE', BASE_URL . 'people' );
\define( 'URL_PLANET', BASE_URL . 'planets' );
\define( 'URL_FILM', BASE_URL . 'films' );
\define( 'URL_SPECIES', BASE_URL . 'species' );
\define( 'URL_STARSHIP', BASE_URL . 'starships' );
\define( 'URL_VEHICLES', BASE_URL . 'vehicles' );

//#endregion  CONSTANTS
