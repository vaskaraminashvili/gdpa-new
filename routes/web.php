<?php

use App\Repositories\NewsRepository;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});


Route::get('/import', function () {
    $newsRepository = resolve(NewsRepository::class);
    $newsRepository->importOldData();
    return response()->json(['message' => 'Imported successfully']);
});
