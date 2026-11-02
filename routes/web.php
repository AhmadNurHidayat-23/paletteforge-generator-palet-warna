<?php

use App\Http\Controllers\PaletteController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PaletteController::class, 'index'])->name('palette.index');
Route::post('/generate', [PaletteController::class, 'generate'])->name('palette.generate');
Route::get('/random', [PaletteController::class, 'random'])->name('palette.random');
