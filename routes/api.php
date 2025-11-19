<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\FriendController;
use App\Http\Controllers\Api\LendingController;
use App\Http\Controllers\Api\ReportController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/books', [BookController::class, 'store']);         // store new book
Route::get('/books', [BookController::class, 'index']);          // list all books

Route::post('/friends', [FriendController::class, 'store']);     // add friend

Route::post('/lendings', [LendingController::class, 'store']);   // lend a book
Route::patch('/lendings/{lending}', [LendingController::class, 'markReturned']); // mark as returned

Route::get('/reports/overdue', [ReportController::class, 'overdue']); // list overdue books
