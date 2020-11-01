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

use Spatie\Permission\Models\Role;

Route::get('/', function () {
    return view('welcome');
    //mendaftarkan role pada user
    // auth()->user()->assignRole('user');
    //merubah role pada user
    // auth()->user()->syncRoles('user');
    //menghapus role pada user
    //auth()->user()->removeRole('admin');
    //cek role
    // if (auth()->user()->hasRole('admin')) {
    //     return 'Oke';
    // }
        // $user = auth()->user();

        //permission based on role
        // $role = Role::find(2);
        // $role->givePermissionTo(['view post']);


        //direct permission
        //memberikan permisson ke user
        // $user->givePermissionTo(['edit post','delete post']);
        //hapus permisson dari user
        // $user->revokePermissionTo(['edit post','delete post']);
        //replace permission yang ada dengan yang baru
        // $user->syncPermissions(['edit post','delete post']);

        // dd($user->can('edit post'));
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::group(['prefix' => 'dashboard'], function () {

    //cek berdasarkan role
    Route::group(['middleware' => ['role:admin']], function () {
        Route::resource('admin', 'AdminController');
        Route::get('post/create','PostController@create')->name('post.create');
    });

    //cek berdasarkan permission
    Route::group(['middleware' => ['permission:view post']], function () {
        Route::get('post','PostController@index')->name('post.index');
    });
    
});