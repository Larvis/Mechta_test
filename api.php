<?php

use Illuminate\Support\Facades\Route;

/* /api/search/doResultsID - для поиска по id сохраненного результата */
/* /api/search/doText  - для поиска по тексту */

Route::prefix('search')->name('search.')->controller(App\Http\Controllers\vBulletin\Search\SearchController::class)->group(function () {
    Route::post('/doResultsID', 'doResultsID')->name('doResultsID');
    Route::post('/doText', 'doText')->name('doText');
});

