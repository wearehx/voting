<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::group(['middleware' => 'auth'], function () {
    Route::get('/', function () {
        return view('home');
    });

    Route::post('/', function () {
        return redirect()->secure('/');
    });

    Route::get('logout', function () {
        Auth::logout();
    });

    Route::get('vote', ['middleware' => 'nominate_or_vote', 'uses' => 'VoteController@create']);
    Route::post('vote', ['middleware' => 'vote', 'uses' => 'VoteController@store']);

    Route::get('nominate', ['middleware' => 'nominate', 'uses' => 'NominationController@create']);
    Route::post('nominate', ['middleware' => 'nominate', 'uses' => 'NominationController@store']);

    Route::get('candidacy', ['middleware' => 'be_nominated', 'uses' => 'CandidacyController@create']);
    Route::post('candidacy', ['middleware' => ['be_nominated', 'run'], 'uses' => 'CandidacyController@store']);
});

Route::get('webhook/user', function (Illuminate\Http\Request $request) {
    if (!hash_equals(Config::get('services.facebook.verify_token'), $request->get('hub_verify_token'))) {
        abort(403);
    }

    return e($request->get('hub_challenge'));
});

Route::post('webhook/user', function (Illuminate\Http\Request $request) {
    if (!hash_equals(substr($request->header('X-Hub-Signature'), 5), hash_hmac('sha1', $request->getContent(), Config::get('services.facebook.client_secret')))) {
        abort(403);
    }

    foreach ($request->json('entry') as $entry) {
        dispatch(new App\Jobs\UpdateUser($entry['uid'], $entry['changed_fields']));
    }
});

Route::get('auth/facebook', 'Auth\AuthController@getFacebookSocialAuth');
Route::get('auth/facebook/callback', 'Auth\AuthController@getSocialAuthCallback');

Route::controller('data', 'DataController');

Route::get('legal/pp', function () {
    return view('legal.pp');
});
