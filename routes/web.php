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
Route::post('/auth','LoginController@authenticate')->name('login.auth');
Route::get('/logout','LoginController@logout')->name('login.logout');

Route::middleware('guest')->group(function(){
	Route::get('/', 'LoginController@loginForm')->name('login.form');

});


Route::middleware('auth:admin')->group(function(){
	//dashboard
	Route::get('/dashboard','DashboardController@index')->name('admin.dashboard');	

	//Music Genres
	Route::prefix('music')->group(function(){
		Route::get('/categories','MusicGenresController@index')->name('musicgenres.index');
		Route::get('/create','MusicGenresController@create')->name('musicgenres.create');
		Route::post('/store','MusicGenresController@store')->name('musicgenres.store');
		Route::get('/edit/{id?}','MusicGenresController@edit')->name('musicgenres.edit');
		Route::put('/update/{id}','MusicGenresController@update')->name('musicgenres.update');
		Route::delete('/delete/{id}','MusicGenresController@destroy')->name('musicgenres.delete');
	});
	// Songs to genres
	Route::prefix('songs')->group(function(){
		Route::get('/list/{id?}','SongsController@index')->name('songs.index');
		Route::get('/add/{id?}','SongsController@addsongs')->name('songs.add');
		Route::post('/store','SongsController@store')->name('songs.store');
		Route::get('/edit/{id}','SongsController@edit')->name('songs.edit');
		Route::put('/update/{id}','SongsController@update')->name('songs.update');
		Route::delete('/delete/{id}','SongsController@destroy')->name('songs.delete');
	});

	//Latin Singles
	Route::prefix('hitsingles')->group(function(){
		Route::get('/','LatinSinglesController@index')->name('latin.index');
		Route::get('/add','LatinSinglesController@add')->name('latin.add');
		Route::post('/store','LatinSinglesController@store')->name('latin.store');
		Route::get('/edit/{id}','LatinSinglesController@edit')->name('latin.edit');
		Route::put('/update/{id}','LatinSinglesController@update')->name('latin.update');
		Route::delete('/delete/{id}','LatinSinglesController@destroy')->name('latin.delete');
	});

	//English Singles
	Route::prefix('djs')->group(function(){
		Route::get('/','EnglishSinglesController@index')->name('english.index');
		Route::get('/add','EnglishSinglesController@add')->name('english.add');
		Route::post('/store','EnglishSinglesController@store')->name('english.store');
		Route::get('/edit/{id}','EnglishSinglesController@edit')->name('english.edit');
		Route::put('/update/{id}','EnglishSinglesController@update')->name('english.update');
		Route::delete('/delete/{id}','EnglishSinglesController@destroy')->name('english.delete');
		Route::get('/djs','EnglishSinglesController@listdjs')->name('english.dj.main');
		Route::get('/djs/add','EnglishSinglesController@addnewdj')->name('english.dj.add');
		Route::post('/djs/savedj','EnglishSinglesController@savedj')->name('english.dj.store');
		Route::get('/djs/edit/{id}','EnglishSinglesController@editdj')->name('english.dj.edit');
		Route::put('/djs/update/{id}','EnglishSinglesController@updatedj')->name('english.dj.update');
		Route::delete('/djs/delete/{id}','EnglishSinglesController@removedj')->name('english.dj.delete');
	});

	//Albums
	Route::prefix('artist')->group(function(){
		Route::get('/','AlbumsController@index')->name('albums.index');
		Route::get('/add','AlbumsController@add')->name('albums.add');
		Route::post('/store','AlbumsController@store')->name('albums.store');
		Route::get('/edit/{id}','AlbumsController@edit')->name('albums.edit');
		Route::put('/update/{id}','AlbumsController@update')->name('albums.update');
		Route::delete('/delete/{id}','AlbumsController@destroy')->name('albums.delete');
    });
    
    Route::prefix('products')->group(function(){
		Route::get('/','ProductsController@index')->name('djproducts.index');
		Route::get('/add','ProductsController@add')->name('djproducts.add');
		Route::post('/store','ProductsController@store')->name('djproducts.store');
		Route::get('/edit/{id}','ProductsController@edit')->name('djproducts.edit');
		Route::put('/update/{id}','ProductsController@update')->name('djproducts.update');
		Route::delete('/delete/{id}','ProductsController@destroy')->name('djproducts.delete');
	});

	//Featured Artists
	Route::prefix('artists')->group(function(){
		Route::get('/','FeaturedArtistController@index')->name('artists.index');
		Route::get('/add','FeaturedArtistController@add')->name('artists.add');
		Route::post('/store','FeaturedArtistController@store')->name('artists.store');
		Route::get('/edit/{id}','FeaturedArtistController@edit')->name('artists.edit');
		Route::put('/update/{id}','FeaturedArtistController@update')->name('artists.update');
		Route::delete('/delete/{id}','FeaturedArtistController@destroy')->name('artists.delete');
	});

	//Events 
	Route::prefix('events')->group(function(){
		Route::get('/','EventsController@index')->name('events.index');
		Route::get('/add','EventsController@add')->name('events.add');
		Route::post('/store','EventsController@store')->name('events.store');
		Route::get('/edit/{id}','EventsController@edit')->name('events.edit');
		Route::put('/update/{id}','EventsController@update')->name('events.update');
		Route::delete('/delete/{id}','EventsController@destroy')->name('events.delete');
	});

	//Images Folder
	Route::prefix('images')->group(function(){
		Route::get('/','ImagesController@index')->name('images.index');
		Route::get('/add','ImagesController@add')->name('images.add');
		Route::post('/store','ImagesController@store')->name('images.store');
		Route::get('/edit/{id}','ImagesController@edit')->name('images.edit');
		Route::put('/update/{id}','ImagesController@update')->name('images.update');
		Route::delete('/delete/{id}','ImagesController@destroy')->name('images.delete');
	});

	//Gallery
	Route::prefix('gallery')->group(function(){
		Route::get('/','GallerysController@index')->name('gallerys.index');
		Route::get('/add','GallerysController@add')->name('gallerys.add');
		Route::post('/store','GallerysController@store')->name('gallerys.store');
		// Route::get('/edit/{id}','GallerysController@edit')->name('gallerys.edit');
		// Route::put('/update/{id}','GallerysController@update')->name('gallerys.update');
		Route::delete('/delete/{id}','GallerysController@destroy')->name('gallerys.delete');
	});

	//Videos
	Route::prefix('videos')->group(function(){
		Route::get('/','VideosController@index')->name('videos.index');
		Route::get('/add','VideosController@add')->name('videos.add');
		Route::post('/store','VideosController@store')->name('videos.store');
		Route::get('/edit/{id}','VideosController@edit')->name('videos.edit');
		Route::put('/update/{id}','VideosController@update')->name('videos.update');
		Route::delete('/delete/{id}','VideosController@destroy')->name('videos.delete');
	});
	//video of the day
	Route::prefix('videos-of-the-day')->group(function(){
		Route::get('/','Video_of_day@index')->name('videos-of-the-day.index');
		Route::get('/add','Video_of_day@add')->name('videos-of-the-day.add');
		Route::post('/store','Video_of_day@store')->name('videos-of-the-day.store');
		Route::get('/edit/{id}','Video_of_day@edit')->name('videos-of-the-day.edit');
		Route::put('/update/{id}','Video_of_day@update')->name('videos-of-the-day.update');
		Route::delete('/delete/{id}','Video_of_day@destroy')->name('videos-of-the-day.delete');
	});
	//audio of the day
	Route::prefix('audio-of-the-day')->group(function(){
		Route::get('/','Audio_of_day@index')->name('audio-of-the-day.index');
		Route::get('/add','Audio_of_day@add')->name('audio-of-the-day.add');
		Route::post('/store','Audio_of_day@store')->name('audio-of-the-day.store');
		Route::get('/edit/{id}','Audio_of_day@edit')->name('audio-of-the-day.edit');
		Route::put('/update/{id}','Audio_of_day@update')->name('audio-of-the-day.update');
		Route::delete('/delete/{id}','Audio_of_day@destroy')->name('audio-of-the-day.delete');
	});
	//audio of the day
	Route::prefix('slider')->group(function(){
		Route::get('/','SLider_images@index')->name('slider.index');
		Route::get('/add','SLider_images@add')->name('slider.add');
		Route::post('/store','SLider_images@store')->name('slider.store');
		Route::get('/edit/{id}','SLider_images@edit')->name('slider.edit');
		Route::put('/update/{id}','SLider_images@update')->name('slider.update');
		Route::delete('/delete/{id}','SLider_images@destroy')->name('slider.delete');
	});

	//VIP LIST
	Route::prefix('vip')->group(function(){
		Route::get('/','VipsController@index')->name('vips.index');		
	});

	//Booking Details
	Route::prefix('booking')->group(function(){
		Route::get('/','BookingsController@index')->name('bookings.index');
	});

	//Social Links
	Route::prefix('socials')->group(function(){
		Route::get('/','SocialsController@index')->name('socials.index');
		Route::get('/edit/{id}','SocialsController@edit')->name('socials.edit');
		Route::put('/update/{id}','SocialsController@update')->name('socials.update');
	});

	Route::prefix('artists_bio')->group(function(){
		Route::get('/','ArtistBioController@listArtists')->name('artists_bio.main');
		Route::get('/add','ArtistBioController@addBio')->name('artists_bio.add');
		Route::post('/store','ArtistBioController@saveBio')->name('artists_bio.store');
		Route::get('/edit/{id}','ArtistBioController@editBio')->name('artists_bio.edit');
		Route::put('/update/{id}','ArtistBioController@updateBio')->name('artists_bio.update');
		Route::delete('/delete/{id}','ArtistBioController@deleteBio')->name('artists_bio.delete');
	});

	//Global Notifications
	Route::prefix('notifications')->group(function(){
		Route::get('/','NotificationsController@index')->name('notifications.index');
		Route::get('/send','NotificationsController@send')->name('notifications.send');
		Route::post('/store','NotificationsController@store')->name('notifications.store');
		Route::delete('/delete/{id}','NotificationsController@destroy')->name('notifications.delete');

	});
	
	//App Download Links or Share
	Route::prefix('share')->group(function(){
		Route::get('/','AppLinksController@index')->name('shares.index');	
		Route::put('/update/{id}','AppLinksController@update')->name('shares.update');
	});

	//OnAir Links
	Route::prefix('onair')->group(function(){
		Route::get('/','OnAirController@index')->name('onair.index');
		Route::put('/update/{id}','OnAirController@update')->name('onair.update');
	});

	//Biography 
	Route::prefix('biography')->group(function(){
		Route::get('/','BiographyController@index')->name('bio.index');
		Route::put('/update/{id}','BiographyController@update')->name('bio.update');
	});

	//Customer Care
	Route::get('/customer', function(){
		return view('customers.support');
	})->name('customers.index');

});


