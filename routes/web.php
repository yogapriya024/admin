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

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes(['register' => false]);

Route::get('partners/unsubscribe/{id}', 'PartnerController@updateBlock')->name('partners.unsubscribe');

Route::middleware(['auth'])->group(function () {

    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('users', 'UserController@index')->name('user.index');
    Route::post('getUser', 'UserController@getUser')->name('getUser');
    Route::post('users/store', 'UserController@store')->name('user.store');
    Route::delete('users/destroy/{id}', 'UserController@destroy')->name('user.destroy');

    Route::get('settings/category', 'CategoryController@index')->name('category.index');
    Route::post('getCategory', 'CategoryController@getCategory')->name('getCategory');
    Route::post('category/store', 'CategoryController@store')->name('category.store');
   // Route::delete('category/destroy/{id}', 'CategoryController@destroy')->name('category.destroy');

    Route::get('settings/tags', 'TagController@index')->name('tags.index');
    Route::post('getTag', 'TagController@getTag')->name('getTag');
    Route::post('tags/store', 'TagController@store')->name('tags.store');
    //Route::delete('tags/destroy/{id}', 'TagController@destroy')->name('tags.destroy');

    Route::get('settings/country', 'CountryController@index')->name('country.index');
    Route::post('getCountry', 'CountryController@getCountry')->name('getCountry');
    Route::post('country/store', 'CountryController@store')->name('country.store');

    Route::get('settings/city', 'CityController@index')->name('city.index');
    Route::post('getCity', 'CityController@getCity')->name('getCity');
    Route::post('city/store', 'CityController@store')->name('city.store');

    Route::get('leads', 'LeadController@index')->name('leads.index');
    Route::post('getLead', 'LeadController@getLead')->name('getLead');
    Route::post('lead/store', 'LeadController@store')->name('leads.store');
    Route::delete('lead/destroy/{id}', 'LeadController@destroy')->name('lead.destroy');
    Route::delete('lead/archive/{id}', 'LeadController@archive')->name('lead.archive');

    Route::get('partners', 'PartnerController@index')->name('partners.index');

    Route::post('getPartner', 'PartnerController@getPartner')->name('getPartner');
    Route::post('partner/store', 'PartnerController@store')->name('partners.store');
    Route::delete('partner/destroy/{id}', 'PartnerController@destroy')->name('partner.destroy');

    Route::get('save_contact/{id}', 'LeadController@saveContact')->name('saveContact');

    Route::get('lead_communication', 'LeadCommunicationController@index')->name('communication.index');
    Route::get('email_sent', 'LeadCommunicationController@emailSent')->name('emailSent.index');
    Route::get('introduce', 'LeadCommunicationController@introduce')->name('introduce.index');
    Route::post('getCommunication/{status?}', 'LeadCommunicationController@getCommunication')->name('getCommunication');
    Route::post('communication_email', 'LeadCommunicationController@sentEmail')->name('communication.email');
    Route::get('introduce_email/{id}', 'LeadCommunicationController@introduceEmail')->name('introduce.email');
    Route::get('convert/{id}', 'ProjectsController@convert')->name('convert');

    Route::get('projects', 'ProjectsController@index')->name('projects');
    Route::post('getProjects', 'ProjectsController@getProjects')->name('getProjects');
    Route::post('projects/update', 'ProjectsController@update')->name('projects.update');

    Route::get('vendors', 'VendorController@index')->name('vendor');
    Route::get('vendors/getEmail', 'VendorController@extractEmail')->name('vendor.getEmail');
    Route::post('vendors', 'VendorController@index');
    Route::post('vendors/mail', 'VendorController@sendMail')->name('vendor.mail');

    Route::get('/truncate/{table}', function ($table) {
        DB::table($table)->truncate();
    });

    Route::get('customer_request', 'CustomerRequestController@index')->name('customerRequest');
    Route::post('getCustomerRequest', 'CustomerRequestController@getCustomerRequest')->name('getCustomerRequest');
    Route::post('customer_request/store', 'CustomerRequestController@store')->name('customerRequest.store');
    Route::delete('customer_request/destroy/{id}', 'CustomerRequestController@destroy')->name('customerRequest.destroy');
    Route::post('customer_request_email', 'CustomerRequestController@sentEmail')->name('customerRequest.email');

    Route::get('settings/progress', 'ProgressController@index')->name('progress.index');
    Route::post('getProgress', 'ProgressController@getProgress')->name('getProgress');
    Route::post('progress/store', 'ProgressController@store')->name('progress.store');
});


//Route::post('users/store', 'UserController@store')->name('user.store');
//Route::post('getUser', 'UserController@getUser')->name('getUser');
