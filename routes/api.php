<?php

use Carbon\Carbon;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Awesome JustBookr API v1.
|
 */

Route::prefix('v1')->group(function () {

    //Public access routes
    Route::get('time', function () {
        return response()->json(Carbon::now()->timestamp);
    });

    Route::get('translations/{locale}', 'TranslationController@show');

    // DEPRECIATED, USE SEARCH FIRST
    Route::get('posts/search/{query}', 'SearchController@posts');
    Route::get('books/search/{query}', 'SearchController@books');
    Route::get('universities/search/{query}', 'SearchController@universities');
    Route::get('users/search/{query}', 'SearchController@users');

    Route::get('books/{query}/google', 'Api\V1\GoogleBookController@show');

    Route::prefix('search')->group(function () {
        Route::get('posts/{query}', 'SearchController@posts');
        Route::get('books/{query}', 'SearchController@books');
        Route::get('books/{query}/google', 'Api\V1\GoogleBookController@search');
        Route::get('universities/{query}', 'SearchController@universities');
        Route::get('users/{query}', 'SearchController@users');
        Route::get('tags/{query}', 'SearchController@tags');
    });

    Route::prefix('messenger')->group(function () {
        Route::get('posts/{query}', 'MessengerController@posts');
        Route::get('books/{query}', 'MessengerController@books');
        Route::get('universities/{query}', 'MessengerController@universities');
        Route::get('users/{query}', 'MessengerController@users');
        Route::get('tags/{query}', 'MessengerController@tags');
    });

    Route::prefix('suggestions')->group(function () {
        Route::get('textbooks', 'SuggestionsController@textbooks');
        Route::get('recent', 'SuggestionsController@recent');
        Route::get('other-editions/{isbn}', 'SuggestionsController@otherEditions');
        Route::get('university-books/{university}', 'SuggestionsController@universityBooks');
    });

    Route::get('universities/{id}/views', 'Api\V1\UniversitiesController@views');

    Route::get('books/{isbn}/views', 'Api\V1\TextbooksController@views');

    Route::get('messenger/{q}', 'MessengerController@books');

    Route::get('messenger/{q}/universities', 'MessengerController@universities');

    // Authenticated routes

    Route::get('me', 'Api\V1\UsersController@me');

    Route::get('me/time-to-reply', 'Api\V1\UsersController@timeToReply');

    Route::post('me/profile-picture', 'Api\V1\UsersController@setProfilePicture');

    Route::post('me/card', 'Api\V1\UsersController@updateCard');

    Route::get('me/post-views', 'Api\V1\UsersController@postViews');

    Route::get('me/notifications', 'Api\V1\UsersController@notifications');

    Route::post('me/set-university', 'Api\V1\UsersController@setUniversity');

    Route::get('suggestions/post-descriptions', 'SuggestionsController@text');

    Route::post('orders/{order}/accept', 'Api\V1\OrdersController@accept');

    Route::post('business-stands/{stand}/activate', 'Api\V1\BusinessStandsController@activate');

    Route::post('business-stands/{stand}/deactivate', 'Api\V1\BusinessStandsController@deactivate');

    Route::post('posts/{post}/mark-sold', 'Api\V1\PostsController@markSold');

    Route::post('posts/{post}/mark-available', 'Api\V1\PostsController@markUnsold');

    Route::get('posts/{post_id}/boost/price', 'Api\V1\PostBoostsController@getPrice');

    Route::get('users/{user}/post-views', 'Api\V1\UsersController@postViews');

    Route::get('users/{user}/time-to-reply', 'Api\V1\UsersController@timeToReply');

    Route::post('textbooks/{isbn}/views', 'Api\V1\TextbookViewsController@store');

    Route::apiResources([
        'posts'                   => 'Api\V1\PostsController',
        'users'                   => 'Api\V1\UsersController',
        'orders'                  => 'Api\V1\OrdersController',
        'books'                   => 'Api\V1\TextbooksController',
        'universities'            => 'Api\V1\UniversitiesController',
        'ratings'                 => 'Api\V1\UserRatingsController',
        'points'                  => 'Api\V1\PointsController',
        'countries'               => 'Api\V1\CountriesController',
        'tags'                    => 'Api\V1\TagsController',
        'searches'                => 'Api\V1\SearchesController',
        'businesses'              => 'Api\V1\BusinessesController',
        'business-stands'         => 'Api\V1\BusinessStandsController',
        'stand-posts'             => 'Api\V1\StandPostsController',
        'book-notifications'      => 'Api\V1\BookNotificationsController',
        'post-boosts'             => 'Api\V1\PostBoostsController',
        'textbook-views'          => 'Api\V1\TextbookViewsController',
        'textbook-price-averages' => 'TextbookPriceAveragesController',
    ]);
});
