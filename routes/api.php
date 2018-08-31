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

//All songs.
Route::post('/all_songs','api\SongsController@all_songs');

// Register new user
Route::post('/add_user','api\NewUsersController@add_user');

//Get like dislike
Route::post('/addlike','api\LikesController@addlike');

//Genres
Route::get('/genres','api\GenresController@getGenres');
Route::post('/genresongs','api\GenresController@getSongs');

//DJ Mixes
Route::post('/djmixes','api\LatinsController@list');

//Djs
Route::get('/djs','api\FeaturedDjsController@listDjs');
Route::post('/djs/songs','api\FeaturedDjsController@songsbydjs');

//Artist
Route::post('/english','api\EnglishsController@list');
Route::get('/artists','api\EnglishsController@albums');
Route::post('/artists/songs','api\EnglishsController@album_songs');

//Share
Route::get('/share','api\CommentsController@sharelinks');

Route::post('/playlist/new','api\PlaylistsController@add');
Route::post('/playlist/user','api\PlaylistsController@user');
Route::post('/playlist/add','api\PlaylistsController@addSongToPlaylist');
Route::post('/playlist/getsongs','api\PlaylistsController@getSongs');
Route::post('/playlist/remove','api\PlaylistsController@removeSong');
Route::post('/playlist/removePlaylist','api\PlaylistsController@removePlaylist');


Route::post('/favs/add','api\FavsController@add');
Route::post('/favs/getsongs','api\FavsController@getSongs');
Route::post('/favs/remove','api\FavsController@removeSong');
Route::get('/events','api\EventsController@index');
//Images and gallery and videos merged into evnetscontroller
Route::get('/folders','api\EventsController@folders');
Route::get('/videos','api\EventsController@videos');

Route::post('signup','api\EventsController@vip_signup');

Route::get('/social_links','api\EnglishsController@social');


Route::post('/comments','api\CommentsController@list');
Route::post('/comments/add','api\CommentsController@addComment');

//biography added in comments controller
Route::get('/biography','api\CommentsController@bio');
Route::get('/onair','api\CommentsController@onAir');

Route::post('/booking','api\CommentsController@booking');

Route::get('/notifications','api\CommentsController@notifications');
Route::get('/sliderimages','api\SliderController@index');

//Artist Biographies added for individual artists
Route::get('/biographies','api\ArtistBioController@getAll');
Route::post('/biography','api\ArtistBioController@getSingleBiography');

// DJ PRODUCTS
Route::get('/djproducts','api\ProductsController@getProducts');

// GALLERY IMAGES
Route::get('/gallery','api\EventsController@images');

