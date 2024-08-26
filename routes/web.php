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

Auth::routes();

Route::group(['middleware' => ['auth','usertype:master|employee','term']], function(){

 Route::get('/', 'DashboardController')->name('home');

 Route::get('/settings', 'Setting\SettingController')->name('settings');
 Route::get('/settings/terms', 'TermController@index')->name('settings.terms');
 Route::post('/settings/terms/store', 'TermController@store')->name('settings.terms.store');
 Route::get('/settings/terms/{id}', 'TermController@show')->name('settings.terms.show');
 Route::post('/settings/terms/update/{id}', 'TermController@update')->name('settings.terms.update');

 Route::get('/settings/classes', 'ClazzController@index')->name('settings.clazzs');
 Route::post('/settings/classes/store', 'ClazzController@store')->name('settings.clazzs.store');
 Route::post('/settings/classes/update/{id}', 'ClazzController@update')->name('settings.clazzs.update');
 Route::get('/settings/classes/destroy/{id}', 'ClazzController@destroy')->name('settings.clazzs.destroy');
 Route::get('/settings/classes/edit/{id}', 'ClazzController@edit')->name('settings.clazzs.edit');

});


Route::group(['middleware' => ['auth','usertype:master|employee']], function(){
 Route::get('/init', 'Init\InitController')->name('init');
 Route::get('/init/set/periods', 'Init\SetTermController@index')->name('init.set.term');
 Route::post('/init/set/term', 'Init\SetTermController@store')->name('init.set.term.store');
 Route::post('/init/set/period', 'Init\SetTermController@storePeriod')->name('init.set.period.store');
});













