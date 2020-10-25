<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'WelcomeController@welcome')->name('welcome');
Route::get('about-us', 'ContactUSController@aboutUs')->name('aboutus');
Route::get('contact-us', 'ContactUSController@contactUS')->name('contactus');
Route::post('contact-us', ['as'=>'contactus.store','uses'=>'ContactUSController@contactSaveData']);
Route::get('explore', 'ExploreController@index')->name('explore');
Route::get('{user}/photos/{category}{hash}', 'ExploreController@imgDetail')->name('image.detail');

//    search images
Route::get('/images/search', 'WelcomeController@search')->name('images.search.index');

Route::group(['prefix' => 'administrator', 'middleware' => ['auth:web', 'checkAdmin']], function () {
//    get main page
    Route::get('/', 'Backend\Admin\AdminController@index');

//    contact us
        Route::get('/contact-us', 'Backend\Admin\MainController@contactUs')->name('admin.contactus');
    Route::delete('/contact-us/destroy/{id}', 'Backend\Admin\MainController@contactUsDestroy')->name('admin.contactUs.destroy');

    //    answer the users tickets
    Route::get('/ticket/answer', 'Backend\Admin\TicketController@answer')->name('admin.tickets.answer');
    Route::get('/ticket/response/{rnd_code}', 'Backend\Admin\TicketController@response')->name('admin.tickets.response');
    Route::post('/ticket/response/send', 'Backend\Admin\TicketController@sendResponse')->name('admin.tickets.sendResponse');

//    manage users
    Route::get('/users/status/{id}/{status}', 'Backend\Admin\UserController@changeStatus')->name('admin.users.status');
    Route::get('/users', 'Backend\Admin\UserController@usersIndex')->name('admin.users.list');
    Route::get('/users/{id}/edit', 'Backend\Admin\UserController@edit')->name('admin.users.edit');
    Route::delete('/users/destroy/{id}', 'Backend\Admin\UserController@usersDestroy')->name('admin.users.destroy');
    Route::patch('/users/upload/{id}', 'Backend\Admin\UserController@update')->name('admin.users.update');
//    Route::get('/users/create/wallet/{id}', 'Backend\Admin\UserController@usersWalletCreate')->name('admin.users.wallet.create');
//    Route::get('/users/wallet/details/{id}', 'Backend\Admin\UserController@walletDetails')->name('admin.user.wallet.details');

//    manage photos
    Route::get('/photo/status/{id}/{status}', 'Backend\Admin\PhotoController@changeStatus')->name('admin.photo.status');
    Route::get('/photo', 'Backend\Admin\PhotoController@index')->name('admin.photo.list');
//    Route::delete('/photo/destroy/{id}', 'Backend\Admin\UserController@usersDestroy')->name('admin.photo.destroy');
//    Route::get('/users/create/photo/{id}', 'Backend\Admin\UserController@usersWalletCreate')->name('admin.users.photo.create');
//    Route::get('/users/photo/details/{id}', 'Backend\Admin\UserController@walletDetails')->name('admin.user.photo.details');

//    manage category
    Route::resource('/category', 'Backend\Admin\CategoryController', [
        'names' => [
            'index' => 'admin.category.index',
            'show' => 'admin.category.show',
            'edit' => 'admin.category.edit',
            'create' => 'admin.category.create',
            'update' => 'admin.category.update',
            'destroy' => 'admin.category.destroy',
            'store' => 'admin.category.store',
        ]
    ]);
//about us setting
    Route::get('about-us', ['as'=>'admin.aboutus.create','uses'=>'Backend\Admin\MainController@aboutUsCreate']);
    Route::post('about-us', ['as'=>'admin.aboutus.store','uses'=>'Backend\Admin\MainController@aboutUsStore']);


});

//rating
Route::post('/rate/add', 'PhotoController@rate')->name('rate.add');

//comment
Route::post('/comment/add', 'PhotoController@comment')->name('comment.add');

//image view
Route::get('{username}/photos/{categoryId}/{p_hash}', 'PhotoController@view')->name('photo.view');
Route::get('{username}/photo/{p_hash}', 'PhotoController@preview')->name('user.photo.preview');

// copy right
Route::get('/photo/copyright', 'PhotoController@copyRightIndex')->name('user.copyright.index');
Route::post('/photo/copyright/search', 'PhotoController@copyRightSearch')->name('user.copyright.search');

Route::group(['prefix' => 'account', 'middleware' => ['auth:web', 'checkUser']], function () {
    //    get main page
    Route::get('/', 'Backend\User\UserController@index')->name('user.profile');
    //    manage photo
    Route::delete('/photo/destroy/{id}', 'Backend\User\PhotoController@destroy')->name('user.photo.destroy');

// save information
    Route::get('/my_information', 'Backend\User\UserController@showInfo')->name('user.showInfo');
    Route::get('/security', 'Backend\User\UserController@showSecurity')->name('user.showSecurity');
    Route::post('/save-setting', 'Backend\User\UserController@saveSetting')->name('user.saveSetting');
    Route::post('/save-info', 'Backend\User\UserController@saveInfo')->name('user.saveInfo');
    //    wallet section
    Route::get('/wallet/charge', 'Backend\User\WalletController@charge')->name('user.wallet.charge');
    Route::post('/wallet/charge-it', 'Backend\User\WalletController@charge_it')->name('user.wallet.charge-it');
    Route::resource('wallet', 'Backend\User\WalletController', [
        'names' => [
            'index' => 'user.wallet.index',
            'show' => 'user.wallet.show',
            'edit' => 'user.wallet.edit',
            'create' => 'user.wallet.create',
            'update' => 'user.wallet.update',
            'destroy' => 'user.wallet.destroy',
            'store' => 'user.wallet.store',

        ]
    ]);

//social network
  /*  Route::get('/social/index', 'Backend\User\SocialNetworkController@socialNetwork')->name('user.social');
    Route::get('/social/add', 'Backend\User\SocialNetworkController@socialAdd')->name('user.social.add');
    Route::post('/social/store', 'Backend\User\SocialNetworkController@socialStore')->name('user.social.store');
    Route::delete('/social/destroy/{$id}', 'Backend\User\SocialNetworkController@destroy')->name('user.social.delete');*/


//    for ticket
    Route::get('/support/create', 'Backend\User\TicketController@create')->name('user.ticket.create');
    Route::post('/support/sendResponse/', 'Backend\User\TicketController@sendResponse')->name('user.ticket.sendResponse');
    Route::post('/support/store/', 'Backend\User\TicketController@store')->name('user.ticket.store');
    Route::get('/support', 'Backend\User\TicketController@index')->name('user.ticket');
    Route::get('/support/{id}', 'Backend\User\TicketController@show')->name('user.ticket.show');
    Route::post('/support/{id}/response', 'Backend\User\TicketController@response')->name('user.ticket.response');
//    for uploads photo
    Route::resource('/photo/upload','Backend\User\UploadController');
});



//Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
//    \UniSharp\LaravelFilemanager\Lfm::routes();
//});

//for login and register
//Route::get('/login/{social}','Auth\LoginController@socialLogin')->where('social','twitter|facebook|linkedin|google|github|bitbucket');
//Route::get('/login/{social}/callback','Auth\LoginController@handleProviderCallback')->where('social','twitter|facebook|linkedin|google|github|bitbucket');
Route::get('/logout', 'Auth\LoginController@logout');
Route::get('auth/redirect/{provider}', 'SocialController@redirect');
Route::get('callback/{provider}', 'SocialController@callback');
Auth::routes(['verify' => true]);
Route::get('/verify', 'Auth\RegisterController@verifyUser')->name('verify.user');

Route::group(['middleware' => ['auth']], function() {

    Route::resource('roles','RoleController');

//    Route::resource('users','UserController');

});

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/username', 'HomeController@username')->name('username');

Route::get('/{username}', 'WelcomeController@account')->name('welcomeaccount');
Route::post('image/get', 'PhotoController@get')->name('getimage');

