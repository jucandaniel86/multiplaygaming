<?php

  use Illuminate\Support\Facades\Route;
  use \App\Http\Controllers\Api\{SelectorsController,
    GamesController,
    FrontendController,
    BannerController
  };
  use \App\Http\Controllers\ClientAreaController;

  Route::prefix('ca-api')->group(function () {
    Route::prefix('selector')->group(function () {
      Route::get('/volatility', [SelectorsController::class, 'getVolatility']);
      Route::get('/game-categories', [GamesController::class, 'gameCategoriesSelector']);
      Route::get('/features', [GamesController::class, 'getFeaturesDropdown']);
      Route::get('/rtp', [SelectorsController::class, 'getRTP']);
      Route::get('/games', [SelectorsController::class, 'getGames']);
      Route::get('/languages', [SelectorsController::class, 'getLanguages']);
      Route::get('/jurisdictions', [SelectorsController::class, 'getJurisdictions']);
      Route::get('/mechanics', [SelectorsController::class, 'getMechanics']);
      Route::get('/range-sliders', [SelectorsController::class, 'getRangeSliders']);
    });

    Route::get('/options', [\App\Http\Controllers\Api\ClientAreaController::class, 'options']);
    Route::get('/option', [\App\Http\Controllers\Api\ClientAreaController::class, 'option']);

    Route::get('/games-filter', [FrontendController::class, 'filterGames'])->name('ca.games-filter');
    Route::get('/get-game/{slug}', [FrontendController::class, 'getGameBySlug'])->name('ca.games.item');

    Route::get('/game-categories', [GamesController::class, 'gameCategoriesSelector']);
    Route::get('/categories-with-games', [FrontendController::class, 'getCategoriesWithGames']);


    Route::post('/update-user-details', [ClientAreaController::class, 'updateUserDetails'])
      ->middleware('auth');
    Route::post('/support', [ClientAreaController::class, 'postSupport'])->middleware('auth');
    Route::get('/banners', [BannerController::class, 'client_area']);
  });
