<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;

Route::get( '/', 'StarWarsController@index' )->name( 'starwars.index' );

Route::prefix( '/character' )->group( function () {
  Route::get( '', 'StarWarsController@character' )->name( 'starwars.index' );
  Route::get( '/{name}', 'StarWarsController@character' )->name( 'starwars.character' );
} );

Route::get( '/characters', 'StarWarsController@characters' )->name( 'starwars.characters' );

Route::get( '/planet-residents', 'StarWarsController@planetResidents' )->name( 'starwars.planetResidents' );

Route::get( '/about', function () {
  return view( 'layouts.about' );
} );
