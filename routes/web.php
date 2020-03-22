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
Route::group(['prefix'=>'admin','namespace'=>'Admin','middleware'=>'admin'],function(){
		Route::get('image-gallery','GalleryController@index')->name('gallery');
		Route::get('import-image-gallery','GalleryController@gallery_import_view')->name('gallery_import');
		Route::post('import-image-gallery','GalleryController@gallery_import')->name('gallery_import');
	});

Route::get('admin/login.html','Admin\AdminController@login')->name('login');
Route::post('admin/login.html','Admin\AdminController@post_login')->name('login');

Route::get('image-gallery/{title}','GalleryController@viewImageGallery')->name('viewImageGallery');
