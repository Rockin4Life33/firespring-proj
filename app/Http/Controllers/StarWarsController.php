<?php

namespace App\Http\Controllers;

use function _\flatten;
use function _\map;
use App\Helper;
use App\Models\Character;
use App\Models\Planet;
use Exception;
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
    $data = Helper::requestData(URL_PEOPLE);
    $characters = Helper::hydrateData($data, Character::class);

    foreach ($characters as $character) {
      $character->hydrate();
    }

    return view('layouts.characters', ['characters' => $characters]);
  }

  /**
   * @param string $name
   *
   * @return View
   */
  public function character(string $name): View
  {
    /** @var Character $character */
    $character = null;

    try {
      $data = Helper::requestData(URL_PEOPLE, "search=$name");
      $characters = Helper::hydrateData($data, Character::class);

      if ($characters !== null && \count($characters) > 0) {
        $character = $characters[0];
        $character->hydrate();
      }
    } catch (Exception $ex) {
      logger($ex->getMessage());
    }

    return view('layouts.character', ['character' => $character]);
  }

  /**
   * @return View
   */
  public function characters(): View
  {
    return $this->index();
  }

  /**
   * @return View
   */
  public function planetResidents(): View
  {
    $planetResidents = [];

    try {
      $allResults = Helper::getDataCollection(URL_PLANET, '', true);
      $allResultsFlat = flatten($allResults);

      $results = map($allResultsFlat, function ($item) {
        return [ $item->name => $item->residents ];
      });

       $planetResidents = $results;
//      $planetResidents = flatten($allResults);
    } catch (Exception $ex) {
      logger($ex->getMessage());
    }
    return view('layouts.planet-residents', ['planetResidents' => $planetResidents]);
  }

}
