<?php
    use Illuminate\Http\Request;

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
    Route::middleware('auth:api')->get('/user', function (Request $request) {
        return $request->user();
    });
    /**
     * Api version 1
     */
    Route::group(['prefix' => 'v1'], function () {
        /**
         * Postcast CRUD operation API
         */
        Route::group(['prefix' => 'podcast'], function () {
            Route::post('store', 'Api\PodcastController@store');
            Route::post('update/{id}', 'Api\PodcastController@update');
            Route::post('approve', 'Api\PodcastController@approve');
            Route::get('published', 'Api\PodcastController@getPublishedPodcast');
            Route::get('/{id}', 'Api\PodcastController@getPodcastById');
            Route::delete('/{id}', 'Api\PodcastController@destroy');
        });
        /**
         * Postcast comment CRUD operation API
         */
        Route::post('comments/store', 'Api\PodcastCommentController@store');
        Route::delete('flag-comment/{id}', 'Api\PodcastCommentController@destroy');
    });