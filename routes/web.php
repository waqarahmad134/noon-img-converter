<?php

use Illuminate\Support\Facades\Route;
use App\Models\Movie;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use Spatie\Sitemap\SitemapIndex;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Define routes for generating sitemaps and optimizing app performance.
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Clear cache and optimize
Route::get('/clear', function () {
    Artisan::call('optimize');
    dd('optimized!');
});
