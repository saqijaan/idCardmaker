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
    return view('frontend.index');
});

Auth::routes();

Route::group(['prefix' => 'user','namespace'=>'User','middleware'=>['auth']], function () {

    Route::get('/home', 'EmployeController@index')->name('user.home');

    Route::resource('employe',          'EmployeController');
    Route::post('/employe/{id}/image/save', 'EmployeController@saveImage')->name('image.save');

    Route::get('employe/csv/upload',   'EmployeController@upload')->name('employe.upload');
    Route::post('employe/csv',   'EmployeController@storeCsv')->name('employe.csv.store');
    Route::get('employe/export/csv',   'EmployeController@export')->name('employe.export');

    Route::get('/employe/generate/ids', 'EmployeController@generateCards')->name('ids.generate');

    Route::get('/employe/id/{employeId}/view', 'EmployeController@generateCard')->name('id.generate');
});

Route::get('/images/{userId}/{filename}', function($userid,$filename){

    return response()->download(storage_path('app/'.$userid).'/'.$filename, $filename, [],'inline');

})->name('image.get');
