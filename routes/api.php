<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Author\AuthorController;
use App\Http\Controllers\Post\PostController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


/*
    | All Routes for Authors Table is Here
*/
Route::post('/register', [AuthorController::class, 'register']);
Route::post('/login', [AuthorController::class, 'login']);


Route::group(['middleware' => ['auth:sanctum']], function () {
    /*
        | Routes for Authors Table is Here
    */
    Route::get('/logout', [AuthorController::class, 'logout']);
    Route::get('/get-all-authors', [AuthorController::class, 'getAllAuthor']);
    Route::post('/update-profile', [AuthorController::class, 'updateAuthor']);
});



/*
    | All Routes for Posts Table is Here
*/
Route::post('/create-post', [PostController::class, 'createPost']);
