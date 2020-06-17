<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@index');

Auth::routes();

Route::get('/profile', 'UserController@index')->name('profile');


Route::resource('/cinema', 'CinemaController');

Route::resource('/film', 'FilmController');

Route::resource('/session', 'SessionController');

Route::resource('/cinema/{cinema}/hall', 'HallController');

Route::resource('/place', 'PlaceController')->except('show', 'edit', 'update');


Route::post('/option/store', 'OptionController@store');

Route::get('/option/get', 'OptionController@get');

Route::get('/address/get-countries', 'AddressController@getCountries')->name('get-countries');

Route::get('/address/get-cities/', 'AddressController@getCities')->name('get-cities');

Route::get('/get-cinemas', 'CinemaController@getCinemas');

Route::post('/film/set-films-to-halls', 'FilmController@setFilmsToHalls');

Route::get('/film/get-films/{hall}', 'FilmController@getFilms');

Route::get('/film/get-film/{name}/{year}', 'FilmController@getFilm');

Route::get('/test/test', function () {
    $timeArr = ["9:00", "12:50", "16:40", "20:30", "24:20"];

    $startDate = new \DateTime('2020-05-25');
    $endDate = new \DateTime('2020-06-14');
    $interval = $startDate->diff($endDate);

    for ($i = 0; $i < $interval->d; $i++)
    {
        $date = $startDate->add(new DateInterval('P' . 1 . 'D'));
        for ($j = 0; $j < count($timeArr); $j++)
        {
            $session = new App\Session();
            $session->date = $date;
            $session->time = $timeArr[$j];
            $session->hall_id = 12;
            $session->film_id = 54;
            $session->save();
        }
    }
    return 'ok';

    //
});

Route::get('/test', 'SessionController@test');
